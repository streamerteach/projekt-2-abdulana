<?php
session_start();
include "includes/header.php";

// Skickar användaren till login om den inte är inloggad
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}
?>

<div class="profile-container"></div>

<h2>Your profile</h2>

<?php

$username = $_SESSION["username"];

if ($username === "abdulana") {
    print "<p><strong>Name:</strong> abdulana</p>";
    print "<p><strong>Username:</strong> $username</p>";
    print "<p><strong>Email:</strong> abdulana@arcada.fi</p>";
} else {
    $users = file("data/users.txt");

    foreach ($users as $user) {
        $parts = explode(" | ", trim($user));
        $name = $parts[0];
        $user_name = $parts[1];
        $email = $parts[2];

        if ($user_name == $username) {
            print "<p><strong>Name:</strong> $name</p>";
            print "<p><strong>Username:</strong> $user_name</p>";
            print "<p><strong>Email:</strong> $email</p>";
            break;
        }
    }
}
?>

<h3>Upload profile picture</h3>

<form method="post" action="upload.php" enctype="multipart/form-data">
    <input type="file" name="image">
    <input type="submit" name="upload" value="Upload">
</form>

<?php 

// Hanterar uppladdning
if (isset($_POST["upload"])) {

    $file = $_FILES["image"];
    $name = $file["name"];
    $tmp = $file["tmp_name"];

    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    if ($ext == "jpg" || $ext == "png") {

        $newName = $username . "_" . time() . "." . $ext;

        move_uploaded_file($tmp, "uploads/" . $newName);

        print "<p>File uploaded successfully.</p>";

    } else {
        print "<p>Only JPG and PNG files are allowed.</p>";
    }
}
?>

<h3>Your previous profile pictures</h3>

<?php
$images = scandir("uploads/");

foreach ($images as $img) {
    if ($img != "." && $img != "..") {
        print "<img src='uploads/$img' width='120' style='margin:5px;'>";
    }
}
?>

</div>

<?php include "includes/footer.php"; ?>