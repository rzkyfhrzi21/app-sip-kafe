<?php
// =====================================================
// pages/data_kuisioner.php (FINAL)
// - Read only
// - Relasi hasil_kuisioner + kafe
// - DataTables enabled
// =====================================================

if (!isset($_SESSION['sesi_id'])) {
    return;
}

$query = mysqli_query($koneksi, "
    SELECT 
        h.id_kuisioner,
        k.nama_kafe,
        h.rasa_kopi,
        h.pelayanan,
        h.fasilitas,
        h.suasana,
        h.harga,
        h.rating
    FROM hasil_kuisioner h
    JOIN kafe k ON k.id_kafe = h.id_kafe
    ORDER BY h.id_kuisioner DESC
");
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>Data Kuisioner</h3>
                <p class="text-subtitle text-muted">
                    Daftar hasil penilaian responden terhadap kafe.
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
                <h4 class="card-title mb-0">Tabel Data Kuisioner</h4>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-striped align-middle" id="tabel">
                    <thead>
                        <tr>
                            <th width="60" class="text-center">No</th>
                            <th>Nama Kafe</th>
                            <th>Rasa Kopi</th>
                            <th>Pelayanan</th>
                            <th>Fasilitas</th>
                            <th>Suasana</th>
                            <th>Harga</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php while ($d = mysqli_fetch_assoc($query)) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($d['nama_kafe']); ?></td>
                                <td><?= (int)$d['rasa_kopi']; ?></td>
                                <td><?= (int)$d['pelayanan']; ?></td>
                                <td><?= (int)$d['fasilitas']; ?></td>
                                <td><?= (int)$d['suasana']; ?></td>
                                <td><?= (int)$d['harga']; ?></td>
                                <td>
                                    <?php if ($d['rating'] !== null): ?>
                                        <span class="badge bg-warning text-dark">
                                            <?= number_format($d['rating'], 2); ?> ★
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
                    *Data ini bersifat <b>read-only</b> dan digunakan sebagai sumber analisis & clustering.
                </small>
            </div>
        </div>
    </section>
</div>