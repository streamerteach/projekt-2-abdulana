
<header class="main-header">
   <!-- LOGO -->
    <div class="header-logo">
        <a href="index.php">
            <img src="media/echo5.png" alt="Website logo" />
        </a>
    </div>



   <!-- NAVIGATION -->
    <div class="header-nav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="guestbook.php">Guestbook</a></li>
            <li><a href="my_profile.php">My Profile</a></li>
        </ul>
    </div>

    <!-- DARK MODE KNAPP -->
    <div class="header-theme">
        <button id="themeToggle">Dark Mode</button>
    </div>

    <!-- USER SECTION -->
    <div class="header-user">
        <?php include_once "model/profile_pic.php"; ?>
    </div>
</header>