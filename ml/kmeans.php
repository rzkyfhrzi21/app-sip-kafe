<?php
// =====================================================
// kmeans.php - K-Means Clustering Engine
// Input: CSV dengan kolom Skor_* 
// Output: JSON dengan cluster, jarak, peringkat
// =====================================================

// Nonaktifkan semua output selain JSON
error_reporting(0);
ini_set('display_errors', 0);

// =====================================================
// TAHAP 1: VALIDASI ARGUMENT
// =====================================================

if ($argc < 2) {
    echo json_encode([
        "error" => "Path file CSV tidak ditemukan"
    ]);
    exit(1);
}

$csv_path = $argv[1];

if (!file_exists($csv_path)) {
    echo json_encode([
        "error" => "File CSV tidak ditemukan",
        "path" => $csv_path
    ]);
    exit(1);
}

// =====================================================
// TAHAP 2: LOAD CSV
// =====================================================

$handle = fopen($csv_path, 'r');
if (!$handle) {
    echo json_encode([
        "error" => "Gagal membuka file CSV"
    ]);
    exit(1);
}

// Deteksi delimiter
$firstLine = fgets($handle);
$delimiters = [
    ';'  => substr_count($firstLine, ';'),
    ','  => substr_count($firstLine, ','),
    "\t" => substr_count($firstLine, "\t")
];
$delimiter = array_search(max($delimiters), $delimiters) ?: ';';

rewind($handle);

// Baca header (hapus BOM)
$header = fgetcsv($handle, 1000, $delimiter);
$header = array_map(function ($h) {
    return trim(preg_replace('/^\xEF\xBB\xBF/', '', $h));
}, $header);

// =====================================================
// TAHAP 3: VALIDASI KOLOM WAJIB
// =====================================================

$required_columns = [
    'Nama Kafe',
    'Skor_Rasa',
    'Skor_Pelayanan',
    'Skor_Fasilitas',
    'Skor_Suasana',
    'Skor_Harga',
    'Skor_Rating'
];

$missing_cols = array_diff($required_columns, $header);
if (!empty($missing_cols)) {
    echo json_encode([
        "error" => "Kolom wajib tidak lengkap",
        "missing" => array_values($missing_cols)
    ]);
    exit(1);
}

// Map index kolom
$col_map = array_flip($header);

// =====================================================
// TAHAP 4: BACA DATA & AGREGASI PER KAFE
// =====================================================

$data_kafe = [];

while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {

    // Skip baris kosong
    if (empty($row[0])) {
        continue;
    }

    // Normalisasi nama kafe
    $nama_kafe = trim(ucwords(strtolower($row[$col_map['Nama Kafe']])));

    // Ambil data numerik
    $rasa      = (float)$row[$col_map['Skor_Rasa']];
    $pelayanan = (float)$row[$col_map['Skor_Pelayanan']];
    $fasilitas = (float)$row[$col_map['Skor_Fasilitas']];
    $suasana   = (float)$row[$col_map['Skor_Suasana']];
    $harga     = (float)$row[$col_map['Skor_Harga']];

    // Skip jika ada nilai 0 atau invalid
    if ($rasa == 0 || $pelayanan == 0 || $fasilitas == 0 || $suasana == 0 || $harga == 0) {
        continue;
    }

    // Agregasi (rata-rata per kafe jika ada duplikat)
    if (!isset($data_kafe[$nama_kafe])) {
        $data_kafe[$nama_kafe] = [
            'rasa' => [],
            'pelayanan' => [],
            'fasilitas' => [],
            'suasana' => [],
            'harga' => []
        ];
    }

    $data_kafe[$nama_kafe]['rasa'][] = $rasa;
    $data_kafe[$nama_kafe]['pelayanan'][] = $pelayanan;
    $data_kafe[$nama_kafe]['fasilitas'][] = $fasilitas;
    $data_kafe[$nama_kafe]['suasana'][] = $suasana;
    $data_kafe[$nama_kafe]['harga'][] = $harga;
}

fclose($handle);

// Validasi data kosong
if (empty($data_kafe)) {
    echo json_encode([
        "error" => "Dataset CSV kosong atau semua data invalid"
    ]);
    exit(1);
}

// Hitung rata-rata per kafe
$df_group = [];
foreach ($data_kafe as $nama => $values) {
    $df_group[] = [
        'nama_kafe' => $nama,
        'rasa'      => array_sum($values['rasa']) / count($values['rasa']),
        'pelayanan' => array_sum($values['pelayanan']) / count($values['pelayanan']),
        'fasilitas' => array_sum($values['fasilitas']) / count($values['fasilitas']),
        'suasana'   => array_sum($values['suasana']) / count($values['suasana']),
        'harga'     => array_sum($values['harga']) / count($values['harga'])
    ];
}

// =====================================================
// VALIDASI JUMLAH DATA
// =====================================================

$k = 3; // Jumlah cluster

if (count($df_group) < $k) {
    echo json_encode([
        "error" => "Jumlah kafe kurang dari jumlah cluster",
        "min_required" => $k,
        "current" => count($df_group)
    ]);
    exit(1);
}

// =====================================================
// TAHAP 5: NORMALISASI MIN-MAX
// =====================================================

$fitur = ['rasa', 'pelayanan', 'fasilitas', 'suasana', 'harga'];

// Cari min & max per fitur
$min_max = [];
foreach ($fitur as $f) {
    $values = array_column($df_group, $f);
    $min_max[$f] = [
        'min' => min($values),
        'max' => max($values)
    ];
}

// Normalisasi data
$X = [];
foreach ($df_group as $i => $row) {
    $X[$i] = [];
    foreach ($fitur as $f) {
        $min = $min_max[$f]['min'];
        $max = $min_max[$f]['max'];

        // Min-Max Scaling
        if ($max - $min == 0) {
            $X[$i][] = 0;
        } else {
            $X[$i][] = ($row[$f] - $min) / ($max - $min);
        }
    }
}

// =====================================================
// TAHAP 6: K-MEANS CLUSTERING
// =====================================================

// Inisialisasi centroid dengan K-Means++
$centroids = kmeans_plus_plus_init($X, $k);

$max_iter = 100;
$labels = [];

for ($iter = 0; $iter < $max_iter; $iter++) {

    // Assign data ke cluster terdekat
    $new_labels = [];
    foreach ($X as $i => $point) {
        $min_dist = PHP_FLOAT_MAX;
        $cluster = 0;

        foreach ($centroids as $c => $centroid) {
            $dist = euclidean_distance($point, $centroid);
            if ($dist < $min_dist) {
                $min_dist = $dist;
                $cluster = $c;
            }
        }

        $new_labels[$i] = $cluster;
    }

    // Cek konvergensi
    if ($labels === $new_labels) {
        break;
    }

    $labels = $new_labels;

    // Update centroid
    $new_centroids = [];
    for ($c = 0; $c < $k; $c++) {
        $cluster_points = [];

        foreach ($labels as $i => $label) {
            if ($label === $c) {
                $cluster_points[] = $X[$i];
            }
        }

        if (empty($cluster_points)) {
            $new_centroids[$c] = $centroids[$c];
        } else {
            $new_centroids[$c] = array_map(function ($col) use ($cluster_points) {
                return array_sum(array_column($cluster_points, $col)) / count($cluster_points);
            }, array_keys($cluster_points[0]));
        }
    }

    $centroids = $new_centroids;
}

// =====================================================
// TAHAP 7: HITUNG JARAK KE CENTROID
// =====================================================

$jarak = [];
foreach ($X as $i => $point) {
    $centroid = $centroids[$labels[$i]];
    $jarak[$i] = euclidean_distance($point, $centroid);
}

// =====================================================
// TAHAP 8: RANKING PER CLUSTER
// =====================================================

$cluster_data = [];
foreach ($labels as $i => $cluster) {
    $cluster_data[$cluster][] = [
        'index' => $i,
        'jarak' => $jarak[$i]
    ];
}

$peringkat = [];
foreach ($cluster_data as $cluster => $items) {
    usort($items, function ($a, $b) {
        return $a['jarak'] <=> $b['jarak'];
    });

    $rank = 1;
    foreach ($items as $item) {
        $peringkat[$item['index']] = $rank++;
    }
}

// =====================================================
// TAHAP 9: OUTPUT JSON
// =====================================================

$output = [
    "k" => $k,
    "iterations" => $iter + 1,
    "rows" => []
];

foreach ($df_group as $i => $row) {
    $output['rows'][] = [
        "nama_kafe" => $row['nama_kafe'],
        "cluster" => $labels[$i] + 1,
        "jarak_centroid" => round($jarak[$i], 6),
        "peringkat_cluster" => $peringkat[$i]
    ];
}

// Output JSON (harus clean, tidak ada output lain)
echo json_encode($output, JSON_UNESCAPED_UNICODE);
exit(0);

// =====================================================
// HELPER FUNCTIONS
// =====================================================

function euclidean_distance($point1, $point2)
{
    $sum = 0;
    for ($i = 0; $i < count($point1); $i++) {
        $sum += pow($point1[$i] - $point2[$i], 2);
    }
    return sqrt($sum);
}

function kmeans_plus_plus_init($X, $k)
{
    $n = count($X);
    $centroids = [];

    // Pilih centroid pertama secara random
    $centroids[0] = $X[array_rand($X)];

    for ($c = 1; $c < $k; $c++) {
        $distances = [];

        foreach ($X as $i => $point) {
            $min_dist = PHP_FLOAT_MAX;

            foreach ($centroids as $centroid) {
                $dist = euclidean_distance($point, $centroid);
                if ($dist < $min_dist) {
                    $min_dist = $dist;
                }
            }

            $distances[$i] = $min_dist;
        }

        $max_index = array_search(max($distances), $distances);
        $centroids[$c] = $X[$max_index];
    }

    return $centroids;
}
