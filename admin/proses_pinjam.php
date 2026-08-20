<?php
include '../koneksi.php';

$user_id = $_POST['user_id'];
$book_id = $_POST['book_id'];
$loan_date = $_POST['loan_date'];

// Hitung tanggal kembali (otomatis +7 hari dari tanggal pinjam)
$due_date = date('Y-m-d', strtotime('+7 days', strtotime($loan_date)));

// 1. Masukkan ke tabel loans
$query = mysqli_query($koneksi, "INSERT INTO loans VALUES(NULL, '$user_id', '$book_id', '$loan_date', '$due_date', NULL, 'borrowed')");

if($query){
    // 2. Kurangi Stok Buku
    mysqli_query($koneksi, "UPDATE books SET stock = stock - 1 WHERE id='$book_id'");

    // Kembali ke dashboard admin
    header("location:index.php?alert=berhasil_pinjam");
} else {
    header("location:pinjam_buku.php?alert=gagal");
}
?>