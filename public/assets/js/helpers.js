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
        `[data-${targetId}-target="${elementId}"]`,
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

window.removeAlert = function (duration = 3000) {
    const customAlerts = document.querySelectorAll(".custom-alerts");

    customAlerts.forEach((container) => {
        const alerts = container.querySelectorAll(".kt-alert");

        alerts.forEach((alert) => {
            if (!alert.dataset.handled) {
                alert.dataset.handled = "true";
                setTimeout(() => alert.remove(), duration);
            }
        });
    });
};

// مراقبة DOM وتفعيل removeAlert عند التغييرات
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".custom-alerts").forEach((container) => {
        const observer = new MutationObserver(() => removeAlert());
        observer.observe(container, { childList: true, subtree: false });
    });
    removeAlert();
});

// تشغيل removeAlert بعد كل تحديث Livewire
document.addEventListener("livewire:load", () => {
    window.livewire.hook("message.processed", () => {
        removeAlert();
    });
});

window.removeDisabledOptions = function () {
    // handle disabled options
    let lists = [
        document.querySelectorAll("select option"),
        document.querySelectorAll("ul li"),
    ];
    lists.forEach((l) => {
        l.forEach((e) => {
            if (e.textContent == "--") {
                e.classList.add("disabled-option");
            }
        });
        l.parentElement;
    });
};
