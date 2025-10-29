// تحديث inputs hidden بناءً على الحالة
window.updateHiddenInputs = function (selectElement, selectedList) {
    const parent =
        selectElement.parentNode ||
        document.querySelector(`[data-for='${selectElement.id}']`) ||
        selectElement.closest(".multi-select-tag");
    if (!parent) return;

    // Normalize selectedIds to strings
    let selectedIds = [];
    if (!selectedList) selectedList = [];
    if (Array.isArray(selectedList)) {
        // could be array of ids or array of objects
        selectedIds = selectedList.map((item) =>
            typeof item === "object" ? String(item.id) : String(item),
        );
    }

    // Existing hidden inputs for this select (only the ones we manage)
    const existingInputs = Array.from(
        parent.querySelectorAll(
            `input[type="hidden"][name="${selectElement.name}"]`,
        ),
    );

    // Remove inputs that are no longer present
    existingInputs.forEach((input) => {
        if (!selectedIds.includes(String(input.value))) {
            input.remove();
        }
    });

    // Recompute existing values (after removals)
    const existingValues = Array.from(
        parent.querySelectorAll(
            `input[type="hidden"][name="${selectElement.name}"]`,
        ),
    ).map((i) => String(i.value));

    // Add missing inputs
    selectedIds.forEach((id) => {
        if (!existingValues.includes(String(id))) {
            const hidden = document.createElement("input");
            hidden.type = "hidden";
            hidden.name = `${selectElement.name}`; // should match e.g. region_id[] or state_id[]
            // try to attach a human readable name if provided in selectedList
            const found = (selectedList || []).find(
                (s) => String(typeof s === "object" ? s.id : s) === String(id),
            );
            hidden.dataset.name = found
                ? found.label || found.name || found.text || ""
                : "";
            hidden.value = id;
            parent.appendChild(hidden);
        }
    });
};

// تحديث حالة الاختيارات داخل <select>
window.updateSelectedOptions = function (selectElement, selectedList) {
    for (let i = 0; i < selectElement.options.length; i++) {
        const option = selectElement.options[i];
        option.selected = selectedList.some((x) => x.id == option.value);
    }
};

// إعادة رسم الـ dropdown (القائمة) بناءً على العناصر المتاحة وغير المختارة
window.renderOptions = function (selectElement, dropdown, selectedList) {
    if (!dropdown) return;
    dropdown.innerHTML = "";

    let added = 0;
    for (let i = 0; i < selectElement.options.length; i++) {
        const option = selectElement.options[i];
        if (!option || option.value === "") continue;
        if (!selectedList.find((x) => x.id == option.value)) {
            const li = document.createElement("li");
            li.className = "li";
            li.dataset.id = option.value;
            li.textContent = option.textContent;
            dropdown.appendChild(li);
            added++;
        }
    }

    if (added === 0) {
        const li = document.createElement("li");
        li.className = "li disabled-option";
        li.textContent =
            window.APP_LANG === "ar"
                ? "لا توجد خيارات"
                : "No options available";
        dropdown.appendChild(li);
    }
};

// azma تاج مع تحديث الـ state و UI
// state: { selectedList: [...] }
// selectElement: العنصر <select>
// dropdown: العنصر UL الخاص بالقائمة
// onAfterRemove: callback(tagId)
window.createTag = function (date) {
    const tag = document.createElement("span");
    tag.classList.add("tag-item");
    tag.textContent = date.name;
    tag.dataset.id = date.id;
    tag.dataset.name = date.name;
    tag.innerHTML = `${date.name} <span class="cross">×</span>`;
    return tag;
};

// Event delegation version - يتستدعى مرة واحدة فقط
window.removeTag = function (
    state,
    selectElement,
    dropdown,
    onAfterRemove = null,
) {
    const wrapper = document.querySelector(`[data-for="${selectElement.id}"]`);
    if (!wrapper) return;

    // ✅ استخدام event delegation - listener واحد على الـ wrapper
    // نتحقق لو الـ listener موجود من قبل
    if (wrapper.dataset.removeTagAttached === "true") return;

    wrapper.dataset.removeTagAttached = "true";

    wrapper.addEventListener("click", async (e) => {
        // تحقق إن الـ click على الـ cross
        if (!e.target.classList.contains("cross")) return;

        const tag = e.target.closest(".tag-item");
        if (!tag) return;

        const tagId = tag.dataset.id;
        const tagName = tag.dataset.name;
        tag.remove();

        const dropdown = wrapper.querySelector(".dropdown");
        if (dropdown) {
            // التاكد قبل إنشاء عنصر جديد انه ليس موجود داخل للـ dropdown
            const exists = Array.from(dropdown.children).find(
                (li) => li.dataset.id == tagId,
            );

            // التأكد من أن العنصر الجديد ليس داخل الـ dropdown
            if (!exists) {
                const newLi = document.createElement("li");
                newLi.classList.add("li");
                newLi.dataset.id = tagId;
                newLi.textContent = tagName;
                dropdown.appendChild(newLi);
            }

            // ⚡️ إعادة ترتيب العناصر فورًا حسب الابجدية
            const sortedLis = Array.from(dropdown.children).sort((a, b) =>
                a.textContent.trim().localeCompare(b.textContent.trim(), "ar", {
                    sensitivity: "base",
                }),
            );

            // 🧹 مسح القديم وإعادة إدخالهم بالترتيب
            dropdown.innerHTML = "";
            sortedLis.forEach((li) => dropdown.appendChild(li));
        }

        // ✅ تحديث state
        state.selectedList = state.selectedList.filter((i) => i.id != tagId);

        // 🧱 تحديث الـ hidden inputs والـ dropdown
        window.updateHiddenInputs(selectElement, state.selectedList);
        window.renderOptions(selectElement, dropdown, state.selectedList);

        // 🔔 dispatch event للتحديثات
        const event = new CustomEvent("multiSelectUpdated", {
            detail: { nameSelect: selectElement.name, tagId },
        });
        selectElement.dispatchEvent(event);

        if (typeof onAfterRemove === "function") onAfterRemove(tagId);
    });
};

// جلب القيم من inputs hidden وترسيم التاجز
window.setTagsFromHiddenInputs = function (selectId) {
    let parentIds = getHiddenInputValues(selectId);
    if (parentIds.length === 0) return;

    const wrapper = document.querySelector(
        `[data-for='${selectId}'] .tag-container`,
    );
    if (!wrapper) {
        console.error(`Tag container not found for ${selectId}`);
        return;
    }

    parentIds.forEach((item) => {
        if (document.querySelector(`.tag-item[data-id='${item.id}']`)) {
            return;
        }

        const tag = document.createElement("span");
        tag.classList.add("tag-item");
        tag.textContent = item.name || item.text || item.id; // fallback
        tag.dataset.id = item.id;
        tag.dataset.name = item.name || item.text || item.id;

        const cross = document.createElement("span");
        cross.classList.add("cross");
        cross.textContent = "×";
        tag.appendChild(cross);

        tag.querySelector(".cross").addEventListener("click", () => {
            tag.remove();
            resetDependentTags(
                selectId,
                document.querySelector(`[data-for='${selectId}'] .tag-input`),
            );

            let inputHidden = document.querySelector(
                `input[name="${selectId}[]"][type="hidden"][value="${tag.dataset.id}"]`,
            );
            if (inputHidden) inputHidden.remove();

            let tagId = item.id;
            const event = new CustomEvent("multiSelectUpdated", {
                detail: { name: item.name, tagId: tagId },
            });
            document.getElementById(selectId).dispatchEvent(event);
        });

        wrapper.prepend(tag);

        // initializing = false;
        window.renderOptions(refSelect, dropdown, state.selectedList);
        window.sortDropdown(dropdown);
    });
};

// ✅ ترتيب التاجز داخل الـ tag-container
window.sortSelectedList = function (state, tagContainer) {
    // const sorted = [...state.selectedList].sort((a, b) =>
    //     a.label.trim().localeCompare(b.label.trim(), "ar", {
    //         sensitivity: "base",
    //     }),
    // );

    const sorted = [...state.selectedList].sort((a, b) =>
        (a.label || "").trim().localeCompare((b.label || "").trim(), "ar", {
            sensitivity: "base",
        }),
    );

    state.selectedList = sorted;

    const tags = Array.from(tagContainer.querySelectorAll(".tag-item"));

    // tags.sort((a, b) =>
    //     a.dataset.name.trim().localeCompare(b.dataset.name.trim(), "ar", {
    //         sensitivity: "base",
    //     }),
    // );

    tags.sort((a, b) =>
        (a.dataset.name || "")
            .trim()
            .localeCompare((b.dataset.name || "").trim(), "ar", {
                sensitivity: "base",
            }),
    );

    tags.forEach((tag) =>
        tagContainer.insertBefore(
            tag,
            tagContainer.querySelector(".tag-input"),
        ),
    );
};

// ✅ ترتيب الـ dropdown ابجديًا
window.sortDropdown = function (dropdown) {
    const items = Array.from(dropdown.children);
    const enabledItems = items.filter(
        (li) => !li.classList.contains("disabled-option"),
    );

    enabledItems.sort((a, b) =>
        a.textContent.trim().localeCompare(b.textContent.trim(), "ar", {
            sensitivity: "base",
        }),
    );

    dropdown.innerHTML = "";
    enabledItems.forEach((li) => dropdown.appendChild(li));
};

// جلب القيم المختارة من inputs hidden
window.getSelectedIds = function (name) {
    return [...document.querySelectorAll(`input[name='${name}']`)]
        .map((input) => input.value)
        .filter((v) => v !== "");
};
