<?php
require 'config.php';

// Dapatkan tab dari URL untuk menentukan tabel dan kolom yang diambil
$tab = $_GET['tab'] ?? '';

// Tentukan tabel dan kolom yang akan diekspor berdasarkan tab
$table = '';
$filename = '';
$columns = [];
if ($tab === 'tk') {
    $table = 'siswa_baru_admin_tk';
    $filename = 'Data_TK.xls';
    $columns = [
        'id', 'nama', 'umur', 'kelas', 'alamat', 'telepon', 'tempat_tanggal_lahir', 
        'jenis_kelamin', 'anak_ke', 'jumlah_saudara', 'nama_ayah', 'nama_ibu', 
        'pendidikan_ayah', 'pendidikan_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu', 
        'agama_orang_tua', 'alamat_orang_tua', 'nama_wali', 'pendidikan_wali', 
        'pekerjaan_wali', 'agama_wali', 'alamat_wali', 'status'
    ];
} elseif ($tab === 'sdit') {
    $table = 'siswa_baru_admin_sdit';
    $filename = 'Data_SDIT.xls';
    $columns = [
        'id', 'nama', 'umur', 'kelas', 'wali_kelas', 'alamat', 'telepon', 
        'tempat_tanggal_lahir', 'jenis_kelamin', 'anak_ke', 'jumlah_saudara', 
        'nama_ayah', 'nama_ibu', 'pendidikan_ayah', 'pendidikan_ibu', 
        'pekerjaan_ayah', 'pekerjaan_ibu', 'agama_orang_tua', 'alamat_orang_tua', 
        'nama_wali', 'pendidikan_wali', 'pekerjaan_wali', 'agama_wali', 
        'alamat_wali', 'status'
    ];
} elseif ($tab === 'smpit') {
    $table = 'siswa_baru_admin_smpit';
    $filename = 'Data_SMPIT.xls';
    $columns = [
        'id', 'nama', 'umur', 'kelas', 'wali_kelas', 'alamat', 'telepon', 
        'tempat_tanggal_lahir', 'jenis_kelamin', 'anak_ke', 'jumlah_saudara', 
        'nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu', 
        'alamat_orang_tua', 'nama_wali', 'pekerjaan_wali', 'alamat_wali', 
        'agama', 'nilai_akhir', 'nilai_rata', 'alumni_sd', 'penghasilan_per_bulan', 
        'status'
    ];
} else {
    die("Tab tidak valid.");
}

// Set header untuk file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

// Query untuk mengambil hanya kolom yang dibutuhkan dari tabel
$columnsList = implode(", ", $columns);
$stmt = $pdo->prepare("SELECT $columnsList FROM $table");
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output data dalam format tabel HTML yang dikenali oleh Excel
echo "<table border='1'>";
echo "<tr>";
foreach ($columns as $column) {
    echo "<th>" . htmlspecialchars($column) . "</th>";
}
echo "</tr>";

foreach ($students as $student) {
    echo "<tr>";
    foreach ($columns as $column) {
        echo "<td>" . htmlspecialchars($student[$column] ?? '-') . "</td>";
    }
    echo "</tr>";
}

echo "</table>";
exit;
?>
