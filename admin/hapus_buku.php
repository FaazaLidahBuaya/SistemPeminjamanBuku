<?php 
// KONEKSI
include '../koneksi.php';

// Menangkap ID buku yang dikirim dari url
$id = $_GET['id'];

// Menghapus data dari database berdasarkan ID
mysqli_query($koneksi,"DELETE FROM books WHERE id='$id'");

// Mengalihkan halaman kembali ke index.php
header("location:index.php?alert=hapus");
?>