//  Global cache - accessible from other files
window.globalRequestCache = window.globalRequestCache || new Map();
const globalRequestCache = window.globalRequestCache;
const filterByForeignIdInstances = {};
//  Mapping من constrainId للـ reference الحالي عشان نلاقي الـ instance الصح
const constrainIdToReference = {};

function filterByForeignId(
    constrainId,
    reference,
    referenceId,
    action = "create",
) {
    const constrainWrapperSelector = `[data-for="${constrainId}"]`;
    const referenceSelect = () => document.getElementById(referenceId);

    let initializing = action == "edit";
    //  استخدم constrainId + reference عشان لو نفس الـ constrainId بس model مختلف
    const instanceKey = `${constrainId}_${reference}_${referenceId}`;
    if (filterByForeignIdInstances[instanceKey]) {
        return filterByForeignIdInstances[instanceKey];
    }

    // دالة تحمل البيانات من السيرفر
    async function loadReferenceData(
        constrainValue,
        selectedValue = null,
        append = false,
    ) {
        //  إضافة context للكاش عشان نفرق بين الطلبات
        const context = `${reference}_${referenceId}`;
        const cacheKey = `${constrainId}_${context}`;

        // لو الطلب بنفس القيمه لسه شغال → تجاهله
        const existing = globalRequestCache.get(cacheKey);
        if (existing?.pending) {
            if (window.APP_DEBUG)
                console.log("⏳ Ignored duplicate pending request");
            return;
        }

        //  نقارن القيمة بشكل صحيح (array vs array)
        // لو آخر طلب بنفس القيمه خلص → تجاهله
        // ⚠️ لكن لو الكاش فيه قيمة قديمة والقيمة الجديدة مختلفة، نسمح بالطلب
        if (existing?.value) {
            const oldValue = Array.isArray(existing.value)
                ? existing.value.sort().join(",")
                : String(existing.value);
            const newValue = Array.isArray(constrainValue)
                ? constrainValue.sort().join(",")
                : String(constrainValue);

            //  نسمح بالطلب لو:
            // 1. القيمة اتغيرت
            // 2. في append mode (عشان all states/cities)
            // 3. النوع اتغير من array لـ single أو العكس
            // 4. الـ append mode اتغير
            const typeChanged =
                Array.isArray(existing.value) !== Array.isArray(constrainValue);
            const appendChanged = existing.append !== append;

            if (oldValue == newValue && !appendChanged && !typeChanged) {
                if (window.APP_DEBUG)
                    console.log(" Ignored duplicate completed request");
                return;
            } else {
                if (window.APP_DEBUG)
                    console.log(
                        "🔄 Value changed or mode changed, clearing cache",
                    );
                globalRequestCache.delete(cacheKey);
            }
        }

        globalRequestCache.set(cacheKey, {
            pending: true,
            value: constrainValue,
            append: append,
        });

        document.getElementById(`${referenceId}-info`)?.classList.add("show");

        const refSelect = referenceSelect();
        if (!refSelect) return;

        refSelect.parentElement?.classList.add("loading");
        if (refSelect) {
            document
                .getElementById(`${referenceId}-loader`)
                ?.classList.add("show");

            document
                .getElementById(`${referenceId}-info`)
                ?.classList.remove("show");
        }

        try {
            // Process constrainValue properly
            let constrainValues;

            if (Array.isArray(constrainValue)) {
                // If it's already an array, just filter and map to integers
                constrainValues = constrainValue
                    .filter((v) => v !== null && v !== undefined && v !== "")
                    .map((v) => parseInt(v));
            } else if (typeof constrainValue == "string") {
                // If it's a string, split by comma first
                constrainValues = constrainValue
                    .split(",")
                    .filter((v) => v.trim())
                    .map((v) => parseInt(v.trim()));
            } else if (typeof constrainValue == "number") {
                // If it's a single number, wrap it in an array
                constrainValues = [constrainValue];
            } else {
                constrainValues = constrainValue;
            }

            // Check if constrainValues is empty or invalid
            if (
                !constrainValues ||
                (Array.isArray(constrainValues) &&
                    constrainValues.length == 0) ||
                constrainValues == "" ||
                constrainValues == null ||
                constrainValues == undefined
            ) {
                if (window.APP_DEBUG)
                    console.log(
                        "⚠️ No valid constrain values, skipping API call",
                    );
                refSelect.innerHTML = '<option value="">--</option>';
                refSelect.disabled = true;
                globalRequestCache.set(cacheKey, {
                    pending: false,
                    value: null,
                    append: append,
                });
                return;
            }

            const body = JSON.stringify({
                _token: document.querySelector('meta[name="csrf-token"]')
                    ?.content,
                model: reference,
                foreignKey: constrainId,
                foreignKeyValue: constrainValues,
            });

            const response = await fetch("/api/get-references", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: body,
                credentials: "same-origin",
            });
            if (!response.ok) throw new Error("Request failed");

            const data = await response.json();
            const currentData = data.data || [];

            if (!append) refSelect.innerHTML = '<option value="">--</option>';

            // تحديث عدد البيانات
            const label = document
                .querySelector(`#${referenceId}`)
                .parentElement.querySelector(".dataLength");
            if (label) {
                label.innerText = `(${currentData.length})` || 0;
            }

            if (!currentData || currentData.length == 0) {
                refSelect.innerHTML = '<option value="">--</option>';
                refSelect.disabled = true;

                // 🔁 احذف أي wrapper قديم
                const oldWrapper = document.querySelector(
                    `[data-for="${refSelect.id}"]`,
                );
                if (oldWrapper) oldWrapper.remove();

                // 🧹 أعد تهيئة specialSelect حتى لو فاضي (عشان الـ UI يتحدث)
                if (refSelect.hasAttribute("special-multiple")) {
                    if (window.specialSelect) window.specialSelect(refSelect);
                } else if (refSelect.hasAttribute("special-search")) {
                    if (window.specialSearch) window.specialSearch(refSelect);
                }

                // 🧽 نظف عداد البيانات
                const label =
                    refSelect.parentElement.querySelector(".dataLength");
                if (label) label.innerText = "(0)";
                return;
            }

            refSelect.parentElement?.classList.remove("loading");
            if (refSelect) {
                document
                    .getElementById(`${referenceId}-loader`)
                    ?.classList.remove("show");
            }

            if (Array.isArray(currentData) && currentData.length > 0) {
                currentData.forEach((item) => {
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.textContent = item.name;
                    refSelect.appendChild(option);
                });
                refSelect.disabled = false;

                // تحديث specialSearch — لكن فقط لو مش في طور التهيئة
                if (!initializing) {
                    document.dispatchEvent(
                        new CustomEvent("updatedPaginate", {
                            detail: { id: referenceId },
                        }),
                    );
                }

                // إعادة تهيئة special search لو محتاج
                const oldWrapper = document.querySelector(
                    `[data-for="${refSelect.id}"]`,
                );
                if (oldWrapper) oldWrapper.remove();

                //  تحضير selectedData هنا (جوا scope الـ currentData)
                let dataValues;
                let selectedData = [];

                if (selectedValue) {
                    dataValues = Array.from(selectedValue.split(",")).map((v) =>
                        v.trim(),
                    );

                    // لو في edit mode وفي currentData
                    if (action == "edit" && currentData.length > 0) {
                        selectedData = currentData.filter((i) =>
                            dataValues.includes(i.id.toString()),
                        );
                    }
                }

                //  استقبل الـ state من specialSelect بدل إنشاء واحد جديد
                let state;

                if (refSelect.hasAttribute("special-multiple")) {
                    if (window.specialSelect) {
                        //  إضافة listener للـ multiSelectUpdated قبل إنشاء الـ component
                        // ⚠️ فقط لـ state_id (عشان نحمل cities)
                        if (
                            constrainId == "state_id" &&
                            !refSelect.dataset.listenerAttached
                        ) {
                            refSelect.dataset.listenerAttached = "true";
                            refSelect.addEventListener(
                                "multiSelectUpdated",
                                async (e) => {
                                    //  تأكد 100% إن الـ event جاي من state_id
                                    if (e.target.id !== "state_id") return;
                                    if (initializing) return; // تجاهل أثناء التهيئة

                                    let stateIds =
                                        window.getSelectedIds("state_id[]");
                                    if (stateIds && stateIds.length > 0) {
                                        await filterByForeignId(
                                            "state_id",
                                            "city",
                                            "city_id",
                                            "edit",
                                        ).loadReferenceData(stateIds);
                                        window.setTagsFromHiddenInputs(
                                            "city_id",
                                        );
                                    } else {
                                        // Clear city select when no states are selected
                                        const citySelect =
                                            document.getElementById("city_id");
                                        if (citySelect) {
                                            citySelect.innerHTML =
                                                '<option value="">--</option>';
                                            citySelect.disabled = true;
                                        }
                                        // Remove all city tags
                                        const cityTags =
                                            document.querySelectorAll(
                                                '[data-for="city_id"] .tag-item',
                                            );
                                        cityTags.forEach((tag) => tag.remove());
                                    }
                                },
                            );
                        }

                        //  تمرير selectedData واستقبال الـ state
                        state = window.specialSelect(refSelect, {
                            selectedData,
                        });

                        // ⚡️ بعد التهيئة، عيّن الـ removeTag الجديد
                        window.removeTag(
                            state,
                            refSelect,
                            null,
                            async (tagId) => {
                                if (constrainId == "state_id") {
                                    let stateIds = window.getSelectedIds(
                                        `${constrainId}[]`,
                                    );

                                    if (stateIds && stateIds.length > 0) {
                                        await filterByForeignId(
                                            "state_id",
                                            "city",
                                            "city_id",
                                            "edit", //  تمرير edit
                                        ).loadReferenceData(stateIds);
                                        window.setTagsFromHiddenInputs(
                                            "city_id",
                                        );
                                    } else {
                                        // Clear city select when no states are selected
                                        const citySelect =
                                            document.getElementById("city_id");
                                        if (citySelect) {
                                            citySelect.innerHTML =
                                                '<option value="">--</option>';
                                            citySelect.disabled = true;
                                        }
                                        // Remove all city tags
                                        const cityTags =
                                            document.querySelectorAll(
                                                '[data-for="city_id"] .tag-item',
                                            );
                                        cityTags.forEach((tag) => tag.remove());
                                    }
                                }
                            },
                        );
                        initializing = false;
                    }
                } else if (refSelect.hasAttribute("special-search")) {
                    if (window.specialSearch) window.specialSearch(refSelect);
                }

                if (!selectedValue) return;

                // تعيين القيمة المحددة لو مش multiple
                if (!Array.isArray(selectedValue)) {
                    // Determine authoritative selection value to avoid timing/race issues.
                    // Priority: hidden input (server-persisted) -> actual <select>.value -> selectedValue arg -> data-current-value
                    const parentEl = refSelect.parentElement;
                    const hiddenInputExisting = parentEl
                        ? parentEl.querySelector(
                              `input[type="hidden"][name^="${refSelect.name}"]`,
                          )
                        : null;
                    const hiddenVal = hiddenInputExisting
                        ? String(hiddenInputExisting.value)
                        : null;
                    const fromSelect =
                        refSelect.value && String(refSelect.value) !== ""
                            ? String(refSelect.value)
                            : null;
                    const dataCurrent = refSelect.dataset.currentValue
                        ? String(refSelect.dataset.currentValue)
                        : null;

                    const effectiveSelectedValue =
                        hiddenVal ||
                        fromSelect ||
                        (selectedValue ? String(selectedValue) : null) ||
                        dataCurrent ||
                        null;

                    // set select.value to effective value (ensures option is selected)
                    if (effectiveSelectedValue) {
                        try {
                            refSelect.value = effectiveSelectedValue;
                        } catch (e) {
                            // ignore if value not present yet
                        }
                    }

                    // Prefer the wrapper that was created next to the select (more reliable)
                    let wrapper = refSelect.nextElementSibling;
                    if (!wrapper || wrapper.dataset.for !== refSelect.id) {
                        wrapper = document.querySelector(
                            `[data-for="${refSelect.id}"]`,
                        );
                    }
                    const searchInput = wrapper?.querySelector(".tag-input");

                    // Find the matching item from currentData using the effective value
                    const selected = currentData.find(
                        (item) => String(item.id) === effectiveSelectedValue,
                    );

                    if (searchInput) {
                        // Ensure hidden input exists and matches the selected value
                        const hiddenName = refSelect.name;
                        const parent = refSelect.parentElement;
                        if (parent) {
                            // remove other hidden inputs for this select then add the correct one
                            // match both `name` and `name[]` (and similar variants) by using starts-with
                            parent
                                .querySelectorAll(
                                    `input[type="hidden"][name^="${hiddenName}"]`,
                                )
                                .forEach((i) => i.remove());

                            const hidden = document.createElement("input");
                            hidden.type = "hidden";
                            // use the exact select name (if it's an array name like state_id[] keep it)
                            hidden.name = hiddenName;
                            hidden.value = effectiveSelectedValue;
                            if (selected) hidden.dataset.name = selected.name;
                            parent.appendChild(hidden);
                        }

                        // Sync the search input UI using the effective selection
                        searchInput.dataset.id = effectiveSelectedValue;
                        searchInput.value = selected ? selected.name : "";

                        // also mark the matching option as selected if it exists
                        Array.from(refSelect.options).forEach((opt) => {
                            opt.selected =
                                String(opt.value) === effectiveSelectedValue;
                        });
                    }
                }
            }
        } catch (error) {
            console.error("Error loading data:", error);
        } finally {
            let attempts = 0;
            const maxAttempts = 3;
            let allRemoved = true;
            const removalInterval = setInterval(() => {
                attempts++;
                if (
                    refSelect.parentElement &&
                    refSelect.parentElement.classList.contains("loading")
                ) {
                    refSelect.parentElement.classList.remove("loading");
                    allRemoved = false;
                }
                const loaderElement = document.getElementById(
                    `${referenceId}-loader`,
                );
                if (loaderElement && loaderElement.classList.contains("show")) {
                    loaderElement.classList.remove("show");
                    allRemoved = false;
                }
                const infoElement = document.getElementById(
                    `${referenceId}-info`,
                );
                if (infoElement && infoElement.classList.contains("show")) {
                    infoElement.classList.remove("show");
                    allRemoved = false;
                }
                if (attempts >= maxAttempts || allRemoved) {
                    clearInterval(removalInterval);
                }
            }, 1000);

            //  بعد انتهاء الطلب، نحدث حالة الكاش
            globalRequestCache.set(cacheKey, {
                pending: false,
                value: constrainValue,
                append: append,
            });
        }
    }

    const refSelect = referenceSelect();
    if (refSelect && !refSelect._filterEventsBound) {
        document.addEventListener("change", handleChange);
        document.addEventListener("click", handleClick);
        refSelect._filterEventsBound = true; //  Mark as initialized
    }

    // 3) لو action == "edit" نحاول تحميل القيم الحالية فورًا
    if (action == "edit") {
        async function loadEditHierarchy() {
            const regionVal = window.getVal("region_id");
            const subregionVal = window.getVal("subregion_id");
            const countryVal = window.getVal("country_id");
            const stateVal = window.getVal("state_id");
            const cityVal = window.getVal("city_id");

            // 1) Region → Subregion (populate subregion list)
            if (regionVal) {
                await loadReferenceData(regionVal, subregionVal);
            }

            // 2) Ensure country list is populated when we have either subregion or country
            if (subregionVal || countryVal) {
                await filterByForeignId(
                    "subregion_id",
                    "country",
                    "country_id",
                    "edit",
                ).loadReferenceData(subregionVal, countryVal);
            }

            // 3) Decide which parent provides states: prefer country, otherwise subregion
            if (countryVal) {
                await filterByForeignId(
                    "country_id",
                    "state",
                    "state_id",
                    "edit",
                ).loadReferenceData(countryVal, stateVal);
            } else if (subregionVal) {
                await filterByForeignId(
                    "subregion_id",
                    "state",
                    "state_id",
                    "edit",
                ).loadReferenceData(subregionVal, stateVal);
            }

            // 4) Maintain UI state for all_states / all_cities
            const allStates = document.getElementById("all_states");
            const stateSelect = document.getElementById("state_id");

            if (allStates && allStates.checked) {
                if (stateSelect) {
                    stateSelect.disabled = true;
                    stateSelect.nextElementSibling?.classList.add("loading");
                }
            } else {
                if (stateSelect) {
                    stateSelect.disabled = false;
                    stateSelect.nextElementSibling?.classList.remove("loading");
                }
            }

            const allCities = document.getElementById("all_cities");
            const citySelect = document.getElementById("city_id");

            if (allCities && allCities.checked) {
                if (citySelect) {
                    citySelect.disabled = true;
                    citySelect.nextElementSibling?.classList.add("loading");
                }
            } else {
                if (citySelect) {
                    citySelect.disabled = false;
                    citySelect.nextElementSibling?.classList.remove("loading");
                }
            }

            // 5) Activate tags from hidden inputs for state and city if present
            window.setTagsFromHiddenInputs("state_id");
            initializing = false;

            const stateIds = getHiddenInputValues("state_id").map((x) => x.id);
            if (stateIds.length > 0) {
                window.setTagsFromHiddenInputs("city_id");
                initializing = false;
            }

            // 6) Finally: State → City (prefer explicit stateVal, otherwise any hidden stateIds)
            const effectiveStateVal =
                stateVal || (stateIds.length > 0 ? stateIds.join(",") : null);
            if (effectiveStateVal) {
                await filterByForeignId(
                    "state_id",
                    "city",
                    "city_id",
                    "edit",
                ).loadReferenceData(effectiveStateVal, cityVal);
                window.setTagsFromHiddenInputs("city_id");
            }
        }

        loadEditHierarchy();
    }

    // 4) حماية: لو الـ select اتفعل بالـ `input` في special search
    const constrainWrapper = document.querySelector(constrainWrapperSelector);
    const searchInput = constrainWrapper?.querySelector(".tag-input");
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            if (!this.value.trim()) clearDependents(constrainId);
        });
    }

    //  إضافة listener على updatedSelect (من SpecialSearch - single select)
    // Support for state_id → city_id
    if (constrainId == "state_id" && referenceSelect()) {
        referenceSelect().addEventListener("updatedSelect", async (e) => {
            //  تأكد إن الـ event جاي من state_id فقط
            if (e.target.id != "state_id") return;

            const stateId = e.detail?.value;
            if (stateId) {
                await filterByForeignId(
                    "state_id",
                    "city",
                    "city_id",
                ).loadReferenceData(stateId);
            } else {
                // Clear cities if no state selected
                const citySelect = document.getElementById("city_id");
                if (citySelect) {
                    citySelect.innerHTML = '<option value="">--</option>';
                    citySelect.disabled = true;
                }
            }
        });
    }

    //  Support for subregion_id → state_id (in pages without country_id)
    if (constrainId == "state_id" && !document.getElementById("country_id")) {
        const subregionSelect = document.getElementById("subregion_id");
        if (subregionSelect && !subregionSelect.dataset.stateListenerBound) {
            subregionSelect.dataset.stateListenerBound = "true";
            subregionSelect.addEventListener("updatedSelect", async (e) => {
                if (e.target.id !== "subregion_id") return;

                const subregionId = e.detail?.value;
                if (subregionId) {
                    await filterByForeignId(
                        "subregion_id",
                        "state",
                        "state_id",
                        action,
                    ).loadReferenceData(subregionId);
                } else {
                    // Clear states if no subregion selected
                    const stateSelect = document.getElementById("state_id");
                    if (stateSelect) {
                        stateSelect.innerHTML = '<option value="">--</option>';
                        stateSelect.disabled = true;
                    }
                }
            });
        }
    }

    //  استخدم نفس الـ instanceKey
    filterByForeignIdInstances[instanceKey] = { loadReferenceData };
    //  احفظ آخر instance key عشان handleClick/handleChange يعرف يلاقيه
    constrainIdToReference[constrainId] = instanceKey;
    return filterByForeignIdInstances[instanceKey];
}

function handleClick(e) {
    const li = e.target.closest("li");
    if (!li) return;

    const wrapper = li.closest("[data-for]");
    if (!wrapper) return;

    const constrainId = wrapper.dataset.for;
    const constrainValue = li.dataset.value;
    if (!constrainValue) return;

    //  استخدم الـ mapping عشان تلاقي الـ instance الصح
    const instanceKey = constrainIdToReference[constrainId];
    const api = instanceKey ? filterByForeignIdInstances[instanceKey] : null;
    api?.loadReferenceData(constrainValue);
}

function handleChange(e) {
    const sel = e.target;
    if (!(sel instanceof HTMLSelectElement)) return;

    //  استخدم الـ mapping عشان تلاقي الـ instance الصح
    const instanceKey = constrainIdToReference[sel.id];
    const api = instanceKey ? filterByForeignIdInstances[instanceKey] : null;
    if (!api) return;

    if (!sel.value) {
        clearDependents(sel.id);
    } else {
        api.loadReferenceData(sel.value);
    }
}

// 🧠 دالة عامة لتفريغ جميع الـ selects التابعة لأي مستوى
function clearDependents(fromId) {
    const hierarchy = [
        "region_id",
        "subregion_id",
        "country_id",
        "state_id",
        "city_id",
    ];
    const fromIndex = hierarchy.indexOf(fromId);
    if (fromIndex == -1) return;

    // 🧹 امسح كاش المستوى نفسه بشكل كامل
    const selfKey = `${fromId}_data`;
    if (globalRequestCache.has(selfKey)) {
        globalRequestCache.delete(selfKey);
        console.debug(`🧹 Cache cleared for ${selfKey}`);
    }

    // 🧹 امسح كاش كل المستويات التابعة بعده
    for (let i = fromIndex + 1; i < hierarchy.length; i++) {
        const level = hierarchy[i];
        const cacheKey = `${level}_data`;
        if (globalRequestCache.has(cacheKey)) {
            globalRequestCache.delete(cacheKey);
            console.debug(`🧹 Cache cleared for ${cacheKey}`);
        }

        const sel = document.getElementById(level);
        if (sel) {
            sel.innerHTML = '<option value="">--</option>';
            sel.disabled = true;
        }

        const wrapper = document.querySelector(`[data-for="${level}"]`);
        if (wrapper) {
            const tagInput = wrapper.querySelector(".tag-input");
            if (tagInput) tagInput.value = "";
            wrapper.querySelectorAll(".tag-item").forEach((t) => t.remove());
        }

        const label = sel?.parentElement?.querySelector(".dataLength");
        if (label) label.innerText = "";

        document.getElementById(`${level}-info`)?.classList.add("show");
    }
}

function getHiddenInputValues(name) {
    const hiddenInputs = document.querySelectorAll(
        `input[name="${name}[]"][type="hidden"]`,
    );
    return Array.from(hiddenInputs).map((input) => ({
        id: input.value,
        name: input.dataset.name,
    }));
}

function resetDependentTags(parentName, childInput) {
    const parentIds = getHiddenInputValues(parentName);
    if (parentIds.length == 0) {
        const childTags =
            childInput.parentElement.querySelectorAll(".tag-item");
        if (childTags.length > 0) {
            childTags.forEach((tag) => tag.remove());
        }
    }
}

// ===========================
// HELPER FUNCTIONS
// ===========================
const stateSelect = document.getElementById("state_id");
stateSelect?.addEventListener("multiSelectUpdated", async (e) => {
    //  تأكد إن الـ event جاي من state_id فقط
    if (e.target.id != "state_id") return;

    let stateIds = window.getSelectedIds("state_id[]");

    if (stateIds && stateIds.length > 0) {
        //  في states محددة - نبعت request
        await filterByForeignId(
            "state_id",
            "city",
            "city_id",
            "edit",
        ).loadReferenceData(stateIds);
        window.setTagsFromHiddenInputs("city_id");
    } else {
        //  مفيش states - نحذف الـ cities مباشرة
        const citySelect = document.getElementById("city_id");
        if (citySelect) {
            citySelect.innerHTML = '<option value="">--</option>';
            citySelect.disabled = true;

            // Clear city dropdown
            const cityWrapper = document.querySelector('[data-for="city_id"]');
            if (cityWrapper) {
                const cityDropdown = cityWrapper.querySelector(".dropdown");
                if (cityDropdown) cityDropdown.innerHTML = "";
            }

            // Clear label
            const label =
                citySelect.parentElement?.querySelector(".dataLength");
            if (label) label.innerText = "(0)";
        }

        // Remove all city tags
        const cityTags = document.querySelectorAll(
            '[data-for="city_id"] .tag-item',
        );
        cityTags.forEach((tag) => tag.remove());

        // Clear hidden inputs
        const cityInputs = document.querySelectorAll(
            'input[name="city_id[]"][type="hidden"]',
        );
        cityInputs.forEach((input) => input.remove());
    }
});
