<?php
session_start();
// Cek Login & Role Admin
if($_SESSION['status'] != "login" || $_SESSION['role'] != "admin"){
    header("location:../login.php?pesan=belum_login");
    exit();
}

include '../koneksi.php';

// Ambil data User (Hanya yang role-nya member)
$users = mysqli_query($koneksi, "SELECT * FROM users WHERE role='member' ORDER BY full_name ASC");

// Ambil data Buku (Hanya yang stoknya ada)
$books = mysqli_query($koneksi, "SELECT * FROM books WHERE stock > 0 ORDER BY title ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Peminjaman</title>
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
            <li><a href="member.php"><i class="fas fa-users"></i> Member</a></li>
            <li><a href="transaksi.php" class="active"><i class="fas fa-exchange-alt"></i> Transaksi</a></li> <li><a href="laporan.php" target="_blank"><i class="fas fa-print"></i> Laporan</a></li>
        </ul>
        <div class="storage-info">
           <a href="../logout.php" style="color: tomato; text-decoration: none;">Logout</a>
        </div>
    </div>

    <div class="admin-main">
        <h2 style="color: white; margin-bottom: 20px;">Catat Peminjaman Baru</h2>

        <div class="form-card">
            <form action="proses_pinjam.php" method="post">
                
                <div class="form-group">
                    <label>Nama Peminjam (Siswa)</label>
                    <div style="position: relative;">
                        <i class="fas fa-user" style="position: absolute; left: 15px; top: 15px; color: #94a3b8;"></i>
                        <select name="user_id" class="custom-input" style="padding-left: 40px;" required>
                            <option value="">-- Pilih Siswa --</option>
                            <?php while($u = mysqli_fetch_assoc($users)) : ?>
                                <option value="<?= $u['id']; ?>"><?= $u['full_name']; ?> (<?= $u['username']; ?>)</option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Buku yang Dipinjam</label>
                    <div style="position: relative;">
                        <i class="fas fa-book" style="position: absolute; left: 15px; top: 15px; color: #94a3b8;"></i>
                        <select name="book_id" class="custom-input" style="padding-left: 40px;" required>
                            <option value="">-- Pilih Buku --</option>
                            <?php while($b = mysqli_fetch_assoc($books)) : ?>
                                <option value="<?= $b['id']; ?>"><?= $b['title']; ?> (Sisa: <?= $b['stock']; ?>)</option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="loan_date" class="custom-input" style="color-scheme: dark;" value="<?= date('Y-m-d'); ?>" required>
                    <small style="color: #94a3b8; display: block; margin-top: 5px;">*Jatuh tempo otomatis dihitung 7 hari ke depan.</small>
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn-login" style="background: #fbbf24; color: #16202c; font-weight: bold; border: none; cursor: pointer; padding: 12px 25px; border-radius: 10px;">
                        <i class="fas fa-paper-plane"></i> Proses Peminjaman
                    </button>
                    <a href="transaksi.php" style="color: #94a3b8; text-decoration: none; margin-left: 20px;">Batal</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>