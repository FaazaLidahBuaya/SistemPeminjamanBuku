<?php 
// Mengaktifkan session
session_start();
 
// Menghapus semua session
session_destroy();
 
// Mengalihkan halaman kembali ke halaman login
header("location:login.php?pesan=logout");
?>