// ======= Multi Delete =======
window.SpecialDelete = function (selectAllId, rowCheckboxSelector) {
    const selectAll = document.getElementById(selectAllId);
    const checkboxes = document.querySelectorAll(rowCheckboxSelector);
    const deleteAllBtn = document.getElementById("deleteAllBtn");

    if (!selectAll || checkboxes.length === 0 || !deleteAllBtn) return;

    deleteAllBtn?.classList.add("hidden");

    // ✅ تحديد الكل
    if (selectAll) {
        selectAll.addEventListener("change", () => {
            checkboxes.forEach((cb) => (cb.checked = selectAll.checked));
            updateDeleteButtonVisibility(rowCheckboxSelector);
        });
    }

    // ✅ عند تحديد/إلغاء تحديد فردي
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            if (!checkbox.checked) {
                selectAll.checked = false;
            } else {
                const allChecked = Array.from(checkboxes).every(
                    (cb) => cb.checked
                );
                selectAll.checked = allChecked;
            }

            updateDeleteButtonVisibility(rowCheckboxSelector);
        });
    });

    // ✅ زر الحذف
    if (deleteAllBtn) {
        deleteAllBtn?.addEventListener("click", () => {
            const selected = document.querySelectorAll(
                `${rowCheckboxSelector}:checked`
            );
            if (selected.length == 0) {
                alert("Please select at least one item to delete.");
                return;
            }

            if (!confirm("Are you sure you want to delete selected items?"))
                return;

            const model = deleteAllBtn?.dataset.model;
            const route = deleteAllBtn?.dataset.route;
            if (!route) {
                console.error("Missing route in data-route attribute.");
                return;
            }

            const deleteForm = document.createElement("form");
            deleteForm.method = "POST";
            deleteForm.action = route;

            // CSRF
            const csrf = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content");
            const csrfInput = document.createElement("input");
            csrfInput.type = "hidden";
            csrfInput.name = "_token";
            csrfInput.value = csrf || "";
            deleteForm.appendChild(csrfInput);

            // method
            const methodInput = document.createElement("input");
            methodInput.type = "hidden";
            methodInput.name = "_method";
            methodInput.value = "DELETE";
            deleteForm.appendChild(methodInput);

            // model
            const modelInput = document.createElement("input");
            modelInput.type = "hidden";
            modelInput.name = "model";
            modelInput.value = model;
            deleteForm.appendChild(modelInput);

            // selected IDs
            selected.forEach((cb) => {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = cb.name;
                input.value = cb.value;
                deleteForm.appendChild(input);
            });

            document.body.appendChild(deleteForm);
            deleteForm.submit();
        });
    }

    function updateDeleteButtonVisibility(rowCheckboxSelector) {
        const selected = document.querySelectorAll(
            `${rowCheckboxSelector}:checked`
        );
        if (selected.length != 0) {
            deleteAllBtn?.classList.remove("hidden");
        } else {
            deleteAllBtn?.classList.add("hidden");
        }
    }
};
