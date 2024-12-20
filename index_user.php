<?php
session_start(); // Memulai sesi untuk mengecek login

// Mengecek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit;
}

// Proses logout
if (isset($_GET['logout'])) {
    session_destroy(); // Menghancurkan sesi login
    header("Location: login.php"); // Arahkan kembali ke halaman login setelah logout
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data HP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <!-- Menambahkan Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Times New Roman', Times, serif; /* Mengubah font ke Times New Roman */
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

        /* Menambahkan styling untuk form pencarian di navbar */
        .navbar .form-inline input {
            width: 250px;
        }

        /* Menambahkan styling untuk tampilan tabel */
        table {
            margin-top: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #007bff;
            color: black; /* Set font color to black */
            font-weight: bold; /* Make font bold */
        }

        td {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }



        .character-animation {
            width: 150px; /* Ukuran gambar lebih besar */
            height: 150px; /* Ukuran gambar lebih besar */
            background-image: url('image/welcome.png'); /* Ganti dengan gambar welcome.png */
            background-size: cover;
            display: inline-block;
            position: fixed;
            bottom: 20px;
            left: 20px; /* Menempatkan gambar di kiri bawah */
            animation: idle 2s infinite; /* Menambahkan animasi idle untuk karakter */
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">
            Alfan Cell
        </a>
        <div class="ml-auto d-flex align-items-center">
            <span class="navbar-text text-white">
                Selamat datang, <?php echo $_SESSION['user']; ?>!
            </span>
        </div>
        <!-- Form pencarian di navbar dengan ikon kaca pembesar -->
        <form method="POST" action="caridat.php" class="d-flex ms-3">
            <input type="text" name="search" class="form-control" placeholder="Cari HP" required>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> <!-- Ikon kaca pembesar -->
            </button>
        </form>
    </div>
</nav>

<!-- Container -->
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data HP</h2>
    </div>

    <!-- Tabel Data HP -->
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
            include 'koneksi.php';  // Ganti dengan path yang sesuai dengan file db.php Anda
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM hp");  // Tampilkan semua data HP
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
            ?>
        </tbody>
    </table>
</div>

<!-- Tombol Logout di kanan bawah -->
<a href="index_user.php?logout=true" class="btn btn-danger logout-button">
    <i class="fas fa-sign-out-alt"></i> Logout
</a>

<!-- Footer -->
<footer>
    <p>&copy; <?php echo date("Y"); ?>  Data HP by Muhammad Alfan Rizieq</p>
</footer>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
