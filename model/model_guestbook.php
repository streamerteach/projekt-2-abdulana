<?php
session_start();
require_once "../db.php"; // Anslutning till databasen

// Kontrollera inloggning 
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {

    // Om inte inloggad → sätt error och skicka tillbaka
    $_SESSION['error'] = "You must be logged in to comment.";
    header('Location: ../guestbook.php');
    exit();
}

// Hantera POST (SKAPA KOMMENTAR)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     // Hämtar info från session + formulär
    $username = $_SESSION['username'];
    $users_id = $_SESSION['user_id'];
    $comment_text = trim($_POST['comment_text']);

    // Kollar att kommentaren inte är tom
    if ($comment_text === '') {
        $_SESSION['error'] = "Comment cannot be empty.";
        header("Location: ../guestbook.php");
        exit();
    }

    try {
         // INSERT NY KOMMENTAR
        $sql = "INSERT INTO comments (profile_id, username, comment_text, users_id, likes)
                VALUES (NULL, :username, :comment_text, :users_id, 0)";

        // Binder värden
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':comment_text', $comment_text);
        $stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);

        // Kör queryn
        $stmt->execute();

        // Tillbaka till guestbook efter lyckad kommentar
        header("Location: ../guestbook.php");
        exit();

    } catch (PDOException $e) {
        // Om något går fel i databasen
        die("Database error: " . $e->getMessage());
    }
}

// SORTERING
$sort = $_GET['sort'] ?? 'newest';
// Bestämmer ordning beroende på val
$order_by = match($sort) {
    'oldest' => 'created_at ASC',
    'most_likes' => 'likes DESC',
    'least_likes' => 'likes ASC',
    default => 'created_at DESC'
};

// HÄMTA KOMMENTARER 
try {
    // Hämtar endast guestbook kommentarer (profile_id = NULL)
    $sql = "SELECT * FROM comments WHERE profile_id IS NULL ORDER BY $order_by LIMIT 6";
    // Kör query
    $stmt = $pdo->query($sql);
    // Sparar alla kommentarer
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database fetch error: " . $e->getMessage());
}
?>