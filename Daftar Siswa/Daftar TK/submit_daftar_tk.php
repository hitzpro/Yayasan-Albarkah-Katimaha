<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['namaLengkap'];
    $umur = $_POST['umur'] ?? null;
    $kelas = $_POST['kelas'];
    $status = 'pending';
    $alamat = $_POST['alamatSiswa'];
    $tempat_tanggal_lahir = $_POST['tempatTanggalLahir'];
    $jenis_kelamin = $_POST['jenisKelamin'];
    $anak_ke = $_POST['anakKe'];
    $jumlah_saudara = $_POST['jumlahSaudara'] ?? null;
    $nama_ayah = $_POST['namaAyah'] ?? null;
    $nama_ibu = $_POST['namaIbu'] ?? null;
    $pendidikan_ayah = $_POST['pendidikanAyah'] ?? null;
    $pendidikan_ibu = $_POST['pendidikanIbu'] ?? null;
    $pekerjaan_ayah = $_POST['pekerjaanAyah'] ?? null;
    $pekerjaan_ibu = $_POST['pekerjaanIbu'] ?? null;
    $agama_orang_tua = $_POST['agamaOrangTua'] ?? null;
    $alamat_orang_tua = $_POST['alamatOrangTua'] ?? null;
    $nama_wali = $_POST['namaWali'] ?? null;
    $pendidikan_wali = $_POST['pendidikanWali'] ?? null;
    $pekerjaan_wali = $_POST['pekerjaanWali'] ?? null;
    $agama_wali = $_POST['agamaWali'] ?? null;
    $alamat_wali = $_POST['alamatWali'] ?? null;
    $telepon = $_POST['noTelpon'];  // Ambil nomor telepon dari form

    // Dapatkan ID terakhir yang disimpan untuk nama folder
    $lastInsertId = $pdo->lastInsertId();
    $folderName = $nama . $lastInsertId;
    $uploadDir = "Uploads/$folderName/";

    // Buat folder untuk menyimpan file
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Proses upload file Akte Kelahiran
    $akteKelahiranPath = null;
    if (isset($_FILES['akteKelahiran']) && $_FILES['akteKelahiran']['error'] == 0) {
        $akteKelahiranPath = $uploadDir . 'akte_kelahiran_' . basename($_FILES['akteKelahiran']['name']);
        move_uploaded_file($_FILES['akteKelahiran']['tmp_name'], $akteKelahiranPath);
    }

    // Proses upload file Kartu Keluarga
    $kartuKeluargaPath = null;
    if (isset($_FILES['kartuKeluarga']) && $_FILES['kartuKeluarga']['error'] == 0) {  // Gunakan nama yang benar di sini
        $kartuKeluargaPath = $uploadDir . 'kartu_keluarga_' . basename($_FILES['kartuKeluarga']['name']);
        move_uploaded_file($_FILES['kartuKeluarga']['tmp_name'], $kartuKeluargaPath);
    }

    // Proses upload file Foto Siswa
    $fotoSiswaPath = null;
    if (isset($_FILES['fotoSiswa']) && $_FILES['fotoSiswa']['error'] == 0) {
        $fotoSiswaPath = $uploadDir . 'foto_siswa_' . basename($_FILES['fotoSiswa']['name']);
        move_uploaded_file($_FILES['fotoSiswa']['tmp_name'], $fotoSiswaPath);
    }

    // Insert data ke dalam tabel siswa_baru_admin_tk termasuk file path dan nomor telepon
    $stmt = $pdo->prepare("INSERT INTO siswa_baru_admin_tk (nama, umur, kelas, status, tempat_tanggal_lahir, jenis_kelamin, anak_ke, jumlah_saudara, nama_ayah, nama_ibu, pendidikan_ayah, pendidikan_ibu, pekerjaan_ayah, pekerjaan_ibu, agama_orang_tua, alamat_orang_tua, nama_wali, pendidikan_wali, pekerjaan_wali, agama_wali, alamat_wali, telepon, akte_kelahiran, kartu_keluarga, foto_siswa) 
    VALUES (:nama, :umur, :kelas, :status, :tempat_tanggal_lahir, :jenis_kelamin, :anak_ke, :jumlah_saudara, :nama_ayah, :nama_ibu, :pendidikan_ayah, :pendidikan_ibu, :pekerjaan_ayah, :pekerjaan_ibu, :agama_orang_tua, :alamat_orang_tua, :nama_wali, :pendidikan_wali, :pekerjaan_wali, :agama_wali, :alamat_wali, :telepon, :akte_kelahiran, :kartu_keluarga, :foto_siswa)");

    $stmt->execute([
        ':nama' => $nama,
        ':umur' => $umur,
        ':kelas' => $kelas,
        ':status' => $status,
        ':tempat_tanggal_lahir' => $tempat_tanggal_lahir,
        ':jenis_kelamin' => $jenis_kelamin,
        ':anak_ke' => $anak_ke,
        ':jumlah_saudara' => $jumlah_saudara,
        ':nama_ayah' => $nama_ayah,
        ':nama_ibu' => $nama_ibu,
        ':pendidikan_ayah' => $pendidikan_ayah,
        ':pendidikan_ibu' => $pendidikan_ibu,
        ':pekerjaan_ayah' => $pekerjaan_ayah,
        ':pekerjaan_ibu' => $pekerjaan_ibu,
        ':agama_orang_tua' => $agama_orang_tua,
        ':alamat_orang_tua' => $alamat_orang_tua,
        ':nama_wali' => $nama_wali,
        ':pendidikan_wali' => $pendidikan_wali,
        ':pekerjaan_wali' => $pekerjaan_wali,
        ':agama_wali' => $agama_wali,
        ':alamat_wali' => $alamat_wali,
        ':telepon' => $telepon,
        ':akte_kelahiran' => $akteKelahiranPath,
        ':kartu_keluarga' => $kartuKeluargaPath,
        ':foto_siswa' => $fotoSiswaPath
    ]);

    // Ambil ID terakhir yang dimasukkan
    $lastInsertId = $pdo->lastInsertId();

    // Insert data ke dalam tabel siswa_baru_umum_tk dengan nomor telepon
    $stmt2 = $pdo->prepare("INSERT INTO siswa_baru_umum_tk (id, nama, kelas, status) VALUES (:id, :nama, :kelas, :status)");
    $stmt2->execute([
        ':id' => $lastInsertId,
        ':nama' => $nama,
        ':kelas' => $kelas,
        ':status' => $status
    ]);

    // Tampilkan pesan sukses
    echo '<div class="success-container">
            <h2>Pendaftaran Berhasil!</h2>
            <p>Terima kasih telah mendaftar. Data Anda telah berhasil disimpan.</p>
            <a href="/public/index.html" class="btn-back-home">Kembali ke Halaman Utama</a>
          </div>';
    echo '<style>' . file_get_contents('style_success.css') . '</style>';
    exit;
}
?>
