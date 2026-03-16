// Cookie

const cookieBanner = document.getElementById("cookie-banner");
const acceptAll = document.getElementById("accept-all");
const necessaryOnly = document.getElementById("necessary-only");

// Visa bannern om cookien inte finns
if (!document.cookie.includes("cookie_consent")) {
    cookieBanner.style.display = "block";
}

// Klick på Accept All
acceptAll.onclick = function () {
    document.cookie = "cookie_consent=all; max-age=" + 60*60*24*365 + "; path=/";
    cookieBanner.style.display = "none";
};

// Klick på Only Necessary
necessaryOnly.onclick = function () {
    document.cookie = "cookie_consent=necessary; max-age=" + 60*60*24*365 + "; path=/";
    cookieBanner.style.display = "none";
};