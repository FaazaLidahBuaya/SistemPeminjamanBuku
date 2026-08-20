<?php
include '../koneksi.php';

$id_loan = $_GET['id'];
$id_buku = $_GET['book_id'];

// 1. Ambil data peminjaman untuk cek tanggal jatuh tempo
$query = mysqli_query($koneksi, "SELECT * FROM loans WHERE id='$id_loan'");
$data = mysqli_fetch_assoc($query);
$due_date = $data['due_date']; // Tanggal harus kembali

// 2. Hitung Denda
$tgl_kembali = date('Y-m-d'); // Hari ini
$bayar_denda = 0;
$tarif_per_hari = 1000; // Ubah nominal denda di sini (Rp 1.000)

// Jika tanggal kembali lebih besar dari jatuh tempo
if(strtotime($tgl_kembali) > strtotime($due_date)){
    // Hitung selisih hari
    $selisih = strtotime($tgl_kembali) - strtotime($due_date);
    $hari_telat = floor($selisih / (60 * 60 * 24)); // Konversi detik ke hari
    $bayar_denda = $hari_telat * $tarif_per_hari;
}

// 3. Update status, tanggal kembali, DAN simpan dendanya
mysqli_query($koneksi, "UPDATE loans SET status='returned', return_date='$tgl_kembali', denda='$bayar_denda' WHERE id='$id_loan'");

// 4. Kembalikan Stok Buku
mysqli_query($koneksi, "UPDATE books SET stock = stock + 1 WHERE id='$id_buku'");

// Redirect dengan pesan (opsional: bisa tambah info denda di URL)
header("location:transaksi.php?pesan=buku_dikembalikan&denda=$bayar_denda");
?>