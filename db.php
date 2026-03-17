<?php
// Funktion som tar bort whitespace och specialtecken
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Definiera databasinställningar
$servername = "localhost";  
$dbname = "abdulana";   
// Hämtar användarnamn + lösenord från separat fil (säkerhet)
include "hemlis.php";  

try {
    // Skapa en PDO-anslutning till databasen
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword); // Använd $dbname direkt här
    
    // Sätter så att PDO visar errors som exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Om något går fel -> visa felmeddelande
    print "Connection failed: " . $e->getMessage();
}
?>