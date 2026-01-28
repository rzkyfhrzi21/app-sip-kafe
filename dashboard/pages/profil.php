<?php
/* =====================================================
   CEK SESSION LOGIN
===================================================== */
if (!isset($_SESSION['sesi_id'])) {
    return;
}

/* =====================================================
   AMBIL ID ADMIN DARI SESSION
===================================================== */
$id_admin = $_SESSION['sesi_id'];

/* =====================================================
   AMBIL DATA ADMIN DARI DATABASE
   - Tabel: admin
===================================================== */
$query = "SELECT * FROM admin WHERE id_admin = '$id_admin' LIMIT 1";
$sql   = mysqli_query($koneksi, $query);
$admin = mysqli_fetch_assoc($sql);

// Jika data admin tidak ditemukan, hentikan
if (!$admin) {
    return;
}

/* =====================================================
   SET VARIABEL UNTUK DITAMPILKAN DI FORM
===================================================== */
$nama_admin = $admin['nama_lengkap'];
$username   = $admin['username'];
$email      = $admin['email'];
$no_hp      = $admin['no_hp'];
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>Profil Admin</h3>
                <p class="text-subtitle text-muted">
                    Kelola informasi akun administrator SIP KAFE
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

    <div class="row">

        <!-- ===================== CARD PROFIL (KIRI) ===================== -->
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <div class="avatar avatar-xl">
                            <!-- SIP KAFE tidak punya foto profil di tabel admin, pakai default -->
                            <img src="assets/static/images/faces/1.jpg" alt="Admin">
                        </div>

                        <h3 class="mt-3"><?= htmlspecialchars($nama_admin); ?></h3>
                        <p class="text-small text-muted text-bold">Administrator</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===================== FORM PROFIL (KANAN) ===================== -->
        <div class="col-12 col-lg-8">

            <!-- ===== CARD INFORMASI ADMIN ===== -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Informasi Admin</h5>
                </div>

                <div class="card-body">
                    <form action="../functions/function_admin.php" method="post">

                        <div class="row form-group mandatory has-icon-left">
                            <!-- Nama Lengkap -->
                            <div class="col-md-6 col-12">
                                <label class="form-label">Nama Lengkap</label>
                                <div class="position-relative">
                                    <input type="text"
                                        class="form-control"
                                        name="nama_lengkap"
                                        placeholder="Nama lengkap"
                                        value="<?= htmlspecialchars($nama_admin); ?>"
                                        required>
                                    <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="col-md-6 col-12 mt-2 mt-md-0">
                                <label class="form-label">Username</label>
                                <div class="position-relative">
                                    <input type="text"
                                        class="form-control"
                                        name="username"
                                        placeholder="Username"
                                        value="<?= htmlspecialchars($username); ?>"
                                        required>
                                    <div class="form-control-icon">
                                        <i class="bi bi-person-badge"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group mandatory has-icon-left mt-2">
                            <!-- Email -->
                            <div class="col-md-6 col-12">
                                <label class="form-label">Email</label>
                                <div class="position-relative">
                                    <input type="email"
                                        class="form-control"
                                        name="email"
                                        placeholder="Email"
                                        value="<?= htmlspecialchars($email); ?>">
                                    <div class="form-control-icon">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Nomor HP -->
                            <div class="col-md-6 col-12 mt-2 mt-md-0">
                                <label class="form-label">Nomor HP</label>
                                <div class="position-relative">
                                    <input type="text"
                                        class="form-control"
                                        name="no_hp"
                                        placeholder="08xxxx"
                                        value="<?= htmlspecialchars($no_hp); ?>">
                                    <div class="form-control-icon">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden ID Admin -->
                        <input type="hidden" name="id_admin" value="<?= $id_admin; ?>">

                        <div class="form-group mt-3">
                            <button type="submit" name="btn_update_profile" class="btn btn-primary">
                                Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ===== CARD UBAH PASSWORD ===== -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Ubah Password</h5>
                </div>

                <div class="card-body">
                    <form action="../functions/function_admin.php" method="post">

                        <div class="row form-group mandatory has-icon-left">
                            <!-- Password baru -->
                            <div class="col-md-6 col-12">
                                <label class="form-label">Password Baru</label>
                                <div class="position-relative">
                                    <input type="password"
                                        class="form-control"
                                        name="password_baru"
                                        placeholder="Password baru">
                                    <div class="form-control-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                </div>
                                <small class="text-muted">
                                    *Kosongkan jika tidak ingin mengganti password
                                </small>
                            </div>

                            <!-- Konfirmasi password -->
                            <div class="col-md-6 col-12 mt-2 mt-md-0">
                                <label class="form-label">Konfirmasi Password</label>
                                <div class="position-relative">
                                    <input type="password"
                                        class="form-control"
                                        name="konfirmasi_password"
                                        placeholder="Ulangi password">
                                    <div class="form-control-icon">
                                        <i class="bi-shield-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="id_admin" value="<?= $id_admin; ?>">

                        <div class="form-group mt-3">
                            <button type="submit" name="btn_update_password" class="btn btn-warning">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>