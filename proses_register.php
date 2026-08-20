<?php
include 'koneksi.php';

$full_name = $_POST['full_name'];
$email     = $_POST['email'];
// 1. Tangkap data baru
$phone     = $_POST['phone_number'];
$address   = $_POST['address'];

$username  = $_POST['username'];
$password  = $_POST['password'];

// Cek dulu apakah username sudah ada?
$cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");

if(mysqli_num_rows($cek_user) > 0){
    echo "<script>
            alert('Username sudah terpakai, silakan cari username lain!');
            window.location='register.php';
          </script>";
} else {
    // 2. Masukkan variabel $address dan $phone ke dalam query INSERT
    // Urutan harus sesuai database: id, username, password, email, full_name, address, phone, role, created_at
    
    $query = "INSERT INTO users VALUES (NULL, '$username', '$password', '$email', '$full_name', '$address', '$phone', 'member', NULL)";
    
    if(mysqli_query($koneksi, $query)){
        header("location:login.php?pesan=sukses_daftar");
    } else {
        echo "Gagal Mendaftar: " . mysqli_error($koneksi);
    }
}
?>