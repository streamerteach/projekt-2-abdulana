<?php
session_start();

// Om användaren INTE är inloggad → skicka till login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rapport</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="js/script.js" defer></script>
    <script src="js/cookie.js" defer></script>
</head>
<body>

<div id="container">
    <?php include "header.php"?>

    <h2>10. Reflektion och feedback</h2>
    <section class="report-section">
        <h3>Databasstruktur</h3>

        <div class="db-container">
            <div class="db-image">
                <img src="media/diagram.png" alt="Databasdiagram" class="report-img">
                <p class="img-source"> Diagram skapat med <a href="https://dbdiagram.io/home" target="_blank">dbdiagram.io</a></p>
            </div>

            <div class="db-text">
                <p>
                Vår databas har tre tabeller: <strong>users</strong>, <strong>comments</strong> och <strong>comment_likes</strong>.
                </p>

                <p>
                Comments-tabellens <code>users_id</code> är en foreign key till users-tabellens <code>id</code><br>
                - den visar vilken användare som skrev kommentaren.
                </p>

                <p>
                Comments-tabellens <code>profile_id</code> är också en foreign key till users-tabellens <code>id</code><br>
                - den visar på vems profil kommentaren ligger.
                </p>

                <p>
                Comment_likes-tabellens <code>user_id</code> är en foreign key till users-tabellens <code>id</code><br>
                - den visar vilken användare som gillade en kommentar.
                </p>

                <p>
                Comment_likes-tabellens <code>comment_id</code> är en foreign key till comments-tabellens <code>id</code><br>
                - den visar vilken kommentar som har fått en like.
                </p>
            </div>
        </div>
    </section>

     <section class="report-section">
        <h3>Aurora</h3>
        <p>
        Jag har arbetat med de blåa delarna av projektet. Det som har varit bra är att jag har lärt mig hur man jobbar med databaser och hur man kopplar ihop dem även om det var lite svårt i början att förstå. 
        Jag har också förstått bättre hur man kan hantera profiler, filtrering och andra funktioner.
        </p>

        <p>Vi har hjälpt varandra mycket under arbetet, vilket gjorde att vi kunde lösa problem snabbare och förstå uppgifterna bättre tillsammans.</p>

        <p>
        Det som var lite svårare var vissa delar av programmeringen, servern, speciellt när något inte fungerade direkt och man behövde testa flera gånger och felsöka. 
        Men genom samarbete och tålamod lyckades vi lösa det.
        </p>

        <p>Sammanfattningsvis har projektet gått bra och jag har lärt mig mycket nytt.</p>


    </section>

    
    <section class="report-section">
        <h3>Anab</h3>
        <p>
        I projekt 2 vidareutvecklade vi dejtingsajten från projekt 1 genom att gå från filbaserad lagring till PHP och databas, vilket gjorde sidan mer dynamisk.
        Jag arbetade med databasen, registrering, sortering av annonser samt gilla/ogilla-funktioner och content management.
        </p>

        <h3>Vad var roligt</h3>
        <p>
        Det roligaste var att se hur allt började hänga ihop när databasen fungerade tillsammans med PHP.
        Jag gillade särskilt like-funktionen där man direkt kunde se hur användarens interaktion sparades i databasen.
        </p>

        <h3>Vad som var svårt</h3>
        <p>
        En sak som visade sig vara svårare än jag först trodde var hur man organiserar
        filerna i projektet. I början låg många filer direkt i root-mappen vilket
        snabbt blev rörigt. Därför började vi använda en enklare MVC-struktur, vilket gjorde projektet mycket
        lättare att hålla organiserat.
        </p>

        <h3>Extra poäng?</h3>
        <p>
        Vi anser att projektet uppfyller kriterierna för bonuspoäng, bland annat genom profilbildsuppladdning, en cookie baserad funktion som förbättrar användarupplevelsen och ett like system där relationer sparas i databasen.
        Vi har också implementerat dark mode som användaren kan toggla. 
        Dessutom har vi lagt fokus på säkerhet genom att använda prepared statements och lösenordshashning.
        </p>


        <h3>Grupparbete</h3>
        <p>
        Vi delade upp uppgifterna men samarbetade mycket när någon körde fast.
        Det gjorde att vi både löste problem snabbare och fick bättre förståelse för hur hela systemet hänger ihop.
        Logotypen för projektet skapades med hjälp av <a href="https://www.canva.com/" target="_blank">Canva</a>.
        </p>
    </section>

    <?php include "footer.php"?>
</div>
