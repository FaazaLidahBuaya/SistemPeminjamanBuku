<?php 
include '../koneksi.php';

$id = $_POST['id'];
$title = $_POST['title'];
$author = $_POST['author'];
$publisher = $_POST['publisher'];

// --- LOGIKA TAHUN ---
// Cek apakah user mengisi tanggal baru?
if($_POST['publication_year'] != ""){
    $full_date = $_POST['publication_year']; 
    $publication_year = substr($full_date, 0, 4); 
} else {
    // Kalau kosong, ambil tahun lama dari database (kita query ulang sebentar)
    $q = mysqli_query($koneksi, "SELECT publication_year FROM books WHERE id='$id'");
    $d = mysqli_fetch_assoc($q);
    $publication_year = $d['publication_year'];
}
// --------------------

$category_id = $_POST['category_id'];
$stock = $_POST['stock'];

// --- LOGIKA GAMBAR ---
$filename = $_FILES['cover_image']['name'];

// Jika admin memilih gambar baru
if($filename != "") {
    $rand = rand();
    $allowed =  array('png','jpg','jpeg');
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if(in_array($ext,$allowed) ) {
        $xx = $rand.'_'.$filename;
        move_uploaded_file($_FILES['cover_image']['tmp_name'], '../assets/'.$xx);
        
        // Update SEMUA data termasuk gambar
        mysqli_query($koneksi, "UPDATE books SET title='$title', author='$author', publisher='$publisher', publication_year='$publication_year', category_id='$category_id', stock='$stock', cover_image='$xx' WHERE id='$id'");
        header("location:index.php?alert=berhasil_update");
    } else {
        header("location:index.php?alert=gagal_ekstensi");
    }
} else {
    // Jika admin TIDAK memilih gambar (Gambar NULL/Kosong)
    // Update data TANPA mengubah kolom cover_image
    mysqli_query($koneksi, "UPDATE books SET title='$title', author='$author', publisher='$publisher', publication_year='$publication_year', category_id='$category_id', stock='$stock' WHERE id='$id'");
    header("location:index.php?alert=berhasil_update");
}
?>