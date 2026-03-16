// Drakmode

// Hämta toggle-knappen
const toggle = document.getElementById('themeToggle');

// Applicera sparad inställning direkt
if (localStorage.getItem('theme') === 'dark') {
    document.documentElement.setAttribute('data-theme', 'dark');
    if (toggle) toggle.textContent = "Light Mode";
} else {
    if (toggle) toggle.textContent = "Dark Mode";
}

// Byt theme när knappen klickas
if (toggle) {
    toggle.addEventListener('click', () => {
        if (document.documentElement.getAttribute('data-theme') === 'dark') {
            document.documentElement.removeAttribute('data-theme');
            localStorage.setItem('theme', 'light');
            toggle.textContent = "Dark Mode";
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            toggle.textContent = "Light Mode";
        }
    });
}

// countdown
if (typeof secondsLeft !== "undefined") {

    function updateCountdown() {

        let days = Math.floor(secondsLeft / 86400);
        let hours = Math.floor((secondsLeft % 86400) / 3600);
        let minutes = Math.floor((secondsLeft % 3600) / 60);
        let seconds = secondsLeft % 60;

        document.getElementById("countdown").innerHTML =
            days + " days " +
            hours + " hours " +
            minutes + " minutes " +
            seconds + " seconds";

        if (secondsLeft > 0) {
            secondsLeft--;
        }
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
}