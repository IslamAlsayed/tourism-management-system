// ======= Multi Checkbox =======
window.SpecialCheckbox = function (checkboxesSelector, onChangeCallback) {
    const checkboxes = document.querySelectorAll(checkboxesSelector);
    if (!checkboxes.length) return;

    function updateSelection() {
        const selectedValues = Array.from(checkboxes)
            .filter((cb) => cb.checked)
            .map((cb) => cb.value);

        onChangeCallback(selectedValues);
    }

    checkboxes.forEach((checkbox) => {
        const label = document.querySelector(
            `label[for="${checkbox.id}"][special-multiple-checkbox]`
        );

        if (label) {
            label.addEventListener("click", function (e) {
                e.preventDefault();
                checkbox.checked = !checkbox.checked;
                updateSelection();
            });
        }

        checkbox.addEventListener("change", updateSelection);
    });

    updateSelection();

    return { update: updateSelection };
};
