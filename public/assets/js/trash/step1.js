let fileTypeIds = document.querySelectorAll(".fileTypeIds");
if (fileTypeIds.length > 0) {
    fileTypeIds.forEach((checkbox) => {
        checkbox.addEventListener("change", (event) => {
            toggleDisplayTarget("filetype", event.target.id);
        });
    });
}

let validOptions = document.querySelectorAll(".validOptions");
if (validOptions.length > 0) {
    validOptions.forEach((radio) => {
        radio.addEventListener("change", (event) => {
            if (event.target.id == "for_all_nationalities_checkbox") {
                document.querySelector(
                    `[data-validoption-target="one_nationality_only_checkbox"]`
                ).style.display = "none";
                return;
            }

            console.log(event.target.value);

            toggleDisplayTarget("validoption", event.target.id);
        });
    });
}

function toggleDisplayTarget(targetId, elementId) {
    let target = document.querySelector(
        `[data-${targetId}-target="${elementId}"]`
    );
    if (target) {
        target.style.display = event.target.checked ? "block" : "none";
        target.style.visibility = event.target.checked ? "visible" : "hidden";
    }
}
