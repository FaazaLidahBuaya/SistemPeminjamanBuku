<?php
include 'koneksi.php';
session_start();

// Ambil data kategori + Jumlah bukunya
$query = mysqli_query($koneksi, "SELECT categories.*, COUNT(books.id) as total_buku 
                                 FROM categories 
                                 LEFT JOIN books ON categories.id = books.category_id 
                                 GROUP BY categories.id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kategori Buku</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav>
        <div class="logo"><i class="fas fa-book-open"></i> Perpustakaan</div>
        <ul class="menu">
            <li><a href="index.php">Library</a></li>
            <li><a href="kategori.php" class="active">Category</a></li>
            <?php if(isset($_SESSION['status'])): ?>
                <li><a href="peminjaman.php">Peminjaman</a></li>
            <?php endif; ?>
        </ul>

        <form action="index.php" method="get" class="search-box">
            <input type="text" name="cari" placeholder="Cari judul atau penulis..." autocomplete="off">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
        
        <?php if(isset($_SESSION['status']) && $_SESSION['status'] == "login"): ?>
            <div style="display: flex; gap: 10px; align-items: center; margin-left: 20px;">
                <span style="color: #8b95a5; font-size: 14px;">Hi, <?= $_SESSION['username']; ?></span>
                <a href="logout.php" class="btn-login" style="background: tomato;">Logout</a>
            </div>
        <?php else: ?>
            <a href="login.php" class="btn-login" style="margin-left: 20px;">Login</a>
        <?php endif; ?>
    </nav>

    <div class="container">
        <div class="main-content">
            <h2 style="margin-bottom: 20px;">Jelajahi Kategori</h2>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                <?php while($cat = mysqli_fetch_assoc($query)) : ?>
                
                <a href="index.php?kategori_id=<?= $cat['id']; ?>" style="text-decoration: none;">
                    <div class="stat-card" style="border: 1px solid #334155; cursor: pointer; transition: 0.3s; height: 100%;">
                        <h3 style="color: #fbbf24; font-size: 18px;"><?= $cat['name']; ?></h3>
                        <div class="stat-value" style="margin-top: 15px;">
                            <i class="fas fa-layer-group" style="color: #fbbf24; opacity: 0.5;"></i>
                            <span style="font-size: 30px;"><?= $cat['total_buku']; ?></span>
                        </div>
                        <small style="color: #8b95a5; display: block; margin-top: 5px;">Judul Buku</small>
                    </div>
                </a>

                <?php endwhile; ?>
            </div>
        </div>
    </div><footer class="main-footer">
        <div class="footer-content">
            
            <div class="footer-brand">
                <i class="fas fa-book-open"></i> Perpustakaan Digital
            </div>

            <div class="footer-links">
                <a href="index.php">Library</a>
                <a href="kategori.php">Kategori</a>
                <a href="peminjaman.php">Peminjaman</a>
                <?php if(!isset($_SESSION['status'])): ?>
                    <a href="login.php">Login Admin</a>
                <?php endif; ?>
            </div>

            <p class="copyright">
                &copy; <?= date('Y'); ?> Dibuat dengan <i class="fas fa-heart" style="color: tomato;"></i> oleh Faaza
            </p>
            
        </div>
    </footer>

</body>
</html>