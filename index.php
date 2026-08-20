<?php
include 'koneksi.php';

// 1. Ambil Data Statistik
$total_buku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM books"))['total'];
$total_kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM categories"))['total'];

session_start();
$total_riwayat = 0;
if(isset($_SESSION['user_id'])){
    $id_user = $_SESSION['user_id'];
    $total_riwayat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM loans WHERE user_id = '$id_user'"))['total'];
}

// 2. LOGIKA UTAMA (Search, Filter Kategori, & Show All)
if(isset($_GET['cari'])){
    // LOGIKA PENCARIAN
    $keyword = $_GET['cari'];
    $buku_query = mysqli_query($koneksi, "SELECT * FROM books WHERE title LIKE '%$keyword%' OR author LIKE '%$keyword%'");
} 
else if(isset($_GET['kategori_id'])){
    // LOGIKA FILTER KATEGORI
    $kategori_id = $_GET['kategori_id'];
    $buku_query = mysqli_query($koneksi, "SELECT * FROM books WHERE category_id='$kategori_id'");
    
    // Ambil nama kategori
    $cat_name_row = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT name FROM categories WHERE id='$kategori_id'"));
    $nama_kategori = $cat_name_row['name'];
} 
else if(isset($_GET['show_all'])){
    // --- LOGIKA BARU: TAMPILKAN SEMUA BUKU ---
    // Query tanpa LIMIT
    $buku_query = mysqli_query($koneksi, "SELECT * FROM books ORDER BY id DESC");
}
else {
    // DEFAULT (Hanya Tampil 8 Buku Terbaru)
    $buku_query = mysqli_query($koneksi, "SELECT * FROM books ORDER BY id DESC LIMIT 8");
}

// 3. Ambil 1 Buku Populer
$popular_book = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM books ORDER BY stock ASC LIMIT 1"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Perpustakaan Digital</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav>
        <div class="logo"><i class="fas fa-book-open"></i> Perpustakaan</div>
        <ul class="menu">
            <li><a href="index.php" class="<?= (!isset($_GET['cari']) && !isset($_GET['kategori_id']) && !isset($_GET['show_all'])) ? 'active' : ''; ?>">Library</a></li>
            <li><a href="kategori.php" class="<?= (isset($_GET['kategori_id'])) ? 'active' : ''; ?>">Category</a></li>
            <?php if(isset($_SESSION['status'])): ?>
                <li><a href="peminjaman.php">Peminjaman</a></li>
            <?php endif; ?>
        </ul>

        <form action="index.php" method="get" class="search-box">
            <input type="text" name="cari" placeholder="Cari judul atau penulis..." value="<?= isset($_GET['cari']) ? $_GET['cari'] : ''; ?>" autocomplete="off">
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
            <div class="header-section">
                <?php if(isset($_GET['cari'])): ?>
                    <h2>Hasil pencarian: "<?= $_GET['cari']; ?>"</h2>
                    <a href="index.php" class="see-all" style="color: tomato;">Reset</a>
                
                <?php elseif(isset($_GET['kategori_id'])): ?>
                    <h2>Kategori: <?= $nama_kategori; ?></h2>
                    <a href="index.php" class="see-all" style="color: tomato;">Reset Filter</a>
                
                <?php elseif(isset($_GET['show_all'])): ?>
                    <h2>Semua Koleksi Buku</h2>
                    <a href="index.php" class="see-all" style="color: tomato;">Tutup</a>

                <?php else: ?>
                    <h2>Recomended</h2>
                    <a href="index.php?show_all=true" class="see-all">See all</a>
                <?php endif; ?>
            </div>

            <div class="book-grid">
                <?php 
                if(mysqli_num_rows($buku_query) > 0) {
                    while($buku = mysqli_fetch_assoc($buku_query)) { 
                ?>
                
                <a href="detail.php?id=<?= $buku['id']; ?>" style="text-decoration: none; color: inherit;">
                    <div class="book-card">
                        <?php if($buku['cover_image'] != NULL): ?>
                            <img src="assets/<?= $buku['cover_image']; ?>" 
                                 style="width: 100%; aspect-ratio: 2/3; object-fit: cover; border-radius: 8px; margin-bottom: 10px;">
                        <?php else: ?>
                            <div style="width: 100%; aspect-ratio: 2/3; background: #333; border-radius: 8px; margin-bottom: 10px; display: flex; align-items: center; justify-content: center; color: #aaa; flex-direction: column;">
                                <i class="fas fa-book" style="font-size: 30px; margin-bottom: 10px;"></i>
                                <span style="font-size: 12px;">No Cover</span>
                            </div>
                        <?php endif; ?>

                        <h3 style="font-size: 16px; margin-bottom: 5px;"><?= $buku['title']; ?></h3>
                        <p style="font-size: 13px; color: #94a3b8;"><?= $buku['author']; ?></p>
                        
                        <?php if($buku['stock'] > 0): ?>
                            <div class="stock-info" style="color: #fbbf24; font-size: 12px; margin-top: 5px;">
                                <i class="fas fa-check-circle"></i> Stok: <?= $buku['stock']; ?>
                            </div>
                        <?php else: ?>
                            <div class="stock-info" style="color: tomato; font-size: 12px; margin-top: 5px;">
                                <i class="fas fa-times-circle"></i> Habis
                            </div>
                        <?php endif; ?>
                    </div>
                </a>

                <?php 
                    } 
                } else {
                    echo "<p style='color: #8b95a5; font-style: italic;'>Buku tidak ditemukan...</p>";
                }
                ?>
            </div>

            <h2 style="margin-top: 40px;">Infomation</h2>
            <div class="stats-container">
                
                <a href="index.php?show_all=true" style="text-decoration: none; flex: 1;">
                    <div class="stat-card" style="cursor: pointer; transition: 0.3s;">
                        <h3>Total buku</h3>
                        <div class="stat-value">
                            <i class="fas fa-book"></i>
                            <span><?= $total_buku; ?></span>
                        </div>
                    </div>
                </a>

                <a href="kategori.php" style="text-decoration: none; flex: 1;">
                    <div class="stat-card" style="cursor: pointer; transition: 0.3s;">
                        <h3>Total kategori</h3>
                        <div class="stat-value">
                            <i class="fas fa-shapes"></i>
                            <span><?= $total_kategori; ?></span>
                        </div>
                    </div>
                </a>

                <a href="peminjaman.php" style="text-decoration: none; flex: 1;">
                    <div class="stat-card" style="cursor: pointer; transition: 0.3s;">
                        <h3>Total riwayat saya</h3>
                        <div class="stat-value">
                            <i class="fas fa-history"></i>
                            <span><?= $total_riwayat; ?></span>
                        </div>
                    </div>
                </a>

            </div>
        </div>

        <div class="sidebar">
            <h2>Most populer book</h2>
            <?php if($popular_book): ?>
            <a href="detail.php?id=<?= $popular_book['id']; ?>" style="text-decoration: none; color: inherit;">
                <div class="popular-card">
                    <?php if($popular_book['cover_image']): ?>
                        <img src="assets/<?= $popular_book['cover_image']; ?>" alt="Cover" 
                             style="width: 100%; aspect-ratio: 2/3; object-fit: cover; border-radius: 10px; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                    <?php endif; ?>
                    <h3 style="margin-top: 15px;"><?= $popular_book['title']; ?></h3>
                    <p><?= $popular_book['author']; ?></p>
                    <small style="display: block; margin-top: 5px; color: #fbbf24;"><?= $popular_book['publication_year']; ?></small>
                </div>
            </a>
            <?php endif; ?>
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