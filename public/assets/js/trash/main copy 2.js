document.addEventListener("DOMContentLoaded", () => {
    const specialMultiples = document.querySelectorAll("[special-multiple]");

    specialMultiples.forEach((selectElement) => {
        initSpecialMultiple(selectElement);
    });

    // لو ضغطت في أي مكان بره، اقفل القوائم
    document.addEventListener("click", function (e) {
        if (!e.target.closest(".multi-select-tag")) {
            closeAllDropdowns();
        }
    });
});

function closeAllDropdowns() {
    document.querySelectorAll(".dropdown").forEach((dd) => {
        dd.classList.add("hidden");
    });
}

function initSpecialMultiple(selectElement) {
    if (!selectElement) return;

    // معالجة required
    const isRequired = selectElement.hasAttribute("required");
    selectElement.removeAttribute("required");

    // نحول الـ select لمولتي
    selectElement.style.display = "none";
    selectElement.setAttribute("multiple", "multiple");

    const wrapper = document.createElement("div");
    wrapper.className = "multi-select-tag";
    wrapper.dataset.for = selectElement.id;

    selectElement.insertAdjacentElement("afterend", wrapper);

    wrapper.innerHTML = `
        <div class="wrapper">
            <div class="tag-container">
                <input type="text" class="tag-input" placeholder="Search" autocomplete="off">
            </div>
            <ul class="dropdown hidden"></ul>
        </div>
    `;

    const tagContainer = wrapper.querySelector(".tag-container");
    const tagInput = wrapper.querySelector(".tag-input");
    const dropdown = wrapper.querySelector(".dropdown");

    let selectedList = [];

    // تحديث الـ hidden inputs
    const updateHiddenInputs = () => {
        selectElement.parentNode
            .querySelectorAll(
                `input[type="hidden"][name="${selectElement.name}"]`
            )
            .forEach((input) => input.remove());

        selectedList.forEach((item, index) => {
            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = selectElement.name;
            hiddenInput.value = item.id;
            hiddenInput.dataset.selectId = selectElement.id;

            // نضيف required لأول input بس لو select كان required
            if (isRequired && index === 0) hiddenInput.required = true;

            selectElement.parentNode.appendChild(hiddenInput);
        });
    };

    // تحديث selected attributes
    const updateSelectedOptions = () => {
        for (let i = 0; i < selectElement.options.length; i++) {
            selectElement.options[i].selected = false;
        }
        updateHiddenInputs();
    };

    const renderOptions = () => {
        dropdown.innerHTML = "";
        for (let i = 0; i < selectElement.options.length; i++) {
            const option = selectElement.options[i];
            if (option.value === "") continue; // skip placeholder
            if (!selectedList.find((item) => item.id == option.value)) {
                const li = document.createElement("li");
                li.className = "li";
                li.dataset.value = option.value;
                li.textContent = option.textContent;
                dropdown.appendChild(li);
            }
        }
    };

    // event: click على dropdown item
    dropdown.addEventListener("click", (e) => {
        if (e.target.tagName !== "LI") return;

        const value = e.target.dataset.value;
        const text = e.target.textContent;

        if (!selectedList.find((i) => i.id == value)) {
            selectedList.push({ id: value, label: text });

            const tag = document.createElement("span");
            tag.className = "tag-item";
            tag.dataset.value = value;
            tag.innerHTML = `${text}<span class="cross">&times;</span>`;

            tag.querySelector(".cross").addEventListener("click", () => {
                tag.remove();
                selectedList = selectedList.filter((i) => i.id !== value);
                updateSelectedOptions();
                renderOptions();
            });

            tagContainer.insertBefore(tag, tagInput);
            updateSelectedOptions();
            renderOptions();
        }

        tagInput.value = "";
        dropdown.classList.add("hidden");
    });

    // event: focus و search
    tagInput.addEventListener("click", (e) => {
        closeAllDropdowns();
        dropdown.classList.remove("hidden");
        e.stopPropagation();
    });

    tagInput.addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        dropdown.querySelectorAll("li").forEach((li) => {
            li.style.display = li.textContent.toLowerCase().includes(filter)
                ? "block"
                : "none";
        });
    });

    tagInput.addEventListener("keydown", (e) => {
        if (e.key == "Backspace" && tagInput.value === "") {
            const lastTag = tagContainer.querySelectorAll(".tag-item");
            if (lastTag.length > 0) {
                lastTag[lastTag.length - 1].querySelector(".cross").click();
            }
        }
    });

    renderOptions();
}
