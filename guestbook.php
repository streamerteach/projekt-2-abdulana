<?php
session_start();
require_once "db.php";

// Hämta sorteringsval
$sort = $_GET['sort'] ?? 'newest';
switch ($sort) {
    case 'oldest': $order_by = "created_at ASC"; break;
    case 'most_likes': $order_by = "likes DESC"; break;
    case 'least_likes': $order_by = "likes ASC"; break;
    case 'newest':
    default: $order_by = "created_at DESC"; break;
}

// Hämta kommentarer
try {
    $stmt = $pdo->prepare("SELECT * FROM comments ORDER BY $order_by LIMIT 6");
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestbook</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="js/script.js" defer></script>
    <script src="js/cookie.js" defer></script>
</head>
<body>


<div id="container">
    <?php include "header.php"; ?>

    <!-- Visa filterformulär -->
    <?php include "view/view_guestbook.php"; ?>

        <!-- Kommentarinlämning -->
    <section class="guestbook-comment-form">
        <h2>Leave a Comment</h2>

         <?php
        if (isset($_SESSION['error'])) {
            print '<div class="error">' . htmlspecialchars($_SESSION['error']) . '</div>';
            unset($_SESSION['error']);
        }
        ?>

        <form method="post" action="model/model_guestbook.php">
            <textarea name="comment_text" placeholder="Write a comment here..."></textarea><br>
            <input type="submit" value="Post Comment">
        </form>
    </section>

    <!-- Kommentarer -->
   <section class="guestbook-posts">

    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <p><strong><?= htmlspecialchars($post['username']) ?></strong> wrote:</p>
                <p><?= htmlspecialchars($post['comment_text']) ?></p>
                <p>Likes: <?= htmlspecialchars($post['likes']) ?> | Posted on: <?= htmlspecialchars($post['created_at']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No comments yet.</p>
    <?php endif; ?>
</section>



</div>
    <?php include "footer.php"; ?>

