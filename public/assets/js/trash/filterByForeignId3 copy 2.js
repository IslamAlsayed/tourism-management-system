/**
 * filterByForeignId - improved version
 *
 * Features:
 * - Instance registry: window._fbfiInstances to avoid duplicate instances per constrainId
 * - AbortController per instance to cancel previous fetch when a new one starts
 * - Skip duplicate requests (same args while one in-flight)
 * - Respect window.replaceForeignKeys mapping
 * - Safe load-on-edit logic (only runs once per instance)
 */

(function () {
    // registry to keep instances
    window._fbfiInstances = window._fbfiInstances || {};

    // helper getters (used across)
    const getSelect = (id) => document.getElementById(id);
    const getInput = (key) =>
        document.querySelector(`[data-for='${key}'] .tag-input`);
    const getHiddenInputValues = (name) => {
        const hiddenInputs = document.querySelectorAll(
            `input[name="${name}[]"][type="hidden"]`,
        );
        return Array.from(hiddenInputs).map((input) => ({
            id: input.value,
            name: input.dataset.name,
        }));
    };
    const setTagsFromHiddenInputs = async (selectId) => {
        let parentIds = getHiddenInputValues(selectId);
        if (parentIds.length === 0) return;
        const wrapper = document.querySelector(
            `[data-for='${selectId}'] .tag-container`,
        );
        if (!wrapper)
            return console.error(`Tag container not found for ${selectId}`);
        parentIds.forEach((item) => {
            if (document.querySelector(`.tag-item[data-id='${item.id}']`))
                return;
            const tag = document.createElement("span");
            tag.classList.add("tag-item");
            tag.textContent = item.name || item.text || item.id;
            tag.dataset.id = item.id;
            tag.dataset.name = item.name || item.text || item.id;
            const cross = document.createElement("span");
            cross.classList.add("cross");
            cross.textContent = "×";
            tag.appendChild(cross);
            cross.addEventListener("click", () => {
                tag.remove();
                // custom event to let multi-select listeners update
                const event = new CustomEvent("multiSelectUpdated", {
                    detail: { name: item.name, tagId: item.id },
                });
                const sel = getSelect(selectId);
                if (sel) sel.dispatchEvent(event);
                // remove corresponding hidden input
                const inputHidden = document.querySelector(
                    `input[name="${selectId}[]"][type="hidden"][value="${item.id}"]`,
                );
                if (inputHidden) inputHidden.remove();
            });
            wrapper.prepend(tag);
        });
    };

    // Main factory
    window.filterByForeignId = function (
        constrainId,
        reference,
        referenceId,
        action = "create",
    ) {
        // if instance already exists -> return it (prevents duplicating listeners and logic)
        if (window._fbfiInstances[constrainId]) {
            return window._fbfiInstances[constrainId];
        }

        // LOCAL STATE for this instance
        const instance = {
            constrainId,
            reference,
            referenceId,
            action,
            abortController: null,
            inFlightKey: null, // key describing last in-flight request
            initialized: false,
        };

        const constrainWrapperSelector = `[data-for="${constrainId}"]`;
        const referenceSelect = () => document.getElementById(referenceId);
        const refWrapper = () =>
            document.querySelector(`[data-for="${referenceId}"]`);

        // helper to compute used foreign key (with replace)
        const getUsedForeignKey = (origKey) => {
            return window.replaceForeignKeys?.[origKey] || origKey;
        };

        // Build a simple string key to dedupe similar requests
        const buildRequestKey = (fk, fkValue, append) => {
            let v;
            if (Array.isArray(fkValue)) v = fkValue.join(",");
            else v = String(fkValue ?? "");
            return `${fk}|${v}|${append ? "a" : "n"}`;
        };

        async function loadReferenceData(
            constrainValue,
            selectedValue = null,
            append = false,
        ) {
            const refSelect = referenceSelect();
            if (!refSelect) return;

            // normalize constrainValue
            let constrainValues = constrainValue;
            if (Array.isArray(constrainValue)) {
                constrainValues = constrainValue
                    .toString()
                    .split(",")
                    .filter((v) => v)
                    .map((v) => parseInt(v));
            }

            const usedFk = getUsedForeignKey(constrainId);

            // Build request key and skip if same as current in-flight
            const key = buildRequestKey(usedFk, constrainValues, append);
            if (instance.inFlightKey && instance.inFlightKey === key) {
                // same request already in flight -> skip
                return;
            }

            // abort previous request if any
            if (instance.abortController) {
                try {
                    instance.abortController.abort();
                } catch (e) {}
            }
            instance.abortController = new AbortController();
            instance.inFlightKey = key;

            // UI: show loaders
            document
                .getElementById(`${referenceId}-info`)
                ?.classList.add("show");
            refSelect.parentElement?.classList.add("loading");
            document
                .getElementById(`${referenceId}-loader`)
                ?.classList.add("show");
            document
                .getElementById(`${referenceId}-info`)
                ?.classList.remove("show");

            try {
                const body = JSON.stringify({
                    _token: document.querySelector('meta[name="csrf-token"]')
                        ?.content,
                    model: reference,
                    foreignKey: usedFk,
                    foreignKeyValue: constrainValues,
                });

                const resp = await fetch("/api/get-references", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                    body: body,
                    credentials: "same-origin",
                    signal: instance.abortController.signal,
                });

                if (!resp.ok) throw new Error("Request failed");

                const data = await resp.json();

                // update label count
                const label = document
                    .querySelector(`#${referenceId}`)
                    ?.parentElement?.querySelector(".dataLength");
                if (label) label.innerText = `(${data?.data?.length || 0})`;

                if (!append)
                    refSelect.innerHTML = '<option value="">--</option>';

                if (Array.isArray(data.data) && data.data.length > 0) {
                    data.data.forEach((item) => {
                        const option = document.createElement("option");
                        option.value = item.id;
                        option.textContent = item.name;
                        refSelect.appendChild(option);
                    });
                    refSelect.disabled = false;

                    // notify other components (your code expects updatedPaginate)
                    document.dispatchEvent(
                        new CustomEvent("updatedPaginate", {
                            detail: { id: referenceId },
                        }),
                    );
                    // re-init special search/select
                    const oldWrapper = document.querySelector(
                        `[data-for="${refSelect.id}"]`,
                    );
                    if (oldWrapper) oldWrapper.remove();

                    if (!refSelect.hasAttribute("special-multiple")) {
                        if (window.specialSearch)
                            window.specialSearch(refSelect);
                    } else if (window.specialSelect) {
                        window.specialSelect(refSelect);
                    }

                    // set selected value if provided
                    if (selectedValue && !Array.isArray(selectedValue)) {
                        refSelect.value = selectedValue;
                        const wrapper = document.querySelector(
                            `[data-for="${refSelect.id}"]`,
                        );
                        const searchInput =
                            wrapper?.querySelector(".tag-input");
                        if (searchInput) {
                            const selected = data.data.find(
                                (i) => i.id == selectedValue,
                            );
                            searchInput.dataset.id = selectedValue;
                            searchInput.value = selected ? selected.name : "";
                        }
                    }
                } else {
                    refSelect.disabled = true;
                }
            } catch (err) {
                if (err.name === "AbortError") {
                    // aborted on purpose — ignore silently
                } else {
                    console.error("Error loading data:", err);
                }
            } finally {
                // clear UI state (small timeout to avoid flicker)
                setTimeout(() => {
                    try {
                        document
                            .getElementById(`${referenceId}-loader`)
                            ?.classList.remove("show");
                        refSelect.parentElement?.classList.remove("loading");
                        document
                            .getElementById(`${referenceId}-info`)
                            ?.classList.remove("show");
                    } catch (e) {}
                }, 120);
                // allow future identical requests
                instance.inFlightKey = null;
            }
        } // end loadReferenceData

        // attach delegated click (only once per instance)
        function attachDelegatedClick() {
            if (instance._clickAttached) return;
            document.addEventListener("click", (e) => {
                const li = e.target.closest?.("li");
                if (!li) return;
                const wrapper = li.closest(constrainWrapperSelector);
                if (!wrapper) return;
                const constrainValue = li.dataset.value;
                if (!constrainValue) return;
                loadReferenceData(constrainValue);
            });
            instance._clickAttached = true;
        }

        // attach change listener for native select of constrainId (only once per instance)
        function attachChangeListener() {
            if (instance._changeAttached) return;
            document.addEventListener("change", (e) => {
                const sel = e.target;
                if (!(sel instanceof HTMLSelectElement)) return;
                if (sel.id !== constrainId) return;
                if (!sel.value) {
                    clearDependents(constrainId);
                } else {
                    loadReferenceData(sel.value);
                }
            });
            instance._changeAttached = true;
        }

        // clearDependents reused from your code (safe copy)
        function clearDependents(fromId) {
            const hierarchy = [
                "region_id",
                "subregion_id",
                "country_id",
                "state_id",
                "city_id",
            ];
            const fromIndex = hierarchy.indexOf(fromId);
            if (fromIndex === -1) return;
            for (let i = fromIndex + 1; i < hierarchy.length; i++) {
                const sel = document.getElementById(hierarchy[i]);
                if (sel) {
                    sel.innerHTML = '<option value="">--</option>';
                    sel.disabled = true;
                    const wrapper = document.querySelector(
                        `[data-for="${hierarchy[i]}"]`,
                    );
                    if (wrapper) {
                        wrapper.parentElement?.classList.add("loading");
                        const input = wrapper.querySelector(".tag-input");
                        if (input) input.value = "";
                        wrapper
                            .querySelectorAll(".tag-item")
                            ?.forEach((t) => t.remove());
                    }
                    const label = document
                        .querySelector(`#${hierarchy[i]}`)
                        ?.parentElement?.querySelector(".dataLength");
                    if (label) label.innerText = "";
                    document
                        .getElementById(`${hierarchy[i]}-info`)
                        ?.classList.add("show");
                }
            }
        }

        // input watcher on special-search's tag-input to clear dependents if cleared
        function attachSearchWatcher() {
            const wrapper = document.querySelector(constrainWrapperSelector);
            const searchInput = wrapper?.querySelector(".tag-input");
            if (!searchInput) return;
            if (searchInput._watchAttached) return;
            searchInput.addEventListener("input", function () {
                if (!this.value.trim()) clearDependents(constrainId);
            });
            searchInput._watchAttached = true;
        }

        // load edit hierarchy — careful to run once only
        async function runEditLoadIfNeeded() {
            if (instance._editLoaded) return;
            instance._editLoaded = true;

            const getVal = (id) =>
                document.querySelector(`#${id}`)?.dataset.currentValue ||
                document.querySelector(`#${id}`)?.value;

            const regionVal = getVal("region_id");
            const subregionVal = getVal("subregion_id");
            const countryVal = getVal("country_id");
            const stateVal = getVal("state_id");
            const cityVal = getVal("city_id");

            // region -> subregion
            if (regionVal) {
                await loadReferenceData(regionVal, subregionVal);
            }

            // subregion -> country (if any)
            if (subregionVal) {
                // if country exists we load countries, otherwise we rely on replace logic (see below)
                await filterByForeignId(
                    "subregion_id",
                    "country",
                    "country_id",
                ).loadReferenceData(subregionVal, countryVal);
            }

            // parent for states: prefer country, otherwise subregion (replace logic)
            const parentForState = countryVal || subregionVal;
            const parentKeyForState = countryVal
                ? "country_id"
                : "subregion_id";

            if (parentForState) {
                await filterByForeignId(
                    parentKeyForState,
                    "state",
                    "state_id",
                ).loadReferenceData(parentForState, stateVal);

                // set states tags
                await setTagsFromHiddenInputs("state_id");
                const stateIds = getHiddenInputValues("state_id").map(
                    (x) => x.id,
                );
                if (stateIds.length > 0) {
                    await setTagsFromHiddenInputs("city_id");
                }
            }

            // state -> city
            if (stateVal) {
                await filterByForeignId(
                    "state_id",
                    "city",
                    "city_id",
                ).loadReferenceData(stateVal, cityVal);
                await setTagsFromHiddenInputs("city_id");
            }
        }

        // Expose instance API
        const api = {
            loadReferenceData,
            _internal: instance,
        };

        // Attach listeners and watchers
        attachDelegatedClick();
        attachChangeListener();
        attachSearchWatcher();

        // If action === edit, run the edit loader (once)
        if (action === "edit") {
            // small delay to ensure DOM special-search initializers run
            setTimeout(
                () => runEditLoadIfNeeded().catch((err) => console.error(err)),
                60,
            );
        }

        // store instance and return API
        window._fbfiInstances[constrainId] = api;
        return api;
    }; // end filterByForeignId
})();
