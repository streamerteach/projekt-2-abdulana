<?php
    session_start();

    // Skickar användaren till login om den inte är inloggad
    if (! isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
    }

    include "includes/header.php";
?>

<h2>Projekt 1</h2>

<h3>Reflektiv rapport – Anab</h3>

<p><strong>Vad har varit bra:</strong><br>
Jag har lagt mycket tid på min del av projektet och det har varit givande att se hur allt började fungera tillsammans och hur sidan blev mer levande när funktionerna kopplades ihop. Det kändes bra att få en tydligare förståelse för hur PHP fungerar i praktiken och hur man bygger upp en sida steg för steg.</p>

<p><strong>Vad har varit roligt:</strong><br>
Det roligaste har varit att se min kod faktiskt fungera på servern. Att få besöksräknaren och sessionerna att uppdateras korrekt gav en känsla av att jag verkligen hade kontroll över projektet. Det var också kul att se hur små ändringar kunde förbättra helheten och göra sidan mer användbar.</p>

<p><strong>Vad har varit svårt:</strong><br>
Det svåraste har helt klart varit rättigheterna och GitHub‑flödet. Jag förstod inte i början varför vissa pushar inte gick igenom eller varför filer låste sig. Det tog lång tid innan jag började förstå hur rättigheterna fungerade och varför GitHub ibland blockerade mina ändringar. Jag fick testa många olika lösningar innan det äntligen klickade.</p>

<p><strong>Vad tog lång tid att förstå:</strong><br>
Rättigheter, filstruktur och hur GitHub hanterar brancher tog mest tid. Jag behövde prova flera gånger, göra om och ibland börja om från början innan jag hittade rätt. Det var frustrerande, men samtidigt lärde jag mig mycket.</p>

<p><strong>Vad spenderade jag för mycket tid på:</strong><br>
Jag la mycket tid på att försöka förstå varför vissa filer inte gick att pusha eller mergea. Jag fastnade också ibland på små detaljer som egentligen inte var viktiga för funktionaliteten, men som tog mycket fokus när jag redan var stressad.</p>

<p><strong>Vad kan jag jobba på till Projekt 2:</strong><br>
Jag vill bli bättre på att planera min tid och dela upp arbetet i mindre steg så jag inte fastnar lika länge på samma problem. Jag vill också bli tryggare med GitHub så att jag kan jobba mer effektivt. En tydligare struktur och bättre dokumentation under arbetets gång skulle hjälpa mig mycket i nästa projekt.</p>

<p><strong>Teamwork:</strong><br>
Samarbetet i gruppen fungerade väldigt bra. Vi hade en tydlig plan och jobbade i två separata brancher som vi sedan pushade in i vår main. Vi kommunicerade bra under hela projektet och hjälpte varandra när vi fastnade eller krockade med något. Det gjorde arbetet smidigare och mer motiverande, och det kändes som att vi hade bra kontroll över projektet från början till slut.</p>
<hr>

<h3>Reflektiv rapport – Aurora</h3>

<p> Under projektet har jag lärt mig hur man använder HTML, PHP och JavaScript tillsammans för att skapa en fungerande webbsida. I början var det svårt att förstå vissa delar, speciellt datumhantering, validering och hur filer sparas på servern, men efter mycket testande blev det lite lättare. Jag arbetade med funktioner som nedräkning av tid och datum, registrering med e-post och lösenord, uppladdning av profilbilder och en gästbok där kommentarer sparas i en fil. Det som var roligast var att se hur sidan blev mer avancerad steg för steg. Det som tog mest tid var små fel i koden och att förstå logiken i PHP. Projekten skulle kanske ha varit lite lättare om vi skulle ha få flera enkla exempel och mera genomgångar före större uppgifter och kanske lite mera förklaringar vad och hur vi kodar och hur allting fungerar, projektet var lite svårt men det blev lite bättre under tiden.<p>

<?php
include "includes/footer.php";
?>