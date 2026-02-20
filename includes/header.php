<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projekt 1</title>

<link rel="stylesheet" href="style.css">
</head>

<body>
<header class="header">

    <!-- Vänster, Logo / Titel -->
    <div class="header-logo">
        <h1><a href="index.php">Echo</a></h1>
    </div>

    <!-- Mitten, Navigation -->
    <nav class="header-nav">
        <a href="index.php">Home</a>
        <a href="upload.php">Profile</a>
        <a href="guestbook.php">Guestbook</a>
        <a href="rapport.php">Rapport</a>
    </nav>

    <!-- Höger, Login / Logout -->
    <div class="header-auth">
        <?php 
        if (isset($_SESSION["username"])) {

            $username = $_SESSION["username"];
            $files = scandir("uploads/");
            $profile = "../uploads/test.png"; // fallback om ingen bild finns

            // Hittar senaste profilbilden
            foreach ($files as $file) {
                if (strpos($file, $username . "_") === 0) {
                    $profile = $file;
                }
            }

            // Visa profilbilden
            print '<a href="upload.php" id="profile-link">
                    <img src="uploads/' . $profile . '" id="profile-img">
                    </a>';

            // Visa logout
                print '<a href="logout.php" id="logout-link">Logout</a>';
            } else {
                print '<a href="login.php" id="login-link">Login / Signup</a>';
        }
        ?>
    </div>
</header>