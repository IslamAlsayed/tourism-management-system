document.addEventListener("DOMContentLoaded", () => {
    // detect all selects
    const specialMultiples = document.querySelectorAll("[special-multiple]");
    const specialSearches = document.querySelectorAll("[special-search]");
    specialMultiples.forEach((select) => window.specialSelect(select));
    specialSearches.forEach((select) => window.specialSearch(select));
    // window.specialDelete("selectAllItems", "input[name='selectedItems[]']");

    // close dropdowns on outside click
    document.addEventListener("click", function (e) {
        if (
            !e.target.closest(".multi-select-tag") &&
            !e.target.closest(".search-select-tag")
        ) {
            closeAllDropdowns();
        }
    });

    let multiples = [
        document.querySelectorAll(".basic-multiple"),
        document.querySelectorAll(".basic-single"),
    ];
    multiples.forEach((multiple) => {
        multiple.forEach((select) => {
            $(document).ready(function () {
                $(select).select2();
            });
        });
    });
});

document.addEventListener("updatedPaginate", () => {
    setTimeout(() => {
        window.resetDeleteSelection();
        // window.specialDelete("selectAllItems", "input[name='selectedItems[]']");
    }, 200);
});

// Re-initialize checkbox selection after Livewire updates
// document.addEventListener("livewire:initialized", () => {
//     Livewire.hook("morph.updated", ({ el, component }) => {
//         // Only re-initialize if the table was updated
//         if (
//             el.querySelector &&
//             (el.querySelector(".kt-table") || el.classList.contains("kt-table"))
//         ) {
//             setTimeout(() => {
//                 window.resetDeleteSelection();
//             }, 150);
//         }
//     });

//     // Also handle after commit (when all DOM updates are complete)
//     Livewire.hook("commit", ({ component, respond }) => {
//         setTimeout(() => {
//             // Re-initialize all special selects
//             const specialMultiples =
//                 document.querySelectorAll("[special-multiple]");
//             const specialSearches =
//                 document.querySelectorAll("[special-search]");
//             specialMultiples.forEach((select) => {
//                 if (!select.classList.contains("select2-hidden-accessible")) {
//                     window.specialSelect(select);
//                 }
//             });
//             specialSearches.forEach((select) => {
//                 if (!select.classList.contains("select2-hidden-accessible")) {
//                     window.specialSearch(select);
//                 }
//             });

//             // Re-initialize select2
//             const basicMultiples = document.querySelectorAll(".basic-multiple");
//             const basicSingles = document.querySelectorAll(".basic-single");
//             basicMultiples.forEach((select) => {
//                 if (!$(select).hasClass("select2-hidden-accessible")) {
//                     $(select).select2();
//                 }
//             });
//             basicSingles.forEach((select) => {
//                 if (!$(select).hasClass("select2-hidden-accessible")) {
//                     $(select).select2();
//                 }
//             });

//             // Re-initialize checkboxes
//             const selectAll = document.getElementById("selectAllItems");
//             if (selectAll && !selectAll.dataset.initialized) {
//                 window.resetDeleteSelection();
//             }

//             // Re-initialize scroll synchronization
//             initScrollSync();
//         }, 200);
//     });
// });

function closeAllDropdowns() {
    document
        .querySelectorAll(".dropdown")
        .forEach((dd) => dd.classList.add("hidden"));
}

window.addEventListener("record-deleted", (e) => {
    let id = e.detail.id;
    let type = e.detail.type;
    if (!id) return;

    const element = document.querySelector(".record-" + type + "-" + id);
    if (element) {
        element.classList.add("fade-down", "loading");
        setTimeout(() => element.remove(), 400);
    }
});

// Function to initialize scroll synchronization
function initScrollSync() {
    const topScroll = document.getElementById("topScroll");
    const topScrollInner = document.getElementById("topScrollInner");
    const tableWrapper = document.getElementById("tableWrapper");
    const table = document.getElementById("data_table");

    if (topScroll && topScrollInner && tableWrapper && table) {
        // Update inner width to match table width
        topScrollInner.style.width = table.scrollWidth + "px";

        // Sync scroll positions
        topScroll.scrollLeft = tableWrapper.scrollLeft;
    }
}

// Initialize scroll sync on page load
const topScroll = document.getElementById("topScroll");
const tableWrapper = document.getElementById("tableWrapper");
if (topScroll && tableWrapper) {
    const topScrollInner = document.getElementById("topScrollInner");
    const table = document.getElementById("data_table");

    if (topScrollInner && table) {
        topScrollInner.style.width = table.scrollWidth + "px";
    }

    // Use passive event listeners to improve scroll performance
    topScroll.addEventListener(
        "scroll",
        () => {
            tableWrapper.scrollLeft = topScroll.scrollLeft;
        },
        { passive: true },
    );

    tableWrapper.addEventListener(
        "scroll",
        () => {
            topScroll.scrollLeft = tableWrapper.scrollLeft;
        },
        { passive: true },
    );
}
