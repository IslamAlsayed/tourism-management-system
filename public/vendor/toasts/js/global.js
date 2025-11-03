export let totalAnimationTime = 0;
export let root = document.documentElement;

export function parseToastTime(time) {
    if (!time) return 0;
    const match = time.match(/^(\d+(\.\d+)?)([smh])?$/i);

    if (match) {
        const value = parseFloat(match[1]);
        const unit = match[3]?.toLowerCase() ?? "s";

        switch (unit) {
            case "h":
                return value * 60 * 60 * 1000;
            case "m":
                return value * 60 * 1000;
            default:
                return value * 1000;
        }
    }
    return 0;
}

export function resetToastTimes() {
    root.style.setProperty("--toast-move", configToast.move);
    root.style.setProperty("--toast-enter-time", configToast.enter_time);
    root.style.setProperty(
        "--toast-visible-time",
        parseToastTime(configToast.visible_time),
    );
    root.style.setProperty("--toast-exit-time", configToast.exit_time);
    root.style.setProperty(
        "--toast-start-delay-time",
        configToast.start_delay_time,
    );
}

export function setToastTimes(toast) {
    const baseVisibleTime = parseToastTime(configToast.visible_time);
    const enterTime = parseToastTime(configToast.enter_time);
    const exitTime = parseToastTime(configToast.exit_time);
    const startDelayTime = parseToastTime(configToast.start_delay_time);

    const rawDuration = toast.dataset.duration ?? null;
    const customDuration = parseToastTime(rawDuration);

    const visibleTime = baseVisibleTime + customDuration;

    totalAnimationTime = startDelayTime + enterTime + exitTime + visibleTime;

    toast.style.setProperty("--toast-visible-time", `${visibleTime}ms`);
}

export function shouldAutoRemove(toast) {
    if (configToast.move != "enable") return false;
    if (toast.classList.contains("no_move")) return false;
    if (toast.classList.contains("forever")) return false;
    if (toast.classList.contains("pin")) return false;
    if (toast.classList.contains("confirm-forever")) return false;
    return true;
}

export function toastShake() {
    let toastInners = document.querySelectorAll(".toasts .toast-inner");

    toastInners.forEach((inner) => {
        if (inner.querySelector(".toast.confirm-forever")) {
            if (!document.querySelector(".layer")) {
                let layer = document.createElement("div");
                layer.className = "layer";
                document.body.appendChild(layer);

                layer.addEventListener("click", () => {
                    let _inner = inner.querySelector(".toast");
                    if (!_inner) return;

                    if (inner.dataset.shaking == "true") return;

                    inner.dataset.shaking = "true";

                    let class_shake = _inner.classList.contains("right")
                        ? "toast-right-shake"
                        : "toast-top-shake";

                    inner.classList.remove(class_shake);
                    void inner.offsetWidth;
                    inner.classList.add(class_shake);

                    setTimeout(() => {
                        inner.classList.remove(class_shake);
                        inner.dataset.shaking = "false";
                    }, 700);
                });
            }
        }
    });
}

const toastTimeouts = new Map();
const toastStartTimes = new Map();
const toastPausedTimes = new Map();
const toastPauseStart = new Map();

export function removeToast(toastInner) {
    if (!toastInner || !toastInner.parentNode) return;

    toastInner.remove();
    toastTimeouts.delete(toastInner);
    toastStartTimes.delete(toastInner);
    toastPausedTimes.delete(toastInner);
    toastPauseStart.delete(toastInner);

    setTimeout(() => {
        const parent = document.querySelector(".toasts");
        if (parent && parent.children.length == 0) {
            parent.remove();
        }
    }, 125);

    const hasConfirm = document.querySelector(".toasts .confirm-forever");
    if (!hasConfirm) {
        document.querySelector(".layer")?.remove();
    }
}

export function userActive(toastInner, toast, totalAnimationTime, fast = 0) {
    let toastActions = toast.querySelectorAll(".toast-action");

    if (toastActions.length) {
        toastActions.forEach((action) => {
            action?.addEventListener("click", () => {
                setTimeout(() => removeToast(toastInner), 125);
            });
        });
    }

    if (shouldAutoRemove(toast)) {
        const startTime = Date.now();
        toastStartTimes.set(toastInner, startTime);
        toastPausedTimes.set(toastInner, 0);

        const id = setTimeout(() => {
            removeToast(toastInner);
        }, totalAnimationTime - fast);

        toastTimeouts.set(toastInner, id);
    }

    toast.addEventListener("mouseenter", () => {
        const id = toastTimeouts.get(toastInner);
        if (id) {
            clearTimeout(id);
            toastTimeouts.delete(toastInner);
            toastPauseStart.set(toastInner, Date.now());
        }
    });

    toast.addEventListener("mouseleave", () => {
        if (shouldAutoRemove(toast) && !toastTimeouts.has(toastInner)) {
            const pauseStart = toastPauseStart.get(toastInner);
            const pausedTime = toastPausedTimes.get(toastInner) || 0;
            const now = Date.now();
            const newPausedTime = pausedTime + (now - pauseStart);
            toastPausedTimes.set(toastInner, newPausedTime);

            const startTime = toastStartTimes.get(toastInner);
            const elapsed = now - startTime - newPausedTime;
            const remaining = totalAnimationTime - fast - elapsed;

            if (remaining > 0) {
                const id = setTimeout(() => {
                    removeToast(toastInner);
                }, remaining);
                toastTimeouts.set(toastInner, id);
            } else {
                removeToast(toastInner);
            }
        }
    });
}

export function isEmoji(char) {
    const emojiRegex =
        /[\u{1F600}-\u{1F64F}|\u{1F300}-\u{1F5FF}|\u{1F680}-\u{1F6FF}|\u{2600}-\u{26FF}|\u{2700}-\u{27BF}|\u{1F900}-\u{1F9FF}|\u{1FA70}-\u{1FAFF}]/u;
    return emojiRegex.test(char);
}

function getOrCreateToasts() {
    let container = document.querySelector(".toasts");
    if (!container) {
        container = document.createElement("div");
        container.className = "toasts";
        document.body.prepend(container);
    }
    return container;
}

function createIcon(type, emoji, icon) {
    let iconElement;

    if (emoji) {
        iconElement = document.createElement("div");
        iconElement.classList.add("toast-icon", "emoji");
        iconElement.style.fontSize = "20px";
        iconElement.textContent = emoji;
    } else {
        iconElement = document.createElement("i");
        iconElement.classList.add("toast-icon", "fas");

        if (icon) {
            icon.split(" ").forEach((_class) => {
                iconElement.classList.add(_class);
            });
        } else {
            switch (type) {
                case "success":
                    iconElement.classList.add("fa-circle-check");
                    break;
                case "error":
                    iconElement.classList.add("fa-circle-xmark");
                    break;
                case "warning":
                    iconElement.classList.add("fa-triangle-exclamation");
                    break;
                case "info":
                    iconElement.classList.add("fa-circle-exclamation");
                    break;
            }
        }
    }

    return iconElement;
}

function createToastText(title, message, actions = null, confirm = null) {
    const ToastText = document.createElement("div");
    ToastText.className = "toast-text";

    const text = document.createElement("div");
    text.className = "text";

    if (title) {
        const titleElement = document.createElement("strong");
        titleElement.textContent = title;
        text.appendChild(titleElement);
    }

    const messageElement = document.createElement("p");
    messageElement.textContent = message;
    text.appendChild(messageElement);

    ToastText.appendChild(text);
    if (actions) ToastText.appendChild(actions);
    if (confirm) ToastText.appendChild(confirm);

    return ToastText;
}

function createCloseButton(toastElement) {
    const close = document.createElement("div");
    close.className = "toast-closed";

    const icon = document.createElement("i");
    icon.className = "fas fa-xmark";
    close.appendChild(icon);

    icon.addEventListener("click", () => {
        console.log(icon);
        // Find the closest .toast-inner ancestor to ensure correct removal
        let toastInner = toastElement.closest(".toast-inner");
        if (toastInner) {
            removeToast(toastInner);
        }
    });

    return close;
}

function createConfirmButtons(onconfirm, onconfirmLink, oncancel) {
    const confirmActions = document.createElement("div");
    confirmActions.className = "toast-actions";

    const a = document.createElement("a");
    a.classList.add("toast-action", "onconfirm");
    a.href = onconfirmLink;
    a.classList.add(isEmoji(onconfirm) ? "emoji" : "text");
    a.textContent = onconfirm;

    const p = document.createElement("p");
    p.classList.add("toast-action", "oncancel");
    p.classList.add(isEmoji(oncancel) ? "emoji" : "text");
    p.textContent = oncancel;

    confirmActions.appendChild(a);
    confirmActions.appendChild(p);

    // Fix: Add event handler for confirm action if a callback is provided
    if (typeof window.onConfirmCallback === "function") {
        a.addEventListener("click", (e) => {
            e.preventDefault();
            window.onConfirmCallback();
            // Remove the toast
            let toastInner = a.closest(".toast-inner");
            if (toastInner) removeToast(toastInner);
        });
    }

    return confirmActions;
}

function createActionsButtons(actions) {
    const _actions = document.createElement("div");
    _actions.className = "toast-actions";

    if (actions) {
        actions.forEach((action) => {
            const a = document.createElement("a");
            a.classList.add("toast-action");
            a.href = action.url;
            if (action.target) a.target = action.target;
            a.classList.add(isEmoji(action.label) ? "emoji" : "text");
            a.textContent = action.label;
            _actions.appendChild(a);
        });
    }

    return _actions;
}

export function pushToast({
    type,
    title,
    message,
    duration,
    emoji,
    icon,
    pin,
    actions,
}) {
    if (!type || !message) return;

    const toasts = getOrCreateToasts();

    root.style.setProperty("--toast-start-delay-time", `0s`);

    const toastInner = document.createElement("div");
    toastInner.className = "toast-inner";

    const toast = document.createElement("div");
    toast.className = `toast toast-${type} top`;

    if (configToast.move != "enable" || pin == "pin") {
        const pin = document.createElement("i");
        pin.className = "toast-icon pin fas fa-thumbtack";

        toast.classList.add("no_move", "pin");
        toast.appendChild(pin);
    }

    if (duration) {
        toast.setAttribute("data-duration", duration);
    }

    toast.appendChild(createIcon(type, emoji, icon));
    let __actions = createActionsButtons(actions);

    toast.appendChild(createToastText(title, message, __actions));
    toast.appendChild(createCloseButton(toast));

    toastInner.appendChild(toast);
    toasts.appendChild(toastInner);

    toastShake(toast);

    // Set timeout for auto-dismiss
    setToastTimes(toast);
    userActive(toastInner, toast, totalAnimationTime, 1000);
}

export function pushToastConfirm({
    type,
    title,
    message,
    duration,
    emoji,
    icon,
    pin,
    onconfirm,
    onconfirmLink,
    oncancel,
    actions,
}) {
    if (!type || !message) return;

    const toasts = getOrCreateToasts();

    root.style.setProperty("--toast-start-delay-time", `0s`);

    const toastInner = document.createElement("div");
    toastInner.className = "toast-inner";

    const toast = document.createElement("div");
    toast.classList.add("toast", `toast-${type}`, "top", "confirm-forever");

    if (
        configToast.move != "enable" ||
        pin == "pin" ||
        toast.classList.contains("confirm-forever")
    ) {
        const pin = document.createElement("i");
        pin.className = "toast-icon pin fas fa-thumbtack";

        toast.classList.add("no_move", "pin");
        toast.appendChild(pin);
    }

    if (duration) {
        toast.setAttribute("data-duration", duration);
    }

    toast.appendChild(createIcon(type, emoji, icon));
    let __actions = createActionsButtons(actions);
    let __confirm = createConfirmButtons(onconfirm, onconfirmLink, oncancel);

    toast.appendChild(createToastText(title, message, __actions, __confirm));
    toast.appendChild(createCloseButton(toast));

    toastInner.appendChild(toast);
    toasts.appendChild(toastInner);

    toastShake(toast);

    // Set timeout for auto-dismiss
    setToastTimes(toast);
    userActive(toastInner, toast, totalAnimationTime, 1000);
}
