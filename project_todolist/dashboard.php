<?php
session_start();
require 'koneksi.php'; // Koneksi ke database
require 'auth.php'; // Memuat fungsi autentikasi

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit;
}

// Ambil data user dari session
$id_user = $_SESSION['id_user'];
$nama_user = $_SESSION['nama'];

// Ambil tugas dari database untuk user yang sedang login
$query = "SELECT * FROM tugas WHERE id_user = ? ORDER BY tanggal_deadline ASC";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $id_user);
$stmt->execute();
$result = $stmt->get_result();
$tugas = $result->fetch_all(MYSQLI_ASSOC);
?>

<?php
$message = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        $message = 'Tugas berhasil ditambahkan.';
    } elseif ($_GET['status'] === 'deleted') {
        $message = 'Tugas berhasil dihapus.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>

    <!-- notifikasi berhasil add tugas dan notifikasi berhasil melakukan edit tugas-->
<?php if (isset($_GET['status'])): ?>
    <script>
        <?php if ($_GET['status'] === 'tambah_berhasil'): ?>
            alert('Tugas berhasil ditambahkan!');
        <?php elseif ($_GET['status'] === 'tambah_gagal'): ?>
            alert('Gagal menambahkan tugas. Silakan coba lagi.');
        <?php elseif ($_GET['status'] === 'edit_berhasil'): ?>
            alert('Tugas berhasil diperbarui!');
        <?php elseif ($_GET['status'] === 'edit_gagal'): ?>
            alert('Gagal memperbarui tugas. Silakan coba lagi.');
        <?php endif; ?>
    </script>
<?php endif; ?>

<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Selamat Datang, <?php echo htmlspecialchars($nama_user); ?></h1>
        <p>Kelola tugas Anda di bawah ini:</p>


        <form method="POST" action="add_tugas.php">
            <div class="form-group">
                <label for="nama_tugas">Nama Tugas</label>
                <input type="text" id="nama_tugas" name="nama_tugas" placeholder="Masukkan nama tugas" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi tugas"></textarea>
            </div>
            <div class="form-group">
                <label for="tanggal_deadline">Tanggal Deadline</label>
                <input type="date" id="tanggal_deadline" name="tanggal_deadline" required>
            </div>
            <button type="submit" name="tambah_tugas" class="btn btn-tambah">Tambah Tugas</button>
        </form>

        <!-- Daftar Tugas -->
        <h2>Daftar Tugas</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Tugas</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Deadline</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tugas)): ?>
                    <?php foreach ($tugas as $t): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($t['nama_tugas']); ?></td>
                            <td><?php echo htmlspecialchars($t['deskripsi']); ?></td>
                            <td><?php echo htmlspecialchars(date('d-m-Y',strtotime($t['tanggal_deadline']))); ?></td>
                            <td><?php echo htmlspecialchars($t['status_tugas']); ?></td>
                            <td>
                                <?php if ($t['status_tugas'] == 'belum'): ?>
                                    <a href="edit_tugas.php?id_tugas=<?php echo $t['id_tugas']; ?>" class="btn btn-edit">Edit</a>
                                <?php else: ?>
                                    <a href="edit_tugas.php?id_tugas=<?php echo $t['id_tugas']; ?>" class="btn btn-edit">Edit</a>
                                <?php endif; ?>
                                <!-- Form untuk hapus -->
                                <form method="POST" action="delete_tugas.php" style="display: inline;">
                                    <input type="hidden" name="hapus_id" value="<?php echo $t['id_tugas']; ?>">
                                    <button type="submit" class="btn btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada tugas</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
    </body>
    </html>