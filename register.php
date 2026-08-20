<!DOCTYPE html>
<html>
<head>
    <title>Daftar Akun</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #16202c;
            display: flex; justify-content: center; align-items: center; min-height: 100vh;
        }
        .login-card {
            background: #1e293b; padding: 30px; border-radius: 15px;
            width: 100%; max-width: 400px;
            border: 1px solid #334155;
        }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { color: white; margin-bottom: 5px; }
        .header p { color: #8b95a5; font-size: 13px; }
        
        .input-group { margin-bottom: 15px; }
        .input-group label { color: #cbd5e1; font-size: 12px; display: block; margin-bottom: 5px; }
        .input-group input, .input-group textarea {
            width: 100%; background: #0f172a; border: 1px solid #334155;
            color: white; padding: 10px; border-radius: 8px; outline: none;
            box-sizing: border-box; /* Agar padding tidak merusak lebar */
        }
        .input-group input:focus, .input-group textarea:focus { border-color: #fbbf24; }
        
        .btn-full {
            width: 100%; padding: 12px; background: #fbbf24; color: #16202c;
            border: none; border-radius: 8px; font-weight: bold; cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="header">
            <h2>Buat Akun Baru</h2>
            <p>Isi data diri kamu untuk mulai meminjam buku</p>
        </div>

        <form action="proses_register.php" method="post">
            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" name="full_name" required>
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label>No. Handphone</label>
                <input type="number" name="phone_number" placeholder="Contoh: 08xx..." required>
            </div>

            <div class="input-group">
                <label>Alamat Lengkap</label>
                <textarea name="address" required style="height: 80px; resize: none; font-family: sans-serif;"></textarea>
            </div>

            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" required autocomplete="off">
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn-full">DAFTAR SEKARANG</button>
            
            <div style="text-align: center; margin-top: 15px; font-size: 13px; color: #8b95a5;">
                Sudah punya akun? <a href="login.php" style="color: #fbbf24; text-decoration: none;">Login</a>
            </div>
        </form>
    </div>

</body>
</html>