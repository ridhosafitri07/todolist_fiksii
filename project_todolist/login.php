<?php
session_start();
require 'koneksi.php'; // Koneksi ke database
require 'auth.php'; // Memuat fungsi autentikasi

// Cek jika user sudah login
if (isset($_SESSION['id_user'])) {
    header('Location: dashboard.php'); // Redirect ke dashboard jika sudah login
    exit;
}

// Inisialisasi variabel untuk pesan error
$error = "";

// Proses form login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        if (login($email, $password)) {
            // Jika login berhasil, arahkan ke dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Email atau password salah!";
        }
    } else {
        $error = "Semua kolom wajib diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
        </div>
        <button type="submit" class="btn">Masuk</button>
    </form>
    <div class="link">
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</div>

</body>
</html>