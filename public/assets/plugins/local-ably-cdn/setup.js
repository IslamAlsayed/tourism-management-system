// ====== Ably Setup ======w
// const ably = new Ably.Realtime({
//     key: "{{ config('app.ably_key') }}",
// });

const currentUserId = window.USERID;

const channels = {
    webPush: ably.channels.get("web.push.notifications"),
};

// import notifications channels (public + per-user private)
channels.importPublic = ably.channels.get("import-channel");
channels.importPrivate = ably.channels.get(
    `private-import-channel-${currentUserId}`,
);

// ====== Helpers ======

const updateCount = (selector, value) => {
    const el = document.querySelector(selector);
    if (!el) return;
    el.textContent = value > 99 ? "99+" : parseInt(value, 10);
    el.classList.add("bounce-in");
    // let notificationDropdown = document.getElementById("notification-dropdown");
    // notificationDropdown.classList.add("hidden");
    el.classList.add("bounce-in");
    setTimeout(() => el.classList.remove("bounce-in"), 150);
};

const showIndicator = (selector) => {
    const el = document.querySelector(selector);
    if (!el) return;

    // Clear any existing timeout to prevent animation conflicts
    if (el.hideTimeout) {
        clearTimeout(el.hideTimeout);
    }

    // Remove hidden class and show the indicator
    el.classList.remove("hidden");

    // Set new timeout and store reference
    el.hideTimeout = setTimeout(() => {
        el.classList.add("hidden");
        el.hideTimeout = null;
    }, 1500);
};

const ensureBadge = (selector, count) => {
    let badge = document.querySelector(selector);
    if (!badge) {
        const btn = document.querySelector(".notification-toggle");
        if (!btn) return;

        badge = document.createElement("span");
        badge.className =
            "absolute bg-danger text-white text-xs rounded-full h-5 w-5 flex items-center justify-center notification-count";
        badge.style.cssText = "top: -3px; right: -3px;";
        btn.appendChild(badge);
    }
    updateCount(".notification-count", count);
};

const updateDashboardCounts = (data) => {
    updateCount(".activities-logs-count", data.activities_logs_count);
    updateCount(".users-count", data.users_count);
    updateCount(".notifications-count", data.notification_count);
};

// ====== Generic notification handler ======

const handleIncoming = (data, showToast = false) => {
    if (!data) return;

    // Toast (only if showToast is explicitly true and not sender)
    if (showToast && currentUserId != data.performer_id) {
        window.showToast({
            type: "success",
            title: data.subject || "",
            message: data.message,
        });
    }

    // Notification count (only update for non-senders)
    if (currentUserId != data.performer_id) {
        // Prefer unread count when available. If unread count is not present, do not update badge
        // to avoid briefly showing total counts (which may arrive in earlier payloads).
        if (typeof data.unread_notifications_count !== "undefined") {
            ensureBadge(".notification-count", data.unread_notifications_count);
            showIndicator(".new-notification");
        }
    }

    updateDashboardCounts(data);
};

// ====== Ably Subscriptions ======

let isInitialized = false; // Prevent duplicate subscriptions
// Track inserted notification IDs to avoid duplicates across messages
const insertedNotifications = new Set();

const initListeners = () => {
    if (isInitialized) return;
    isInitialized = true;

    channels.webPush.subscribe("web.push.notifications", (msg) => {
        if (!msg.data) return;
        if (window.settings && !window.settings.app_push_notifications) {
            return;
        }
        if (window.Livewire) {
            // If payload contains a notification object, try to insert it for the recipient
            const notify = msg.data.notification;
            const recipientId =
                notify?.target_user_id ??
                notify?.recipient_user_id ??
                msg.data.target_user_id ??
                null;

            if (notify) {
                // Only insert or update UI for notifications intended for this user
                if (recipientId == currentUserId) {
                    const container = document.querySelector("#notifications");
                    if (container) {
                        // avoid duplicate insertion using both DOM check and Set
                        if (
                            !insertedNotifications.has(notify.id) &&
                            !container.querySelector(
                                `.notification-${notify.id}`,
                            )
                        ) {
                            const html = createNotification(notify);
                            // Dispatch a DOM event so other parts of the app (e.g., Livewire) can react
                            try {
                                window.dispatchEvent(
                                    new CustomEvent("import-completed", {
                                        detail: data,
                                    }),
                                );
                            } catch (e) {
                                // ignore if CustomEvent not supported
                            }
                            container.insertAdjacentHTML("afterbegin", html);
                            insertedNotifications.add(notify.id);
                        }
                    } else {
                        console.warn(
                            "Notifications container '#notifications' not found. Skipping insertion.",
                        );
                    }

                    // Update counts, show toast and animation for recipient
                    handleIncoming(msg.data, false);
                }
                // If notify exists but it's for someone else, ignore entirely.
            } else {
                // No per-recipient notification in payload — treat as a global/dashboard update
                if (currentUserId != msg.data.performer_id) {
                    handleIncoming(msg.data, false);
                }
            }
        }
    });

    // Listen for import/export completion messages (public channel)
    try {
        channels.importPublic.subscribe((msg) => {
            if (!msg?.data) return;
            console.log("msg", msg.data);
            const data = msg.data;
            // event payload uses { message, type }
            if (data.message) {
                window.showToast({
                    type: data.type || "success",
                    title: "",
                    message: data.message,
                });
            }
        });
    } catch (e) {
        console.warn("Failed to subscribe to import public channel", e);
    }

    // Listen for user-targeted import messages on private channel
    try {
        channels.importPrivate.subscribe((msg) => {
            if (!msg?.data) return;
            console.log("msg", msg.data);
            const data = msg.data;
            if (data.message) {
                window.showToast({
                    type: data.type || "success",
                    title: "",
                    message: data.message,
                });
            }
        });
    } catch (e) {
        // private channel may require auth — ignore if unavailable
        // console.debug('Private import channel not available or requires auth', e);
    }
};
document.addEventListener("DOMContentLoaded", initListeners);

function createNotification(notification) {
    const isUnread = !notification.is_read;
    const titleHTML = notification.title
        ? `
            <p class="text-sm font-medium text-gray-900 truncate">
                ${notification.title}
            </p>`
        : "";

    // Dispatch DOM event for Livewire or other listeners
    try {
        window.dispatchEvent(
            new CustomEvent("import-completed", { detail: data }),
        );
    } catch (e) {
        // ignore
    }
    const messageClass = notification.title ? "" : "font-medium";

    return `
<div wire:key="notification-${notification.id}"
    class="notification p-3 border-gray-100 hover:bg-gray-50 ${isUnread ? "bg-blue-50" : ""} notification-${notification.id}">
    <div class="flex items-start space-x-3">
        <div class="flex-1 min-w-0">

            ${titleHTML}

            <p class="text-sm text-gray-600 ${messageClass}">
                ${notification.message.substring(0, 60)}
            </p>

            <p class="text-xs text-gray-400 mt-1">
                ${notification.human_created_at || ""}
            </p>
        </div>
        ${
            currentUserId == notification.target_user_id
                ? `
        <div class="flex-shrink-0 flex space-x-1">
            <div class="shrink-0 relative">
                <div class="cursor-pointer shrink-0 notification-actions-toggle"
                    data-id="${notification.id}">
                    <i class="fas fa-ellipsis" style="color: #4a5565"></i>
                </div>

                <div data-dropdown="${notification.id}"
                    class="notification-actions absolute mt-2 w-[100px] bg-white rounded-md shadow-lg border border-gray-200 hidden"
                    style="z-index: 10; top: -18px; user-select: none;">
                    <ul class="p-1">

                        ${
                            isUnread
                                ? `
                        <li>
                            <span wire:click="markAsRead(${notification.id})"
                                style="font-size: 10px; padding: 5px 10px; border-radius: 3px;"
                                class="block text-gray-700 hover:bg-gray-100 cursor-pointer readNotification-${notification.id}">
                                Mark Read
                            </span>
                        </li>`
                                : ""
                        }

                        <li>
                            <span wire:click="deleteNotification(${notification.id})"
                                style="font-size: 10px; padding: 5px 10px; border-radius: 3px;"
                                class="block text-red-600 hover:bg-gray-100 cursor-pointer deleteNotification-${notification.id}">
                                Delete
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>`
                : ""
        }
    </div>
</div>
    `;
}
