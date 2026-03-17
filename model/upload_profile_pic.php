<?php
session_start(); // startar session (för att veta vem som är inloggad)

// Kollar om användaren är inloggad
if (!isset($_SESSION["username"])) {
    die("Not logged in.");
}

// Hämtar username från session
$username = $_SESSION["username"];


$uploadsDir = __DIR__ . "/../uploads/";

// Kollar om en fil har skickats via formuläret
if (isset($_FILES["profile_pic"])) {

    // Temporär fil (där filen ligger innan den sparas)
    $fileTmp = $_FILES["profile_pic"]["tmp_name"];
    // Original filnamn
    $fileName = $_FILES["profile_pic"]["name"];

    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Skapar ett unikt namn: username + timestamp
    $newName = $username . "_" . time() . "." . $extension;

     // Flyttar filen från temp till uploads-mappen
    if (move_uploaded_file($fileTmp, $uploadsDir . $newName)) {
         // Om det lyckas -> spara success message
        $_SESSION["success"] = "Profile picture uploaded successfully";
    } else {
         // Om det misslyckas -> spara error message
        $_SESSION["error"] = "Upload failed";
    }
}
// Skickar tillbaka användaren till profil-sidan
header("Location: ../my_profile.php");
exit();
