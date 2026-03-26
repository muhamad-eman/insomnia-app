<?php
session_start();
include '../config/koneksi.php';

if (isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

$error = "";
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$username'");
    if (mysqli_num_rows($query) === 1) {
        $data = mysqli_fetch_assoc($query);
        if (password_verify($password, $data['password'])) {
            $_SESSION['admin'] = $data['username'];
            $_SESSION['nama_admin'] = $data['nama_lengkap'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Insomnia Expert</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-box {
            width: 100%;
            max-width: 400px;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-muted);
            font-size: 0.875rem;
        }
        input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 0.75rem;
            color: white;
            outline: none;
            transition: border-color 0.3s;
        }
        input:focus {
            border-color: var(--primary-color);
        }
        .error-msg {
            color: #ef4444;
            background: rgba(239, 68, 68, 0.1);
            padding: 0.75rem;
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box glass-card animate-fade-in">
            <h2 class="text-gradient" style="text-align: center;">Admin Login</h2>
            <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem;">Silakan masuk ke panel pakar</p>
            
            <?php if ($error): ?>
                <div class="error-msg"><?= $error ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required placeholder="admin">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                <button type="submit" name="login" class="btn" style="width: 100%;">Masuk Sekarang</button>
            </form>
            <div style="margin-top: 2rem; text-align: center;">
                <a href="../index.php" style="color: var(--text-muted); text-decoration: none; font-size: 0.875rem;">&larr; Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>
