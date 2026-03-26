<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../config/koneksi.php';

$result = mysqli_query($koneksi, "SELECT * FROM riwayat_diagnosa ORDER BY tgl_diagnosa DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Diagnosa - ExpertPanel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div style="display: flex; min-height: 100vh;">
        <aside style="width: 260px; background: var(--bg-card); padding: 2rem; border-right: 1px solid var(--glass-border);">
           <h3 class="text-gradient">ExpertPanel</h3>
            <nav style="margin-top: 2rem;">
                <a href="index.php" style="display: block; padding: 0.75rem 1rem; color: var(--text-muted); text-decoration: none;">Dashboard</a>
                <a href="penyakit.php" style="display: block; padding: 0.75rem 1rem; color: var(--text-muted); text-decoration: none;">Data Penyakit</a>
                <a href="gejala.php" style="display: block; padding: 0.75rem 1rem; color: var(--text-muted); text-decoration: none;">Data Gejala</a>
                <a href="rule.php" style="display: block; padding: 0.75rem 1rem; color: var(--text-muted); text-decoration: none;">Basis Pengetahuan</a>
                <a href="riwayat.php" style="display: block; padding: 0.75rem 1rem; color: var(--primary-color); text-decoration: none; background: rgba(99, 102, 241, 0.1); border-radius: 0.75rem;">Riwayat Diagnosa</a>
            </nav>
        </aside>

        <main style="flex: 1; padding: 2rem;">
            <h1>Riwayat <span class="text-gradient">Diagnosa User</span></h1>
            <div class="glass-card" style="margin-top: 2rem;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; color: var(--text-muted); font-size: 0.8rem;">
                            <th style="padding: 1rem; border-bottom: 1px solid var(--glass-border);">TANGGAL</th>
                            <th style="padding: 1rem; border-bottom: 1px solid var(--glass-border);">NAMA</th>
                            <th style="padding: 1rem; border-bottom: 1px solid var(--glass-border);">HASIL</th>
                            <th style="padding: 1rem; border-bottom: 1px solid var(--glass-border);">KEPERCAYAAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td style="padding: 1rem; border-bottom: 1px solid var(--glass-border);"><?= $row['tgl_diagnosa'] ?></td>
                            <td style="padding: 1rem; border-bottom: 1px solid var(--glass-border);"><?= $row['nama_pengguna'] ?></td>
                            <td style="padding: 1rem; border-bottom: 1px solid var(--glass-border);"><?= $row['hasil_diagnosa'] ?></td>
                            <td style="padding: 1rem; border-bottom: 1px solid var(--glass-border);"><?= number_format($row['nilai_densitas'] * 100, 2) ?>%</td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
