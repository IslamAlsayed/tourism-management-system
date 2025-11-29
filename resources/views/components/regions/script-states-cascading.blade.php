@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // ========================================
            // HELPER FUNCTIONS
            // ========================================
            const getSelect = (id) => document.getElementById(id);
            const getInput = (key) => document.querySelector(`[data-for='${key}'] .tag-input`);

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
            const citySelect = getSelect("city_id");
            const allCities = getSelect("all_cities");

            if (!countrySelect || !citySelect) return;

            // STATE MANAGEMENT
            let isLoading = false;

            // ========================================
            // MAIN LOGIC
            // ========================================
            async function handleStateChange(triggerType) {
                const countryId = getInput("country_id")?.dataset.id;

                await resetDependentTags("country_id", getInput("city_id"));

                if (allCities && allCities?.checked) {
                    citySelect.disabled = true;
                    getSelect("city_id").nextElementSibling?.classList.add('loading');
                    await loadData("country_id", "city", "city_id", countryId);
                    return;
                }

                stateSelect.disabled = false;
                getSelect("country_id").nextElementSibling?.classList.remove('loading');

                if (allCities && allCities?.checked) {
                    citySelect.disabled = true;
                    citySelect.innerHTML = '<option value="">--</option>';
                    getSelect("city_id")?.nextElementSibling.classList.add('loading');
                    return;
                }

                citySelect.disabled = false;
                getSelect("city_id")?.nextElementSibling.classList.remove('loading');
                await loadData("country_id", "city", "city_id", countryId);
            }

            // ========================================
            // EVENT HANDLERS
            // ========================================
            if (!countrySelect.dataset.bound) {
                countrySelect.dataset.bound = "true";
                countrySelect?.addEventListener("updatedSelect", async () => {
                    if (isLoading) return;
                    isLoading = true;

                    const countryId = getInput("country_id")?.dataset.id;

                    if (!countryId) {
                        citySelect.innerHTML = '<option value="">--</option>';
                        getSelect("city_id").nextElementSibling?.classList.add('loading');
                        document.querySelectorAll(`input[name='city_id[]']`).forEach(i => i
                            .remove());
                        isLoading = false;
                        return;
                    }

                    if (allCities && allCities?.checked) {
                        citySelect.disabled = true;
                        getSelect("city_id").nextElementSibling?.classList.add('loading');
                        await loadData("country_id", "city", "city_id", countryId);
                    } else {
                        citySelect.disabled = false;
                        getSelect("city_id").nextElementSibling?.classList.remove('loading');
                        await loadData("country_id", "city", "city_id", countryId);
                    }

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
                        const countryId = getInput("country_id")?.dataset.id;
                        if (countryId) await loadData("country_id", "city", "city_id", countryId);
                    }
                });
            }
        });
    </script>
@endpush
