<?php
require 'config.php';

$tab = $_GET['tab'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

if ($tab === 'tk') {
    $stmt = $pdo->prepare("SELECT * FROM siswa_baru_admin_tk LIMIT :offset, :perPage");
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($students as $student) {
        echo '<tr>';
        echo '<td>' . ($student['id'] ?? '-') . '</td>';
        echo '<td>' . ($student['nama'] ?? '-') . '</td>';
        echo '<td>' . ($student['umur'] ?? '-') . '</td>';
        echo '<td>' . ($student['kelas'] ?? '-') . '</td>';
        echo '<td>' . ($student['alamat'] ?? '-') . '</td>';
        echo '<td>' . ($student['telepon'] ?? '-') . '</td>';
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
        
        
        // Tombol aksi terpisah untuk download Foto, Akte, dan KK
        echo '<td>';
        if (!empty($student['foto_siswa'])) {
            echo '<a href="' . $student['foto_siswa'] . '" class="btn btn-primary btn-sm" download>Download Foto</a>';
        } else {
            echo '-';
        }
        echo '</td>';
        
        echo '<td>';
        if (!empty($student['akte_kelahiran'])) {
            echo '<a href="' . $student['akte_kelahiran'] . '" class="btn btn-warning btn-sm" download>Download Akte</a>';
        } else {
            echo '-';
        }
        echo '</td>';
        
        echo '<td>';
        if (!empty($student['kartu_keluarga'])) {
            echo '<a href="' . $student['kartu_keluarga'] . '" class="btn btn-success btn-sm" download>Download KK</a>';
        } else {
            echo '-';
        }
        echo '</td>';

        echo '</tr>';
    }
}elseif ($tab === 'sdit') {
  // Query untuk siswa SDIT
  $stmt = $pdo->prepare("SELECT * FROM siswa_baru_admin_sdit LIMIT :offset, :perPage");
  $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
  $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
  $stmt->execute();
  $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($students as $student) {
      echo '<tr>';
      echo '<td>' . ($student['id'] ?? '-') . '</td>';
      echo '<td>' . ($student['nama'] ?? '-') . '</td>';
      echo '<td>' . ($student['umur'] ?? '-') . '</td>';
      echo '<td>' . ($student['kelas'] ?? '-') . '</td>';
      echo '<td>' . ($student['wali_kelas'] ?? '-') . '</td>';
      echo '<td>' . ($student['alamat'] ?? '-') . '</td>';
      echo '<td>' . ($student['telepon'] ?? '-') . '</td>';
      echo '<td>' . ($student['status'] ?? '-') . '</td>';
      
      // Kolom tambahan yang ada di tabel siswa_baru_admin_sdit
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
      
      // Tombol download untuk file
      echo '<td>' . (!empty($student['foto_siswa']) ? '<a href="' . $student['foto_siswa'] . '" class="btn btn-primary btn-sm" download>Download Foto</a>' : '-') . '</td>';
      echo '<td>' . (!empty($student['akte_kelahiran']) ? '<a href="' . $student['akte_kelahiran'] . '" class="btn btn-warning btn-sm" download>Download Akte</a>' : '-') . '</td>';
      echo '<td>' . (!empty($student['kartu_keluarga']) ? '<a href="' . $student['kartu_keluarga'] . '" class="btn btn-success btn-sm" download>Download KK</a>' : '-') . '</td>';
      echo '</tr>';
  }
}




?>
