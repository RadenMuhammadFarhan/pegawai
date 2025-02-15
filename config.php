<?php
$host = "localhost";
$user = "root"; // Sesuaikan dengan database Anda
$pass = ""; // Jika ada password, isi di sini
$db = "kepegawaian"; // Nama database Anda

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
