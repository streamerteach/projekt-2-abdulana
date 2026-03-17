<?php
    // Kollar att sidan nås via POST (från formulär)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Hämtar data från formuläret
    $username = $_POST["username"] ?? "";
    $realname = $_POST["realname"] ?? "";
    $email = $_POST["email"] ?? "";

    // Hashar lösenordet 
    $password = password_hash($_POST["pwd"] ?? "", PASSWORD_DEFAULT);

    $zipcode = $_POST["zipcode"] ?? "";
    $bio = $_POST["bio"] ?? "";
    $salary = $_POST["salary"] ?? "";

    try {
        // Kopplar till databasen
        require_once "../db.php";

         // SQL query för att lägga till ny användare
        $sql = "INSERT INTO users 
        (username, realname, email, pwd, zipcode, bio, salary)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Förbereder query
        $stmt = $pdo->prepare($sql);

         // Kör queryn med värden från formuläret
        $stmt->execute([
        $username,
        $realname,
        $email,
        $password,
        $zipcode,
        $bio,
        $salary
        ]);

         // Skickar användaren till login efter registrering
        header("Location: ../login.php");
        exit();

        } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
        }

    } else {
        // Om man försöker gå hit utan POST -> tillbaka till signup
        header("Location: ../signup.php");
        exit();

    }