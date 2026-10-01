<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Kalau udah login, tendang balik ke beranda
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}
$page_title = "Registrasi Petugas";
include __DIR__ . '/../includes/header.php';
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<section>
    <h2>Registrasi Petugas</h2>
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>
    <form method="post" action="proses_register.php">
        <p><label>Nama</label><br><input type="text" name="nama" required></p>
        <p><label>Username</label><br><input type="text" name="username" required></p>
        <p><label>Password</label><br><input type="password" name="password" minlength="6" required></p>
        <p><button type="submit">Daftar</button></p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>