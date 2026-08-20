<?php
session_start();
if($_SESSION['status'] != "login" || $_SESSION['role'] != "admin"){
    header("location:../login.php"); exit();
}
include '../koneksi.php';

// 1. Ambil data BOOKING (status = booked)
$booking = mysqli_query($koneksi, "SELECT loans.*, books.title, users.full_name 
                                  FROM loans 
                                  JOIN books ON loans.book_id = books.id 
                                  JOIN users ON loans.user_id = users.id 
                                  WHERE loans.status = 'booked' ORDER BY loan_date DESC");

// 2. Ambil data yang SEDANG DIPINJAM (status = borrowed)
$pinjam = mysqli_query($koneksi, "SELECT loans.*, books.title, users.full_name 
                                  FROM loans 
                                  JOIN books ON loans.book_id = books.id 
                                  JOIN users ON loans.user_id = users.id 
                                  WHERE loans.status = 'borrowed' ORDER BY loan_date DESC");

// 3. Ambil data RIWAYAT (status = returned) - Limit 10 terakhir
$riwayat = mysqli_query($koneksi, "SELECT loans.*, books.title, users.full_name 
                                   FROM loans 
                                   JOIN books ON loans.book_id = books.id 
                                   JOIN users ON loans.user_id = users.id 
                                   WHERE loans.status = 'returned' ORDER BY return_date DESC LIMIT 10");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Peminjaman</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-body">

    <div class="admin-sidebar">
        <div class="logo"><i class="fas fa-book-open" style="color: #fbbf24;"></i> Admin</div>
        <ul class="admin-menu">
            <li><a href="index.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="kelola_buku.php"><i class="fas fa-book"></i> Data Buku</a></li>
            <li><a href="kategori.php"><i class="fas fa-shapes"></i> Kategori</a></li>
            <li><a href="member.php"><i class="fas fa-users"></i> Member</a></li>
            <li><a href="transaksi.php" class="active"><i class="fas fa-exchange-alt"></i> Transaksi</a></li> <li><a href="laporan.php" target="_blank"><i class="fas fa-print"></i> Laporan</a></li>
        </ul>
        <div class="storage-info">
           <a href="../logout.php" style="color: tomato; text-decoration: none;">Logout</a>
        </div>
    </div>

    <div class="admin-main">
        
        <div class="admin-header">
            <h2 style="color: white;">Transaksi Peminjaman</h2>
            <div style="display: flex; gap: 10px;">
                <a href="pinjam_buku.php" class="btn-login" style="background: #3b82f6; color: white; font-weight: bold; padding: 10px 20px; border-radius: 20px;">
                    <i class="fas fa-plus"></i> Pinjam Manual
                </a>
                <a href="laporan.php" target="_blank" class="btn-login" style="background: white; color: #16202c; font-weight: bold; padding: 10px 20px; border-radius: 20px;" title="Cetak Laporan">
                    <i class="fas fa-print"></i>
                </a>
            </div>
        </div>

        <?php if(isset($_GET['pesan'])): ?>
            <div style="background: #10b981; color: white; padding: 15px; margin-bottom: 20px; border-radius: 10px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_GET['pesan']); ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['denda']) && $_GET['denda'] > 0): ?>
            <div style="background: #fbbf24; color: #16202c; padding: 15px; margin-bottom: 20px; border-radius: 10px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-exclamation-triangle"></i> 
                <strong>Buku Dikembalikan!</strong> Denda keterlambatan: <strong>Rp <?= number_format($_GET['denda']); ?></strong>
            </div>
        <?php endif; ?>

        
        <h4 style="color: #fbbf24; margin-bottom: 15px; text-transform: uppercase; font-size: 12px; border-bottom: 1px solid #334155; padding-bottom: 10px; letter-spacing: 1px;">
            <i class="fas fa-inbox"></i> Permintaan Booking Masuk
        </h4>

        <table class="custom-table" style="margin-bottom: 50px;">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Buku yang Dipesan</th>
                    <th>Tanggal Booking</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($b = mysqli_fetch_assoc($booking)) : ?>
                <tr>
                    <td style="font-weight: bold; color: white;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 30px; height: 30px; background: #fbbf24; border-radius: 50%; display: flex; justify-content: center; align-items: center; color: #16202c; font-size: 12px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <?= $b['full_name']; ?>
                        </div>
                    </td>
                    <td style="color: #94a3b8;"><?= $b['title']; ?></td>
                    <td style="color: #94a3b8;"><?= date('d M Y', strtotime($b['loan_date'])); ?></td>
                    <td>
                        <a href="proses_approve.php?id=<?= $b['id']; ?>" 
                           style="background: #10b981; color: white; padding: 8px 15px; border-radius: 20px; font-size: 12px; text-decoration: none; margin-right: 5px; display: inline-block;"
                           onclick="return confirm('Siswa sudah datang mengambil buku?');">
                           <i class="fas fa-check"></i> Ambil
                        </a>
                        
                        <a href="proses_batal.php?id=<?= $b['id']; ?>&book_id=<?= $b['book_id']; ?>" 
                           style="background: #ef4444; color: white; padding: 8px 15px; border-radius: 20px; font-size: 12px; text-decoration: none; display: inline-block;"
                           onclick="return confirm('Batalkan booking? Stok akan dikembalikan.');">
                           <i class="fas fa-times"></i> Batal
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
                
                <?php if(mysqli_num_rows($booking) == 0): ?>
                    <tr><td colspan="4" style="text-align:center; color: #555; font-style: italic; padding: 20px;">Tidak ada permintaan booking baru.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>


        <h4 style="color: #3b82f6; margin-bottom: 15px; text-transform: uppercase; font-size: 12px; border-bottom: 1px solid #334155; padding-bottom: 10px; letter-spacing: 1px;">
            <i class="fas fa-hand-holding"></i> Sedang Dipinjam
        </h4>

        <table class="custom-table" style="margin-bottom: 50px;">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Jatuh Tempo</th>
                    <th>Status Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($p = mysqli_fetch_assoc($pinjam)) : 
                    // LOGIKA HITUNG ESTIMASI DENDA LIVE
                    $estimasi_denda = 0;
                    $tarif_per_hari = 1000;
                    $tgl_sekarang = date('Y-m-d');
                    $hari_telat = 0;

                    if($tgl_sekarang > $p['due_date']){
                        $selisih = strtotime($tgl_sekarang) - strtotime($p['due_date']);
                        $hari_telat = floor($selisih / (60 * 60 * 24));
                        $estimasi_denda = $hari_telat * $tarif_per_hari;
                    }
                ?>
                <tr>
                    <td style="font-weight: bold; color: white;"><?= $p['full_name']; ?></td>
                    <td style="color: #94a3b8;"><?= $p['title']; ?></td>
                    <td style="color: #fbbf24;"><?= date('d M Y', strtotime($p['due_date'])); ?></td>
                    <td>
                        <?php if($estimasi_denda > 0): ?>
                            <span style="color: #ef4444; font-weight: bold; background: rgba(239, 68, 68, 0.1); padding: 5px 10px; border-radius: 10px; font-size: 12px;">
                                Rp <?= number_format($estimasi_denda); ?> (Telat <?= $hari_telat; ?> Hari)
                            </span>
                        <?php else: ?>
                            <span style="color: #10b981; background: rgba(16, 185, 129, 0.1); padding: 5px 10px; border-radius: 10px; font-size: 12px;">
                                Aman
                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="proses_kembali.php?id=<?= $p['id']; ?>&book_id=<?= $p['book_id']; ?>" 
                           style="background: #3b82f6; color: white; padding: 8px 15px; border-radius: 20px; font-size: 12px; text-decoration: none;"
                           onclick="return confirm('Selesaikan peminjaman ini? Buku akan dikembalikan ke stok.');">
                           <i class="fas fa-check-double"></i> Selesai
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>

                <?php if(mysqli_num_rows($pinjam) == 0): ?>
                    <tr><td colspan="5" style="text-align:center; color: #555; font-style: italic; padding: 20px;">Tidak ada buku yang sedang dipinjam.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>


        <h4 style="color: #94a3b8; margin-bottom: 15px; text-transform: uppercase; font-size: 12px; border-bottom: 1px solid #334155; padding-bottom: 10px; letter-spacing: 1px;">
            <i class="fas fa-history"></i> Riwayat Pengembalian Terakhir
        </h4>

        <table class="custom-table">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($r = mysqli_fetch_assoc($riwayat)) : ?>
                <tr style="opacity: 0.6;">
                    <td><?= $r['full_name']; ?></td>
                    <td><?= $r['title']; ?></td>
                    <td><?= date('d M Y', strtotime($r['return_date'])); ?></td>
                    <td>
                        <span style="background: #334155; padding: 5px 10px; border-radius: 10px; font-size: 11px;">
                            Dikembalikan
                        </span>
                        <?php if($r['denda'] > 0): ?>
                            <span style="color: #ef4444; font-size: 11px; margin-left: 5px;">(Kena Denda)</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</body>
</html>