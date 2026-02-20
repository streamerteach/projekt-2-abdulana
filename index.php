<?php
session_start();

// Skickar användaren till login om den inte är inloggad
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

include "includes/functions.php";
include "includes/header.php";
?>

<!-- Cookie-banner -->
 <?php if (!isset($_COOKIE["cookie_consent"])): ?>
<div id="cookie-banner">
    <p>We use cookies to improve your experience.</p>
    <button id="accept-all">Accept all</button>
    <button id="necessary-only">Necessary only</button>
</div>
<?php endif; ?>

<?php

// Kollar om användaren har varit här förut med ($_COOKIE)
$first_visit = $_COOKIE["first_visit"] ?? date("Y-m-d H:i:s");

if (!isset($_COOKIE["first_visit"])) {
    // Om det är first visit så skapar den cookie och hälsar välkommen
    setcookie("first_visit", date("Y-m-d H:i:s"), time() + (86400 * 365));  // 1år
    print "Welcome to Echo! This is your first visit.";
} else {
    // Om cookie finns så visar det när personen har var här första gången
    print "<p>Welcome back! You first visited Echo on: " . $_COOKIE["first_visit"] . "</p>";
}



// Räknar hur många unika användare som varit inne (baserat på username)
// Alla unika besökare sparas i filen visits.txt
$visits = count_visits();
print "<p>Number of unique visitors: " . $visits . "</p>";


// Visar serverinfo 
print "<h3>Server Information</h3>";
print "<p>PHP version: " . phpversion() . "</p>";
print "<p>Server software: " . $_SERVER["SERVER_SOFTWARE"] . "</p>";
?>

<hr>

<h2>Select a date:</h2>

<form method="post" action="index.php">
    <label>Enter your date (YYYY-MM-DD):</label><br>
    <input type="date" name="date"><br><br>
    <input type="submit" value="Calculate">
</form>

<?php 
// Räknar ut hur länge det är kvar
$date = $_POST["date"] ?? "";

if ($date != "") {
    $date = str_replace(["<", ">"], "", $date);

    $now = time();
    $future = strtotime($date);

    if ($future > $now) {
        $seconds_left = $future - $now;
        $days = floor($seconds_left / 86400);

        print"<p>There are $days days left.</p>";
        print "<script>var secondsLeft = $seconds_left;</script>";
    } else {
        print "<p>The date is in the past.</p>"; 
    }
}

// Funktion för att skriva ut dagens datum i finskt format
function formatFinnishDate() {
    $days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
   
    $dayName = $days[date("w")];
    $dayNum = date("j");
    $monthName = $months[date("n") - 1];
    return "$dayName $dayNum $monthName";
}
?>

<!-- Här visas nedräkningen -->
<div id="countdown"></div>

<?php
print "<p>Today is: <strong>" . formatFinnishDate() . "</strong></p>";
?>

<?php
include "includes/footer.php";
?>