// ========================================
// SINGLE SELECT WITH SEARCH
// ========================================
window.specialSearch = function (selectElement) {
    if (!selectElement) return;

    // ========================================
    // INITIALIZATION
    // ========================================
    const isRequired = selectElement.hasAttribute("required");
    selectElement.removeAttribute("required");
    selectElement.style.display = "none";

    const wrapper = document.createElement("div");
    wrapper.className = "search-select-tag";
    wrapper.dataset.for = selectElement.id;
    selectElement.insertAdjacentElement("afterend", wrapper);

    wrapper.innerHTML = `
        <div class="wrapper">
            <div class="tag-container">
                <input type="search" class="tag-input" placeholder="Search..." autocomplete="off" readonly>
            </div>
            <ul class="dropdown hidden"></ul>
        </div>
    `;

    // ========================================
    // DOM ELEMENTS
    // ========================================
    const searchInput = wrapper.querySelector(".tag-input");
    const dropdown = wrapper.querySelector(".dropdown");

    // ========================================
    // STATE MANAGEMENT
    // ========================================
    let selectedValue = "";
    let selectedLabel = "";

    if (selectElement.value) {
        searchInput.dataset.id = selectElement.value;
        searchInput.value = selectElement.selectedOptions[0].textContent.trim();
    }

    // ========================================
    // HELPER FUNCTIONS
    // ========================================
    const updateHiddenInput = () => {
        selectElement.parentNode
            .querySelectorAll(
                `input[type="hidden"][name="${selectElement.name}"]`,
            )
            .forEach((i) => i.remove());

        if (selectedValue) {
            const hidden = document.createElement("input");
            hidden.type = "hidden";
            hidden.name = selectElement.name;
            hidden.value = selectedValue;
            if (isRequired) hidden.required = true;
            selectElement.parentNode.appendChild(hidden);
        }
    };

    const renderOptions = (filter = "") => {
        dropdown.innerHTML = "";
        let found = false;

        for (let i = 0; i < selectElement.length; i++) {
            const option = selectElement.options[i];
            if (option.value === "") continue;

            const match = option.textContent
                .toLowerCase()
                .includes(filter.toLowerCase());
            if (match) {
                const li = document.createElement("li");
                li.className = "li";
                li.dataset.value = option.value;
                li.textContent = option.textContent;
                dropdown.appendChild(li);
                found = true;
            }
        }

        if (!found) {
            const noOptions = document.createElement("li");
            noOptions.className = "no-options text-gray-500 italic px-2 py-1";
            const noDataMessage =
                window.APP_LANG == "ar"
                    ? "لا توجد بيانات متاحة"
                    : "No options available";
            noOptions.textContent = noDataMessage;
            noOptions.classList.add("disabled-option");
            dropdown.appendChild(noOptions);
        }
    };

    // ========================================
    // EVENT HANDLERS
    // ========================================
    searchInput.addEventListener("click", (e) => {
        closeAllDropdowns();
        searchInput.removeAttribute("readonly");

        const currentFilter = searchInput.value?.trim() || "";
        renderOptions(currentFilter);

        dropdown.classList.remove("hidden");
        e.stopPropagation();
    });

    document.addEventListener("click", (e) => {
        if (!wrapper.contains(e.target)) {
            dropdown.classList.add("hidden");
            searchInput.setAttribute("readonly", true);
        }
    });

    searchInput.addEventListener("input", function () {
        if (!this.value.trim()) {
            clearDependents(selectElement.id);
            renderOptions(this.value);
            return;
        }
    });

    dropdown.addEventListener("click", (e) => {
        if (e.target.tagName !== "LI") return;

        const value = e.target.dataset.value;
        const label = e.target.textContent;

        selectedValue = value;
        selectedLabel = label;
        searchInput.dataset.id = value;
        searchInput.value = label.trim();
        searchInput.setAttribute("readonly", true);
        dropdown.classList.add("hidden");

        updateHiddenInput();

        const event = new CustomEvent("updatedSelect", {
            detail: { value, label },
        });
        selectElement.dispatchEvent(event);
    });

    function clearDependents(fromId) {
        const hierarchy = [
            "region_id",
            "subregion_id",
            "country_id",
            "state_id",
            "city_id",
        ];
        const fromIndex = hierarchy.indexOf(fromId);

        if (fromIndex === -1) return;

        // 🧹 امسح كاش المستوى نفسه من globalRequestCache
        if (window.globalRequestCache) {
            const selfKey = `${fromId}_data`;
            if (window.globalRequestCache.has(selfKey)) {
                window.globalRequestCache.delete(selfKey);
                console.debug(`🧹 Cache cleared for ${selfKey}`);
            }
        }

        // مرّ على كل العناصر اللي بعد المستوى الحالي وافرغها
        for (let i = fromIndex + 1; i < hierarchy.length; i++) {
            const level = hierarchy[i];

            // 🧹 امسح الكاش لكل مستوى تابع
            if (window.globalRequestCache) {
                const cacheKey = `${level}_data`;
                if (window.globalRequestCache.has(cacheKey)) {
                    window.globalRequestCache.delete(cacheKey);
                    console.debug(`🧹 Cache cleared for ${cacheKey}`);
                }
            }

            const sel = document.getElementById(level);
            if (sel) {
                sel.innerHTML = '<option value="">--</option>';
                sel.disabled = true;
                const wrapper = document.querySelector(`[data-for="${level}"]`);
                if (wrapper) {
                    wrapper.parentElement?.classList.add("loading");
                    const tagInput = wrapper.querySelector(".tag-input");
                    if (tagInput) tagInput.value = "";
                    if (wrapper.querySelectorAll(".tag-item").length > 0) {
                        wrapper
                            .querySelectorAll(".tag-item")
                            .forEach((t) => t.remove());
                    }
                }

                let dataLength = document
                    .getElementById(level)
                    ?.parentElement.querySelector(".dataLength");
                if (dataLength) dataLength.innerText = "";

                document.getElementById(`${level}-info`)?.classList.add("show");
            }
        }
    }
};
