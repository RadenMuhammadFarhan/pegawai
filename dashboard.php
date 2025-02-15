<?php
include 'config.php';

// Ambil jumlah pegawai berdasarkan status
$status_result = mysqli_query($conn, "SELECT status, COUNT(*) as jumlah FROM pegawai GROUP BY status");
$status_data = [];
while ($row = mysqli_fetch_assoc($status_result)) {
    $status_data[$row['status']] = $row['jumlah'];
}

// Ambil jumlah pegawai berdasarkan jabatan
$jabatan_result = mysqli_query($conn, "SELECT jabatan, COUNT(*) as jumlah FROM pegawai GROUP BY jabatan");
$jabatan_data = [];
while ($row = mysqli_fetch_assoc($jabatan_result)) {
    $jabatan_data[$row['jabatan']] = $row['jumlah'];
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white p-3 vh-100" style="width: 250px;">
            <h4>Menu</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="dashboard.php" class="nav-link text-white">🏠 Dashboard</a></li>
                <li class="nav-item"><a href="pegawai.php" class="nav-link text-white">👥 Data Pegawai</a></li>
                <li class="nav-item"><a href="gaji.php" class="nav-link text-white">👥 Data Gaji</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link text-white">Logout</a></li>
            </ul>
        </div>

        <!-- Konten Dashboard -->
        <div class="container mt-4">
            <h2>Dashboard</h2>
            
            <!-- Statistik Pegawai -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow p-3">
                        <h5 class="text-center">Pegawai Berdasarkan Status</h5>
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow p-3">
                        <h5 class="text-center">Pegawai Berdasarkan Jabatan</h5>
                        <canvas id="jabatanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data Status Pegawai
        var statusData = {
            labels: ["Aktif", "Tidak Aktif", "Magang"],
            datasets: [{
                label: "Jumlah Pegawai",
                data: [
                    <?= $status_data['aktif'] ?? 0; ?>,
                    <?= $status_data['tidak aktif'] ?? 0; ?>,
                    <?= $status_data['magang'] ?? 0; ?>
                ],
                backgroundColor: ["#4CAF50", "#FF5733", "#FFC107"]
            }]
        };

        // Grafik Status Pegawai
        new Chart(document.getElementById("statusChart"), {
            type: "pie",
            data: statusData
        });

        // Data Jabatan Pegawai
        var jabatanData = {
            labels: ["Programmer", "Designer", "Manager"],
            datasets: [{
                label: "Jumlah Pegawai",
                data: [
                    <?= $jabatan_data['Programmer'] ?? 0; ?>,
                    <?= $jabatan_data['Designer'] ?? 0; ?>,
                    <?= $jabatan_data['Manager'] ?? 0; ?>
                ],
                backgroundColor: ["#007BFF", "#E91E63", "#28A745"]
            }]
        };

        // Grafik Jabatan Pegawai
        new Chart(document.getElementById("jabatanChart"), {
            type: "bar",
            data: jabatanData
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
