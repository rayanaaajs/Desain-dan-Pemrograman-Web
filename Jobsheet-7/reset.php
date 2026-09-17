<?php
session_start();
session_destroy(); // Menghapus seluruh memori (buku, anggota, flash message)

// Alihkan pengguna kembali ke halaman utama
header('Location: index.php'); 
exit;