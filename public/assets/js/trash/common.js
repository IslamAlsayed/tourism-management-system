// public/assets/js/common.js
//= require ./utils/domUtils.js
//= require ./utils/tagUtils.js
//= require ./components/SpecialSelect.js
//= require ./components/filterByForeignId.js
//= require ./modules/locationHandler.js

// import "./filterByForeignId.js";
// import "./SpecialSearch.js";
// import "./SpecialSelect.js";
// import "./TagContainer.js";

// console.log("%c[Common Loaded]", "color: green; font-weight: bold;");

// public/assets/js/common.js

// ✅ استيراد يدوي (لو مش عندك bundler)
document.addEventListener("DOMContentLoaded", async () => {
    // تحميل الملفات بالترتيب
    const scripts = [
        "/assets/js/utils/domUtils.js",
        "/assets/js/utils/tagUtils.js",
        "/assets/js/Multiples/SpecialSelect.js",
        "/assets/js/Multiples/SpecialSearch.js",
        "/assets/js/components/filterByForeignId.js",
        "/assets/js/modules/locationHandler.js",
    ];

    for (const src of scripts) {
        await loadScript(src);
    }

    console.log(
        "%c[Common Loaded Successfully ✅]",
        "color: green; font-weight: bold;"
    );
});

// دالة لتحميل ملف JS بشكل ديناميكي
function loadScript(src) {
    return new Promise((resolve, reject) => {
        const script = document.createElement("script");
        script.src = src;
        script.async = false;
        script.onload = resolve;
        script.onerror = reject;
        document.head.appendChild(script);
    });
}
