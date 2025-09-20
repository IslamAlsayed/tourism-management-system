// ======= Helpers =======
window.closeAllDropdown = function () {
    document
        .querySelectorAll(".multi-select-tag .dropdown")
        .forEach((dropdown) => dropdown.classList.add("hidden"));
};

window.loadData = function (container = null) {
    let containerHotels =
        container || document.getElementById("containerHotels");
    let loader = document.createElement("div");
    loader.className = "loader";
    if (containerHotels) {
        containerHotels.appendChild(loader);
    }
};

let toggleTriggers = document.querySelectorAll(".toggle-trigger");
if (toggleTriggers.length > 0) {
    toggleTriggers.forEach((trigger) => {
        trigger.addEventListener("change", (event) => {
            const type = event.target.type; // checkbox | radio
            const targetId = event.target.dataset.toggleTarget;
            const elementId = event.target.dataset.toggleId;
            toggleDisplayTarget(targetId, elementId, event.target.checked);
        });
    });
}

function toggleDisplayTarget(targetId, elementId, isChecked, type = "radio") {
    if (type === "radio") {
        // Hide all targets with the same data-toggle-target
        document
            .querySelectorAll(".target-trigger")
            .forEach((t) => (t.style.display = "none"));
    }

    let target = document.querySelector(
        `[data-${targetId}-target="${elementId}"]`
    );

    if (target) {
        target.style.display = isChecked ? "block" : "none";
        target.style.visibility = isChecked ? "visible" : "hidden";
    }
}
