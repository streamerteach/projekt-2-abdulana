<?php
include "includes/header.php";

// Genererar random lösenord
//Med standardläng: 12 tecken
function generatePassword($length = 12)
    {$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
    return substr(str_shuffle($chars), 0, $length);}
?>

<h2>Create an account</h2>

<form method="post" action="register.php">
    <label>Name:</label><br>
    <input type="text" name="name"><br><br>

    <label>Username:</label><br>
    <input type="text" name="username"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <input type="submit" name="register" value="Register">
</form>

<p>Already have an account? <a href="login.php">Log in here</a>.</p>

<?php 
if (isset($_POST["register"])) {

    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];

    // Kollar att båda fälten är ifyllda
    if ($username != "" && $email != "") {
        
        // Skapar ett slumpat lösenord
        $password = generatePassword(12);

        // Hashar lösenordet
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Skapar en rad som sparas i users.txt
        $user = $name . " | " . $username . " | " . $email . " | " . $hash . "\n";

        // Sparar användaren i textfilen
        file_put_contents("data/users.txt", $user, FILE_APPEND);

        // Visar att kontot skapats + lösenordet
        print "<p>Your account has been created!</p>";
        print "<p><strong>Your password is: $password</strong></p>";
    } else {
        print "<p>Please fill in all fields.</p>";
    }
}

include "includes/footer.php";
?>