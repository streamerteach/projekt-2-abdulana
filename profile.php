<?php

    session_start();
    require_once "db.php";

    // Hämtar user id från URL (t.ex profile.php?id=5)
    $id = $_GET["id"] ?? "";

    // Hämtar användaren från databasen baserat på id
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if (! $user) {
    die("Profile not found.");
    }

    // Hämtar alla kommentarer som denna användare har skrivit
    try {
    $stmt = $pdo->prepare("
        SELECT c.*, u2.username AS profile_owner
        FROM comments c
        LEFT JOIN users u2 ON u2.id = c.profile_id
        WHERE c.users_id = ?
        ORDER BY c.created_at DESC
    ");
    $stmt->execute([$user['id']]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
    $comments = [];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile</title>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/index.css">

<script src="js/script.js" defer></script>
<script src="js/cookie.js" defer></script>
</head>

<body>

<div id="container">

<?php include "header.php"?>


<div class="profile-content">

    <!-- LEFT SIDE -->

<div class="profile-top">
    <section class="profile-info">
         <!-- Visar användarens info -->
        <h2 class="profile-username"><?php print htmlspecialchars($user["username"])?></h2>
        <p><strong>Realname:</strong><?php print htmlspecialchars($user["realname"])?></p>
        <p><strong>Zipcode:</strong><?php print htmlspecialchars($user["zipcode"])?></p>
        <p><strong>Bio:</strong><?php print htmlspecialchars($user["bio"])?></p>

        <!-- Endast inloggade ser email + salary -->
        <?php if (isset($_SESSION["user_id"])) {?>
            <p><strong>Email:</strong> <?php print htmlspecialchars($user["email"])?></p>
            <p><strong>Salary:</strong> <?php print htmlspecialchars($user["salary"])?></p>
        <?php }?>

    </section>

    <div class="comments-box">
        <!-- Visar hur många kommentarer användaren skrivit -->
        <h3>Comments made by <?php print htmlspecialchars($user["username"])?> (<?php print count($comments)?>)</h3>

         <!-- Om det finns kommentarer -->
        <?php if (! empty($comments)): ?>
        <!-- Loopar igenom alla kommentarer -->
        <?php foreach ($comments as $comment): ?>

        <?php
            $liked = false; // default = inte likad
            // Om man är inloggad → kolla om man redan har likat kommentaren
            if (isset($_SESSION['user_id'])) {
                $stmt = $pdo->prepare("
                SELECT id FROM comment_likes
                WHERE user_id = ? AND comment_id = ?
            ");
                $stmt->execute([$_SESSION['user_id'], $comment['id']]);
                $liked = $stmt->fetch(); // true om den finns
            }
        ?>

        <div class="post">
        <!-- Visar vem som skrev kommentaren -->
        <p><strong><?php print htmlspecialchars($comment['username'])?> wrote:</strong></p>
        <!-- Själva kommentaren -->
        <p><?php print htmlspecialchars($comment['comment_text'])?></p>

        <!-- Visar likes + datum -->
        <p>
        Likes: <?php print htmlspecialchars($comment['likes'])?> |
        Posted on: <?php print htmlspecialchars($comment['created_at'])?>
        </p>

        <!-- Endast inloggade kan like/unlike -->
        <?php if (isset($_SESSION['user_id'])): ?>

        <!-- Form som skickar comment_id till like_comment.php -->
        <form method="post" action="like_comment.php">
        <input type="hidden" name="comment_id" value="<?php print $comment['id']?>">

         <!-- Byter text beroende på om man redan likat -->
        <button type="submit">
        <?php print($liked ? "👎 Undo Like" : "👍 Like"); ?>
        </button>

        </form>

        <?php endif; ?>

        </div>

        <?php endforeach; ?>
        <?php else: ?>
        <!-- Om inga kommentarer finns -->
        <p>No comments yet.</p>

        <?php endif; ?>

    </div>

</div>
<?php include "footer.php"?>
</div>
