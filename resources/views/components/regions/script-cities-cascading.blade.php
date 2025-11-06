@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // ========================================
            // HELPER FUNCTIONS
            // ========================================
            const getSelect = (id) => document.getElementById(id);
            const getInput = (key) => document.querySelector(`[data-for='${key}'] .tag-input`);

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
            const allStates = getSelect("all_states");

            if (!countrySelect || !stateSelect) return;

            // STATE MANAGEMENT
            let isLoading = false;

            // ========================================
            // MAIN LOGIC
            // ========================================
            async function handleStateChange(triggerType) {
                const countryId = getInput("country_id")?.dataset.id;

                await resetDependentTags("country_id", getInput("state_id"));

                if (allStates && allStates?.checked) {
                    stateSelect.disabled = true;
                    getSelect("state_id").nextElementSibling?.classList.add('loading');
                    await loadData("country_id", "state", "state_id", countryId);
                    return;
                }

                stateSelect.disabled = false;
                getSelect("state_id").nextElementSibling?.classList.remove('loading');

                if (allStates && allStates?.checked) {
                    stateSelect.disabled = true;
                    stateSelect.innerHTML = '<option value="">--</option>';
                    getSelect("state_id")?.nextElementSibling.classList.add('loading');
                    return;
                }

                stateSelect.disabled = false;
                getSelect("state_id")?.nextElementSibling.classList.remove('loading');
                await loadData("country_id", "state", "state_id", countryId);
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
                        stateSelect.innerHTML = '<option value="">--</option>';
                        getSelect("state_id").nextElementSibling?.classList.add('loading');
                        document.querySelectorAll(`input[name='state_id[]']`).forEach(i => i.remove());
                        isLoading = false;
                        return;
                    }

                    if (allStates && allStates?.checked) {
                        stateSelect.disabled = true;
                        getSelect("state_id").nextElementSibling?.classList.add('loading');
                        await loadData("country_id", "state", "state_id", countryId);
                    } else {
                        stateSelect.disabled = false;
                        getSelect("state_id").nextElementSibling?.classList.remove('loading');
                        await loadData("country_id", "state", "state_id", countryId);
                    }

                    isLoading = false;
                });
            }

            if (allStates && !allStates.dataset.bound) {
                allStates.dataset.bound = "true";
                allStates?.addEventListener("change", async () => {
                    if (allStates.checked) {
                        stateSelect.disabled = true;
                        getSelect("state_id")?.nextElementSibling.classList.add('loading');
                    } else {
                        stateSelect.disabled = false;
                        getSelect("state_id")?.nextElementSibling.classList.remove('loading');
                    }
                });
            }
        });
    </script>
@endpush
