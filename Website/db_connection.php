<?php
$host = 'localhost';
$dbname = 'breyer_college';
$user = 'pma';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
