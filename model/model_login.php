<?php
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once "../db.php";

    // Hämta input
    $username = trim($_POST["username"]);
    $pwd      = $_POST["pwd"];

    // Kontrollera tomma fält
    if (empty($username) || empty($pwd)) {
        // Sätt sessionfelmeddelande för att visa på login-sidan
        $_SESSION['error_message'] = "You must fill in all fields";
        header("Location: ../login.php"); // Skicka användaren tillbaka till login-sidan
        exit();
    }

    try {
        // Hämta användare från databasen
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindValue(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Kontrollera lösenord
            if (password_verify($pwd, $user['pwd'])) {
                // Inloggning lyckades, spara info i session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header("Location: ../index.php"); // Valfri sida efter login
                exit();
            } else {
                die("Fel lösenord.");
            }
        } else {
            // Sätt ett sessionmeddelande för att visa på login-sidan
            $_SESSION['error_message'] = "The user does not exist";
            header("Location: ../login.php");
            exit();
        }

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../login.php");
    exit();
}