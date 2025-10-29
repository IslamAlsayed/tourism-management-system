// ✅ Global cache - accessible from other files
window.globalRequestCache = window.globalRequestCache || new Map();
const globalRequestCache = window.globalRequestCache;
const filterByForeignIdInstances = {};

function filterByForeignId(
    constrainId,
    reference,
    referenceId,
    action = "create",
) {
    const constrainWrapperSelector = `[data-for="${constrainId}"]`;
    const referenceSelect = () => document.getElementById(referenceId);

    let initializing = action === "edit";
    if (filterByForeignIdInstances[constrainId]) {
        return filterByForeignIdInstances[constrainId];
    }

    // دالة تحمل البيانات من السيرفر
    async function loadReferenceData(
        constrainValue,
        selectedValue = null,
        append = false,
    ) {
        const cacheKey = `${constrainId}_data`;

        // لو الطلب بنفس القيمه لسه شغال → تجاهله
        const existing = globalRequestCache.get(cacheKey);
        if (existing?.pending) {
            if (window.APP_DEBUG)
                console.log("⏳ Ignored duplicate pending request");
            return;
        }

        // ✅ نقارن القيمة بشكل صحيح (array vs array)
        // لو آخر طلب بنفس القيمه خلص → تجاهله
        // ⚠️ لكن لو الكاش فيه قيمة قديمة والقيمة الجديدة مختلفة، نسمح بالطلب
        if (existing?.value) {
            const oldValue = Array.isArray(existing.value)
                ? existing.value.sort().join(",")
                : String(existing.value);
            const newValue = Array.isArray(constrainValue)
                ? constrainValue.sort().join(",")
                : String(constrainValue);

            if (oldValue === newValue) {
                if (window.APP_DEBUG)
                    console.log("✅ Ignored duplicate completed request", {
                        oldValue,
                        newValue,
                    });
                return;
            } else {
                if (window.APP_DEBUG)
                    console.log("🔄 Value changed, clearing cache", {
                        oldValue,
                        newValue,
                    });
                globalRequestCache.delete(cacheKey);
            }
        }

        globalRequestCache.set(cacheKey, {
            pending: true,
            value: constrainValue,
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
            } else if (typeof constrainValue === "string") {
                // If it's a string, split by comma first
                constrainValues = constrainValue
                    .split(",")
                    .filter((v) => v.trim())
                    .map((v) => parseInt(v.trim()));
            } else if (typeof constrainValue === "number") {
                // If it's a single number, wrap it in an array
                constrainValues = [constrainValue];
            } else {
                constrainValues = constrainValue;
            }

            // Check if constrainValues is empty or invalid
            if (
                !constrainValues ||
                (Array.isArray(constrainValues) &&
                    constrainValues.length === 0) ||
                constrainValues === "" ||
                constrainValues === null ||
                constrainValues === undefined
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

            if (!currentData || currentData.length === 0) {
                refSelect.innerHTML = '<option value="">--</option>';
                refSelect.disabled = true;

                // 🔁 احذف أي wrapper قديم
                const oldWrapper = document.querySelector(
                    `[data-for="${refSelect.id}"]`,
                );
                if (oldWrapper) oldWrapper.remove();

                // 🧹 أعد تهيئة specialSelect حتى لو فاضي (عشان الـ UI يتحدث)
                if (refSelect.hasAttribute("special-search")) {
                    if (window.specialSearch) window.specialSearch(refSelect);
                } else if (refSelect.hasAttribute("special-multiple")) {
                    if (window.specialSelect) window.specialSelect(refSelect);
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

                // ✅ تحضير selectedData هنا (جوا scope الـ currentData)
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

                // ✅ استقبل الـ state من specialSelect بدل إنشاء واحد جديد
                let state;

                if (refSelect.hasAttribute("special-search")) {
                    if (window.specialSearch) window.specialSearch(refSelect);
                } else if (refSelect.hasAttribute("special-multiple")) {
                    if (window.specialSelect) {
                        // ✅ إضافة listener للـ multiSelectUpdated قبل إنشاء الـ component
                        // ⚠️ فقط لـ state_id (عشان نحمل cities)
                        if (
                            constrainId == "state_id" &&
                            !refSelect.dataset.listenerAttached
                        ) {
                            refSelect.dataset.listenerAttached = "true";
                            refSelect.addEventListener(
                                "multiSelectUpdated",
                                async (e) => {
                                    // ✅ تأكد 100% إن الـ event جاي من state_id
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

                        // ✅ تمرير selectedData واستقبال الـ state
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
                                            "edit", // ✅ تمرير edit
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
                }

                if (!selectedValue) return;

                // تعيين القيمة المحددة لو مش multiple
                if (!Array.isArray(selectedValue)) {
                    refSelect.value = selectedValue;
                    const wrapper = document.querySelector(
                        `[data-for="${refSelect.id}"]`,
                    );
                    const searchInput = wrapper?.querySelector(".tag-input");
                    if (searchInput) {
                        const selected = currentData.find(
                            (item) => item.id == selectedValue,
                        );
                        searchInput.dataset.id = selectedValue;
                        searchInput.value = selected ? selected.name : "";
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

            // ✅ بعد انتهاء الطلب، نحدث حالة الكاش
            globalRequestCache.set(cacheKey, {
                pending: false,
                value: constrainValue,
            });
        }
    }

    if (!referenceSelect()._filterEventsBound) {
        document.addEventListener("change", handleChange);
        document.addEventListener("click", handleClick);
        referenceSelect()._filterEventsBound = true; // ✅ Mark as initialized
    }

    // 3) لو action == "edit" نحاول تحميل القيم الحالية فورًا
    if (action == "edit") {
        async function loadEditHierarchy() {
            const getVal = (id) =>
                document.querySelector(`#${id}`)?.dataset.currentValue ||
                document.querySelector(`#${id}`)?.value;

            const regionVal = getVal("region_id");
            const subregionVal = getVal("subregion_id");
            const countryVal = getVal("country_id");
            const stateVal = getVal("state_id");
            const cityVal = getVal("city_id");

            // ✅ لو مفيش country استخدم subregion كبديل
            const parentForState = countryVal || subregionVal;
            const parentKeyForState = countryVal
                ? "country_id"
                : "subregion_id";

            // ✅ Region → Subregion
            if (regionVal) {
                await loadReferenceData(regionVal, subregionVal);
            }

            // ✅ Subregion → Country (لو فيه country)
            if (subregionVal && countryVal) {
                await filterByForeignId(
                    "subregion_id",
                    "country",
                    "country_id",
                    "edit", // ✅ تمرير edit
                ).loadReferenceData(subregionVal, countryVal);
            }

            // ✅ Country أو Subregion → State
            if (parentForState) {
                await filterByForeignId(
                    parentKeyForState,
                    "state",
                    "state_id",
                    "edit", // ✅ تمرير edit
                ).loadReferenceData(parentForState, stateVal);

                // ✅ حالة all_states
                const allStates = document.getElementById("all_states");
                const stateSelect = document.getElementById("state_id");

                if (allStates && allStates.checked) {
                    stateSelect.disabled = true;
                    stateSelect?.nextElementSibling?.classList.add("loading");
                } else {
                    if (stateSelect) {
                        stateSelect.disabled = false;
                        stateSelect?.nextElementSibling?.classList.remove(
                            "loading",
                        );
                    }
                }

                // ✅ حالة all_cities
                const allCities = document.getElementById("all_cities");
                const citySelect = document.getElementById("city_id");

                if (allCities && allCities.checked) {
                    citySelect.disabled = true;
                    citySelect?.nextElementSibling?.classList.add("loading");
                } else {
                    if (citySelect) {
                        citySelect.disabled = false;
                        citySelect?.nextElementSibling?.classList.remove(
                            "loading",
                        );
                    }
                }

                // ✅ فعّل الـ tags من hidden inputs
                window.setTagsFromHiddenInputs("state_id");
                // بعد ما خلصنا تهيئة الـ tags والـ state — نسمح للـ listeners تشتغل طبيعياً
                initializing = false;

                const stateIds = getHiddenInputValues("state_id").map(
                    (x) => x.id,
                );
                if (stateIds.length > 0) {
                    window.setTagsFromHiddenInputs("city_id");
                    // بعد ما خلصنا تهيئة الـ tags والـ state — نسمح للـ listeners تشتغل طبيعياً
                    initializing = false;
                }
            }

            // ✅ State → City
            if (stateVal) {
                await filterByForeignId(
                    "state_id",
                    "city",
                    "city_id",
                    "edit", // ✅ تمرير edit
                ).loadReferenceData(stateVal, cityVal);

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

    filterByForeignIdInstances[constrainId] = { loadReferenceData };
    return filterByForeignIdInstances[constrainId];
}

function handleClick(e) {
    const li = e.target.closest("li");
    if (!li) return;

    const wrapper = li.closest("[data-for]");
    if (!wrapper) return;

    const constrainId = wrapper.dataset.for;
    const constrainValue = li.dataset.value;
    if (!constrainValue) return;

    const api = filterByForeignIdInstances[constrainId];
    api?.loadReferenceData(constrainValue);
}

function handleChange(e) {
    const sel = e.target;
    if (!(sel instanceof HTMLSelectElement)) return;

    const api = filterByForeignIdInstances[sel.id];
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
    if (fromIndex === -1) return;

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
    if (parentIds.length === 0) {
        const childTags =
            childInput.parentElement.querySelectorAll(".tag-item");
        if (childTags.length > 0) {
            childTags.forEach((tag) => tag.remove());
        }
    }
}

// ========================================
// HELPER FUNCTIONS
// ========================================
const stateSelect = document.getElementById("state_id");
stateSelect?.addEventListener("multiSelectUpdated", async (e) => {
    // ✅ تأكد إن الـ event جاي من state_id فقط
    if (e.target.id != "state_id") return;

    let stateIds = window.getSelectedIds("state_id[]");

    if (stateIds && stateIds.length > 0) {
        // ✅ في states محددة - نبعت request
        await filterByForeignId(
            "state_id",
            "city",
            "city_id",
            "edit",
        ).loadReferenceData(stateIds);
        window.setTagsFromHiddenInputs("city_id");
    } else {
        // ✅ مفيش states - نحذف الـ cities مباشرة
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
