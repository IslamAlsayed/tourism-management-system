document.addEventListener("DOMContentLoaded", () => {
    // detect all selects
    const specialMultiples = document.querySelectorAll("[special-multiple]");
    const specialSearches = document.querySelectorAll("[special-search]");

    specialMultiples.forEach((select) => SpecialSelect(select));
    specialSearches.forEach((select) => SpecialSearch(select));
    SpecialDelete("selectAllItems", "input[name='selectedItems[]']");

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

function closeAllDropdowns() {
    document
        .querySelectorAll(".dropdown")
        .forEach((dd) => dd.classList.add("hidden"));
}
