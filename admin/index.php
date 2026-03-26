<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../config/koneksi.php';

// Get counts for dashboard
$jml_penyakit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM penyakit"))['total'];
$jml_gejala = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM gejala"))['total'];
$jml_riwayat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM riwayat_diagnosa"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Insomnia Expert</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--glass-border);
            padding: 2rem;
            position: sticky;
            top: 0;
            height: 100vh;
        }
        .main-content {
            flex: 1;
            padding: 2rem;
        }
        .nav-link {
            display: block;
            padding: 0.75rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 0.75rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .stat-card {
            padding: 1.5rem;
            text-align: center;
        }
        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }
        .logout-btn {
            margin-top: auto;
            color: #ef4444;
            padding: 0.75rem 1rem;
            text-decoration: none;
            display: block;
            border-radius: 0.75rem;
        }
        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <h3 class="text-gradient">ExpertPanel</h3>
            <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 2rem;">Logged in as: <?= $_SESSION['nama_admin'] ?></p>
            
            <nav>
                <a href="index.php" class="nav-link active">Dashboard</a>
                <a href="penyakit.php" class="nav-link">Data Penyakit</a>
                <a href="gejala.php" class="nav-link">Data Gejala</a>
                <a href="rule.php" class="nav-link">Basis Pengetahuan</a>
                <a href="riwayat.php" class="nav-link">Riwayat Diagnosa</a>
            </nav>

            <div style="margin-top: 5rem;">
                <a href="logout.php" class="logout-btn">Keluar Sistem</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="animate-fade-in">
                <h1>Dashboard <span class="text-gradient">Overview</span></h1>
                <p style="color: var(--text-muted);">Selamat datang kembali, Pakar Insomnia.</p>
            </header>

            <div class="stats-grid animate-fade-in" style="animation-delay: 0.2s;">
                <div class="glass-card stat-card">
                    <p style="color: var(--text-muted);">Total Jenis Insomnia</p>
                    <div class="stat-value text-gradient"><?= $jml_penyakit ?></div>
                </div>
                <div class="glass-card stat-card">
                    <p style="color: var(--text-muted);">Total Gejala</p>
                    <div class="stat-value text-gradient"><?= $jml_gejala ?></div>
                </div>
                <div class="glass-card stat-card">
                    <p style="color: var(--text-muted);">Total Diagnosa</p>
                    <div class="stat-value text-gradient"><?= $jml_riwayat ?></div>
                </div>
            </div>

            <div class="glass-card animate-fade-in" style="margin-top: 2rem; animation-delay: 0.4s;">
                <h3>Petunjuk Penggunaan</h3>
                <ul style="color: var(--text-muted); padding-left: 1.2rem;">
                    <li>Gunakan menu <b>Data Penyakit</b> untuk menambah/mengubah jenis insomnia.</li>
                    <li>Gunakan menu <b>Data Gejala</b> untuk mengelola gejala klinis.</li>
                    <li>Gunakan menu <b>Basis Pengetahuan</b> untuk mengatur nilai Densitas (Belief) antara gejala dan penyakit.</li>
                    <li>Nilai Densitas harus berada di rentang 0 sampai 1.</li>
                </ul>
            </div>
        </main>
    </div>
</body>
</html>
