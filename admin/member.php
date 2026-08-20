<?php
session_start();
if ($_SESSION['status'] != "login" || $_SESSION['role'] != "admin") {
    header("location:../login.php"); exit();
}
include '../koneksi.php';

$members = mysqli_query($koneksi, "SELECT * FROM users WHERE role='member' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Member</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-body">

    <div class="admin-sidebar">
        <div class="logo"><i class="fas fa-book-open" style="color: #fbbf24;"></i> Admin</div>
        <ul class="admin-menu">
            <li><a href="index.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="kelola_buku.php"><i class="fas fa-book"></i> Data Buku</a></li>
            <li><a href="kategori.php"><i class="fas fa-shapes"></i> Kategori</a></li>
            <li><a href="member.php" class="active"><i class="fas fa-users"></i> Member</a></li> <li><a href="transaksi.php"><i class="fas fa-exchange-alt"></i> Transaksi</a></li>
            <li><a href="laporan.php" target="_blank"><i class="fas fa-print"></i> Laporan</a></li>
        </ul>
        <div class="storage-info">
           <a href="../logout.php" style="color: tomato; text-decoration: none;">Logout</a>
        </div>
    </div>

    <div class="admin-main">
        
        <div class="admin-header">
            <h2 style="color: white;">Data Siswa</h2>
            <a href="tambah_member.php" class="btn-login" style="background: #3b82f6; color: white; font-weight: bold; padding: 10px 20px; border-radius: 20px;">
                <i class="fas fa-user-plus"></i> Register Siswa
            </a>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($members)): ?>
                <tr>
                    <td style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 35px; height: 35px; background: #334155; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fbbf24;">
                            <i class="fas fa-user"></i>
                        </div>
                        <?= $row['full_name']; ?>
                    </td>
                    <td style="color: #94a3b8;">@<?= $row['username']; ?></td>
                    <td style="color: #94a3b8;"><?= $row['email']; ?></td>
                    <td><?= $row['phone_number']; ?></td>
                    <td>
                        <a href="edit_member.php?id=<?= $row['id']; ?>" style="color: #3b82f6; margin-right: 15px;">
                            <i class="fas fa-pen"></i>
                        </a>
                        <a href="hapus_member.php?id=<?= $row['id']; ?>" style="color: tomato;" onclick="return confirm('Hapus siswa ini?');">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</body>
</html>