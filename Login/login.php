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

// Login function
function login($pdo, $inputUsername, $inputPassword) {
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username");
    $stmt->execute(['username' => $inputUsername]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        // Verify password using SHA-256 hashing
        if (hash('sha256', $inputPassword) === $admin['password']) {
            // Check if admin is already logged in
            $stmt = $pdo->prepare("SELECT * FROM login_admin WHERE admin_id = :admin_id");
            $stmt->execute(['admin_id' => $admin['admin_id']]);
            $loginAdmin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($loginAdmin) {
                // Update status to 'aktif' if admin_id exists in login_admin
                $stmt = $pdo->prepare("UPDATE login_admin SET status = 'aktif' WHERE admin_id = :admin_id");
                $stmt->execute(['admin_id' => $admin['admin_id']]);
            } else {
                // Add a new login record if admin_id does not exist
                $stmt = $pdo->prepare("INSERT INTO login_admin (admin_id, status) VALUES (:admin_id, 'aktif')");
                $stmt->execute(['admin_id' => $admin['admin_id']]);
            }

            // Set session variables
            $_SESSION['admin_id'] = $admin['admin_id'];

            // Redirect to dashboard
            header("Location: ../Dashboard/dashboard.php");
            exit();
        } else {
            // Incorrect password
            displayError("Username or password is incorrect");
        }
    } else {
        // Username not found
        displayError("Username or password is incorrect");
    }
}

// Function to display error using SweetAlert
function displayError($message) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '$message',
                confirmButtonText: 'OK'
            });
          </script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    login($pdo, $inputUsername, $inputPassword);
}
