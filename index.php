<?php
require_once 'config/config.php';

// Ambil cluster terbaru
$qLast = mysqli_query($koneksi, "SELECT MAX(id_cluster) AS last_id FROM clustering");
$idCluster = (int) mysqli_fetch_assoc($qLast)['last_id'];

// Hitung statistik untuk hero section
$qStats = mysqli_query($koneksi, "
    SELECT 
        COUNT(DISTINCT k.id_kafe) as total_kafe,
        COUNT(DISTINCT hq.id_kuisioner) as total_responden,
        ROUND(AVG(hq.rating), 1) as avg_rating
    FROM kafe k
    LEFT JOIN hasil_kuisioner hq ON hq.id_kafe = k.id_kafe
");
$stats = mysqli_fetch_assoc($qStats);

// Filter
$filter = $_GET['filter'] ?? 'all';
$filterSQL = "";
$orderBy = "hc.peringkat_cluster ASC";

switch ($filter) {
    case 'harga':
        $orderBy = "k.harga_terendah ASC";
        break;
    case 'rating':
        $orderBy = "rating DESC";
        break;
    case 'cluster1':
        $filterSQL = " AND hc.cluster = 1 ";
        break;
    case 'cluster2':
        $filterSQL = " AND hc.cluster = 2 ";
        break;
    case 'cluster3':
        $filterSQL = " AND hc.cluster = 3 ";
        break;
    default:
        $filterSQL = "";
}

// Query ranking kafe
$q = mysqli_query($koneksi, "
    SELECT 
        k.id_kafe,
        k.nama_kafe,
        k.foto_kafe,
        k.alamat,
        k.harga_terendah,
        k.harga_tertinggi,
        hc.cluster,
        hc.peringkat_cluster,
        ROUND(AVG(hq.rating), 2) AS rating,
        ROUND(AVG(hq.nilai_wsm), 2) AS nilai_wsm
    FROM hasil_clustering hc
    JOIN kafe k ON k.id_kafe = hc.id_kafe
    LEFT JOIN hasil_kuisioner hq ON hq.id_kafe = k.id_kafe
    WHERE hc.id_cluster = '$idCluster' $filterSQL
    GROUP BY hc.id_hasil
    ORDER BY $orderBy
");

$clusterColor = [1 => 'success', 2 => 'warning', 3 => 'danger'];
$clusterLabel = [1 => 'Kualitas Tinggi', 2 => 'Kualitas Sedang', 3 => 'Kualitas Rendah'];

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
    <meta name="description" content="Temukan kafe terbaik di Bandar Lampung berdasarkan rating dan kualitas pelayanan" />
    <meta name="theme-color" content="#7b4b2a" />

    <title>Peringkat Kafe Terbaik Bandar Lampung - <?= NAMA_WEB ?></title>
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon" />

    <?php include 'assets/css.php'; ?>
</head>

<body>

    <!-- NAVBAR -->
    <?php include 'navbar.php'; ?>

    <!-- HERO SECTION -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>☕ Peringkat Kafe Terbaik<br>Bandar Lampung</h1>
                <p>Temukan kafe favorit berdasarkan rating dan kualitas pelayanan terbaik</p>

                <div class="hero-stats">
                    <div class="hero-stat-item">
                        <span class="stat-number"><?= $stats['total_kafe'] ?? 0 ?></span>
                        <span class="stat-label">Kafe Terdaftar</span>
                    </div>
                    <div class="hero-stat-item">
                        <span class="stat-number"><?= $stats['total_responden'] ?? 0 ?></span>
                        <span class="stat-label">Responden</span>
                    </div>
                    <div class="hero-stat-item">
                        <span class="stat-number"><?= $stats['avg_rating'] ?? 0 ?></span>
                        <span class="stat-label">Rating Rata-rata</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-4 mb-5">

        <!-- FILTER SECTION -->
        <div class="filter-section">
            <div class="filter-buttons">
                <a href="?filter=all" class="filter-btn <?= $filter == 'all' ? 'active' : '' ?>">
                    <i class="bi bi-grid-3x3-gap-fill"></i> Semua
                </a>
                <a href="?filter=rating" class="filter-btn <?= $filter == 'rating' ? 'active' : '' ?>">
                    <i class="bi bi-star-fill"></i> Rating Tertinggi
                </a>
                <a href="?filter=harga" class="filter-btn <?= $filter == 'harga' ? 'active' : '' ?>">
                    <i class="bi bi-cash-coin"></i> Harga Terjangkau
                </a>
                <a href="?filter=cluster1" class="filter-btn <?= $filter == 'cluster1' ? 'active' : '' ?>">
                    <i class="bi bi-award-fill"></i> Kualitas Tinggi
                </a>
                <a href="?filter=cluster2" class="filter-btn <?= $filter == 'cluster2' ? 'active' : '' ?>">
                    <i class="bi bi-star-half"></i> Kualitas Sedang
                </a>
                <a href="?filter=cluster3" class="filter-btn <?= $filter == 'cluster3' ? 'active' : '' ?>">
                    <i class="bi bi-cup-hot"></i> Kualitas Standar
                </a>
            </div>
        </div>

        <!-- HASIL PENCARIAN -->
        <?php if (isset($_GET['filter']) && $_GET['filter'] != 'all'): ?>
            <div class="alert alert-info d-flex align-items-center mb-4" role="alert" style="font-size: 0.95rem;">
                <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                Menampilkan kafe dengan filter: <strong><?= htmlspecialchars(ucwords(str_replace('cluster', 'Cluster ', $filter))) ?></strong>
            </div>
        <?php endif; ?>

        <!-- KAFE GRID -->
        <div class="row g-3 g-md-4">
            <?php if (mysqli_num_rows($q) > 0): ?>
                <?php while ($r = mysqli_fetch_assoc($q)): ?>
                    <?php
                    $foto = !empty($r['foto_kafe']) ? $r['foto_kafe'] : 'default.jpg';
                    $foto_url = "dashboard/assets/foto_kafe/" . htmlspecialchars($foto);
                    ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card kafe-card">
                            <div class="position-relative">
                                <img src="<?= $foto_url ?>"
                                    class="card-img-top"
                                    alt="<?= htmlspecialchars($r['nama_kafe']); ?>"
                                    onerror="this.src='dashboard/assets/foto_kafe/foto_kafe.jpg'">

                                <?php if ($r['peringkat_cluster']): ?>
                                    <span class="badge-rank">
                                        #<?= $r['peringkat_cluster']; ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= htmlspecialchars($r['nama_kafe']); ?>
                                </h5>

                                <?php if ($r['cluster']): ?>
                                    <div class="mb-2">
                                        <span class="badge badge-cluster bg-<?= $clusterColor[$r['cluster']]; ?>">
                                            <?= $clusterLabel[$r['cluster']]; ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <div class="d-flex justify-content-between align-items-center mb-2 rating-wsm">
                                    <span class="rating-stars">
                                        <i class="bi bi-star-fill"></i>
                                        <?= $r['rating'] ? number_format($r['rating'], 1) : 'N/A'; ?>
                                    </span>
                                    <?php if ($r['nilai_wsm']): ?>
                                        <small class="badge-wsm-public">
                                            WSM: <?= $r['nilai_wsm']; ?>
                                        </small>
                                    <?php endif; ?>
                                </div>

                                <p class="text-muted info-text mb-2">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <?= strlen($r['alamat']) > 30 ? substr(htmlspecialchars($r['alamat']), 0, 30) . '...' : htmlspecialchars($r['alamat']); ?>
                                </p>

                                <p class="text-muted info-text mb-3">
                                    <i class="bi bi-cash-stack"></i>
                                    Rp<?= number_format($r['harga_terendah']); ?> - Rp<?= number_format($r['harga_tertinggi']); ?>
                                </p>

                                <a href="detail_kafe.php?id=<?= $r['id_kafe']; ?>"
                                    class="btn btn-primary btn-sm w-100">
                                    <i class="bi bi-eye-fill"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center py-5">
                        <i class="bi bi-search fs-1 d-block mb-3" style="color: var(--primary);"></i>
                        <h4>Kafe Tidak Ditemukan</h4>
                        <p class="mb-3">Silakan coba filter lain atau kembali ke semua kafe</p>
                        <a href="index.php" class="btn btn-coffee mt-3">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>

    <?php include 'assets/js.php'; ?>

    <script>
        // Auto focus search input on desktop
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.querySelector('input[name="q"]');
            if (searchInput && window.innerWidth > 768) {
                searchInput.focus();
            }
        });

        // Smooth scroll anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Auto close navbar on mobile after click
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        const navbarCollapse = document.querySelector('.navbar-collapse');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                        toggle: false
                    });
                    bsCollapse.hide();
                }
            });
        });

        // Highlight keyword in card titles
        const keyword = <?= json_encode($keyword); ?>;
        if (keyword) {
            const regex = new RegExp(`(${keyword})`, 'gi');
            document.querySelectorAll('.card-title').forEach(title => {
                title.innerHTML = title.textContent.replace(regex, '<mark style="background: var(--accent); color: var(--primary2); padding: 2px 3px; border-radius: 3px;">$1</mark>');
            });
        }
    </script>
</body>

</html>