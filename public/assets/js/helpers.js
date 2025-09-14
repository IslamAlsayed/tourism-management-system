// ======= Helpers =======
window.closeAllDropdown = function () {
    document
        .querySelectorAll(".multi-select-tag .dropdown")
        .forEach((dropdown) => dropdown.classList.add("hidden"));
};

window.loadData = function (container = null) {
    let containerHotels =
        container || document.getElementById("containerHotels");
    let loader = document.createElement("div");
    loader.className = "loader";
    if (containerHotels) {
        containerHotels.appendChild(loader);
    }
};
