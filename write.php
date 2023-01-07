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
    <div class="header">
        <h1>Schreiben</h1>
        <p>
            Ganz gleich, wie dein Tag war, hier hast du die Möglichkeit, deine Gedanken zu notieren. Schreibe, was dich glücklich macht oder was dich traurig macht. Schreibe, was dir gerade durch den Kopf geht.
        </p>
    </div>

    <div class="form">
        <div class="moods-wrapper">
            <span>Wie fühlst du dich?</span>
            <div class="moods">
                <?php foreach ($moods as $mood) { ?>
                    <div class="mood icon-text" data-id="<?php echo $mood['id']; ?>"><span class="icon"><?php echo $mood["gicon"]; ?></span><span class="stimmung"><?php echo $mood["bezeichnung"]; ?></span></div>
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

    <div class="formatting">
        <h2>Formatierung</h2>

        <table>
            <thead>
            <tr>
                <th>Syntax</th>
                <th>Ergebnis</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>h2((Überschrift))<br><span class="text-muted">Möglich von 2 (größte)–4 (kleinste)</span></td>
                <td><h2 style="margin: 0;">Überschrift</h2></td>
            </tr>

            <tr>
                <td>*Fett*</td>
                <td><strong>Fett</strong></td>
            </tr>

            <tr>
                <td>_Kursiv_</td>
                <td><i>Kursiv</i></td>
            </tr>
            </tbody>
        </table>
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

    const sanitizeInput = (input) => {
        // Escape single quotes and backslashes
        input = input.replace(/['\\]/g, "\\$&");

        // Remove control characters
        input = input.replace(/[\x00-\x1F\x7F]/g, "");

        // Convert HTML tags to character entities
        input = input.replace(/</g, "&lt;").replace(/>/g, "&gt;");

        // Trim leading and trailing whitespace
        input = input.trim();

        return input;
    }


    document.querySelector("#save").addEventListener("click", () => {
        let title = document.querySelector("#title").value;
        let content = document.querySelector("#content").value;
        let mood = document.querySelector(".mood.selected").dataset.id;

        title = sanitizeInput(title);
        content = sanitizeInput(content);

        content = content.replace(/\r?\n/g, '<br>');
        content = content.replace(/\*([^*]+)\*/g, '<strong>$1</strong>');
        content = content.replace(/\_([^*]+)\_/g, '<i>$1</i>');
        content = content.replace(/h2\(\(([^)]+)\)\)/g, '<h2>$1</h2>');
        content = content.replace(/h3\(\(([^)]+)\)\)/g, '<h3>$1</h3>');
        content = content.replace(/h4\(\(([^)]+)\)\)/g, '<h4>$1</h4>');

        $.ajax({
            url: "ajax/write.php",
            type: "GET",
            data: {
                title: title,
                content: content,
                mood: mood
            },
            success: (data) => {
                let msg = document.querySelector("#message");

                $.ajax({
                    url: "ajax/getMoodSelectionMessage.php",
                    data: {
                        mood: mood
                    },
                    success: (data) => {
                        msg.innerHTML = data;
                    }
                });

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