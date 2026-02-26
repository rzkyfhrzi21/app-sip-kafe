<?php
require_once 'config/config.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    header('Location: index.php');
    exit;
}

// Ambil latest clustering untuk id kafe ini
$qLatestCluster = mysqli_query($koneksi, "
    SELECT cluster, peringkat_cluster, jarak_centroid 
    FROM hasil_clustering 
    WHERE id_kafe = $id 
    ORDER BY id_cluster DESC LIMIT 1
");
$latestCluster = mysqli_fetch_assoc($qLatestCluster);

// Data kafe dan rating
$q = mysqli_query($koneksi, "
    SELECT 
        k.*,
        ROUND(AVG(hq.rating), 2) AS rating,
        ROUND(AVG(hq.rasa_kopi), 2) AS rasa_kopi,
        ROUND(AVG(hq.pelayanan), 2) AS pelayanan,
        ROUND(AVG(hq.fasilitas), 2) AS fasilitas,
        ROUND(AVG(hq.suasana), 2) AS suasana,
        ROUND(AVG(hq.harga), 2) AS harga_rating,
        ROUND(AVG(hq.nilai_wsm), 2) AS nilai_wsm,
        COUNT(hq.id_kuisioner) AS total_responden
    FROM kafe k
    LEFT JOIN hasil_kuisioner hq ON hq.id_kafe = k.id_kafe
    WHERE k.id_kafe = $id
    GROUP BY k.id_kafe
");
$kafe = mysqli_fetch_assoc($q);
if (!$kafe) {
    header('Location: index.php');
    exit;
}

$clusterColor = [1 => 'success', 2 => 'warning', 3 => 'danger'];
$clusterLabel = [1 => 'Kualitas Terbaik', 2 => 'Kualitas Standar', 3 => 'Kualitas Rendah'];

$foto = !empty($kafe['foto_kafe']) ? $kafe['foto_kafe'] : 'default.jpg';
$foto_url = "dashboard/assets/foto_kafe/" . htmlspecialchars($foto);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
    <meta name="description" content="Detail informasi <?= htmlspecialchars($kafe['nama_kafe']); ?> - Rating, harga, fasilitas, dan lokasi" />
    <meta name="theme-color" content="#7b4b2a" />

    <title><?= htmlspecialchars($kafe['nama_kafe']); ?> - <?= NAMA_WEB ?></title>

    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon" />
    <?php require_once 'assets/css.php'; ?>
</head>

<body>

    <!-- Navbar -->
    <?php require_once 'navbar.php'; ?>

    <div class="container mt-4 mb-5">

        <div class="row g-4">

            <!-- Kiri: Foto + Rating, Statistik, Detail penilaian -->
            <div class="col-12 col-lg-8">

                <!-- Foto kafe -->
                <img src="<?= $foto_url; ?>" alt="<?= htmlspecialchars($kafe['nama_kafe']); ?>" class="img-fluid rounded mb-4"
                    style="width: 100%; max-height: 450px; object-fit: cover; border: 1px solid var(--accent); padding: 4px;"
                    onerror="this.src='dashboard/assets/foto_kafe/foto_kafe.jpg'">

                <!-- Rating & Statistik -->
                <div class="d-flex gap-3 justify-content-around mb-4 text-center">
                    <div class="bg-white rounded shadow-sm p-3 flex-fill" style="max-width: 160px;">
                        <h4 class="fw-bold text-accent mb-1"><?= number_format($kafe['rating'] ?? 0, 1); ?></h4>
                        <small class="text-muted">Rating Keseluruhan</small>
                    </div>
                    <div class="bg-white rounded shadow-sm p-3 flex-fill" style="max-width: 160px;">
                        <h4 class="fw-bold text-primary2 mb-1"><?= $kafe['total_responden'] ?? 0; ?></h4>
                        <small class="text-muted">Responden</small>
                    </div>
                    <?php if ($kafe['nilai_wsm']): ?>
                        <div class="bg-white rounded shadow-sm p-3 flex-fill" style="max-width: 160px;">
                            <h4 class="fw-bold text-primary2 mb-1"><?= $kafe['nilai_wsm']; ?></h4>
                            <small class="text-muted">Nilai WSM</small>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Detail Penilaian -->
                <div class="bg-white rounded shadow-sm p-4" style="border: 1px solid var(--accent);">
                    <!-- DETAIL PENILAIAN -->
                    <div class="info-card">
                        <h5>
                            <i class="bi bi-star-fill"></i>
                            Rating & Penilaian
                        </h5>

                        <div class="row g-3 mt-3">
                            <?php
                            $criteria = [
                                'Rasa Kopi' => $kafe['rasa_kopi'] ?? 0,
                                'Pelayanan' => $kafe['pelayanan'] ?? 0,
                                'Fasilitas' => $kafe['fasilitas'] ?? 0,
                                'Suasana' => $kafe['suasana'] ?? 0,
                                'Harga' => $kafe['harga_rating'] ?? 0,
                            ];
                            ?>
                            <?php foreach ($criteria as $label => $value): ?>
                                <div class="col-12 col-md-6 d-flex align-items-center gap-3">
                                    <div style="flex: 1;">
                                        <strong>
                                            <?= htmlspecialchars($label) ?>
                                        </strong>
                                        <div class="d-flex align-items-center gap-2 mt-1">
                                            <!-- Icon bintang untuk nilai -->
                                            <i class="bi bi-star-fill text-warning" style="font-size: 1rem;"></i>
                                            <span><?= number_format($value, 1); ?> / 5.0</span>
                                        </div>
                                    </div>
                                    <div class="progress" style="width: 50%; height: 8px; border-radius: 4px;">
                                        <div class="progress-bar" role="progressbar" style="width: <?= ($value / 5) * 100 ?>%; background: var(--primary);" aria-valuenow="<?= $value ?>" aria-valuemin="0" aria-valuemax="5"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Kafe -->
                <?php if (!empty($kafe['deskripsi'])) : ?>
                    <div class="bg-white rounded shadow-sm p-4 mt-4" style="border: 1px solid var(--accent);">
                        <h5 class="fw-bold mb-3 text-primary2"><i class="bi bi-info-circle-fill me-2"></i>Tentang Kafe</h5>
                        <p><?= nl2br(htmlspecialchars($kafe['deskripsi'])); ?></p>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Kanan: Info umum & fasilitas & data clustering -->
            <div class="col-12 col-lg-4">

                <!-- Info Umum -->
                <div class="bg-white rounded shadow-sm p-4 mb-4" style="border: 1px solid var(--accent);">
                    <h5 class="fw-bold mb-3 text-primary2"><i class="bi bi-info-square-fill me-2"></i>Informasi Umum</h5>
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-geo-alt-fill fs-5 text-primary2"></i>
                        <span><?= htmlspecialchars($kafe['alamat']) ?: '<em>Belum diisi</em>'; ?></span>
                    </div>
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-cash-stack fs-5 text-primary2"></i>
                        <span>Kisaran Harga Rp<?= number_format($kafe['harga_terendah'] ?? 0) ?> - Rp<?= number_format($kafe['harga_tertinggi'] ?? 0) ?></span>
                    </div>
                    <?php if (!empty($kafe['fasilitas'])): ?>
                        <div class="mb-2 d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-primary2" style="font-size: 1.2rem;"></i>
                            <span><strong>Fasilitas:</strong> <?= htmlspecialchars(number_format($kafe['fasilitas'], 1)); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($kafe['jam_buka'])): ?>
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-clock-fill fs-5 text-primary2"></i>
                            <span>Jam Operasional: <?= htmlspecialchars($kafe['jam_buka']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($kafe['no_telepon'])): ?>
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-telephone-fill fs-5 text-primary2"></i>
                            <a href="tel:<?= htmlspecialchars($kafe['no_telepon']); ?>" style="color: var(--primary2); text-decoration: none;">
                                <?= htmlspecialchars($kafe['no_telepon']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Data Clustering -->
                <?php if (!empty($latestCluster['cluster'])): ?>
                    <div class="bg-white rounded shadow-sm p-4" style="border: 1px solid var(--accent);">
                        <h5 class="fw-bold mb-3 text-primary2"><i class="bi bi-diagram-3-fill me-2"></i>Data Clustering</h5>
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-award-fill fs-4 text-<?= $clusterColor[$latestCluster['cluster']] ?? 'secondary'; ?>"></i>
                            <span>Cluster: <span class="badge bg-<?= $clusterColor[$latestCluster['cluster']]; ?> px-3 py-2"><?= $clusterLabel[$latestCluster['cluster']]; ?></span></span>
                        </div>
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-trophy-fill fs-5 text-warning"></i>
                            <span>Peringkat: #<?= $latestCluster['peringkat_cluster']; ?> di cluster ini</span>
                        </div>
                        <div class="mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-bullseye fs-5 text-primary"></i>
                            <span>Jarak Centroid: <code><?= number_format($latestCluster['jarak_centroid'], 6); ?></code></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- tombol aksi -->
                <div class="d-grid gap-3 mt-4">
                    <a href="index.php" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kafe
                    </a>
                    <a href="cari_kafe.php" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari Kafe Lain
                    </a>
                </div>

            </div>
        </div>

    </div>

    <!-- Footer -->
    <?php require_once 'footer.php'; ?>

    <?php require_once 'assets/js.php'; ?>

</body>

</html>