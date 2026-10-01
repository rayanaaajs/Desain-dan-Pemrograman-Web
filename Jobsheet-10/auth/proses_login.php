<?php
// auth/proses_login.php
session_start();
require __DIR__ . '/../includes/koneksi.php';

// --- TAMBAHIN KODE INI DI ATAS ---
// 1. Bikin hitungan awal kalau belum ada
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
$max_attempts = 3; // Jatah maksimal login

// 2. Cegat duluan kalau udah 3 kali gagal
if ($_SESSION['login_attempts'] >= $max_attempts) {
    $_SESSION['flash'] = [
        'type' => 'error', 
        'pesan' => 'Udah 3 kali salah login! Akses ditahan sementara, tutup dulu browsernya.'
    ];
    header('Location: login.php');
    exit;
}
// ---------------------------------

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifikasi hash password
if ($user && password_verify($password, $user['password'])) {
// --- TAMBAHIN INI: Reset hitungan gagal karena udah berhasil masuk ---
    unset($_SESSION['login_attempts']);
    // Set data ke Session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];
    
    // CEK CHECKBOX REMEMBER ME
    if (isset($_POST['remember']) && $_POST['remember'] == '1') {
        // Buat cookie berlaku 30 hari (86400 detik x 30)
        setcookie('user_id', $user['id'], time() + (86400 * 30), "/");
        // Kita hash username-nya sebagai "kunci cadangan" biar lebih aman
        setcookie('user_key', hash('sha256', $user['username']), time() + (86400 * 30), "/");
    }
    
    header('Location: ../index.php');
    exit;
}

// --- ROMBAK BAGIAN BAWAH INI ---
// Tambahin hitungan gagalnya
$_SESSION['login_attempts']++;

// Hitung sisa nyawa
$sisa_percobaan = $max_attempts - $_SESSION['login_attempts'];

// Bikin pesannya dinamis
if ($sisa_percobaan > 0) {
    $pesan = "Username atau password salah! Sisa percobaan: $sisa_percobaan kali lagi.";
} else {
    $pesan = "Gagal login 3 kali! Akses lo ditahan sementara.";
}

$_SESSION['flash'] = ['type' => 'error', 'pesan' => $pesan];
header('Location: login.php');
exit;