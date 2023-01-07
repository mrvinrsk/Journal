<?php
include_once "php/methods.php";
include_once "php/sql.php";

$entry = $pdo->query("SELECT * FROM JournalEntry WHERE id = " . $params['id'] . ";")->fetch();
$date = new DateTime($entry['datum']);
$mood = $pdo->query("SELECT * FROM Mood WHERE id = " . $entry["moodId"] . ";")->fetch();
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Deine Einträge | Journal</title>

    <base href="/Journal/">
    <link rel="stylesheet" href="style/css/global.css">
    <link rel="stylesheet" href="style/css/read-entry.css">

    <script src="js/jquery.min.js"></script>
    <script src="js/popups.js"></script>
</head>
<body>

<div class="popups">
    <div class="popup" id="delete">
        <h3>Wirklich löschen?</h3>
        <p>
            <strong>Bist du dir sicher, dass du diesen Eintrag aus deinem Gedächtnis streichen möchtest?</strong><br><br>
            Dieser Vorgang kann nicht rückgängig gemacht werden. Ist dein Eintrag einmal gelöscht, können auch die Seitenbetreiber dir nicht bei der Wiederherstellung helfen – er ist dann für immer verloren.
        </p>

        <div class="buttons">
            <button class="small danger" data-toggle-popup="delete" onclick="deleteEntry();">Ja, löschen</button>
            <button class="small muted" data-toggle-popup="delete">Nein, behalten</button>
        </div>
    </div>
</div>

<main>
    <div class="complete-entry">
        <div class="title">
            <h1><?php echo $entry["titel"]; ?></h1>
            <span class="timestamp"><?php echo $date->format("d.m.Y") . ", " . $date->format("H:i") . " Uhr"; ?></span>
            <div class="mood icon-text"><span class="icon"><?php echo $mood["gicon"]; ?></span><span><?php echo $mood["bezeichnung"]; ?></span></div>
        </div>

        <article class="entry"><?php echo $entry["eintrag"]; ?></article>
    </div>

    <div class="buttons">
        <button class="icon-text" id="edit"><span class="icon">edit</span><span>Bearbeiten</span></button>
        <button class="icon-text" id="delete" data-toggle-popup="delete"><span class="icon">delete</span><span>Löschen</span></button>
    </div>
</main>

<script>
    function deleteEntry() {
        $.ajax({
            url: "ajax/deleteEntry.php",
            type: "POST",
            data: {
                id: <?php echo $params['id']; ?>
            },
            success: function (data) {
                console.log(data);
                // window.location.href = "../";
            }
        });
    }
</script>

</body>
</html>