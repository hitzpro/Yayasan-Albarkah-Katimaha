<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$dsn = "mysql:host=localhost;dbname=yayasan_albarkah;charset=utf8mb4";
$dbUsername = "wakhid123";
$dbPassword = "wakhid123";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: /public/Login/login.html");
    exit();
}

$adminId = $_SESSION['admin_id'];

try {
    // Fetch the current profile data for this admin
    $stmt = $pdo->prepare("SELECT nama_profile, foto_profile FROM login_admin WHERE admin_id = :admin_id");
    $stmt->execute(['admin_id' => $adminId]);
    $adminData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$adminData) {
        echo "Admin data not found";
        exit();
    }

    // Check profile data and update accordingly
    if (empty($adminData['nama_profile']) && empty($adminData['foto_profile'])) {
        // If both fields are empty, only update status to 'tidak aktif'
        $stmt = $pdo->prepare("UPDATE login_admin SET status = 'tidak aktif' WHERE admin_id = :admin_id");
        $stmt->execute(['admin_id' => $adminId]);
    } else {
        // If profile data exists, update status but keep the current profile data
        $stmt = $pdo->prepare("UPDATE login_admin SET status = 'tidak aktif' WHERE admin_id = :admin_id");
        $stmt->execute(['admin_id' => $adminId]);
    }

    // End session and redirect immediately
    session_unset();
    session_destroy();

    header("Location: /public/Login/login.html");
    exit();
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
