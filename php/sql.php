<?php
$servername = "localhost";
$username = "journal";
$password = "xiNU7wBksPIZ";
$db = "Journal";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
}

?>
