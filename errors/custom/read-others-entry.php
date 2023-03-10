<?php
include_once "../../php/methods.php";
include_once "../../php/sql.php";

$user = getLoggedInUser($pdo);
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nicht erlaubt | Journal</title>

    <base href="/Journal/">
    <link rel="stylesheet" href="style/css/global.css">
    <link rel="stylesheet" href="style/css/error.css">
</head>
<body>

<main>
    <h1>Zugriff verweigert</h1>
    <p>Du hast auf diesen Inhalt keinen Zugriff</p>

    <a class="button" href="./account">Zurück zum Profil</a>
</main>

</body>
</html>