<?php
session_start();
// Cek Login & Role Admin
if ($_SESSION['role'] != "admin") {
    header("location:../login.php");
    exit();
}

include '../koneksi.php';

// Ambil semua data peminjaman (Baik yang dipinjam, dikembalikan, atau booking)
// Diurutkan dari yang terbaru
$query = mysqli_query($koneksi, "SELECT loans.*, books.title, users.full_name 
                                 FROM loans 
                                 JOIN books ON loans.book_id = books.id 
                                 JOIN users ON loans.user_id = users.id 
                                 ORDER BY loans.loan_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perpustakaan</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #f2f2f2;
        }
        .status-kembali {
            color: green;
            font-weight: bold;
        }
        .status-pinjam {
            color: blue;
        }
        .status-denda {
            color: red;
        }
        
        /* CSS Khusus Cetak: Sembunyikan tombol saat diprint */
        @media print {
            .no-print {
                display: none;
            }
        }
        
        .btn-print {
            background: #2d3b4e;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
            cursor: pointer;
            border: none;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()" class="btn-print">Cetak Laporan</button>
        <a href="transaksi.php" style="text-decoration: none; color: #555; margin-left: 10px;">Kembali</a>
    </div>

    <h2>LAPORAN PEMINJAMAN BUKU</h2>
    <h4>PERPUSTAKAAN DIGITAL</h4>
    <hr>
    <small>Dicetak pada tanggal: <?= date('d-m-Y'); ?></small>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_assoc($query)) : 
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['full_name']; ?></td>
                <td><?= $row['title']; ?></td>
                <td><?= date('d-m-Y', strtotime($row['loan_date'])); ?></td>
                <td><?= date('d-m-Y', strtotime($row['due_date'])); ?></td>
                <td>
                    <?= ($row['return_date']) ? date('d-m-Y', strtotime($row['return_date'])) : '-'; ?>
                </td>
                <td>
                    <?php 
                    if($row['status'] == 'returned') echo "<span class='status-kembali'>Dikembalikan</span>";
                    elseif($row['status'] == 'borrowed') echo "<span class='status-pinjam'>Dipinjam</span>";
                    else echo "Booking";
                    ?>
                </td>
                <td>
                    <?php 
                    if($row['denda'] > 0){
                        echo "<span class='status-denda'>Rp " . number_format($row['denda']) . "</span>";
                    } else {
                        echo "-";
                    }
                    ?>
                </td>
            </tr>
            <?php 
                endwhile; 
            } else {
                echo "<tr><td colspan='8' style='text-align:center;'>Belum ada data transaksi.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>