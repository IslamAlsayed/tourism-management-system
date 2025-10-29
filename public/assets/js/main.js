document.addEventListener("DOMContentLoaded", () => {
    // detect all selects
    const specialMultiples = document.querySelectorAll("[special-multiple]");
    const specialSearches = document.querySelectorAll("[special-search]");
    specialMultiples.forEach((select) => specialSelect(select));
    specialSearches.forEach((select) => specialSearch(select));
    specialDelete("selectAllItems", "input[name='selectedItems[]']");

    // close dropdowns on outside click
    document.addEventListener("click", function (e) {
        if (
            !e.target.closest(".multi-select-tag") &&
            !e.target.closest(".search-select-tag")
        ) {
            closeAllDropdowns();
        }
    });
});

document.addEventListener("updatedPaginate", () => {
    setTimeout(() => {
        resetDeleteSelection();
        specialDelete("selectAllItems", "input[name='selectedItems[]']");
    }, 200);
});

function closeAllDropdowns() {
    document
        .querySelectorAll(".dropdown")
        .forEach((dd) => dd.classList.add("hidden"));
}
