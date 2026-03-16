<?php
// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="main-header">
    <!-- Logo -->
    <div class="header-logo">
        <a href="/echo/index.php">
            <img src="/echo/media/echo5.png" alt="Website logo" />
        </a>
    </div>



    <!-- Navigation links -->
    <div class="header-nav">
        <ul>
            <li><a href="/echo/index.php">Home</a></li>
            <li><a href="/echo/guestbook.php">Guestbook</a></li>
            <li><a href="/echo/my_profile.php">My Profile</a></li>
        </ul>
    </div>

    <!-- Darkmode toggle -->
    <div class="header-theme">
        <button id="themeToggle">Dark Mode</button>
    </div>

    <!-- USER SECTION -->
    <div class="header-user">
        <?php include "model/profile_pic.php"; ?>
    </div>
</header>