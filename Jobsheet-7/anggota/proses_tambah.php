<?php
session_start();

$nama = trim($_POST['nama'] ?? '');
$no_anggota = trim($_POST['no_anggota'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');

$errors = [];

// Validasi Form
if ($nama === '') $errors[] = "Nama anggota wajib diisi.";
if ($no_anggota === '') $errors[] = "Nomor anggota wajib diisi.";
if ($no_hp !== '' && !is_numeric($no_hp)) {
    $errors[] = "Nomor HP hanya boleh berisi angka.";
}

// Redirect jika ada error
if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

// Simpan data jika sukses
if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}

$_SESSION['anggota'][] = [
    'no_anggota' => $no_anggota,
    'nama' => $nama,
    'alamat' => $alamat,
    'no_hp' => $no_hp
];

// Buat flash message sukses
$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;