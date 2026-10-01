<?php
require __DIR__ . '/../includes/auth.php';
// 2. Validasi ROLE ADMIN (Kunci jalur belakang)
if (($_SESSION['role'] ?? '') !== 'admin') {
    // Kalau bukan admin, tendang balik ke halaman list
    $_SESSION['flash'] = [
        'type' => 'error', 
        'pesan' => 'Akses ditolak bro! Lo bukan Admin, nggak berhak hapus data.'
    ];
    header('Location: list.php');
    exit;
}
require __DIR__ . '/../includes/koneksi.php';

// Pastikan hanya form POST yang diizinkan masuk
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id'] ?? null;
if ($id) {
    // AWAS: Klausa WHERE sangat penting agar tidak menghapus seluruh database!
    $stmt = $pdo->prepare("DELETE FROM anggota WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil dihapus.'];
}

header('Location: list.php');
exit;