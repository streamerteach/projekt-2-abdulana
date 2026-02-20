<?php 
session_start();
include "includes/header.php";

// Skickar användaren till login om den inte är inloggad
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}
?>

<h2>Guestbook</h2>

<form method="post" action="guestbook.php">
    <textarea name="comment"></textarea><br><br>
    <input type="submit" name="send" value="Post">
</form>

<?php
// Sparar kommentarer
if (isset($_POST["send"])) {

    $user = $_SESSION["username"];
    $comment = $_POST["comment"];
    $time = date("Y-m-d H:i:s");

    if ($comment != "") {
        $line = $user . " | " . $time . " | " . $comment . "\n";
        file_put_contents("data/guestbook.txt", $line, FILE_APPEND);
    }
}

// Skapar fil om den saknas
if (!file_exists("data/guestbook.txt")) {
    file_put_contents("data/guestbook.txt", "");
}

// Läser kommentarer
$comments = file("data/guestbook.txt");
$comments = array_reverse($comments);

foreach ($comments as $row) {
    print "<p>$row</p>";
}

include "includes/footer.php";
?>