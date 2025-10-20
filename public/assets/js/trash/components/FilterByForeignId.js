// public/assets/js/components/filterByForeignId.js
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

        console.log(
            `[loadReferenceData] => model: ${reference}, foreignKey: ${constrainId}, value:`,
            constrainValue
        );

        select.parentElement?.classList.add("loading");
        document.getElementById(`${referenceId}-info`)?.classList.add("show");

        try {
            let constrainValues = Array.isArray(constrainValue)
                ? constrainValue
                : constrainValue
                      .toString()
                      .split(",")
                      .filter(Boolean)
                      .map(Number);

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
            console.log(`[API Response]`, data);

            // تحديث البيانات داخل الـ select
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

            // إعادة تحميل الـ SpecialSelect
            const oldWrapper = document.querySelector(
                `[data-for="${referenceId}"]`
            );
            if (oldWrapper) oldWrapper.remove();

            if (
                window.SpecialSelect &&
                select.hasAttribute("special-multiple")
            ) {
                window.SpecialSelect(select);
            } else if (window.SpecialSearch) {
                window.SpecialSearch(select);
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

    return { loadReferenceData };
}

window.filterByForeignId = filterByForeignId;
