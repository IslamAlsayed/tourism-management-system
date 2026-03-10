import "./libs/trix";
import "./bootstrap";
import KTComponents, { KTToast, KTSelect } from "@keenthemes/ktui";
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
window.KTComponents = KTComponents;
window.KTToast = KTToast;
window.KTSelect = KTSelect;
window.confetti = confetti;

window.FullCalendar = { Calendar, dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin };
window.tinymce = tinymce;
window.Dropzone = Dropzone;
window.L = L;

// Metronic Core JavaScript functionality
document.addEventListener("DOMContentLoaded", function () {
    // Initialize all KT components (Select, Datepicker, Modal, etc.)
    KTComponents.init();

    // Listen to Livewire toast events
    if (typeof Livewire !== "undefined") {
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
    } else {
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

    // Initialize drawer functionality
    initDrawers();

    // Initialize menu functionality
    initMenus();

    // Initialize sticky headers
    initStickyHeaders();

    // Initialize modal functionality
    initModals();
});

// Drawer functionality
function initDrawers() {
    const drawers = document.querySelectorAll("[data-kt-drawer]");

    drawers.forEach((drawer) => {
        const toggles = document.querySelectorAll(
            `[data-kt-drawer-toggle="#${drawer.id}"]`,
        );

        toggles.forEach((toggle) => {
            toggle.addEventListener("click", function (e) {
                e.preventDefault();
                drawer.classList.toggle("hidden");
                drawer.classList.toggle("block");
            });
        });
    });
}

// Menu functionality
function initMenus() {
    const menus = document.querySelectorAll('[data-kt-menu="true"]');

    menus.forEach((menu) => {
        const items = menu.querySelectorAll(
            '[data-kt-menu-item-toggle="dropdown"]',
        );

        items.forEach((item) => {
            const trigger = item.querySelector(
                '[data-kt-menu-item-trigger="click"], [data-kt-menu-item-trigger="click|lg:hover"]',
            );
            const dropdown = item.querySelector(".kt-menu-dropdown");

            if (trigger && dropdown) {
                trigger.addEventListener("click", function (e) {
                    e.preventDefault();
                    dropdown.classList.toggle("hidden");
                });
            }
        });
    });
}

// Sticky header functionality
function initStickyHeaders() {
    const stickyElements = document.querySelectorAll('[data-kt-sticky="true"]');

    stickyElements.forEach((element) => {
        const stickyClass =
            element.getAttribute("data-kt-sticky-class") || "kt-sticky";
        const offset =
            parseInt(element.getAttribute("data-kt-sticky-offset")) || 0;

        window.addEventListener("scroll", function () {
            if (window.scrollY > offset) {
                element.classList.add(...stickyClass.split(" "));
            } else {
                element.classList.remove(...stickyClass.split(" "));
            }
        });
    });
}

// Modal functionality
function initModals() {
    const modalToggles = document.querySelectorAll("[data-kt-modal-toggle]");

    modalToggles.forEach((toggle) => {
        toggle.addEventListener("click", function (e) {
            e.preventDefault();
            const modalId = this.getAttribute("data-kt-modal-toggle");
            const modal = document.querySelector(modalId);

            if (modal) {
                modal.classList.toggle("hidden");
                modal.classList.toggle("flex");
            }
        });
    });
}

// Close modals when clicking outside
document.addEventListener("click", function (e) {
    const modals = document.querySelectorAll(".kt-modal");

    modals.forEach((modal) => {
        if (e.target === modal) {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }
    });
});

// Export functions for use in other modules
window.MetronicCore = {
    initDrawers,
    initMenus,
    initStickyHeaders,
    initModals,
};

// Canvas Confetti Random Direction
window.randomConfetti = function () {
    const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };
    function randomInRange(min, max) {
        return Math.random() * (max - min) + min;
    }

    const interval = setInterval(function () {
        const timeLeft = 2000;

        if (timeLeft <= 0) {
            return clearInterval(interval);
        }

        const particleCount = 50 * (timeLeft / 2000);
        confetti(
            Object.assign({}, defaults, {
                particleCount,
                origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 },
            })
        );
        confetti(
            Object.assign({}, defaults, {
                particleCount,
                origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 },
            })
        );
    }, 250);
    
    // Stop after 2 seconds
    setTimeout(() => clearInterval(interval), 2000);
};

