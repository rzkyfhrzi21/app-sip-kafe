<?php
require_once 'config/config.php';

// ambil cluster terbaru
$qLast = mysqli_query($koneksi, "SELECT MAX(id_cluster) AS last_id FROM clustering");
$idCluster = (int) mysqli_fetch_assoc($qLast)['last_id'];

// ranking kafe (peringkat_cluster ASC)
$q = mysqli_query($koneksi, "
    SELECT 
        k.id_kafe,
        k.nama_kafe,
        k.foto_kafe,
        hc.cluster,
        hc.peringkat_cluster,
        AVG(hq.rating) AS rating
    FROM hasil_clustering hc
    JOIN kafe k ON k.id_kafe = hc.id_kafe
    LEFT JOIN hasil_kuisioner hq ON hq.id_kafe = k.id_kafe
    WHERE hc.id_cluster = '$idCluster'
    GROUP BY hc.id_hasil
    ORDER BY hc.peringkat_cluster ASC
    LIMIT 12
");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Peringkat Kafe Terbaik - <?= NAMA_WEB ?></title>

    <?php include 'dashboard/pages/css.php'; ?>
    <link rel="stylesheet" href="assets/public.css">
</head>

<body>

    <!-- NAVBAR PUBLIK -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php"><?= NAMA_WEB ?></a>
            <div class="ms-auto">
                <a href="cari_kafe.php" class="btn btn-outline-primary">
                    🔍 Cari Kafe
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">

        <div class="page-heading mb-4">
            <h3>Peringkat Kafe Terbaik</h3>
            <p class="text-subtitle text-muted">
                Berdasarkan data kuisioner & clustering terbaru
            </p>
        </div>

        <div class="row g-4">
            <?php while ($r = mysqli_fetch_assoc($q)): ?>
                <?php
                $foto = !empty($r['foto_kafe']) ? $r['foto_kafe'] : 'default.jpg';
                ?>
                <div class="col-12 col-md-4">
                    <div class="card kafe-card h-100">
                        <img src="dashboard/assets/foto_kafe/<?= htmlspecialchars($foto) ?>"
                            class="card-img-top"
                            onerror="this.src='dashboard/assets/foto_kafe/foto_kafe.jpg'">

                        <div class="card-body">
                            <span class="badge bg-primary mb-2">
                                #<?= $r['peringkat_cluster']; ?>
                            </span>

                            <h5 class="card-title">
                                <?= htmlspecialchars($r['nama_kafe']); ?>
                            </h5>

                            <p class="text-muted mb-2">
                                Cluster <?= $r['cluster']; ?> ·
                                <?= number_format($r['rating'], 2); ?> ★
                            </p>

                            <a href="detail_kafe.php?id=<?= $r['id_kafe']; ?>"
                                class="btn btn-primary btn-sm">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    </div>

    <?php include 'dashboard/pages/js.php'; ?>
</body>

</html>