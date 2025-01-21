<?php
session_start();

error_log("Session before destroy: " . session_id());

session_unset();
session_destroy();  // Hancurkan sesi

// Debugging: Cek apakah sesi sudah dihancurkan
error_log("Session after destroy: " . session_id());

header('Location: login.php');  // Mengarahkan ke login.php di folder yang sama
exit;

// https://github.com/Madleyym/Rental-Mobil/blob/main/logout.php