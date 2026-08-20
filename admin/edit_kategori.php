<?php
session_start();
if($_SESSION['role'] != "admin"){ header("location:../login.php"); exit(); }
include '../koneksi.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM categories WHERE id='$id'"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Kategori</title>
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
    </div>

    <div class="admin-main">
        <h2 style="color: white; margin-bottom: 20px;">Edit Nama Kategori</h2>

        <div class="form-card">
            <form action="proses_edit_kategori.php" method="post">
                <input type="hidden" name="id" value="<?= $data['id']; ?>">

                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" class="custom-input" value="<?= $data['name']; ?>" required>
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn-login" style="background: #3b82f6; color: white; font-weight: bold; border: none; cursor: pointer; padding: 12px 25px; border-radius: 10px;">Update</button>
                    <a href="kategori.php" style="color: #94a3b8; text-decoration: none; margin-left: 20px;">Batal</a>
                </div>

            </form>
        </div>
    </div>
</body>
</html>