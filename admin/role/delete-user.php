<?php
// Sertakan koneksi ke database
require_once '../../config/koneksi.php';

// Cek apakah ada parameter 'id' di URL
if (isset($_GET['id'])) {
    $id_user = $_GET['id'];

    // Cek apakah yang akan dihapus adalah admin
    $query_check_admin = "SELECT level FROM tbl_user WHERE id_user = ?";
    $stmt = $conn->prepare($query_check_admin);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->bind_result($level);
    $stmt->fetch();

    if ($level == 'admin') {
        echo "Anda tidak dapat menghapus pengguna dengan level admin.";
        exit; // Hentikan eksekusi jika admin
    }

    // Query untuk menghapus pengguna berdasarkan id_user
    $query_delete = "DELETE FROM tbl_user WHERE id_user = ?";

    // Persiapkan statement untuk delete
    if ($stmt = $conn->prepare($query_delete)) {
        // Ikat parameter dan eksekusi query
        $stmt->bind_param("i", $id_user);
        if ($stmt->execute()) {
            // Redirect setelah berhasil menghapus
            header("Location: users.php"); // Kembali ke halaman users
            exit; // Pastikan tidak ada output setelah header
        } else {
            echo "Gagal menghapus pengguna.";
        }
        $stmt->close();
    } else {
        echo "Query error.";
    }
} else {
    echo "ID pengguna tidak ditemukan.";
}

$conn->close();
