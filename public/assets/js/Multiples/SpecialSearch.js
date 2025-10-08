// ======= SINGLE SELECT WITH SEARCH =======
window.SpecialSearch = function (selectElement) {
    if (!selectElement) return;

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

    const searchInput = wrapper.querySelector(".tag-input");
    const dropdown = wrapper.querySelector(".dropdown");

    let selectedValue = "";
    let selectedLabel = "";

    const updateHiddenInput = () => {
        selectElement.parentNode
            .querySelectorAll(
                `input[type="hidden"][name="${selectElement.name}"]`
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

    // ✅ renderOptions with "No options found"
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

        // ✅ لو مفيش نتائج، نضيف عنصر "No options found"
        if (!found) {
            const noLi = document.createElement("li");
            noLi.className = "no-options text-gray-500 italic px-2 py-1";
            noLi.textContent = "No options found";
            noLi.classList.add("disabled-option");
            dropdown.appendChild(noLi);
        }
    };

    // open dropdown
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

    // search live
    searchInput.addEventListener("input", function () {
        renderOptions(this.value);
    });

    // select option
    dropdown.addEventListener("click", (e) => {
        if (e.target.tagName !== "LI") return;
        const value = e.target.dataset.value;
        const label = e.target.textContent;
        selectedValue = value;
        selectedLabel = label;
        searchInput.value = label;
        searchInput.setAttribute("readonly", true);
        dropdown.classList.add("hidden");
        updateHiddenInput();
    });
};
