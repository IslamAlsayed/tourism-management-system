// function filterByForeignId_2(constrainId, reference, referenceId) {
//     const constrainSelect = document.querySelector(
//         `[data-for="${constrainId}"]`
//     );
//     const referenceSelect = document.querySelector(`#${referenceId}`);

//     if (!constrainSelect || !referenceSelect) return;

//     const searchInput = constrainSelect.querySelector(".tag-input");

//     // 💡 دالة داخلية: المسؤولة عن معالجة التغيير وتحميل البيانات
//     const handleSelection = async (e) => {
//         if (e.target.tagName !== "LI" || !constrainSelect.contains(e.target))
//             return;

//         const constrainValue = e.target.dataset.value;
//         if (!constrainValue) return;

//         referenceSelect.parentElement.classList.add("loading");
//         document.getElementById(`${referenceId}-loader`)?.classList.add("show");
//         document
//             .getElementById(`${referenceId}-info`)
//             ?.classList.remove("show");

//         try {
//             const response = await fetch(
//                 `/dashboard/api/${reference}/${constrainId}/${constrainValue}`
//             );
//             if (!response.ok) throw new Error("Request failed");

//             const data = await response.json();

//             // تنظيف الخيارات القديمة
//             referenceSelect.innerHTML = '<option value="">--</option>';

//             if (data.length > 0) {
//                 referenceSelect.disabled = false;
//                 data.forEach((item) => {
//                     const option = document.createElement("option");
//                     option.value = item.id;
//                     option.textContent = item.name;
//                     referenceSelect.appendChild(option);
//                 });
//             } else {
//                 const option = document.createElement("option");
//                 option.value = "";
//                 option.textContent = "--";
//                 referenceSelect.appendChild(option);
//             }

//             // إعادة بناء الـ special-search
//             const existingWrapper = document.querySelector(
//                 `[data-for="${referenceSelect.id}"]`
//             );
//             if (existingWrapper) existingWrapper.remove();

//             referenceSelect.parentElement.classList.remove("loading");
//             document
//                 .getElementById(`${referenceId}-loader`)
//                 ?.classList.remove("show");

//             window.SpecialSearch(referenceSelect);
//         } catch (error) {
//             console.error("Error loading data:", error);
//             referenceSelect.parentElement.classList.remove("loading");
//             document
//                 .getElementById(`${referenceId}-loader`)
//                 ?.classList.remove("show");
//             document
//                 .getElementById(`${referenceId}-info`)
//                 ?.classList.add("show");
//         }
//     };

//     // ✅ تنظيف أي listener سابق لنفس الـ reference
//     if (referenceSelect._boundHandler) {
//         document.removeEventListener("click", referenceSelect._boundHandler);
//     }

//     // ✅ إنشاء listener جديد مربوط بالدالة الداخلية
//     referenceSelect._boundHandler = handleSelection;
//     document.addEventListener("click", handleSelection);

//     // ✅ لو تم حذف القيمة في الـ input — نظهر الـ loader
//     searchInput.addEventListener("input", function () {
//         if (!this.value) {
//             referenceSelect.parentElement.classList.add("loading");
//             document
//                 .getElementById(`${referenceId}-info`)
//                 ?.classList.add("show");
//         }
//     });
// }

function filterByForeignId(constrainId, reference, referenceId) {
    const constrainSelect = document.querySelector(
        `[data-for="${constrainId}"]`
    );
    const referenceSelect = document.querySelector(`#${referenceId}`);
    referenceSelect.parentElement.classList.add("loading");
    document.getElementById(`${referenceId}-info`)?.classList.add("show");

    // console.log("filterByForeignId1:", { constrainId, reference, referenceId });

    if (!constrainSelect || !referenceSelect) return;

    // 🔹 إزالة أي مستمعات سابقة لنفس الـ reference لتفادي التعارض
    // const newListener = async (e) => {
    //     if (e.target.tagName === "LI" && constrainSelect.contains(e.target)) {
    //         await handleSelection(e);
    //     }
    // };

    // document.removeEventListener("click", referenceSelect._boundHandler);
    // referenceSelect._boundHandler = newListener;
    // document.addEventListener("click", newListener);

    const searchInput = constrainSelect.querySelector(".tag-input");
    searchInput.addEventListener("input", function () {
        if (!this.value) {
            referenceSelect.parentElement.classList.add("loading");
            document
                .getElementById(`${referenceId}-info`)
                ?.classList.add("show");
        }
    });

    document.addEventListener("click", (e) => handleSelection(e));

    let handleSelection = async (e) => {
        if (e.target.tagName === "LI" && constrainSelect.contains(e.target)) {
            console.log("filterByForeignId2:", {
                constrainId,
                reference,
                referenceId,
            });

            const constrainValue = e.target.dataset.value;

            if (!constrainValue) return;
            referenceSelect.parentElement.classList.add("loading");
            document
                .getElementById(`${referenceId}-loader`)
                ?.classList.add("show");
            document
                .getElementById(`${referenceId}-info`)
                ?.classList.remove("show");

            try {
                // ✅ تحميل المدن عبر fetch (Vanilla JS)
                const response = await fetch(
                    `/dashboard/api/${reference}/${constrainId}/${constrainValue}`
                );

                if (!response.ok) {
                    let count = 1;
                    let counter = setInterval(() => {
                        count++;
                        console.log(count);
                        if (count >= 7) {
                            clearInterval(counter);
                            referenceSelect.parentElement.classList.add(
                                "loading"
                            );
                            document
                                .getElementById(`${referenceId}-loader`)
                                ?.classList.remove("show");
                            document
                                .getElementById(`${referenceId}-info`)
                                ?.classList.add("show");
                            console.log("please try again later;");
                            return;
                        }
                    }, 1000);
                }

                const data = await response.json();

                // ✅ تنظيف الخيارات القديمة
                referenceSelect.innerHTML = '<option value="">--</option>';

                if (data.length > 0) {
                    referenceSelect.disabled = false;
                    data.forEach((item) => {
                        const option = document.createElement("option");
                        option.value = item.id;
                        option.textContent = item.name;
                        referenceSelect.appendChild(option);
                    });
                } else {
                    // لو مفيش مدن
                    const option = document.createElement("option");
                    option.value = "";
                    option.textContent = "--";
                    referenceSelect.appendChild(option);
                }

                // ✅ إعادة تفعيل الـ special-search
                // ✅ إعادة تفعيل الـ special-search
                const existingWrapper = document.querySelector(
                    `[data-for="${referenceSelect.id}"]`
                );

                let previousSearchValue = "";
                if (existingWrapper) {
                    const input = existingWrapper.querySelector(".tag-input");
                    if (input) previousSearchValue = input.value; // 🟡 احفظ القيمة القديمة
                    existingWrapper.remove();
                }

                referenceSelect.parentElement.classList.remove("loading");
                document
                    .getElementById(`${referenceId}-loader`)
                    ?.classList.remove("show");

                // 🟢 إعادة بناء SpecialSearch
                window.SpecialSearch(referenceSelect);

                // 🟢 بعد إعادة البناء، رجّع القيمة القديمة لو فيه قيمة
                const newWrapper = document.querySelector(
                    `[data-for="${referenceSelect.id}"]`
                );
                if (newWrapper && previousSearchValue) {
                    const newInput = newWrapper.querySelector(".tag-input");
                    if (newInput) newInput.value = previousSearchValue;
                }

                // const existingWrapper = document.querySelector(
                //     `[data-for="${referenceSelect.id}"]`
                // );
                // if (existingWrapper) existingWrapper.remove();

                // referenceSelect.parentElement.classList.remove("loading");
                // document
                //     .getElementById(`${referenceId}-loader`)
                //     ?.classList.remove("show");
                // window.SpecialSearch(referenceSelect);
            } catch (error) {
                console.error("Error loading data:", error);
            }
        }
    };
}
