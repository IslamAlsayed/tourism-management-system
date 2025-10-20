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

function removeAlert(deration = 3000) {
    const customAlerts = document.getElementById("custom-alerts");
    if (customAlerts) {
        let alerts = customAlerts.querySelectorAll(".kt-alert");

        alerts.forEach((alert) => {
            if (!alert.dataset.handled) {
                alert.dataset.handled = "true";
                setTimeout(() => alert.remove(), deration);
            }
        });
    }
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

document.addEventListener("livewire:navigated", initToggles);
document.addEventListener("livewire:load", initToggles);
document.addEventListener("livewire:update", initToggles);

function initToggles() {
    const customToggleInputs = document.querySelectorAll("[toggle-input]");
    customToggleInputs.forEach((toggle) => {
        toggle.addEventListener("click", () => {
            toggle?.classList.toggle("loading");
            toggle?.classList.toggle("active");
            toggle
                ?.querySelector(".handle")
                ?.parentElement?.classList.toggle("active");
        });
    });
}
