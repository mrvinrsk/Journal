<?php
include_once "../php/sql.php";
include_once "../php/methods.php";

$title = $_GET["title"];
$entry = $_GET["content"];
$mood = $_GET["mood"];

try {
    $pdo->query("INSERT INTO JournalEntry(datum, titel, eintrag, moodId) VALUES('" . now() . "', '$title', '$entry', $mood);");
    echo $pdo->query("SELECT * FROM Mood WHERE id = $mood;")->fetch()["gewichtung"];
} catch (PDOException $e) {
    echo $e->getMessage();
}