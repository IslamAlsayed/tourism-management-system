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
    if (wrapper.dataset.removeTagAttached === 'true') return;
    
    wrapper.dataset.removeTagAttached = 'true';

    wrapper.addEventListener("click", (e) => {
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
