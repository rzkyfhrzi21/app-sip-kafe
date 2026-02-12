<?php
// =====================================================
// pages/mulai_clustering.php
// Upload dataset & proses clustering K-Means + WSM
// =====================================================

if (!isset($_SESSION['sesi_id'])) {
    return;
}

?>

<!-- Custom Loading Style -->
<style>
    .swal2-popup.swal2-loading {
        padding: 2rem;
    }

    .custom-loader {
        width: 80px;
        height: 80px;
        border: 8px solid #f3f3f3;
        border-top: 8px solid #435ebe;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .loading-text {
        font-size: 1.1rem;
        color: #435ebe;
        font-weight: 600;
        margin-top: 1rem;
    }

    .loading-steps {
        text-align: left;
        margin-top: 1.5rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .loading-steps li {
        padding: 0.5rem 0;
        color: #6c757d;
        position: relative;
        padding-left: 2rem;
        font-size: 0.95rem;
    }

    .loading-steps li.active {
        color: #435ebe;
        font-weight: 600;
    }

    .loading-steps li.active::before {
        content: "⏳";
        position: absolute;
        left: 0;
        animation: pulse 1s infinite;
    }

    .loading-steps li.completed::before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #28a745;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .info-box {
        background: #e7f3ff;
        border-left: 4px solid #435ebe;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }

    .info-box h6 {
        color: #435ebe;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .info-box ul {
        margin: 0.5rem 0 0 0;
        padding-left: 2rem;
    }

    .info-box li {
        color: #495057;
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }

    /* Spacing untuk card */
    .card {
        margin-bottom: 2rem;
    }

    .card-body {
        padding: 2rem;
    }

    .card-header {
        padding: 1.25rem 1.5rem;
    }

    .card-footer {
        padding: 1.25rem 1.5rem;
    }

    /* Spacing untuk form groups */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .row {
        margin-bottom: 1rem;
    }

    .col-md-6 {
        margin-bottom: 1.5rem;
    }

    /* Input styling */
    .bobot-input {
        transition: all 0.3s ease;
        height: 45px;
        font-size: 1rem;
    }

    .bobot-input:focus {
        border-color: #435ebe;
        box-shadow: 0 0 0 0.2rem rgba(67, 94, 190, 0.25);
    }

    .input-group-text {
        min-width: 50px;
        justify-content: center;
        font-weight: 600;
    }

    /* Label styling */
    .form-label {
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    /* Badge total bobot */
    #totalBobot {
        transition: all 0.3s ease;
        font-size: 1.3rem !important;
        padding: 0.6rem 1.2rem;
        min-width: 80px;
    }

    /* Alert styling */
    .alert {
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border-radius: 8px;
    }

    .alert i {
        margin-right: 0.5rem;
    }

    /* Card header gradient */
    .card-header.bg-primary {
        background: linear-gradient(135deg, #435ebe 0%, #5a6fd8 100%) !important;
    }

    .card-header.bg-success {
        background: linear-gradient(135deg, #198754 0%, #28a745 100%) !important;
    }

    /* FilePond custom style */
    .filepond--root {
        margin-bottom: 0;
    }

    .filepond--drop-label {
        min-height: 150px;
    }

    /* Button styling */
    .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    #btnSubmit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    #btnSubmit:not(:disabled):hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }

        .info-box {
            padding: 1.25rem;
            font-size: 0.9rem;
        }

        .custom-loader {
            width: 60px;
            height: 60px;
            border-width: 6px;
        }

        .loading-text {
            font-size: 1rem;
        }

        .col-md-6 {
            margin-bottom: 1rem;
        }

        .loading-steps {
            font-size: 0.85rem;
        }
    }

    /* Icon spacing */
    i.bi {
        margin-right: 0.5rem;
    }
</style>

<div class="page-heading">
    <div class="page-title mb-4">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>Mulai Clustering</h3>
                <p class="text-subtitle text-muted">
                    Upload dataset kuisioner untuk proses clustering kafe dengan metode K-Means & WSM.
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

        <!-- ================= INFO BOX: PENJELASAN WSM ================= -->
        <div class="info-box">
            <h6><i class="bi bi-info-circle-fill"></i> Tentang Weighted Sum Model (WSM)</h6>
            <p class="mb-2">
                WSM digunakan sebagai metode pendukung untuk menghitung nilai akhir setiap kafe berdasarkan bobot kriteria:
            </p>
            <ul class="mb-0">
                <li><strong>Rasa Kopi:</strong> Kualitas utama yang menjadi prioritas</li>
                <li><strong>Pelayanan:</strong> Kecepatan & keramahan staff</li>
                <li><strong>Fasilitas:</strong> WiFi, AC, toilet, parkir</li>
                <li><strong>Suasana:</strong> Kenyamanan & estetika tempat</li>
                <li><strong>Harga:</strong> Keterjangkauan harga menu</li>
                <li><strong>Rating:</strong> Penilaian keseluruhan konsumen</li>
            </ul>
        </div>

        <form action="../functions/function_clustering.php"
            method="post"
            enctype="multipart/form-data"
            id="formClustering"
            data-parsley-validate>

            <!-- ================= CARD 1: BOBOT KRITERIA WSM ================= -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-sliders"></i>
                        Bobot Kriteria (Weighted Sum Model)
                    </h5>
                </div>

                <div class="card-body">
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-lightbulb-fill"></i>
                        <strong>Catatan:</strong> Total bobot harus = 100%. Bobot menentukan tingkat kepentingan setiap kriteria.
                    </div>

                    <div class="row">
                        <!-- Rasa Kopi -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-cup-hot-fill text-danger"></i> Rasa Kopi
                                </label>
                                <div class="input-group">
                                    <input type="number"
                                        name="bobot_rasa"
                                        id="bobot_rasa"
                                        class="form-control bobot-input"
                                        value="30"
                                        min="0"
                                        max="100"
                                        step="1"
                                        required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Pelayanan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-people-fill text-success"></i> Pelayanan
                                </label>
                                <div class="input-group">
                                    <input type="number"
                                        name="bobot_pelayanan"
                                        id="bobot_pelayanan"
                                        class="form-control bobot-input"
                                        value="20"
                                        min="0"
                                        max="100"
                                        step="1"
                                        required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Fasilitas -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-wifi text-primary"></i> Fasilitas
                                </label>
                                <div class="input-group">
                                    <input type="number"
                                        name="bobot_fasilitas"
                                        id="bobot_fasilitas"
                                        class="form-control bobot-input"
                                        value="15"
                                        min="0"
                                        max="100"
                                        step="1"
                                        required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Suasana -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-stars text-warning"></i> Suasana
                                </label>
                                <div class="input-group">
                                    <input type="number"
                                        name="bobot_suasana"
                                        id="bobot_suasana"
                                        class="form-control bobot-input"
                                        value="15"
                                        min="0"
                                        max="100"
                                        step="1"
                                        required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Harga -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-cash-coin text-info"></i> Harga
                                </label>
                                <div class="input-group">
                                    <input type="number"
                                        name="bobot_harga"
                                        id="bobot_harga"
                                        class="form-control bobot-input"
                                        value="10"
                                        min="0"
                                        max="100"
                                        step="1"
                                        required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-star-fill text-warning"></i> Rating
                                </label>
                                <div class="input-group">
                                    <input type="number"
                                        name="bobot_rating"
                                        id="bobot_rating"
                                        class="form-control bobot-input"
                                        value="10"
                                        min="0"
                                        max="100"
                                        step="1"
                                        required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Bobot -->
                    <div class="alert alert-secondary d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <span class="fw-bold">Total Bobot:</span>
                            <span id="totalBobot" class="badge bg-success ms-2 fs-5">100%</span>
                        </div>
                        <button type="button" id="btnAutoAdjust" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-magic"></i> Auto Sesuaikan
                        </button>
                    </div>
                </div>
            </div>

            <!-- ================= CARD 2: UPLOAD DATASET ================= -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-file-earmark-spreadsheet"></i>
                        Upload Dataset CSV
                    </h5>
                </div>

                <div class="card-body">
                    <div class="alert alert-warning mt-3">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <strong>Format CSV harus sesuai template:</strong>
                        <br>
                        <code class="mt-2 d-block">Nama Kafe;Skor_Rasa;Skor_Pelayanan;Skor_Fasilitas;Skor_Suasana;Skor_Harga;Skor_Rating</code>
                    </div>

                    <div class="form-group">
                        <label class="form-label fw-bold">
                            <i class="bi bi-upload"></i> Pilih File Dataset (CSV)
                        </label>
                        <input type="file"
                            name="dataset_csv"
                            data-max-file-size="10MB"
                            class="filepond-csv"
                            data-parsley-required="true"">
                    </div>
                </div>

                <div class=" card-footer d-flex justify-content-between">
                        <a href="index" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit"
                            name="btn_mulai_clustering"
                            id="btnSubmit"
                            class="btn btn-success btn-lg px-5">
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

        // =====================================================
        // VALIDASI TOTAL BOBOT WSM (HARUS 100%)
        // =====================================================
        const bobotInputs = document.querySelectorAll('.bobot-input');
        const totalBobotEl = document.getElementById('totalBobot');
        const btnSubmit = document.getElementById('btnSubmit');

        function hitungTotalBobot() {
            let total = 0;
            bobotInputs.forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            totalBobotEl.textContent = total + '%';

            // Validasi total = 100%
            if (total === 100) {
                totalBobotEl.classList.remove('bg-danger');
                totalBobotEl.classList.add('bg-success');
                btnSubmit.disabled = false;
            } else {
                totalBobotEl.classList.remove('bg-success');
                totalBobotEl.classList.add('bg-danger');
                btnSubmit.disabled = true;
            }
        }

        bobotInputs.forEach(input => {
            input.addEventListener('input', hitungTotalBobot);
        });

        // Hitung saat load
        hitungTotalBobot();

        // =====================================================
        // AUTO-ADJUST BOBOT
        // =====================================================
        const btnAutoAdjust = document.getElementById('btnAutoAdjust');

        btnAutoAdjust.addEventListener('click', function() {
            const inputs = Array.from(bobotInputs);
            const currentTotal = inputs.reduce((sum, input) =>
                sum + (parseFloat(input.value) || 0), 0
            );

            if (currentTotal === 0) {
                // Bagi rata jika semua 0
                const equalValue = Math.floor(100 / inputs.length);
                inputs.forEach((input, index) => {
                    input.value = index === 0 ?
                        100 - (equalValue * (inputs.length - 1)) : equalValue;
                });
            } else {
                // Proporsi sesuai nilai saat ini
                inputs.forEach(input => {
                    const currentValue = parseFloat(input.value) || 0;
                    const newValue = Math.round((currentValue / currentTotal) * 100);
                    input.value = newValue;
                });

                // Koreksi pembulatan agar tepat 100%
                const newTotal = inputs.reduce((sum, input) =>
                    sum + parseFloat(input.value), 0
                );
                if (newTotal !== 100) {
                    inputs[0].value = parseFloat(inputs[0].value) + (100 - newTotal);
                }
            }

            hitungTotalBobot();
        });

        // =====================================================
        // INISIALISASI FILEPOND
        // =====================================================
        if (window.FilePond) {
            FilePond.parse(document.body);
        }

        // =====================================================
        // LOADING ANIMATION - MUNCUL SETELAH VALIDASI LOLOS
        // =====================================================
        const form = document.getElementById('formClustering');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // ========== VALIDASI CLIENT-SIDE ==========

            // 1. Validasi total bobot
            let total = 0;
            bobotInputs.forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            if (total !== 100) {
                Swal.fire({
                    icon: 'error',
                    title: 'Bobot Tidak Valid',
                    text: 'Total bobot harus 100%! Saat ini: ' + total + '%',
                    confirmButtonColor: '#435ebe'
                });
                return;
            }

            // 2. Validasi file upload
            const fileInput = document.querySelector('input[name="dataset_csv"]');
            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'File Belum Dipilih',
                    text: 'Silakan pilih file CSV terlebih dahulu!',
                    confirmButtonColor: '#435ebe'
                });
                return;
            }

            // ========== SEMUA VALIDASI LOLOS ==========
            // Tampilkan loading dengan step animation

            let currentStep = 0;
            const steps = [
                'Memvalidasi file CSV...',
                'Membaca dataset...',
                'Menghitung nilai WSM...',
                'Normalisasi data...',
                'Proses K-Means Clustering...',
                'Menyimpan hasil clustering...',
                'Finalisasi data...'
            ];

            Swal.fire({
                title: 'Proses Clustering Sedang Berjalan',
                html: `
                    <div class="custom-loader"></div>
                    <div class="loading-text" id="currentStep">Memulai proses...</div>
                    <div class="loading-steps">
                        <ol id="stepsList">
                            ${steps.map((step, index) => 
                                `<li id="step-${index}">${step}</li>`
                            ).join('')}
                        </ol>
                    </div>
                `,
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    // Animasi step berjalan setiap 2 detik
                    const interval = setInterval(() => {
                        if (currentStep < steps.length) {
                            // Mark previous step as completed
                            if (currentStep > 0) {
                                const prevStep = document.getElementById(`step-${currentStep - 1}`);
                                if (prevStep) {
                                    prevStep.classList.add('completed');
                                    prevStep.classList.remove('active');
                                }
                            }

                            // Mark current step as active
                            const currStep = document.getElementById(`step-${currentStep}`);
                            if (currStep) {
                                currStep.classList.add('active');
                            }

                            // Update text
                            const stepText = document.getElementById('currentStep');
                            if (stepText) {
                                stepText.textContent = steps[currentStep];
                            }

                            currentStep++;
                        } else {
                            // All steps shown, keep last one active
                            clearInterval(interval);
                        }
                    }, 2000);
                }
            });

            // ========== TAMBAHKAN HIDDEN INPUT ==========
            // Ini penting agar btn_mulai_clustering terkirim
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'btn_mulai_clustering';
            hiddenInput.value = '1';
            form.appendChild(hiddenInput);

            // Submit form setelah loading muncul
            setTimeout(() => {
                form.submit();
            }, 100);
        });

    });
</script>