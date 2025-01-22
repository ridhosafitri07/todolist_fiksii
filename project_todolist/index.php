<?php
session_start();
// Jika pengguna sudah login, redirect ke dashboard
if (isset($_SESSION['id_user'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <h2>Manajemen Waktu yang Lebih Baik Dimulai dari Sini</h2>
        <p>Nikmati kemudahan mengatur jadwal dan tugas Anda. Bersiaplah untuk mencapai lebih banyak setiap hari. Masuk atau daftar untuk memulai perjalanan Anda!</p>
        <div class="buttons">
            <a href="login.php" class="btn-masuk">Masuk</a>
            <a href="register.php" class="btn-daftar">Daftar</a>
        </div>
        <div class="footer">
            <p>&copy; 2025 To-Do List App.</p>
        </div>
    </div>
    
</body>
</html>