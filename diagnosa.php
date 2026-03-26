<?php
include 'config/koneksi.php';
$gejala = mysqli_query($koneksi, "SELECT * FROM gejala ORDER BY kode_gejala ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulai Diagnosa - Insomnia Expert</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .symptom-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.03);
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid transparent;
        }
        .symptom-item:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: var(--glass-border);
        }
        .symptom-item input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 1.5rem;
            accent-color: var(--primary-color);
        }
        .symptom-item span {
            font-size: 1.05rem;
        }
    </style>
</head>
<body>
    <nav class="container" style="padding: 2rem 0;">
        <a href="index.php" style="color: var(--text-muted); text-decoration: none;">&larr; Kembali ke Beranda</a>
    </nav>

    <main class="container animate-fade-in" style="max-width: 800px;">
        <header style="margin-bottom: 3rem; text-align: center;">
            <h1 class="text-gradient">Konsultasi Gejala</h1>
            <p style="color: var(--text-muted);">Silakan pilih gejala yang Anda rasakan selama beberapa hari terakhir.</p>
        </header>

        <div class="glass-card">
            <form action="proses_diagnosa.php" method="POST">
                <div style="margin-bottom: 2rem;">
                    <label style="display: block; margin-bottom: 10px; color: var(--text-muted); font-size: 0.9rem;">Nama Lengkap</label>
                    <input type="text" name="nama_user" required placeholder="Masukkan nama Anda" style="width: 100%; padding: 1rem; background: rgba(255, 255, 255, 0.05); border: 1px solid var(--glass-border); border-radius: 0.75rem; color: white;">
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; margin-bottom: 15px; color: var(--text-muted); font-size: 0.9rem;">Pilih Gejala yang Dialami:</label>
                    <?php while($row = mysqli_fetch_assoc($gejala)): ?>
                    <label class="symptom-item">
                        <input type="checkbox" name="gejala[]" value="<?= $row['kode_gejala'] ?>">
                        <span><?= $row['nama_gejala'] ?></span>
                    </label>
                    <?php endwhile; ?>
                </div>

                <button type="submit" class="btn" style="width: 100%; padding: 1.2rem; font-size: 1.1rem; box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);">Proses Diagnosa</button>
            </form>
        </div>
    </main>
</body>
</html>
