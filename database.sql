CREATE DATABASE IF NOT EXISTS insomnia_ds;
USE insomnia_ds;

-- Table for Admin
CREATE TABLE IF NOT EXISTS admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL
);

-- Initial Admin (password: admin123)
INSERT INTO admin (username, password, nama_lengkap) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator Expert');

-- Table for Penyakit (Types of Insomnia)
CREATE TABLE IF NOT EXISTS penyakit (
    kode_penyakit VARCHAR(10) PRIMARY KEY,
    nama_penyakit VARCHAR(100) NOT NULL,
    keterangan TEXT,
    solusi TEXT
);

-- Table for Gejala (Symptoms)
CREATE TABLE IF NOT EXISTS gejala (
    kode_gejala VARCHAR(10) PRIMARY KEY,
    nama_gejala VARCHAR(255) NOT NULL
);

-- Table for Basis Pengetahuan (Knowledge Base)
CREATE TABLE IF NOT EXISTS basis_pengetahuan (
    id_rule INT AUTO_INCREMENT PRIMARY KEY,
    kode_penyakit VARCHAR(10),
    kode_gejala VARCHAR(10),
    nilai_densitas FLOAT,
    FOREIGN KEY (kode_penyakit) REFERENCES penyakit(kode_penyakit) ON DELETE CASCADE,
    FOREIGN KEY (kode_gejala) REFERENCES gejala(kode_gejala) ON DELETE CASCADE
);

-- Table for Riwayat Diagnosa (History)
CREATE TABLE IF NOT EXISTS riwayat_diagnosa (
    id_diagnosa INT AUTO_INCREMENT PRIMARY KEY,
    nama_pengguna VARCHAR(100),
    tgl_diagnosa TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    gejala_dipilih TEXT,
    hasil_diagnosa TEXT,
    nilai_densitas FLOAT
);

-- Dummy Data for Penyakit
INSERT INTO penyakit (kode_penyakit, nama_penyakit, keterangan, solusi) VALUES
('P01', 'Insomnia Akut', 'Gangguan tidur jangka pendek yang biasanya berlangsung selama beberapa hari atau minggu.', 'Relaksasi, menjaga jadwal tidur yang teratur, dan menghindari stres.'),
('P02', 'Insomnia Kronis', 'Gangguan tidur yang terjadi setidaknya 3 malam per minggu selama 3 bulan atau lebih.', 'Terapi perilaku kognitif (CBT-I), konsultasi medis, dan evaluasi gaya hidup.'),
('P03', 'Insomnia Onset', 'Kesulitan untuk memulai tidur di awal malam.', 'Hindari kafein di sore hari, batasi screen time sebelum tidur, dan teknik pernapasan.'),
('P04', 'Insomnia Maintenance', 'Ketidakmampuan untuk tetap tertidur selama malam hari atau bangun terlalu dini.', 'Pastikan lingkungan kamar gelap dan tenang, hindari alkohol sebelum tidur.');

-- Dummy Data for Gejala
INSERT INTO gejala (kode_gejala, nama_gejala) VALUES
('G01', 'Kesulitan memulai tidur pada malam hari'),
('G02', 'Sering terbangun pada malam hari'),
('G03', 'Bangun terlalu dini dan tidak bisa tidur lagi'),
('G04', 'Merasa tidak segar setelah tidur'),
('G05', 'Kantuk berlebihan di siang hari'),
('G06', 'Iritabilitas, depresi, atau kecemasan'),
('G07', 'Kesulitan memusatkan perhatian atau mengingat'),
('G08', 'Sakit kepala tegang atau gejala fisik lainnya'),
('G09', 'Kekhawatiran berkelanjutan tentang tidur');

-- Dummy Data for Rules (Mass Functions)
INSERT INTO basis_pengetahuan (kode_penyakit, kode_gejala, nilai_densitas) VALUES
('P01', 'G01', 0.8),
('P01', 'G06', 0.4),
('P02', 'G05', 0.9),
('P02', 'G07', 0.7),
('P03', 'G01', 0.85),
('P03', 'G09', 0.5),
('P04', 'G02', 0.8),
('P04', 'G03', 0.75);
