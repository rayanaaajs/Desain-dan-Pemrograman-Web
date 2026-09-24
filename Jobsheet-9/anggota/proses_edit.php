<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id = $_POST['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

// 1. Menangkap data anggota
$noAnggota = trim($_POST['no_anggota'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');

// 2. Validasi anggota
$errors = [];
if ($nama === '') $errors[] = "Nama wajib diisi.";
if ($noAnggota === '') $errors[] = "No. Anggota wajib diisi.";
if ($noHp !== '' && !is_numeric($noHp)) $errors[] = "Nomor HP hanya boleh berisi angka.";

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode($id)); // Kembali ke form edit
    exit;
}

// 3. UPDATE ke tabel anggota
$stmt = $pdo->prepare(
    "UPDATE anggota SET nama = :nama, no_anggota = :no_anggota, alamat = :alamat, no_hp = :no_hp WHERE id = :id"
);

try {
    // 4. Eksekusi dengan variabel anggota
    $stmt->execute([
        'nama' => $nama,
        'no_anggota' => $noAnggota,
        'alamat' => $alamat,
        'no_hp' => $noHp,
        'id' => $id,
    ]);
} catch (PDOException $e) {
    // Tangani jika pengguna mengubah nomor anggota menjadi nomor yang sudah ada
    if ($e->getCode() == '23505') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'No. Anggota sudah dipakai, gunakan nomor lain.'];
        header('Location: edit.php?id=' . urlencode($id));
        exit;
    }
    throw $e;
}

// 5. Pesan sukses
$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil diperbarui.'];
header('Location: list.php');
exit;