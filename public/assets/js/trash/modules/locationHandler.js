// public/assets/js/modules/locationHandler.js
document.addEventListener("DOMContentLoaded", () => {
    const { getSelect, getInput, getSelectedIds } = DomUtils;
    const { resetDependentTags } = TagUtils;

    const country = getSelect("country_id");
    const state = getSelect("state_id");
    const city = getSelect("city_id");
    const allStates = getSelect("all_states");
    const allCities = getSelect("all_cities");

    let isLoading = false;

    country?.addEventListener("updatedSelect", async () => {
        if (isLoading) return;
        isLoading = true;

        const countryId = getInput("country_id")?.dataset.id;
        await resetDependentTags("state_id", getInput("city_id"));

        if (allStates?.checked)
            await filterByForeignId(
                "country_id",
                "city",
                "city_id"
            ).loadReferenceData(countryId);
        else
            await filterByForeignId(
                "country_id",
                "state",
                "state_id"
            ).loadReferenceData(countryId);

        isLoading = false;
    });

    state?.addEventListener("multiSelectUpdated", async () =>
        handleStateChange()
    );
    allStates?.addEventListener("change", async () => handleStateChange());
    allCities?.addEventListener("change", async () => handleStateChange());

    async function handleStateChange() {
        if (isLoading) return;
        isLoading = true;

        const stateIds = getSelectedIds("state_id[]");
        const countryId = getInput("country_id")?.dataset.id;
        await resetDependentTags("state_id", getInput("city_id"));

        if (allStates?.checked || allCities?.checked)
            await filterByForeignId(
                "country_id",
                "city",
                "city_id"
            ).loadReferenceData(countryId);
        else if (stateIds.length)
            await filterByForeignId(
                "state_id",
                "city",
                "city_id"
            ).loadReferenceData(stateIds);
        else city.innerHTML = '<option value="">--</option>';

        isLoading = false;
    }
});
