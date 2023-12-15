
function checkCookiesConsent() {
    var cookiesConsent = localStorage.getItem("cookiesConsent");
    if (!cookiesConsent) {
        openBox();
    } else if (cookiesConsent === "rejected") {
        openBox();
    }
}

function acceptCookies(event) {
    event.stopPropagation();
    localStorage.setItem("cookiesConsent", "accepted");
    closeBox();
}

function rejectCookies(event) {
    event.stopPropagation(); 
    localStorage.setItem("cookiesConsent", "rejected");
    openBox();
}

function openBox() {
    var cookiesConsent = localStorage.getItem("cookiesConsent");
    
    if (!cookiesConsent || cookiesConsent === "rejected") {
        var blurBg = document.querySelector(".blur-bg");
        if (!blurBg) {
            blurBg = document.createElement("div");
            blurBg.classList.add("blur-bg");
            document.body.appendChild(blurBg);
        }
    }

    var popup = document.getElementById("myForm");
    popup.style.display = "block";

    var formButtons = document.querySelectorAll("form button");
    formButtons.forEach(function(button) {
        button.disabled = true;
    });

    var openButton = document.querySelector(".open-button");
    openButton.disabled = true;
}


function closeBox() {
    var blurBg = document.querySelector(".blur-bg");
    if (blurBg) {
        document.body.removeChild(blurBg);
    }

    // Ukryj popup
    var popup = document.getElementById("myForm");
    popup.style.display = "none";

    var formButtons = document.querySelectorAll("form button");
    formButtons.forEach(function(button) {
        button.disabled = false;
    });
    var openButton = document.querySelector(".open-button");
    openButton.disabled = false;
}

checkCookiesConsent();
