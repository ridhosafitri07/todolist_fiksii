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
$success = "";

// Proses form registrasi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $konfirmasi_password = trim($_POST['konfirmasi_password']);

    // Validasi input
    if (!empty($nama) && !empty($email) && !empty($username) && !empty($password) && !empty($konfirmasi_password)) {
        if ($password === $konfirmasi_password) {
            // Cek apakah email atau username sudah terdaftar
            $query = "SELECT * FROM users WHERE email = ? OR username = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param('ss', $email, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Email atau username sudah terdaftar!";
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Simpan data ke database
                $insert_query = "INSERT INTO users (nama, email, username, password) VALUES (?, ?, ?, ?)";
                $insert_stmt = $koneksi->prepare($insert_query);
                $insert_stmt->bind_param('ssss',$nama, $email, $username, $hashed_password);

                if ($insert_stmt->execute()) {
                    $success = "Registrasi berhasil! Silakan login.";
                } else {
                    $error = "Terjadi kesalahan saat menyimpan data.";
                }
            }
        } else {
            $error = "Password dan konfirmasi password tidak cocok!";
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
    <title>Registrasi</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>

<div class="register-container">
    <h2>Registrasi</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <p class="success"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan username Anda" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
        </div>
        <div class="form-group">
            <label for="konfirmasi_password">Konfirmasi Password</label>
            <input type="password" id="konfirmasi_password" name="konfirmasi_password" placeholder="Konfirmasi password Anda" required>
        </div>
        <button type="submit" class="btn">Daftar</button>
    </form>
    <div class="link">
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</div>

</body>
</html>