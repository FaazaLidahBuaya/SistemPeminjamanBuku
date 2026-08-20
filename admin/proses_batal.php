<?php 
session_start();
if($_SESSION['role'] != "admin"){
    header("location:../login.php"); exit();
}

include '../koneksi.php';

$id = $_GET['id'];
$book_id = $_GET['book_id'];

// 1. Hapus data di tabel loans
$hapus = mysqli_query($koneksi, "DELETE FROM loans WHERE id='$id'");

if($hapus){
    // 2. Kembalikan stok buku (+1) karena tidak jadi dipinjam
    mysqli_query($koneksi, "UPDATE books SET stock = stock + 1 WHERE id='$book_id'");
    
    header("location:transaksi.php?pesan=Booking_dibatalkan_stok_kembali");
} else {
    echo "Gagal membatalkan.";
}
?>