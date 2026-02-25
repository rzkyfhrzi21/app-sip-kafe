<?php
// =====================================================
// pages/data_kafe.php (FINAL FIX)
// =====================================================

if (!isset($_SESSION['sesi_id'])) {
    return;
}

$query = mysqli_query($koneksi, "
    SELECT 
        k.*,
        COUNT(h.id_kuisioner) AS total_ulasan
    FROM kafe k
    LEFT JOIN hasil_kuisioner h ON h.id_kafe = k.id_kafe
    GROUP BY k.id_kafe
    ORDER BY k.nama_kafe ASC
");
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>Data Kafe</h3>
                <p class="text-subtitle text-muted">Kelola data kafe dan total ulasan.</p>
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Informasi Detail Kafe</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKafe">
                    <i class="bi bi-plus-circle"></i> Tambah Kafe
                </button>

            </div>

            <div class="card-body table-responsive">
                <table class="table table-striped align-middle" id="tabel">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Kafe</th>
                            <th>Alamat</th>
                            <th>Harga</th>
                            <th>Total Ulasan</th>
                            <th class="no-export" width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($k = mysqli_fetch_assoc($query)):
                            $foto = $k['foto_kafe'] ?: 'default.jpg';
                            $foto_url = "assets/foto_kafe/" . htmlspecialchars($foto);
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>

                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="javascript:void(0)"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalPreviewFoto"
                                            data-img_src="<?= $foto_url ?>"
                                            data-img_nama="<?= htmlspecialchars($k['nama_kafe']) ?>">
                                            <img src="<?= $foto_url ?>"
                                                onerror="this.src='assets/foto_kafe/foto_kafe.jpg'"
                                                style="width:120px;height:120px;object-fit:cover;border-radius:10px;cursor:pointer">
                                        </a>

                                        <div class="fw-bold">
                                            <?= htmlspecialchars($k['nama_kafe']) ?>
                                        </div>
                                    </div>
                                </td>


                                <td><?= htmlspecialchars($k['alamat']) ?></td>

                                <td>
                                    Rp <?= number_format($k['harga_terendah']) ?> –
                                    Rp <?= number_format($k['harga_tertinggi']) ?>
                                </td>

                                <td>
                                    <span class="badge bg-info"><?= (int)$k['total_ulasan'] ?> Ulasan</span>
                                </td>

                                <td class="no-export">
                                    <button class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditKafe"
                                        data-id="<?= $k['id_kafe'] ?>"
                                        data-nama="<?= htmlspecialchars($k['nama_kafe']) ?>"
                                        data-alamat="<?= htmlspecialchars($k['alamat']) ?>"
                                        data-hmin="<?= $k['harga_terendah'] ?>"
                                        data-hmax="<?= $k['harga_tertinggi'] ?>"
                                        data-foto="<?= htmlspecialchars($k['foto_kafe']) ?>">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>

                                    <button class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDeleteKafe"
                                        data-id="<?= $k['id_kafe'] ?>"
                                        data-foto="<?= htmlspecialchars($k['foto_kafe']) ?>">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- ================= MODAL TAMBAH ================= -->
<div class="modal fade" id="modalTambahKafe" data-bs-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form method="post" action="../functions/function_kafe.php"
            enctype="multipart/form-data" class="modal-content" data-parsley-validate>

            <div class="modal-header">
                <h5 class="modal-title">Tambah Kafe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="form-group mandatory has-icon-left">
                    <label class="form-label">Nama Kafe</label>
                    <div class="position-relative">
                        <input type="text" name="nama_kafe" minlength="4"
                            class="form-control" data-parsley-required="true">
                        <div class="form-control-icon"><i class="bi bi-cup-hot"></i></div>
                    </div>
                </div>

                <div class="form-group mandatory has-icon-left mt-2">
                    <label class="form-label">Alamat</label>
                    <div class="position-relative">
                        <textarea name="alamat" minlength="5"
                            class="form-control" data-parsley-required="true"></textarea>
                        <div class="form-control-icon"><i class="bi bi-geo-alt"></i></div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col form-group mandatory has-icon-left">
                        <label>Harga Terendah</label>
                        <div class="position-relative">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_terendah"
                                    min="1000" step="1000"
                                    class="form-control" data-parsley-required="true">
                            </div>
                        </div>
                    </div>

                    <div class="col form-group mandatory has-icon-left">
                        <label>Harga Tertinggi</label>
                        <div class="position-relative">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_tertinggi"
                                    min="1000" step="1000"
                                    class="form-control" data-parsley-required="true">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mandatory has-icon-left mt-2">
                    <label>Foto Kafe</label>
                    <div class="position-relative">
                        <p>
                        <div class="text-bold"><code>* Ukuran file melebihi 1 MB & bukan format gambar tidak akan disimpan</code></div>
                        </p>
                        <input type="file" id="foto_kafe" name="foto_kafe" data-max-file-size="1MB" image-crop-aspect-ratio="1:1" class="image-resize-filepond" required>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" name="btn_add_kafe" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Simpan
                </button>
                <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
            </div>

        </form>
    </div>
</div>

<!-- ================= MODAL EDIT ================= -->
<div class="modal fade" id="modalEditKafe" data-bs-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form method="post" action="../functions/function_kafe.php"
            enctype="multipart/form-data" class="modal-content" data-parsley-validate>

            <input type="hidden" name="id_kafe" id="edit-id">
            <input type="hidden" name="foto_lama" id="edit-foto-lama">

            <div class="modal-header">
                <h5 class="modal-title">Edit Kafe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="form-group mandatory has-icon-left">
                    <label>Nama Kafe</label>
                    <div class="position-relative">
                        <input type="text" id="edit-nama" name="nama_kafe"
                            class="form-control" data-parsley-required="true">
                        <div class="form-control-icon"><i class="bi bi-cup-hot"></i></div>
                    </div>
                </div>

                <div class="form-group mandatory has-icon-left mt-2">
                    <label>Alamat</label>
                    <div class="position-relative">
                        <textarea id="edit-alamat" name="alamat"
                            class="form-control" data-parsley-required="true"></textarea>
                        <div class="form-control-icon"><i class="bi bi-geo-alt"></i></div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col form-group mandatory has-icon-left">
                        <label>Harga Terendah</label>
                        <div class="position-relative">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" id="edit-hmin"
                                    name="harga_terendah"
                                    class="form-control" data-parsley-required="true">
                            </div>
                        </div>
                    </div>

                    <div class="col form-group mandatory has-icon-left">
                        <label>Harga Tertinggi</label>
                        <div class="position-relative">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" id="edit-hmax"
                                    name="harga_tertinggi"
                                    class="form-control" data-parsley-required="true">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group has-icon-left mt-2">
                    <label>Ganti Foto Kafe (Opsional)</label>
                    <div class="position-relative">
                        <p>
                        <div class="text-bold"><code>* Ukuran file melebihi 1 MB & bukan format gambar tidak akan disimpan</code></div>
                        </p>
                        <input type="file" id="editFotoLama" name="foto_kafe" data-max-file-size="1MB" image-crop-aspect-ratio="1:1" class="image-resize-filepond">
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" name="btn_edit_kafe" class="btn btn-warning">
                    <i class="bi bi-save"></i> Update
                </button>
                <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
            </div>

        </form>
    </div>
</div>

<!-- ================= MODAL DELETE ================= -->
<div class="modal fade" id="modalDeleteKafe" data-bs-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="../functions/function_kafe.php" class="modal-content">
            <input type="hidden" name="id_kafe" id="delete-id">
            <input type="hidden" name="foto_kafe" id="delete-foto">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Hapus Kafe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p>Jika kafe memiliki data kuisioner, maka proses hapus akan gagal.</p>
            </div>

            <div class="modal-footer">
                <button type="submit" name="btn_delete_kafe" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Hapus
                </button>
                <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL PREVIEW FOTO ================= -->
<div class="modal fade" id="modalPreviewFoto" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="galleryTitle" class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="galleryImage" class="img-fluid rounded" onerror="this.src='assets/foto_kafe/foto_kafe.jpg'">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // ====== AMBIL ELEMENT EDIT ======
        const editId = document.getElementById('edit-id');
        const editNama = document.getElementById('edit-nama');
        const editAlamat = document.getElementById('edit-alamat');
        const editHmin = document.getElementById('edit-hmin');
        const editHmax = document.getElementById('edit-hmax');
        const editFotoLama = document.getElementById('edit-foto-lama');

        // ====== AMBIL ELEMENT DELETE ======
        const deleteId = document.getElementById('delete-id');
        const deleteFoto = document.getElementById('delete-foto');

        // ====== ISI MODAL EDIT ======
        document.querySelectorAll('[data-bs-target="#modalEditKafe"]').forEach(btn => {
            btn.addEventListener('click', function() {
                editId.value = this.dataset.id;
                editNama.value = this.dataset.nama;
                editAlamat.value = this.dataset.alamat;
                editHmin.value = this.dataset.hmin;
                editHmax.value = this.dataset.hmax;
                editFotoLama.value = this.dataset.foto;
            });
        });

        // ====== ISI MODAL DELETE ======
        document.querySelectorAll('[data-bs-target="#modalDeleteKafe"]').forEach(btn => {
            btn.addEventListener('click', function() {
                deleteId.value = this.dataset.id;
                deleteFoto.value = this.dataset.foto;
            });
        });

        // ====== PREVIEW FOTO ======
        const galleryImage = document.getElementById('galleryImage');
        const galleryTitle = document.getElementById('galleryTitle');

        document.querySelectorAll('[data-bs-target="#modalPreviewFoto"]').forEach(el => {
            el.addEventListener('click', function() {
                galleryImage.src = this.dataset.img_src;
                galleryTitle.innerText = 'Galeri ' + this.dataset.img_nama;
            });
        });

        // ====== FILEPOND ======
        if (window.FilePond) {
            FilePond.parse(document.body);
        }
    });
</script>