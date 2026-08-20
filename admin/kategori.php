<?php
session_start();
if($_SESSION['status'] != "login" || $_SESSION['role'] != "admin"){
    header("location:../login.php"); exit();
}
include '../koneksi.php';

// Ambil data kategori + Hitung jumlah buku
$query = mysqli_query($koneksi, "SELECT categories.*, COUNT(books.id) as total_buku 
                                 FROM categories 
                                 LEFT JOIN books ON categories.id = books.category_id 
                                 GROUP BY categories.id 
                                 ORDER BY categories.id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kategori</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-body">

    <div class="admin-sidebar">
        <div class="logo"><i class="fas fa-book-open" style="color: #fbbf24;"></i> Admin</div>
        <ul class="admin-menu">
            <li><a href="index.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="kelola_buku.php"><i class="fas fa-book"></i> Data Buku</a></li>
            <li><a href="kategori.php" class="active"><i class="fas fa-shapes"></i> Kategori</a></li> <li><a href="member.php"><i class="fas fa-users"></i> Member</a></li>
            <li><a href="transaksi.php"><i class="fas fa-exchange-alt"></i> Transaksi</a></li>
            <li><a href="laporan.php" target="_blank"><i class="fas fa-print"></i> Laporan</a></li>
        </ul>
        <div class="storage-info">
           <a href="../logout.php" style="color: tomato; text-decoration: none;">Logout</a>
        </div>
    </div>

    <div class="admin-main">
        
        <div class="admin-header">
            <h2 style="color: white;">Kategori Buku</h2>
            <a href="tambah_kategori.php" class="btn-login" style="background: #fbbf24; color: #16202c; font-weight: bold; padding: 10px 20px; border-radius: 20px;">
                <i class="fas fa-plus"></i> Kategori Baru
            </a>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Koleksi</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($row = mysqli_fetch_assoc($query)) : 
                ?>
                <tr>
                    <td style="color: #94a3b8;"><?= $no++; ?></td>
                    <td style="font-weight: bold; color: #fbbf24; font-size: 16px;">
                        <i class="fas fa-folder" style="margin-right: 10px; color: #fbbf24;"></i>
                        <?= $row['name']; ?>
                    </td>
                    <td>
                        <span style="background: rgba(251, 191, 36, 0.1); color: #fbbf24; padding: 5px 12px; border-radius: 15px; font-size: 12px;">
                            <?= $row['total_buku']; ?> Judul
                        </span>
                    </td>
                    <td>
                        <a href="edit_kategori.php?id=<?= $row['id']; ?>" style="color: #3b82f6; margin-right: 15px;"><i class="fas fa-pen"></i></a>
                        <a href="hapus_kategori.php?id=<?= $row['id']; ?>" style="color: tomato;" onclick="return confirm('Hapus kategori ini?');"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</body>
</html>