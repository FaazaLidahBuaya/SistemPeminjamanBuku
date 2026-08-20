<!DOCTYPE html>
<html>
<head>
    <title>Login Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* CSS Khusus Login biar Minimalis */
        body {
            background-color: #16202c;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-card {
            background: #1e293b;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 350px; /* Ukuran Minimalis */
            text-align: center;
            border: 1px solid #334155;
        }
        .login-header { margin-bottom: 30px; }
        .login-header i { font-size: 40px; color: #fbbf24; margin-bottom: 10px; }
        .login-header h2 { color: white; font-size: 24px; }
        .login-header p { color: #8b95a5; font-size: 14px; }
        
        .input-group { margin-bottom: 20px; text-align: left; }
        .input-group label { color: #cbd5e1; font-size: 13px; display: block; margin-bottom: 5px; }
        .input-group input {
            width: 100%;
            background: #0f172a;
            border: 1px solid #334155;
            color: white;
            padding: 12px;
            border-radius: 8px;
            outline: none;
        }
        .input-group input:focus { border-color: #fbbf24; }
        
        .btn-full {
            width: 100%;
            padding: 12px;
            background: #fbbf24;
            color: #16202c;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-bottom: 10px; /* Jarak ke tombol tamu */
        }
        .btn-full:hover { background: #f59e0b; }

        /* --- TAMBAHAN STYLE TOMBOL TAMU --- */
        .btn-guest {
            display: block;
            width: 100%;
            padding: 12px;
            background: transparent;
            color: #fbbf24;
            border: 1px solid #fbbf24;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            transition: 0.3s;
            box-sizing: border-box; /* Agar padding tidak merusak lebar */
        }
        .btn-guest:hover {
            background: rgba(251, 191, 36, 0.1);
            color: #f59e0b;
        }
        
        .register-link { margin-top: 20px; font-size: 13px; color: #8b95a5; }
        .register-link a { color: #fbbf24; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

    <div class="login-card">
        
        <div class="login-header">
            <i class="fas fa-book-open"></i>
            <h2>Selamat Datang</h2>
            <p>Silakan login untuk melanjutkan</p>
        </div>

        <?php 
        if(isset($_GET['pesan'])){
            if($_GET['pesan'] == "gagal"){
                echo "<div style='background: #ef4444; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px;'>Username / Password salah!</div>";
            } else if($_GET['pesan'] == "logout"){
                echo "<div style='background: #10b981; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px;'>Berhasil Logout</div>";
            } else if($_GET['pesan'] == "belum_login"){
                echo "<div style='background: #f59e0b; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px;'>Anda harus login dulu</div>";
            } else if($_GET['pesan'] == "sukses_daftar"){
                echo "<div style='background: #10b981; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px;'>Pendaftaran Berhasil! Silakan Login.</div>";
            }
        }
        ?>

        <form action="cek_login.php" method="post">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required autocomplete="off">
            </div>
            
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-full">MASUK</button>
        </form>

        <a href="index.php" class="btn-guest">
            <i class="fas fa-user-secret"></i> MASUK SEBAGAI TAMU
        </a>

        <div class="register-link">
            Belum punya akun? <a href="register.php">Daftar sekarang</a>
        </div>
    </div>

</body>
</html>