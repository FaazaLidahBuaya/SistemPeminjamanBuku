<?php 
session_start();
if($_SESSION['role'] != "admin"){
    header("location:../login.php"); exit();
}

include '../koneksi.php';
$id = $_GET['id'];

// Update status jadi 'borrowed' (Dipinjam)
// Kita set loan_date jadi hari ini (hari pengambilan)
// Dan set due_date jadi 7 hari ke depan
$tgl_ambil = date('Y-m-d');
$due_date = date('Y-m-d', strtotime('+7 days'));

$query = "UPDATE loans SET 
          status='borrowed', 
          loan_date='$tgl_ambil', 
          due_date='$due_date' 
          WHERE id='$id'";

if(mysqli_query($koneksi, $query)){
    header("location:transaksi.php?pesan=Buku_berhasil_diambil");
} else {
    echo "Gagal memproses.";
}
?>