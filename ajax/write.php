<?php
include_once "../php/sql.php";
include_once "../php/methods.php";

$title = $_GET["title"];
$entry = $_GET["content"];
$mood = $_GET["mood"];
$user = $_GET["user"];

try {
    $pdo->query("INSERT INTO JournalEntry(datum, titel, eintrag, moodId, userId) VALUES('" . now() . "', '$title', '$entry', $mood, $user);");

    if(isset($_GET["causes"])) {
        $causes = $_GET["causes"];
        $entryId = $pdo->query("SELECT id FROM JournalEntry WHERE userId = $user ORDER BY id DESC LIMIT 1;")->fetch()["id"];

        foreach($causes as $cause) {
            $pdo->query("INSERT INTO EntryCause(causeId, entryId) VALUES($cause, $entryId);");
        }
    }

    echo $pdo->query("SELECT * FROM Mood WHERE id = $mood;")->fetch()["gewichtung"];
} catch (PDOException $e) {
    echo $e->getMessage();
}