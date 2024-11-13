<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="CSS/styles.css" />
    <link
      rel="shortcut icon"
      href="Logo/LOGO_YAYASAN.png"
      type="image/x-icon"
    />
    <style>

        /* Color Variables */
:root {
  --primary-color: #4caf50;
  --secondary-color: #ffffff;
  --text-color: #333;
  --background-color: #f9f9f9;
  --primary-hover: #45a049;
  --secondary-hover: #e9e9e9;
}

body {
  font-family: "Poppins", sans-serif;
  background-color: var(--background-color);
  color: var(--text-color);
  
}
/* Navbar Styles */
.navbar {
  background-color: #4caf50; /* Warna latar navbar */
  padding: 15px 0;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.navbar .navbar-brand {
  color: white; /* Warna teks brand */
  font-weight: bold; /* Menebalkan teks brand */
}

/* Footer Styles */
.footer {
  background-color: #4caf50; /* Warna latar footer */
  color: white; /* Warna teks footer */
  padding: 20px 0; /* Padding atas dan bawah */
  font-weight: bold;
}

.footer-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 15px; /* Padding samping */
}

.footer-logo {
  max-width: 100px; /* Ukuran maksimum logo */
}

.social-link {
  color: white; /* Warna teks untuk link sosial */
  text-decoration: none; /* Menghilangkan garis bawah */
  margin: 0 10px; /* Margin antar link */
}

.social-link:hover {
  text-decoration: underline; /* Garis bawah saat hover */
}

/* Responsive Styles */
@media (max-width: 768px) {
  .container {
    width: 90%; /* Lebar kontainer di perangkat kecil */
  }

  .footer-container {
    flex-direction: column; /* Mengatur footer menjadi kolom pada perangkat kecil */
    align-items: flex-start; /* Menyelaraskan item di kiri */
    text-align: left; /* Teks diratakan ke kiri */
  }

  .social-link {
    margin: 5px 0; /* Margin vertikal antar link sosial */
  }
  
}

/* Logo Footer */
.footer-logo {
  max-width: 100px; /* Batas maksimal lebar logo footer */
  height: auto; /* Tinggi otomatis untuk menjaga proporsi */
}

/* Menambahkan margin pada logo footer */
.footer-left {
  margin-right: 15px; /* Jarak kanan antara logo dan informasi footer */
}

/* Responsive Styles for Logos */
@media (max-width: 768px) {
  .logo-header {
    max-width: 150px; /* Ukuran logo header di perangkat kecil */
  }

  .footer-logo {
    max-width: 80px; /* Ukuran logo footer di perangkat kecil */
  }
}

.logo-header:hover {
  text-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  color: var(--secondary-color);
}
.btn-back {
  background-color: var(--secondary-color);
  color: var(--primary-color);
  padding: 8px;
  border-radius: 5px;
  margin: 0 10px;
  font-weight: bold;
  text-decoration: none;
}

.btn-back:hover {
  background-color: var(--secondary-hover);
  color: var(--primary-color);
  padding: 8px;
  border-radius: 5px;
  margin: 0 10px;
  font-weight: bold;
  text-decoration: none;
}

        /* Style untuk tab */
        .tab {
            overflow: hidden;
            border-bottom: 1px solid #ccc;
        }

        .tab button {
            background-color: inherit;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
        }

        .tab button:hover {
            background-color: #ddd;
        }

        .tab button.active {
            background-color: #ccc;
        }

        /* Style untuk konten tab */
        .tabcontent {
            display: none;
            padding: 20px;
            border: 1px solid #ccc;
            border-top: none;
        }

        /* Style untuk tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Style untuk navigasi paginasi */
        .pagination {
            display: flex;
            justify-content: center;
            list-style-type: none;
            padding: 0;
        }

        .pagination li {
            display: inline;
            padding: 8px 16px;
            border: 1px solid #ddd;
            margin: 0 4px;
            cursor: pointer;
        }

        .pagination li.active {
            background-color: #4CAF50;
            color: white;
        }


        .container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}
    </style>
</head>
<body>

<nav class="navbar">
      <div class="container">
        <a class="navbar-brand" href="/yayasan-albarkah-katimaha/index.html">
          <h4 class="logo-header">
            <strong>Yayasan Al Barkah Katimaha</strong>
          </h4>
        </a>
        <a class="btn-back" href="/yayasan-albarkah-katimaha/index.html">Kembali</a>
      </div>
    </nav>
    <br><br>



    <div class="container">
<h2 style="text-align:center;"><strong>Data Siswa Baru</strong></h2>
<div class="tab">
    <button class="tablinks" onclick="openTab(event, 'TK')" id="defaultOpen">TK</button>
    <button class="tablinks" onclick="openTab(event, 'SDIT')">SDIT</button>
    <button class="tablinks" onclick="openTab(event, 'SMPIT')">SMPIT</button>
</div>

<div id="TK" class="tabcontent">
    <?php displayData('siswa_baru_umum_tk'); ?>
</div>

<div id="SDIT" class="tabcontent">
    <?php displayData('siswa_baru_umum_sdit'); ?>
</div>

<div id="SMPIT" class="tabcontent">
    <?php displayData('siswa_baru_umum_smpit'); ?>
</div>
</div>

<script>
    // Fungsi untuk membuka tab
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Membuka tab default
    document.getElementById("defaultOpen").click();
</script>

<?php
// Fungsi untuk menampilkan data dengan paginasi
function displayData($table) {
    $host = 'localhost';
    $dbname = 'yayasan_albarkah';
    $username = 'wakhid123';
    $password = 'wakhid123';
    
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Ambil jumlah data total
        $stmt = $conn->query("SELECT COUNT(*) FROM $table");
        $totalRecords = $stmt->fetchColumn();
        $limit = 10; // Jumlah data per halaman
        $totalPages = ceil($totalRecords / $limit);

        // Tentukan halaman saat ini
        $page = isset($_GET[$table . '_page']) ? (int)$_GET[$table . '_page'] : 1;
        $offset = ($page - 1) * $limit;

        // Query data sesuai paginasi
        $stmt = $conn->query("SELECT * FROM $table LIMIT $limit OFFSET $offset");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($data) {
            echo "<table>";
            echo "<tr>";
            foreach (array_keys($data[0]) as $columnName) {
                echo "<th>$columnName</th>";
            }
            echo "</tr>";
            
            foreach ($data as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Tidak ada data yang ditemukan.</p>";
        }

        // Tampilkan navigasi paginasi
        echo '<ul class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = $i == $page ? 'class="active"' : '';
            echo "<li $active onclick=\"window.location.href='?{$table}_page=$i'\">$i</li>";
        }
        echo '</ul>';
        
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
</body>
</html>
