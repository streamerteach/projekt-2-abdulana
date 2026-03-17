<?php
require_once "db.php";  

// Hämtar de senaste 4 användarna från databasen
try {
    $stmt = $pdo->prepare("SELECT * FROM users ORDER BY id DESC LIMIT 4");
    $stmt->execute();

     // Sparar alla profiler i en array
    $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    print "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>echo</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="js/script.js" defer></script>
    <script src="js/cookie.js" defer></script>
</head>
<body>


<!-- Cookie banner -->
<div id="cookie-banner">
    <p>We use cookies to improve your experience</p>
    <button id="accept-all">Accept all</button>
    <button id="necessary-only">Only necessary</button>
</div>


<div id="container">
    <?php include "header.php"?>

    <div class="content-section">
        <!-- LEFT SIDE -->
        <section class="left-section">
            <article>
                <?php include "view/view_profiles.php" ?>
            </article>
        </section>

        <!-- RIGHT SIDE -->
        <aside class="right-section">
            <!-- Välkomstmeddelande + cookie -->
            <section class="info-box">
            <?php
            if (isset($_SESSION['username'])) {
                $username = htmlspecialchars($_SESSION['username']);
                
                if (isset($_COOKIE['last_visit'])) {
                    // Om användaren varit inne tidigare
                    $lastVisit = date("Y-m-d", $_COOKIE['last_visit']);
                    print "<h3 class='greetings'>Welcome back, $username! Last time you were here: $lastVisit</h3>";
                } else {
                    // Första gången användaren är inne
                    print "<h3 class='greetings'>Welcome $username! This is your first visit.</h3>";
                }
                // Sparar senaste besök i en cookie (30 dagar)
                setcookie("last_visit", time(), time() + (86400 * 30));
            }
            ?>
            </section>

            <hr>
            <!-- Datumräknare -->
            <section class="info-box date-box">
                <h3>Select a date</h3>

                <!-- Form där användaren väljer datum -->
                <form method="post" action="index.php">
                    <input type="date" name="date"><br><br>
                    <input id="submit-btn" type="submit" value="Calculate">
                </form>

                <?php
                // Hämtar datum från form
                $date = $_POST["date"] ?? "";

                if ($date != "") {

                    $date = str_replace(["<", ">"], "", $date);

                    $now = time();
                    $future = strtotime($date);

                    if ($future > $now) {

                        $seconds_left = $future - $now;
                        print "<p class='date-success'>Countdown started!</p>";
                        // Skickar till JS så countdown
                        print "<script>var secondsLeft = $seconds_left;</script>";
                    } else {
                        // Om datumet har passerat
                        print "<p class='date-error'>The selected date is in the past</p>";
                    }
                }
                ?>
                <!-- Här visas countdown via JS -->
                <p id="countdown"></p>
            </section>

            <hr>

            <!-- ANTAL ANVÄNDARE -->
            <section class="info-box visitors-box">
                <h3>Unique Visitors</h3>
                <?php 
                try {
                    // Räknar hur många users finns i databasen
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users");
                    $stmt->execute();
                    $count = $stmt->fetchColumn();

                    print htmlspecialchars($count);

                } catch (PDOException $e) {
                    print "Error: " . $e->getMessage();
                }
                ?>
            </section>

            <hr>

            <!-- SERVER INFO -->
            <section class="info-box server-box">
                <h3>Server Info</h3>
                <p>PHP version: <?php print phpversion(); ?></p>
                <p>Server: <?php print $_SERVER['SERVER_SOFTWARE']; ?></p>

            </section>
        </aside>
<div>

</div>
<?php include "footer.php" ?>