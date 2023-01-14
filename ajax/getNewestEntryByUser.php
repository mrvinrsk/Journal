<?php
include_once "../php/sql.php";
$user = $_GET["user"];
$entry = $pdo->query("SELECT id FROM JournalEntry WHERE userId = $user ORDER BY datum DESC LIMIT 1;")->fetch();
echo $entry["id"];