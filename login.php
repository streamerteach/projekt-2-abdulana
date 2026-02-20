<?php 
session_start();
include "includes/header.php";
?>

<div class="login-container">

<h2>Log in</h2>
<form method="post" action="login.php">
    <label>Username:</label><br>
    <input type="text" name="username"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <input type="submit" name="login" value="Log in">
</form>

<p>Don't have an account? <a href="register.php">Register here</a>.</p>

<?php
if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username != "" && $password != "") {

         $found = false;
    
        // Hardcodad admin inloggning
        if ($username == "abdulana" && $password == "Test123") {
            $found = true;
            $_SESSION["username"] = "abdulana";
            $_SESSION["last_login"] = date("Y-m-d H:i:s");

            print "<p>Welcome admin!</p>";
            print "<p>Last login: " . $_SESSION["last_login"] . "</p>";
            
            header("Location: index.php");
            exit;
        }
        
        $users = file("data/users.txt");

            // Vanliga användare
        foreach ($users as $user) {

            $parts = explode(" | ", trim($user));

            if (count($parts) < 4) {
                continue;
            }

            $name = $parts[0];
            $user_name = $parts[1];
            $email = $parts[2];
            $hash = $parts[3];

            // Kolla username + hash
            if ($username == $user_name && password_verify($password, $hash)) {

                $found = true;

                $_SESSION["username"] = $username;
                $_SESSION["last_login"] = date("Y-m-d H:i:s");

                print "<p>Welcome to Echo, $username</p>";
                print "<p>Last login: " . $_SESSION["last_login"] . "</p>";
                
                header("Location: index.php");
                exit;
            }
        }

        if (!$found) {
            print "<p>Incorrect username or password.</p>";
        }

    } else {
        print "<p>Please fill in both fields.</p>";
    }
}
?>

</div>

<?php
include "includes/footer.php";
?>