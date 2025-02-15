<?php
include 'config.php';


// Proses tambah/edit gaji
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $id_pegawai = $_POST['id_pegawai'];
    $gaji_pokok = $_POST['gaji_pokok'];
    $tunjangan = $_POST['tunjangan'];
    $potongan = $_POST['potongan'];
    $gaji_bersih = $gaji_pokok + $tunjangan - $potongan;

    if ($id) {
        // Edit gaji
        $query = "UPDATE gaji SET gaji_pokok='$gaji_pokok', tunjangan='$tunjangan', potongan='$potongan', gaji_bersih='$gaji_bersih' WHERE id='$id'";
    } else {
        // Tambah gaji baru
        $query = "INSERT INTO gaji (id_pegawai, gaji_pokok, tunjangan, potongan, gaji_bersih) VALUES ('$id_pegawai', '$gaji_pokok', '$tunjangan', '$potongan', '$gaji_bersih')";
    }
    mysqli_query($conn, $query);
    header("Location: gaji.php");
    exit();
}

// Proses hapus gaji
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM gaji WHERE id='$id'");
    header("Location: gaji.php");
    exit();
}

// Ambil data pegawai dan gaji
$pegawai = mysqli_query($conn, "SELECT * FROM pegawai");
$query = "SELECT g.id, p.nama, p.jabatan, p.status, g.gaji_pokok, g.tunjangan, g.potongan, 
                 (g.gaji_pokok + g.tunjangan - g.potongan) AS gaji_bersih
          FROM pegawai p
          LEFT JOIN gaji g ON p.id = g.id_pegawai";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Gaji Pegawai</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="d-flex">
        <div class="sidebar bg-dark text-white p-3" style="width: 250px; height: 100vh;">
            <h4>Menu</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link text-white" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="pegawai.php">Data Pegawai</a></li>
                <li class="nav-item"><a class="nav-link text-white active" href="gaji.php">Data Gaji</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="container mt-4">
            <h2 class="mb-4">Data Gaji Pegawai</h2>
            
            <!-- Form Tambah/Edit Gaji -->
            <div class="card mb-4">
                <div class="card-header">Tambah/Edit Gaji</div>
                <div class="card-body">
                    <form method="POST" action="gaji.php">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label>Pegawai</label>
                            <select name="id_pegawai" class="form-control">
                                <?php while ($p = mysqli_fetch_assoc($pegawai)) { ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3"><label>Gaji Pokok</label><input type="number" name="gaji_pokok" class="form-control"></div>
                        <div class="mb-3"><label>Tunjangan</label><input type="number" name="tunjangan" class="form-control"></div>
                        <div class="mb-3"><label>Potongan</label><input type="number" name="potongan" class="form-control"></div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan</th>
                            <th>Potongan</th>
                            <th>Gaji Akhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['jabatan']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>Rp <?php echo number_format($row['gaji_pokok'], 0, ',', '.'); ?></td>
                            <td>Rp <?php echo number_format($row['tunjangan'], 0, ',', '.'); ?></td>
                            <td>Rp <?php echo number_format($row['potongan'], 0, ',', '.'); ?></td>
                            <td>Rp <?php echo number_format($row['gaji_bersih'], 0, ',', '.'); ?></td>
                            <td>
                                <a href="gaji.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="gaji.php?hapus=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus?');">Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>