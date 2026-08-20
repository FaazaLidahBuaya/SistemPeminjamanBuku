<?php
session_start();
include 'koneksi.php';
$id_buku = $_GET['id'];

// Ambil info buku
$query = mysqli_query($koneksi, "SELECT * FROM books WHERE id='$id_buku'");
$buku = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Buku</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">

    <div style="background: #253341; padding: 30px; border-radius: 15px; display: flex; gap: 30px; max-width: 800px; width: 100%;">
        
        <?php if($buku['cover_image'] != NULL): ?>
            <img src="assets/<?= $buku['cover_image']; ?>" style="width: 250px; border-radius: 10px; object-fit: cover;">
        <?php else: ?>
            <div style="width: 250px; height: 350px; background: #333; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #aaa; flex-direction: column;">
                <i class="fas fa-book" style="font-size: 50px; margin-bottom: 10px;"></i>
                <span>No Cover</span>
            </div>
        <?php endif; ?>
        
        <div style="color: white; flex: 1;">
            <h1 style="margin-bottom: 10px;"><?= $buku['title']; ?></h1>
            <p style="color: #8b95a5; margin-bottom: 20px;">Penulis: <?= $buku['author']; ?></p>
            
            <table cellpadding="5" style="color: #ddd;">
                <tr>
                    <td>Penerbit</td>
                    <td>: <?= $buku['publisher']; ?></td>
                </tr>
                <tr>
                    <td>Tahun</td>
                    <td>: <?= $buku['publication_year']; ?></td>
                </tr>
                <tr>
                    <td>Stok Tersedia</td>
                    <td>: <strong><?= $buku['stock']; ?></strong></td>
                </tr>
            </table>

            <br>
            
            <?php if($buku['stock'] > 0): ?>
                
                <div style="background: #253341; border: 1px solid #fbbf24; color: #fbbf24; padding: 15px; border-radius: 8px; text-align: center;">
                    <i class="fas fa-check-circle"></i> Stok Tersedia
                    
                    <?php if(isset($_SESSION['status']) && $_SESSION['status'] == "login"): ?>
                        <form action="proses_booking.php" method="post" style="margin-top: 15px;">
                            <input type="hidden" name="book_id" value="<?= $buku['id']; ?>">
                            <button type="submit" class="btn-login" style="background: #fbbf24; color: #16202c; width: 100%; border: none; font-weight: bold; cursor: pointer; padding: 10px; transition: 0.3s;" onmouseover="this.style.background='#f59e0b'" onmouseout="this.style.background='#fbbf24'">
                                <i class="fas fa-bookmark"></i> BOOKING SEKARANG
                            </button>
                        </form>
                        <p style="font-size: 13px; color: #8b95a5; margin-top: 10px;">
                            Buku akan diamankan untukmu. Segera ambil di perpustakaan.
                        </p>
                    <?php else: ?>
                        <p style="margin-top: 10px; color: #cbd5e1; font-size: 14px;">
                            <a href="login.php" style="color: #fbbf24; text-decoration: none; font-weight: bold;">Login</a> untuk membooking buku ini.
                        </p>
                    <?php endif; ?>

                </div>

            <?php else: ?>
                <button disabled style="background: #ef4444; color: white; padding: 10px 20px; border: none; border-radius: 5px; width: 100%; cursor: not-allowed;">
                    STOK HABIS
                </button>
            <?php endif; ?>

            <br>
            <a href="index.php" style="color: #8b95a5; text-decoration: none; display: block; text-align: center; margin-top: 10px;">Kembali</a>
        </div>
    </div>

</body>
</html>