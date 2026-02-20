<?php

// Filen där alla användare som har varit inne sparas
function count_visits()
{
    // Om filen inte finns så skapas en tom
    $file = "data/visits.txt";

    if (!file_exists($file)) {
        file_put_contents($file, "");
    }

    //Hämtar användare från session, den som är inloggad just nu
    // Om det inte finns något namn så skriver den "unknown"
    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];
    } else {
        $username = "unknown";
    }

    // Tar tiden just nu för att kunna se när personen va inne första gången
    $time = date("Y-m-d H:i:s");

    // Läser allt som står i filen
    $content = file_get_contents($file);

    // Kollar om användarnamnet redan finns i filen 
    // Om inte så lägger den till det som en ny rad
    if (strpos($content, $username) === false) {
        $content .= $username . " | " . $time . "\n";
        file_put_contents($file, $content);
    }

    // Räknar hur många rader det finns = hur många unika användare som varit inne
    $lines = file($file);
    return count($lines);
}
?>