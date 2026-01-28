<?php
session_start();

// Cek login admin
if (!isset($_SESSION['sesi_id']) !== 'admin') {
    header('Location: ../auth/login');
    exit;
}
