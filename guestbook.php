<?php

session_start();

require_once "db.php";

// Hämta sorteringsval från URL (GET)
$sort = $_GET['sort'] ?? 'newest';

// Bestämmer hur vi ska sortera beroende på val
$order_by = match($sort) {
    'oldest' => 'created_at ASC',
    'most_likes' => 'likes DESC',
    'least_likes' => 'likes ASC',
    default => 'created_at DESC'
};

// Hämtar endast guestbook kommentarer 
try {
    $stmt = $pdo->prepare("SELECT * FROM comments WHERE profile_id IS NULL ORDER BY $order_by LIMIT 6");
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    print "Error: " . $e->getMessage();
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
  <!-- Header -->
<?php include "header.php"; ?>

<!-- Filter (sortering UI ligger i separat fil) -->
<?php include "view/view_guestbook.php"; ?>

    <!-- FORM FÖR ATT SKRIVA KOMMENTAR -->
    <section class="guestbook-comment-form">
        <h2>Leave a Comment</h2>

         <?php
         // Visar error message (t.ex. tom kommentar)
        if (isset($_SESSION['error'])) {
            print '<div class="error">' . htmlspecialchars($_SESSION['error']) . '</div>';
            unset($_SESSION['error']);
        }
        ?>

       <form method="post" action="model/model_guestbook.php">
            <input type="hidden" name="profile_id" value="NULL">
            <textarea name="comment_text" placeholder="Write a comment..." required></textarea>
            <button type="submit">Post Comment</button>

        </form>
    </section>

    <!-- VISAR KOMMENTARER -->
   <section class="guestbook-posts">

    <?php if (!empty($posts)): ?>

        <!-- Loopar igenom alla kommentarer -->
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <!-- Username -->
                <p><strong><?= htmlspecialchars($post['username']) ?></strong> wrote:</p>
                 <!-- Själva kommentaren -->
                <p><?= htmlspecialchars($post['comment_text']) ?></p>
                <!-- Likes + datum -->
                <p>Likes: <?= htmlspecialchars($post['likes']) ?> | Posted on: <?= htmlspecialchars($post['created_at']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Om inga kommentarer finns -->
        <p>No comments yet.</p>
    <?php endif; ?>
</section>



</div>
    <?php include "footer.php"; ?>

