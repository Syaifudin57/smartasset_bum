-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Jul 2025 pada 05.22
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartasset_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cabang`
--

CREATE TABLE `cabang` (
  `id` int(11) NOT NULL,
  `nama_cabang` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cabang`
--

INSERT INTO `cabang` (`id`, `nama_cabang`) VALUES
(1, 'Cabang Magelang'),
(2, 'Cabang Semarang'),
(3, 'Cabang Yogyakarta');

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_pengajuan`
--

CREATE TABLE `daftar_pengajuan` (
  `id` int(11) NOT NULL,
  `id_pengajuan` varchar(50) DEFAULT NULL,
  `id_cabang` int(11) NOT NULL,
  `nomor_form` varchar(50) NOT NULL,
  `tanggal_form` date NOT NULL,
  `kode_aset` varchar(50) DEFAULT NULL,
  `nama_aset` varchar(100) NOT NULL,
  `quantity_aset` int(11) NOT NULL,
  `estimasi_harga` bigint(20) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status_kacab` enum('pending','approved','rejected') DEFAULT 'pending',
  `status_am` enum('pending','approved','rejected') DEFAULT 'pending',
  `status_ho` enum('pending','approved','rejected') DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `tanggal_dibuat` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'submitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_pengajuan`
--

INSERT INTO `daftar_pengajuan` (`id`, `id_pengajuan`, `id_cabang`, `nomor_form`, `tanggal_form`, `kode_aset`, `nama_aset`, `quantity_aset`, `estimasi_harga`, `keterangan`, `status_kacab`, `status_am`, `status_ho`, `catatan`, `tanggal_dibuat`, `status`) VALUES
(5, 'PGJ005', 2, 'FORM-2029', '2025-07-13', NULL, 'Meja kerja kayu', 10, 1500000, 'Pengganti meja lama', 'approved', 'approved', 'approved', NULL, '2025-07-14 13:41:44', 'submitted'),
(7, '23', 2, '2025/FRM/0015', '2024-05-03', 'AST-753', 'Aset Printer Laser', 2, 3600000, 'Keterangan pengajuan ke-15', 'approved', 'pending', 'pending', NULL, '2025-07-14 14:05:25', 'submitted'),
(9, '28', 3, 'FORM-2030', '2025-07-14', 'A001', 'Truk Fuso', 1, 300000000, 'Untuk mengantar barang', 'approved', 'pending', 'pending', NULL, '2025-07-14 14:06:40', 'submitted'),
(11, '29', 1, 'FORM-2031', '2025-07-14', 'A003', 'PC', 1, 15000000, 'PC Admin', 'pending', 'pending', 'pending', NULL, '2025-07-14 14:13:26', 'submitted'),
(13, '31', 0, '', '0000-00-00', NULL, '', 0, 0, NULL, 'pending', 'pending', 'pending', NULL, '2025-07-14 15:24:59', 'Submitted'),
(14, '32', 0, '', '0000-00-00', NULL, '', 0, 0, NULL, 'pending', 'pending', 'pending', NULL, '2025-07-14 15:35:51', 'Submitted'),
(15, '33', 0, '', '0000-00-00', NULL, '', 0, 0, NULL, 'approved', 'approved', 'approved', NULL, '2025-07-14 16:11:44', 'Submitted');

-- --------------------------------------------------------

--
-- Struktur dari tabel `input_pembelian`
--

CREATE TABLE `input_pembelian` (
  `id` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `no_pembelian` varchar(50) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `vendor` varchar(100) NOT NULL,
  `nilai_realisasi` int(11) NOT NULL,
  `bukti_nota` varchar(255) DEFAULT NULL,
  `foto_barang` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `input_pembelian`
--

INSERT INTO `input_pembelian` (`id`, `id_pengajuan`, `no_pembelian`, `tanggal_pembelian`, `vendor`, `nilai_realisasi`, `bukti_nota`, `foto_barang`, `created_at`) VALUES
(2, 4, '10/7/2025-1', '2025-07-10', 'Toko Gemilang', 500000, '1752133708_nota.jpg', '1752133708_barang.jpeg', '2025-07-10 07:48:28'),
(3, 30, '10/7/2025-2', '2025-07-15', 'Toko Jaya Komputer', 4000000, '1752478748_nota.jpg', '1752478748_barang.png', '2025-07-14 07:39:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `input_pengajuan`
--

CREATE TABLE `input_pengajuan` (
  `id` int(11) NOT NULL,
  `id_cabang` int(11) DEFAULT NULL,
  `nomor_form` varchar(50) DEFAULT NULL,
  `tanggal_form` date DEFAULT NULL,
  `kode_aset` varchar(50) DEFAULT NULL,
  `nama_aset` varchar(100) DEFAULT NULL,
  `quantity_aset` int(11) DEFAULT NULL,
  `estimasi_harga` decimal(15,2) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('draft','submitted','approved_kacab','approved_am','approved_ho','rejected') DEFAULT 'draft',
  `created_by` int(11) DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `status_pengajuan` enum('Draft','Submitted') DEFAULT 'Draft',
  `approval_kacab` enum('pending','approved','rejected') DEFAULT 'pending',
  `approval_am` enum('pending','approved','rejected') DEFAULT 'pending',
  `approval_ho` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `input_pengajuan`
--

INSERT INTO `input_pengajuan` (`id`, `id_cabang`, `nomor_form`, `tanggal_form`, `kode_aset`, `nama_aset`, `quantity_aset`, `estimasi_harga`, `keterangan`, `status`, `created_by`, `submitted_at`, `status_pengajuan`, `approval_kacab`, `approval_am`, `approval_ho`) VALUES
(4, 1, 'FORM-0001', '2025-07-09', 'A003', 'Kursi Staf', 2, 500000.00, 'untuk kursi kasir', 'submitted', NULL, '2025-07-12 21:44:38', 'Draft', 'approved', 'approved', 'approved'),
(5, 1, 'FORM-0002', '2025-07-08', 'A001', 'Jam dinding', 1, 200000.00, 'Jam lama rusak', 'submitted', NULL, '2025-07-09 20:33:34', 'Draft', 'approved', 'approved', 'pending'),
(6, 3, 'FORM-0003', '2025-07-08', 'A006', 'Tangga Teleskop', 2, 1500000.00, 'Untuk jasa instalasi', 'submitted', NULL, '2025-07-14 13:45:59', 'Draft', 'approved', 'approved', 'pending'),
(8, 1, 'FORM-0004', '2025-07-09', 'A003', 'Meja Kantor', 4, 1000000.00, 'meja staf', 'submitted', NULL, '2025-07-11 15:19:53', 'Draft', 'approved', 'approved', 'pending'),
(9, 2, '2025/FRM/0001', '2024-04-29', 'AST-993', 'Aset Meja', 4, 1030652.00, 'Keterangan pengajuan ke-1', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(10, 2, '2025/FRM/0002', '2024-01-07', 'AST-379', 'Aset Proyektor', 6, 7781282.00, 'Keterangan pengajuan ke-2', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(11, 1, '2025/FRM/0003', '2024-04-21', 'AST-206', 'Aset Proyektor', 7, 5928105.00, 'Keterangan pengajuan ke-3', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(12, 2, '2025/FRM/0004', '2024-04-17', 'AST-277', 'Aset Printer', 2, 2922343.00, 'Keterangan pengajuan ke-4', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(13, 1, '2025/FRM/0005', '2024-03-23', 'AST-834', 'Aset Meja', 6, 5471186.00, 'Keterangan pengajuan ke-5', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(14, 2, '2025/FRM/0006', '2024-08-02', 'AST-774', 'Aset Kursi', 6, 8808196.00, 'Keterangan pengajuan ke-6', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(15, 3, '2025/FRM/0007', '2024-05-31', 'AST-365', 'Aset Meja', 4, 7462030.00, 'Keterangan pengajuan ke-7', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(16, 2, '2025/FRM/0008', '2024-09-13', 'AST-455', 'Aset Meja', 7, 4628292.00, 'Keterangan pengajuan ke-8', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(17, 3, '2025/FRM/0009', '2024-11-22', 'AST-112', 'Aset Kamera', 3, 9870000.00, 'Keterangan pengajuan ke-9', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(18, 1, '2025/FRM/0010', '2024-06-15', 'AST-888', 'Aset Monitor', 5, 6500000.00, 'Keterangan pengajuan ke-10', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(19, 3, '2025/FRM/0011', '2024-12-01', 'AST-654', 'Aset Scanner', 2, 3400000.00, 'Keterangan pengajuan ke-11', 'submitted', NULL, '2025-07-14 13:46:06', 'Draft', 'approved', 'approved', 'pending'),
(20, 2, '2025/FRM/0012', '2024-07-25', 'AST-777', 'Aset Meja', 4, 7200000.00, 'Keterangan pengajuan ke-12', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(21, 1, '2025/FRM/0013', '2024-10-04', 'AST-321', 'Aset Rak Besi', 3, 5900000.00, 'Keterangan pengajuan ke-13', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(22, 3, '2025/FRM/0014', '2024-02-12', 'AST-159', 'Aset Meja Besar', 6, 8000000.00, 'Keterangan pengajuan ke-14', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(23, 2, '2025/FRM/0015', '2024-05-03', 'AST-753', 'Aset Printer Laser', 2, 3600000.00, 'Keterangan pengajuan ke-15', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(24, 3, 'FORM-2026', '2025-07-12', 'A006', 'Pesawat Telpon', 3, 3000000.00, 'Sekertariat', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(25, 1, 'FORM-2027', '2025-07-14', 'A006', 'Monitor', 5, 5000000.00, 'Monitor CCTV', 'submitted', NULL, '2025-07-14 13:43:45', 'Draft', 'approved', 'pending', 'pending'),
(26, 1, 'FORM-2028', '2025-07-14', 'A002', 'Scanner', 1, 2000000.00, 'alat scan dokumen', 'submitted', NULL, '2025-07-14 10:38:11', 'Draft', 'pending', 'pending', 'pending'),
(27, 1, 'FORM-2029', '2025-07-14', 'A003', 'Dispenser', 1, 500000.00, 'Dispenser air minum', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(28, 3, 'FORM-2030', '2025-07-14', 'A001', 'Truk Fuso', 1, 300000000.00, 'Untuk mengantar barang', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(29, 1, 'FORM-2031', '2025-07-14', 'A003', 'PC', 1, 15000000.00, 'PC Admin', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(30, 1, 'FORM-2032', '2025-07-14', 'A003', 'Monitor', 4, 4000000.00, 'Monitor cctv baru', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(31, 1, 'FORM-2033', '2025-07-14', 'A001', 'Meja Etalase', 1, 2000000.00, 'Etalase baru', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(32, 2, 'FORM-2034', '2025-07-14', 'A002', 'Laptop HP', 1, 15000000.00, 'Administrasi', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending'),
(33, 1, 'FORM-2035', '2025-07-13', 'A003', 'AC', 1, 3000000.00, 'Ac baru', 'draft', NULL, NULL, 'Draft', 'pending', 'pending', 'pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `jenis_laporan` enum('bulanan','tahunan') DEFAULT NULL,
  `periode` date DEFAULT NULL,
  `id_pengajuan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `role` enum('admin','admin_pusat','kepala_cabang','area_manager','super_admin') NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `foto` varchar(100) DEFAULT 'default.png',
  `email` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_expired` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `role`, `is_active`, `foto`, `email`, `photo`, `reset_token`, `reset_expired`) VALUES
(1, 'admin', '$2y$10$ECqSbK6hBeYZoTeVnOZdLua30V79243kWo4Z0JOEqjczS9.XvKgE6', 'Administrator Utama', 'admin', 1, 'default.png', 'syaifudin1878@gmail.com', 'profile_1752304629.png', NULL, NULL),
(2, 'ho', '$2y$10$s.laVrFYj1tWy0/nlh2dMODUuLBi7DjwXc8aHsHJTE9lmYemieJGS', 'Head Office', 'admin_pusat', 1, 'default.png', NULL, NULL, NULL, NULL),
(3, 'kacab1', '$2y$10$XdrkqGZNYxjphPkxMm7FA.EEBnL16xmJ5rMle5CBu/OEp27kv0Hc.', 'Kepala Cabang Magelang', 'kepala_cabang', 1, 'default.png', NULL, NULL, NULL, NULL),
(5, 'manager', '$2y$10$4T1upHbaStdo/qUn5XOJeuQjIRaoydUziCNlAs1uPmMRjANVXIJ92', 'Manager Area', 'area_manager', 1, 'default.png', 'setiya.nugroho@unimma.ac.id', 'profile_1752318797.png', NULL, NULL),
(8, 'kacab', '$2y$10$iPHFCZc045ivcI.nP4UeC.VTlWy4A3J7t0FP9GELpOivRMZaF2M6C', 'Kepala Cabang Semarang', 'kepala_cabang', 1, 'default.png', NULL, NULL, NULL, NULL),
(10, '2405040074', '$2y$10$sQQn7uyIu5Gj0hLTz4p1Lei8e.MUXBkvZvSSyAPTiIK3D/pwvPZ4a', 'Syaifudin', 'admin', 1, 'default.png', 'syaifudin1878@gmail.com', NULL, NULL, NULL),
(12, 'superadmin', '$2y$10$7UbNYvAkHB4XexByRDcjROcqoeK49R5WtDeUJj/4FPf9BIQEHZcxW', 'Super Administrator', 'super_admin', 1, 'default.png', 'superadmin@example.com', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `verifikasi_pengajuan`
--

CREATE TABLE `verifikasi_pengajuan` (
  `id` int(11) NOT NULL,
  `id_pengajuan` int(11) DEFAULT NULL,
  `id_cabang` int(11) DEFAULT NULL,
  `nomor_form` varchar(50) DEFAULT NULL,
  `tanggal_form` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `action` enum('disetujui','ditolak','pending') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cabang`
--
ALTER TABLE `cabang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `daftar_pengajuan`
--
ALTER TABLE `daftar_pengajuan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `input_pembelian`
--
ALTER TABLE `input_pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengajuan` (`id_pengajuan`);

--
-- Indeks untuk tabel `input_pengajuan`
--
ALTER TABLE `input_pengajuan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_ibfk_1` (`id_pengajuan`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `verifikasi_pengajuan`
--
ALTER TABLE `verifikasi_pengajuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengajuan` (`id_pengajuan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cabang`
--
ALTER TABLE `cabang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `daftar_pengajuan`
--
ALTER TABLE `daftar_pengajuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `input_pembelian`
--
ALTER TABLE `input_pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `input_pengajuan`
--
ALTER TABLE `input_pengajuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `verifikasi_pengajuan`
--
ALTER TABLE `verifikasi_pengajuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `input_pembelian`
--
ALTER TABLE `input_pembelian`
  ADD CONSTRAINT `input_pembelian_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `input_pengajuan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `input_pengajuan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `verifikasi_pengajuan`
--
ALTER TABLE `verifikasi_pengajuan`
  ADD CONSTRAINT `verifikasi_pengajuan_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `input_pengajuan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
