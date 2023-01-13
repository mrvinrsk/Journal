<?php
include_once "php/sql.php";
include_once "php/methods.php";

$userId = getLoggedInUser($pdo);

setcookie("sessionId", "", -1);
$pdo->query("DELETE FROM LoginSession WHERE userId = $userId;");