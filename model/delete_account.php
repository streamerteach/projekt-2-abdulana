<?php

session_start();

// Kollar att användaren är inloggad
if (!isset($_SESSION["user_id"])) {
    die("Not logged in.");
}

require_once "../db.php";

// Hämtar user_id från session och lösenord från formulär
$user_id = $_SESSION["user_id"];
$password = $_POST["pwd"] ?? "";



/* HÄMTA LAGRAT LÖSENORD  */

// Hämtar användarens hashade lösenord från databasen
$stmt = $pdo->prepare("SELECT pwd FROM users WHERE id = ?");
$stmt->execute([$user_id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Om användaren inte finns
if (!$user) {
    die("User not found.");
}

/*  VERIFY PASSWORD  */

// Kollar om lösenordet stämmer
if (!password_verify($password, $user["pwd"])) {

    // Fel lösenord -> skicka tillbaka med error
    $_SESSION["error"] = "Wrong password.";
    header("Location: ../my_profile.php");
    exit();
}


/*  DELETE ACCOUNT  */

// Tar bort användaren från databasen
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$user_id]);


// Tar bort hela sessionen (användaren loggas ut)
session_destroy();

// Skickar användaren till startsidan
header("Location: ../index.php");
exit();
