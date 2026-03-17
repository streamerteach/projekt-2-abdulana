<div class="sort-bar">
<form method="get" action="guestbook.php" class="sortering">
    <label for="sort">Sort by:</label>

    <!-- Dropdown för sortering -->
    <select name="sort">
        <!-- Default = newest -->
        <option value="newest" <?= ($_GET['sort'] ?? 'newest') == 'newest' ? 'selected' : '' ?>>Newest Post</option>
        <option value="oldest" <?= ($_GET['sort'] ?? 'newest') == 'oldest' ? 'selected' : '' ?>>Oldest Post</option>
        <option value="most_likes" <?= ($_GET['sort'] ?? 'newest') == 'most_likes' ? 'selected' : '' ?>>Most Likes</option>
        <option value="least_likes" <?= ($_GET['sort'] ?? 'newest') == 'least_likes' ? 'selected' : '' ?>>Least Likes</option>
    </select>
    <!-- Skickar valet till URL (GET) -->
    <input type="submit" value="Sort">
</form>
</div>
