<?php
session_start();
// Cek Login & Role Admin
if($_SESSION['status'] != "login" || $_SESSION['role'] != "admin"){
    header("location:../login.php"); exit();
}

include '../koneksi.php';
$id = $_GET['id'];

// --- PROTEKSI ---
// Cari data user berdasarkan ID, TAPI HANYA yang role-nya 'member'
// Ini mencegah Admin mengedit data sesama Admin lewat URL
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id' AND role='member'");
$member = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan (artinya ID salah atau mencoba edit Admin)
if(mysqli_num_rows($query) < 1){
    echo "<script>
            alert('Akses Ditolak! Anda hanya bisa mengedit data Siswa.'); 
            window.location='member.php';
          </script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Siswa</title>
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
        <h2 style="color: white; margin-bottom: 20px;">Edit Data Siswa</h2>

        <div class="form-card">
            <form action="proses_edit_member.php" method="post">
                <input type="hidden" name="id" value="<?= $member['id']; ?>">

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="full_name" class="custom-input" value="<?= $member['full_name']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="custom-input" value="<?= $member['username']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="custom-input" value="<?= $member['email']; ?>" required>
                </div>

                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" name="phone_number" class="custom-input" value="<?= $member['phone_number']; ?>">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="address" class="custom-input" style="height: 100px; resize: none;"><?= $member['address']; ?></textarea>
                </div>

                <div class="form-group" style="border-top: 1px solid #334155; padding-top: 20px; margin-top: 20px;">
                    <label style="color: #fbbf24;"><i class="fas fa-key"></i> Reset Password (Opsional)</label>
                    <input type="text" name="password" class="custom-input" placeholder="Isi hanya jika ingin mengganti password siswa...">
                    <small style="color: #94a3b8; font-style: italic;">*Biarkan kosong jika password tidak ingin diubah.</small>
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn-login" style="background: #3b82f6; color: white; font-weight: bold; border: none; cursor: pointer; padding: 12px 25px; border-radius: 10px;">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="member.php" style="color: #94a3b8; text-decoration: none; margin-left: 20px;">Batal</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>