<?php
session_start();
include 'koneksi.php';

// Cek Login
if(!isset($_SESSION['status'])){
    header("location:login.php?pesan=belum_login");
    exit();
}

$user_id = $_SESSION['user_id'];
$book_id = $_POST['book_id'];
$loan_date = date('Y-m-d');
$due_date = date('Y-m-d', strtotime('+7 days')); 

// 1. Cek Stok Buku
$cek_stok = mysqli_query($koneksi, "SELECT stock FROM books WHERE id='$book_id'");
$data = mysqli_fetch_assoc($cek_stok);

if($data['stock'] > 0){
    // 2. Kurangi Stok
    mysqli_query($koneksi, "UPDATE books SET stock = stock - 1 WHERE id='$book_id'");

    // 3. Masukkan ke Loans dengan menyebutkan nama kolom (LEBIH AMAN)
    // Kita abaikan kolom 'id' (auto increment) dan 'denda' (biarkan default/kosong)
    $query = "INSERT INTO loans (user_id, book_id, loan_date, due_date, return_date, status) 
              VALUES ('$user_id', '$book_id', '$loan_date', '$due_date', NULL, 'booked')";
    
    if(mysqli_query($koneksi, $query)){
        header("location:peminjaman.php?pesan=berhasil_booking");
    } else {
        echo "Gagal booking: " . mysqli_error($koneksi);
    }
} else {
    echo "<script>alert('Yah, Stok habis keduluan orang lain!'); window.location='index.php';</script>";
}
?>