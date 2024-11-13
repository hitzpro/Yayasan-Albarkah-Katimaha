<?php
require 'config.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Check the database connection
if (!$pdo) {
    die("Database connection failed.");
}

// Calculate total number of records and pages
$totalStmt = $pdo->query("SELECT COUNT(*) FROM siswa_baru_admin_sdit");
if (!$totalStmt) {
    die("Failed to count records in siswa_baru_admin_sdit table.");
}
$totalStudents = $totalStmt->fetchColumn();
$totalPages = ceil($totalStudents / $perPage);

// Fetch students for the current page
$stmt = $pdo->prepare("SELECT * FROM siswa_baru_admin_sdit LIMIT :offset, :perPage");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
if (!$stmt->execute()) {
    die("Failed to fetch records from siswa_baru_admin_sdit.");
}

$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display table rows for the students
foreach ($students as $student) {
    echo '<tr>';
    echo '<td>' . ($student['id'] ?? '-') . '</td>';
    echo '<td>' . ($student['nama'] ?? '-') . '</td>';
    echo '<td>' . ($student['umur'] ?? '-') . '</td>';
    echo '<td>' . ($student['kelas'] ?? '-') . '</td>';
    echo '<td>' . ($student['wali_kelas'] ?? '-') . '</td>';
    echo '<td>' . ($student['alamat'] ?? '-') . '</td>';
    echo '<td>' . ($student['telepon'] ?? '-') . '</td>';
    
    // Additional columns specific to SDIT
    echo '<td>' . ($student['tempat_tanggal_lahir'] ?? '-') . '</td>';
    echo '<td>' . ($student['jenis_kelamin'] ?? '-') . '</td>';
    echo '<td>' . ($student['anak_ke'] ?? '-') . '</td>';
    echo '<td>' . ($student['jumlah_saudara'] ?? '-') . '</td>';
    echo '<td>' . ($student['nama_ayah'] ?? '-') . '</td>';
    echo '<td>' . ($student['nama_ibu'] ?? '-') . '</td>';
    echo '<td>' . ($student['pendidikan_ayah'] ?? '-') . '</td>';
    echo '<td>' . ($student['pendidikan_ibu'] ?? '-') . '</td>';
    echo '<td>' . ($student['pekerjaan_ayah'] ?? '-') . '</td>';
    echo '<td>' . ($student['pekerjaan_ibu'] ?? '-') . '</td>';
    echo '<td>' . ($student['agama_orang_tua'] ?? '-') . '</td>';
    echo '<td>' . ($student['alamat_orang_tua'] ?? '-') . '</td>';
    echo '<td>' . ($student['nama_wali'] ?? '-') . '</td>';
    echo '<td>' . ($student['pendidikan_wali'] ?? '-') . '</td>';
    echo '<td>' . ($student['pekerjaan_wali'] ?? '-') . '</td>';
    echo '<td>' . ($student['agama_wali'] ?? '-') . '</td>';
    echo '<td>' . ($student['alamat_wali'] ?? '-') . '</td>';
       // Kolom Status sebagai link yang dapat diklik
       $statusColor = ($student['status'] === 'diterima') ? 'green' : 'red';
echo '<td><a href="#" class="status-toggle" data-id="' . $student['id'] . '" data-table="sdit" style="font-weight: bold; color: ' . $statusColor . ';">' . ($student['status'] ?? '-') . '</a></td>';


    // Download buttons for Foto, Akte, KK
    echo '<td>' . (!empty($student['foto_siswa']) ? '<a href="' . $student['foto_siswa'] . '" class="btn btn-primary btn-sm" download>Download Foto</a>' : '-') . '</td>';
    echo '<td>' . (!empty($student['akte_kelahiran']) ? '<a href="' . $student['akte_kelahiran'] . '" class="btn btn-warning btn-sm" download>Download Akte</a>' : '-') . '</td>';
    echo '<td>' . (!empty($student['kartu_keluarga']) ? '<a href="' . $student['kartu_keluarga'] . '" class="btn btn-success btn-sm" download>Download KK</a>' : '-') . '</td>';
    echo '<td><button class="btn btn-danger btn-sm delete-button" data-id="' . $student['id'] . '" data-table="sdit">Hapus</button></td>';

    echo '</tr>';
}

// Output the total page count as a hidden input for JavaScript
echo '<input type="hidden" id="total-pages-sdit" value="' . $totalPages . '">';
?>
