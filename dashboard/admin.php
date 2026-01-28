<?php
session_start();

require_once '../config/config.php';

/* ==============================
CEK SESSION LOGIN
============================== */
if (!isset($_SESSION['sesi_id'])) {
    header('Location: ../auth/login?status=warning&action=auth&ket=belumlogin');
    exit();
}

/* ==============================
   AMBIL DATA ADMIN (tabel: admin)
   ============================== */
$query = "SELECT * FROM admin WHERE id_admin = '$sesi_id' LIMIT 1";

$sql = mysqli_query($koneksi, $query);
$admin = mysqli_fetch_assoc($sql);

// Jika data admin tidak ditemukan (session invalid / data terhapus)
if (!$admin) {
    session_destroy();
    header('Location: ../auth/login?status=error&action=auth&ket=sessioninvalid');
    exit();
}

// Ambil data admin
$sesi_nama     = isset($admin['nama_lengkap']) ? $admin['nama_lengkap'] : '';
$sesi_username = isset($admin['username']) ? $admin['username'] : '';
$sesi_email    = isset($admin['email']) ? $admin['email'] : '';
$sesi_nohp     = isset($admin['no_hp']) ? $admin['no_hp'] : '';

// (Opsional) SIP KAFE tidak punya foto profil di tabel admin
// Jadi biarkan default image di HTML kamu
$sesi_img = '';

// Tidak ada role di SIP KAFE, jadi tidak perlu cek role admin lagi
$page = $_GET['page'] ?? 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="noindex, nofollow">

    <title>
        <?= ucwords(str_replace('_', ' ', $page)); ?>
        - Panel Admin <?= NAMA_WEB ?>
    </title>

    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">

    <?php include 'pages/css.php'; ?>
</head>


<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <div class="header-top">
                    <div class="container">
                        <div class="logo">
                            <a href="../index"><img src="../assets/logo.png" width="100" alt="<?= NAMA_WEB ?>"></a>
                        </div>
                        <div class="logo pukul">
                            <div class="sidebar-hide align-items-left">
                                <b><label>Pukul : <?= $pukul; ?></label></b>
                            </div>
                        </div>

                        <div class="header-top-left">
                            <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                    role="img" class="iconify iconify--system-uicons" width="20" height="20"
                                    preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                    <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                            opacity=".3"></path>
                                        <g transform="translate(-210 -1)">
                                            <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                            <circle cx="220.5" cy="11.5" r="4"></circle>
                                            <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                        </g>
                                    </g>
                                </svg>
                                <div class="form-check form-switch fs-6">
                                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                    <label class="form-check-label"></label>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                    role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="header-top-right">
                            <div class="dropdown">
                                <a href="#" id="topbarUserDropdown"
                                    class="user-dropdown d-flex align-items-center dropend dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">

                                    <div class="avatar avatar-md2">
                                        <img src="assets/<?= !empty($sesi_img)
                                                                ? 'profile/' . htmlspecialchars($sesi_img)
                                                                : 'static/images/faces/1.jpg'; ?>"
                                            alt="Foto Profil Admin"
                                            onerror="this.src='assets/static/images/faces/1.jpg'">
                                    </div>

                                    <div class="text">
                                        <h8 class="user-dropdown-name">
                                            <?= htmlspecialchars($sesi_nama); ?>
                                        </h8>
                                        <p class="user-dropdown-status text-sm text-muted text-capitalize">
                                            Administrator
                                        </p>
                                    </div>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end shadow-lg"
                                    aria-labelledby="topbarUserDropdown">
                                    <li>
                                        <a class="dropdown-item" href="?page=Profil">Profil</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-logout"
                                            data-bs-backdrop="false">
                                            Logout
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <a href="#" class="burger-btn d-block d-xl-none">
                                <i class="bi bi-justify fs-3"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <nav class="main-navbar">
                    <div class="container">
                        <ul>
                            <li class="menu-item">
                                <a href="../index" class="menu-link">
                                    <span><i class="bi bi-house-door-fill"></i> Beranda</span>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="admin?page=Dashboard" class="menu-link">
                                    <span><i class="bi bi-grid-fill"></i> Dashboard</span>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="admin?page=Data Kafe" class="menu-link">
                                    <span><i class="bi bi-cup-hot-fill"></i> Data Kafe</span>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="admin?page=Data Kuisioner" class="menu-link">
                                    <span><i class="bi bi-clipboard-data-fill"></i> Data Kuisioner</span>
                                </a>
                            </li>

                            <li class="menu-item has-sub">
                                <a href="#" class="menu-link">
                                    <span><i class="bi bi-diagram-3-fill"></i>Mulai Clustering</span>
                                </a>
                                <div class="submenu">
                                    <div class="submenu-group-wrapper">
                                        <ul class="submenu-group">
                                            <li class="submenu-item">
                                                <a href="admin?page=Mulai Clustering" class="submenu-link">
                                                    Proses Clustering (Upload CSV)
                                                </a>
                                            </li>
                                            <li class="submenu-item">
                                                <a href="admin?page=Hasil Clustering" class="submenu-link">
                                                    Hasil Clustering
                                                </a>
                                            </li>
                                            <li class="submenu-item">
                                                <a href="admin?page=Riwayat Clustering" class="submenu-link">
                                                    Riwayat Clustering
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            <li class="menu-item">
                                <a href="admin?page=Profil" class="menu-link">
                                    <span><i class="bi bi-person-circle"></i> Profil</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <!--Logout Modal -->
            <div class="modal fade text-left" id="modal-logout" tabindex="-1"
                role="dialog" aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Yakin Ingin Logout ?</h5>
                            <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>
                                Keluar dari halaman dashboard.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-danger text-dark" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Batal</span>
                            </button>
                            <a href="../auth/logout" class="btn btn-danger ms-1">
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-wrapper container">
                <?php
                // Routing halaman SIP KAFE
                switch ($page) {

                    case 'Dashboard':
                        include 'pages/dashboard.php';
                        break;

                    case 'Data Kafe':
                        include 'pages/data_kafe.php';
                        break;

                    case 'Data Kuisioner':
                        include 'pages/data_kuisioner.php';
                        break;

                    case 'Mulai Clustering':
                        include 'pages/mulai_clustering.php';
                        break;

                    case 'Hasil Clustering':
                        include 'pages/hasil_clustering.php';
                        break;

                    case 'Riwayat Clustering':
                        include 'pages/riwayat_clustering.php';
                        break;

                    case 'Profil':
                        include 'pages/profil.php';
                        break;
                }
                ?>
            </div>

            <footer class="mt-5">
                <div class="container">
                    <div class="footer clearfix mb-0 text-muted py-3 border-top">
                        <div class="float-start">
                            <p class="mb-0">
                                <strong><?= NAMA_WEB ?></strong>
                                <span class="mx-1">•</span>
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>
                            </p>
                            <small class="d-block">
                                <?= DESKRIPSI_WEB ?>
                            </small>
                        </div>

                        <div class="float-end text-end">
                            <p class="mb-0">
                                Dibuat dengan <span class="text-danger"><i class="bi bi-heart-fill"></i></span>
                                oleh <a href="<?= URL_IG ?>" target="_blank" class="fw-bold"><?= NAMA_LENGKAP ?></a>
                            </p>
                            <small class="d-block">
                                <i class="bi bi-geo-alt"></i> Bandar Lampung
                            </small>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
    </div>

    <!-- JS -->
    <?php include 'pages/js.php'; ?>
    <!-- JS -->


</body>

</html>