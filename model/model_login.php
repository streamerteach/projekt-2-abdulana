<?php
session_start();  // startar session (för login + error messages)

// Kollar att sidan nås via POST (från login-form)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once "../db.php"; // kopplar till databasen

    // Hämtar input från formuläret
    $username = trim($_POST["username"]); // tar bort extra spaces
    $pwd      = $_POST["pwd"];

    // Kollar om något fält är tomt
    if (empty($username) || empty($pwd)) {

        // Sparar error i session (visas på login-sidan)
        $_SESSION['error_message'] = "You must fill in all fields";
        header("Location: ../login.php"); // Skicka användaren tillbaka till login-sidan
        exit();
    }

    try {
       // Hämtar användare från databasen baserat på username
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindValue(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
             // Kollar om lösenordet stämmer (hash jämförelse)
            if (password_verify($pwd, $user['pwd'])) {

                // Login OK -> spara info i session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                 // Skicka till startsidan
                header("Location: ../index.php"); 
                exit();
            } else {
                 // Fel lösenord
                $_SESSION['error_message'] = "Wrong password";
                header("Location: ../login.php");
                exit();
            }
        } else {
            // Användaren finns inte
            $_SESSION['error_message'] = "The user does not exist";
            header("Location: ../login.php");
            exit();
        }

    } catch (PDOException $e) {
        // Om något går fel i databasen
        die("Query failed: " . $e->getMessage());
    }

} else {
    // Om man försöker gå hit utan POST
    header("Location: ../login.php");
    exit();
}