<?php
// =====================================================
// pages/riwayat_clustering.php (FINAL FIX)
// =====================================================

if (!isset($_SESSION['sesi_id'])) {
    return;
}

// ambil id_cluster terbesar (terbaru)
$qLast = mysqli_query($koneksi, "SELECT MAX(id_cluster) AS last_id FROM clustering");
$last = mysqli_fetch_assoc($qLast);
$id_cluster_terbaru = (int)$last['last_id'];

// ambil semua riwayat clustering
$query = mysqli_query($koneksi, "
    SELECT *
    FROM clustering
    ORDER BY id_cluster DESC
");
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>Riwayat Clustering</h3>
                <p class="text-subtitle text-muted">
                    Riwayat proses clustering dataset kuisioner kafe di bandar lampung.
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

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Riwayat Clustering</h4>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-striped align-middle" id="tabel">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama File CSV</th>
                            <th>Jumlah Cluster</th>
                            <th>Jumlah Data</th>
                            <th>Waktu Clustering</th>
                            <th class="no-export text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($c = mysqli_fetch_assoc($query)):
                            $isTerbaru = ((int)$c['id_cluster'] === $id_cluster_terbaru);
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>

                                <!-- NAMA FILE (KLIK → TAB BARU) -->
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="fw-bold">
                                            <?= htmlspecialchars($c['nama_file']); ?>
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-secondary">
                                        <?= (int)$c['jumlah_cluster']; ?> Cluster
                                    </span>
                                </td>

                                <td>
                                    <?= (int)$c['jumlah_data']; ?> Data
                                </td>

                                <td>
                                    <?= date('d M Y H:i', strtotime($c['waktu_clustering'])); ?>
                                </td>

                                <td class="text-center no-export">
                                    <a href="../functions/function_riwayat_clustering.php?aksi=download&id_cluster=<?= $c['id_cluster']; ?>"
                                        class="btn btn-sm btn-success" title="Download CSV">
                                        <i class="bi bi-download"></i> Download
                                    </a>

                                    <?php if ($isTerbaru): ?>
                                        <!-- ARAHKAN KE HASIL CLUSTERING (cluster terbaru tidak bisa dihapus) -->
                                        <a href="admin?page=Hasil Clustering"
                                            class="btn btn-sm btn-secondary"
                                            title="Riwayat terbaru tidak bisa dihapus, lihat hasil clustering">
                                            <i class="bi bi-eye-fill"></i> Lihat Hasil
                                        </a>
                                    <?php else: ?>
                                        <!-- HAPUS -->
                                        <button class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDeleteClustering"
                                            data-id="<?= $c['id_cluster']; ?>">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </button>
                                    <?php endif; ?>
                                </td>

                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <small class="text-muted d-block mt-2">
                    * Riwayat clustering terbaru tidak dapat dihapus.
                </small>
            </div>
        </div>
    </section>
</div>

<!-- =====================================================
MODAL DELETE RIWAYAT CLUSTERING
===================================================== -->
<div class="modal fade" id="modalDeleteClustering" data-bs-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post"
            action="../functions/function_riwayat_clustering.php"
            class="modal-content">

            <input type="hidden" name="id_cluster" id="delete-id-cluster">

            <input type="hidden" name="aksi" value="delete">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Hapus Riwayat Clustering</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p>
                    Apakah Anda yakin ingin menghapus riwayat clustering ini?
                </p>
                <small class="text-muted">
                    * Saat riwayat clustering dihapus, maka seluruh data pada tabel
                    <b>hasil_clustering</b> yang memiliki
                    <b>id_cluster</b> yang sama juga akan ikut terhapus.
                </small>
            </div>

            <div class="modal-footer">
                <button type="submit"
                    name="btn_delete_clustering"
                    class="btn btn-danger">
                    <i class="bi bi-trash"></i> Ya, Hapus
                </button>
                <button type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Batal
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const deleteIdCluster = document.getElementById('delete-id-cluster');

        document
            .querySelectorAll('[data-bs-target="#modalDeleteClustering"]')
            .forEach(btn => {
                btn.addEventListener('click', function() {
                    deleteIdCluster.value = this.dataset.id;
                });
            });

    });
</script>