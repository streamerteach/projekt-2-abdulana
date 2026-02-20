if (typeof secondsLeft !== "undefined") {

    // En funktion som uppdaterar nedräkningen varje sekund
    function updateCountdown() {

        // Om tiden är slut
        if (secondsLeft <= 0) {
            document.getElementById("countdown").innerHTML = "The date has been reached!";
            return;
        }

        // Räknar ut dagar, timmar, minuter och sekunder
        var days = Math.floor(secondsLeft / 86400);
        var hours = Math.floor((secondsLeft % 86400) / 3600);
        var minutes = Math.floor((secondsLeft % 3600) / 60);
        var seconds = secondsLeft % 60;

        // Skriver ut resultatet i HTML elementet med id (countdown)
        document.getElementById("countdown").innerHTML =
            "Time left: " + days + " days " +
            hours + " hours " +
            minutes + " minutes " +
            seconds + " seconds";

        secondsLeft--;
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
}

// Cookie-banner funktioner
document.getElementById("accept-all")?.addEventListener("click", function() {
        document.cookie = "cookie_consent=all; path=/; max-age=" + (60*60*24*365);
        document.getElementById("cookie-banner").style.display = "none";
});

document.getElementById("necessary-only")?.addEventListener("click", function() {
        document.cookie = "cookie_consent=necessary; path=/; max-age=" + (60*60*24*365);
        document.getElementById("cookie-banner").style.display = "none";
});