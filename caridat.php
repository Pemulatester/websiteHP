<?php
session_start(); // Memulai sesi untuk mengecek login

// Mengecek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit;
}

// Koneksi database
include 'koneksi.php';  // Ganti dengan path yang sesuai dengan file db.php Anda

// Menangani form pencarian
$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_POST['search']);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian Data HP</title>
    <!-- Menambahkan Bootstrap dan Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .navbar {
            margin-bottom: 20px;
        }
        table img {
            width: 100px;  /* Ukuran gambar yang konsisten */
            height: 100px; /* Ukuran gambar yang konsisten */
            object-fit: cover; /* Menjaga proporsi gambar */
        }
        footer {
            margin-top: 20px;
            text-align: center;
            color: #888;
        }
        /* Styling untuk tombol logout di bawah kanan */
        .logout-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }
        /* Styling untuk tombol kembali */
        .back-button {
            position: fixed;
            bottom: 80px;
            right: 20px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Alfan Cell</a>
        <div class="ml-auto d-flex align-items-center">
            <span class="navbar-text text-white">
                Selamat datang, <?php echo $_SESSION['user']; ?>!
            </span>
        </div>
        <!-- Form pencarian dengan ikon kaca pembesar -->
        <form method="POST" action="caridat.php" class="d-flex ms-3">
            <input type="text" name="search" class="form-control" placeholder="Cari HP" value="<?php echo $search; ?>" required>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> <!-- Ikon kaca pembesar -->
            </button>
        </form>
    </div>
</nav>

<!-- Container -->
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Hasil Pencarian HP</h2>
    </div>

    <!-- Tabel Hasil Pencarian -->
    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Nama HP</th>
                <th>Harga</th>
                <th>Spesifikasi</th>
                <th>Gambar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($search != '') {
                // Query untuk mencari data berdasarkan nama
                $query = "SELECT * FROM hp WHERE nama LIKE '%$search%'";
                $data = mysqli_query($koneksi, $query);
                $no = 1;
                while ($d = mysqli_fetch_array($data)) {
            ?>  
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['nama']; ?></td>
                <td><?php echo number_format($d['harga'], 0, ',', '.'); ?> IDR</td>
                <td><?php echo $d['spesifikasi']; ?></td>
                <td>
                    <img src="image/<?php echo $d['gambar']; ?>" alt="Gambar HP">
                </td>
            </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Footer -->
<footer>
    <p>&copy; <?php echo date("Y"); ?>  Data HP by Muhammad Alfan Rizieq</p>
</footer>

<!-- Tombol Logout di bawah kanan -->
<a href="index_user.php?logout=true" class="btn btn-danger logout-button">
    <i class="fas fa-sign-out-alt"></i> Logout
</a>

<!-- Tombol Kembali ke Halaman Index -->
<a href="index_user.php" class="btn btn-secondary back-button">
    <i class="fas fa-arrow-left"></i> Kembali
</a>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
