<?php
require_once "../db.php";

// Hämta alla profiler
try {

    $stmt = $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
    $stmt->execute();

    $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    print "Error: " . $e->getMessage();
}
?>