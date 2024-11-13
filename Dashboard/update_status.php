<?php
require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
$table = $data['table'] ?? null;

if ($id && $table && in_array($table, ['tk', 'sdit', 'smpit'])) {
    $adminTable = 'siswa_baru_admin_' . $table;
    $umumTable = 'siswa_baru_umum_' . $table;

    $stmt = $pdo->prepare("SELECT status FROM $adminTable WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $currentStatus = $stmt->fetchColumn();

    if ($currentStatus !== false) {
        $newStatus = ($currentStatus === 'diterima') ? 'pending' : 'diterima';

        foreach ([$adminTable, $umumTable] as $tbl) {
            $updateStmt = $pdo->prepare("UPDATE $tbl SET status = :newStatus WHERE id = :id");
            $updateStmt->execute([':newStatus' => $newStatus, ':id' => $id]);
        }

        echo json_encode(['success' => true, 'newStatus' => $newStatus]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Status tidak ditemukan']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'ID atau tabel tidak valid']);
}
?>
