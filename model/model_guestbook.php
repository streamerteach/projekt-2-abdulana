<?php
session_start();
require_once "../db.php";

// Kontrollera om användaren är inloggad
if (!isset($_SESSION['username'])) {
    $_SESSION['error'] = "You must be logged in to comment.";  // Felmeddelande om användaren inte är inloggad
    header('Location: ../guestbook.php');  // Omdirigera tillbaka till guestbook-sidan
    exit();
}

// Hantera kommentarinlämning
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kontrollera om användaren är inloggad
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];  // Användarens namn från session
        $comment_text = trim($_POST['comment_text']);

        // Validera att kommentaren inte är tom
        if (empty($comment_text)) {
            $_SESSION['error'] = "Comment cannot be empty.";
            header("Location: ../guestbook.php");
            exit();
        }

        try {
            // Sätt in kommentar i databasen
            $stmt = $pdo->prepare("INSERT INTO comments (username, comment_text, likes) VALUES (:username, :comment_text, 0)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':comment_text', $comment_text);
            $stmt->execute();

            // Om inlämningen lyckas, omdirigera till guestbook-sidan
            header("Location: ../guestbook.php");  // Se till att sidan laddas om
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = "An error occurred while posting your comment.";
            header("Location: ../guestbook.php");
            exit();
        }
    } else {
        // Felmeddelande om användaren inte är inloggad
        $_SESSION['error'] = "You must be logged in to comment.";
        header('Location: ../guestbook.php');
        exit();
    }
}

// Hämta sorteringsval
$sort = $_GET['sort'] ?? 'newest';
switch ($sort) {
    case 'oldest':
        $order_by = "created_at ASC";
        break;
    case 'most_likes':
        $order_by = "likes DESC";
        break;
    case 'least_likes':
        $order_by = "likes ASC";
        break;
    case 'newest':
    default:
        $order_by = "created_at DESC";
        break;
}

try {
    // Hämta kommentarer med max 6, baserat på sortering
    $stmt = $pdo->prepare("SELECT * FROM comments ORDER BY $order_by LIMIT 6");
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    print "Error: " . $e->getMessage();
}
?>