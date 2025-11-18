// ======= Multi Delete =======
window.specialDelete = function (selectAllId, rowCheckboxSelector) {
    const selectAll = document.getElementById(selectAllId);
    const checkboxes = document.querySelectorAll(rowCheckboxSelector);
    const deleteAllBtn = document.getElementById("deleteAllBtn");

    if (!selectAll || checkboxes.length === 0 || !deleteAllBtn) return;

    // مسح الأحداث القديمة
    const newSelectAll = selectAll.cloneNode(true);
    selectAll.parentNode.replaceChild(newSelectAll, selectAll);

    const newCheckboxes = [];
    document.querySelectorAll(rowCheckboxSelector).forEach((cb) => {
        const newCb = cb.cloneNode(true);
        cb.parentNode.replaceChild(newCb, cb);
        newCheckboxes.push(newCb);
    });

    // Mark as initialized
    newSelectAll.dataset.initialized = "true";
    deleteAllBtn?.classList.add("hidden");

    // ✅ تحديد الكل
    if (newSelectAll) {
        newSelectAll.addEventListener("change", () => {
            newSelectAll.classList.remove("indeterminate");
            newCheckboxes.forEach((cb) => (cb.checked = newSelectAll.checked));
            updateDeleteButtonVisibility(rowCheckboxSelector);
        });
    }

    // ✅ عند تحديد/إلغاء تحديد فردي
    newCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            if (!checkbox.checked) {
                newSelectAll.classList.add("indeterminate");
            } else {
                newSelectAll.classList.remove("indeterminate");
                const allChecked = newCheckboxes.every((cb) => cb.checked);
                newSelectAll.checked = allChecked;
            }

            updateDeleteButtonVisibility(rowCheckboxSelector);
        });
    });

    // ✅ زر الحذف
    if (deleteAllBtn) {
        const deleteHandler = () => {
            const selected = document.querySelectorAll(
                `${rowCheckboxSelector}:checked`,
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
        };

        // Remove old listener and add new one
        const newDeleteBtn = deleteAllBtn.cloneNode(true);
        deleteAllBtn.parentNode.replaceChild(newDeleteBtn, deleteAllBtn);
        newDeleteBtn.addEventListener("click", deleteHandler);
    }
};

function updateDeleteButtonVisibility(rowCheckboxSelector) {
    const selected = document.querySelectorAll(
        `${rowCheckboxSelector}:checked`,
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

document.addEventListener("DOMContentLoaded", () => {
    // detect all selects
    window.specialDelete("selectAllItems", "input[name='selectedItems[]']");

    document.addEventListener("updatedPaginate", () => {
        console.log("updatedPaginate");
        setTimeout(() => {
            window.resetDeleteSelection();
            window.specialDelete(
                "selectAllItems",
                "input[name='selectedItems[]']",
            );
        }, 200);
    });
});
