// public/assets/js/utils/domUtils.js
window.DomUtils = {
    getSelect: (id) => document.getElementById(id),
    getInput: (key) => document.querySelector(`[data-for='${key}'] .tag-input`),

    getSelectedIds: (name) => {
        return [...document.querySelectorAll(`input[name='${name}']`)]
            .map((input) => input.value)
            .filter((v) => v !== "");
    },
};
