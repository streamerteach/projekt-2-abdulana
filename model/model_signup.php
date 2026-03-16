<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"] ?? "";
    $realname = $_POST["realname"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = password_hash($_POST["pwd"] ?? "", PASSWORD_DEFAULT);
    $zipcode = $_POST["zipcode"] ?? "";
    $bio = $_POST["bio"] ?? "";
    $salary = $_POST["salary"] ?? "";

    try {
        require_once "../db.php";

        $sql = "INSERT INTO users 
                (username, realname, email, pwd, zipcode, bio, salary)
                 VALUES (?, ?, ?, ?, ?, ?, ?);";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $username,
            $realname,
            $email,
            $password,
            $zipcode,
            $bio,
            $salary
        ]);

        $pdo = null;
        $stmt = null;

        header("Location: ../signup.php");
        exit();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../signup.php");
}