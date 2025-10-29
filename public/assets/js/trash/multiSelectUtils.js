// multiSelectUtils.js

// public\assets\js\multiSelectUtils.js

// تحديث الهيدن إنبوتس بناءً على الحالة
window.updateHiddenInputs2 = function (selectElement, selectedList) {
    // نحذف القديم
    const parent = selectElement.parentNode;
    parent
        .querySelectorAll(`input[type="hidden"][name="${selectElement.name}"]`)
        .forEach((i) => i.remove());

    // نضيف الجديد
    selectedList.forEach((item) => {
        // نتأكد ما فيش duplicate
        if (parent.querySelector(`input[type="hidden"][value="${item.id}"]`))
            return;
        const hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = `${selectElement.name}`;
        hidden.dataset.name = item.label;
        hidden.value = item.id;
        parent.appendChild(hidden);
    });
};

window.updateHiddenInputs3 = function (selectElement, selectedList) {
    const parent = selectElement.parentNode;

    // ✅ الحصول على IDs من الـ selectedList
    const selectedIds = selectedList.map((item) => item.id.toString());

    // ✅ الحصول على الـ hidden inputs الموجودة
    const existingInputs = parent.querySelectorAll(
        `input[type="hidden"][name="${selectElement.name}"]`,
    );

    // 🧹 حذف الـ inputs اللي مش موجودة في selectedList
    existingInputs.forEach((input) => {
        if (!selectedIds.includes(input.value.toString())) {
            input.remove();
        }
    });

    // ✅ إضافة الـ inputs الجديدة اللي مش موجودة
    selectedList.forEach((item) => {
        const exists = Array.from(existingInputs).some(
            (input) => input.value.toString() === item.id.toString(),
        );

        if (!exists) {
            const hidden = document.createElement("input");
            hidden.type = "hidden";
            hidden.name = `${selectElement.name}`;
            hidden.dataset.name = item.label || item.name;
            hidden.value = item.id;
            parent.appendChild(hidden);
        }
    });
};

window.updateHiddenInputs4 = function (refSelect, values = []) {
    const wrapper = refSelect.closest(".multi-select-tag");
    const hiddenInputsContainer = wrapper.querySelector(".hidden-tags");

    // ✅ اجمع القيم الموجودة بالفعل (بدون مسح)
    const existingInputs = Array.from(
        hiddenInputsContainer.querySelectorAll("input[type='hidden']"),
    ).map((input) => input.value);

    // ✅ إضيف القيم الجديدة فقط
    values.forEach((val) => {
        if (!existingInputs.includes(val)) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = refSelect.name;
            input.value = val;
            hiddenInputsContainer.appendChild(input);
        }
    });

    // ✅ إحذف أي قيمة اتشالت من الـ tags
    existingInputs.forEach((val) => {
        if (!values.includes(val)) {
            const toRemove = hiddenInputsContainer.querySelector(
                `input[type='hidden'][value="${val}"]`,
            );
            toRemove?.remove();
        }
    });
};

// window.updateHiddenInputs(selectElement, selectedList)
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
window.removeTag2 = function (
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
                `input[type="hidden"][name="${selectElement.name}"][value="${tagId}"]`,
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

window.createTag = function (date) {
    const tag = document.createElement("span");
    tag.classList.add("tag-item");
    tag.textContent = date.name;
    tag.dataset.id = date.id;
    tag.dataset.name = date.name;
    tag.innerHTML = `${date.name} <span class="cross">×</span>`;
    return tag;
};

window.removeTag_old = function (
    tagOrState,
    state,
    selectElement,
    dropdown,
    onAfterRemove,
) {
    let tags = [];

    // لو أول باراميتر هو tag
    if (tagOrState instanceof HTMLElement) {
        tags = [tagOrState];
    } else {
        // لو أول باراميتر هو state (يعني مفيش tag محددة)
        state = tagOrState;
        tags = document.querySelectorAll(
            `[data-for="${selectElement.id}"] .tag-item`,
        );
    }

    tags.forEach((tag) => {
        const cross = tag.querySelector(".cross");
        if (!cross) return;

        // منع التكرار في حالة الـ reinitialization
        cross.replaceWith(cross.cloneNode(true));
        const newCross = tag.querySelector(".cross");

        newCross.addEventListener("click", async () => {
            const tagId = tag.dataset.id;
            const tagName = tag.dataset.name;
            tag.remove();

            const wrapper = document.querySelector(
                `[data-for="${selectElement.id}"]`,
            );
            if (wrapper) {
                const dropdown = wrapper.querySelector(".dropdown");

                // 🧱 إنشاء li جديد يمثل العنصر المحذوف
                const newLi = document.createElement("li");
                newLi.classList.add("li");
                newLi.dataset.id = tagId;
                newLi.textContent = tagName;

                dropdown.appendChild(newLi);

                // 🧩 ترتيب أبجدي
                const sortedLis = Array.from(dropdown.children).sort((a, b) =>
                    a.textContent
                        .trim()
                        .localeCompare(b.textContent.trim(), "ar", {
                            sensitivity: "base",
                        }),
                );

                dropdown.innerHTML = "";
                sortedLis.forEach((li) => dropdown.appendChild(li));
            }

            // ✅ تحديث state
            state.selectedList = state.selectedList.filter(
                (i) => i.id != tagId,
            );

            // 🧹 حذف hidden inputs
            document
                .querySelectorAll(
                    `input[name="${selectElement.name}"][value="${tagId}"]`,
                )
                .forEach((i) => i.remove());

            // ✅ تحديث الـ select والـ dropdown
            updateHiddenInputs(selectElement, state.selectedList);
            renderOptions(selectElement, dropdown, state.selectedList);

            // 🔔 dispatch event
            const event = new CustomEvent("multiSelectUpdated", {
                detail: { nameSelect: selectElement.name, tagId },
            });
            selectElement.dispatchEvent(event);

            if (typeof onAfterRemove === "function") await onAfterRemove(tagId);
        });
    });
};

window.removeTag_old2 = function (
    tag,
    state,
    selectElement,
    dropdown,
    onAfterRemove,
) {
    const cross = tag.querySelector(".cross");
    if (!cross) return;

    cross.addEventListener("click", () => {
        const tagId = tag.dataset.id;
        const tagName = tag.dataset.name;
        tag.remove();

        const wrapper = document.querySelector(
            `[data-for="${selectElement.id}"]`,
        );
        if (wrapper) {
            const dropdown = wrapper.querySelector(".dropdown");

            const newLi = document.createElement("li");
            newLi.classList.add("li");
            newLi.dataset.id = tagId;
            newLi.textContent = tagName;
            dropdown.appendChild(newLi);

            // 🧩 ترتيب الـ li أبجديًا
            const sortedLis = Array.from(dropdown.children).sort((a, b) =>
                a.textContent.trim().localeCompare(b.textContent.trim(), "ar", {
                    sensitivity: "base",
                }),
            );

            dropdown.innerHTML = "";
            sortedLis.forEach((li) => dropdown.appendChild(li));
        }

        // تحديث state + hidden inputs
        state.selectedList = state.selectedList.filter((i) => i.id != tagId);
        document
            .querySelectorAll(
                `input[name="${selectElement.name}"][value="${tagId}"]`,
            )
            .forEach((i) => i.remove());

        updateHiddenInputs(selectElement, state.selectedList);
        renderOptions(selectElement, dropdown, state.selectedList);

        const event = new CustomEvent("multiSelectUpdated", {
            detail: { nameSelect: selectElement.name, tagId },
        });
        selectElement.dispatchEvent(event);

        if (typeof onAfterRemove === "function") onAfterRemove(tagId);
    });
};

window.removeTag_last_one = function (
    state,
    selectElement,
    dropdown,
    onAfterRemove = null,
) {
    const wrapper = document.querySelector(`[data-for="${selectElement.id}"]`);
    if (!wrapper) return;

    const tags = wrapper.querySelectorAll(".cross");

    tags.forEach((cross) => {
        // إزالة أي event listeners قديمة عن طريق استبدال العنصر
        const newCross = cross.cloneNode(true);
        cross.parentNode.replaceChild(newCross, cross);

        newCross.addEventListener("click", () => {
            const tag = newCross.parentElement;
            const tagId = tag.dataset.id;
            const tagName = tag.dataset.name;
            tag.remove();

            if (wrapper) {
                const dropdown = wrapper.querySelector(".dropdown");

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
                    a.textContent
                        .trim()
                        .localeCompare(b.textContent.trim(), "ar", {
                            sensitivity: "base",
                        }),
                );

                // 🧹 مسح القديم وإعادة إدخالهم بالترتيب
                dropdown.innerHTML = "";
                sortedLis.forEach((li) => dropdown.appendChild(li));
            }

            // ✅ تحديث state
            state.selectedList = state.selectedList.filter(
                (i) => i.id != tagId,
            );

            // � تحديث الـ hidden inputs والـ dropdown (بدون حذف يدوي)
            window.updateHiddenInputs(selectElement, state.selectedList);
            window.renderOptions(selectElement, dropdown, state.selectedList);

            window.sortSelectedList(state, tagContainer);
            window.sortDropdown(dropdown);

            // 🔔 dispatch event للتحديثات
            const event = new CustomEvent("multiSelectUpdated", {
                detail: { nameSelect: selectElement.name, tagId },
            });
            selectElement.dispatchEvent(event);

            if (typeof onAfterRemove === "function") onAfterRemove(tagId);
        });
    });
};

window.removeTag44 = function (
    state,
    selectElement,
    dropdown,
    onAfterRemove = null,
) {
    const tags = document.querySelectorAll(".cross");
    tags.forEach((cross) => {
        cross.addEventListener("click", () => {
            const tag = cross.parentElement;
            const tagId = tag.dataset.id;
            const tagName = tag.dataset.name;
            tag.remove();

            // ✅ الـ option في الـ select الأصلي بيكون موجود أصلاً
            // لكن محتاجين نرجعه للـ dropdown
            const wrapper = document.querySelector(
                `[data-for="${selectElement.id}"]`,
            );
            if (wrapper) {
                const dropdown = wrapper.querySelector(".dropdown");

                // 🧱 إنشاء li جديد يمثل الـ option
                const newLi = document.createElement("li");
                newLi.dataset.value = tagId;
                newLi.textContent = tagName;
                newLi.classList.add("li");

                // 🧩 ترتيب الإدراج حسب القيمة
                const existingLis = Array.from(dropdown.children);
                const existing = existingLis.find(
                    (li) => li.dataset.value == tagId,
                );

                if (!existing) {
                    const insertBefore = existingLis.find(
                        (li) => parseInt(li.dataset.value) > parseInt(tagId),
                    );

                    if (insertBefore) {
                        dropdown.insertBefore(newLi, insertBefore);
                        console.log("insert before", tagId);
                    } else {
                        dropdown.appendChild(newLi);
                        console.log("append", tagId);
                    }
                } else {
                    console.log("already exists in dropdown");
                }
            }

            // ✅ تعديل المصفوفة الأصلية داخل الكائن
            state.selectedList = state.selectedList.filter(
                (i) => i.id != tagId,
            );

            // 🧹 حذف الـ hidden inputs إن وجد
            document
                .querySelectorAll(
                    `input[name="${selectElement.name}"][value="${tagId}"]`,
                )
                .forEach((i) => i.remove());

            // 🧱 تحديث الـ select والـ dropdown
            updateHiddenInputs(selectElement, state.selectedList);
            renderOptions(selectElement, dropdown, state.selectedList);

            // 🔔 dispatch event للتحديثات
            const event = new CustomEvent("multiSelectUpdated", {
                detail: { nameSelect: selectElement.name, tagId },
            });
            selectElement.dispatchEvent(event);

            if (typeof onAfterRemove === "function") onAfterRemove(tagId);
        });
    });
};

window.removeTag3 = function (
    state,
    selectElement,
    dropdown,
    onAfterRemove = null,
) {
    const tags = document.querySelectorAll(".cross");
    tags.forEach((cross) => {
        cross.addEventListener("click", () => {
            const tag = cross.parentElement;
            const tagId = tag.dataset.id;
            const tagName = tag.dataset.name;
            tag.remove();

            let oldOption = document.createElement("option");
            oldOption.value = tagId;
            oldOption.text = tagName;

            const wrapper = document.querySelector(
                `[data-for="${selectElement.id}"]`,
            );

            if (wrapper) {
                const dropdown = wrapper.querySelector(".dropdown");

                const lis = Array.from(dropdown.children).map((li) => {
                    const newLi = document.createElement("li");
                    newLi.dataset.id = li.dataset.id;
                    newLi.textContent = li.textContent;
                    return newLi;
                });
                const insertBefore = lis.find((opt) => opt.dataset.id > tagId);
                const existing = lis.find((opt) => opt.dataset.id == tagId);
                if (!existing) {
                    if (insertBefore) {
                        console.log("insert");
                        dropdown.insertBefore(oldOption, insertBefore);
                    } else {
                        console.log("append");
                        dropdown.appendChild(oldOption);
                    }
                    console.log("not exists");
                } else {
                    console.log("already exists");
                }
            }

            // ✅ تعديل المصفوفة الأصلية داخل الكائن
            state.selectedList = state.selectedList.filter(
                (i) => i.id != tagId,
            );

            // حذف الهيدن إن وجد
            document
                .querySelectorAll(
                    `input[name="${selectElement.name}"][value="${tagId}"]`,
                )
                .forEach((i) => i.remove());

            updateHiddenInputs(selectElement, state.selectedList);
            renderOptions(selectElement, dropdown, state.selectedList);

            const event = new CustomEvent("multiSelectUpdated", {
                detail: { nameSelect: selectElement.name, tagId },
            });
            selectElement.dispatchEvent(event);

            if (typeof onAfterRemove === "function") onAfterRemove(tagId);
        });
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

window.getSelectedIds = function (name) {
    return [...document.querySelectorAll(`input[name='${name}']`)]
        .map((input) => input.value)
        .filter((v) => v !== "");
};

// setTimeout(() => {
//     const oldWrapper = document.querySelector(
//         `[data-for="${selectElement.id}"]`,
//     );

//     if (oldWrapper) {
//         const tagInput = oldWrapper.querySelector(".tag-input");
//         const dropdown = oldWrapper.querySelector(".dropdown");

//         // 🧹 نظف الـ dropdown فقط
//         if (dropdown) dropdown.innerHTML = "";

//         // 🧱 أعد بناء عناصر الـ dropdown من الـ select
//         Array.from(selectElement.options).forEach((opt) => {
//             // تجاهل العناصر المختارة (اللي معمولها tag بالفعل)
//             if (!opt.selected) {
//                 const li = document.createElement("li");
//                 li.dataset.value = opt.value;
//                 li.textContent = opt.textContent;
//                 li.classList.add("li");
//                 dropdown.appendChild(li);
//             }
//         });

//         // 🔍 إعادة تفعيل البحث
//         if (tagInput) {
//             tagInput.addEventListener("input", (e) => {
//                 const term = e.target.value.toLowerCase();
//                 Array.from(dropdown.children).forEach((li) => {
//                     li.style.display = li.textContent
//                         .toLowerCase()
//                         .includes(term)
//                         ? ""
//                         : "none";
//                 });
//             });
//         }

//         // 🖱️ تفعيل اختيار العناصر من الـ dropdown
//         dropdown.addEventListener("click", (e) => {
//             const li = e.target.closest("li");
//             if (!li) return;

//             // تحديث الـ select
//             const value = li.dataset.value;
//             const opt = Array.from(selectElement.options).find(
//                 (o) => o.value === value,
//             );
//             if (opt) opt.selected = true;

//             // إنشاء tag جديد
//             const tagContainer =
//                 oldWrapper.querySelector(".tag-container");
//             if (tagContainer) {
//                 const tag = document.createElement("span");
//                 tag.className = "tag-item";
//                 tag.dataset.id = value;
//                 tag.dataset.name = li.textContent;
//                 tag.innerHTML = `${li.textContent} <span class="cross">×</span>`;
//                 tagContainer.insertBefore(
//                     tag,
//                     oldWrapper.querySelector(".tag-input"),
//                 );
//             }

//             li.remove(); // شيل العنصر من الـ dropdown
//         });

//         console.log(
//             "🔁 Refreshed specialSelect dropdown & tags preserved",
//         );
//     } else {
//         // ⏳ مفيش wrapper قبل كده، ابنيه جديد
//         window.specialSelect(selectElement);
//     }
// }, 0);

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
