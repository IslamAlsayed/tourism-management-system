function filterByForeignId(
    constrainId,
    reference,
    referenceId,
    action = "create"
) {
    const constrainWrapperSelector = `[data-for="${constrainId}"]`;
    const referenceSelect = () => document.getElementById(referenceId);

    // دالة عامة لتحميل البيانات
    async function loadReferenceData(constrainValue, selectedValue = null) {
        const refSelect = referenceSelect();
        if (!refSelect) return;
        refSelect.parentElement?.classList.add("loading");
        document.getElementById(`${referenceId}-info`)?.classList.add("show");
        document.getElementById(`${referenceId}-loader`)?.classList.add("show");

        try {
            const response = await fetch("/api/get-references", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    _token: document.querySelector('meta[name="csrf-token"]')
                        .content,
                    model: reference,
                    foreignKey: constrainId,
                    foreignKeyValue: constrainValue,
                }),
                credentials: "same-origin",
            });
            const data = await response.json();
            refSelect.innerHTML = '<option value="">--</option>';

            if (Array.isArray(data) && data.length) {
                data.forEach((item) => {
                    const opt = document.createElement("option");
                    opt.value = item.id;
                    opt.textContent = item.name;
                    refSelect.appendChild(opt);
                });

                refSelect.disabled = false;

                // تحديث SpecialSearch
                document.dispatchEvent(
                    new CustomEvent("updatedPaginate", {
                        detail: { id: referenceId },
                    })
                );

                if (selectedValue) {
                    refSelect.value = selectedValue;
                    const wrapper = document.querySelector(
                        `[data-for="${refSelect.id}"]`
                    );
                    const searchInput = wrapper?.querySelector(".tag-input");
                    if (searchInput) {
                        const selected = data.find(
                            (item) => item.id == selectedValue
                        );
                        searchInput.value = selected ? selected.name : "";
                    }
                }
            } else {
                refSelect.disabled = true;
            }
        } catch (err) {
            console.error(err);
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

    // ----------------------------
    // 🧠 تحميل القيم الحالية في وضع edit
    if (action === "edit") {
        async function loadEditHierarchy() {
            const getVal = (id) =>
                document.querySelector(`#${id}`)?.dataset.currentValue ||
                document.querySelector(`#${id}`)?.value;

            const regionVal = getVal("region_id");
            const subregionVal = getVal("subregion_id");
            const stateVal = getVal("state_id");
            const cityVal = getVal("city_id");

            // تحميل متسلسل
            if (regionVal) {
                await loadReferenceData(regionVal, subregionVal); // region → subregion
            }
            if (subregionVal) {
                await filterByForeignId(
                    "subregion_id",
                    "state",
                    "state_id"
                ).loadReferenceData(subregionVal, stateVal);
            }
            if (stateVal) {
                await filterByForeignId(
                    "state_id",
                    "city",
                    "city_id"
                ).loadReferenceData(stateVal, cityVal);
            }
        }

        loadEditHierarchy();
    }

    // ----------------------------
    // 🖱️ التعامل مع الـ select
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

    // 🧹 تنظيف الـ selects التابعة لو المستخدم مسح قيمة من special search
    const constrainWrapper = document.querySelector(constrainWrapperSelector);
    const searchInput = constrainWrapper?.querySelector(".tag-input");
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            if (!this.value.trim()) clearDependents(constrainId);
        });
    }

    return { loadReferenceData };
}

function clearDependents(fromId) {
    const hierarchy = ["region_id", "subregion_id", "state_id", "city_id"];
    const fromIndex = hierarchy.indexOf(fromId);
    if (fromIndex === -1) return;

    for (let i = fromIndex + 1; i < hierarchy.length; i++) {
        const sel = document.getElementById(hierarchy[i]);
        if (sel) {
            sel.innerHTML = '<option value="">--</option>';
            sel.disabled = true;
            const wrapper = document.querySelector(
                `[data-for="${hierarchy[i]}"]`
            );
            if (wrapper?.querySelector(".tag-input"))
                wrapper.querySelector(".tag-input").value = "";
            document
                .getElementById(`${hierarchy[i]}-info`)
                ?.classList.add("show");
        }
    }
}
