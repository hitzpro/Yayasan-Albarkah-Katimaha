<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil semua data dari form, gunakan nilai default jika input tidak ada
    $nama = $_POST['namaLengkap'] ?? null;
    $umur = $_POST['umur'] ?? null;
    $kelas = $_POST['kelas'] ?? null;
    $wali_kelas = $_POST['waliKelas'] ?? null;
    $alamat = $_POST['alamatSiswa'] ?? null;
    $telepon = $_POST['noTelepon'] ?? null;
    $tempat_tanggal_lahir = $_POST['tempatTanggalLahir'] ?? null;
    $jenis_kelamin = $_POST['jenisKelamin'] ?? null;
    $anak_ke = $_POST['anakKe'] ?? null;
    $jumlah_saudara = $_POST['jumlahSaudara'] ?? null;
    $nama_ayah = $_POST['namaAyah'] ?? null;
    $nama_ibu = $_POST['namaIbu'] ?? null;
    $pendidikan_ayah = $_POST['pendidikanAyah'] ?? null;
    $pendidikan_ibu = $_POST['pendidikanIbu'] ?? null;
    $pekerjaan_ayah = $_POST['pekerjaanAyah'] ?? null;
    $pekerjaan_ibu = $_POST['pekerjaanIbu'] ?? null;
    $agama_orang_tua = $_POST['agamaOrtu'] ?? null;
    $alamat_orang_tua = $_POST['alamatOrtu'] ?? null;
    $nama_wali = $_POST['namaWali'] ?? null;
    $pendidikan_wali = $_POST['pendidikanWali'] ?? null;
    $pekerjaan_wali = $_POST['pekerjaanWali'] ?? null;
    $agama_wali = $_POST['agamaWali'] ?? null;
    $alamat_wali = $_POST['alamatWali'] ?? null;
    $status = 'pending';

    // Simpan data ke tabel siswa_baru_admin_sdit
    $stmt = $pdo->prepare("INSERT INTO siswa_baru_admin_sdit (nama, umur, kelas, wali_kelas, alamat, telepon, status, tempat_tanggal_lahir, jenis_kelamin, anak_ke, jumlah_saudara, nama_ayah, nama_ibu, pendidikan_ayah, pendidikan_ibu, pekerjaan_ayah, pekerjaan_ibu, agama_orang_tua, alamat_orang_tua, nama_wali, pendidikan_wali, pekerjaan_wali, agama_wali, alamat_wali) 
        VALUES (:nama, :umur, :kelas, :wali_kelas, :alamat, :telepon, :status, :tempat_tanggal_lahir, :jenis_kelamin, :anak_ke, :jumlah_saudara, :nama_ayah, :nama_ibu, :pendidikan_ayah, :pendidikan_ibu, :pekerjaan_ayah, :pekerjaan_ibu, :agama_orang_tua, :alamat_orang_tua, :nama_wali, :pendidikan_wali, :pekerjaan_wali, :agama_wali, :alamat_wali)");
    $stmt->execute([
        ':nama' => $nama,
        ':umur' => $umur,
        ':kelas' => $kelas,
        ':wali_kelas' => $wali_kelas,
        ':alamat' => $alamat,
        ':telepon' => $telepon,
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
        ':alamat_wali' => $alamat_wali
    ]);

    // Ambil ID terbaru untuk penamaan folder
    $lastInsertId = $pdo->lastInsertId();
    $folderName = $nama . $lastInsertId;
    $uploadDir = "Uploads/$folderName/";

    // Buat folder jika belum ada
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Proses file upload
    $akteKelahiranPath = null;
    if (isset($_FILES['akteKelahiran']) && $_FILES['akteKelahiran']['error'] == 0) {
        $akteKelahiranPath = $uploadDir . 'akte_kelahiran_' . time() . '_' . basename($_FILES['akteKelahiran']['name']);
        move_uploaded_file($_FILES['akteKelahiran']['tmp_name'], $akteKelahiranPath);
    }

    $kartuKeluargaPath = null;
    if (isset($_FILES['kartuKeluarga']) && $_FILES['kartuKeluarga']['error'] == 0) {
        $kartuKeluargaPath = $uploadDir . 'kartu_keluarga_' . time() . '_' . basename($_FILES['kartuKeluarga']['name']);
        move_uploaded_file($_FILES['kartuKeluarga']['tmp_name'], $kartuKeluargaPath);
    }

    $fotoSiswaPath = null;
    if (isset($_FILES['fotoSiswa']) && $_FILES['fotoSiswa']['error'] == 0) {
        $fotoSiswaPath = $uploadDir . 'foto_siswa_' . time() . '_' . basename($_FILES['fotoSiswa']['name']);
        move_uploaded_file($_FILES['fotoSiswa']['tmp_name'], $fotoSiswaPath);
    }

    // Simpan path file ke tabel siswa_baru_admin_sdit
    $stmt = $pdo->prepare("UPDATE siswa_baru_admin_sdit SET 
        akte_kelahiran = :akte_kelahiran, 
        kartu_keluarga = :kartu_keluarga, 
        foto_siswa = :foto_siswa 
        WHERE id = :id");

    $stmt->execute([
        ':akte_kelahiran' => $akteKelahiranPath,
        ':kartu_keluarga' => $kartuKeluargaPath,
        ':foto_siswa' => $fotoSiswaPath,
        ':id' => $lastInsertId
    ]);

    // Insert data ke dalam tabel siswa_baru_umum_sdit dengan nomor telepon
    $stmt2 = $pdo->prepare("INSERT INTO siswa_baru_umum_sdit (id, nama, kelas, status) VALUES (:id, :nama, :kelas, :status)");
    $stmt2->execute([
        ':id' => $lastInsertId,
        ':nama' => $nama,
        ':kelas' => $kelas,
        ':status' => $status
    ]);

    // Pesan sukses
    echo '<div class="success-container">
            <h2>Pendaftaran Berhasil!</h2>
            <p>Data Anda telah berhasil disimpan.</p>
            <a href="/yayasan-albarkah-katimaha/index" class="btn-back-home">Kembali ke Halaman Utama</a>
          </div>';
    echo '<style>' . file_get_contents('style_success.css') . '</style>';
    exit;
}
?>
