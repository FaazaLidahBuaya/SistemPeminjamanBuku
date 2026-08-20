<?php 
include '../koneksi.php';

// Menangkap data yang dikirim dari form
$title = $_POST['title'];
$author = $_POST['author'];
$publisher = $_POST['publisher'];

// --- BAGIAN UBAH TANGGAL JADI TAHUN ---
// Data dari form date formatnya: "2026-01-26"
$full_date = $_POST['publication_year']; 
// Ambil 4 karakter pertama saja untuk mendapatkan Tahun (contoh: "2026")
$publication_year = substr($full_date, 0, 4); 
// --------------------------------------

$category_id = $_POST['category_id'];
$stock = $_POST['stock'];

// --- BAGIAN UPLOAD GAMBAR ---
$rand = rand();
$allowed =  array('png','jpg','jpeg');
$filename = $_FILES['cover_image']['name'];
$ukuran = $_FILES['cover_image']['size'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

if($filename != "") {
    // KONDISI 1: Jika user meng-upload gambar
    if(in_array($ext,$allowed) ) {
        // Cek ukuran file (maksimal sekitar 2MB)
        if($ukuran < 2044070){		
            $xx = $rand.'_'.$filename;
            // Pindahkan file gambar ke folder assets
            move_uploaded_file($_FILES['cover_image']['tmp_name'], '../assets/'.$xx);
            
            // Simpan ke database dengan nama gambar ($xx)
            // Urutan: id, title, author, publisher, year, category, stock, cover, created_at
            mysqli_query($koneksi, "INSERT INTO books VALUES (NULL,'$title','$author','$publisher','$publication_year','$category_id','$stock','$xx', NULL)");
            
            header("location:index.php?alert=berhasil");
        }else{
            header("location:index.php?alert=gagal_ukuran");
        }
    }else{
        header("location:index.php?alert=gagal_ekstensi");
    }
} else {
    // KONDISI 2: Jika user TIDAK meng-upload gambar (kosong)
    // Bagian cover diisi NULL
    mysqli_query($koneksi, "INSERT INTO books VALUES (NULL,'$title','$author','$publisher','$publication_year','$category_id','$stock', NULL, NULL)");
    header("location:index.php");
}
?>