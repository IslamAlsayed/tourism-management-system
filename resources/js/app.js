import "./libs/trix";
import "./bootstrap";
// ⚠️ DO NOT import KTUI here! ktui.min.js (loaded in scripts.blade.php) handles
// ALL KT components (KTComponents, KTMenu, KTToast, KTSelect, KTDrawer, KTModal, etc.)
// and registers them as window globals. Importing here would create a dual instance.
import confetti from "canvas-confetti";

// External Plugins
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';
import tinymce from 'tinymce/tinymce';
import Dropzone from "dropzone";
import L from "leaflet";

// Expose globally for use in Blade templates
window.confetti = confetti;

window.FullCalendar = { Calendar, dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin };
window.tinymce = tinymce;
window.Dropzone = Dropzone;
window.L = L;

// ─────────────────────────────────────────────────────────────────────────────
// KTUI Architecture:
// 1. core.bundle.js (sync <script>) — Loads KTUI, exports KTDom/KTComponents
//    to window. Calls KTComponents.init() on DOMContentLoaded + livewire:navigated.
// 2. This file (Vite ESM, deferred) — Imports KTUI for KTToast/KTSelect only.
//    Does NOT call KTComponents.init() to avoid dual-init conflicts.
// 3. demo1.js (sync <script>) — Uses window.KTDom from core.bundle.js.
//
// ⚠️ DO NOT call KTComponents.init() here. core.bundle.js already does it.
// ─────────────────────────────────────────────────────────────────────────────

// Only custom sticky header logic (not in KTUI 9.4.9)
if (document.readyState === 'loading') {
    document.addEventListener("DOMContentLoaded", () => initStickyHeaders());
} else {
    initStickyHeaders();
}

if (typeof document !== "undefined") {
    document.addEventListener("livewire:navigated", () => initStickyHeaders());

    document.addEventListener("livewire:initialized", () => {
        Livewire.on("show-toast", (event) => {
            const data = Array.isArray(event) ? event[0] : event;
            const variant = data.type || "info";
            KTToast.show({
                variant: variant,
                message: data.message || "",
                duration: data.pin ? 0 : 4000,
                dismiss: true,
            });
        });
    });
}

function initStickyHeaders() {
    const stickyElements = document.querySelectorAll('[data-kt-sticky="true"]');
    stickyElements.forEach((element) => {
        if (element._ktStickyBound) return;
        element._ktStickyBound = true;
        const stickyClass = element.getAttribute("data-kt-sticky-class") || "kt-sticky";
        const offset = parseInt(element.getAttribute("data-kt-sticky-offset")) || 0;
        window.addEventListener("scroll", function () {
            if (window.scrollY > offset) {
                element.classList.add(...stickyClass.split(" "));
            } else {
                element.classList.remove(...stickyClass.split(" "));
            }
        });
    });
}

window.MetronicCore = {
    initStickyHeaders,
    reinit: () => window.KTComponents && window.KTComponents.init(),
};

// Canvas Confetti Random Direction
window.randomConfetti = function () {
    const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };
    function randomInRange(min, max) {
        return Math.random() * (max - min) + min;
    }
    let timeLeft = 2000;
    const interval = setInterval(function () {
        timeLeft -= 250;
        if (timeLeft <= 0) return clearInterval(interval);
        const particleCount = 50 * (timeLeft / 2000);
        confetti(Object.assign({}, defaults, {
            particleCount,
            origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 },
        }));
        confetti(Object.assign({}, defaults, {
            particleCount,
            origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 },
        }));
    }, 250);
    setTimeout(() => clearInterval(interval), 2000);
};
