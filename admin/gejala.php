<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../config/koneksi.php';

$message = "";

// Handle Delete
if (isset($_GET['delete'])) {
    $kode = $_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM gejala WHERE kode_gejala = '$kode'");
    $message = "Gejala berhasil dihapus!";
}

// Handle Add/Edit
if (isset($_POST['save'])) {
    $kode = $_POST['kode_gejala'];
    $nama = $_POST['nama_gejala'];

    $check = mysqli_query($koneksi, "SELECT * FROM gejala WHERE kode_gejala = '$kode'");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($koneksi, "UPDATE gejala SET nama_gejala='$nama' WHERE kode_gejala='$kode'");
        $message = "Gejala berhasil diupdate!";
    } else {
        mysqli_query($koneksi, "INSERT INTO gejala VALUES ('$kode', '$nama')");
        $message = "Gejala berhasil ditambahkan!";
    }
}

$edit_data = null;
if (isset($_GET['edit'])) {
    $kode = $_GET['edit'];
    $edit_data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM gejala WHERE kode_gejala = '$kode'"));
}

$result = mysqli_query($koneksi, "SELECT * FROM gejala ORDER BY kode_gejala ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Gejala - ExpertPanel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: var(--bg-card); border-right: 1px solid var(--glass-border); padding: 2rem; }
        .main-content { flex: 1; padding: 2rem; }
        .nav-link { display: block; padding: 0.75rem 1rem; color: var(--text-muted); text-decoration: none; border-radius: 0.75rem; margin-bottom: 0.5rem; }
        .nav-link.active { background: rgba(99, 102, 241, 0.1); color: var(--primary-color); }
        
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid var(--glass-border); }
        th { color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 3fr; gap: 1rem; }
        input { width: 100%; padding: 0.75rem; background: rgba(255, 255, 255, 0.05); border: 1px solid var(--glass-border); border-radius: 0.5rem; color: white; }
        .badge-delete { color: #ef4444; text-decoration: none; font-size: 0.8rem; margin-left: 10px; }
        .badge-edit { color: var(--accent); text-decoration: none; font-size: 0.8rem; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <h3 class="text-gradient">ExpertPanel</h3>
            <nav style="margin-top: 2rem;">
                <a href="index.php" class="nav-link">Dashboard</a>
                <a href="penyakit.php" class="nav-link">Data Penyakit</a>
                <a href="gejala.php" class="nav-link active">Data Gejala</a>
                <a href="rule.php" class="nav-link">Basis Pengetahuan</a>
                <a href="riwayat.php" class="nav-link">Riwayat Diagnosa</a>
            </nav>
        </aside>

        <main class="main-content">
            <h1>Kelola <span class="text-gradient">Data Gejala</span></h1>
            
            <?php if($message): ?>
                <div class="glass-card" style="padding: 1rem; margin-bottom: 1rem; border-color: var(--primary-color);"><?= $message ?></div>
            <?php endif; ?>

            <div class="glass-card" style="margin-bottom: 2rem;">
                <h3><?= $edit_data ? 'Edit' : 'Tambah' ?> Gejala</h3>
                <form action="" method="POST" style="margin-top: 1rem;">
                    <div class="form-grid">
                        <div>
                            <label style="display:block; margin-bottom:5px;">Kode</label>
                            <input type="text" name="kode_gejala" value="<?= $edit_data ? $edit_data['kode_gejala'] : '' ?>" required placeholder="G01">
                        </div>
                        <div>
                            <label style="display:block; margin-bottom:5px;">Nama Gejala</label>
                            <input type="text" name="nama_gejala" value="<?= $edit_data ? $edit_data['nama_gejala'] : '' ?>" required placeholder="Kesulitan tidur...">
                        </div>
                    </div>
                    <button type="submit" name="save" class="btn" style="margin-top: 1rem;">Simpan Gejala</button>
                    <?php if($edit_data): ?>
                        <a href="gejala.php" class="btn btn-secondary">Batal</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="glass-card">
                <h3>Daftar Gejala</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Gejala</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['kode_gejala'] ?></td>
                            <td><?= $row['nama_gejala'] ?></td>
                            <td>
                                <a href="?edit=<?= $row['kode_gejala'] ?>" class="badge-edit">Edit</a>
                                <a href="?delete=<?= $row['kode_gejala'] ?>" class="badge-delete" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
