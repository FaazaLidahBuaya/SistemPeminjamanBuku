<?php 
// Mengaktifkan session php
session_start();
 
// Menghubungkan dengan koneksi
include 'koneksi.php';
 
// Menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = $_POST['password'];
 
// Menyeleksi data user dengan username dan password yang sesuai
$data = mysqli_query($koneksi,"SELECT * FROM users WHERE username='$username' AND password='$password'");
 
// Menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($data);
 
if($cek > 0){
    $row = mysqli_fetch_assoc($data);

    // Simpan data user ke session
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['status'] = "login";

    // Cek Level User
    if($row['role'] == "admin"){
        // Jika admin, arahkan ke folder admin
        header("location:admin/index.php");
    }else{
        // Jika member, arahkan ke halaman utama member
        header("location:index.php");
    }

}else{
    // Jika gagal, alihkan kembali ke halaman login
    header("location:login.php?pesan=gagal");
}
?>