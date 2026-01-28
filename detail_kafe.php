<?php
require_once 'config/config.php';

$id = (int) ($_GET['id'] ?? 0);
if (!$id) die('Kafe tidak ditemukan');

$q = mysqli_query($koneksi, "
    SELECT 
        k.*,
        AVG(hq.rating) AS rating
    FROM kafe k
    LEFT JOIN hasil_kuisioner hq ON hq.id_kafe = k.id_kafe
    WHERE k.id_kafe = '$id'
    GROUP BY k.id_kafe
");

$kafe = mysqli_fetch_assoc($q);
if (!$kafe) die('Data tidak ditemukan');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($kafe['nama_kafe']); ?> - <?= NAMA_WEB ?></title>

    <?php include 'dashboard/pages/css.php'; ?>
    <link rel="stylesheet" href="assets/public.css">
</head>

<body>

    <nav class="navbar navbar-light bg-white shadow-sm">
        <div class="container">
            <a href="index.php" class="btn btn-sm btn-outline-secondary">
                ← Kembali
            </a>
        </div>
    </nav>

    <div class="container mt-4">

        <div class="row">
            <div class="col-md-6">
                <img src="assets/foto_kafe/<?= htmlspecialchars($kafe['foto_kafe']); ?>"
                    class="img-fluid rounded"
                    onerror="this.src='dashboard/assets/foto_kafe/foto_kafe.jpg'">
            </div>

            <div class="col-md-6">
                <h2><?= htmlspecialchars($kafe['nama_kafe']); ?></h2>

                <p class="text-muted mb-2">
                    Rating <?= number_format($kafe['rating'], 2); ?> ★
                </p>

                <ul class="list-group list-group-flush mt-3">
                    <li class="list-group-item">Harga: Rp<?= number_format($kafe['harga_terendah']); ?> - Rp<?= number_format($kafe['harga_tertinggi']); ?></li>
                    <li class="list-group-item">Alamat: <?= htmlspecialchars($kafe['alamat']); ?></li>
                    <li class="list-group-item">Fasilitas: <?= htmlspecialchars($kafe['fasilitas']); ?></li>
                </ul>
            </div>
        </div>

    </div>

    <?php include 'dashboard/pages/js.php'; ?>
</body>

</html>