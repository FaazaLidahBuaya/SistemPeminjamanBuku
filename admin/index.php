<?php
session_start();
if ($_SESSION['status'] != "login" || $_SESSION['role'] != "admin") {
    header("location:../login.php?pesan=belum_login");
    exit();
}
include '../koneksi.php';

// Data Statistik
$count_buku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM books"))['total'];
$count_pinjam = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM loans WHERE status='borrowed'"))['total'];
$count_member = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users WHERE role='member'"))['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-body">

    <div class="admin-sidebar">
        <div class="logo">
            <i class="fas fa-book-open" style="color: #fbbf24;"></i> Admin
        </div>
        <ul class="admin-menu">
            <li><a href="index.php" class="active"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="kelola_buku.php"><i class="fas fa-book"></i> Data Buku</a></li>
            <li><a href="kategori.php"><i class="fas fa-shapes"></i> Kategori</a></li>
            <li><a href="member.php"><i class="fas fa-users"></i> Member</a></li>
            <li><a href="transaksi.php"><i class="fas fa-exchange-alt"></i> Transaksi</a></li>
            <li><a href="laporan.php" target="_blank"><i class="fas fa-print"></i> Laporan</a></li>
        </ul>

        <div class="storage-info">
           <a href="../logout.php" style="color: tomato; text-decoration: none;">Logout</a>
        </div>
    </div>

    <div class="admin-main">
        
        <div class="admin-header" style="margin-bottom: 30px;">
            <h2 style="color: white;">Dashboard Overview</h2>
        </div>

        <h4 style="color: #94a3b8; margin-bottom: 20px; text-transform: uppercase; font-size: 12px;">Common Information</h4>
        <div class="quick-access-grid">
            
            <div class="folder-card">
                <div class="folder-header">
                    <div class="folder-icon"><i class="fas fa-book"></i></div>
                    <i class="fas fa-ellipsis-h" style="color: #555;"></i>
                </div>
                <div class="folder-title">Total Koleksi</div>
                <div class="folder-stat"><?= $count_buku; ?> Buku</div>
            </div>

            <div class="folder-card">
                <div class="folder-header">
                    <div class="folder-icon" style="color: #3b82f6; background: rgba(59, 130, 246, 0.1);"><i class="fas fa-hand-holding"></i></div>
                    <i class="fas fa-ellipsis-h" style="color: #555;"></i>
                </div>
                <div class="folder-title">Sedang Dipinjam</div>
                <div class="folder-stat"><?= $count_pinjam; ?> Transaksi</div>
            </div>

            <div class="folder-card">
                <div class="folder-header">
                    <div class="folder-icon" style="color: #10b981; background: rgba(16, 185, 129, 0.1);"><i class="fas fa-users"></i></div>
                    <i class="fas fa-ellipsis-h" style="color: #555;"></i>
                </div>
                <div class="folder-title">Member Aktif</div>
                <div class="folder-stat"><?= $count_member; ?> Siswa</div>
            </div>

        </div>

        <h4 style="color: #94a3b8; margin-bottom: 20px; text-transform: uppercase; font-size: 12px;">Buku Terbaru Ditambahkan</h4>
        
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $recent = mysqli_query($koneksi, "SELECT * FROM books ORDER BY id DESC LIMIT 5");
                while($b = mysqli_fetch_assoc($recent)):
                ?>
                <tr>
                    <td style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 30px; height: 30px; background: #fbbf24; border-radius: 5px; display: flex; align-items: center; justify-content: center; color: #16202c;">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <?= $b['title']; ?>
                    </td>
                    <td style="color: #94a3b8;"><?= $b['author']; ?></td>
                    <td style="color: #94a3b8;"><?= $b['publication_year']; ?></td>
                    <td><?= $b['stock']; ?></td>
                    <td>
                        <?php if($b['stock'] > 0): ?>
                            <span style="color: #10b981; font-size: 13px;"><i class="fas fa-check-circle"></i> Ready</span>
                        <?php else: ?>
                            <span style="color: tomato; font-size: 13px;"><i class="fas fa-times-circle"></i> Habis</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>

</body>
</html>