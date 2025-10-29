function filterByForeignId(
    constrainId,
    reference,
    referenceId,
    action = "create"
) {
    const constrainSelect = document.querySelector(
        `[data-for="${constrainId}"]`
    );
    const referenceSelect = document.querySelector(`#${referenceId}`);

    if (!constrainSelect || !referenceSelect) return;

    async function loadReferenceData(constrainValue, selectedValue = null) {
        referenceSelect.parentElement.classList.add("loading");
        document.getElementById(`${referenceId}-loader`)?.classList.add("show");

        try {
            const response = await fetch("/api/get-references", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    _token: document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    model: reference,
                    foreignKey: constrainId,
                    foreignKeyValue: constrainValue,
                }),
                credentials: "same-origin",
            });
            if (!response.ok) throw new Error("Request failed");

            const data = await response.json();
            referenceSelect.innerHTML = '<option value="">--</option>';

            if (Array.isArray(data) && data.length > 0) {
                data.forEach((item) => {
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.textContent = item.name;
                    referenceSelect.appendChild(option);
                });
                referenceSelect.disabled = false;

                const oldWrapper = document.querySelector(
                    `[data-for="${referenceSelect.id}"]`
                );
                if (oldWrapper) oldWrapper.remove();
                window.SpecialSearch(referenceSelect);

                if (selectedValue) {
                    referenceSelect.value = selectedValue;

                    const referenceWrapper = document.querySelector(
                        `[data-for="${referenceSelect.id}"]`
                    );
                    const searchInput =
                        referenceWrapper?.querySelector(".tag-input");

                    if (searchInput && selectedValue) {
                        // searchInput.value = selectedValue.trim();

                        let referenceValue = data.find(
                            (item) => item.id == selectedValue
                        );
                        searchInput.value = referenceValue
                            ? referenceValue.name.trim()
                            : selectedValue.trim() || "";
                    }
                }
            } else {
                referenceSelect.disabled = true;
            }
        } catch (error) {
            console.error("Error loading data:", error);
        } finally {
            referenceSelect.parentElement.classList.remove("loading");
            document
                .getElementById(`${referenceId}-loader`)
                ?.classList.remove("show");
        }
    }

    if (action === "edit") {
        const constrainValue =
            constrainSelect.querySelector("select")?.value ||
            constrainSelect.dataset.value ||
            document.querySelector(`#${constrainId}`)?.value;

        const currentReferenceValue =
            document.querySelector(`#${referenceId}`)?.dataset.currentValue ||
            document.querySelector(`#${referenceId}`)?.value;

        if (constrainValue) {
            loadReferenceData(constrainValue, currentReferenceValue);
        }
    }

    async function handleSelection(e) {
        if (e.target.tagName !== "LI" || !constrainSelect.contains(e.target))
            return;
        const constrainValue = e.target.dataset.value;
        if (!constrainValue) return;

        loadReferenceData(constrainValue);
    }

    if (action === "create") {
        constrainSelect.addEventListener("click", handleSelection);
    }

    const constrainSearchInput = constrainSelect.querySelector(".tag-input");
    if (constrainSearchInput) {
        constrainSearchInput.addEventListener("input", function () {
            if (!this.value) {
                referenceSelect.innerHTML = '<option value="">--</option>';
                referenceSelect.disabled = true;
            }
        });
    }
}
