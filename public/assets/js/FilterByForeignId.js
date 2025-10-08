function FilterByForeignId(constrainId, reference, referenceId) {
    const constrainSelect = document.querySelector(
        `[data-for="${constrainId}"]`
    );
    const referenceSelect = document.querySelector(`#${referenceId}`);

    if (!constrainSelect || !referenceSelect) return;

    referenceSelect.parentElement.classList.add("loading");
    document.getElementById(`${referenceId}-loader`)?.classList.remove("show");
    document.getElementById(`${referenceId}-info`)?.classList.add("show");

    // 🔹 وظيفة واحدة فقط لمعالجة الاختيار
    async function handleSelection(e) {
        if (e.target.tagName !== "LI" || !constrainSelect.contains(e.target))
            return;

        const constrainValue = e.target.dataset.value;
        if (!constrainValue) return;

        // 💫 أضف حالة التحميل
        referenceSelect.parentElement.classList.add("loading");
        document.getElementById(`${referenceId}-loader`)?.classList.add("show");
        document
            .getElementById(`${referenceId}-info`)
            ?.classList.remove("show");

        try {
            // ✅ طلب البيانات
            const response = await fetch(
                `/dashboard/api/${reference}/${constrainId}/${constrainValue}`
            );

            if (!response.ok) throw new Error("Request failed");

            const data = await response.json();

            // ✅ تحديث الخيارات
            referenceSelect.innerHTML = '<option value="">--</option>';
            if (Array.isArray(data) && data.length > 0) {
                data.forEach((item) => {
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.textContent = item.name;
                    referenceSelect.appendChild(option);
                });
                referenceSelect.disabled = false;
            } else {
                referenceSelect.disabled = true;
            }

            // ✅ تحديث واجهة special-search
            const oldWrapper = document.querySelector(
                `[data-for="${referenceSelect.id}"]`
            );
            if (oldWrapper) oldWrapper.remove();
            window.SpecialSearch(referenceSelect);
        } catch (error) {
            console.error("Error loading data:", error);
        } finally {
            referenceSelect.parentElement.classList.remove("loading");
            document
                .getElementById(`${referenceId}-loader`)
                ?.classList.remove("show");
        }
    }

    // 🟢 أضف مستمع للكليك على عناصر الاختيار
    constrainSelect.addEventListener("click", handleSelection);

    // 🔹 في حالة المستخدم مسح الـ input
    const searchInput = constrainSelect.querySelector(".tag-input");
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            if (!this.value) {
                referenceSelect.innerHTML = '<option value="">--</option>';
                referenceSelect.disabled = true;
            }
        });
    }
}
