<?php
session_start(); 
require_once "db.php"; 

// Kollar om användaren är inloggad
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // 
    exit; // 
}

// Hämtar user_id från session
$user_id = $_SESSION['user_id'];

// Hämtar comment_id från form (POST)
$comment_id = $_POST['comment_id'] ?? null;

// Om ingen kommentar skickades -> gå tillbaka
if (!$comment_id) {
    header("Location: profile.php");
    exit;
}

// Kollar om användaren redan har likat denna kommentar
$stmt = $pdo->prepare("
SELECT * FROM comment_likes
WHERE user_id = ? AND comment_id = ?
");
$stmt->execute([$user_id, $comment_id]);

$liked = $stmt->fetch(); // om något hittas har användaren redan likat

if ($liked) {
    //  TA BORT LIKE 
    // Tar bort raden från comment_likes (unlike)
    $stmt = $pdo->prepare("
    DELETE FROM comment_likes
    WHERE user_id = ? AND comment_id = ?
    ");
    $stmt->execute([$user_id, $comment_id]);

    // Minskar likes med 1 i comments-tabellen
    $stmt = $pdo->prepare("
    UPDATE comments
    SET likes = likes - 1
    WHERE id = ?
    ");
    $stmt->execute([$comment_id]);

} else {
    //  LÄGG TILL LIKE 
    // Lägger till en rad i comment_likes (sparar vem som likat vad)
    $stmt = $pdo->prepare("
    INSERT INTO comment_likes (user_id, comment_id)
    VALUES (?, ?)
    ");
    $stmt->execute([$user_id, $comment_id]);

    // Ökar likes med 1 i comments-tabellen
    $stmt = $pdo->prepare("
    UPDATE comments
    SET likes = likes + 1
    WHERE id = ?
    ");
    $stmt->execute([$comment_id]);
}

// Skickar tillbaka användaren till sidan de kom från
header("Location: " . $_SERVER['HTTP_REFERER']);
exit; 
?>
