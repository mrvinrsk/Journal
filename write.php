<?php
include_once "php/sql.php";
$moods = $pdo->query("SELECT * FROM Mood;");
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Schreiben | Journal</title>

    <link rel="stylesheet" href="style/css/global.css">
    <link rel="stylesheet" href="style/css/write.css">

    <script src="js/jquery.min.js"></script>
    <script src="js/popups.js"></script>
</head>
<body>

<main>
    <h1>Schreiben</h1>

    <div class="form">
        <div class="moods-wrapper">
            <span>Wie fühlst du dich?</span>
            <div class="moods">
                <?php foreach ($moods as $mood) { ?>
                    <div class="mood icon-text" data-id="<?php echo $mood['id']; ?>"><?php echo $mood["bezeichnung"]; ?></div>
                <?php } ?>
            </div>
        </div>

        <div class="input">
            <label for="title">Titel</label>
            <input type="text" name="title" id="title" placeholder="Titel">
        </div>

        <div class="input">
            <label for="content">Inhalt</label>
            <textarea name="content" id="content" cols="30" rows="10" placeholder="Inhalt"></textarea>
        </div>

        <button class="submit full" id="save">Eintrag speichern</button>
    </div>
</main>

<div class="popups">
    <div class="popup" id="success">
        <h2>Gespeichert</h2>
        <p>Du hast deinen Eintrag gespeichert.</p>
        <span id="message"></span>
    </div>
</div>

<script>
    document.querySelectorAll(".mood").forEach(mood => {
        mood.addEventListener("click", () => {
            document.querySelectorAll(".mood").forEach(mood => {
                mood.classList.remove("selected");
            });

            mood.classList.add("selected");
        });
    });

    document.querySelector("#save").addEventListener("click", () => {
        let title = document.querySelector("#title").value;
        let content = document.querySelector("#content").value;

        $.ajax({
            url: "ajax/write.php",
            type: "GET",
            data: {
                title: title,
                content: content,
                mood: document.querySelector(".mood.selected").dataset.id
            },
            success: (data) => {
                let msg = document.querySelector("#message");
                let m = document.querySelector(".mood.selected").textContent;

                switch (data) {
                    case "Klasse":
                    case "Positiv":
                        msg.innerHTML = "Es freut uns zu hören, dass du dich <strong>" + m.toLowerCase() + "</strong> fühlst.";
                        break;

                    case "Eher positiv":
                    case "Neutral":
                    case "Eher negativ":
                        msg.innerHTML = "Naja, es geht schlimmer als <strong>" + m.toLowerCase() + "</strong>, morgen ist auch noch ein Tag. Lass dich nicht unterkriegen.";
                        break;

                    case "Negativ":
                    case "Miserabel":
                        msg.innerHTML = "Wir hoffen, dass du dich bald besser fühlst. Sich <strong>" + m.toLowerCase() + "</strong> zu fühlen, ist nicht schön.";
                        break;
                }

                document.querySelectorAll("input, textarea").forEach(input => {
                    input.value = "";
                });

                document.querySelectorAll(".mood").forEach(mood => {
                    mood.classList.remove("selected");
                });


                togglePopup("success");
            }
        });
    });
</script>

</body>
</html>