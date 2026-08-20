<?php 
include '../koneksi.php';
$id = $_POST['id'];
$name = $_POST['name'];
mysqli_query($koneksi, "UPDATE categories SET name='$name' WHERE id='$id'");
header("location:kategori.php?alert=update_sukses");
?>