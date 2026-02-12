<?php
// =====================================================
// flash_message_handler.php
// Helper untuk menampilkan pesan dari SESSION
// Lokasi: /config/flash_message_handler.php
// =====================================================

/**
 * Fungsi untuk menampilkan flash message dari session
 * Digunakan untuk menampilkan pesan error/success setelah redirect
 */
function show_flash_message()
{
    if (!isset($_SESSION)) {
        session_start();
    }

    // Cek apakah ada flash message
    if (isset($_SESSION['flash_status'])) {
        $status = $_SESSION['flash_status'];
        $action = $_SESSION['flash_action'] ?? '';
        $ket = $_SESSION['flash_ket'] ?? '';
        $msg = $_SESSION['flash_msg'] ?? '';
        $total = $_SESSION['flash_total'] ?? 0;

        // Tentukan tipe alert
        $alert_type = 'info';
        $title = 'Informasi';

        switch ($status) {
            case 'success':
                $alert_type = 'success';
                $title = 'Berhasil!';
                break;
            case 'error':
                $alert_type = 'danger';
                $title = 'Gagal!';
                break;
            case 'warning':
                $alert_type = 'warning';
                $title = 'Peringatan!';
                break;
        }

        // Tentukan pesan berdasarkan ket
        $message = '';
        switch ($ket) {
            case 'invalid_request':
                $message = 'Request tidak valid. Silakan coba lagi.';
                break;
            case 'invalid_weight_total':
                $message = 'Total bobot harus 100%. ' . $msg;
                break;
            case 'file_missing':
                $message = 'File CSV tidak ditemukan atau gagal diupload.';
                break;
            case 'upload_failed':
                $message = 'Gagal mengupload file. Pastikan format file benar.';
                break;
            case 'file_unreadable':
                $message = 'File tidak dapat dibaca. Pastikan file tidak corrupt.';
                break;
            case 'invalid_column_count':
                $message = 'Jumlah kolom CSV tidak sesuai. Harus ada 7 kolom: Nama Kafe, Skor_Rasa, Skor_Pelayanan, Skor_Fasilitas, Skor_Suasana, Skor_Harga, Skor_Rating';
                break;
            case 'invalid_header':
                $message = 'Header CSV tidak sesuai. Gunakan format: <code>Nama Kafe;Skor_Rasa;Skor_Pelayanan;Skor_Fasilitas;Skor_Suasana;Skor_Harga;Skor_Rating</code>';
                break;
            case 'insert_clustering_failed':
                $message = 'Gagal menyimpan record clustering ke database.';
                break;
            case 'kmeans_error':
                $message = 'Proses K-Means gagal. Detail: ' . $msg;
                break;
            case 'invalid_kmeans_output':
                $message = 'Output K-Means tidak valid. ' . $msg;
                break;
            case 'process_completed':
                $message = "Proses clustering berhasil! Total data yang diproses: <strong>$total kafe</strong>.";
                break;
            default:
                $message = $msg ? $msg : 'Terjadi kesalahan yang tidak diketahui.';
        }

        // Tampilkan alert Bootstrap 5
        echo <<<HTML
        <div class="alert alert-{$alert_type} alert-dismissible fade show" role="alert">
            <h5 class="alert-heading"><i class="bi bi-info-circle-fill"></i> {$title}</h5>
            <p class="mb-0">{$message}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
HTML;

        // Hapus flash message dari session
        unset($_SESSION['flash_status']);
        unset($_SESSION['flash_action']);
        unset($_SESSION['flash_ket']);
        unset($_SESSION['flash_msg']);
        unset($_SESSION['flash_total']);
    }
}

// Auto-execute jika dipanggil langsung
if (basename($_SERVER['PHP_SELF']) === 'flash_message_handler.php') {
    show_flash_message();
}
