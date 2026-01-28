<?php
require_once 'config/config.php';

$keyword = $_GET['q'] ?? '';

$sql = "
    SELECT 
        k.id_kafe,
        k.nama_kafe,
        k.foto_kafe,
        AVG(hq.rating) AS rating
    FROM kafe k
    LEFT JOIN hasil_kuisioner hq ON hq.id_kafe = k.id_kafe
    WHERE k.nama_kafe LIKE '%$keyword%'
    GROUP BY k.id_kafe
    ORDER BY rating DESC
";

$q = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cari Kafe - <?= NAMA_WEB ?></title>

    <?php include 'dashboard/pages/css.php'; ?>
    <link rel="stylesheet" href="assets/public.css">
</head>

<body>

    <nav class="navbar navbar-light bg-white shadow-sm">
        <div class="container">
            <a href="index.php" class="navbar-brand fw-bold"><?= NAMA_WEB ?></a>
        </div>
    </nav>

    <div class="container mt-4">

        <form class="mb-4">
            <input type="text" name="q"
                class="form-control form-control-lg"
                placeholder="Cari nama kafe..."
                value="<?= htmlspecialchars($keyword); ?>">
        </form>

        <div class="row g-3">
            <?php while ($r = mysqli_fetch_assoc($q)): ?>
                <div class="col-12 col-md-4">
                    <div class="card kafe-card">
                        <div class="card-body">
                            <h5><?= htmlspecialchars($r['nama_kafe']); ?></h5>
                            <p class="text-muted"><?= number_format($r['rating'], 2); ?> ★</p>
                            <a href="detail_kafe.php?id=<?= $r['id_kafe']; ?>"
                                class="btn btn-outline-primary btn-sm">
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