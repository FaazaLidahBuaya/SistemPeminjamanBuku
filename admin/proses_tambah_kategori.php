<?php 
include '../koneksi.php';
$name = $_POST['name'];
mysqli_query($koneksi, "INSERT INTO categories VALUES (NULL, '$name')");
header("location:kategori.php?alert=berhasil");
?>