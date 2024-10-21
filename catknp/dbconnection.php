<?php
$host = 'localhost:3306';
$dbname = 'ndotofor_catknp';
$username = 'ndotofor_richie';
$password = 'Ilovemymum78!';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
