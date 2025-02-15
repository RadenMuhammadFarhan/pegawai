<?php
include 'config.php';

// Ambil data pegawai dari database
$result = mysqli_query($conn, "SELECT (@row_number := @row_number + 1) AS id_urut, p.* 
                               FROM pegawai p, (SELECT @row_number := 0) AS temp");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #343a40;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
        }
        
        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            white-space: nowrap;
        }

        .table th {
            background: #343a40;
            color: white;
        }

        .table-responsive {
            width: 100%;
            display: block;
            overflow-x: auto;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
    </style>
</head>
<body class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Menu</h4>
        <a href="dashboard.php">🏠 Kembali ke Dashboard</a>
        <a href="pegawai.php">👥 Data Pegawai</a>
        <a href="gaji.php">👥 Gaji</a>
    </div>

    <!-- Konten Halaman -->
    <div class="content">
        <h2 class="mb-4">Data Pegawai</h2>

        <!-- Filter Show Entries & Search -->
        <div class="d-flex justify-content-between mb-3">
            <div>
                <label>Show 
                    <select id="showEntries" class="form-select d-inline-block w-auto">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select> entries
                </label>
            </div>
            <input type="text" id="searchBox" class="form-control w-25" placeholder="Cari Pegawai...">
        </div>

        <!-- Tombol Tambah Pegawai -->
        <a href="tambah_pegawai.php" class="btn btn-success mb-3">+ Tambah Pegawai</a>


        <!-- Tabel Pegawai -->
        <div class="table-container">
            <table class="table table-striped" id="pegawaiTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Nomor HP</th>
                        <th>Email</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['id_urut']}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['jenis_kelamin']}</td>
                                <td>{$row['alamat']}</td>
                                <td>{$row['nomor_hp']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['jabatan']}</td>
                                <td>{$row['status']}</td>
                                <td>
                                    <a href='edit_pegawai.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <button onclick='confirmDelete({$row['id']})' class='btn btn-danger btn-sm'>Hapus</button>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // SEARCH FUNCTION
        document.getElementById("searchBox").addEventListener("keyup", function() {
            let input = this.value.toLowerCase();
            let rows = document.querySelectorAll("#pegawaiTable tbody tr");

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(input) ? "" : "none";
            });
        });

        // SHOW ENTRIES FUNCTION
        document.getElementById("showEntries").addEventListener("change", function() {
            let selectedValue = parseInt(this.value);
            let rows = document.querySelectorAll("#pegawaiTable tbody tr");

            rows.forEach((row, index) => {
                row.style.display = index < selectedValue ? "" : "none";
            });
        });

        // CONFIRM DELETE
        function confirmDelete(id) {
            if (confirm("Apakah Anda yakin ingin menghapus pegawai ini?")) {
                fetch(`hapus_pegawai.php?id=${id}`)
                    .then(response => response.text())
                    .then(data => {
                        alert("Data pegawai telah dihapus!");
                        location.reload();
                    })
                    .catch(error => console.error("Terjadi kesalahan:", error));
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
