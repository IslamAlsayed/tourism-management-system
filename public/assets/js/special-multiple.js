// ======= Multi-Select Component =======
function initMultiSelect(selectElement, onChangeCallback) {
    selectElement.style.display = "none";

    // تأكد إن الـ select multiple
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

    // Function to update selected options in the select element
    function updateSelectedOptions() {
        // Clear all selected options first
        for (let i = 0; i < selectElement.options.length; i++) {
            selectElement.options[i].selected = false;
        }

        // Create hidden inputs for form submission
        updateHiddenInputs();
    }

    // Function to create hidden inputs for proper form submission
    function updateHiddenInputs() {
        // Remove existing hidden inputs first
        const existingInputs = selectElement.parentNode.querySelectorAll(
            `input[type="hidden"][name="${selectElement.name}"]`
        );
        existingInputs.forEach((input) => input.remove());

        // Add hidden inputs for selectedList only
        selectedList.forEach((item) => {
            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = selectElement.name;
            hiddenInput.value = item.id;
            hiddenInput.setAttribute("data-select-id", selectElement.id);
            selectElement.parentNode.appendChild(hiddenInput);
        });
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

    // ✅ اختيار عنصر
    dropdown.addEventListener("click", function (e) {
        if (e.target.tagName == "LI") {
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

                        // Update selected options
                        updateSelectedOptions();

                        renderOptions();
                        onChangeCallback(selectedList.map((s) => s.id));
                    }
                );

                tagContainer.insertBefore(tag, tagInput);

                // Update selected options
                updateSelectedOptions();

                renderOptions();
                onChangeCallback(selectedList.map((s) => s.id));
            }
            tagInput.value = "";
            dropdown.classList.add("hidden");
        }
    });

    // ✅ إظهار القائمة
    tagInput.addEventListener("click", function (e) {
        closeAllDropdown();
        dropdown.classList.remove("hidden");
        e.stopPropagation();
    });

    // ✅ فلترة
    tagInput.addEventListener("input", function () {
        let filter = this.value.toLowerCase();
        dropdown.querySelectorAll("li").forEach((li) => {
            li.style.display = li.textContent.toLowerCase().includes(filter)
                ? "block"
                : "none";
        });
    });

    // ✅ Backspace
    tagInput.addEventListener("keydown", function (e) {
        if (e.key == "Backspace" && tagInput.value == "") {
            let lastTag = tagContainer.querySelectorAll(".tag-item");
            if (lastTag.length > 0) {
                let tag = lastTag[lastTag.length - 1];
                let value = tag.dataset.value;
                tag.querySelector(".cross").click();
            }
        }
    });

    // أول رندر
    renderOptions();
    return {
        updateOptions: function (containerOptions, newOptions) {
            // Clear existing options
            containerOptions.innerHTML = "";

            if (newOptions.length == 0) {
                let option = document.createElement("option");
                option.textContent = "No options available";
                option.disabled = true;
                option.selected = true;
                option.classList.add("disabled-option");
                containerOptions.appendChild(option);

                // Clear selectedList فقط لو مفيش بيانات
                selectedList = [];
            } else {
                // Add new options
                newOptions.forEach((opt) => {
                    let option = document.createElement("option");
                    option.value = opt.id;
                    option.textContent = opt.name;
                    containerOptions.appendChild(option);
                });
            }

            // Remove existing hidden inputs
            const existingInputs = containerOptions.parentNode.querySelectorAll(
                `input[type="hidden"][name="${containerOptions.name}"]`
            );
            existingInputs.forEach((input) => input.remove());

            // **هنا نضيف فقط القيم الموجودة في selectedList**
            selectedList.forEach((item) => {
                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = containerOptions.name;
                hiddenInput.value = item.id;
                hiddenInput.setAttribute("data-select-id", containerOptions.id);
                containerOptions.parentNode.appendChild(hiddenInput);

                // نعلم الـ option كمحدد لو موجود
                let option = containerOptions.querySelector(
                    `option[value="${item.id}"]`
                );
                if (option) option.selected = true;
            });

            // Remove existing tags
            tagContainer
                .querySelectorAll(".tag-item")
                .forEach((t) => t.remove());

            // إعادة رسم التاجات الموجودة
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
}

// ======= Multi-Checkbox Component =======
function initMultiCheckbox(checkboxesSelector, onChangeCallback) {
    // هنجمع كل الـ checkboxes
    const checkboxes = document.querySelectorAll(checkboxesSelector);

    if (!checkboxes.length) return;

    // function لتجميع القيم المختارة
    function updateSelection() {
        const selectedValues = Array.from(checkboxes)
            .filter((cb) => cb.checked)
            .map((cb) => cb.value);

        // call الكول باك ونرجع القيم المختارة
        onChangeCallback(selectedValues);
    }

    // نربط كل checkbox بالـ event
    checkboxes.forEach((checkbox) => {
        const label = document.querySelector(
            `label[for="${checkbox.id}"][special-multiple-checkbox]`
        );

        if (label) {
            label.addEventListener("click", function (e) {
                e.preventDefault();
                checkbox.checked = !checkbox.checked;
                updateSelection();
            });
        }

        // برضه نخلي أي تغيير مباشر على الـ checkbox يشتغل
        checkbox.addEventListener("change", updateSelection);
    });

    // أول مرة نشغلها
    updateSelection();

    return {
        update: updateSelection, // تقدر تناديها إيدويًا لو حبيت
    };
}

function closeAllDropdown() {
    document
        .querySelectorAll(".multi-select-tag .dropdown")
        .forEach((dropdown) => dropdown.classList.add("hidden"));
}

function confirmMultiSelect(multiSelect) {
    if (multiSelect) {
        multiSelect.name = `${multiSelect.id}_Options[]`;
        initMultiSelect(multiSelect, function (values) {
            dataToSend.countries = values;
            if (multiSelect.dataset.type != "hotels") {
                fetchData();
            }
        });
    }
}

function closeAllConfirmMultiSelect() {
    let injectionSelects = document.querySelectorAll(".injection-select");
    if (injectionSelects.length > 0) {
        injectionSelects.forEach((select) => {
            select.parentElement.remove();
        });
    }
}

function loadData(container = null) {
    let containerHotels =
        container || document.getElementById("containerHotels");
    let loader = document.createElement("div");
    loader.className = "loader";
    containerHotels.appendChild(loader);
    console.log("loader");
}

document.addEventListener("click", function (e) {
    if (!e.target.closest(".multi-select-tag")) {
        closeAllDropdown();
    }
});

// ======= Main Logic =======
let hotelsMultiSelect = null;
let citiesMultiSelect = null;
let dataToSend = { countries: [], cities: [], stars: [], hotels: [] };
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

let allHotels = document.getElementById("all-hotels");
let specialMultiples = document.querySelectorAll("[special-multiple]");
let specialCheckboxes = document.querySelectorAll(
    "[special-multiple-checkbox]"
);

if (specialMultiples.length > 0) {
    specialMultiples.forEach((item) => {
        let multiSelect = document.getElementById(item.id);
        confirmMultiSelect(multiSelect);
    });
}

// MultiCheckbox للـ Stars
if (specialCheckboxes.length > 0) {
    initMultiCheckbox(".starsOptions", function (values) {
        dataToSend.stars = values;
        fetchData();
    });
}

// ✅ Fetch Hotels
function fetchData() {
    if (
        dataToSend.countries.length === 0 &&
        dataToSend.cities.length === 0 &&
        dataToSend.stars.length === 0
    ) {
        allHotels.parentElement.style.display = "block";
        console.log("No countries or cities or stars selected.");
        if (hotelsMultiSelect) {
            hotelsMultiSelect.updateOptions(hotelsSelect, []);
        }
        return;
    }

    fetch("/dashboard/quote/v2/get-hotels-by-countries-and-cities", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken ? csrfToken : "",
        },
        body: JSON.stringify(dataToSend),
    })
        .then((response) => response.json())

        .then((data) => {
            loadData();

            let containerHotels = document.getElementById("containerHotels");

            // Object.keys لأن data.data عبارة عن object فيها countries
            if (JSON.stringify(data.data).length > 0) {
                closeAllConfirmMultiSelect();

                Object.keys(data.data).forEach((countryId, i) => {
                    const countryData = data.data[countryId];

                    // Label للدولة
                    let div = document.createElement("div");
                    let label = document.createElement("label");
                    label.setAttribute("for", `hotels_${i}_`);
                    label.className = "kt-label mb-2";
                    label.innerHTML = `Hotels - <span class="text-primary">${countryData.country_name}</span>`;
                    div.appendChild(label);
                    containerHotels.appendChild(div);

                    // New Select لكل دولة
                    let newSelect = document.createElement("select");
                    newSelect.className = "injection-select";
                    newSelect.id = `hotels_${i}_`;
                    newSelect.name = `hotels_${i}_Options[]`;
                    newSelect.setAttribute("data-type", "hotels");
                    newSelect.setAttribute(
                        "special-multiple",
                        "special-multiple"
                    );

                    // Add options grouped by city
                    const cities = countryData.hotels_by_city;
                    Object.keys(cities).forEach((cityId) => {
                        const cityData = cities[cityId];

                        let optgroup = document.createElement("optgroup");
                        optgroup.label = cityData.city_name;

                        cityData.hotels.forEach((hotel) => {
                            let option = document.createElement("option");
                            option.value = hotel.id;
                            option.textContent = hotel.name;
                            optgroup.appendChild(option);
                        });

                        newSelect.appendChild(optgroup);
                    });

                    div.appendChild(newSelect);
                    containerHotels.appendChild(div);

                    let multiSelect = document.getElementById(newSelect.id);
                    confirmMultiSelect(multiSelect);
                });
            } else {
                allHotels.parentElement.style.display = "block";
            }

            if (document.querySelector(".loader")) {
                setTimeout(
                    () => document.querySelector(".loader").remove(),
                    1000
                );
            }
        })
        .catch((error) => console.error("Error:", error));
}

let lists = [
    document.querySelectorAll("select option"),
    document.querySelectorAll("ul li"),
];

lists.forEach((l) => {
    l.forEach((e) => {
        if (e.textContent == "--") {
            e.classList.add("disabled-option");
        }
    });
});
