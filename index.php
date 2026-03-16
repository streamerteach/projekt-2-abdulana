<?php
require_once "db.php";

// Hämta de senaste 5 profilerna
try {
    $stmt = $pdo->prepare("SELECT * FROM users ORDER BY id DESC LIMIT 4");
    $stmt->execute();

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

    <!-- Filter section  (Sortering uppg 5) -->
    <section class="filter-section">
    </section>

    
    <div class="content-section">
        <!-- LEFT SIDE -->
        <section class="left-section">
            <article>
                <?php include "view/view_profiles.php" ?>
            </article>
        </section>


            <!-- RIGHT SIDE -->
            <aside class="right-section">

                <section class="info-box">
                <?php
                if (isset($_SESSION['username'])) {
                    // Check if this is the first visit in this session
                    if (!isset($_SESSION['first_visit'])) {
                        // First visit
                        $_SESSION['first_visit'] = true;
                        echo '<h3 class="greetings">Welcome ' . htmlspecialchars($_SESSION['username']) . '! This is your first visit.</h3>';
                    } else {
                        // Not the first visit
                        echo '<h3 class="greetings">Welcome back, ' . htmlspecialchars($_SESSION['username']) . '</h3>';
                    }
                }
                ?>
                </section>
                <hr>
                <!-- Datumräknare -->
                <section class="info-box date-box">
                    <h3>Select a date</h3>

                    <form method="post" action="index.php">
                        <input type="date" name="date"><br><br>
                        <input id="submit-btn" type="submit" value="Calculate">
                    </form>

                    <?php
                    $date = $_POST["date"] ?? "";

                    if ($date != "") {

                        $date = str_replace(["<", ">"], "", $date);

                        $now = time();
                        $future = strtotime($date);

                        if ($future > $now) {

                            $seconds_left = $future - $now;
                            print "<p class='date-success'>Countdown started!</p>";
                            print "<script>var secondsLeft = $seconds_left;</script>";
                        } else {
                            print "<p class='date-error'>The selected date is in the past</p>";
                        }
                    }
                    ?>
                    <p id="countdown"></p>
                </section>
                <hr>
                <section class="info-box visitors-box">
                    <h3>Unique Visitors</h3>
                    <?php 
                    try {
                        // Count all registered users
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
                <section class="info-box server-box">
                    <h3>Server Info</h3>
                    <p>PHP version: <?= phpversion(); ?></p>
                    <p>Server: <?= $_SERVER['SERVER_SOFTWARE']; ?></p>
                </section>

            </aside>
    <div>

   
</div>
 <?php include "footer.php" ?>