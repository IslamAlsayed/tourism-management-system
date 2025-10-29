// ======= Multi Select =======
window.SpecialSelect = function (selectElement) {
    if (!selectElement) return;

    const isRequired = selectElement.hasAttribute("required");
    selectElement.removeAttribute("required");

    selectElement.style.display = "none";
    selectElement.setAttribute("multiple", "multiple");

    const wrapper = document.createElement("div");
    wrapper.className = "multi-select-tag";
    wrapper.dataset.for = selectElement.id;
    selectElement.insertAdjacentElement("afterend", wrapper);

    wrapper.innerHTML = `
        <div class="wrapper">
            <div class="tag-container">
                <input type="search" class="tag-input" placeholder="Search" autocomplete="off">
            </div>
            <ul class="dropdown hidden"></ul>
        </div>
    `;

    const tagContainer = wrapper.querySelector(".tag-container");
    const tagInput = wrapper.querySelector(".tag-input");
    const dropdown = wrapper.querySelector(".dropdown");

    let selectedList = [];

    const updateHiddenInputs = () => {
        selectElement.parentNode
            .querySelectorAll(
                `input[type="hidden"][name="${selectElement.name}"]`
            )
            .forEach((i) => i.remove());

        selectedList.forEach((item, index) => {
            const hidden = document.createElement("input");
            hidden.type = "hidden";
            hidden.name = selectElement.name;
            hidden.value = item.id;
            if (isRequired && index === 0) hidden.required = true;
            selectElement.parentNode.appendChild(hidden);
        });
    };

    const updateSelectedOptions = () => {
        for (let i = 0; i < selectElement.options.length; i++) {
            selectElement.options[i].selected = false;
        }
        updateHiddenInputs();
    };

    const renderOptions = () => {
        dropdown.innerHTML = "";
        for (let i = 0; i < selectElement.length; i++) {
            const option = selectElement.options[i];
            if (option.value === "") continue;
            if (!selectedList.find((x) => x.id == option.value)) {
                const li = document.createElement("li");
                li.className = "li";
                li.dataset.id = option.value;
                li.textContent = option.textContent;
                dropdown.appendChild(li);
            }
        }
    };

    dropdown.addEventListener("click", (e) => {
        if (e.target.tagName !== "LI") return;
        const value = e.target.dataset.id;
        const text = e.target.textContent;

        if (!selectedList.find((x) => x.id == value)) {
            selectedList.push({ id: value, label: text });

            const tag = document.createElement("span");
            tag.className = "tag-item";
            tag.dataset.id = value;
            tag.innerHTML = `${text}<span class="cross">&times;</span>`;

            tag.querySelector(".cross").addEventListener("click", () => {
                tag.remove();
                selectedList = selectedList.filter((i) => i.id !== value);
                updateSelectedOptions();
                renderOptions();

                let nameSelect = selectElement.name;
                const event = new CustomEvent("multiSelectUpdated", {
                    detail: { name, nameSelect },
                });
                selectElement.dispatchEvent(event);
            });

            tagContainer.insertBefore(tag, tagInput);
            updateSelectedOptions();
            renderOptions();

            // ✅ إطلاق حدث "updatedSelect" على select الأصلي بعد اختيار قيمة
            let selectedIds = selectedList.map((i) => i.id);
            const event = new CustomEvent("updatedSelect", {
                detail: { value, selectedIds },
            });
            selectElement.dispatchEvent(event);
        }

        tagInput.value = "";
        dropdown.classList.add("hidden");
    });

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

                const select = document.getElementById("state_id");
                const event = new CustomEvent("multiSelectUpdated", {
                    detail: { name: "state_id" },
                });
                select.dispatchEvent(event);
            }
        }
    });

    renderOptions();
};

//   setTimeout(() => {
//       let hiddenInputs = document.querySelectorAll(
//           `input[type="hidden"][name="${selectElement.name}[]"]`
//       );

//       if (hiddenInputs.length === 0) {
//           hiddenInputs.forEach((input) => {
//               const value = input.value;
//               const label = input.dataset.name;
//               console.log({ id: value, label: label });
//               selectedList.push({ id: value, label: label });
//           });
//       }
//   }, 100);
