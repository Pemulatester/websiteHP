<?php
// Detail koneksi
$servername = "localhost";
$username = "root";  // Username default XAMPP adalah root
$password = "";      // Password biasanya kosong di XAMPP
$dbname = "tugas_web"; // Nama database yang telah kamu buat

// Membuat koneksi
$koneksi = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Hapus atau komentar baris ini setelah selesai debugging
// echo "Koneksi berhasil"; 
?>
