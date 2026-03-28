<?php
// config/database.php

$host = 'localhost';
$db   = 'edquiz';
$user = 'root';           // Change if you have set a password
$pass = '';               // Put your MySQL password here if any
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Show clear error during development
    die("❌ Database connection failed: " . $e->getMessage());
}
?>