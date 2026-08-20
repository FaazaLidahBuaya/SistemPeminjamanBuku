<?php 
session_start();
// Cek Login & Role Admin
if($_SESSION['status'] != "login" || $_SESSION['role'] != "admin"){
    header("location:../login.php"); exit();
}

include '../koneksi.php';

$id = $_GET['id'];

// --- PROTEKSI ---
// Cek dulu apakah ID yang mau dihapus adalah 'member' (Siswa)
// Jangan sampai Admin menghapus Admin lain lewat URL
$cek = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id' AND role='member'");

if(mysqli_num_rows($cek) > 0){
    // 1. Hapus Data Peminjaman Siswa Tersebut (Penting agar tidak error foreign key)
    mysqli_query($koneksi, "DELETE FROM loans WHERE user_id='$id'");

    // 2. Hapus Akun Siswa
    mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");
    
    header("location:member.php?alert=berhasil_hapus");
} else {
    // Jika mencoba menghapus admin atau ID tidak ditemukan
    echo "<script>
            alert('Gagal! Anda tidak bisa menghapus sesama Admin atau User tidak ditemukan.');
            window.location='member.php';
          </script>";
}
?>