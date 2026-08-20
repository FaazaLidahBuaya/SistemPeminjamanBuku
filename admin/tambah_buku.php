<?php
session_start();
if ($_SESSION['status'] != "login" || $_SESSION['role'] != "admin") {
    header("location:../login.php?pesan=belum_login"); exit();
}
include '../koneksi.php';
$categories = mysqli_query($koneksi, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-body">

    <div class="admin-sidebar">
        <div class="logo"><i class="fas fa-book-open" style="color: #fbbf24;"></i> Admin</div>
        <ul class="admin-menu">
            <li><a href="index.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="kelola_buku.php" class="active"><i class="fas fa-book"></i> Data Buku</a></li>
            <li><a href="kategori.php"><i class="fas fa-shapes"></i> Kategori</a></li>
            <li><a href="member.php"><i class="fas fa-users"></i> Member</a></li>
            <li><a href="transaksi.php"><i class="fas fa-exchange-alt"></i> Transaksi</a></li>
            <li><a href="laporan.php" target="_blank"><i class="fas fa-print"></i> Laporan</a></li>
        </ul>
    </div>

    <div class="admin-main">
        <h2 style="color: white; margin-bottom: 20px;">Upload Buku Baru</h2>

        <div class="form-card">
            <form action="proses_tambah.php" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="title" class="custom-input" placeholder="Masukkan judul..." required>
                </div>

                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="author" class="custom-input" required>
                </div>

                <div class="form-group">
                    <label>Penerbit</label>
                    <input type="text" name="publisher" class="custom-input">
                </div>

                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="date" name="publication_year" class="custom-input" style="color-scheme: dark;" required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category_id" class="custom-input">
                        <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                            <option value="<?= $cat['id']; ?>"><?= $cat['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Stok Awal</label>
                    <input type="number" name="stock" class="custom-input" required>
                </div>

                <div class="form-group">
                    <label>Cover Image</label>
                    <input type="file" name="cover_image" class="custom-input" style="padding: 10px;">
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn-login" style="background: #fbbf24; color: #16202c; font-weight: bold; border: none; cursor: pointer; padding: 12px 25px; border-radius: 10px;">Simpan Buku</button>
                    <a href="kelola_buku.php" style="color: #94a3b8; text-decoration: none; margin-left: 20px;">Batal</a>
                </div>

            </form>
        </div>
    </div>
</body>
</html>