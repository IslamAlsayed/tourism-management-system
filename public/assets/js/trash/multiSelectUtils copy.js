// ========================================
// GLOBAL HELPERS (PUBLIC FUNCTIONS)
// ========================================
// ========================================
// MULTI SELECT UTILITIES
// ========================================
window.updateHiddenInputs = function (selectElement, selectedList) {
    selectElement.parentNode
        .querySelectorAll(`input[type="hidden"][name="${selectElement.name}"]`)
        .forEach((i) => i.remove());

    selectedList.forEach((item) => {
        let hiddenInput = document.querySelector(
            `input[type="hidden"][value="${item.id}"]`,
        );
        if (hiddenInput) return;

        const hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = `${selectElement.name}`;
        hidden.dataset.name = item.label;
        hidden.value = item.id;
        selectElement.parentNode.appendChild(hidden);
    });
};

window.updateSelectedOptions = function (selectElement, selectedList) {
    for (let i = 0; i < selectElement.options.length; i++) {
        const option = selectElement.options[i];
        option.selected = selectedList.some((x) => x.id == option.value);
    }
};

window.renderOptions = function (selectElement, dropdown, selectedList) {
    if (!dropdown) return;

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

// 🧩 حذف تاج معين
// window.removeTag = function (
//     selectedList,
//     selectElement,
//     onAfterRemove = null,
// ) {
//     const tags = document.querySelectorAll(".cross");
//     tags.forEach((cross) => {
//         cross.addEventListener("click", () => {
//             console.log("remove tag");
//             const tag = cross.parentElement;
//             const tagId = tag.dataset.id;

//             tag.remove();

//             // تحديث القائمة
//             selectedList = selectedList.filter((i) => i.id != tagId);

//             // حذف الهيدن إن وجد
//             document
//                 .querySelector(
//                     `input[name="${selectElement.name}"][value="${tagId}"]`,
//                 )
//                 .remove();

//             updateHiddenInputs(selectElement, selectedList);
//             renderOptions(
//                 selectElement,
//                 tag.parentElement.nextElementSibling,
//                 selectedList,
//             );

//             // إطلاق الحدث
//             const event = new CustomEvent("multiSelectUpdated", {
//                 detail: { nameSelect: selectElement.name, tagId },
//             });
//             selectElement.dispatchEvent(event);

//             if (typeof onAfterRemove === "function") onAfterRemove(tagId);
//         });
//     });
// };

// ازالة تاج مع تحديث الـ state و UI
// state: { selectedList: [...] }
// selectElement: العنصر <select>
// dropdown: العنصر UL الخاص بالقائمة
// onAfterRemove: callback(tagId)
window.removeTag = function (
    state,
    selectElement,
    dropdown,
    onAfterRemove = null,
) {
    if (!state || !Array.isArray(state.selectedList)) {
        console.warn("removeTag: invalid state object passed");
        return;
    }

    // Delegated listener: نربط على الـ document لمرة واحدة
    // نتأكد أننا لا نضيف مستمع متعدد بنفس الطريقة
    const handlerName = `__multi_remove_tag_handler_for_${selectElement.id}`;
    if (document[handlerName]) return; // already attached

    const handler = (e) => {
        if (!e.target.classList.contains("cross")) return;
        const tag = e.target.closest(".tag-item");
        if (!tag) return;

        const tagId = tag.dataset.id;
        // remove DOM tag
        tag.remove();

        // update state.selectedList (مباشر داخل الكائن)
        state.selectedList = state.selectedList.filter((i) => i.id != tagId);

        // remove hidden inputs that match
        selectElement.parentNode
            .querySelectorAll(
                `input[type="hidden"][name="${selectElement.name}[]"][value="${tagId}"]`,
            )
            .forEach((i) => i.remove());

        // update hidden inputs and options and dropdown
        updateHiddenInputs(selectElement, state.selectedList);
        updateSelectedOptions(selectElement, state.selectedList);
        renderOptions(selectElement, dropdown, state.selectedList);

        // dispatch event
        const event = new CustomEvent("multiSelectUpdated", {
            detail: { nameSelect: selectElement.name, tagId },
        });
        selectElement.dispatchEvent(event);

        if (typeof onAfterRemove === "function") {
            try {
                onAfterRemove(tagId);
            } catch (err) {
                console.error(err);
            }
        }
    };

    document.addEventListener("click", handler);
    // store reference so we avoid double-binding
    document[handlerName] = handler;
};

// window.removeTag = function (
//     state,
//     selectElement,
//     dropdown,
//     onAfterRemove = null,
// ) {
//     const tags = document.querySelectorAll(".cross");
//     tags.forEach((cross) => {
//         cross.addEventListener("click", () => {
//             const tag = cross.parentElement;
//             const tagId = tag.dataset.id;
//             tag.remove();

//             // ✅ تعديل المصفوفة الأصلية داخل الكائن
//             state.selectedList = state.selectedList.filter(
//                 (i) => i.id != tagId,
//             );

//             // حذف الهيدن إن وجد
//             document
//                 .querySelectorAll(
//                     `input[name="${selectElement.name}"][value="${tagId}"]`,
//                 )
//                 .forEach((i) => i.remove());

//             updateHiddenInputs(selectElement, state.selectedList);
//             renderOptions(selectElement, dropdown, state.selectedList);

//             const event = new CustomEvent("multiSelectUpdated", {
//                 detail: { nameSelect: selectElement.name, tagId },
//             });
//             selectElement.dispatchEvent(event);

//             if (typeof onAfterRemove === "function") onAfterRemove(tagId);
//         });
//     });
// };

window.getSelectedIds = function (name) {
    return [...document.querySelectorAll(`input[name='${name}']`)]
        .map((input) => input.value)
        .filter((v) => v !== "");
};
