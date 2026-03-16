<section class="left-section">
<h2>Profiles</h2>

<?php
foreach ($profiles as $row) {

    print "<div class='post'>";
    print "<h3>Username: " . htmlspecialchars($row["username"]) . "</h3>";
    print "<p>Zipcode: " . htmlspecialchars($row["zipcode"]) . "</p>";
    print "<p>Bio: " . htmlspecialchars($row["bio"]) . "</p>";

    if (isset($_SESSION["user_id"])) {
        print "<p>Email: " . htmlspecialchars($row["email"]) . "</p>";
        print "<p>Salary: " . htmlspecialchars($row["salary"]) . "</p>";
    }

    // VIEW PROFILE BUTTON
    print "<a class='view-profile-btn' href='profile.php?id=" . $row["id"] . "'>View Profile</a>";

    print "</div>";
}
?>
</section>