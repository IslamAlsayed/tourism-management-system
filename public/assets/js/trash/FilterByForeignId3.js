function filterByForeignId(
    constrainId,
    reference,
    referenceId,
    action = "create"
) {
    const refSelect = () => document.getElementById(referenceId);

    async function loadReferenceData(constrainValue, selectedValue = null) {
        const select = refSelect();
        if (!select) return;

        select.parentElement?.classList.add("loading");
        document.getElementById(`${referenceId}-info`)?.classList.add("show");
        try {
            let constrainValues = constrainValue
                .toString()
                .split(",")
                .filter((v) => v)
                .map((v) => parseInt(v));

            const response = await fetch("/api/get-references", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    _token: document.querySelector('meta[name="csrf-token"]')
                        .content,
                    model: reference,
                    foreignKey: constrainId,
                    foreignKeyValue: constrainValues,
                }),
            });

            const { data } = await response.json();

            // تحديث عدد العناصر
            const label = select.parentElement.querySelector(".dataLength");
            if (label) label.innerText = `(${data.length})`;

            select.innerHTML = '<option value="">--</option>';
            data.forEach((item) => {
                const option = document.createElement("option");
                option.value = item.id;
                option.textContent = item.name;
                select.appendChild(option);
            });

            select.disabled = false;

            // إعادة تهيئة الـ specialSelect
            document.dispatchEvent(
                new CustomEvent("updatedPaginate", {
                    detail: { id: referenceId },
                })
            );
            const oldWrapper = document.querySelector(
                `[data-for="${referenceId}"]`
            );
            if (oldWrapper) oldWrapper.remove();

            if (
                window.specialSelect &&
                select.hasAttribute("special-multiple")
            ) {
                window.specialSelect(select);
            } else if (window.specialSearch) {
                window.specialSearch(select);
            }

            // في حالة edit
            if (selectedValue) {
                select.value = selectedValue;
                const input = document.querySelector(
                    `[data-for='${referenceId}'] .tag-input`
                );
                if (input) {
                    const item = data.find((i) => i.id == selectedValue);
                    input.value = item ? item.name : "";
                    input.dataset.id = selectedValue;
                }
            }
        } catch (err) {
            console.error("Error loading data:", err);
        } finally {
            select.parentElement?.classList.remove("loading");
            document
                .getElementById(`${referenceId}-info`)
                ?.classList.remove("show");
        }
    }

    // تحميل تلقائي في وضع الـ edit
    if (action === "edit") {
        (async function loadEdit() {
            const region = getVal("region_id");
            const subregion = getVal("subregion_id");
            const country = getVal("country_id");
            const state = getVal("state_id");
            const city = getVal("city_id");

            if (region) await loadReferenceData(region, subregion);
            if (subregion)
                await filterByForeignId(
                    "subregion_id",
                    "country",
                    "country_id"
                ).loadReferenceData(subregion, country);
            if (country)
                await filterByForeignId(
                    "country_id",
                    "state",
                    "state_id"
                ).loadReferenceData(country, state);
            if (state)
                await filterByForeignId(
                    "state_id",
                    "city",
                    "city_id"
                ).loadReferenceData(state, city);

            // await setTagsFromHiddenInputs("state_id");
            // await setTagsFromHiddenInputs("city_id");
        })();
    }

    function getVal(id) {
        const el = document.getElementById(id);
        return el?.dataset.currentValue || el?.value || null;
    }

    return { loadReferenceData };
}
