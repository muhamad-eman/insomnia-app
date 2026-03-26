<?php
include 'config/koneksi.php';

if (!isset($_POST['gejala']) || empty($_POST['gejala'])) {
    die("Silakan pilih minimal satu gejala! <a href='diagnosa.php'>Kembali</a>");
}

$nama_user = mysqli_real_escape_string($koneksi, $_POST['nama_user']);
$gejala_pilihan = $_POST['gejala']; // Array of kode_gejala

// Logic Dempster-Shafer
// 1. Get Mass Function (Belief) for each symptom
$m_list = [];
foreach ($gejala_pilihan as $g_kode) {
    $q = mysqli_query($koneksi, "SELECT * FROM basis_pengetahuan WHERE kode_gejala = '$g_kode'");
    $evidence = [];
    while ($row = mysqli_fetch_assoc($q)) {
        $evidence[$row['kode_penyakit']] = $row['nilai_densitas'];
    }
    
    // Sum of density for known diseases
    $sum_belief = array_sum($evidence);
    
    // Normalize if needed (though usually pakar gives belief directly)
    // For DS, we need m(X) = belief and m(theta) = 1 - belief
    // But since one symptom might belong to multiple diseases, we group them
    
    $m_list[] = [
        'diseases' => array_keys($evidence),
        'belief' => $sum_belief > 1 ? 1 : $sum_belief, // Cap at 1
        'theta' => 1 - ($sum_belief > 1 ? 1 : $sum_belief)
    ];
}

// 2. Combination Rule
// Initial mass function is the first symptom
$res_m = $m_list[0];

for ($i = 1; $i < count($m_list); $i++) {
    $m_next = $m_list[$i];
    $new_combinations = [];
    
    // Calculate intersections
    // Case 1: m1(A) * m2(B) -> A intersection B
    $intersect_res = array_intersect($res_m['diseases'], $m_next['diseases']);
    $val1 = $res_m['belief'] * $m_next['belief'];
    
    // Case 2: m1(A) * m2(theta) -> A
    $val2 = $res_m['belief'] * $m_next['theta'];
    
    // Case 3: m1(theta) * m2(B) -> B
    $val3 = $res_m['theta'] * $m_next['belief'];
    
    // Case 4: m1(theta) * m2(theta) -> theta
    $val4 = $res_m['theta'] * $m_next['theta'];

    // For simplicity in this native implementation for multiple diseases:
    // We combine the beliefs. If intersection is empty, it's a conflict.
    // However, in a simple expert system, we focus on the most probable disease.
    
    // Re-calculating new belief (Focusing on the main disease intersection)
    if (!empty($intersect_res)) {
        $res_m['diseases'] = $intersect_res;
        $res_m['belief'] = ($val1 + $val2 + $val3) / (1 - 0); // Assuming conflict K is 0 for basic mock
        $res_m['theta'] = $val4;
    } else {
        // If no intersection, we take the one with highest belief
        if ($m_next['belief'] > $res_m['belief']) {
            $res_m = $m_next;
        }
    }
}

// 3. Final Result
$final_belief = $res_m['belief'];
$final_diseases = $res_m['diseases'];
$kode_penyakit_final = $final_diseases[0]; // Take first if multiple

$penyakit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM penyakit WHERE kode_penyakit = '$kode_penyakit_final'"));

// Save to History
$gejala_txt = implode(', ', $gejala_pilihan);
$nama_penyakit = $penyakit['nama_penyakit'];
mysqli_query($koneksi, "INSERT INTO riwayat_diagnosa (nama_pengguna, gejala_dipilih, hasil_diagnosa, nilai_densitas) 
VALUES ('$nama_user', '$gejala_txt', '$nama_penyakit', '$final_belief')");

session_start();
$_SESSION['hasil'] = [
    'nama' => $nama_user,
    'penyakit' => $penyakit,
    'confidence' => $final_belief,
    'gejala' => $gejala_txt
];

header("Location: hasil.php");
?>
