<?php
include_once "php/methods.php";
include_once "php/sql.php";

$userId = getLoggedInUser($pdo);
if ($userId == -1) {
    include_once "errors/custom/not-logged-in.php";
    exit();
}
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Deine Einträge | Journal</title>

    <link rel="stylesheet" href="style/css/global.css">
    <link rel="stylesheet" href="style/css/read-list.css">

    <script src="js/jquery.min.js"></script>
    <script src="js/main.js"></script>
</head>
<body>

<main>
    <div class="simpleflex">
        <h1>Deine Einträge</h1>
        <a href="./write" class="button success icon-text"><span class="icon">edit_note</span><span>Schreiben</span></a>
    </div>

    <div class="entries">
        <?php
        $entriesStmt = $pdo->query("SELECT * FROM JournalEntry WHERE userId = $userId ORDER BY datum DESC LIMIT 3;");
        $entries = $entriesStmt->fetchAll();

        if ($entriesStmt->rowCount() >= 1) {
            foreach ($entries as $entry) {
                $entryId = $entry["id"];
                $date = new DateTime($entry['datum']);
                ?>

                <div class="entry">
                    <div class="text">
                        <div class="title">
                            <h2><?php echo $entry["titel"]; ?></h2>
                            <span class="timestamp"><?php echo $date->format("d.m.Y") . ", " . $date->format("H:i") . " Uhr"; ?></span>
                        </div>
                        <div class="info">
                            <?php
                            $mood = $pdo->query("SELECT * FROM Mood WHERE id = " . $entry["moodId"] . ";")->fetch();
                            ?>
                            <div class="mood icon-text"><span
                                        class="icon"><?php echo $mood["gicon"]; ?></span><span><?php echo $mood["bezeichnung"]; ?></span>
                            </div>

                            <?php

                            $causesStmt = $pdo->query("SELECT Cause.gicon, Cause.bezeichnung FROM Cause, EntryCause WHERE entryId = $entryId AND Cause.id = EntryCause.causeId;");
                            if ($causesStmt->rowCount() >= 1) {
                                $causes = $causesStmt->fetchAll();

                                foreach ($causes as $cause) {
                                    ?>
                                    <div class="icon-text mood"><span class="icon"><?php echo $cause["gicon"]; ?></span><span><?php echo $cause["bezeichnung"]; ?></span></div>
                                    <?php
                                }
                            }
                            ?>
                        </div>

                        <p><?php echo truncate_words($entry["eintrag"], 30); ?></p>
                    </div>

                    <button class="small read-more" id="<?php echo $entry['id']; ?>">Ansehen</button>
                </div>

            <?php }
        } else {
            ?>
            <div class="entry missing">
                <p>Du hast noch keine Einträge geschrieben</p>
            </div>
        <?php } ?>
    </div>
</main>

<script>
    document.querySelectorAll(".read-more").forEach(function (button) {
        button.addEventListener("click", function () {
            window.location.href += "/" + button.id;
        });
    });
</script>

</body>
</html>