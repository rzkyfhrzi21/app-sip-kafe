<?php
require_once 'config/config.php';

$keyword = $_GET['q'] ?? '';
$filter = $_GET['filter'] ?? 'all';

// Build query condition and order by
$whereClause = "1=1";
$orderBy = "rating DESC";

if (!empty($keyword)) {
    $keyword_safe = mysqli_real_escape_string($koneksi, $keyword);
    $whereClause .= " AND (k.nama_kafe LIKE '%$keyword_safe%' OR k.alamat LIKE '%$keyword_safe%')";
}

switch ($filter) {
    case 'rating':
        $orderBy = "rating DESC";
        break;
    case 'harga':
        $orderBy = "k.harga_terendah ASC";
        break;
    case 'nama':
        $orderBy = "k.nama_kafe ASC";
        break;
    default:
        $orderBy = "rating DESC";
}

$sql = "
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
    FROM kafe k
    LEFT JOIN hasil_clustering hc ON hc.id_kafe = k.id_kafe
    LEFT JOIN hasil_kuisioner hq ON hq.id_kafe = k.id_kafe
    WHERE $whereClause
    GROUP BY k.id_kafe
    ORDER BY $orderBy
    LIMIT 50
";

$q = mysqli_query($koneksi, $sql);
$total_results = mysqli_num_rows($q);

$clusterColor = [1 => 'success', 2 => 'warning', 3 => 'danger'];
$clusterLabel = [1 => 'Kualitas Tinggi', 2 => 'Kualitas Sedang', 3 => 'Kualitas Rendah'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
    <meta name="description" content="Cari kafe favorit di Bandar Lampung berdasarkan nama, lokasi, dan rating" />
    <meta name="theme-color" content="#7b4b2a" />

    <title>Cari Kafe - <?= NAMA_WEB ?></title>
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon" />

    <?php require_once 'assets/css.php'; ?>
</head>

<body>

    <!-- NAVBAR -->
    <?php require_once 'navbar.php'; ?>

    <div class="container mt-4 mb-5">

        <!-- SEARCH SECTION -->
        <div class="search-section">
            <h3 class="text-center mb-3" style="color: var(--primary2);">
                <i class="bi bi-search"></i> Cari Kafe Favorit
            </h3>
            <p class="text-center text-muted mb-4">
                Temukan kafe berdasarkan nama atau lokasi
            </p>

            <form method="GET" action="cari_kafe.php" class="mb-4">
                <div class="search-box position-relative">
                    <input type="text" name="q" class="form-control form-control-lg" placeholder="Cari nama kafe atau lokasi..." value="<?= htmlspecialchars($keyword); ?>" autocomplete="off" />
                    <button type="submit" class="search-icon border-0 bg-transparent" aria-label="Cari">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

                <?php if (!empty($keyword)) : ?>
                    <div class="text-center mt-3">
                        <a href="cari_kafe.php" class="btn btn-sm btn-coffee-outline">
                            <i class="bi bi-x-circle"></i> Hapus Pencarian
                        </a>
                    </div>
                <?php endif; ?>
            </form>

            <!-- FILTER BUTTONS -->
            <div class="filter-buttons text-center mb-4" style="font-size: 0.9rem;">
                <a href="?q=<?= urlencode($keyword); ?>&filter=all" class="filter-btn <?= $filter == 'all' ? 'active' : '' ?>">
                    <i class="bi bi-grid-3x3-gap-fill"></i> Semua
                </a>
                <a href="?q=<?= urlencode($keyword); ?>&filter=rating" class="filter-btn <?= $filter == 'rating' ? 'active' : '' ?>">
                    <i class="bi bi-star-fill"></i> Rating Tertinggi
                </a>
                <a href="?q=<?= urlencode($keyword); ?>&filter=harga" class="filter-btn <?= $filter == 'harga' ? 'active' : '' ?>">
                    <i class="bi bi-cash-coin"></i> Harga Terjangkau
                </a>
                <a href="?q=<?= urlencode($keyword); ?>&filter=nama" class="filter-btn <?= $filter == 'nama' ? 'active' : '' ?>">
                    <i class="bi bi-sort-alpha-down"></i> Nama A-Z
                </a>
            </div>

            <!-- ALERT HASIL PENCARIAN -->
            <?php if (!empty($keyword)) : ?>
                <div class="alert alert-info d-flex align-items-center justify-content-between" role="alert">
                    <div>
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Ditemukan <strong><?= $total_results; ?></strong> kafe untuk pencarian "<strong><?= htmlspecialchars($keyword); ?></strong>"
                    </div>
                </div>
            <?php endif; ?>

            <!-- KAFE GRID -->
            <div class="row g-3 g-md-4">
                <?php if ($total_results > 0) : ?>
                    <?php while ($r = mysqli_fetch_assoc($q)) : ?>
                        <?php
                        $foto = !empty($r['foto_kafe']) ? $r['foto_kafe'] : 'default.jpg';
                        $foto_url = "dashboard/assets/foto_kafe/" . htmlspecialchars($foto);
                        ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="card kafe-card">
                                <div class="position-relative">
                                    <img src="<?= $foto_url ?>" class="card-img-top" alt="<?= htmlspecialchars($r['nama_kafe']); ?>" onerror="this.src='dashboard/assets/foto_kafe/foto_kafe.jpg'" />
                                    <?php if ($r['peringkat_cluster']) : ?>
                                        <span class="badge-rank">
                                            #<?= $r['peringkat_cluster']; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($r['nama_kafe']); ?></h5>
                                    <?php if ($r['cluster']) : ?>
                                        <div class="mb-2">
                                            <span class="badge badge-cluster bg-<?= $clusterColor[$r['cluster']]; ?>">
                                                <?= $clusterLabel[$r['cluster']]; ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="d-flex justify-content-between align-items-center mb-2 rating-wsm">
                                        <span class="rating-stars">
                                            <i class="bi bi-star-fill"></i> <?= $r['rating'] ? number_format($r['rating'], 1) : 'N/A'; ?>
                                        </span>
                                        <?php if ($r['nilai_wsm']) : ?>
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
                                    <a href="detail_kafe.php?id=<?= $r['id_kafe']; ?>" class="btn btn-primary btn-sm w-100">
                                        <i class="bi bi-eye-fill"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="col-12">
                        <div class="alert alert-warning text-center py-5">
                            <i class="bi bi-search fs-1 d-block mb-3" style="color: var(--primary);"></i>
                            <h4>Kafe Tidak Ditemukan</h4>
                            <p class="mb-3">
                                <?php if (!empty($keyword)) : ?>
                                    Tidak ada kafe yang cocok dengan pencarian "<strong><?= htmlspecialchars($keyword); ?></strong>"
                                <?php else : ?>
                                    Silakan masukkan kata kunci untuk mencari kafe
                                <?php endif; ?>
                            </p>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <a href="cari_kafe.php" class="btn btn-coffee">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset Pencarian
                                </a>
                                <a href="index.php" class="btn btn-coffee-outline">
                                    <i class="bi bi-house-fill"></i> Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php require_once 'footer.php'; ?>
        <?php require_once 'assets/js.php'; ?>

        <script>
            // Untuk fokus otomatis pada search input desktop
            document.addEventListener("DOMContentLoaded", function() {
                const searchInput = document.querySelector('input[name="q"]');
                if (searchInput && window.innerWidth > 768) {
                    searchInput.focus();
                }
            });

            // Smooth scroll helper
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

            // Highlight keyword pada nama kafe hasil pencarian
            const keyword = "<?= htmlspecialchars($keyword); ?>";
            if (keyword) {
                const regex = new RegExp(`(${keyword})`, 'gi');
                document.querySelectorAll('.card-title').forEach(title => {
                    title.innerHTML = title.textContent.replace(regex, '<mark style="background: var(--accent); color: var(--primary2); padding: 2px 3px; border-radius: 3px;">$1</mark>');
                });
            }
        </script>

</body>

</html>