<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Debug Session</title>
</head>
<body style="padding: 2rem; font-family: monospace; background: #2b2b2b; color: #0f0;">
    <h2>Isi $_SESSION Saat Ini:</h2>
    <!-- Tag pre mempertahankan spasi dan baris baru agar mudah dibaca -->
    <pre><?php print_r($_SESSION); ?></pre> 
</body>
</html>