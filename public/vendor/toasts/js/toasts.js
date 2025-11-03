import {
    totalAnimationTime,
    resetToastTimes,
    toastShake,
    setToastTimes,
    userActive,
    pushToast,
    pushToastConfirm,
} from "./global.js";

document.addEventListener("DOMContentLoaded", function () {
    resetToastTimes();
});

document.querySelectorAll(".toast-inner").forEach((inner) => {
    const toast = inner.querySelector(".toast");
    toastShake(toast);
    setToastTimes(toast);
    userActive(inner, toast, totalAnimationTime, 0);
});

document.addEventListener("click", function (e) {
    const toastBtn = e.target.closest(".push-toast-btn");
    const confirmBtn = e.target.closest(".push-confirm-btn");
    if (!toastBtn || !confirmBtn) return;

    if (toastBtn) {
        const type =
            target.dataset.type ||
            target.dataset.theme ||
            configToast.default_theme;
        const title = target.dataset.title || type;
        const message =
            target.dataset.message || configToast.default_message || null;
        const duration = target.dataset.duration || null;
        const pin = target.dataset.pin || null;
        const emoji = target.dataset.emoji || null;
        const icon = target.dataset.icon || null;
        const actions = target.dataset.actions || null;

        pushToast({
            type: type,
            title: title,
            message: message,
            duration: duration,
            emoji: emoji,
            icon: icon,
            pin: pin,
            actions: JSON.parse(actions) || null,
        });
    }

    if (confirmBtn) {
        e.preventDefault();

        const isForm = target.tagName === "FORM";

        const type =
            target.dataset.type ||
            target.dataset.theme ||
            configToast.default_theme;
        const title =
            target.dataset.title || configToast.default_confirm_title || type;
        const message =
            target.dataset.message ||
            configToast.default_confirm_message ||
            null;
        const pin = target.dataset.pin || null;
        const emoji = target.dataset.emoji || null;
        const icon = target.dataset.icon || null;
        const onconfirm =
            target.dataset.onconfirm ||
            configToast.default_onconfirm_text ||
            "Yes";
        const onconfirmLink = target.dataset.onconfirmlink || "#";
        const oncancel =
            target.dataset.oncancel ||
            configToast.default_oncancel_text ||
            "No";
        const actions = target.dataset.actions || null;

        const proceed = () => {
            if (isForm) {
                target.submit();
            } else {
                // Trigger native click if it's just a button (e.g., inside a form)
                target.dispatchEvent(
                    new Event("confirmed-click", { bubbles: true }),
                );
            }
        };

        pushToastConfirm({
            type: type,
            title: title,
            message: message,
            pin: pin,
            emoji: emoji,
            icon: icon,
            onconfirm: onconfirm,
            onconfirmLink: onconfirmLink,
            oncancel: oncancel,
            actions: JSON.parse(actions) || null,
            onConfirmCallback: proceed,
        });
    }
});

window.pushToast = pushToast;
window.pushToastConfirm = pushToastConfirm;

document.addEventListener("livewire:init", () => {
    Livewire.on("show-toast", (d) => window.pushToast(d[0]));
});
