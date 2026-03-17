<?php
// Startar session om den inte redan är startad
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kollar om användaren är inloggad
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];

    $uploadsDir = __DIR__ . "/../uploads/"; 

    $profile = "test.png"; // Standard profilbild om ingen finns

    // Kollar om uploads-mappen finns
    if (is_dir($uploadsDir)) {
        $files = scandir($uploadsDir); // Hämtar alla filer i mappen

        // Loopar igenom alla filer
        foreach ($files as $file) {
            // Kollar om filen börjar med username_
            if (strpos($file, $username . "_") === 0) {
                // Sätter den som profilbild (senaste matchen i listan)
                $profile = $file;
            }
        }
    }

    // Kontrollera att filen verkligen finns, om inte -> använd default bild
    if (!file_exists($uploadsDir . $profile)) {
        $profile = "test.png";
    }

    // Visar profilbild (klickbar → går till min profil)
    print '<a href="my_profile.php" class="profile-bubble">';
    print '<img src="uploads/' . htmlspecialchars($profile) . '" alt="Profile">';
    print '</a>';
    // Logout knapp
    print '<a href="logout.php" class="logout-bubble">Logout</a>';
} else {
    // Om inte inloggad → visa login knapp
    print '<a href="login.php" class="login-bubble">Login</a>';
}
?>