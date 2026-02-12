<!-- =====================================================
     NAVBAR COMPONENT - SIP KAFE PUBLIC
     Location: components/navbar.php
     Usage: <?php include 'components/navbar.php'; ?>
===================================================== -->

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php" style="gap: 0.3rem; color: var(--primary2);">
            <i class="bi bi-cup-hot-fill fs-4"></i>
            SIP KAFE
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="index.php" style="gap: 0.3rem; font-weight: 600;">
                        <i class="bi bi-trophy-fill"></i>
                        Ranking
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="cari_kafe.php" style="gap: 0.3rem; font-weight: 600;">
                        <i class="bi bi-search"></i>
                        Cari Kafe
                    </a>
                </li>
                <!-- <li class="nav-item ms-lg-3">
                    <a href="cari_kafe.php" class="btn btn-outline-primary d-flex align-items-center" style="gap: 0.3rem; padding: 0.375rem 1rem;">
                        <i class="bi bi-search"></i>
                        <span class="d-none d-lg-inline">Cari</span>
                    </a>
                </li> -->
            </ul>
        </div>
    </div>
</nav>

<style>
    /* =====================================================
   NAVBAR CUSTOM STYLES
===================================================== */
    .navbar-public {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary2) 100%);
        padding: 0.75rem 0;
        box-shadow: 0 4px 12px rgba(59, 36, 22, 0.2);
        transition: all 0.3s ease;
    }

    .navbar-public.scrolled {
        padding: 0.5rem 0;
        box-shadow: 0 6px 16px rgba(59, 36, 22, 0.3);
    }

    .navbar-public .navbar-brand {
        font-size: 1.5rem;
        font-weight: 800;
        color: white !important;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .navbar-public .navbar-brand:hover {
        color: var(--accent) !important;
        transform: scale(1.05);
    }

    .navbar-public .navbar-brand i {
        font-size: 1.8rem;
        animation: steam 2s ease-in-out infinite;
    }

    @keyframes steam {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-3px);
        }
    }

    .navbar-public .navbar-toggler {
        border: 2px solid var(--accent);
        padding: 0.5rem 0.75rem;
        transition: all 0.3s ease;
    }

    .navbar-public .navbar-toggler:focus {
        box-shadow: 0 0 0 0.2rem rgba(212, 163, 115, 0.5);
    }

    .navbar-public .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(212, 163, 115, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .navbar-public .nav-link {
        color: rgba(255, 255, 255, 0.9) !important;
        font-weight: 600;
        margin: 0 0.5rem;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .navbar-public .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 3px;
        background: var(--accent);
        transition: width 0.3s ease;
        border-radius: 2px;
    }

    .navbar-public .nav-link:hover::after,
    .navbar-public .nav-link.active::after {
        width: 80%;
    }

    .navbar-public .nav-link:hover,
    .navbar-public .nav-link.active {
        color: var(--accent) !important;
    }

    .navbar-public .nav-link i {
        font-size: 1.1rem;
    }

    .navbar-public .btn-outline-light {
        border: 2px solid var(--accent);
        color: var(--accent);
        font-weight: 600;
        transition: all 0.3s ease;
        padding: 0.5rem 1.25rem;
    }

    .navbar-public .btn-outline-light:hover {
        background: var(--accent);
        color: var(--primary2);
        border-color: var(--accent);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(212, 163, 115, 0.3);
    }

    /* Mobile Styles */
    @media (max-width: 991.98px) {
        .navbar-public .navbar-collapse {
            background: rgba(59, 36, 22, 0.95);
            margin-top: 1rem;
            padding: 1rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .navbar-public .nav-link {
            margin: 0.25rem 0;
            padding: 0.75rem 1rem;
            border-radius: 8px;
        }

        .navbar-public .nav-link:hover,
        .navbar-public .nav-link.active {
            background: rgba(212, 163, 115, 0.2);
        }

        .navbar-public .nav-link::after {
            display: none;
        }

        .navbar-public .btn-outline-light {
            width: 100%;
            margin-top: 0.5rem;
        }
    }

    /* Scroll Effect */
    .navbar-public.scrolled .navbar-brand {
        font-size: 1.3rem;
    }

    .navbar-public.scrolled .navbar-brand i {
        font-size: 1.5rem;
    }
</style>

<script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar-public');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Auto close navbar on mobile after click
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        const navbarCollapse = document.querySelector('.navbar-collapse');

        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                        toggle: false
                    });
                    bsCollapse.hide();
                }
            });
        });
    });
</script>