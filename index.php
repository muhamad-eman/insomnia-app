<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar Insomnia - Dempster Shafer</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }
        .hero-content {
            max-width: 800px;
        }
        .hero h1 {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }
        .hero p {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
        }
        .features {
            padding: 5rem 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .feature-card i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: block;
        }
    </style>
</head>
<body>
    <nav class="container" style="display: flex; justify-content: space-between; align-items: center; padding: 2rem 0;">
        <div class="logo"><h3 class="text-gradient" style="font-weight: 800;">INSOMNIA.AI</h3></div>
        <div>
            <a href="admin/login.php" class="btn btn-secondary" style="margin-right: 1rem;">Login Admin</a>
            <a href="diagnosa.php" class="btn">Mulai Diagnosa</a>
        </div>
    </nav>

    <section class="hero animate-fade-in">
        <div class="hero-content">
            <span style="text-transform: uppercase; letter-spacing: 0.1em; color: var(--accent); font-weight: 600; font-size: 0.875rem;">Deep insight into your sleep</span>
            <h1 class="text-gradient">Diagnosa Gangguan Tidur Secara Cerdas</h1>
            <p>Gunakan teknologi Sistem Pakar berbasis metode <b>Dempster-Shafer</b> untuk menganalisis gejala insomnia Anda dengan tingkat akurasi yang terukur secara ilmiah.</p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="diagnosa.php" class="btn" style="padding: 1rem 2.5rem; font-size: 1.1rem;">Konsultasi Sekarang</a>
                <a href="#tentang" class="btn btn-secondary" style="padding: 1rem 2.5rem; font-size: 1.1rem;">Pelajari Metode</a>
            </div>
        </div>
    </section>

    <section id="tentang" class="container">
        <div class="glass-card animate-fade-in" style="margin-top: -5rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
                <div>
                    <h2 class="text-gradient">Apa itu Dempster-Shafer?</h2>
                    <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Metode Dempster-Shafer adalah teori matematika untuk pembuktian berdasarkan fungsi kepercayaan dan penalaran yang masuk akal, yang digunakan untuk mengkombinasikan potongan informasi yang terpisah (bukti) untuk mengkalkulasi kemungkinan dari suatu peristiwa.</p>
                    <p style="color: var(--text-muted);">Dalam sistem ini, setiap gejala yang Anda pilih memiliki nilai densitas (keyakinan pakar) yang akan dikompositkan untuk menghasilkan hasil diagnosa yang paling relevan.</p>
                </div>
                <div style="background: rgba(255,255,255,0.03); padding: 2rem; border-radius: 1rem; border: 1px dashed var(--glass-border);">
                    <ul style="list-style: none;">
                        <li style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                            <span style="color: var(--accent);">✔</span> Akurasi berbasis data pakar
                        </li>
                         <li style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                            <span style="color: var(--accent);">✔</span> Perhitungan matematis transparan
                        </li>
                         <li style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                            <span style="color: var(--accent);">✔</span> Rekomendasi solusi instan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <footer class="container" style="text-align: center; padding: 4rem 0; color: var(--text-muted); font-size: 0.875rem;">
        <p>&copy; 2024 Insomnia Expert System - Built with PHP Native & Dempster-Shafer</p>
    </footer>
</body>
</html>
