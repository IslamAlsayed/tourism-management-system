@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // ========================================
            // HELPER FUNCTIONS
            // ========================================
            const getSelect = (id) => document.getElementById(id);
            const getInput = (key) => document.querySelector(`[data-for='${key}'].tag - input`);

            const getSelectedIds = (name) => {
                return [...document.querySelectorAll(`input[name='${name}']`)]
                    .map(input => input.value)
                    .filter(v => v !== "");
            };

            const loadData = async (fromId, model, toId, value, append = false) => {
                const ref = filterByForeignId(fromId, model, toId);
                if (ref && typeof ref.loadReferenceData === "function") {
                    await ref.loadReferenceData(value, append);
                }
            };

            // ========================================
            // DOM ELEMENTS
            // ========================================
            const countrySelect = getSelect("country_id");
            const stateSelect = getSelect("state_id");
            const citySelect = getSelect("city_id");
            const allStates = getSelect("all_states");
            const allCities = getSelect("all_cities");

            if (!countrySelect || !stateSelect || !citySelect) return;

            // STATE MANAGEMENT
            let isLoading = false;

            // ========================================
            // MAIN LOGIC
            // ========================================
            async function handleStateChange(triggerType) {
                let stateIds = getSelectedIds("state_id[]");
                let countryId = getInput("country_id")?.dataset.id;

                await resetDependentTags("state_id", getInput("city_id"));

                if (allStates && allStates?.checked) {
                    stateSelect.disabled = true;
                    getSelect("state_id").nextElementSibling?.classList.add('loading');
                    await loadData("country_id", "city", "city_id", countryId);
                    return;
                }
                stateSelect.disabled = false;
                getSelect("state_id").nextElementSibling?.classList.remove('loading');

                if (stateIds.length == 0) {
                    citySelect.disabled = false;
                    citySelect.innerHTML = '<option value="">--</option>';
                    getSelect("city_id")?.parentElement.classList.add('loading');
                    document.getElementById(`city_id-info`)?.classList.add("show");
                    const label = document.getElementById("city_id")?.parentElement.querySelector(
                        ".dataLength");
                    if (label) label.innerText = '';
                    stateIds = getInput("state_id")?.dataset.id;
                }

                if (stateIds.length > 0) {
                    if (globalRequestCache.has("state_id_city_city_id")) {
                        globalRequestCache.delete("state_id_city_city_id");
                    }
                    citySelect.disabled = false;
                    getSelect("city_id")?.nextElementSibling.classList.remove('loading');
                    await loadData("state_id", "city", "city_id", stateIds);
                }

                if (allCities && allCities?.checked) {
                    citySelect.disabled = true;
                    citySelect.innerHTML = '<option value="">--</option>';
                    getSelect("city_id")?.nextElementSibling.classList.add('loading');
                    return;
                }
            }

            // ========================================
            // EVENT HANDLERS
            // ========================================
            if (!countrySelect.dataset.bound) {
                countrySelect.dataset.bound = "true";

                // For single select (updatedSelect event)
                countrySelect?.addEventListener("updatedSelect", async () => {
                    if (isLoading) return;
                    isLoading = true;

                    let countryId = getInput("country_id")?.dataset.id;

                    if (!countryId) {
                        stateSelect.innerHTML = '<option value="">--</option>';
                        citySelect.innerHTML = '<option value="">--</option>';
                        getSelect("state_id").nextElementSibling?.classList.add('loading');
                        document.querySelectorAll(`input[name='state_id[]'] `).forEach(i => i.remove());
                        isLoading = false;
                        return;
                    }

                    if (allStates && allStates?.checked) {
                        stateSelect.disabled = true;
                        getSelect("state_id").nextElementSibling?.classList.add('loading');
                        await loadData("country_id", "city", "city_id", countryId);
                    } else {
                        stateSelect.disabled = false;
                        getSelect("state_id").nextElementSibling?.classList.remove('loading');
                        await loadData("country_id", "state", "state_id", countryId);
                    }

                    isLoading = false;
                });
            }

            if (!stateSelect.dataset.bound) {
                stateSelect.dataset.bound = "true";

                // For multi select (updatedSelect event)
                stateSelect?.addEventListener("updatedSelect", async () => {
                    if (isLoading) return;
                    isLoading = true;
                    getSelect("city_id").nextElementSibling?.classList.add('loading');
                    document.querySelectorAll(`input[name='city_id[]']`).forEach(i => i.remove());

                    let stateIds = getSelectedIds("state_id[]");
                    if (stateIds.length == 0) {
                        citySelect.innerHTML = '<option value="">--</option>';
                        stateIds = getInput("state_id")?.dataset.id;
                        isLoading = false;
                    }

                    citySelect.disabled = false;
                    getSelect("city_id")?.nextElementSibling.classList.remove(
                        'loading');
                    await loadData("state_id", "city", "city_id", stateIds);
                    isLoading = false;
                });

                // For multi select (multiSelectUpdated event)
                stateSelect?.addEventListener("multiSelectUpdated", async () => {
                    if (isLoading) return;
                    isLoading = true;
                    await handleStateChange("multiSelectUpdated");
                    isLoading = false;
                });
            }

            if (allStates && !allStates.dataset.bound) {
                allStates.dataset.bound = "true";
                allStates?.addEventListener("change", async () => {
                    if (isLoading) return;
                    isLoading = true;

                    // getSelect("city_id").nextElementSibling?.classList.add('loading');
                    // document.querySelectorAll(`input[name='city_id[]']`).forEach(i => i.remove());
                    await handleStateChange("allStatesChange");
                    isLoading = false;
                });
            }

            if (allCities && !allCities.dataset.bound) {
                allCities.dataset.bound = "true";
                allCities?.addEventListener("change", async () => {
                    if (allCities.checked) {
                        citySelect.disabled = true;
                        getSelect("city_id")?.nextElementSibling.classList.add('loading');
                    } else {
                        citySelect.disabled = false;
                        getSelect("city_id")?.nextElementSibling.classList.remove('loading');
                        const stateId = getInput("state_id")?.dataset.id;
                        if (stateId) await loadData("state_id", "city", "city_id", stateIds);
                    }
                });
            }
        });
    </script>
@endpush
