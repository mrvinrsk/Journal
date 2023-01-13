<?php
include_once "../php/sql.php";

$mail = $_GET['mail'];

if ($pdo->query("SELECT * FROM Account WHERE mail = '$mail'")->rowCount() > 0) {
    echo "true";
} else {
    echo "false";
}