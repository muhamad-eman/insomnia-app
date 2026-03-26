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
    $id = $_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM basis_pengetahuan WHERE id_rule = '$id'");
    $message = "Basis pengetahuan berhasil dihapus!";
}

// Handle Add
if (isset($_POST['save'])) {
    $penyakit = $_POST['kode_penyakit'];
    $gejala = $_POST['kode_gejala'];
    $densitas = $_POST['nilai_densitas'];

    mysqli_query($koneksi, "INSERT INTO basis_pengetahuan (kode_penyakit, kode_gejala, nilai_densitas) VALUES ('$penyakit', '$gejala', '$densitas')");
    $message = "Basis pengetahuan berhasil ditambahkan!";
}

$result = mysqli_query($koneksi, "
    SELECT bp.id_rule, bp.nilai_densitas, p.nama_penyakit, g.nama_gejala 
    FROM basis_pengetahuan bp
    JOIN penyakit p ON bp.kode_penyakit = p.kode_penyakit
    JOIN gejala g ON bp.kode_gejala = g.kode_gejala
    ORDER BY p.kode_penyakit ASC
");

$penyakit_list = mysqli_query($koneksi, "SELECT * FROM penyakit");
$gejala_list = mysqli_query($koneksi, "SELECT * FROM gejala");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basis Pengetahuan - ExpertPanel</title>
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
        select, input { width: 100%; padding: 0.75rem; background: rgba(255, 255, 255, 0.05); border: 1px solid var(--glass-border); border-radius: 0.5rem; color: white; }
        option { background: var(--bg-dark); }
        .badge-delete { color: #ef4444; text-decoration: none; font-size: 0.8rem; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <h3 class="text-gradient">ExpertPanel</h3>
            <nav style="margin-top: 2rem;">
                <a href="index.php" class="nav-link">Dashboard</a>
                <a href="penyakit.php" class="nav-link">Data Penyakit</a>
                <a href="gejala.php" class="nav-link">Data Gejala</a>
                <a href="rule.php" class="nav-link active">Basis Pengetahuan</a>
                <a href="riwayat.php" class="nav-link">Riwayat Diagnosa</a>
            </nav>
        </aside>

        <main class="main-content">
            <h1>Kelola <span class="text-gradient">Basis Pengetahuan</span></h1>
            
            <?php if($message): ?>
                <div class="glass-card" style="padding: 1rem; margin-bottom: 1rem; border-color: var(--primary-color);"><?= $message ?></div>
            <?php endif; ?>

            <div class="glass-card" style="margin-bottom: 2rem;">
                <h3>Tambah Aturan (Rule)</h3>
                <form action="" method="POST" style="margin-top: 1rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display:block; margin-bottom:5px;">Pilih Penyakit</label>
                            <select name="kode_penyakit" required>
                                <?php while($p = mysqli_fetch_assoc($penyakit_list)): ?>
                                    <option value="<?= $p['kode_penyakit'] ?>"><?= $p['nama_penyakit'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <label style="display:block; margin-bottom:5px;">Pilih Gejala</label>
                            <select name="kode_gejala" required>
                                <?php while($g = mysqli_fetch_assoc($gejala_list)): ?>
                                    <option value="<?= $g['kode_gejala'] ?>"><?= $g['nama_gejala'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <label style="display:block; margin-bottom:5px;">Nilai Densitas (0-1)</label>
                            <input type="number" step="0.01" name="nilai_densitas" required placeholder="0.8">
                        </div>
                    </div>
                    <button type="submit" name="save" class="btn" style="margin-top: 1rem;">Hubungkan & Simpan</button>
                </form>
            </div>

            <div class="glass-card">
                <h3>Daftar Rule & Nilai Densitas</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Penyakit</th>
                            <th>Gejala</th>
                            <th>Densitas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['nama_penyakit'] ?></td>
                            <td><?= $row['nama_gejala'] ?></td>
                            <td><b class="text-gradient"><?= $row['nilai_densitas'] ?></b></td>
                            <td>
                                <a href="?delete=<?= $row['id_rule'] ?>" class="badge-delete" onclick="return confirm('Yakin hapus?')">Hapus</a>
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
