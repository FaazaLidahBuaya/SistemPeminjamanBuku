<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if(!isset($_SESSION['status'])){ 
    header("location:login.php"); 
    exit(); 
}

$id_user = $_SESSION['user_id'];

// Ambil Riwayat Member
$query = mysqli_query($koneksi, "SELECT loans.*, books.title, books.cover_image 
                                 FROM loans 
                                 JOIN books ON loans.book_id = books.id 
                                 WHERE loans.user_id = '$id_user' 
                                 ORDER BY loans.id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Peminjaman Saya</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    
    <nav>
        <div class="logo"><i class="fas fa-book-open"></i> Perpustakaan</div>
        <ul class="menu">
            <li><a href="index.php">Library</a></li>
            <li><a href="kategori.php">Category</a></li>
            <li><a href="peminjaman.php" class="active">Peminjaman</a></li>
        </ul>

        <form action="index.php" method="get" class="search-box">
            <input type="text" name="cari" placeholder="Cari judul atau penulis..." autocomplete="off">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
        
        <div style="display: flex; gap: 10px; align-items: center; margin-left: 20px;">
            <span style="color: #8b95a5; font-size: 14px;">Hi, <?= $_SESSION['username']; ?></span>
            <a href="logout.php" class="btn-login" style="background: tomato;">Logout</a>
        </div>
    </nav>

    <div class="container" style="display: block;"> 
        <h2 style="margin-bottom: 20px;">Riwayat Buku Saya</h2>

        <div style="background: #1e293b; border-radius: 15px; overflow: hidden; padding: 10px;">
            <table cellpadding="20" cellspacing="0" style="width: 100%; color: white; border-collapse: collapse;">
                <thead>
                    <tr style="background: #0f172a; text-align: left; border-bottom: 2px solid #334155;">
                        <th>Buku</th>
                        <th>Tanggal Pinjam / Booking</th>
                        <th>Jatuh Tempo</th>
                        <th>Tanggal Kembali</th>
                        <th>Denda</th> 
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query)) : ?>
                    <tr style="border-bottom: 1px solid #334155;">
                        <td style="display: flex; align-items: center; gap: 15px;">
                            <?php if($row['cover_image']): ?>
                                <img src="assets/<?= $row['cover_image']; ?>" style="width: 40px; height: 60px; object-fit: cover; border-radius: 5px;">
                            <?php else: ?>
                                <div style="width: 40px; height: 60px; background: #333; border-radius: 5px;"></div>
                            <?php endif; ?>
                            <span style="font-weight: bold; color: #fbbf24;"><?= $row['title']; ?></span>
                        </td>
                        <td><?= $row['loan_date']; ?></td>
                        <td><?= $row['due_date']; ?></td>
                        <td>
                            <?= ($row['return_date']) ? $row['return_date'] : '-'; ?>
                        </td>
                        
                        <td>
                            <?php 
                            if($row['status'] == 'returned'){
                                // KASUS 1: Buku sudah kembali
                                if($row['denda'] > 0){
                                    echo "<span style='color: tomato;'>Rp " . number_format($row['denda']) . "</span>";
                                } else {
                                    echo "-";
                                }
                            } else {
                                // KASUS 2: Buku masih dipinjam / dibooking
                                $denda_est = 0;
                                $tarif = 1000; 
                                $tgl_sekarang = date('Y-m-d');
                                
                                if(strtotime($tgl_sekarang) > strtotime($row['due_date'])){
                                    $selisih = strtotime($tgl_sekarang) - strtotime($row['due_date']);
                                    $hari = floor($selisih / (60 * 60 * 24));
                                    $denda_est = $hari * $tarif;
                                }

                                if($denda_est > 0){
                                    echo "<span style='color: #fbbf24; font-size: 13px;'>Est: Rp " . number_format($denda_est) . "</span>";
                                    echo "<br><small style='color: #8b95a5;'>(Telat $hari hari)</small>";
                                } else {
                                    echo "-";
                                }
                            }
                            ?>
                        </td>

                        <td>
                            <?php if($row['status'] == 'borrowed'): ?>
                                <span style="background: #3b82f6; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px;">Dipinjam</span>
                            <?php elseif($row['status'] == 'booked'): ?>
                                <span style="background: #f59e0b; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px;">Booking</span>
                            <?php else: ?>
                                <span style="background: #10b981; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px;">Selesai</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
            <?php if(mysqli_num_rows($query) == 0): ?>
                <div style="text-align: center; padding: 40px; color: #8b95a5;">
                    <p>Kamu belum pernah meminjam atau membooking buku.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
    
    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-brand"><i class="fas fa-book-open"></i> Perpustakaan Digital</div>
            <div class="footer-links">
                <a href="index.php">Library</a>
                <a href="kategori.php">Kategori</a>
                <a href="peminjaman.php">Peminjaman</a>
            </div>
            <p class="copyright">&copy; <?= date('Y'); ?> Dibuat dengan <i class="fas fa-heart" style="color: tomato;"></i></p>
        </div>
    </footer>
</body>
</html>