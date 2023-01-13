<?php
include_once "php/sql.php";
include_once "php/methods.php";

$userId = getLoggedInUser($pdo);

if ($userId == -1) {
    header("Location: ./auth/?next=account");
    exit();
}
$account = $pdo->query("SELECT * FROM Account WHERE id = $userId;")->fetch();
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dein Account | Journal</title>

    <link rel="stylesheet" href="style/css/global.css">
    <link rel="stylesheet" href="style/css/account.css">

    <script src="js/jquery.min.js"></script>
    <script src="js/main.js"></script>
</head>
<body>

<main>
    <h1>Willkommen, <strong><?php echo $account["username"]; ?></strong></h1>
    <p class="text-muted">Du hast dich zuletzt am <?php echo date('d.m.Y', strtotime($account["lastLogin"])); ?> um <?php echo date('H:i', strtotime($account["lastLogin"])); ?> Uhr eingeloggt.</p>
</main>

</body>
</html>
