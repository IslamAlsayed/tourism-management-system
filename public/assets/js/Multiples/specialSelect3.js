// ========================================
// MULTI SELECT COMPONENT
// ========================================
window.specialSelect = function (selectElement, options = {}) {
    if (!selectElement) return;

    const { selectedData = [] } = options; // هنا بنستقبل الداتا القديمة

    // إعداد العنصر الأساسي
    const isRequired = selectElement.hasAttribute("required");
    selectElement.removeAttribute("required");
    selectElement.style.display = "none";
    selectElement.setAttribute("multiple", "multiple");

    // إنشاء الهيكل
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

    // DOM elements
    const tagContainer = wrapper.querySelector(".tag-container");
    const tagInput = wrapper.querySelector(".tag-input");
    const dropdown = wrapper.querySelector(".dropdown");

    // STATE
    const state = { selectedList: [] };

    // 🟩 لو في داتا مختارة مسبقًا (في وضع edit)
    if (selectedData.length) {
        state.selectedList = selectedData;

        selectedData.forEach((item) => {
            const tag = document.createElement("span");
            tag.className = "tag-item";
            tag.dataset.id = item.id;
            tag.dataset.name = item.name;
            tag.innerHTML = `${item.name}<span class="cross">&times;</span>`;
            tagContainer.insertBefore(tag, tagInput);
        });

        window.sortSelectedList(state, tagContainer);
        window.sortDropdown(dropdown);
    }

    // ===========================================================
    // ✅ EVENTS - Dropdown listener - يجب إضافته مرة واحدة فقط
    // ===========================================================
    // if (!dropdown.dataset.bound) {
    //     dropdown.dataset.bound = "true";

    //     dropdown.addEventListener("click", (e) => {
    //         const li = e.target.closest("li");
    //         if (!li || li.classList.contains("disabled-option")) return;

    //         const value = li.dataset.id;
    //         const text = li.textContent.trim();

    //         if (!state.selectedList.find((x) => x.id == value)) {
    //             // add to selectedList
    //             state.selectedList.push({ id: value, label: text });

    //             // create tag element
    //             const tag = document.createElement("span");
    //             tag.className = "tag-item";
    //             tag.dataset.id = value;
    //             tag.dataset.name = text;
    //             tag.innerHTML = `${text}<span class="cross">&times;</span>`;
    //             tagContainer.insertBefore(tag, tagInput);

    //             // update hidden inputs incrementally
    //             window.updateHiddenInputs(selectElement, state.selectedList);

    //             // remove this option from dropdown
    //             li.remove();
    //             window.sortDropdown(dropdown);

    //             // update select element options selection (if relevant)
    //             window.updateSelectedOptions(selectElement, state.selectedList);

    //             // sort tags visually
    //             window.sortSelectedList(state, tagContainer);

    //             // 🔔 dispatch event that multiSelect changed
    //             const event = new CustomEvent("multiSelectUpdated", {
    //                 detail: {
    //                     nameSelect: selectElement.name,
    //                     selectedIds: state.selectedList.map((i) => i.id),
    //                 },
    //             });
    //             selectElement.dispatchEvent(event);
    //         }

    //         tagInput.value = "";
    //         dropdown.classList.add("hidden");
    //     });
    // }

    dropdown.addEventListener("click", (e) => {
        if (e.target.tagName !== "LI") return;

        const value = e.target.dataset.id;
        const text = e.target.textContent;

        if (!state.selectedList.find((x) => x.id == value)) {
            state.selectedList.push({ id: value, label: text });

            const tag = document.createElement("span");
            tag.className = "tag-item";
            tag.dataset.id = value;
            tag.dataset.name = text;
            tag.innerHTML = `${text}<span class="cross">&times;</span>`;

            let parentSelect = document.getElementById(
                selectElement.id,
            ).parentElement;

            let tags = parentSelect.querySelectorAll(".tag-item");
            tags.forEach((tag) => {
                let hiddenInput = document.querySelector(
                    `input[type="hidden"][value="${tag.dataset.id}"]`,
                );
                if (hiddenInput) return;

                const hidden = document.createElement("input");
                hidden.type = "hidden";
                hidden.name = `${selectElement.name}`;
                hidden.dataset.name = tag.dataset.name;
                hidden.value = tag.dataset.id;
                parentSelect.appendChild(hidden);
            });

            tagContainer.insertBefore(tag, tagInput);

            window.sortSelectedList(state, tagContainer);
            window.sortDropdown(dropdown);

            window.renderOptions(selectElement, dropdown, state.selectedList);
            window.updateSelectedOptions(selectElement, state.selectedList);
            window.updateHiddenInputs(selectElement, state.selectedList);
            window.removeTag(state, selectElement);

            const event = new CustomEvent("updatedSelect", {
                detail: {
                    nameSelect: selectElement.name,
                    selectedIds: state.selectedList.map((i) => i.id),
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

        if (dropdown.children.length === 0) {
            const li = document.createElement("li");
            li.className = "li disabled-option";
            const noDataMessage =
                window.APP_LANG == "ar"
                    ? "لا توجد بيانات متاحة"
                    : "No options available";
            li.textContent = noDataMessage;

            dropdown.appendChild(li);
        }

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

    window.sortSelectedList(state, tagContainer);
    window.sortDropdown(dropdown);

    // INITIALIZATION
    window.renderOptions(selectElement, dropdown, state.selectedList);
    window.updateSelectedOptions(selectElement, state.selectedList);
    window.updateHiddenInputs(selectElement, state.selectedList);
    // ⚠️ removeTag هيتستدعى من filterByForeignId.js بعد ما نرجع الـ state
    // ⚠️ multiSelectUpdated listener هيتضاف من filterByForeignId.js قبل استدعاء specialSelect

    // ✅ إرجاع الـ state عشان نستخدمه برة
    return state;
};
