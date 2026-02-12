<?php
// =====================================================
// pages/mulai_clustering.php (FINAL)
// - Upload dataset CSV
// - Tanpa modal
// - Action: function_clustering.php
// =====================================================

if (!isset($_SESSION['sesi_id'])) {
    return;
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>Mulai Clustering</h3>
                <p class="text-subtitle text-muted">
                    Upload dataset kuisioner untuk proses clustering kafe.
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

        <form action="../functions/function_clustering.php"
            method="post"
            enctype="multipart/form-data"
            data-parsley-validate>

            <!-- ================= CARD 1 : UPLOAD DATASET ================= -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mb-0">Upload Dataset</h2>
                </div>

                <div class="card-body">
                    <div class="form-group mandatory has-icon-left">
                        <label class="form-label">File Dataset (CSV)</label>
                        <div class="position-relative">
                            <p class="mb-1">
                                <code>
                                    * Format file .csv (hasil kuisioner yang sudah dibersihkan)
                                </code>
                            </p>
                            <input type="file"
                                name="dataset_csv"
                                data-max-file-size="10MB"
                                class="filepond-csv"
                                data-parsley-required="true">

                        </div>
                    </div>

                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit"
                        name="btn_mulai_clustering"
                        class="btn btn-success px-4">
                        <i class="bi bi-diagram-3-fill"></i>
                        Mulai Clustering
                    </button>
                </div>
            </div>

        </form>

    </section>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Inisialisasi FilePond
        if (window.FilePond) {
            FilePond.parse(document.body);
        }

    });
</script>