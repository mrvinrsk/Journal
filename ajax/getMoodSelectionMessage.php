<?php
include_once "../php/sql.php";

$mood = $pdo->query("SELECT auswahlNachricht FROM Mood WHERE id = " . $_GET["mood"] . ";")->fetch();
echo $mood["auswahlNachricht"];