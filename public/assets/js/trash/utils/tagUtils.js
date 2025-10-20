// public/assets/js/utils/tagUtils.js
window.TagUtils = {
    async resetDependentTags(fromKey, toInput) {
        if (!toInput) return;
        const parent = toInput.closest(".multi-select-tag");
        if (parent) parent.querySelector(".tag-container").innerHTML = "";
        const nextSelect = document.getElementById(fromKey);
        if (nextSelect) nextSelect.innerHTML = '<option value="">--</option>';
    },

    async setTagsFromHiddenInputs(selectId) {
        const hiddenInputs = document.querySelectorAll(
            `input[name='${selectId}[]']`
        );
        if (!hiddenInputs.length) return;

        const select = document.getElementById(selectId);
        if (!select) return;

        const selectedList = [...hiddenInputs].map((input) => ({
            id: input.value,
            label: input.dataset.name,
        }));

        // إعادة رسم الـ tags
        if (window.SpecialSelect && select.hasAttribute("special-multiple")) {
            window.SpecialSelect(select);
        }

        // تحديث القيم داخل select نفسه
        [...select.options].forEach((option) => {
            option.selected = selectedList.some(
                (item) => item.id == option.value
            );
        });
    },
};
