// ====== Ably Setup ======w
// const ably = new Ably.Realtime({
//     key: "{{ config('app.ably_key') }}",
// });

const channels = {
    statusRecord: ably.channels.get("status-record"),
    webPush: ably.channels.get("web-push-notifications"),
    notifications: ably.channels.get("notifications"),
};

const currentUserId = window.USERID;

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

    // Livewire updates
    if (window.Livewire) {
        Livewire.dispatch("notificationCreated");
    }

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
        if (data.unread_notifications_count !== undefined) {
            ensureBadge(".notification-count", data.unread_notifications_count);
            showIndicator(".new-notification");
        }
    }

    updateDashboardCounts(data);
};

// ====== Ably Subscriptions ======

let isInitialized = false; // Prevent duplicate subscriptions

const initListeners = () => {
    if (isInitialized) return; // Don't initialize twice
    isInitialized = true;

    channels.statusRecord.subscribe("record.updated", async (msg) => {
        if (!msg.data) return;

        if (window.Livewire) {
            Livewire.dispatch("recordUpdated");
        }

        // Translate and show toast only for non-performers
        if (currentUserId != msg.data.performer_id) {
            const response = await fetch("/api/translate-record-event", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
                body: JSON.stringify(msg.data),
            });

            const result = await response.json();
            if (result) {
                // window.showToast({
                //     type: "info",
                //     message: result.message,
                // });
            }
        }

        handleIncoming(msg.data, false); // Don't show toast again, already shown above
    });

    channels.webPush.subscribe("web.push.notifications", (msg) => {
        if (!msg.data) return;
        if (window.Livewire) {
            // Livewire.dispatch("notificationCreated", { silent: true });
            window.addEventListener("new-notification-data", (e) => {
                const n = e.detail.notification;
                if (!n) return;
                const html = createNotification(n);
                const container = document.querySelector("#notifications");
                container.insertAdjacentHTML("afterbegin", html);
            });
        }
        if (currentUserId != msg.data.performer_id) {
            // window.showToast({
            //     type: "success",
            //     title: msg.data.subject || "",
            //     message: msg.data.message,
            // });
            handleIncoming(msg.data, false); // Pass false to prevent duplicate toast
        }
    });

    channels.notifications.subscribe("notification.created", (msg) => {
        if (!msg.data) return;
        if (currentUserId != msg.data.performer_id) {
            handleIncoming(msg.data, false); // Only update counts, no toast
        }
    });
};

document.addEventListener("DOMContentLoaded", initListeners);
// Removed livewire:navigated to prevent duplicate initialization

function createNotification(notification) {
    const isUnread = !notification.is_read;
    const titleHTML = notification.title
        ? `
            <p class="text-sm font-medium text-gray-900 truncate">
                ${notification.title}
            </p>`
        : "";

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
            window.USERID == notification.recipient_user_id
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
