<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../Login/login.html"); // Redirect ke halaman login jika belum login
    exit();
}

// Simpan koneksi database di sini
$dsn = "mysql:host=localhost;dbname=yayasan_albarkah;charset=utf8mb4";
$dbUsername = "wakhid123";
$dbPassword = "wakhid123";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$adminId = $_SESSION['admin_id'];

try {
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, $options);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <!-- Include SweetAlert2 CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <!-- Sidebar Toggle Button positioned at top-left -->
    <button class="toggle-btn" onclick="toggleSidebar()" id="sidebarToggleBtn">&#9776;</button>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar" id="sidebar">
                <div class="profile-info">
                    <img src="profile-pic-placeholder.png" alt="Profile Picture" class="profile-pic">
                    <h5 id="adminName">Admin Name</h5>
                    <p>ID Wali Kelas: <span id="waliKelasId"><?php echo htmlspecialchars($adminId); ?></span></p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" onclick="showSection('profile', this)">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showSection('student-management', this)">Manajemen Siswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showSection('upload-student-data', this)">Upload Data Siswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showSection('announcement', this)">Pengumuman</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="logout.php" id="logout-link">Logout</a>

<!-- Tambahkan library SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById("logout-link").addEventListener("click", function(event) {
    event.preventDefault(); // Mencegah pengalihan langsung

    Swal.fire({
        title: 'Apakah Anda yakin ingin logout?',
        text: "Anda akan keluar dari sesi ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, logout!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'logout.php'; // Mengarahkan ke logout.php jika dikonfirmasi
        }
    });
});
</script>

                    </li>
                </ul>
                <div class="date-time" id="date-time"></div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 content" id="mainContent">
                <!-- Profile Section -->
                <section id="profile" class="section active">
                    <h3>Edit Profile</h3>
                    <form>
                        <div class="form-group">
                            <label for="adminName">Name</label>
                            <input type="text" class="form-control" id="adminName" placeholder="Enter your name">
                        </div>
                        <div class="form-group">
                            <label for="adminPhoto">Upload Photo</label>
                            <input type="file" class="form-control-file" id="adminPhoto">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Profile</button>
                    </form>
                </section>

                <section id="student-management" class="section">
    <h3>Manajemen Siswa</h3>
    <ul class="nav nav-tabs" id="student-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab-tk" data-toggle="tab" href="#tk" role="tab" aria-controls="tk" aria-selected="true">Siswa TK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab-sdit" data-toggle="tab" href="#sdit" role="tab" aria-controls="sdit" aria-selected="false">Siswa SDIT</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab-smpit" data-toggle="tab" href="#smpit" role="tab" aria-controls="smpit" aria-selected="false">Siswa SMPIT</a>
        </li>
    </ul>

    <div class="tab-content mt-3">
    <!-- TK Table -->
    <div class="tab-pane fade show active" id="tk" role="tabpanel" aria-labelledby="tab-tk">
        <div class="table-container">
            <table id="table-tk" class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>Kelas</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Tempat Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Anak Ke</th>
                        <th>Jumlah Saudara</th>
                        <th>Nama Ayah</th>
                        <th>Nama Ibu</th>
                        <th>Pendidikan Ayah</th>
                        <th>Pendidikan Ibu</th>
                        <th>Pekerjaan Ayah</th>
                        <th>Pekerjaan Ibu</th>
                        <th>Agama Orang Tua</th>
                        <th>Alamat Orang Tua</th>
                        <th>Nama Wali</th>
                        <th>Pendidikan Wali</th>
                        <th>Pekerjaan Wali</th>
                        <th>Agama Wali</th>
                        <th>Alamat Wali</th>
                        <th>STATUS</th>
                        <th>Foto</th>
                        <th>Akte Kelahiran</th>
                        <th>Kartu Keluarga</th>
                    </tr>
                </thead>
                <tbody id="content-tk">
                    <!-- TK content from PHP will load here -->
                </tbody>
            </table>
        </div>
        <button id="downloadExcelTk" class="btn btn-success mt-3">Download Data TK ke Excel</button>
        <div id="pagination-tk" class="pagination-container"></div>
    </div>

    <!-- SDIT Table -->
    <div class="tab-pane fade" id="sdit" role="tabpanel" aria-labelledby="tab-sdit">
        <div class="table-container">
            <table id="table-sdit" class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Tempat Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Anak Ke</th>
                        <th>Jumlah Saudara</th>
                        <th>Nama Ayah</th>
                        <th>Nama Ibu</th>
                        <th>Pendidikan Ayah</th>
                        <th>Pendidikan Ibu</th>
                        <th>Pekerjaan Ayah</th>
                        <th>Pekerjaan Ibu</th>
                        <th>Agama Orang Tua</th>
                        <th>Alamat Orang Tua</th>
                        <th>Nama Wali</th>
                        <th>Pendidikan Wali</th>
                        <th>Pekerjaan Wali</th>
                        <th>Agama Wali</th>
                        <th>Alamat Wali</th>
                        <th>STATUS</th>
                        <th>Foto</th>
                        <th>Akte Kelahiran</th>
                        <th>Kartu Keluarga</th>
                    </tr>
                </thead>
                <tbody id="content-sdit">
                    <!-- SDIT content from PHP will load here -->
                </tbody>
            </table>
        </div>
        <button id="downloadExcelSdit" class="btn btn-success mt-3">Download Data SDIT ke Excel</button>
        <div id="pagination-sdit" class="pagination-container"></div>
    </div>

<!-- SMPIT Table -->
<div class="tab-pane fade" id="smpit" role="tabpanel" aria-labelledby="tab-smpit">
    <div class="table-container">
        <table id="table-smpit" class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Umur</th>
                    <th>Kelas</th>
                    <th>Wali Kelas</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Tempat Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Anak Ke</th>
                    <th>Jumlah Saudara</th>
                    <th>Nama Ayah</th>
                    <th>Nama Ibu</th>
                    <th>Pekerjaan Ayah</th>
                    <th>Pekerjaan Ibu</th>
                    <th>Alamat Orang Tua</th>
                    <th>Nama Wali</th>
                    <th>Pekerjaan Wali</th>
                    <th>Alamat Wali</th>
                    <th>Agama</th>
                    <th>Nilai Akhir</th>
                    <th>Nilai Rata-Rata</th>
                    <th>Alumni SD</th>
                    <th>Penghasilan per Bulan</th>
                    <th>STATUS</th>
                    <th>Foto</th>
                    <th>Akte Kelahiran</th>
                    <th>Kartu Keluarga</th>
                </tr>
            </thead>
            <tbody id="content-smpit">
                <!-- SMPIT content from PHP will load here -->
            </tbody>
        </table>
    </div>
    <button id="downloadExcelSmpit" class="btn btn-success mt-3">Download Data SMPIT ke Excel</button>
    <div id="pagination-smpit" class="pagination-container"></div>
</div>


</section>


                <!-- Upload Data Section -->
                <section id="upload-student-data" class="section">
                    <h3>Upload Data Siswa Lama</h3>
                    <form>
                        <div class="form-group">
                            <label for="uploadFile">Upload Excel File</label>
                            <input type="file" class="form-control-file" id="uploadFile">
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                </section>

                <!-- Announcement Section -->
                <section id="announcement" class="section">
                    <h3>Pengumuman</h3>
                    <form>
                        <div class="form-group">
                            <label for="announcementTitle">Judul Pengumuman</label>
                            <input type="text" class="form-control" id="announcementTitle">
                        </div>
                        <div class="form-group">
                            <label for="announcementContent">Isi Pengumuman</label>
                            <textarea class="form-control" id="announcementContent" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Publish</button>
                    </form>
                </section>
            </main>
        </div>
    </div>

  <!-- Modal Popup untuk pesan -->
<div id="modal-popup" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="modal-message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Konfirmasi Hapus -->
<div id="delete-confirmation-modal" class="modal">
    <div class="modal-container">
    <h2>Konfirmasi Hapus</h2>
    <p>Apakah Anda yakin ingin menghapus data ini?</p>
    <button id="confirm-delete-btn" class="btn btn-danger">Yes</button>
    <button onclick="closeDeleteModal()" class="btn btn-secondary">No</button>
    </div>
</div>

<!-- Modal Notifikasi Berhasil Hapus -->
<div id="success-modal" class="modal">
    <h2>Berhasil</h2>
    <p>Data berhasil dihapus.</p>
    <button onclick="closeSuccessModal()" class="btn btn-primary">OK</button>
</div>

<!-- Overlay untuk menampilkan modal di tengah layar -->
<div id="modal-overlay" class="modal-overlay"></div>




<!-- Modal untuk Menampilkan Status Operasi (Berhasil/Gagal) -->
<div id="operation-status-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="status-modal-title">Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeStatusModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="status-modal-message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeStatusModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const content = document.getElementById("mainContent");
            sidebar.classList.toggle("closed");
            content.classList.toggle("expanded");
        }

        function showSection(sectionId, element) {
            document.querySelectorAll(".section").forEach((section) => {
                section.classList.remove("active");
            });
            document.querySelectorAll(".nav-link").forEach((link) => {
                link.classList.remove("active");
            });

            document.getElementById(sectionId).classList.add("active");
            element.classList.add("active");
        }

        function updateDateTime() {
            const now = new Date();
            const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const months = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
                "Agustus", "September", "Oktober", "November", "Desember"
            ];
            const formattedDate = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
            const formattedTime = now.toLocaleTimeString("id-ID");
            document.getElementById("date-time").innerText = `${formattedDate} ${formattedTime}`;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const currentTabContent = {
        tk: document.getElementById("tk"), // Tab div for TK
        sdit: document.getElementById("sdit"), // Tab div for SDIT
        smpit: document.getElementById("smpit") // Tab div for SMPIT
    };

    function loadPage(tabName, pageIndex) {
        if (!tabName || !currentTabContent[tabName]) {
            console.error(`Invalid tab name: "${tabName}"`);
            return;
        }

        const url = `get_students_${tabName}.php?page=${pageIndex}`;
        console.log(`Loading URL: ${url}`);

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error(`Network response was not ok: ${response.statusText}`);
                return response.text();
            })
            .then(html => {
                console.log(`Content loaded for ${tabName}:`, html);

                // Clear only the tbody for the selected tab
                currentTabContent[tabName].querySelector("tbody").innerHTML = html;

                // Extract total pages for pagination
                const totalPagesInput = document.getElementById(`total-pages-${tabName}`);
                const totalPages = totalPagesInput ? parseInt(totalPagesInput.value) : 1;

                console.log(`Total pages for ${tabName}: ${totalPages}`);
                setupPagination(tabName, pageIndex, totalPages);
            })
            .catch(error => {
                console.error(`Failed to load content for ${tabName} page ${pageIndex}:`, error);
            });
    }

    function setupPagination(tabName, currentPage, totalPages) {
        const paginationContainer = document.getElementById(`pagination-${tabName}`);
        if (!paginationContainer) {
            console.error(`Pagination container not found for ${tabName}`);
            return;
        }
        paginationContainer.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.innerText = i;
            pageButton.classList.add('page-btn');
            if (i === currentPage) pageButton.classList.add('active');

            pageButton.addEventListener('click', () => loadPage(tabName, i));
            paginationContainer.appendChild(pageButton);
        }
    }

    const tabs = document.querySelectorAll('.nav-link');
    tabs.forEach(tab => {
        tab.addEventListener('click', function(event) {
            event.preventDefault();
            const selectedTab = tab.getAttribute('href').substring(1);

            console.log(`Tab clicked: ${selectedTab}`);

            if (!selectedTab || !currentTabContent[selectedTab]) {
                console.error(`Invalid tab name selected: "${selectedTab}"`);
                return;
            }

            // Remove 'show' and 'active' classes from all tab contents
            Object.keys(currentTabContent).forEach(tabKey => {
                currentTabContent[tabKey].classList.remove("show", "active");
            });

            // Add 'show' and 'active' classes only to the selected tab content
            currentTabContent[selectedTab].classList.add("show", "active");

            // Set active class on the selected tab link
            tabs.forEach(item => item.classList.remove('active'));
            tab.classList.add('active');

            // Load page content for the selected tab, default to page 1
            loadPage(selectedTab, 1);
        });
    });

    // Initial load with TK tab default
    loadPage("tk", 1);
});

</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("downloadExcelTk").addEventListener("click", function () {
        window.location.href = "downloadExcel.php?tab=tk";
    });

    document.getElementById("downloadExcelSdit").addEventListener("click", function () {
        window.location.href = "downloadExcel.php?tab=sdit";
    });

    document.getElementById("downloadExcelSmpit").addEventListener("click", function () {
        window.location.href = "downloadExcel.php?tab=smpit";
    });
});


</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Toggle status
    document.querySelectorAll('.status-toggle').forEach(statusLink => {
        statusLink.addEventListener('click', function (e) {
            e.preventDefault();
            const studentId = this.getAttribute('data-id');

            fetch('update_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: studentId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.innerText = data.newStatus;
                    this.style.color = data.newStatus === 'diterima' ? 'green' : 'red';
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Delete row
    document.querySelectorAll('.delete-button').forEach(deleteBtn => {
        deleteBtn.addEventListener('click', function () {
            const studentId = this.getAttribute('data-id');

            if (confirm("Yakin ingin menghapus data ini?")) {
                fetch('delete_student.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: studentId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('tr').remove();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
});

</script>





<script>
// Fungsi untuk membuka modal
function showModal(title, message) {
    document.getElementById('modal-title').innerText = title;
    document.getElementById('modal-message').innerText = message;
    document.getElementById('modal-popup').style.display = 'block';
    document.getElementById('modal-overlay').style.display = 'block';
}

// Fungsi untuk menutup modal
function closeModal() {
    document.getElementById('modal-popup').style.display = 'none';
    document.getElementById('modal-overlay').style.display = 'none';
}

// Variabel untuk menyimpan ID dan tabel yang akan dihapus
let deleteId = null;
let deleteTable = null;

// Fungsi untuk membuka modal konfirmasi hapus
function showDeleteModal(id, table) {
    deleteId = id;
    deleteTable = table;
    document.getElementById('delete-confirmation-modal').style.display = 'flex';
    document.getElementById('modal-overlay').style.display = 'block';
}

// Fungsi untuk menutup modal konfirmasi hapus
function closeDeleteModal() {
    document.getElementById('delete-confirmation-modal').style.display = 'none';
    document.getElementById('modal-overlay').style.display = 'none';
    deleteId = null;
    deleteTable = null;
}

// Fungsi untuk membuka modal sukses hapus
function showSuccessModal() {
    document.getElementById('success-modal').style.display = 'block';
    document.getElementById('modal-overlay').style.display = 'block';
}

// Fungsi untuk menutup modal sukses hapus
function closeSuccessModal() {
    document.getElementById('success-modal').style.display = 'none';
    document.getElementById('modal-overlay').style.display = 'none';
}

// Event listener untuk tombol konfirmasi hapus pada modal
document.getElementById('confirm-delete-btn').addEventListener('click', function () {
    if (deleteId && deleteTable) {
        fetch('delete_student.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: deleteId, table: deleteTable })
        })
        .then(response => response.json())
        .then(data => {
            closeDeleteModal();
            if (data.success) {
                document.querySelector(`button[data-id="${deleteId}"][data-table="${deleteTable}"]`).closest('tr').remove();
                showSuccessModal(); // Tampilkan modal berhasil setelah data dihapus
            } else {
                showModal("Kesalahan", "Gagal menghapus data.");
            }
        })
        .catch(error => {
            closeDeleteModal();
            showModal("Peringatan", "Berhasil Menghapus Data");
        });
    }
});

// Delegasi event untuk menangani klik pada tombol hapus dan status-toggle
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('delete-button')) {
        event.preventDefault();
        const studentId = event.target.getAttribute('data-id');
        const table = event.target.getAttribute('data-table');
        
        // Tampilkan modal konfirmasi hapus
        showDeleteModal(studentId, table);
    }

    if (event.target.classList.contains('status-toggle')) {
        event.preventDefault();
        const statusLink = event.target;
        const studentId = statusLink.getAttribute('data-id');
        const table = statusLink.getAttribute('data-table');

        fetch('update_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: studentId, table: table })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                statusLink.innerText = data.newStatus;
                statusLink.style.color = data.newStatus === 'diterima' ? 'green' : 'red';
                showModal("Status Diperbarui", `Status telah diubah menjadi "${data.newStatus}"`);
            } else {
                showModal("Kesalahan", "Gagal mengubah status: " + (data.error || "Tidak diketahui"));
            }
        })
        .catch(error => {
            console.error("Error updating status:", error);
            showModal("Kesalahan", "Terjadi kesalahan pada server.");
        });
    }
});

</script>


</body>
</html>
