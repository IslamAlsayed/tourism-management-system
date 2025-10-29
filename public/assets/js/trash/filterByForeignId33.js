/**
 * filterByForeignId v2
 * - Backwards compatible: calling filterByForeignId(constrainId, reference, referenceId, action)
 * - Uses data- attributes if present on selects (data-api, data-foreign-key, data-model, data-next)
 * - Prevents duplicate/concurrent requests via AbortController + dedupe key
 * - Supports specialSearch and specialSelect initialization hooks if available on window
 * - Supports edit initialization via data-current-value and hidden inputs
 */

(function () {
    window._fbfiInstances = window._fbfiInstances || {};

    const getSelect = (id) => document.getElementById(id);
    const getWrapper = (id) => document.querySelector(`[data-for="${id}"]`);
    const getInput = (key) =>
        document.querySelector(`[data-for='${key}'] .tag-input`);
    const getHiddenInputs = (name) => {
        return Array.from(
            document.querySelectorAll(`input[name="${name}[]"][type="hidden"]`),
        ).map((i) => ({ id: i.value, name: i.dataset.name }));
    };

    function normalizeValues(val) {
        if (val === null || val === undefined) return null;
        if (Array.isArray(val)) return val;
        if (typeof val === "string" && val.indexOf(",") !== -1) {
            return val
                .split(",")
                .map((v) => v.trim())
                .filter(Boolean);
        }
        return val;
    }

    window.filterByForeignId = function (
        constrainId,
        reference,
        referenceId,
        action = "create",
    ) {
        // return existing instance if exists (prevents duplicate listeners)
        if (window._fbfiInstances[constrainId])
            return window._fbfiInstances[constrainId];

        const instance = {
            constrainId,
            reference,
            referenceId,
            action,
            abortController: null,
            inFlightKey: null,
            editLoaded: false,
        };

        const constrainWrapperSelector = `[data-for="${constrainId}"]`;
        const referenceSelect = () => document.getElementById(referenceId);
        const constrainSelect = () => document.getElementById(constrainId);

        // compute used foreign key via replaceForeignKeys or data-foreign-key on reference element
        const getUsedForeignKey = (orig) => {
            // prefer explicit dataset on reference element
            const refEl = referenceSelect();
            if (refEl && refEl.dataset && refEl.dataset.foreignKey)
                return refEl.dataset.foreignKey;
            return window.replaceForeignKeys?.[orig] || orig;
        };

        const buildKey = (fk, fkValue, append) => {
            const v = Array.isArray(fkValue)
                ? fkValue.join(",")
                : String(fkValue ?? "");
            return `${fk}|${v}|${append ? "a" : "n"}`;
        };

        async function fetchReferences(
            usedFk,
            usedModel,
            fkValue,
            append = false,
        ) {
            // decide API: element may override via data-api
            const refEl = referenceSelect();
            const apiUrl =
                refEl && refEl.dataset && refEl.dataset.api
                    ? refEl.dataset.api
                    : "/api/get-references";

            const payload = {
                _token: document.querySelector('meta[name="csrf-token"]')
                    ?.content,
                model: usedModel,
                foreignKey: usedFk,
                foreignKeyValue: fkValue,
            };

            // abort previous
            if (instance.abortController) {
                try {
                    instance.abortController.abort();
                } catch (e) {}
            }
            instance.abortController = new AbortController();

            const key = buildKey(usedFk, fkValue, append);
            if (instance.inFlightKey && instance.inFlightKey === key) {
                // identical request in flight -> skip
                return null;
            }
            instance.inFlightKey = key;

            const resp = await fetch(apiUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify(payload),
                credentials: "same-origin",
                signal: instance.abortController.signal,
            });
            if (!resp.ok) throw new Error("Request failed");
            const json = await resp.json();
            instance.inFlightKey = null;
            return json;
        }

        async function loadReferenceData(
            constrainValue,
            selectedValue = null,
            append = false,
        ) {
            const refSel = referenceSelect();
            if (!refSel) return;

            // UI show
            getWrapper(referenceId)?.parentElement?.classList.add("loading");
            document
                .getElementById(`${referenceId}-loader`)
                ?.style?.setProperty("display", "inline-block");
            document
                .getElementById(`${referenceId}-info`)
                ?.style?.setProperty("display", "none");

            // normalize
            const usedFk = getUsedForeignKey(constrainId);
            const model = refSel.dataset.model || reference;
            const normalized = normalizeValues(constrainValue);

            try {
                const data = await fetchReferences(
                    usedFk,
                    model,
                    normalized,
                    append,
                );
                // handle empty or error
                if (!data || !Array.isArray(data.data)) {
                    refSel.disabled = true;
                    return;
                }

                const label =
                    refSel.parentElement?.querySelector(".dataLength");
                if (label) label.innerText = `(${data.data.length})`;

                if (!append) refSel.innerHTML = '<option value="">--</option>';

                // append options
                data.data.forEach((item) => {
                    const o = document.createElement("option");
                    o.value = item.id;
                    o.textContent = item.name;
                    refSel.appendChild(o);
                });

                refSel.disabled = false;

                // trigger updatedPaginate event for externals
                document.dispatchEvent(
                    new CustomEvent("updatedPaginate", {
                        detail: { id: referenceId },
                    }),
                );

                // re-init special search/select if available
                const oldWrapper = document.querySelector(
                    `[data-for="${refSel.id}"]`,
                );
                if (oldWrapper) oldWrapper.remove();

                if (!refSel.hasAttribute("special-multiple")) {
                    if (window.specialSearch) window.specialSearch(refSel);
                } else if (window.specialSelect) {
                    window.specialSelect(refSel);
                }

                // set selected single value
                if (selectedValue && !Array.isArray(selectedValue)) {
                    refSel.value = selectedValue;
                    const wrapper = document.querySelector(
                        `[data-for="${refSel.id}"]`,
                    );
                    const searchInput = wrapper?.querySelector(".tag-input");
                    if (searchInput) {
                        const sel = data.data.find(
                            (i) => i.id == selectedValue,
                        );
                        searchInput.dataset.id = selectedValue;
                        searchInput.value = sel ? sel.name : "";
                    }
                }
            } catch (err) {
                if (err.name === "AbortError") {
                    // ignore
                } else {
                    console.error("Error loading data:", err);
                }
            } finally {
                setTimeout(() => {
                    try {
                        document
                            .getElementById(`${referenceId}-loader`)
                            ?.style?.setProperty("display", "none");
                        getWrapper(
                            referenceId,
                        )?.parentElement?.classList.remove("loading");
                        document
                            .getElementById(`${referenceId}-info`)
                            ?.style?.setProperty("display", "none");
                    } catch (e) {}
                }, 120);
            }
        } // end loadReferenceData

        // delegated click for special lists (LI elements)
        function attachDelegatedClick() {
            if (instance._clickAttached) return;
            document.addEventListener("click", (e) => {
                const li = e.target.closest?.("li");
                if (!li) return;
                const wrapper = li.closest(constrainWrapperSelector);
                if (!wrapper) return;
                const v = li.dataset.value;
                if (!v) return;
                loadReferenceData(v);
            });
            instance._clickAttached = true;
        }

        // change listener for native selects
        function attachChange() {
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

        // watcher for special-search input clearing
        function attachInputWatcher() {
            const wrapper = document.querySelector(constrainWrapperSelector);
            const inp = wrapper?.querySelector(".tag-input");
            if (!inp || inp._watchAttached) return;
            inp.addEventListener("input", function () {
                if (!this.value.trim()) clearDependents(constrainId);
            });
            inp._watchAttached = true;
        }

        // load sequence on edit (runs once)
        async function runEditSequence() {
            if (instance.editLoaded) return;
            instance.editLoaded = true;

            const getVal = (id) => {
                const el = document.querySelector(`#${id}`);
                if (!el) return null;
                return el.dataset.currentValue ?? el.value ?? null;
            };

            const regionVal = getVal("region_id");
            const subregionVal = getVal("subregion_id");
            const countryVal = getVal("country_id");
            const stateVal = getVal("state_id");
            const cityVal = getVal("city_id");

            // region -> subregion
            if (regionVal) await loadReferenceData(regionVal, subregionVal);

            // subregion -> country (if exist)
            if (subregionVal) {
                await filterByForeignId(
                    "subregion_id",
                    "country",
                    "country_id",
                ).loadReferenceData(subregionVal, countryVal);
            }

            // parent for state: prefer country else subregion
            const parentForState = countryVal || subregionVal;
            const parentKey = countryVal ? "country_id" : "subregion_id";
            if (parentForState) {
                await filterByForeignId(
                    parentKey,
                    "state",
                    "state_id",
                ).loadReferenceData(parentForState, stateVal);

                // handle all_states/all_cities UI
                const allStates = document.getElementById("all_states");
                const stEl = document.getElementById("state_id");
                if (allStates?.checked) {
                    if (stEl) stEl.disabled = true;
                    stEl?.nextElementSibling?.classList.add("loading");
                } else {
                    if (stEl) stEl.disabled = false;
                    stEl?.nextElementSibling?.classList.remove("loading");
                }

                const allCities = document.getElementById("all_cities");
                const ctEl = document.getElementById("city_id");
                if (allCities?.checked) {
                    if (ctEl) ctEl.disabled = true;
                    ctEl?.nextElementSibling?.classList.add("loading");
                } else {
                    if (ctEl) ctEl.disabled = false;
                    ctEl?.nextElementSibling?.classList.remove("loading");
                }

                // set tags
                await setTagsFromHiddenInputs("state_id");
                const sids = getHiddenInputs("state_id").map((x) => x.id);
                if (sids.length > 0) await setTagsFromHiddenInputs("city_id");
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

        // expose API
        const api = { loadReferenceData, _instance: instance };

        // attach listeners
        attachDelegatedClick();
        attachChange();
        attachInputWatcher();

        // if edit mode -> start init after small delay (allow special-inits to run)
        if (action === "edit") {
            setTimeout(
                () => runEditSequence().catch((err) => console.error(err)),
                80,
            );
        }

        window._fbfiInstances[constrainId] = api;
        return api;
    }; // end filterByForeignId

    // helper: clearDependents (kept compatible)
    window.clearDependents = function (fromId) {
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
                    ?.style?.setProperty("display", "inline-block");
            }
        }
    };

    // helper: setTagsFromHiddenInputs (kept compatible)
    window.setTagsFromHiddenInputs = async function (selectId) {
        const parentIds = getHiddenInputs(selectId);
        if (!parentIds.length) return;
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
            tag.textContent = item.name || item.id;
            tag.dataset.id = item.id;
            const cross = document.createElement("span");
            cross.classList.add("cross");
            cross.textContent = "×";
            tag.appendChild(cross);
            cross.addEventListener("click", () => {
                tag.remove();
                const inputHidden = document.querySelector(
                    `input[name="${selectId}[]"][type="hidden"][value="${item.id}"]`,
                );
                if (inputHidden) inputHidden.remove();
                const event = new CustomEvent("multiSelectUpdated", {
                    detail: { name: item.name, tagId: item.id },
                });
                const sel = document.getElementById(selectId);
                if (sel) sel.dispatchEvent(event);
            });
            wrapper.prepend(tag);
        });
    };
}); // IIFE
