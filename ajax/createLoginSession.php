<?php
include_once "../php/sql.php";


$cred = $_REQUEST["cred"];
$pass = $_REQUEST["pass"];

// check if password is correct
$account = $pdo->query("SELECT id, passwort FROM Account WHERE mail = '$cred' OR username = '$cred';")->fetch();
$passHash = $account["passwort"];
$userId = $account["id"];

if (password_verify($pass, $passHash)) {
    // check if session already exists
    if ($pdo->query("SELECT userId FROM LoginSession WHERE userId = $userId;")->rowCount() == 1) {
        // remove old session
        $pdo->query("DELETE FROM LoginSession WHERE userId = $userId;");
    }

    // create session
    include_once "../php/methods.php";

    $sessionId = genStr(64, "A-Z0-9");

    set_cookie("sessionId", $sessionId, 86400);

    $pdo->query("INSERT INTO LoginSession (sessionId, userId) VALUES ('$sessionId', $userId);");
    $pdo->query("UPDATE Account SET lastLogin = '" . now() . "' WHERE id = $userId;");

    echo $_COOKIE["sessionId"];
} else {
    echo "-1";
}