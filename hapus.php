<?php
// Menghubungkan ke database
include 'koneksi.php'; // Pastikan path relatif sudah benar

// Memeriksa apakah ID ada di URL dan valid
if (isset($_GET['id']) && intval($_GET['id']) > 0) {
    $id = intval($_GET['id']); // Mengubah ID ke integer untuk keamanan

    // Query untuk menghapus data berdasarkan ID
    $query = "DELETE FROM hp WHERE id = $id"; // Mengubah query untuk tabel hp

    // Eksekusi query penghapusan
    if (mysqli_query($koneksi, $query)) {
        // Jika penghapusan berhasil, arahkan kembali ke halaman daftar hp
        header("Location: index.php"); // Arahkan ke index.php setelah berhasil
        exit; // Pastikan tidak ada kode lain yang dieksekusi setelah pengalihan
    } else {
        // Jika gagal, tampilkan pesan kesalahan
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    // Jika ID tidak ditemukan atau tidak valid
    echo "ID tidak valid atau tidak ditemukan! <br>";
    echo "<a href='index.php'>Kembali ke daftar HP</a>";
}
?>
