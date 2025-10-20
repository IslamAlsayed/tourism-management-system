// ======= Multi Select =======
window.specialSelect = function (selectElement) {
    if (!selectElement) return;

    const isRequired = selectElement.hasAttribute("required");
    selectElement.removeAttribute("required");

    selectElement.style.display = "none";
    selectElement.setAttribute("multiple", "multiple");

    const wrapper = document.createElement("div");
    wrapper.className = "multi-select-tag";
    wrapper.dataset.for = selectElement.id;
    selectElement.insertAdjacentElement("afterend", wrapper);

    wrapper.innerHTML = `
        <div class="wrapper">
            <div class="tag-container">
                <input type="search" class="tag-input" placeholder="Search" autocomplete="off">
            </div>
            <ul class="dropdown hidden"></ul>
        </div>
    `;

    const tagContainer = wrapper.querySelector(".tag-container");
    const tagInput = wrapper.querySelector(".tag-input");
    const dropdown = wrapper.querySelector(".dropdown");

    // ==========================
    // 1️⃣ جهّز selectedList
    // ==========================
    let selectedList = [];

    // ==========================
    // 2️⃣ تحديث hidden inputs
    // ==========================
    const updateHiddenInputs = () => {
        // احذف الموجود بس اللي داخل الـ parent مش أي input جاي من السيرفر
        selectElement.parentNode
            .querySelectorAll(
                `input[type="hidden"][name="${selectElement.name}[]"]`
            )
            .forEach((i) => i.remove());

        selectedList.forEach((item) => {
            if (
                document.querySelector(
                    `input[type="hidden"][value="${item.id}"]`
                )
            ) {
                return;
            }
            const hidden = document.createElement("input");
            hidden.type = "hidden";
            hidden.name = `${selectElement.name}`;
            hidden.dataset.name = item.label;
            hidden.value = item.id;
            selectElement.parentNode.appendChild(hidden);
        });
    };

    // ==========================
    // 3️⃣ تحديث الـ select نفسه
    // ==========================
    const updateSelectedOptions = () => {
        for (let i = 0; i < selectElement.options.length; i++) {
            const option = selectElement.options[i];
            option.selected = selectedList.some((x) => x.id == option.value);
        }
    };

    // ==========================
    // 4️⃣ عرض الخيارات في القائمة
    // ==========================
    const renderOptions = () => {
        dropdown.innerHTML = "";
        for (let i = 0; i < selectElement.length; i++) {
            const option = selectElement.options[i];
            if (option.value === "") continue;
            if (!selectedList.find((x) => x.id == option.value)) {
                const li = document.createElement("li");
                li.className = "li";
                li.dataset.id = option.value;
                li.textContent = option.textContent;
                dropdown.appendChild(li);
            }
        }
    };

    // ==========================
    // 5️⃣ أحداث الاختيار والإزالة
    // ==========================
    dropdown.addEventListener("click", (e) => {
        if (e.target.tagName !== "LI") return;

        const value = e.target.dataset.id;
        const text = e.target.textContent;

        if (!selectedList.find((x) => x.id == value)) {
            selectedList.push({ id: value, label: text });

            const tag = document.createElement("span");
            tag.className = "tag-item";
            tag.dataset.id = value;
            tag.dataset.name = text;
            tag.innerHTML = `${text}<span class="cross">&times;</span>`;

            let parentSelect = document.getElementById(
                selectElement.id
            ).parentElement;

            const hidden = document.createElement("input");
            hidden.type = "hidden";
            hidden.name = `${selectElement.name}`;
            hidden.dataset.name = text;
            hidden.value = value;
            parentSelect.appendChild(hidden);

            tag.querySelector(".cross").addEventListener("click", () => {
                tag.remove();
                selectedList = selectedList.filter((i) => i.id !== value);
                updateSelectedOptions();
                updateHiddenInputs();
                renderOptions();

                const event = new CustomEvent("multiSelectUpdated", {
                    detail: { nameSelect: selectElement.name },
                });
                selectElement.dispatchEvent(event);
            });

            tagContainer.insertBefore(tag, tagInput);
            updateSelectedOptions();
            updateHiddenInputs();
            renderOptions();

            // const selectedIds = selectedList.map((i) => i.id);
            // 🔥 أرسل الحدث "updatedSelect" بعد الاختيار
            const event = new CustomEvent("updatedSelect", {
                detail: {
                    nameSelect: selectElement.name,
                    selectedIds: selectedList.map((i) => i.id),
                },
            });
            selectElement.dispatchEvent(event);
        }

        tagInput.value = "";
        dropdown.classList.add("hidden");
    });

    tagInput.addEventListener("click", (e) => {
        closeAllDropdowns();
        dropdown.classList.remove("hidden");
        e.stopPropagation();
    });

    tagInput.addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        dropdown.querySelectorAll("li").forEach((li) => {
            li.style.display = li.textContent.toLowerCase().includes(filter)
                ? "block"
                : "none";
        });
    });

    tagInput.addEventListener("keydown", (e) => {
        if (e.key === "Backspace" && tagInput.value === "") {
            const lastTag = tagContainer.querySelectorAll(".tag-item");
            if (lastTag.length > 0) {
                lastTag[lastTag.length - 1].querySelector(".cross").click();
                const event = new CustomEvent("multiSelectUpdated", {
                    detail: { nameSelect: selectElement.name },
                });
                selectElement.dispatchEvent(event);
            }
        }
    });

    // ==========================
    // 6️⃣ التهيئة الأولية
    // ==========================
    renderOptions(); // ← يرسم القائمة
    updateSelectedOptions(); // ← يضبط الـ selected options
    updateHiddenInputs(); // ← يضمن أن الـ inputs متزامنة
};
