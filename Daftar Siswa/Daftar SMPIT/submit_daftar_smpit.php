<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form inputs
    $nama = $_POST['namaLengkap'] ?? null;
    $umur = $_POST['umur'] ?? null;
    $kelas = $_POST['kelas'] ?? null;
    $wali_kelas = $_POST['waliKelas'] ?? null;
    $alamat = $_POST['alamatTinggal'] ?? null;
    $telepon = $_POST['noTelp'] ?? null;
    $status = 'pending';
    $tempat_tanggal_lahir = $_POST['tempatTanggalLahir'] ?? null;
    $jenis_kelamin = $_POST['jenisKelamin'] ?? null;
    $anak_ke = $_POST['anakKe'] ?? null;
    $jumlah_saudara = $_POST['jumlahSaudara'] ?? null;
    $nama_ayah = $_POST['namaAyah'] ?? null;
    $nama_ibu = $_POST['namaIbu'] ?? null;
    $pekerjaan_ayah = $_POST['pekerjaanAyah'] ?? null;
    $pekerjaan_ibu = $_POST['pekerjaanIbu'] ?? null;
    $alamat_orang_tua = $_POST['alamatOrangTua'] ?? null;
    $nama_wali = $_POST['namaWali'] ?? null;
    $pekerjaan_wali = $_POST['pekerjaanWali'] ?? null;
    $alamat_wali = $_POST['alamatWali'] ?? null;
    $agama = $_POST['agama'] ?? null;
    $nilai_akhir = $_POST['nilaiAkhir'] ?? null;
    $nilai_rata = $_POST['nilaiRata'] ?? null;
    $alumni_sd = $_POST['alumni'] ?? null;
    $penghasilan_per_bulan = $_POST['penghasilanPerBulan'] ?? null;

    // Insert into `siswa_baru_admin_smpit`
    $stmt = $pdo->prepare("INSERT INTO siswa_baru_admin_smpit 
        (nama, umur, kelas, wali_kelas, alamat, telepon, status, tempat_tanggal_lahir, jenis_kelamin, anak_ke, jumlah_saudara, nama_ayah, nama_ibu, pekerjaan_ayah, pekerjaan_ibu, alamat_orang_tua, nama_wali, pekerjaan_wali, alamat_wali, agama, nilai_akhir, nilai_rata, alumni_sd, penghasilan_per_bulan) 
        VALUES 
        (:nama, :umur, :kelas, :wali_kelas, :alamat, :telepon, :status, :tempat_tanggal_lahir, :jenis_kelamin, :anak_ke, :jumlah_saudara, :nama_ayah, :nama_ibu, :pekerjaan_ayah, :pekerjaan_ibu, :alamat_orang_tua, :nama_wali, :pekerjaan_wali, :alamat_wali, :agama, :nilai_akhir, :nilai_rata, :alumni_sd, :penghasilan_per_bulan)");

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
        ':pekerjaan_ayah' => $pekerjaan_ayah,
        ':pekerjaan_ibu' => $pekerjaan_ibu,
        ':alamat_orang_tua' => $alamat_orang_tua,
        ':nama_wali' => $nama_wali,
        ':pekerjaan_wali' => $pekerjaan_wali,
        ':alamat_wali' => $alamat_wali,
        ':agama' => $agama,
        ':nilai_akhir' => $nilai_akhir,
        ':nilai_rata' => $nilai_rata,
        ':alumni_sd' => $alumni_sd,
        ':penghasilan_per_bulan' => $penghasilan_per_bulan
    ]);

    $lastInsertId = $pdo->lastInsertId();
    $folderName = $nama . $lastInsertId;
    $uploadDir = "Uploads/$folderName/";

    // Create directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Process file uploads
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

    // Update paths in `siswa_baru_admin_smpit`
    $stmt = $pdo->prepare("UPDATE siswa_baru_admin_smpit SET 
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

    // Insert into `siswa_baru_umum_smpit` with minimal data
    $stmt2 = $pdo->prepare("INSERT INTO siswa_baru_umum_smpit (id, nama, kelas, status) VALUES (:id, :nama, :kelas, :status)");
    $stmt2->execute([
        ':id' => $lastInsertId,
        ':nama' => $nama,
        ':kelas' => $kelas,
        ':status' => $status
    ]);

    // Success message with embedded CSS
    echo '<div class="success-container">
            <h2>Pendaftaran Berhasil!</h2>
            <p>Data Anda telah berhasil disimpan.</p>
            <a href="/yayasan-albarkah-katimaha/index" class="btn-back-home">Kembali ke Halaman Utama</a>
          </div>';
    echo '<style>' . file_get_contents('style_success.css') . '</style>';
    exit;
}
?>
