<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jenis_kelamin= mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $nomor_hp = mysqli_real_escape_string($conn, $_POST['nomor_hp']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Panggil Stored Procedure
    $sql = "CALL TambahPegawai('$nama','$jenis_kelamin','$alamat', '$nomor_hp', '$email', '$jabatan', '$status', @hasil)";
    if (mysqli_query($conn, $sql)) {
        // Ambil hasil output dari Stored Procedure
        $result = mysqli_query($conn, "SELECT @hasil AS hasil");
        
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $pesan = $row['hasil'];

            echo "<script>alert('$pesan'); window.location='pegawai.php';</script>";
        } else {
            echo "<script>alert('Gagal mengambil hasil dari Stored Procedure');</script>";
        }
    } else {
        echo "<script>alert('Gagal menjalankan Stored Procedure: " . mysqli_error($conn) . "');</script>";
    }

    // Ambil hasil output dari Stored Procedure
    $result = mysqli_query($conn, "SELECT @hasil AS hasil");
    $row = mysqli_fetch_assoc($result);
    $pesan = $row['hasil'];

    // Periksa apakah email sudah ada di database
    $cek_email = mysqli_query($conn, "SELECT * FROM pegawai WHERE email = '$email'");
    
    if (!$cek_email) {
        die("Query Error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($cek_email) > 0) {
        echo "<script>alert('Email sudah digunakan! Gunakan email lain.'); window.history.back();</script>";
        exit();
    }

    // Jika email belum ada, masukkan data ke database
    $query = "INSERT INTO pegawai (nama, jenis_kelamin, alamat, nomor_hp, email, jabatan, status) 
          VALUES ('$nama', '$jenis_kelamin', '$alamat', '$nomor_hp', '$email', '$jabatan', '$status')";


    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pegawai berhasil ditambahkan!'); window.location='pegawai.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan pegawai: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card p-4 shadow-lg">
        <h2 class="text-center mb-4">Tambah Pegawai</h2>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
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
                <input type="text" name="nomor_hp" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <select name="jabatan" class="form-select">
                    <option value="Programmer">Programmer</option>
                    <option value="Designer">Designer</option>
                    <option value="Manager">Manager</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif">Aktif</option>
                    <option value="tidak aktif">Tidak Aktif</option>
                    <option value="magang">Magang</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Tambah</button>
        </form>
        <a href="pegawai.php" class="btn btn-secondary w-100 mt-3">Kembali</a>
    </div>
</body>
</html>
