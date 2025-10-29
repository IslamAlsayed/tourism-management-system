// ======= Multi-Select Component =======
window.initMultiSelect = function (selectElement, onChangeCallback) {
    if (!selectElement) return null;

    selectElement.style.display = "none";
    selectElement.setAttribute("multiple", "multiple");

    let wrapper = document.createElement("div");
    wrapper.className = "multi-select-tag";
    wrapper.setAttribute("data-for", selectElement.id);
    selectElement.parentNode.insertBefore(wrapper, selectElement.nextSibling);

    wrapper.innerHTML = `
        <div class="wrapper">
            <div class="tag-container">
                <input type="text" class="tag-input" placeholder="Search" autocomplete="off">
            </div>
            <ul class="dropdown hidden"></ul>
        </div>
    `;

    let tagContainer = wrapper.querySelector(".tag-container");
    let tagInput = wrapper.querySelector(".tag-input");
    let dropdown = wrapper.querySelector(".dropdown");

    let selectedList = [];

    function updateHiddenInputs() {
        const existingInputs = selectElement.parentNode.querySelectorAll(
            `input[type="hidden"][name="${selectElement.name}"]`
        );
        existingInputs.forEach((input) => input.remove());

        selectedList.forEach((item) => {
            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = selectElement.name;
            hiddenInput.value = item.id;
            hiddenInput.setAttribute("data-select-id", selectElement.id);
            selectElement.parentNode.appendChild(hiddenInput);
        });
    }

    function updateSelectedOptions() {
        for (let i = 0; i < selectElement.options.length; i++) {
            selectElement.options[i].selected = false;
        }
        updateHiddenInputs();
    }

    function renderOptions() {
        dropdown.innerHTML = "";
        for (let i = 0; i < selectElement.length; i++) {
            let option = selectElement.options[i];

            if (!selectedList.find((item) => item.id == option.value)) {
                let li = document.createElement("li");
                li.className = "li";
                li.dataset.value = option.value;
                li.textContent = option.textContent;
                dropdown.appendChild(li);
            }
        }
    }

    // events
    dropdown.addEventListener("click", function (e) {
        if (e.target.tagName === "LI") {
            let value = e.target.dataset.value;
            let text = e.target.textContent;

            if (!selectedList.find((item) => item.id == value)) {
                selectedList.push({ id: value, label: text });

                let tag = document.createElement("span");
                tag.className = "tag-item";
                tag.dataset.value = value;
                tag.innerHTML = `${text}<span class="cross">&times;</span>`;

                tag.querySelector(".cross").addEventListener(
                    "click",
                    function () {
                        tag.remove();
                        selectedList = selectedList.filter(
                            (item) => item.id !== value
                        );
                        updateSelectedOptions();
                        renderOptions();
                        onChangeCallback(selectedList.map((s) => s.id));
                    }
                );

                tagContainer.insertBefore(tag, tagInput);

                updateSelectedOptions();
                renderOptions();
                onChangeCallback(selectedList.map((s) => s.id));
            }
            tagInput.value = "";
            dropdown.classList.add("hidden");
        }
    });

    tagInput.addEventListener("click", function (e) {
        window.closeAllDropdown();
        dropdown.classList.remove("hidden");
        e.stopPropagation();
    });

    tagInput.addEventListener("input", function () {
        let filter = this.value.toLowerCase();
        dropdown.querySelectorAll("li").forEach((li) => {
            li.style.display = li.textContent.toLowerCase().includes(filter)
                ? "block"
                : "none";
        });
    });

    tagInput.addEventListener("keydown", function (e) {
        if (e.key == "Backspace" && tagInput.value === "") {
            let lastTag = tagContainer.querySelectorAll(".tag-item");
            if (lastTag.length > 0) {
                lastTag[lastTag.length - 1].querySelector(".cross").click();
            }
        }
    });

    renderOptions();

    return {
        updateOptions: function (containerOptions, newOptions) {
            containerOptions.innerHTML = "";

            if (newOptions.length === 0) {
                let option = document.createElement("option");
                option.textContent = "No options available";
                option.disabled = true;
                option.selected = true;
                option.classList.add("disabled-option");
                containerOptions.appendChild(option);
                selectedList = [];
            } else {
                newOptions.forEach((opt) => {
                    let option = document.createElement("option");
                    option.value = opt.id;
                    option.textContent = opt.name;
                    containerOptions.appendChild(option);
                });
            }

            const existingInputs = containerOptions.parentNode.querySelectorAll(
                `input[type="hidden"][name="${containerOptions.name}"]`
            );
            existingInputs.forEach((input) => input.remove());

            selectedList.forEach((item) => {
                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = containerOptions.name;
                hiddenInput.value = item.id;
                hiddenInput.setAttribute("data-select-id", containerOptions.id);
                containerOptions.parentNode.appendChild(hiddenInput);

                let option = containerOptions.querySelector(
                    `option[value="${item.id}"]`
                );
                if (option) option.selected = true;
            });

            tagContainer
                .querySelectorAll(".tag-item")
                .forEach((t) => t.remove());

            selectedList.forEach((item) => {
                let tag = document.createElement("span");
                tag.className = "tag-item";
                tag.dataset.value = item.id;
                tag.innerHTML = `${item.label}<span class="cross">&times;</span>`;
                tag.querySelector(".cross").addEventListener(
                    "click",
                    function () {
                        tag.remove();
                        selectedList = selectedList.filter(
                            (i) => i.id !== item.id
                        );
                        updateSelectedOptions();
                    }
                );
                tagContainer.insertBefore(tag, tagInput);
            });

            renderOptions();
            tagInput.value = "";
            dropdown.classList.add("hidden");
        },
    };
};
