<?php
include_once "../php/sql.php";
$pdo->query("DELETE FROM JournalEntry WHERE id = " . $_REQUEST["id"] . ";");
echo "Success";