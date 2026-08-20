<?php
session_start();
if($_SESSION['status'] != "login" || $_SESSION['role'] != "admin"){
    header("location:../login.php"); exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Siswa Baru</title>
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
        <h2 style="color: white; margin-bottom: 20px;">Registrasi Siswa Baru</h2>

        <div class="form-card">
            <form action="proses_tambah_member.php" method="post">
                
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="full_name" class="custom-input" placeholder="Nama Lengkap Siswa" required>
                </div>

                <div class="form-group">
                    <label>Username (Untuk Login)</label>
                    <input type="text" name="username" class="custom-input" placeholder="Contoh: budi123" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="password" class="custom-input" placeholder="Masukkan password..." required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="custom-input" placeholder="email@sekolah.com" required>
                </div>

                <div class="form-group">
                    <label>Nomor HP</label>
                    <input type="number" name="phone_number" class="custom-input" placeholder="08xxxxxxxxxx">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="address" class="custom-input" style="height: 100px; resize: none;" placeholder="Alamat lengkap siswa..."></textarea>
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn-login" style="background: #fbbf24; color: #16202c; font-weight: bold; border: none; cursor: pointer; padding: 12px 25px; border-radius: 10px;">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                    <a href="member.php" style="color: #94a3b8; text-decoration: none; margin-left: 20px;">Batal</a>
                </div>

            </form>
        </div>
    </div>
</body>
</html>