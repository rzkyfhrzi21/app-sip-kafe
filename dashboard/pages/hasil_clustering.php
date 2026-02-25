<?php
// =====================================================
// pages/hasil_clustering.php (FINAL WITH IMPROVED UI)
// Menampilkan hasil clustering terbaru dengan tampilan menarik
// =====================================================

// Validasi sesi login
if (!isset($_SESSION['sesi_id'])) {
    return;
}

// Ambil cluster terbaru ID
$qLast = mysqli_query($koneksi, "SELECT MAX(id_cluster) AS last_id FROM clustering");
$last = mysqli_fetch_assoc($qLast);
$id_cluster_terbaru = (int)$last['last_id'];

if ($id_cluster_terbaru === 0) {
    echo '<div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle-fill"></i>
            Belum ada data clustering. Silakan <a href="?page=Mulai Clustering">upload dataset</a> terlebih dahulu.
          </div>';
    return;
}

// Filter cluster dari URL
$filterCluster = $_GET['nocluster'] ?? null;
$filterSQL = "";
if ($filterCluster !== null) {
    $filterSQL = " AND hc.cluster = '" . intval($filterCluster) . "' ";
}

// Query utama hasil clustering
$query = mysqli_query($koneksi, "
    SELECT 
        hc.id_hasil, hc.id_cluster, hc.cluster, hc.jarak_centroid,
        hc.peringkat_cluster, hc.rating_akhir,
        k.id_kafe, k.nama_kafe, k.alamat, k.foto_kafe,
        ROUND(AVG(hq.rating), 2) AS rating,
        ROUND(AVG(hq.nilai_wsm), 2) AS nilai_wsm_avg
    FROM hasil_clustering hc
    JOIN kafe k ON hc.id_kafe = k.id_kafe
    LEFT JOIN hasil_kuisioner hq ON hq.id_kafe = k.id_kafe
    WHERE hc.id_cluster = '$id_cluster_terbaru' $filterSQL
    GROUP BY hc.id_hasil
    ORDER BY hc.cluster ASC, hc.peringkat_cluster ASC
");

// Ringkasan jumlah kafe per cluster
$qClusterCount = mysqli_query($koneksi, "
    SELECT cluster, COUNT(*) AS total 
    FROM hasil_clustering 
    WHERE id_cluster = '$id_cluster_terbaru' 
    GROUP BY cluster
");
$clusterCount = [];
while ($row = mysqli_fetch_assoc($qClusterCount)) {
    $clusterCount[$row['cluster']] = $row['total'];
}

// Statistik per cluster
$stats_cluster = [];
for ($i = 1; $i <= 3; $i++) {
    $qStats = mysqli_query($koneksi, "
        SELECT 
            COUNT(*) AS jumlah,
            ROUND(AVG(rating_akhir), 2) AS avg_rating,
            ROUND(MIN(jarak_centroid), 6) AS min_jarak,
            ROUND(MAX(jarak_centroid), 6) AS max_jarak
        FROM hasil_clustering 
        WHERE id_cluster = $id_cluster_terbaru AND cluster = $i
    ");
    $stats_cluster[$i] = mysqli_fetch_assoc($qStats);
}

// Top 5 kafe per cluster
$topPerCluster = [];
for ($c = 1; $c <= 3; $c++) {
    $q = mysqli_query($koneksi, "
        SELECT 
            k.nama_kafe, k.foto_kafe, hc.peringkat_cluster, hc.jarak_centroid,
            hc.rating_akhir, ROUND(AVG(hq.rating), 2) AS rating,
            ROUND(AVG(hq.nilai_wsm), 2) AS nilai_wsm
        FROM hasil_clustering hc
        JOIN kafe k ON k.id_kafe = hc.id_kafe
        LEFT JOIN hasil_kuisioner hq ON hq.id_kafe = k.id_kafe
        WHERE hc.id_cluster = '$id_cluster_terbaru' AND hc.cluster = '$c'
        GROUP BY hc.id_hasil
        ORDER BY hc.peringkat_cluster ASC
        LIMIT 5
    ");
    while ($r = mysqli_fetch_assoc($q)) {
        $topPerCluster[$c][] = $r;
    }
}

$clusterColor = [1 => 'success', 2 => 'warning', 3 => 'danger'];
$clusterLabel = [1 => '', 2 => '', 3 => ''];
?>

<head>
    <style>
        /* Custom styling untuk Top Kafe Card */
        .topkafe-card {
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .topkafe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .topkafe-card .card-header {
            padding: 14px 18px;
        }

        .topkafe-card .card-body {
            padding: 18px;
        }

        .topkafe-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .topkafe-item {
            border: 1px solid rgba(0, 0, 0, .08);
            border-radius: 12px;
            padding: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            transition: all 0.3s ease;
        }

        .topkafe-item:hover {
            background: #f8f9fa;
            border-color: rgba(0, 0, 0, 0.15);
            transform: translateX(5px);
        }

        .topkafe-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .topkafe-rank {
            min-width: 42px;
            height: 32px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            font-size: 12px;
        }

        .topkafe-name {
            font-weight: 800;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topkafe-rating {
            font-weight: 700;
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid rgba(0, 0, 0, .08);
        }

        .badge-wsm {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.35rem 0.6rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Stat card hover effect */
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>Hasil Clustering</h3>
                <p class="text-subtitle text-muted">
                    Hasil clustering kafe (cluster terbaru).
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= ucwords($page); ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- ================= SECTION RINGKASAN CLUSTER ================= -->
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0">Ringkasan Cluster</h2>

                <?php if (isset($_GET['nocluster'])): ?>
                    <!-- RESET FILTER -->
                    <a href="admin?page=<?= $page; ?>"
                        class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset Filter
                    </a>
                <?php endif; ?>
            </div>

            <div class="card-body">
                <div class="row">
                    <?php
                    for ($i = 1; $i <= 3; $i++):
                        $total = $clusterCount[$i] ?? 0;
                        $stat = $stats_cluster[$i];
                    ?>
                        <div class="col-12 col-md-4">
                            <div class="card border stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3">
                                        <!-- ICON -->
                                        <div class="bg-<?= $clusterColor[$i]; ?> text-white p-3 rounded">
                                            <i class="bi bi-diagram-3-fill fs-4"></i>
                                        </div>

                                        <div>
                                            <h5 class="mb-1">Cluster <?= $i; ?></h5>
                                            <small class="text-muted">
                                                <?= $clusterLabel[$i]; ?>
                                            </small>
                                        </div>
                                    </div>

                                    <hr>

                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-1">
                                            <i class="bi bi-shop text-<?= $clusterColor[$i]; ?>"></i>
                                            <strong>Jumlah Kafe:</strong> <?= $stat['jumlah']; ?>
                                        </li>
                                        <li class="mb-1">
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <strong>Rata-rata Rating:</strong> <?= $stat['avg_rating']; ?> / 5
                                        </li>
                                        <li class="mb-1">
                                            <i class="bi bi-arrow-down-circle text-success"></i>
                                            <strong>Jarak Min:</strong> <?= $stat['min_jarak']; ?>
                                        </li>
                                        <li>
                                            <i class="bi bi-arrow-up-circle text-danger"></i>
                                            <strong>Jarak Max:</strong> <?= $stat['max_jarak']; ?>
                                        </li>
                                    </ul>

                                    <div class="mt-3">
                                        <a href="admin?page=<?= $page; ?>&nocluster=<?= $i; ?>"
                                            class="btn btn-outline-<?= $clusterColor[$i]; ?> w-100">
                                            <i class="bi bi-eye-fill"></i>
                                            Tampilkan Cluster <?= $i; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- ================= END RINGKASAN CLUSTER ================= -->

    <!-- =====================================================
        TOP KAFE PER CLUSTER
    ===================================================== -->
    <section class="section mt-4">
        <div class="row g-4">
            <?php for ($c = 1; $c <= 3; $c++): ?>
                <?php
                $color = $clusterColor[$c];
                $rankBg = ($c == 1 ? '#198754' : ($c == 2 ? '#ffc107' : '#dc3545'));
                ?>
                <div class="col-12 col-md-4">
                    <div class="card topkafe-card shadow-sm">
                        <div class="card-header bg-<?= $color; ?> text-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-award-fill"></i>
                                    Top Kafe Cluster <?= $c; ?>
                                </h5>
                                <span class="badge bg-light text-dark">
                                    <?= isset($topPerCluster[$c]) ? count($topPerCluster[$c]) : 0; ?> kafe
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php if (!empty($topPerCluster[$c])): ?>
                                <ul class="topkafe-list">
                                    <?php foreach ($topPerCluster[$c] as $kafe): ?>
                                        <li class="topkafe-item">
                                            <div class="topkafe-left">
                                                <span class="topkafe-rank"
                                                    style="background: <?= $rankBg; ?>;">
                                                    #<?= (int)$kafe['peringkat_cluster']; ?>
                                                </span>

                                                <div class="min-w-0">
                                                    <div class="topkafe-name">
                                                        <?= htmlspecialchars($kafe['nama_kafe']); ?>
                                                    </div>
                                                    <small class="text-muted">
                                                        <i class="bi bi-bullseye"></i>
                                                        Jarak: <?= number_format((float)$kafe['jarak_centroid'], 4); ?>
                                                    </small>
                                                    <?php if (isset($kafe['nilai_wsm'])): ?>
                                                        <br>
                                                        <small class="badge-wsm" style="font-size: 10px;">
                                                            WSM: <?= $kafe['nilai_wsm']; ?>
                                                        </small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <?php if ($kafe['rating'] !== null): ?>
                                                <span class="topkafe-rating">
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <?= number_format((float)$kafe['rating'], 2); ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="topkafe-rating text-muted">–</span>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1"></i>
                                    <p class="mb-0">Tidak ada data</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </section>

    <!-- =====================================================
        TABEL DETAIL HASIL CLUSTERING
    ===================================================== -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="bi bi-table"></i>
                    Daftar Kafe & Cluster
                </h4>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-striped align-middle" id="tabel">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Kafe</th>
                            <th>Cluster</th>
                            <th>Nilai WSM</th>
                            <th>Peringkat</th>
                            <th>Jarak Centroid</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        mysqli_data_seek($query, 0);
                        while ($r = mysqli_fetch_assoc($query)):
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>

                                <!-- NAMA KAFE -->
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <?php
                                        $foto = !empty($r['foto_kafe']) ? $r['foto_kafe'] : 'default.jpg';
                                        $foto_url = "assets/foto_kafe/" . htmlspecialchars($foto);
                                        ?>
                                        <img src="<?= $foto_url; ?>"
                                            onerror="this.src='assets/foto_kafe/foto_kafe.jpg'"
                                            style="width:100px;height:100px;object-fit:cover;border-radius:10px;"
                                            alt="<?= htmlspecialchars($r['nama_kafe']); ?>">

                                        <div class="fw-bold">
                                            <?= htmlspecialchars($r['nama_kafe']); ?>
                                            <br>
                                            <small class="text-muted">
                                                <?= htmlspecialchars($r['alamat']); ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <!-- CLUSTER -->
                                <?php
                                $badge = 'bg-secondary'; // default
                                if ((int)$r['cluster'] === 1) $badge = 'bg-success';
                                elseif ((int)$r['cluster'] === 2) $badge = 'bg-warning';
                                elseif ((int)$r['cluster'] === 3) $badge = 'bg-danger';
                                ?>

                                <td>
                                    <span class="badge <?= $badge; ?>">
                                        Cluster <?= (int)$r['cluster']; ?>
                                    </span>
                                </td>

                                <!-- NILAI WSM -->
                                <td>
                                    <?php if ($r['nilai_wsm_avg'] !== null): ?>
                                        <span class="badge-wsm">
                                            <?= $r['nilai_wsm_avg']; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">–</span>
                                    <?php endif; ?>
                                </td>

                                <!-- PERINGKAT -->
                                <td>
                                    <span class="badge bg-primary">
                                        #<?= (int)$r['peringkat_cluster']; ?>
                                    </span>
                                </td>

                                <!-- JARAK -->
                                <td>
                                    <code><?= number_format($r['jarak_centroid'], 6); ?></code>
                                </td>

                                <!-- RATING -->
                                <td>
                                    <?php if ($r['rating_akhir'] !== null): ?>
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-star-fill"></i>
                                            <?= number_format($r['rating_akhir'], 2); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">–</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <small class="text-muted d-block mt-2">
                    <i class="bi bi-info-circle"></i>
                    * Data diambil dari hasil clustering terakhir.
                </small>
            </div>
        </div>
    </section>
</div>