<?php
session_start();
if (!isset($_SESSION['hasil'])) {
    header("Location: diagnosa.php");
    exit;
}
$hasil = $_SESSION['hasil'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosa - Insomnia Expert</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container animate-fade-in" style="max-width: 900px; padding-top: 4rem;">
        <header style="text-align: center; margin-bottom: 3rem;">
            <h1 class="text-gradient">Hasil Diagnosa</h1>
            <p style="color: var(--text-muted);">Berdasarkan analisis gejala yang Anda berikan</p>
        </header>

        <div class="glass-card" style="margin-bottom: 2rem; border-color: var(--primary-color);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
                <div>
                    <h4 style="color: var(--text-muted); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Pasien</h4>
                    <h2 style="margin: 0;"><?= $hasil['nama'] ?></h2>
                </div>
                <div style="text-align: right;">
                    <h4 style="color: var(--text-muted); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Tingkat Keyakinan</h4>
                    <h2 class="text-gradient" style="margin: 0; font-size: 2.5rem;"><?= number_format($hasil['confidence'] * 100, 2) ?>%</h2>
                </div>
            </div>

            <div style="padding: 1.5rem; background: rgba(99, 102, 241, 0.1); border-radius: 1rem; border: 1px solid rgba(99, 102, 241, 0.2); margin-bottom: 2rem;">
                <h3 style="margin-bottom: 0.5rem;">Terdiagnosa: <span class="text-gradient"><?= $hasil['penyakit']['nama_penyakit'] ?></span></h3>
                <p style="color: var(--text-main);"><?= $hasil['penyakit']['keterangan'] ?></p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <h4 style="color: var(--accent); margin-bottom: 10px;">Gejala yang Dialami:</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem;"><?= $hasil['gejala'] ?></p>
                </div>
                <div>
                    <h4 style="color: var(--accent); margin-bottom: 10px;">Solusi Rekomendasi:</h4>
                    <p style="color: var(--text-main); font-size: 0.9rem; border-left: 3px solid var(--accent); padding-left: 1rem;"><?= $hasil['penyakit']['solusi'] ?></p>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 3rem; display: flex; gap: 1rem; justify-content: center;">
            <a href="diagnosa.php" class="btn">Konsultasi Ulang</a>
            <button onclick="window.print()" class="btn btn-secondary">Cetak Hasil</button>
            <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
