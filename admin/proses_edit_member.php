<?php 
session_start();
// Cek Login Admin
if($_SESSION['role'] != "admin"){
    header("location:../login.php"); exit();
}

include '../koneksi.php';

$id = $_POST['id'];
$full_name = $_POST['full_name'];
$username = $_POST['username'];
$email = $_POST['email'];
$phone = $_POST['phone_number'];
$address = $_POST['address'];
$password = $_POST['password'];

// --- LOGIKA UPDATE ---

if($password != ""){
    // KONDISI 1: Admin mengisi password baru (Reset Password)
    // Pastikan WHERE id='$id' DAN role='member' (Proteksi ganda)
    $query = "UPDATE users SET 
              full_name='$full_name', 
              username='$username', 
              email='$email', 
              phone_number='$phone', 
              address='$address', 
              password='$password' 
              WHERE id='$id' AND role='member'";
} else {
    // KONDISI 2: Password dikosongkan (Tidak diganti)
    $query = "UPDATE users SET 
              full_name='$full_name', 
              username='$username', 
              email='$email', 
              phone_number='$phone', 
              address='$address' 
              WHERE id='$id' AND role='member'";
}

$hasil = mysqli_query($koneksi, $query);

if($hasil){
    header("location:member.php?alert=update_sukses");
} else {
    // Jika gagal (misal username kembar)
    header("location:edit_member.php?id=$id&alert=gagal");
}
?>