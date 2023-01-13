<?php
include_once "../php/sql.php";
include_once "../php/methods.php";

$username = $_REQUEST['username'];
$mail = $_REQUEST['mail'];
$password = password_hash($_REQUEST['password'], PASSWORD_BCRYPT);

try {
    $pdo->query("INSERT INTO Account (username, registrationDate, mail, passwort) VALUES ('$username', '" . now() . "', '$mail', '$password');");
    echo "true";
} catch (PDOException $e) {
    echo $e->getMessage();
}