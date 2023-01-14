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
    <title>Nicht eingeloggt | Journal</title>

    <base href="/Journal/">
    <link rel="stylesheet" href="style/css/global.css">
    <link rel="stylesheet" href="style/css/error.css">
</head>
<body>

<main>
    <h1>Login erforderlich</h1>
    <p>Du musst dich einloggen, um auf diesen Inhalt zu erhalten.</p>

    <a class="button" href="auth/?next=<?php echo str_replace('/Journal/', '', $_SERVER['REQUEST_URI']); ?>">Zurück zum Profil</a>
</main>

</body>
</html>