<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

// Pastikan hanya form POST yang diizinkan masuk
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id'] ?? null;
if ($id) {
    // AWAS: Klausa WHERE sangat penting agar tidak menghapus seluruh database!
    $stmt = $pdo->prepare("DELETE FROM buku WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil dihapus.'];
}

header('Location: list.php');
exit;