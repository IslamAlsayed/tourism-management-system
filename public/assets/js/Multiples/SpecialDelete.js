// ======= Multi Delete =======
window.specialDelete = function (selectAllId, rowCheckboxSelector) {
    const selectAll = document.getElementById(selectAllId);
    const checkboxes = document.querySelectorAll(rowCheckboxSelector);
    const deleteAllBtn = document.getElementById("deleteAllBtn");

    // مسح الأحداث القديمة
    if (selectAll) selectAll.replaceWith(selectAll.cloneNode(true));
    document
        .querySelectorAll(rowCheckboxSelector)
        .forEach((cb) => cb.replaceWith(cb.cloneNode(true)));

    // ثم إعادة الربط
    const newSelectAll = document.getElementById(selectAllId);
    const newCheckboxes = document.querySelectorAll(rowCheckboxSelector);

    if (!newSelectAll || newCheckboxes.length === 0 || !deleteAllBtn) return;

    deleteAllBtn?.classList.add("hidden");

    // ✅ تحديد الكل
    if (newSelectAll) {
        newSelectAll.addEventListener("change", () => {
            newCheckboxes.forEach((cb) => (cb.checked = newSelectAll.checked));
            updateDeleteButtonVisibility(rowCheckboxSelector);
        });
    }

    // ✅ عند تحديد/إلغاء تحديد فردي
    newCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            if (!checkbox.checked) {
                newSelectAll.checked = false;
            } else {
                const allChecked = Array.from(newCheckboxes).every(
                    (cb) => cb.checked
                );
                newSelectAll.checked = allChecked;
            }

            updateDeleteButtonVisibility(rowCheckboxSelector);
        });
    });

    // ✅ زر الحذف
    if (deleteAllBtn) {
        deleteAllBtn?.addEventListener("click", () => {
            const selected = document.querySelectorAll(
                `${rowCheckboxSelector}:checked`
            );
            if (selected.length == 0) {
                alert("Please select at least one item to delete.");
                return;
            }

            if (!confirm("Are you sure you want to delete selected items?"))
                return;

            const model = deleteAllBtn?.dataset.model;
            const route = deleteAllBtn?.dataset.route;
            if (!route) {
                console.error("Missing route in data-route attribute.");
                return;
            }

            const deleteForm = document.createElement("form");
            deleteForm.method = "POST";
            deleteForm.action = route;

            // CSRF
            const csrf = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content");
            const csrfInput = document.createElement("input");
            csrfInput.type = "hidden";
            csrfInput.name = "_token";
            csrfInput.value = csrf || "";
            deleteForm.appendChild(csrfInput);

            // method
            const methodInput = document.createElement("input");
            methodInput.type = "hidden";
            methodInput.name = "_method";
            methodInput.value = "DELETE";
            deleteForm.appendChild(methodInput);

            // model
            const modelInput = document.createElement("input");
            modelInput.type = "hidden";
            modelInput.name = "model";
            modelInput.value = model;
            deleteForm.appendChild(modelInput);

            // selected IDs
            selected.forEach((cb) => {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = cb.name;
                input.value = cb.value;
                deleteForm.appendChild(input);
            });

            document.body.appendChild(deleteForm);
            deleteForm.submit();
        });
    }
};

function updateDeleteButtonVisibility(rowCheckboxSelector) {
    const selected = document.querySelectorAll(
        `${rowCheckboxSelector}:checked`
    );
    if (selected.length != 0) {
        deleteAllBtn?.classList.remove("hidden");
        document.getElementById("selectedCount").innerHTML =
            `<strong class="text-primary">${selected.length}</strong> items selected` ||
            "";
    } else {
        deleteAllBtn?.classList.add("hidden");
        document.getElementById("selectedCount").innerHTML = "";
    }
}

function resetDeleteSelection() {
    const selectAllItems = document.getElementById("selectAllItems");
    const anyChecked = document.querySelector(
        "input[name='selectedItems[]']:checked"
    );
    if (anyChecked && selectAllItems) {
        selectAllItems.click();
    }
}

document.addEventListener("DOMContentLoaded", () => {
    // detect all selects
    specialDelete("selectAllItems", "input[name='selectedItems[]']");

    // document.addEventListener("updatedPaginate", () => {
    //     console.log("updatedPaginate");
    //     setTimeout(() => {
    //         resetDeleteSelection();
    //         SpecialDelete("selectAllItems", "input[name='selectedItems[]']");
    //     }, 200);
    // });
});
