<?php
session_start();
require 'koneksi.php'; // Koneksi ke database
require 'auth.php'; // Memuat fungsi autentikasi

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit;
}

$id_user = $_SESSION['id_user']; // Ambil ID user dari session

// Cek apakah ID tugas ada di URL
if (!isset($_GET['id_tugas'])) {
    header('Location: dashboard.php'); // Redirect ke dashboard jika ID tugas tidak ada
    exit;
}

$id_tugas = $_GET['id_tugas']; // Ambil ID tugas dari URL

// Ambil data tugas dari database untuk user yang sedang login
$query = "SELECT * FROM tugas WHERE id_tugas = ? AND id_user = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('ii', $id_tugas, $id_user);
$stmt->execute();
$result = $stmt->get_result();
$tugas = $result->fetch_assoc();

// Jika tugas tidak ditemukan atau bukan milik user, redirect ke dashboard
if (!$tugas) {
    header('Location: dashboard.php');
    exit;
}

// Proses update tugas jika form dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_tugas'])) {
    $nama_tugas = trim($_POST['nama_tugas']);
    $deskripsi = trim($_POST['deskripsi']);
    $tanggal_deadline = trim($_POST['tanggal_deadline']);
    $status = trim($_POST['status_tugas']); // Ambil status dari form

    if (!empty($nama_tugas) && !empty($tanggal_deadline)) {
        $update_query = "UPDATE tugas SET nama_tugas = ?, deskripsi = ?, tanggal_deadline = ?, status_tugas = ? WHERE id_tugas = ? AND id_user = ?";
        $update_stmt = $koneksi->prepare($update_query);
        $update_stmt->bind_param('ssssii', $nama_tugas, $deskripsi, $tanggal_deadline, $status, $id_tugas, $id_user);

        if ($update_stmt->execute()) {
            header('Location: dashboard.php?status=edit_berhasil');
            exit;
        } 

        } else {
            $error = "Gagal memperbarui tugas.";
        }
    } else {
        $error = "Nama tugas dan tanggal deadline wajib diisi.";
    }

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Edit Tugas</h1>

        <!-- <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?> -->

        <!-- Form Edit Tugas -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_tugas">Nama Tugas</label>
                <input type="text" id="nama_tugas" name="nama_tugas" value="<?php echo htmlspecialchars($tugas['nama_tugas']); ?>" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"><?php echo htmlspecialchars($tugas['deskripsi']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="tanggal_deadline">Tanggal Deadline</label>
                <input type="date" id="tanggal_deadline" name="tanggal_deadline" value="<?php echo htmlspecialchars(date('Y-m-d', strtotime($tugas['tanggal_deadline']))); ?>" required>
            </div>
            <div class="form-group">
                <label for="status_tugas">Status</label>
                <select id="status_tugas" name="status_tugas" required>
                    <option value="belum" <?php echo ($tugas['status_tugas'] === 'belum') ? 'selected' : ''; ?>>Belum</option>
                    <option value="selesai" <?php echo ($tugas['status_tugas'] === 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                </select>
            </div>
            <button type="submit" name="update_tugas" class="btn">Simpan Perubahan</button>
            <a href="dashboard.php" class="btn">Batal</a>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>