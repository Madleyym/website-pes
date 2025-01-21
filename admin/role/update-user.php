<?php
require_once '../../config/koneksi.php';  // Path relatif dari admin/role ke config

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $level = mysqli_real_escape_string($conn, $_POST['level']);

    // Query untuk memperbarui role
    $query = "UPDATE tbl_user SET level = '$level' WHERE id_user = '$id_user'";

    if (mysqli_query($conn, $query)) {
        header("Location: users.php"); // Arahkan kembali ke halaman pengguna
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
