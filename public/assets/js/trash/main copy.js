// ======= Main Logic =======
let hotelsMultiSelect = null;
let citiesMultiSelect = null;
let dataToSend = { countries: [], cities: [], stars: [], hotels: [] };
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

let allHotels = document.getElementById("all-hotels");
let specialMultiples = document.querySelectorAll("[special-multiple]");
let specialCheckboxes = document.querySelectorAll(
    "[special-multiple-checkbox]",
);

function confirmMultiSelect(multiSelect) {
    if (multiSelect) {
        window.initMultiSelect(multiSelect, function (values) {
            // dataToSend.countries = values;
            // if (multiSelect.dataset.type != "hotels") {
            //     fetchHotels();
            // }
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

// init multi-selects
if (specialMultiples.length > 0) {
    specialMultiples.forEach((item) => {
        let multiSelect = document.getElementById(item.id);
        confirmMultiSelect(multiSelect);
    });
}

// init multi-checkbox
// if (specialCheckboxes.length > 0) {
//     window.initMultiCheckbox(".starsOptions", function (values) {
//         dataToSend.stars = values;
//         fetchHotels();
//     });
// }

// close dropdowns when clicking outside
document.addEventListener("click", function (e) {
    if (!e.target.closest(".multi-select-tag")) {
        window.closeAllDropdown();
    }
});

// ======= Fetch Hotels =======
function fetchHotels() {
    if (
        dataToSend.countries.length === 0 &&
        dataToSend.cities.length === 0 &&
        dataToSend.stars.length === 0
    ) {
        if (allHotels) allHotels.parentElement.style.display = "block";

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
            window.loadData();

            let containerHotels = document.getElementById("containerHotels");
            if (containerHotels) containerHotels.innerHTML = "";

            if (Object.keys(data.data).length > 0) {
                if (allHotels) allHotels.parentElement.style.display = "none";
                closeAllConfirmMultiSelect();

                Object.keys(data.data).forEach((countryId, i) => {
                    const countryData = data.data[countryId];

                    let div = document.createElement("div");
                    let label = document.createElement("label");
                    label.setAttribute("for", `hotelsOptions${i}`);
                    label.className = "kt-label mb-2";
                    label.innerHTML = `Hotels - <span class="text-primary">${countryData.country_name}</span>`;
                    div.appendChild(label);
                    containerHotels.appendChild(div);

                    let newSelect = document.createElement("select");
                    newSelect.className = "injection-select";
                    newSelect.id = `hotelsOptions${i}`;
                    newSelect.name = `hotelsOptions[]`;
                    newSelect.setAttribute("data-type", "hotels");
                    newSelect.setAttribute(
                        "special-multiple",
                        "special-multiple",
                    );

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
                if (allHotels) allHotels.parentElement.style.display = "block";

                let div = document.createElement("div");
                let label = document.createElement("label");
                label.setAttribute("for", `hotelsOptionsEmpty`);
                label.className = "kt-label mb-2";
                label.innerHTML = `Hotels - <span class="text-red-600">No options available</span>`;
                div.appendChild(label);

                let newSelect = document.createElement("select");
                newSelect.className = "injection-select";
                newSelect.id = `hotelsOptionsEmpty`;
                newSelect.name = `hotelsOptionsEmpty[]`;
                newSelect.setAttribute("data-type", "hotels");
                newSelect.setAttribute("special-multiple", "special-multiple");

                let option = document.createElement("option");
                option.textContent = "No options available";
                option.className = "disabled-option";
                option.disabled = true;
                newSelect.appendChild(option);

                div.appendChild(newSelect);
                if (containerHotels) containerHotels.appendChild(div);

                confirmMultiSelect(newSelect);
            }

            if (document.querySelector(".loader")) {
                setTimeout(
                    () => document.querySelector(".loader").remove(),
                    1000,
                );
            }
        })
        .catch((error) => console.error("Error:", error));
}

// handle disabled options
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
