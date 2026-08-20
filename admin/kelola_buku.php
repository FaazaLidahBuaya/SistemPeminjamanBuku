<?php
session_start();
if($_SESSION['status'] != "login" || $_SESSION['role'] != "admin"){
    header("location:../login.php"); exit();
}
include '../koneksi.php';
$books = mysqli_query($koneksi, "SELECT * FROM books ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Buku</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-body">

    <div class="admin-sidebar">
        <div class="logo"><i class="fas fa-book-open" style="color: #fbbf24;"></i> Admin</div>
        <ul class="admin-menu">
            <li><a href="index.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="kelola_buku.php" class="active"><i class="fas fa-book"></i> Data Buku</a></li> <li><a href="kategori.php"><i class="fas fa-shapes"></i> Kategori</a></li>
            <li><a href="member.php"><i class="fas fa-users"></i> Member</a></li>
            <li><a href="transaksi.php"><i class="fas fa-exchange-alt"></i> Transaksi</a></li>
            <li><a href="laporan.php" target="_blank"><i class="fas fa-print"></i> Laporan</a></li>
        </ul>
        <div class="storage-info">
           <a href="../logout.php" style="color: tomato; text-decoration: none;">Logout</a>
        </div>
    </div>

    <div class="admin-main">
        
        <div class="admin-header">
            <h2 style="color: white;">Data Buku</h2>
            <a href="tambah_buku.php" class="btn-login" style="background: #fbbf24; color: #16202c; font-weight: bold; padding: 10px 20px; border-radius: 20px;">
                <i class="fas fa-plus"></i> Upload New Book
            </a>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Stok</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($books)) : ?>
                <tr>
                    <td>
                        <?php if($row['cover_image']): ?>
                            <img src="../assets/<?= $row['cover_image']; ?>" style="width: 40px; height: 50px; object-fit: cover; border-radius: 5px;">
                        <?php else: ?>
                            <div style="width: 40px; height: 50px; background: #333; border-radius: 5px;"></div>
                        <?php endif; ?>
                    </td>
                    <td style="font-weight: bold;"><?= $row['title']; ?></td>
                    <td style="color: #94a3b8;"><?= $row['author']; ?></td>
                    <td><?= $row['stock']; ?></td>
                    <td>
                        <a href="edit_buku.php?id=<?= $row['id']; ?>" style="color: #fbbf24; margin-right: 10px;"><i class="fas fa-pen"></i></a>
                        <a href="hapus_buku.php?id=<?= $row['id']; ?>" style="color: tomato;" onclick="return confirm('Hapus?');"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</body>
</html>