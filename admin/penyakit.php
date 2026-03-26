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
    mysqli_query($koneksi, "DELETE FROM penyakit WHERE kode_penyakit = '$kode'");
    $message = "Data berhasil dihapus!";
}

// Handle Add/Edit
if (isset($_POST['save'])) {
    $kode = $_POST['kode_penyakit'];
    $nama = $_POST['nama_penyakit'];
    $ket = $_POST['keterangan'];
    $solusi = $_POST['solusi'];

    $check = mysqli_query($koneksi, "SELECT * FROM penyakit WHERE kode_penyakit = '$kode'");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($koneksi, "UPDATE penyakit SET nama_penyakit='$nama', keterangan='$ket', solusi='$solusi' WHERE kode_penyakit='$kode'");
        $message = "Data berhasil diupdate!";
    } else {
        mysqli_query($koneksi, "INSERT INTO penyakit VALUES ('$kode', '$nama', '$ket', '$solusi')");
        $message = "Data berhasil ditambahkan!";
    }
}

$edit_data = null;
if (isset($_GET['edit'])) {
    $kode = $_GET['edit'];
    $edit_data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM penyakit WHERE kode_penyakit = '$kode'"));
}

$result = mysqli_query($koneksi, "SELECT * FROM penyakit ORDER BY kode_penyakit ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Penyakit - ExpertPanel</title>
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
        
        .form-card { margin-bottom: 2rem; }
        .form-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; }
        input, textarea { width: 100%; padding: 0.75rem; background: rgba(255, 255, 255, 0.05); border: 1px solid var(--glass-border); border-radius: 0.5rem; color: white; }
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
                <a href="penyakit.php" class="nav-link active">Data Penyakit</a>
                <a href="gejala.php" class="nav-link">Data Gejala</a>
                <a href="rule.php" class="nav-link">Basis Pengetahuan</a>
                <a href="riwayat.php" class="nav-link">Riwayat Diagnosa</a>
            </nav>
        </aside>

        <main class="main-content">
            <h1>Kelola <span class="text-gradient">Data Penyakit</span></h1>
            
            <?php if($message): ?>
                <div class="glass-card" style="padding: 1rem; margin-bottom: 1rem; border-color: var(--primary-color);"><?= $message ?></div>
            <?php endif; ?>

            <div class="glass-card form-card">
                <h3><?= $edit_data ? 'Edit' : 'Tambah' ?> Penyakit</h3>
                <form action="" method="POST" style="margin-top: 1rem;">
                    <div class="form-grid">
                        <div>
                            <label style="display:block; margin-bottom:5px;">Kode</label>
                            <input type="text" name="kode_penyakit" value="<?= $edit_data ? $edit_data['kode_penyakit'] : '' ?>" required placeholder="P01">
                        </div>
                        <div>
                            <label style="display:block; margin-bottom:5px;">Nama Penyakit</label>
                            <input type="text" name="nama_penyakit" value="<?= $edit_data ? $edit_data['nama_penyakit'] : '' ?>" required placeholder="Insomnia Akut">
                        </div>
                    </div>
                    <div style="margin-top: 1rem;">
                        <label style="display:block; margin-bottom:5px;">Keterangan</label>
                        <textarea name="keterangan" rows="3"><?= $edit_data ? $edit_data['keterangan'] : '' ?></textarea>
                    </div>
                    <div style="margin-top: 1rem;">
                        <label style="display:block; margin-bottom:5px;">Solusi / Penanganan</label>
                        <textarea name="solusi" rows="3"><?= $edit_data ? $edit_data['solusi'] : '' ?></textarea>
                    </div>
                    <button type="submit" name="save" class="btn" style="margin-top: 1rem;">Simpan Data</button>
                    <?php if($edit_data): ?>
                        <a href="penyakit.php" class="btn btn-secondary">Batal</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="glass-card">
                <h3>Daftar Penyakit</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Penyakit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['kode_penyakit'] ?></td>
                            <td><?= $row['nama_penyakit'] ?></td>
                            <td>
                                <a href="?edit=<?= $row['kode_penyakit'] ?>" class="badge-edit">Edit</a>
                                <a href="?delete=<?= $row['kode_penyakit'] ?>" class="badge-delete" onclick="return confirm('Yakin hapus?')">Hapus</a>
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
