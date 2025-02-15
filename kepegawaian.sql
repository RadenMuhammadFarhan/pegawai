-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2025 at 11:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kepegawaian`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `TambahPegawai` (IN `p_nama` VARCHAR(255), IN `p_nomor_hp` VARCHAR(20), IN `p_email` VARCHAR(255), IN `p_jabatan` VARCHAR(100), IN `p_status` ENUM('aktif','tidak aktif','magang'), OUT `p_hasil` VARCHAR(255))   BEGIN
    DECLARE email_count INT;
    
    -- Cek apakah email sudah ada
    SELECT COUNT(*) INTO email_count FROM pegawai WHERE email = p_email;

    IF email_count > 0 THEN
        SET p_hasil = 'Email sudah digunakan!';
    ELSE
        -- Jika belum ada, tambahkan pegawai baru
        INSERT INTO pegawai (nama, nomor_hp, email, jabatan, status)
        VALUES (p_nama, p_nomor_hp, p_email, p_jabatan, p_status);
        
        SET p_hasil = 'Pegawai berhasil ditambahkan!';
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `gaji`
--

CREATE TABLE `gaji` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `gaji_pokok` decimal(10,2) NOT NULL,
  `tunjangan` decimal(10,2) NOT NULL,
  `potongan` decimal(10,2) NOT NULL,
  `gaji_bersih` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_pegawai`
--

CREATE TABLE `log_pegawai` (
  `id` int(11) NOT NULL,
  `pegawai_id` int(11) DEFAULT NULL,
  `aksi` varchar(50) DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_pegawai`
--

INSERT INTO `log_pegawai` (`id`, `pegawai_id`, `aksi`, `waktu`) VALUES
(4, 1, 'Pegawai Ditambahkan', '2025-02-13 16:24:36'),
(5, 2, 'Pegawai Ditambahkan', '2025-02-13 16:25:17'),
(6, 3, 'Pegawai Ditambahkan', '2025-02-13 16:25:53'),
(7, 4, 'Pegawai Ditambahkan', '2025-02-15 05:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nomor_hp` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `status` enum('aktif','tidak aktif','magang') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nama`, `jenis_kelamin`, `alamat`, `nomor_hp`, `email`, `jabatan`, `status`) VALUES
(1, 'Farhan', 'Laki-laki', 'Antapani no 5 Bandung', '08212223232', 'Farhan@gmail.com', 'Programmer', 'tidak aktif'),
(2, 'Andrew', 'Laki-laki', 'Jl. Dipatiukur No 5 Bandung', '08123213141', 'andrew@gmail.com', 'Manager', 'aktif'),
(3, 'Tate', 'Perempuan', 'Jl. Buah Batu No. 21 Bandung', '08424927421', 'Tate@gmail.com', 'Designer', 'magang'),
(4, 'Ayu', 'Laki-laki', 'Jl. Dago Pakar No 30 Bandung', '088246242321', 'ayu@gmail.com', 'Designer', 'tidak aktif');

--
-- Triggers `pegawai`
--
DELIMITER $$
CREATE TRIGGER `After_Insert_Pegawai` AFTER INSERT ON `pegawai` FOR EACH ROW BEGIN
    INSERT INTO log_pegawai (pegawai_id, aksi) 
    VALUES (NEW.id, 'Pegawai Ditambahkan');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(2, 'admin', '0192023a7bbd73250516f069df18b500', 'admin'),
(3, '', '$2y$10$KO.IJv87n3cOUgNTwQ8sueBkzd.TgiN6FUvxqKaVil0MIJsjEfKn2', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gaji`
--
ALTER TABLE `gaji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `log_pegawai`
--
ALTER TABLE `log_pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gaji`
--
ALTER TABLE `gaji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `log_pegawai`
--
ALTER TABLE `log_pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gaji`
--
ALTER TABLE `gaji`
  ADD CONSTRAINT `gaji_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
