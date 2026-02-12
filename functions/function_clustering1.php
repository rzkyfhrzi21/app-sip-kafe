<?php
// =====================================================
// function_clustering.php
// Controller proses clustering SIP Kafe
// =====================================================

require_once '../config/config.php';

// =====================================================
// TAHAP 0: VALIDASI REQUEST
// =====================================================
if (!isset($_POST['btn_mulai_clustering'])) {
    header("Location: ../dashboard/admin?page=Mulai Clustering&status=error&action=clustering&ket=invalid_request");
    exit;
}

if (!isset($_FILES['dataset_csv']) || $_FILES['dataset_csv']['error'] !== 0) {
    header("Location: ../dashboard/admin?page=Mulai Clustering&status=warning&action=clustering&ket=file_missing");
    exit;
}

// =====================================================
// TAHAP 1: SETUP & SIMPAN FILE DATASET
// =====================================================
$uploadDir = '../dashboard/assets/file_clustering/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$originalName = basename($_FILES['dataset_csv']['name']);
$targetPath   = $uploadDir . $originalName;

if (!move_uploaded_file($_FILES['dataset_csv']['tmp_name'], $targetPath)) {
    header("Location: ../dashboard/admin?page=Mulai Clustering&status=error&action=clustering&ket=upload_failed");
    exit;
}

// =====================================================
// TAHAP 2: BUKA FILE CSV
// =====================================================
$handle = fopen($targetPath, 'r');
if (!$handle) {
    header("Location: ../dashboard/admin?page=Mulai Clustering&status=error&action=clustering&ket=file_unreadable");
    exit;
}

// =====================================================
// TAHAP 3: VALIDASI HEADER CSV (WAJIB SESUAI TEMPLATE)
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

// Ambil header CSV (BARIS PERTAMA)
$firstLine = fgets($handle);

// =====================================================
// AUTO DETECT DELIMITER ( ; , TAB )
// =====================================================
$delimiters = [
    ';'  => substr_count($firstLine, ';'),
    ','  => substr_count($firstLine, ','),
    "\t" => substr_count($firstLine, "\t")
];

// Ambil delimiter terbanyak
$delimiter = array_search(max($delimiters), $delimiters);

// Fallback default
if (!$delimiter) {
    $delimiter = ';';
}

rewind($handle);

// Ambil header CSV sesuai delimiter
$csvHeader = fgetcsv($handle, 1000, $delimiter);

// Normalisasi header (trim + lowercase)
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
    header("Location: ../dashboard/admin?page=Mulai Clustering&status=warning&action=clustering&ket=invalid_column_count");
    exit;
}

// Validasi isi & urutan header
if ($csvHeaderNormalized !== $expectedHeaderNormalized) {
    fclose($handle);
    header("Location: ../dashboard/admin?page=Mulai Clustering&status=warning&action=clustering&ket=invalid_header");
    exit;
}

// =====================================================
// TAHAP 3.1: RENAME FILE DATASET (SETELAH HEADER VALID)
// =====================================================

// Tutup file sementara
fclose($handle);

// Buat nama file resmi sesuai format sistem
$finalFileName = date('Y-m-d_H-i-s') . '_Clustering_SIP_Kafe_Balam.csv';
$finalPath     = $uploadDir . $finalFileName;

// Rename file
rename($targetPath, $finalPath);

// Update path file untuk proses selanjutnya
$targetPath = $finalPath;

// Buka ulang file CSV yang sudah di-rename
$handle = fopen($targetPath, 'r');

// Lewati header (karena sudah divalidasi)
fgetcsv($handle, 1000, $delimiter);

// Hapus BOM jika ada
$firstLine = preg_replace('/^\xEF\xBB\xBF/', '', $firstLine);

// =====================================================
// TAHAP 3.2: RESET DATA HASIL (TANPA HAPUS RIWAYAT)
// - kafe        : TIDAK DIHAPUS
// - clustering  : TIDAK DIHAPUS (riwayat)
// - hasil_*     : DIHAPUS SEMUA
// =====================================================

mysqli_query($koneksi, "SET FOREIGN_KEY_CHECKS=0");

mysqli_query($koneksi, "TRUNCATE TABLE hasil_clustering");
mysqli_query($koneksi, "TRUNCATE TABLE hasil_kuisioner");

mysqli_query($koneksi, "SET FOREIGN_KEY_CHECKS=1");


// =====================================================
// TAHAP 4: IMPORT DATA CSV KE DATABASE
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

    // ===============================
    // CEK DATA KAFE
    // ===============================
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
        // Insert kafe baru (default value)
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

    // ===============================
    // INSERT HASIL KUISIONER
    // ===============================
    mysqli_query(
        $koneksi,
        "INSERT INTO hasil_kuisioner
        (id_kafe, rasa_kopi, pelayanan, fasilitas, suasana, harga, rating)
        VALUES
        ($id_kafe, $rasa, $pelayanan, $fasilitas, $suasana, $harga, $rating)"
    );

    $jumlahData++;
}

fclose($handle);

// =====================================================
// TAHAP 5: INSERT RECORD CLUSTERING
// =====================================================
$namaFileClustering = $finalFileName;

$ins = mysqli_query(
    $koneksi,
    "INSERT INTO clustering
    (nama_file, jumlah_cluster, jumlah_data, waktu_clustering)
    VALUES
    ('" . mysqli_real_escape_string($koneksi, $namaFileClustering) . "',
     3,
     $jumlahData,
     NOW())"
);
if (!$ins) {
    header("Location: ../dashboard/admin?page=Mulai Clustering&status=error&action=clustering&ket=insert_clustering_failed");
    exit;
}

$idClusterBaru = mysqli_insert_id($koneksi);

// =====================================================
// TAHAP 6: JALANKAN PYTHON (MESIN ML)
// =====================================================
$pythonPath = "C:\\Python3117\\python.exe";
$scriptPath = realpath('../ml/kmeans.py');
$csvPath    = realpath($targetPath);

$command = "cmd /c \"\"$pythonPath\" \"$scriptPath\" \"$csvPath\" 2>&1\"";
exec($command, $output, $status);

if ($status !== 0) {
    header("Location: ../dashboard/admin?page=Mulai Clustering&status=error&action=clustering&ket=python_error");
    exit;
}

// =====================================================
// TAHAP 7: TERIMA OUTPUT JSON & SIMPAN HASIL CLUSTERING
// =====================================================
$json   = implode("", $output);
$result = json_decode($json, true);

if (!isset($result['rows'])) {
    header("Location: ../dashboard/admin?page=Mulai Clustering&status=error&action=clustering&ket=invalid_python_output");
    exit;
}

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

    // Jika kafe belum ada (ini penting!)
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

    // INSERT hasil clustering + rating akhir
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
            (
                SELECT ROUND(AVG(rating), 2)
                FROM hasil_kuisioner
                WHERE id_kafe = $id_kafe
            )
        )"
    );
}

// =====================================================
// TAHAP 8: SELESAI (REDIRECT SUCCESS)
// =====================================================
header("Location: ../dashboard/admin?page=Hasil Clustering&status=success&action=clustering&ket=process_completed");
exit;
