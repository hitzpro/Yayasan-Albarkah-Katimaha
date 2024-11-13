<?php
require 'config.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Calculate total number of records and pages
$totalStmt = $pdo->query("SELECT COUNT(*) FROM siswa_baru_admin_smpit");
$totalStudents = $totalStmt->fetchColumn();
$totalPages = ceil($totalStudents / $perPage);

// Fetch students for the current page
$stmt = $pdo->prepare("SELECT * FROM siswa_baru_admin_smpit LIMIT :offset, :perPage");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
$stmt->execute();

$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display table rows for the students
foreach ($students as $student) {
    // Buat URL yang sesuai dengan path lokasi gambar
    $folderName = urlencode($student['nama'] . $student['id']);
    $basePath = "/public/Daftar Siswa/Daftar SMPIT/Uploads/$folderName/";

    // URL file
    $fotoSiswaUrl = !empty($student['foto_siswa']) ? $basePath . urlencode($student['foto_siswa']) : null;
    $akteKelahiranUrl = !empty($student['akte_kelahiran']) ? $basePath . urlencode($student['akte_kelahiran']) : null;
    $kartuKeluargaUrl = !empty($student['kartu_keluarga']) ? $basePath . urlencode($student['kartu_keluarga']) : null;

    echo '<tr>';
    echo '<td>' . ($student['id'] ?? '-') . '</td>';
    echo '<td>' . ($student['nama'] ?? '-') . '</td>';
    echo '<td>' . ($student['umur'] ?? '-') . '</td>';
    echo '<td>' . ($student['kelas'] ?? '-') . '</td>';
    echo '<td>' . ($student['wali_kelas'] ?? '-') . '</td>';
    echo '<td>' . ($student['alamat'] ?? '-') . '</td>';
    echo '<td>' . ($student['telepon'] ?? '-') . '</td>';
    echo '<td>' . ($student['tempat_tanggal_lahir'] ?? '-') . '</td>';
    echo '<td>' . ($student['jenis_kelamin'] ?? '-') . '</td>';
    echo '<td>' . ($student['anak_ke'] ?? '-') . '</td>';
    echo '<td>' . ($student['jumlah_saudara'] ?? '-') . '</td>';
    echo '<td>' . ($student['nama_ayah'] ?? '-') . '</td>';
    echo '<td>' . ($student['nama_ibu'] ?? '-') . '</td>';
    echo '<td>' . ($student['pekerjaan_ayah'] ?? '-') . '</td>';
    echo '<td>' . ($student['pekerjaan_ibu'] ?? '-') . '</td>';
    echo '<td>' . ($student['alamat_orang_tua'] ?? '-') . '</td>';
    echo '<td>' . ($student['nama_wali'] ?? '-') . '</td>';
    echo '<td>' . ($student['pekerjaan_wali'] ?? '-') . '</td>';
    echo '<td>' . ($student['alamat_wali'] ?? '-') . '</td>';
    echo '<td>' . ($student['agama'] ?? '-') . '</td>';
    echo '<td>' . ($student['nilai_akhir'] ?? '-') . '</td>';
    echo '<td>' . ($student['nilai_rata'] ?? '-') . '</td>';
    echo '<td>' . ($student['alumni_sd'] ?? '-') . '</td>';
    echo '<td>' . ($student['penghasilan_per_bulan'] ?? '-') . '</td>';

    // Kolom Status sebagai link yang dapat diklik
    $statusColor = ($student['status'] === 'diterima') ? 'green' : 'red';
    echo '<td><a href="#" class="status-toggle" data-id="' . $student['id'] . '" data-table="smpit" style="font-weight: bold; color: ' . $statusColor . ';">' . ($student['status'] ?? '-') . '</a></td>';

    // Link download dengan tombol
    echo '<td>' . ($fotoSiswaUrl ? '<a href="' . $fotoSiswaUrl . '" class="btn btn-primary btn-sm" download>Download Foto</a>' : '-') . '</td>';
    echo '<td>' . ($akteKelahiranUrl ? '<a href="' . $akteKelahiranUrl . '" class="btn btn-warning btn-sm" download>Download Akte</a>' : '-') . '</td>';
    echo '<td>' . ($kartuKeluargaUrl ? '<a href="' . $kartuKeluargaUrl . '" class="btn btn-success btn-sm" download>Download KK</a>' : '-') . '</td>';

    // Tombol hapus
    echo '<td><button class="btn btn-danger btn-sm delete-button" data-id="' . $student['id'] . '" data-table="smpit">Hapus</button></td>';
    echo '</tr>';
}

// Output the total page count as a hidden input for JavaScript pagination
echo '<input type="hidden" id="total-pages-smpit" value="' . $totalPages . '">';

?>
