<?php
// config.php
$host = 'localhost';
$dbname = 'yayasan_albarkah';
$username = 'wakhid123';  // Sesuaikan dengan username DB Anda
$password = 'wakhid123';      // Sesuaikan dengan password DB Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
