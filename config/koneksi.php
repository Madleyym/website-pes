<?php
// Konfigurasi database
$host = 'localhost'; // Nama host database
$username = 'root';  // Username database
$password = '';      // Password database
$database = 'kisni'; // Nama database yang digunakan

// Membuat koneksi ke MySQL
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menyetel karakter encoding ke UTF-8
$conn->set_charset("utf8");

// Pesan jika koneksi berhasil
// echo "Koneksi berhasil!";
?>
