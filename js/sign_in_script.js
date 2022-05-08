function initialize() {
    let emailElement = document.getElementById("email");
    let passwordElement = document.getElementById("password");

    emailElement.addEventListener("click", elementClick, false);
    passwordElement.addEventListener("click", elementClick, false);
}

function elementClick(e) {
    e.target.classList.remove("errorField");
}

window.addEventListener("load", initialize);