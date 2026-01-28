<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'env.php';

date_default_timezone_set('Asia/Jakarta');
$pukul = date('H:i A');

// Deteksi server
$host = $_SERVER['SERVER_NAME'];
if ($host === 'localhost' || strpos($host, '127.0.0.1') !== false) {
    $server     = 'localhost';
    $username   = 'root';
    $password   = '';
    $database   = 'app_sip_kafe';
} else {
    $server     = '';
    $username   = '';
    $password   = '';
    $database   = '';
}

$koneksi = mysqli_connect($server, $username, $password, $database);

if (!$koneksi) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

/* SESSION GLOBAL */
$sesi_id = $_SESSION['sesi_id'] ?? null;
