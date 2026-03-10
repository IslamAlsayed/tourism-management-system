document.addEventListener("DOMContentLoaded", () => {
    initPageComponents();
});

// Re-initialize components after Livewire SPA navigation
document.addEventListener("livewire:navigated", () => {
    initPageComponents();
});

function initPageComponents() {
    // detect all selects
    const specialMultiples = document.querySelectorAll("[special-multiple]");
    const specialSearches = document.querySelectorAll("[special-search]");
    specialMultiples.forEach((select) => {
        if (!select.classList.contains("select2-hidden-accessible")) {
            window.specialSelect(select);
        }
    });
    specialSearches.forEach((select) => {
        if (!select.classList.contains("select2-hidden-accessible")) {
            window.specialSearch(select);
        }
    });

    // close dropdowns on outside click
    document.addEventListener("click", function (e) {
        if (
            !e.target.closest(".multi-select-tag") &&
            !e.target.closest(".search-select-tag")
        ) {
            closeAllDropdowns();
        }
    });

    // Initialize Select2
    if (typeof $ !== 'undefined') {
        $(document).ready(function () {
            let multiples = [
                document.querySelectorAll(".basic-multiple"),
                document.querySelectorAll(".basic-single"),
            ];
            multiples.forEach((multiple) => {
                multiple.forEach((select) => {
                    if (!$(select).hasClass("select2-hidden-accessible")) {
                        $(select).select2();
                    }
                });
            });
        });
    }
}

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

    console.log(".record-" + type + "-" + id);
    const element = document.querySelector(".record-" + type + "-" + id);
    if (element) {
        element.classList.add("fade-down", "loading");
        setTimeout(() => element.remove(), 250);
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

// Sidebar scroll to active - on page load
document.addEventListener("DOMContentLoaded", () => {
    setTimeout(scrollSidebarToActive, 50);
});

// Sidebar scroll to active - on navigation
window.addEventListener("load", () => {
    setTimeout(scrollSidebarToActive, 200);
});

// Add click listeners to all sidebar links
// document.addEventListener("DOMContentLoaded", () => {
//     const sidebarLinks = document.querySelectorAll("#sidebar .kt-menu-link");
//     sidebarLinks.forEach((link) => {
//         link.addEventListener("click", () => {
//             // Wait for page navigation
//             setTimeout(scrollSidebarToActive, 100);
//         });
//     });
// });

function scrollSidebarToActive() {
    const activeLink = document.querySelector(".kt-menu-link.active");
    if (!activeLink) {
        console.warn("No active link found");
        return;
    }

    // افتح الـ accordion لو مقفول
    let parentItem = activeLink.closest(".kt-menu-item");
    while (parentItem) {
        if (!parentItem.classList.contains("show")) {
            parentItem.classList.add("show");
        }
        // افتح كل الـ parents لحد ما نوصل للـ sidebar root
        parentItem = parentItem.parentElement?.closest(".kt-menu-item");
    }

    // خُد العنصر اللي فعليًا بيعمل scroll
    const scrollContainer = getScrollableParent(activeLink);
    if (!scrollContainer) {
        console.warn("No scrollable parent found");
        return;
    }

    const containerRect = scrollContainer.getBoundingClientRect();
    const linkRect = activeLink.getBoundingClientRect();

    const offset =
        linkRect.top -
        containerRect.top +
        scrollContainer.scrollTop -
        scrollContainer.clientHeight / 2 +
        linkRect.height / 2;

    scrollContainer.scrollTo({ top: offset, behavior: "smooth" });
}

function getScrollableParent(el) {
    while (el) {
        const style = getComputedStyle(el);
        if (
            (style.overflowY === "auto" || style.overflowY === "scroll") &&
            el.scrollHeight > el.clientHeight
        ) {
            return el;
        }
        el = el.parentElement;
    }
    return null;
}




// document.addEventListener("DOMContentLoaded", function () {
//     const sidebarScrollable = document.querySelector(".kt-scrollable-y-hover");
//     if (!sidebarScrollable) return;

//     const activeItem =
//         sidebarScrollable.querySelector(".kt-menu-item.show") ||
//         sidebarScrollable.querySelector(".kt-menu-item-show") ||
//         sidebarScrollable.querySelector(".active.bg-accent\\/60") ||
//         sidebarScrollable.querySelector(".kt-menu-item-show.show") ||
//         sidebarScrollable.querySelector(".kt-menu-link.active");
//     if (!activeItem) return;

//     // height calculations
//     const sidebarHeight = sidebarScrollable.clientHeight;
//     const itemOffsetTop = activeItem.offsetTop;
//     const itemHeight = activeItem.offsetHeight;

//     // Scroll so active item is centered
//     sidebarScrollable.scrollTo({
//         top: itemOffsetTop - sidebarHeight / 2 + itemHeight / 2,
//         behavior: "smooth",
//     });
// });

// Submit form with Ctrl+Enter on create/edit pages
document.addEventListener("keydown", function (e) {
    // Check if Ctrl/Cmd + Enter was pressed
    if ((e.ctrlKey || e.metaKey) && e.key === "Enter") {
        // Check if current page is create or edit page
        const currentUrl = window.location.pathname;
        const isCreateOrEditPage =
            currentUrl.includes("/create") || currentUrl.includes("/edit");

        if (isCreateOrEditPage) {
            // Find and submit the form
            const formButtonSaveRecord = document.getElementById("formButtonSaveRecord");
            if (formButtonSaveRecord) {
                e.preventDefault();
                formButtonSaveRecord.click();
            }
        }
    }
});