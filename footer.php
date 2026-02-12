<?php require_once 'config/env.php'; ?>

<footer class="footer" style="background: none; padding: 2rem 0; color: var(--primary2); font-family: 'Nunito', sans-serif; font-weight: 500;">
    <div class="container" style="max-width: 720px; margin: auto;">

        <div style="margin-bottom: 1.5rem;">
            <h5 style="font-weight: 700; display: flex; align-items: center; gap: 0.5rem; font-size: 1.3rem; margin-bottom: 0.5rem; color: var(--primary);">
                <i class="bi bi-cup-hot-fill"></i>
                <?= NAMA_WEB ?>
            </h5>
            <p style="margin-bottom: 0.25rem;">
                <?= DESKRIPSI_WEB ?>
            </p>
            <p style="font-weight: 700;">
                Sistem Informasi Peringkat Kafe berbasis K-Means Clustering dan Weighted Sum Model (WSM).
            </p>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <h6 style="font-weight: 700; font-size: 1.1rem; margin-bottom: 0.5rem; color: var(--primary2);">
                Menu
            </h6>
            <p style="margin: 0; font-size: 1rem;">
                <a href="index.php" style="color: var(--primary2); text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                    <i class="bi bi-trophy-fill"></i> Ranking Kafe
                </a>
                &nbsp;&nbsp;
                <a href="cari_kafe.php" style="color: var(--primary2); text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                    <i class="bi bi-search"></i> Cari Kafe
                </a>
            </p>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <h6 style="font-weight: 700; font-size: 1.1rem; margin-bottom: 0.5rem; color: var(--primary2);">
                Kontak
            </h6>
            <p style="margin: 0.2rem 0; font-size: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-geo-alt-fill" style="font-size: 1.1rem; color: var(--accent);"></i> Bandar Lampung, Lampung
            </p>
            <p style="margin: 0.2rem 0; font-size: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-envelope-fill" style="font-size: 1.1rem; color: var(--accent);"></i>
                <a href="mailto:<?= EMAIL ?>" style="color: var(--primary2); text-decoration: none;"><?= EMAIL ?></a>
            </p>
            <p style="margin: 0.2rem 0; font-size: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-phone-fill" style="font-size: 1.1rem; color: var(--accent);"></i>
                <a href="tel:+<?= NO_WA ?>" style="color: var(--primary2); text-decoration: none;"><?= NO_WA ?></a>
            </p>
        </div>

        <div style="margin-bottom: 2rem;">
            <h6 style="font-weight: 700; font-size: 1.1rem; margin-bottom: 0.5rem; color: var(--primary2);">
                Ikuti Kami
            </h6>
            <div style="display: flex; gap: 1rem;">
                <a href="<?= URL_IG ?>" target="_blank" class="social-link" style="background: var(--light-bg); border-radius: 50%; padding: 0.5rem; display: inline-flex; align-items: center; justify-content: center; color: var(--accent); font-size: 1.5rem; transition: all 0.3s ease; text-decoration: none;">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="#" target="_blank" class="social-link" style="background: var(--light-bg); border-radius: 50%; padding: 0.5rem; display: inline-flex; align-items: center; justify-content: center; color: var(--accent); font-size: 1.5rem; transition: all 0.3s ease; text-decoration: none;">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="#" target="_blank" class="social-link" style="background: var(--light-bg); border-radius: 50%; padding: 0.5rem; display: inline-flex; align-items: center; justify-content: center; color: var(--accent); font-size: 1.5rem; transition: all 0.3s ease; text-decoration: none;">
                    <i class="bi bi-twitter"></i>
                </a>
                <a href="#" target="_blank" class="social-link" style="background: var(--light-bg); border-radius: 50%; padding: 0.5rem; display: inline-flex; align-items: center; justify-content: center; color: var(--accent); font-size: 1.5rem; transition: all 0.3s ease; text-decoration: none;">
                    <i class="bi bi-youtube"></i>
                </a>
            </div>
        </div>

        <div style="border-top: 1px solid var(--accent); padding-top: 1rem; font-size: 0.9rem; text-align: center; color: var(--primary2);">
            <p style="margin-bottom: 0.3rem;">
                &copy; <?= date('Y'); ?> <strong><?= NAMA_WEB ?></strong>. All Rights Reserved.
            </p>
            <p>
                Dibuat dengan <span style="color: #e25555; font-size: 1.1rem;">❤️</span> oleh
                <a href="<?= URL_IG ?>" target="_blank" style="color: var(--accent); text-decoration: none; font-weight: 700;"><?= NAMA_LENGKAP ?></a>
            </p>
        </div>
    </div>
</footer>

<style>
    /* Social Links */
    .social-link {
        width: 40px;
        height: 40px;
        background: rgba(212, 163, 115, 0.2);
        border: 2px solid var(--accent);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: var(--accent);
        color: var(--primary2);
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(212, 163, 115, 0.3);
    }

    .footer-section a {
        transition: all 0.3s ease;
    }

    .footer-section a:hover {
        color: var(--accent) !important;
        padding-left: 5px;
    }
</style>