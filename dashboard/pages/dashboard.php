<?php
// =====================================================
// DASHBOARD SIP KAFE
// =====================================================

// ================= TOTAL KAFE =================
$qKafe = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kafe");
$totalKafe = mysqli_fetch_assoc($qKafe)['total'];

// ================= TOTAL KUISIONER =================
$qKuisioner = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM hasil_kuisioner");
$totalKuisioner = mysqli_fetch_assoc($qKuisioner)['total'];

// ================= CLUSTER TERAKHIR =================
$qLastCluster = mysqli_query($koneksi, "
    SELECT MAX(id_cluster) AS last_id 
    FROM clustering
");
$idClusterTerakhir = (int)(mysqli_fetch_assoc($qLastCluster)['last_id'] ?? 0);

// ================= JUMLAH DATA CLUSTER TERAKHIR =================
$qJumlahData = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total 
    FROM hasil_clustering 
    WHERE id_cluster = '$idClusterTerakhir'
");
$totalDataCluster = mysqli_fetch_assoc($qJumlahData)['total'] ?? 0;

// ================= DISTRIBUSI CLUSTER (DONUT) =================
$qDistribusi = mysqli_query($koneksi, "
    SELECT cluster, COUNT(*) AS total
    FROM hasil_clustering
    WHERE id_cluster = '$idClusterTerakhir'
    GROUP BY cluster
");

$clusterLabel = [];
$clusterTotal = [];

while ($c = mysqli_fetch_assoc($qDistribusi)) {
    $clusterLabel[] = 'Cluster ' . $c['cluster'];
    $clusterTotal[] = (int)$c['total'];
}

// ================= TOP KAFE PER CLUSTER =================
$topPerCluster = [];

for ($c = 1; $c <= 3; $c++) {
    $q = mysqli_query($koneksi, "
        SELECT 
            k.nama_kafe,
            k.foto_kafe,
            hc.peringkat_cluster,
            hc.jarak_centroid,
            AVG(hq.rating) AS rating
        FROM hasil_clustering hc
        JOIN kafe k ON k.id_kafe = hc.id_kafe
        LEFT JOIN hasil_kuisioner hq ON hq.id_kafe = k.id_kafe
        WHERE hc.id_cluster = '$idClusterTerakhir'
          AND hc.cluster = '$c'
        GROUP BY hc.id_hasil
        ORDER BY hc.peringkat_cluster ASC
        LIMIT 3
    ");

    while ($r = mysqli_fetch_assoc($q)) {
        $topPerCluster[$c][] = $r;
    }
}
?>

<head>
    <style>
        .topkafe-card {
            border-radius: 16px;
            overflow: hidden;
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
            padding: 12px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
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
    </style>

</head>

<!-- =====================================================
HEADER
===================================================== -->
<div class="page-heading">

    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-8">
                <h3>Dashboard Admin</h3>
                <h5 class="text-muted"> Selamat datang, <b><?= htmlspecialchars($sesi_nama); ?></b> 👋 Kelola data kafe dan proses clustering SIP KAFE. </h5>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= ucwords($page); ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <!-- =====================================================
    RINGKASAN DATA
    ===================================================== -->
    <section class="row">
        <div class="col-12">
            <div class="row">

                <?php
                $cards = [
                    ['Total Kafe', $totalKafe, 'bi-cup-hot', 'primary'],
                    ['Total Kuisioner', $totalKuisioner, 'bi-clipboard-data', 'success'],
                    ['Clustering Terakhir', $idClusterTerakhir ?: '-', 'bi-diagram-3', 'warning'],
                    ['Jumlah Data Cluster', $totalDataCluster, 'bi-database', 'danger'],
                ];
                foreach ($cards as $c):
                ?>
                    <div class="col-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-muted"><?= $c[0]; ?></h6>
                                <h3><?= $c[1]; ?></h3>
                                <i class="bi <?= $c[2]; ?> fs-1 text-<?= $c[3]; ?>"></i>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <!-- =====================================================
        AKSI CEPAT
        ===================================================== -->
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Aksi Cepat</h4>
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="admin?page=MulaiClustering" class="btn btn-lg btn-primary">
                        🚀 Mulai Clustering
                    </a>
                    <a href="admin?page=HasilClustering" class="btn btn-lg btn-success">
                        📊 Hasil Clustering
                    </a>
                    <a href="admin?page=RiwayatClustering" class="btn btn-lg btn-warning">
                        🕓 Riwayat Clustering
                    </a>
                    <a href="admin?page=DataKafe" class="btn btn-lg btn-outline-secondary">
                        ☕ Kelola Data Kafe
                    </a>
                </div>
            </div>
        </div>

        <!-- =====================================================
        CHART DISTRIBUSI CLUSTER
        ===================================================== -->
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Distribusi Kafe per Cluster</h4>
                    <p class="text-muted mb-0">Berdasarkan hasil clustering terakhir</p>
                </div>
                <div class="card-body">
                    <div id="chart-cluster"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================================================
    TOP KAFE PER CLUSTER
    ===================================================== -->
    <section class="section mt-4">
        <div class="row g-4">
            <?php for ($c = 1; $c <= 3; $c++): ?>
                <?php
                $color = ($c == 1 ? 'primary' : ($c == 2 ? 'success' : 'warning'));
                // warna rank box (biar konsisten walau bg-warning)
                $rankBg = ($c == 3 ? '#ffc107' : null);
                ?>
                <div class="col-12 col-md-4">
                    <div class="card topkafe-card shadow-sm">
                        <div class="card-header bg-<?= $color; ?> text-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="card-title mb-0">Top Kafe Cluster <?= $c; ?></h5>
                                <span class="badge bg-light text-dark">
                                    <?= isset($topPerCluster[$c]) ? count($topPerCluster[$c]) : 0; ?> kafe
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php if (!empty($topPerCluster[$c])): ?>
                                <ul class="topkafe-list">
                                    <?php foreach ($topPerCluster[$c] as $kafe): ?>
                                        <li class="topkafe-item mt-3">
                                            <div class="topkafe-left">
                                                <span class="topkafe-rank"
                                                    style="background: <?= $rankBg ?: 'var(--bs-' . $color . ')'; ?>;">
                                                    #<?= (int)$kafe['peringkat_cluster']; ?>
                                                </span>

                                                <div class="min-w-0">
                                                    <div class="topkafe-name">
                                                        <?= htmlspecialchars($kafe['nama_kafe']); ?>
                                                    </div>
                                                    <small class="text-muted">
                                                        Jarak: <?= isset($kafe['jarak_centroid']) ? number_format((float)$kafe['jarak_centroid'], 4) : '-'; ?>
                                                    </small>
                                                </div>
                                            </div>

                                            <?php if ($kafe['rating'] !== null): ?>
                                                <span class="topkafe-rating">
                                                    <?= number_format((float)$kafe['rating'], 2); ?>★
                                                </span>
                                            <?php else: ?>
                                                <span class="topkafe-rating text-muted">–</span>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <div class="text-muted">Tidak ada data</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </section>

</div>

<!-- =====================================================
APEXCHART
===================================================== -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    new ApexCharts(document.querySelector("#chart-cluster"), {
        series: <?= json_encode($clusterTotal); ?>,
        labels: <?= json_encode($clusterLabel); ?>,
        chart: {
            type: 'donut',
            height: 350
        },
        colors: ['#435ebe', '#28a745', '#ffc107'],
        legend: {
            position: 'bottom'
        },
        dataLabels: {
            enabled: true
        }
    }).render();
</script>