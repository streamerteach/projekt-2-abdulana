<?php
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $uploadsDir = __DIR__ . "/../uploads/"; // folder relative to this file
    $files = [];

    // Make sure the uploads folder exists
    if (is_dir($uploadsDir)) {
        $files = scandir($uploadsDir);
    }

    $profile = "test.png"; // default profile picture

    // Find the latest profile picture for this user
    foreach ($files as $file) {
        if (strpos($file, $username . "_") === 0) {
            $profile = $file;
        }
    }


    // Separate bubbles for profile + logout
    print '<a href="/echo/my_profile.php" class="profile-bubble">';
    print '<img src="/echo/uploads/' . $profile . '" alt="Profile">';
    print '</a>';

    print '<a href="/echo/logout.php" class="logout-bubble">Logout</a>';

} else {
    // Not logged in → show login/signup
    print '<a href="/echo/login.php" class="login-bubble">Login</a>';
}
?>