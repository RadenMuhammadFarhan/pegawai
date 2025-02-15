<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM pegawai WHERE id='$id'");
    $pegawai = mysqli_fetch_assoc($result);
    
    if (!$pegawai) {
        echo "<p class='alert alert-danger'>Data pegawai tidak ditemukan.</p>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $nomor_hp = $_POST['nomor_hp'];
    $email = $_POST['email'];
    $jabatan = $_POST['jabatan'];
    $status = $_POST['status'];

    
    mysqli_query($conn, "UPDATE pegawai SET nama='$nama', jenis_kelamin='$jenis_kelamin', alamat='$alamat', nomor_hp='$nomor_hp', email='$email', jabatan='$jabatan', status='$status' WHERE id='$id'");
    header("Location: pegawai.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card p-4 shadow-lg">
        <h2 class="text-center mb-4">Edit Pegawai</h2>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($pegawai['nama']); ?>" required>
            </div>
            <div class="mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor HP</label>
                <input type="text" name="nomor_hp" class="form-control" value="<?php echo htmlspecialchars($pegawai['nomor_hp']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($pegawai['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <select name="jabatan" class="form-select">
                    <option value="Programmer" <?php if($pegawai['jabatan'] == 'Programmer') echo 'selected'; ?>>Programmer</option>
                    <option value="Designer" <?php if($pegawai['jabatan'] == 'Designer') echo 'selected'; ?>>Designer</option>
                    <option value="Manager" <?php if($pegawai['jabatan'] == 'Manager') echo 'selected'; ?>>Manager</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif" <?php if($pegawai['status'] == 'aktif') echo 'selected'; ?>>Aktif</option>
                    <option value="tidak aktif" <?php if($pegawai['status'] == 'tidak aktif') echo 'selected'; ?>>Tidak Aktif</option>
                    <option value="magang" <?php if($pegawai['status'] == 'magang') echo 'selected'; ?>>Magang</option>
                </select>
            </div>
            <button type="submit" name="update" class="btn btn-primary w-100">Update</button>
        </form>
        <a href="pegawai.php" class="btn btn-secondary w-100 mt-3">Kembali</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
