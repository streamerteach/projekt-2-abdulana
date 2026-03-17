<?php

session_start(); // startar session så vi vet vem som är inloggad

// Om man inte är inloggad -> skicka till login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

require_once "db.php"; 

$user_id = $_SESSION["user_id"];

// Hämtar användarens info från databasen
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC); // sparar all user data i array

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Profile</title>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/index.css">

<script src="js/script.js" defer></script>
<script src="js/cookie.js" defer></script>
</head>

<body>

<div id="container">

<?php include "header.php"; ?> 

<!-- TOP SECTION -->
<div class="profile-top">
    <div class="profile-info">
        <h2>Profile info</h2>

        <!-- Visar användarens info -->
        <p><strong>Username:</strong> <?php print htmlspecialchars($user["username"]); ?></p>
        <p><strong>Realname:</strong> <?php print htmlspecialchars($user["realname"]); ?></p>
        <p><strong>Email:</strong> <?php print htmlspecialchars($user["email"]); ?></p>
        <p><strong>Zipcode:</strong> <?php print htmlspecialchars($user["zipcode"]); ?></p>
        <p><strong>Bio:</strong> <?php print htmlspecialchars($user["bio"]); ?></p>
        <p><strong>Salary:</strong> <?php print htmlspecialchars($user["salary"]);?></p>
    </div>

    <div class="profile-upload">
        <h2>Upload profile picture</h2>

        <!-- Form för att ladda upp profilbild -->
        <form action="model/upload_profile_pic.php" method="post" enctype="multipart/form-data">
            <input type="file" name="profile_pic" required>
            <button type="submit">Upload</button>
        </form>
    </div>

</div>

<!-- PREVIOUS PICTURES -->
<section class="profile-pictures">
<h2>Previous profile pictures</h2>
<div class="previous-pics">
<?php
// Hämtar username för att matcha filnamn
$username = $user["username"]; 
$uploadsDir = "uploads/"; 

// Kollar om mappen finns
if (is_dir($uploadsDir)) {

    $files = scandir($uploadsDir); // hämtar alla filer i mappen

    // loopar igenom alla filer
    foreach ($files as $file) {

        // visar bara bilder som börjar med username
        if (strpos($file, $username . "_") === 0) {

            print '<img src="uploads/' . htmlspecialchars($file) . '">';

        }
    }
}
?>
</div>
</section>

<!-- ACTION BUTTONS -->
<section class="profile-actions">
    <div class="profile-change-acc">

        <h3>Change profile</h3>

        <!-- Form för att uppdatera profil -->
        <form action="model/change_profile.php" method="post" class="change-form">

            <!-- Fälten är ifyllda med användarens info -->
            <input type="text" name="username" value="<?php print htmlspecialchars($user['username']); ?>"> 
            <input type="text" name="realname" value="<?php print htmlspecialchars($user['realname']); ?>">
            <input type="text" name="email" value="<?php print htmlspecialchars($user['email']); ?>">
            <input type="text" name="zipcode" value="<?php print htmlspecialchars($user['zipcode']); ?>">

            <textarea name="bio"><?php print htmlspecialchars($user['bio']); ?></textarea>
            <input type="number" name="salary" placeholder="Salary" value="<?php print htmlspecialchars($user['salary']); ?>"><br>
                
            <button>Update</button>
        </form>
    </div>


    <div class="profile-delete-acc">

    <h3>Delete account</h3>

    <?php
    // Visar error message om något gick fel (t.ex fel lösenord)
    if (isset($_SESSION["error"])) {
        print '<p class="error">' . $_SESSION["error"] . '</p>';
        unset($_SESSION["error"]); 
    }
    ?>

       <!-- Form för att radera konto -->
       <form action="model/delete_account.php" method="post" class="delete-form">

            <input type="password" name="pwd" placeholder="Password" required>

            <!-- En confirm popup -->
            <button onclick="return confirm('Are you sure you want to delete your account?');">
                Delete
            </button>

        </form>

    </div>
</section>


<?php include "footer.php"; ?> 

</div>
