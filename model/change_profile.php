<?php

session_start(); // startar session

// Kollar att sidan nås via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Kollar att användaren är inloggad
    if (!isset($_SESSION["user_id"])) {
        die("Not logged in.");
    }

    $user_id = $_SESSION["user_id"];

    try {

        require_once "../db.php"; // kopplar till databasen

        /*  HÄMTA NUVARANDE DATA  */
        // Hämtar användarens nuvarande info
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        /* ===== HÄMTA DATA FRÅN FORM ===== */
        $username = $_POST["username"];
        $realname = $_POST["realname"];
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];
        $zipcode = $_POST["zipcode"];
        $bio = $_POST["bio"];
        $salary = $_POST["salary"];

        /*  OM FÄLT ÄR TOMMA -> BEHÅLL GAMLA  */
        if ($username == "") $username = $user["username"];
        if ($realname == "") $realname = $user["realname"];
        if ($email == "") $email = $user["email"];
        if ($zipcode == "") $zipcode = $user["zipcode"];
        if ($bio == "") $bio = $user["bio"];
        if ($salary == "") $salary = $user["salary"];

        /*  LÖSENORD  */
        if ($pwd == "") {
            // Om inget nytt lösenord -> behåll gamla
            $pwd = $user["pwd"];  
        } else {
            // Annars → hash nytt lösenord
            $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        }

        /*  UPDATE USER  */
        $sql = "UPDATE users 
                SET username = ?, realname = ?, email = ?, pwd = ?, zipcode = ?, bio = ?, salary = ?
                WHERE id = ?";

        $stmt = $pdo->prepare($sql);

        // Kör update med nya värden
        $stmt->execute([
            $username,
            $realname,
            $email,
            $pwd,
            $zipcode,
            $bio,
            $salary,
            $user_id
        ]);

        // Success message
        $_SESSION["success"] = "Profile updated successfully";

        // Tillbaka till profil sidan
        header("Location: ../my_profile.php");
        exit();

    } catch (PDOException $e) {
        // Om något går fel
        die("Query failed: " . $e->getMessage());
    }

}
