<link rel="stylesheet" href="assets/compiled/css/app.css">
<link rel="stylesheet" href="assets/compiled/css/app-dark.css">
<link rel="stylesheet" href="assets/compiled/css/iconly.css">

<!-- Bootstrap 5 -->
<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

<!-- Font Awesome (CDN) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- SweetAlert2 (CDN) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Choices (CDN) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

<!-- DataTables (CDN) -->
<!-- DataTables Bootstrap 4 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">

<!-- Responsive Bootstrap 4 -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">

<!-- Buttons Bootstrap 4 -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.bootstrap4.min.css">

<!-- FilePond (CDN) -->
<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.css">
<link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css">

<!-- Toastify (CDN) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<!-- Flatpickr (CDN) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
    :root {
        /* ===== SIP KAFE - Coffee Modern Palette ===== */
        --primary: #7b4b2a;
        /* espresso */
        --primary2: #3b2416;
        /* dark roast */
        --accent: #d4a373;
        /* crema gold */

        --text: #1f2937;
        --muted: #6b7280;
        --border: #e5e7eb;

        /* Bootstrap color system */
        --bs-primary: var(--primary);
        --bs-primary-rgb: 123, 75, 42;

        --bs-link-color: var(--primary);
        --bs-link-hover-color: var(--primary2);
    }

    /* Navbar background = primary */
    .main-navbar {
        background: var(--primary) !important;
    }

    /* Warna teks menu */
    .main-navbar .menu-link,
    .main-navbar .menu-link span,
    .main-navbar .menu-link i {
        color: #fff !important;
    }

    /* Hover/active biar tetap enak dilihat */
    .main-navbar .menu-item.active>.menu-link,
    .main-navbar .menu-link:hover {
        background: rgba(255, 255, 255, 0.12) !important;
        border-radius: 10px;
    }

    /* Submenu biar kontras */
    .main-navbar .submenu {
        background: #fff !important;
    }

    .main-navbar .submenu .submenu-link {
        color: var(--text) !important;
    }

    .main-navbar .submenu .submenu-link:hover {
        background: rgba(123, 75, 42, 0.08) !important;
    }

    /* Button primary */
    .btn-primary {
        background-color: var(--primary) !important;
        border-color: var(--primary) !important;
    }

    .btn-primary:hover {
        background-color: var(--primary2) !important;
        border-color: var(--primary2) !important;
    }

    /* Badge */
    .badge.bg-primary {
        background-color: var(--primary) !important;
    }

    /* Table hover */
    .table-hover tbody tr:hover {
        background-color: rgba(123, 75, 42, 0.06);
    }

    /* Form focus */
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.15rem rgba(123, 75, 42, 0.25);
    }
</style>