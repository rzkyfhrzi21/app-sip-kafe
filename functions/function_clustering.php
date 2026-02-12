<?php
// =====================================================
// function_clustering.php (TANPA CRON JOB VERSION)
// Controller proses clustering SIP Kafe
// 
// FIXED:
// - Gunakan SESSION untuk pesan error (bukan URL)
// - Perbaiki redirect yang terlalu panjang
// - Pastikan semua proses berjalan seperti sebelumnya
// =====================================================

session_start();
require_once '../config/config.php';

// =====================================================
// HELPER FUNCTION: REDIRECT DENGAN SESSION
// =====================================================
function redirect_with_message($page, $status, $action, $ket, $msg = '') {
    $_SESSION['flash_status'] = $status;
    $_SESSION['flash_action'] = $action;
    $_SESSION['flash_ket'] = $ket;
    if (!empty($msg)) {
        $_SESSION['flash_msg'] = $msg;
    }
    header("Location: ../dashboard/admin?page=$page");
    exit;
}

// =====================================================
// TAHAP 0: VALIDASI REQUEST & BOBOT WSM
// =====================================================

// Cek apakah form di-submit
if (!isset($_POST['btn_mulai_clustering'])) {
    redirect_with_message('Mulai Clustering', 'error', 'clustering', 'invalid_request');
}

// =====================================================
// VALIDASI & AMBIL BOBOT WSM DARI FORM
// =====================================================

$bobot_rasa      = isset($_POST['bobot_rasa']) ? (float)$_POST['bobot_rasa'] : 0;
$bobot_pelayanan = isset($_POST['bobot_pelayanan']) ? (float)$_POST['bobot_pelayanan'] : 0;
$bobot_fasilitas = isset($_POST['bobot_fasilitas']) ? (float)$_POST['bobot_fasilitas'] : 0;
$bobot_suasana   = isset($_POST['bobot_suasana']) ? (float)$_POST['bobot_suasana'] : 0;
$bobot_harga     = isset($_POST['bobot_harga']) ? (float)$_POST['bobot_harga'] : 0;
$bobot_rating    = isset($_POST['bobot_rating']) ? (float)$_POST['bobot_rating'] : 0;

// Hitung total bobot (harus = 100%)
$total_bobot = $bobot_rasa + $bobot_pelayanan + $bobot_fasilitas +
    $bobot_suasana + $bobot_harga + $bobot_rating;

// Validasi total bobot
if ($total_bobot != 100) {
    redirect_with_message('Mulai Clustering', 'error', 'clustering', 'invalid_weight_total', 'Total bobot harus 100%');
}

// Konversi bobot ke desimal (0-1) untuk perhitungan WSM
$w_rasa      = $bobot_rasa / 100;
$w_pelayanan = $bobot_pelayanan / 100;
$w_fasilitas = $bobot_fasilitas / 100;
$w_suasana   = $bobot_suasana / 100;
$w_harga     = $bobot_harga / 100;
$w_rating    = $bobot_rating / 100;

// =====================================================
// VALIDASI FILE UPLOAD
// =====================================================

if (!isset($_FILES['dataset_csv']) || $_FILES['dataset_csv']['error'] !== 0) {
    redirect_with_message('Mulai Clustering', 'warning', 'clustering', 'file_missing');
}

// =====================================================
// TAHAP 1: SETUP & SIMPAN FILE DATASET
// =====================================================

$uploadDir = '../dashboard/assets/file_clustering/';

// Buat folder jika belum ada
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$originalName = basename($_FILES['dataset_csv']['name']);
$targetPath   = $uploadDir . $originalName;

// Upload file ke server
if (!move_uploaded_file($_FILES['dataset_csv']['tmp_name'], $targetPath)) {
    redirect_with_message('Mulai Clustering', 'error', 'clustering', 'upload_failed');
}

// =====================================================
// TAHAP 2: BUKA FILE CSV
// =====================================================

$handle = fopen($targetPath, 'r');
if (!$handle) {
    redirect_with_message('Mulai Clustering', 'error', 'clustering', 'file_unreadable');
}

// =====================================================
// TAHAP 3: VALIDASI HEADER CSV
// =====================================================

$expectedHeader = [
    'Nama Kafe',
    'Skor_Rasa',
    'Skor_Pelayanan',
    'Skor_Fasilitas',
    'Skor_Suasana',
    'Skor_Harga',
    'Skor_Rating'
];

// Ambil baris pertama untuk deteksi delimiter
$firstLine = fgets($handle);

// AUTO DETECT DELIMITER
$delimiters = [
    ';'  => substr_count($firstLine, ';'),
    ','  => substr_count($firstLine, ','),
    "\t" => substr_count($firstLine, "\t")
];

$delimiter = array_search(max($delimiters), $delimiters);
if (!$delimiter) {
    $delimiter = ';';
}

// Reset pointer file ke awal
rewind($handle);

// Ambil header CSV sesuai delimiter
$csvHeader = fgetcsv($handle, 1000, $delimiter);

// Normalisasi header
$csvHeaderNormalized = array_map(
    fn($h) => strtolower(trim(preg_replace('/^\xEF\xBB\xBF/', '', $h))),
    $csvHeader
);

$expectedHeaderNormalized = array_map(
    fn($h) => strtolower(trim($h)),
    $expectedHeader
);

// Validasi jumlah kolom
if (count($csvHeaderNormalized) !== count($expectedHeaderNormalized)) {
    fclose($handle);
    redirect_with_message('Mulai Clustering', 'warning', 'clustering', 'invalid_column_count');
}

// Validasi isi & urutan header
if ($csvHeaderNormalized !== $expectedHeaderNormalized) {
    fclose($handle);
    redirect_with_message('Mulai Clustering', 'warning', 'clustering', 'invalid_header');
}

// =====================================================
// TAHAP 3.1: RENAME FILE DATASET
// =====================================================

fclose($handle);

$finalFileName = date('Y-m-d_H-i-s') . '_Clustering_SIP_Kafe_Balam.csv';
$finalPath     = $uploadDir . $finalFileName;

rename($targetPath, $finalPath);
$targetPath = $finalPath;

// Buka ulang file CSV yang sudah di-rename
$handle = fopen($targetPath, 'r');
fgetcsv($handle, 1000, $delimiter); // Lewati header

// =====================================================
// TAHAP 3.2: RESET DATA HASIL
// =====================================================

mysqli_query($koneksi, "SET FOREIGN_KEY_CHECKS=0");
mysqli_query($koneksi, "TRUNCATE TABLE hasil_clustering");
mysqli_query($koneksi, "TRUNCATE TABLE hasil_kuisioner");
mysqli_query($koneksi, "SET FOREIGN_KEY_CHECKS=1");

// =====================================================
// TAHAP 4: IMPORT DATA CSV KE DATABASE + HITUNG WSM
// =====================================================

$jumlahData = 0;

while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {

    $nama_kafe = trim($row[0]);
    $rasa      = (float)$row[1];
    $pelayanan = (float)$row[2];
    $fasilitas = (float)$row[3];
    $suasana   = (float)$row[4];
    $harga     = (float)$row[5];
    $rating    = (float)$row[6];

    // HITUNG NILAI WSM
    $nilai_wsm = ($w_rasa * $rasa) +
        ($w_pelayanan * $pelayanan) +
        ($w_fasilitas * $fasilitas) +
        ($w_suasana * $suasana) +
        ($w_harga * $harga) +
        ($w_rating * $rating);

    $nilai_wsm_normalized = round($nilai_wsm, 2);

    // CEK APAKAH KAFE SUDAH ADA
    $nama_kafe_db = mysqli_real_escape_string($koneksi, $nama_kafe);

    $cek = mysqli_query(
        $koneksi,
        "SELECT id_kafe FROM kafe 
         WHERE LOWER(nama_kafe) = LOWER('$nama_kafe_db')"
    );

    if (mysqli_num_rows($cek) > 0) {
        $data    = mysqli_fetch_assoc($cek);
        $id_kafe = $data['id_kafe'];
    } else {
        mysqli_query(
            $koneksi,
            "INSERT INTO kafe 
            (nama_kafe, alamat, harga_terendah, harga_tertinggi, foto_kafe)
            VALUES
            ('" . mysqli_real_escape_string($koneksi, ucwords(strtolower($nama_kafe))) . "',
             'Belum diisi', 1, 1, 'default.jpg')"
        );
        $id_kafe = mysqli_insert_id($koneksi);
    }

    // INSERT HASIL KUISIONER + NILAI WSM
    mysqli_query(
        $koneksi,
        "INSERT INTO hasil_kuisioner
        (id_kafe, rasa_kopi, pelayanan, fasilitas, suasana, harga, rating, nilai_wsm)
        VALUES
        ($id_kafe, $rasa, $pelayanan, $fasilitas, $suasana, $harga, $rating, $nilai_wsm_normalized)"
    );

    $jumlahData++;
}

fclose($handle);

// =====================================================
// TAHAP 5: INSERT RECORD CLUSTERING KE DATABASE
// =====================================================

$ins = mysqli_query(
    $koneksi,
    "INSERT INTO clustering
    (nama_file, jumlah_cluster, jumlah_data, waktu_clustering)
    VALUES
    ('" . mysqli_real_escape_string($koneksi, $finalFileName) . "',
     3,
     $jumlahData,
     NOW())"
);

if (!$ins) {
    redirect_with_message('Mulai Clustering', 'error', 'clustering', 'insert_clustering_failed');
}

$idClusterBaru = mysqli_insert_id($koneksi);

// =====================================================
// TAHAP 6: JALANKAN K-MEANS CLUSTERING
// =====================================================

$phpPath    = "C:\\xampp\\php\\php.exe"; // Sesuaikan path PHP Anda
$scriptPath = realpath('../ml/kmeans.php');
$csvPath    = realpath($targetPath);

$command = "\"$phpPath\" \"$scriptPath\" \"$csvPath\" 2>&1";
exec($command, $output, $status);

if ($status !== 0) {
    $_SESSION['flash_msg'] = implode("\n", $output);
    redirect_with_message('Mulai Clustering', 'error', 'clustering', 'kmeans_error');
}

// =====================================================
// TAHAP 7: SIMPAN HASIL CLUSTERING
// =====================================================

$json   = implode("", $output);
$result = json_decode($json, true);

if (!isset($result['rows'])) {
    $_SESSION['flash_msg'] = $json;
    redirect_with_message('Mulai Clustering', 'error', 'clustering', 'invalid_kmeans_output');
}

// SIMPAN HASIL KE DATABASE
foreach ($result['rows'] as $row) {

    $nama_kafe_raw = trim($row['nama_kafe']);
    $nama_kafe_db  = mysqli_real_escape_string($koneksi, $nama_kafe_raw);

    $q = mysqli_query(
        $koneksi,
        "SELECT id_kafe FROM kafe
         WHERE LOWER(TRIM(nama_kafe)) = LOWER('$nama_kafe_db')
         LIMIT 1"
    );

    $d = mysqli_fetch_assoc($q);

    if (!$d) {
        mysqli_query(
            $koneksi,
            "INSERT INTO kafe (nama_kafe, alamat, harga_terendah, harga_tertinggi, foto_kafe)
             VALUES (
                '" . mysqli_real_escape_string($koneksi, ucwords(strtolower($nama_kafe_raw))) . "',
                'Belum diisi', 1, 1, 'default.jpg'
             )"
        );
        $id_kafe = mysqli_insert_id($koneksi);
    } else {
        $id_kafe = (int)$d['id_kafe'];
    }

    // HITUNG RATING AKHIR
    $q_rating = mysqli_query(
        $koneksi,
        "SELECT ROUND(AVG(rating), 2) as avg_rating
         FROM hasil_kuisioner
         WHERE id_kafe = $id_kafe"
    );

    $rating_data = mysqli_fetch_assoc($q_rating);
    $rating_akhir = $rating_data['avg_rating'] ?? 0;

    // INSERT HASIL CLUSTERING
    mysqli_query(
        $koneksi,
        "INSERT INTO hasil_clustering
        (id_cluster, id_kafe, cluster, jarak_centroid, peringkat_cluster, rating_akhir)
        VALUES
        (
            $idClusterBaru,
            $id_kafe,
            {$row['cluster']},
            {$row['jarak_centroid']},
            {$row['peringkat_cluster']},
            $rating_akhir
        )"
    );
}

// =====================================================
// TAHAP 8: LOG AKTIVITAS
// =====================================================

$log_message = "Clustering berhasil | File: $finalFileName | Data: $jumlahData | K=3 | Bobot: R=$bobot_rasa%, P=$bobot_pelayanan%, F=$bobot_fasilitas%, S=$bobot_suasana%, H=$bobot_harga%, RT=$bobot_rating%";

if (isset($_SESSION['sesi_id'])) {
    mysqli_query(
        $koneksi,
        "INSERT INTO log_aktivitas (id_admin, aktivitas, waktu)
         VALUES (
             {$_SESSION['sesi_id']},
             '" . mysqli_real_escape_string($koneksi, $log_message) . "',
             NOW()
         )"
    );
}

// =====================================================
// TAHAP 9: SELESAI - REDIRECT KE HALAMAN HASIL
// =====================================================

$_SESSION['flash_total'] = $jumlahData;
redirect_with_message('Hasil Clustering', 'success', 'clustering', 'process_completed');

// =====================================================
// END OF FILE
// =====================================================
