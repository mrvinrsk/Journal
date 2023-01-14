<?php
include_once "../php/sql.php";
include_once "../php/methods.php";

$title = $_GET["title"];
$entry = $_GET["content"];
$mood = $_GET["mood"];
$user = $_GET["user"];

try {
    $pdo->query("INSERT INTO JournalEntry(datum, titel, eintrag, moodId, userId) VALUES('" . now() . "', '$title', '$entry', $mood, $user);");
    echo $pdo->query("SELECT * FROM Mood WHERE id = $mood;")->fetch()["gewichtung"];
} catch (PDOException $e) {
    echo $e->getMessage();
}