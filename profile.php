<?php
session_start();
require_once "db.php";

// Get user id from URL
$id = $_GET["id"] ?? "";

// Fetch user from database
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);

$user = $stmt->fetch();
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

<?php include "header.php" ?>


<div class="profile-content">

    <!-- LEFT SIDE -->

<div class="profile-top">
    <section class="profile-info">
        <h2 class="profile-username"><?= htmlspecialchars($user["username"]) ?></h2>
        <p><strong>Realname:</strong> <?= htmlspecialchars($user["realname"]) ?></p>
        <p><strong>Zipcode:</strong> <?= htmlspecialchars($user["zipcode"]) ?></p>
        <p><strong>Bio:</strong> <?= htmlspecialchars($user["bio"]) ?></p>

        <?php if (isset($_SESSION["user_id"])) { ?>
            <p><strong>Email:</strong> <?= htmlspecialchars($user["email"]) ?></p>
            <p><strong>Salary:</strong> <?= htmlspecialchars($user["salary"]) ?></p>
        <?php } ?>

    </section>

    <section class="comment-form-box">

        <h3>Write a comment</h3>

        <?php if (isset($_SESSION["user_id"])) { ?>

        <form method="post" action="add_comment.php">

            <textarea name="comment" placeholder="Write your comment..."></textarea>
            <input type="hidden" name="profile_id" value="<?= $user["id"] ?>">
            <button type="submit">Post Comment</button>

        </form>

        <?php } else { ?>

        <p>You must log in to comment.</p>

        <?php } ?>

    </section>

</div>

<div class="comments-box">

    <h3>Comments (0)</h3>

    <p>No comments yet.</p>

</div>
<?php include "footer.php" ?>
</div>
