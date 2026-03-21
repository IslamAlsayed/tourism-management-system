// Inject scrollbar styles into <head> - blue for light, bright blue for dark theme
(function injectScrollbarStyles() {
    const id = 'top-scroll-style';
    if (document.getElementById(id)) return;
    const style = document.createElement('style');
    style.id = id;
    style.textContent = `
        /* Light theme - blue */
        .top-scroll::-webkit-scrollbar { height: 7px !important; }
        .top-scroll::-webkit-scrollbar-thumb { background: linear-gradient(90deg, #2563eb, #3b82f6) !important; border-radius: 10px !important; }
        .top-scroll::-webkit-scrollbar-thumb:hover { background: #1d4ed8 !important; }
        .top-scroll::-webkit-scrollbar-track { background: rgba(37,99,235,0.08) !important; border-radius: 10px !important; }
        .top-scroll.no-overflow { height: 0 !important; overflow: hidden !important; }
        .table-wrapper::-webkit-scrollbar { height: 7px; }
        .table-wrapper::-webkit-scrollbar-thumb { background: linear-gradient(90deg, #2563eb, #3b82f6); border-radius: 10px; }
        .table-wrapper::-webkit-scrollbar-track { background: rgba(37,99,235,0.08); border-radius: 10px; }
        /* Dark theme - bright blue */
        .dark .top-scroll::-webkit-scrollbar-thumb { background: linear-gradient(90deg, #3b82f6, #60a5fa) !important; }
        .dark .top-scroll::-webkit-scrollbar-thumb:hover { background: #2563eb !important; }
        .dark .top-scroll::-webkit-scrollbar-track { background: rgba(59,130,246,0.12) !important; }
        .dark .table-wrapper::-webkit-scrollbar-thumb { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .dark .table-wrapper::-webkit-scrollbar-track { background: rgba(59,130,246,0.12); }
        /* SweetAlert z-index fix */
        .swal2-container { z-index: 9999 !important; }
    `;
    document.head.appendChild(style);
})();

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

    // Re-initialize top scroll sync after page components load
    setTimeout(() => initScrollSync(), 300);
}

// Re-sync top scrollbar after Livewire DOM updates
document.addEventListener("livewire:navigated", () => {
    setTimeout(() => initScrollSync(), 300);
});

document.addEventListener("updatedPaginate", () => {
    setTimeout(() => {
        window.resetDeleteSelection();
        initScrollSync();
    }, 200);
});

// Re-sync top scrollbar after Alpine live preview column changes
document.addEventListener("live-cols-update", () => {
    setTimeout(() => initScrollSync(), 50);
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
        const tableScrollWidth = table.scrollWidth;
        const wrapperClientWidth = tableWrapper.clientWidth;

        // Update inner width to match table width
        topScrollInner.style.width = tableScrollWidth + "px";

        // Sync scroll positions
        topScroll.scrollLeft = tableWrapper.scrollLeft;

        // Hide the top scrollbar entirely when no horizontal overflow
        if (tableScrollWidth <= wrapperClientWidth) {
            topScroll.classList.add("no-overflow");
        } else {
            topScroll.classList.remove("no-overflow");
        }
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

/**
 * Global fix for 405 Method Not Allowed (Livewire)
 * Prevents accidental GET form submissions when pressing Enter in Livewire components.
 */
document.addEventListener("keydown", function (e) {
    if (e.key === "Enter" && e.target.tagName === "INPUT" && !e.ctrlKey && !e.metaKey) {
        const form = e.target.closest("form");
        const isLivewire = e.target.closest("[wire\\:id]") || (form && form.closest("[wire\\:id]"));
        
        // If it's a Livewire component and NOT a standard form with an action
        if (isLivewire && (!form || !form.getAttribute("action") || form.getAttribute("action") === "#" || form.getAttribute("action").includes("livewire/update"))) {
            // Prevent default form submission via Enter
            e.preventDefault();
            // Trigger change event to ensure Livewire models are updated
            e.target.dispatchEvent(new Event("change", { bubbles: true }));
            console.log("Livewire 405 Prevention: Blocked Enter key submission on input:", e.target.id || e.target.name);
        }
    }
});