function filterByForeignId(
    constrainId,
    reference,
    referenceId,
    action = "create"
) {
    const constrainWrapperSelector = `[data-for="${constrainId}"]`;
    const referenceSelect = () => document.getElementById(referenceId);

    // دالة تحمل البيانات من السيرفر
    async function loadReferenceData(
        constrainValue,
        selectedValue = null,
        append = false
    ) {
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
            let constrainValues = constrainValue
                .toString()
                .split(",")
                .filter((v) => v)
                .map((v) => parseInt(v));
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
                    foreignKeyValue: constrainValues,
                }),
                credentials: "same-origin",
            });
            if (!response.ok) throw new Error("Request failed");

            const data = await response.json();

            const label = document
                .querySelector(`#${referenceId}`)
                .parentElement.querySelector(".dataLength");
            if (label) {
                label.innerText = `(${data.data.length})` || 0;
            }

            if (!append) refSelect.innerHTML = '<option value="">--</option>';

            if (Array.isArray(data.data) && data.data.length > 0) {
                data.data.forEach((item) => {
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.textContent = item.name;
                    refSelect.appendChild(option);
                });
                refSelect.disabled = false;

                // تحديث specialSearch
                document.dispatchEvent(
                    new CustomEvent("updatedPaginate", {
                        detail: { id: referenceId },
                    })
                );

                // إعادة تهيئة special search لو محتاج
                const oldWrapper = document.querySelector(
                    `[data-for="${refSelect.id}"]`
                );
                if (oldWrapper) oldWrapper.remove();

                if (!refSelect.hasAttribute("special-multiple")) {
                    if (window.specialSearch) window.specialSearch(refSelect);
                } else if (window.specialSelect) {
                    window.specialSelect(refSelect);
                }

                if (selectedValue && !Array.isArray(selectedValue)) {
                    refSelect.value = selectedValue;
                    const wrapper = document.querySelector(
                        `[data-for="${refSelect.id}"]`
                    );
                    const searchInput = wrapper?.querySelector(".tag-input");
                    if (searchInput) {
                        const selected = data.data.find(
                            (item) => item.id == selectedValue
                        );
                        searchInput.dataset.id = selectedValue;
                        searchInput.value = selected ? selected.name : "";
                    }
                }
            } else {
                refSelect.disabled = true;
            }
        } catch (error) {
            console.error("Error loading data:", error);
        } finally {
            refSelect.parentElement?.classList.remove("loading");
            document
                .getElementById(`${referenceId}-loader`)
                ?.classList.remove("show");
            document
                .getElementById(`${referenceId}-info`)
                ?.classList.remove("show");
        }
    }

    // --- Event handling المرن ---
    // 1) Delegated click: يمسك أي click على LI داخل ال wrapper حتى لو اتبنى لاحقًا
    document.addEventListener("click", (e) => {
        const li = e.target.closest?.("li");
        if (!li) return;
        const wrapper = li.closest(constrainWrapperSelector);
        if (!wrapper) return;
        const constrainValue = li.dataset.value;
        if (!constrainValue) return;
        loadReferenceData(constrainValue);
    });

    // 2) Change event على الـ select الفعلي (لو specialSearch بيستخدم select)
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

    // 3) لو action === "edit" نحاول تحميل القيم الحالية فورًا
    if (action === "edit") {
        async function loadEditHierarchy() {
            const getVal = (id) =>
                document.querySelector(`#${id}`)?.dataset.currentValue ||
                document.querySelector(`#${id}`)?.value;

            const regionVal = getVal("region_id");
            const subregionVal = getVal("subregion_id");
            const countryVal = getVal("country_id");
            const stateVal = getVal("state_id");
            const cityVal = getVal("city_id");

            // تحميل متسلسل
            if (regionVal) {
                await loadReferenceData(regionVal, subregionVal); // region → subregion
            }
            if (subregionVal) {
                await filterByForeignId(
                    "subregion_id",
                    "country",
                    "country_id"
                ).loadReferenceData(subregionVal, countryVal);
            }
            if (countryVal) {
                await filterByForeignId(
                    "country_id",
                    "state",
                    "state_id"
                ).loadReferenceData(countryVal, stateVal);

                // 1️⃣ حمّل الولايات التابعة أولاً
                // 2️⃣ فعّل الـ tags من hidden inputs بعد تحميل الـ options
                console.log("test1");
                await setTagsFromHiddenInputs("state_id");
                const stateIds = getHiddenInputValues("state_id").map(
                    (x) => x.id
                );
                if (stateIds.length > 0) {
                    console.log("test2");
                    await loadData("state_id", "city", "city_id", stateIds);
                    await setTagsFromHiddenInputs("city_id");
                }
            }
            if (stateVal) {
                await filterByForeignId(
                    "state_id",
                    "city",
                    "city_id"
                ).loadReferenceData(stateVal, cityVal);

                console.log("test3");
                await setTagsFromHiddenInputs("city_id");
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

    // expose loadReferenceData for manual calls (optional)
    return { loadReferenceData };
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

    // مرّ على كل العناصر اللي بعد المستوى الحالي وافرغها
    for (let i = fromIndex + 1; i < hierarchy.length; i++) {
        const sel = document.getElementById(hierarchy[i]);
        if (sel) {
            sel.innerHTML = '<option value="">--</option>';
            sel.disabled = true;
            const wrapper = document.querySelector(
                `[data-for="${hierarchy[i]}"]`
            );
            if (wrapper) {
                wrapper.parentElement?.classList.add("loading");
                wrapper.querySelector(".tag-input").value = "";
                if (wrapper.querySelectorAll(".tag-item").length > 0) {
                    wrapper
                        .querySelectorAll(".tag-item")
                        .forEach((t) => t.remove());
                }
            }

            document
                .getElementById(`${hierarchy[i]}-info`)
                ?.classList.add("show");
        }
    }
}

function getHiddenInputValues(name) {
    const hiddenInputs = document.querySelectorAll(
        `input[name="${name}[]"][type="hidden"]`
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

async function setTagsFromHiddenInputs(selectId) {
    let parentIds = getHiddenInputValues(selectId);
    if (parentIds.length === 0) return;

    const wrapper = document.querySelector(
        `[data-for='${selectId}'] .tag-container`
    );
    if (!wrapper) {
        console.error(`Tag container not found for ${selectId}`);
        return;
    }

    parentIds.forEach((item) => {
        if (document.querySelector(`.tag-item[data-id='${item.id}']`)) {
            return;
        }

        const tag = document.createElement("span");
        tag.classList.add("tag-item");
        tag.textContent = item.name || item.text || item.id; // fallback
        tag.dataset.id = item.id;
        tag.dataset.name = item.name || item.text || item.id;

        const cross = document.createElement("span");
        cross.classList.add("cross");
        cross.textContent = "×";
        tag.appendChild(cross);

        tag.querySelector(".cross").addEventListener("click", () => {
            tag.remove();
            resetDependentTags(selectId, getInput(selectId));

            let inputHidden = document.querySelector(
                `input[name="${selectId}[]"][type="hidden"][value="${tag.dataset.id}"]`
            );
            if (inputHidden) inputHidden.remove();

            let tagId = item.id;
            const event = new CustomEvent("multiSelectUpdated", {
                detail: { name: item.name, tagId: tagId },
            });
            getSelect(selectId).dispatchEvent(event);
        });

        wrapper.prepend(tag);
    });
}

const getSelect = (id) => document.getElementById(id);
const getInput = (key) =>
    document.querySelector(`[data-for='${key}'] .tag-input`);

const countrySelect = getSelect("country_id");
const stateSelect = getSelect("state_id");
const citySelect = getSelect("city_id");
const allStates = getSelect("all_states");
const allCities = getSelect("all_cities");

stateSelect?.addEventListener("updatedSelect", async () => {
    console.log("test1");
});
stateSelect?.addEventListener("multiSelectUpdated", async (e) => {
    console.log("test2:", e.detail);
    await handleStateChange("multiSelectUpdated");
});
allStates?.addEventListener("change", async () => {
    console.log("test3");
});
allCities?.addEventListener("change", async () => {
    console.log("test4");
});

const loadData = async (fromId, model, toId, value) => {
    const ref = filterByForeignId(fromId, model, toId);
    if (ref && typeof ref.loadReferenceData === "function") {
        await ref.loadReferenceData(value);
    }
};

const getSelectedIds = (name) => {
    return [...document.querySelectorAll(`input[name='${name}']`)]
        .map((input) => input.value)
        .filter((v) => v !== "");
};

async function handleStateChange(triggerType) {
    const stateIds = getSelectedIds("state_id[]");
    const countryId = getInput("country_id")?.dataset.id;

    await resetDependentTags("state_id", getInput("city_id"));

    // ✅ حالة "كل الولايات"
    if (allStates?.checked) {
        stateSelect.disabled = true;
        getSelect("state_id").nextElementSibling?.classList.add("loading");
        await loadData("country_id", "city", "city_id", countryId);
        return;
    }

    // ✅ الحالة العادية
    stateSelect.disabled = false;
    getSelect("state_id").nextElementSibling?.classList.remove("loading");
    if (!stateIds.length) {
        citySelect.disabled = false;
        citySelect.innerHTML = '<option value="">--</option>';
        getSelect("city_id")?.parentElement.classList.add("loading");
        document.getElementById(`city_id-info`)?.classList.add("show");
        const label = document
            .getElementById("city_id")
            ?.parentElement.querySelector(".dataLength");
        if (label) label.innerText = "";
        return;
    }

    // ✅ لو allCities متعلم عليها → نجيب كل المدن في الدولة
    if (allCities?.checked) {
        citySelect.disabled = true;
        citySelect.innerHTML = '<option value="">--</option>';
        getSelect("city_id")?.nextElementSibling.classList.add("loading");
        return;
    }

    // ✅ تحميل المدن بناءً على الولاية
    citySelect.disabled = false;
    getSelect("city_id")?.nextElementSibling.classList.remove("loading");
    await loadData("state_id", "city", "city_id", stateIds);
}
