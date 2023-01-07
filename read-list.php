<?php
include_once "php/methods.php";
include_once "php/sql.php";
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Deine Einträge | Journal</title>

    <link rel="stylesheet" href="style/css/global.css">
    <link rel="stylesheet" href="style/css/read-list.css">

    <script src="js/jquery.min.js"></script>
</head>
<body>

<main>
    <h1>Deine Einträge</h1>

    <div class="entries">
        <?php
        $entries = $pdo->query("SELECT * FROM JournalEntry ORDER BY datum DESC;")->fetchAll();
        foreach ($entries as $entry) {
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
                        <div class="mood icon-text"><span class="icon"><?php echo $mood["gicon"]; ?></span><span><?php echo $mood["bezeichnung"]; ?></span></div>
                    </div>

                    <p><?php echo truncate_words($entry["eintrag"], 30); ?></p>
                </div>

                <?php if (strcmp(truncate_words($entry["eintrag"], 30), $entry["eintrag"])) { ?>
                    <button class="small read-more" id="<?php echo $entry['id']; ?>">Weiterlesen</button>
                <?php } ?>
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