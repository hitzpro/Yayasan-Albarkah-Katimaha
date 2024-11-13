<?php
require 'config.php';

// Set header untuk JSON
header('Content-Type: application/json');

// Decode data JSON dari request
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
$table = $data['table'] ?? null;

// Validasi input dan periksa apakah tabel yang diterima valid
if ($id && $table && in_array($table, ['tk', 'sdit', 'smpit'])) {
    // Tentukan nama tabel untuk admin dan umum berdasarkan nilai `table`
    $adminTable = 'siswa_baru_admin_' . $table;
    $umumTable = 'siswa_baru_umum_' . $table;

    $success = true; // Flag untuk menentukan apakah semua query berhasil
    $errors = []; // Array untuk menyimpan pesan error jika ada

    // Hapus data dari tabel admin dan umum
    foreach ([$adminTable, $umumTable] as $tbl) {
        $stmt = $pdo->prepare("DELETE FROM $tbl WHERE id = :id");
        if (!$stmt->execute([':id' => $id])) {
            $success = false;
            $errors[] = "Gagal menghapus data dari tabel $tbl";
        }
    }

    // Kirim respons sesuai dengan hasil query
    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $errors]);
    }
} else {
    // Kirim respons gagal jika data tidak valid
    echo json_encode(['success' => false, 'error' => 'ID atau tabel tidak valid']);
}
?>
