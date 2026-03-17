<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="js/script.js" defer></script>
    <script src="js/cookie.js" defer></script>
</head>
<body>

    <div id="container">
        <?php include "header.php" ?>

        <section>
            <article>
                <?php include "view/view_signup.php" ?>
            </article>
        </section>

        <?php include "footer.php" ?>
    </div>
