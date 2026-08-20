<?php 
session_start();
if($_SESSION['role'] != "admin"){
    header("location:../login.php"); exit();
}

include '../koneksi.php';

// Menangkap data yang dikirim dari form
$full_name = $_POST['full_name'];
$username = $_POST['username'];
$password = $_POST['password']; // Simpan password apa adanya (sesuai sistem login kamu saat ini)
$email = $_POST['email'];
$phone = $_POST['phone_number'];
$address = $_POST['address'];

// Cek apakah Username sudah ada? (Mencegah error duplikat)
$cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");

if(mysqli_num_rows($cek) > 0){
    // Jika username sudah terpakai, kembalikan dengan pesan error
    echo "<script>
            alert('Gagal! Username sudah dipakai siswa lain.');
            window.location='tambah_member.php';
          </script>";
} else {
    // Jika aman, Lakukan Insert
    // Format: id (NULL), username, password, email, full_name, address, phone, role ('member'), created_at (NULL/Auto)
    $query = "INSERT INTO users VALUES (NULL, '$username', '$password', '$email', '$full_name', '$address', '$phone', 'member', NULL)";
    
    if(mysqli_query($koneksi, $query)){
        header("location:member.php?alert=berhasil_tambah");
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }
}
?>