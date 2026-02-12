<!-- =====================================================
     CSS DEPENDENCIES - SIP KAFE PUBLIC
     Location: assets/css.php
     Called from: index.php, detail_kafe.php, cari_kafe.php
===================================================== -->

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- Google Fonts - Nunito -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<!-- Custom Public CSS -->
<style>
    /* Root Colors (Kopi Tua & Krema) */
    :root {
        --primary: #7b4b2a;
        /* Espresso */
        --primary2: #3b2416;
        /* Dark Roast */
        --accent: #d4a373;
        /* Crema Gold */
        --light-bg: #f5f1e8;
        /* Cream Background */

        --text-default: #3b2416;
        --text-muted: #6b5b4c;
    }

    /* Body basic */
    body {
        font-family: 'Nunito', sans-serif;
        background-color: var(--light-bg);
        color: var(--text-default);
        margin: 0;
        font-weight: 500;
    }

    /* Container max width & padding */
    .container {
        max-width: 1140px;
        padding: 1rem;
        margin: auto;
    }

    /* FILTER BUTTONS */
    .filter-buttons {
        margin-bottom: 1.5rem;
    }

    .filter-buttons a {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.35rem 0.8rem;
        margin-right: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--primary2);
        text-decoration: none;
        border-bottom: 2px solid transparent;
        transition: color 0.3s, border-color 0.3s;
    }

    .filter-buttons a:hover,
    .filter-buttons a.active {
        color: var(--accent);
        border-bottom-color: var(--accent);
    }

    /* BERHASIL PENCARIAN ALERT */
    .alert-info {
        font-size: 0.95rem;
        color: var(--primary2);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Card Kafe */
    .kafe-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(123, 75, 42, 0.1);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .kafe-card:hover {
        box-shadow: 0 8px 24px rgba(123, 75, 42, 0.2);
        transform: translateY(-5px);
    }

    /* Foto kafe */
    .kafe-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        display: block;
    }

    /* Badge peringkat pojok kiri atas */
    .kafe-card .badge-rank {
        position: absolute;
        top: 12px;
        left: 12px;
        background: var(--accent);
        color: var(--primary2);
        font-weight: 700;
        font-size: 1rem;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Card body content */
    .kafe-card .card-body {
        padding: 1rem 1rem 1.25rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    /* Nama kafe */
    .kafe-card .card-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: var(--primary2);
        flex-grow: 1;
    }

    /* Cluster badge */
    .kafe-card .badge-cluster {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        color: white;
        display: inline-block;
        margin-bottom: 0.75rem;
    }

    .badge-cluster.bg-success {
        background-color: #198754;
    }

    .badge-cluster.bg-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-cluster.bg-danger {
        background-color: #dc3545;
    }

    /* Rating dan WSM */
    .kafe-card .rating-wsm {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
        color: var(--primary2);
    }

    .kafe-card .rating-wsm i {
        color: var(--accent);
        margin-right: 0.2rem;
    }

    .badge-wsm-public {
        background: linear-gradient(135deg, var(--primary), var(--primary2));
        color: var(--accent);
        padding: 0.25rem 0.6rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* Alamat dan Harga */
    .kafe-card .info-text {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .kafe-card .info-text i {
        color: var(--primary);
    }

    /* Tombol detail */
    .kafe-card .btn-primary {
        background: var(--primary);
        border: none;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        transition: background-color 0.3s ease;
        margin-top: auto;
    }

    .kafe-card .btn-primary:hover {
        background-color: var(--primary2);
        box-shadow: 0 4px 8px rgba(123, 75, 42, 0.3);
    }

    /* Pastikan tombol terlihat seperti ikon tanpa background dan border */
    .search-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        color: var(--primary);
        cursor: pointer;
        padding: 0;
        font-size: 1.2em;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Container input harus posisi relative untuk tombol posisi absolute */
    .search-box {
        position: relative;
        width: 100%;
    }

    /* Tambahkan padding-right agar teks tidak tertutup tombol */
    .search-box input[type="text"] {
        padding-right: 2.5rem;
        /* ruang untuk tombol ikon */
    }

    /* Responsive for smaller devices */
    @media (max-width: 767.98px) {
        .kafe-card img {
            height: 160px;
        }

        .page-heading h3 {
            font-size: 1.8rem;
        }

        .filter-buttons a {
            font-size: 0.85rem;
        }
    }
</style>