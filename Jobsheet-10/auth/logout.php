<?php
// auth/logout.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
// Hancurkan Cookie Remember Me
setcookie('user_id', '', time() - 3600, "/");
setcookie('user_key', '', time() - 3600, "/");

header('Location: login.php');
exit;