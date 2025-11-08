import {
    totalAnimationTime,
    resetToastTimes,
    toastShake,
    setToastTimes,
    removeToast,
    userActive,
    showToast,
    showToastConfirm,
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

// مراقبة DOM وتفعيل removeToast عند التغييرات
document.addEventListener("DOMContentLoaded", () => {
    setTimeout(() => {
        document.querySelectorAll(".toasts").forEach((toastsContainer) => {
            const toastClosed =
                toastsContainer.querySelectorAll(".toast-closed");
            toastClosed.forEach((closed) => {
                closed.addEventListener("click", () => {
                    removeToast(closed.closest(".toast-inner"));
                });
            });
        });
    }, 100);
});

document.addEventListener("click", function (e) {
    if (e.target.closest(".push-toast-btn")) {
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

        showToast({
            type: type,
            title: title,
            message: message,
            duration: duration,
            emoji: emoji,
            icon: icon,
            pin: pin,
            actions: JSON.parse(actions) || null,
        });
    } else if (e.target.closest(".push-confirm-btn")) {
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
        let yesText = window.APP_LANG == "ar" ? "نعم" : "Yes";
        const onconfirm =
            target.dataset.onconfirm ||
            configToast.default_onconfirm_text ||
            yesText ||
            "Yes";
        const onconfirmLink = target.dataset.onconfirmlink || "#";
        let noText = window.APP_LANG == "ar" ? "لا" : "No";
        const oncancel =
            target.dataset.oncancel ||
            configToast.default_oncancel_text ||
            noText ||
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

        showToastConfirm({
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

window.removeToast = removeToast;
window.showToast = showToast;
window.showToastConfirm = showToastConfirm;

document.addEventListener("livewire:init", () => {
    Livewire.on("show-toast", (d) => window.showToast(d[0]));
});

document.addEventListener("livewire:init", () => {
    Livewire.on("show-toast-confirm", (d) => window.showToastConfirm(d[0]));
});

// console.log("userId: ", window.USERID);

// // Listen for Echo broadcast events
// if (typeof Echo !== "undefined") {
//     console.log("Echo");
//     Echo.private(`import-channel-${window.USERID}`).listen(
//         "show-toast",
//         (e) => {
//             console.log("broadcast", e);
//             window.showToast(e);
//         },
//     );
// }
