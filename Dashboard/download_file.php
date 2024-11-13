<?php
$filePath = "C:/xampp/htdocs/public/Daftar Siswa/Daftar SMPIT/Uploads/akte_kelahiran_1731468282_11122468_84.pdf"; // Ganti dengan file uji coba di lokasi server

if (file_exists($filePath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePath));

    flush(); // Bersihkan output buffering
    readfile($filePath);
    exit;
} else {
    echo "File tidak ditemukan.";
}
