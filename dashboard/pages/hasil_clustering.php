<?php
// =====================================================
// pages/riwayat_clustering.php
// MENAMPILKAN HASIL CLUSTERING TERBARU
// =====================================================

/*
 STEP 0
 -------------------------------------------------------
 Validasi sesi login
*/
if (!isset($_SESSION['sesi_id'])) {
    return;
}

/*
 STEP 1
 -------------------------------------------------------
 Ambil ID_CLUSTER TERBARU
 (hasil clustering terakhir yang dijadikan acuan)
*/
$qLast = mysqli_query($koneksi, "
    SELECT MAX(id_cluster) AS last_id 
    FROM clustering
");
$last = mysqli_fetch_assoc($qLast);
$id_cluster_terbaru = (int)$last['last_id'];

/*
 STEP 2
 -------------------------------------------------------
 Ambil FILTER CLUSTER dari URL (GET)
 contoh: ?nocluster=1
*/
$filterCluster = $_GET['nocluster'] ?? null;
$filterSQL = "";

/*
 Jika filter cluster ada, tambahkan ke WHERE
*/
if ($filterCluster !== null) {
    $filterSQL = " AND hc.cluster = '" . intval($filterCluster) . "' ";
}

/*
 STEP 3
 -------------------------------------------------------
 Query UTAMA HASIL CLUSTERING
 - JOIN ke tabel kafe (nama & foto)
 - LEFT JOIN ke hasil_kuisioner (ambil rating)
 - Filter id_cluster terbaru
 - Filter cluster (jika ada)
*/
$query = mysqli_query($koneksi, "
    SELECT 
        hc.id_hasil,
        hc.id_cluster,
        hc.cluster,
        hc.jarak_centroid,
        hc.peringkat_cluster,

        k.nama_kafe,
        k.foto_kafe,

        AVG(hq.rating) AS rating

    FROM hasil_clustering hc
    JOIN kafe k 
        ON k.id_kafe = hc.id_kafe
    LEFT JOIN hasil_kuisioner hq
        ON hq.id_kafe = k.id_kafe

    WHERE hc.id_cluster = '$id_cluster_terbaru'
    $filterSQL

    GROUP BY hc.id_hasil
    ORDER BY hc.cluster ASC, hc.peringkat_cluster ASC
");

/*
 STEP 4
 -------------------------------------------------------
 Query RINGKASAN CLUSTER
 Digunakan untuk card "Jumlah Kafe per Cluster"
*/
$qClusterCount = mysqli_query($koneksi, "
    SELECT cluster, COUNT(*) AS total
    FROM hasil_clustering
    WHERE id_cluster = '$id_cluster_terbaru'
    GROUP BY cluster
");

/*
 STEP 5
 -------------------------------------------------------
 Simpan jumlah kafe per cluster ke array
 contoh:
 $clusterCount[1] = 5
 $clusterCount[2] = 8
*/
$clusterCount = [];
while ($c = mysqli_fetch_assoc($qClusterCount)) {
    $clusterCount[$c['cluster']] = $c['total'];
}
// ================= CLUSTER TERAKHIR =================
$qLastCluster = mysqli_query($koneksi, "
    SELECT MAX(id_cluster) AS last_id 
    FROM clustering
");
$idClusterTerakhir = (int)(mysqli_fetch_assoc($qLastCluster)['last_id'] ?? 0);
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
        LIMIT 5
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
                    $clusterColor = [
                        1 => 'primary',
                        2 => 'success',
                        3 => 'warning'
                    ];

                    for ($i = 1; $i <= 3; $i++):
                        $total = $clusterCount[$i] ?? 0;
                    ?>
                        <div class="col-12 col-md-4">
                            <div class="card border">
                                <div class="card-body">

                                    <div class="d-flex align-items-center gap-3">
                                        <!-- ICON -->
                                        <div class="bg-<?= $clusterColor[$i]; ?> text-white p-3 rounded">
                                            <i class="bi bi-diagram-3-fill fs-4"></i>
                                        </div>

                                        <div>
                                            <h5 class="mb-1">Cluster <?= $i; ?></h5>
                                            <small class="text-muted">
                                                Jumlah Kafe : <b><?= $total; ?></b>
                                            </small>
                                        </div>
                                    </div>

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

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">
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
                            <th>Peringkat</th>
                            <th>Jarak Centroid</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
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
                                            style="width:100px;height:100px;object-fit:cover;border-radius:10px;">

                                        <div class="fw-bold">
                                            <?= htmlspecialchars($r['nama_kafe']); ?>
                                        </div>
                                    </div>
                                </td>


                                <!-- CLUSTER -->
                                <?php
                                $badge = 'bg-secondary'; // default kalau di luar 1-3
                                if ((int)$r['cluster'] === 1) $badge = 'bg-primary';
                                elseif ((int)$r['cluster'] === 2) $badge = 'bg-success';
                                elseif ((int)$r['cluster'] === 3) $badge = 'bg-warning';
                                ?>

                                <td>
                                    <span class="badge <?= $badge; ?>">
                                        Cluster <?= (int)$r['cluster']; ?>
                                    </span>
                                </td>

                                <!-- PERINGKAT -->
                                <td>
                                    <span class="badge bg-danger">
                                        #<?= (int)$r['peringkat_cluster']; ?>
                                    </span>
                                </td>

                                <!-- JARAK -->
                                <td>
                                    <?= number_format($r['jarak_centroid'], 4); ?>
                                </td>

                                <!-- RATING -->
                                <td>
                                    <?php if ($r['rating'] !== null): ?>
                                        <span class="badge bg-warning text-dark">
                                            <?= number_format($r['rating'], 2); ?> ★
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
                    * Data diambil dari hasil clustering terakhir.
                </small>
            </div>
        </div>
    </section>
</div>