let dataToSend2 = { transportation: {} };
const csrfToken2 = document.querySelector('meta[name="csrf-token"]').content;

// ✅ Listen for company select change
let companyOptions = document.querySelectorAll("select[id^='main-companies']");
companyOptions.forEach((select) => {
    select.addEventListener("change", function (e) {
        let company_id = e.target.value;
        let dataIndex = e.target.id.replace("main-companies", ""); // index = رقم الشركة

        // خزّن الشركة في object keyed بالـ index
        dataToSend2.transportation[dataIndex] = company_id;

        fetchTransportation(dataIndex, company_id);
    });
});

// ✅ Fetch Transportation Buses
function fetchTransportation(dataIndex, companyId) {
    fetch("/dashboard/quote/v2/get-transportation", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken2 ? csrfToken2 : "",
        },
        body: JSON.stringify({ transportation: [companyId] }),
    })
        .then((response) => response.json())
        .then((data) => {
            let containerBuses = document.querySelector(
                `[data-company="company-buses-${dataIndex}"]`
            );

            if (!containerBuses) return;

            containerBuses.innerHTML = ""; // reset

            if (data.data.buses && data.data.buses.length > 0) {
                // Label
                let label = document.createElement("label");
                label.className = "kt-label mb-2";
                label.innerHTML = "Buses";
                containerBuses.appendChild(label);

                // Select
                let newSelect = document.createElement("select");
                newSelect.className = "kt-select injection-select";
                newSelect.name = `trips[${dataIndex}][0][bused][]`; // tripIndex = 0 كبداية
                newSelect.setAttribute("multiple", "multiple");

                data.data.buses.forEach((bus) => {
                    let option = document.createElement("option");
                    option.value = bus.id;
                    option.textContent = `${bus.name} (${bus.seats} seats)`;
                    newSelect.appendChild(option);
                });

                containerBuses.appendChild(newSelect);

                // init multi-select لو عندك مكتبة
                if (typeof closeAllConfirmMultiSelect === "function") {
                    closeAllConfirmMultiSelect();
                }
            }
        })
        .catch((error) => console.error("Error:", error));
}
