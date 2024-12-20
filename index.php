<?php
session_start(); // Memulai sesi untuk mengecek login

// Mengecek apakah user sudah login
if (!isset($_SESSION['admin'])) {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            color: #333;
        }
        .navbar {
            margin-bottom: 20px;
            animation: gradient-animation 5s infinite alternate;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .dropdown-toggle {
            font-weight: bold;
            color: white !important;
        }
        .table img {
            max-width: 80px;
            max-height: 80px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 2px;
        }
        .btn {
            font-size: 12px;
        }
        footer {
            margin-top: 30px;
            text-align: center;
            color: #777;
            font-size: 12px;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        @keyframes gradient-animation {
            0% {
                background-color: rgb(255, 0, 0);
            }
            25% {
                background-color: rgb(0, 255, 0);
            }
            50% {
                background-color: rgb(0, 0, 255);
            }
            75% {
                background-color: rgb(255, 255, 0);
            }
            100% {
                background-color: rgb(255, 0, 255);
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Data HP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="tambah.php">Tambah HP</a></li>
                            <li><a class="dropdown-item" href="lihat_user.php">Lihat User</a></li>
                            <li><a class="dropdown-item" href="index.php?logout=true">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Tabel Data HP -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Nama HP</th>
                    <th>Harga</th>
                    <th>Spesifikasi</th>
                    <th>Gambar</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'koneksi.php'; // Ganti dengan path yang sesuai
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM hp"); // Sesuaikan dengan tabel Anda
                while ($d = mysqli_fetch_array($data)) {
                ?>
                <tr>
                    <td class="text-center"><?php echo $no++; ?></td>
                    <td><?php echo $d['nama']; ?></td>
                    <td class="text-start"><?php echo number_format($d['harga'], 0, ',', '.'); ?> IDR</td>
                    <td><?php echo $d['spesifikasi']; ?></td>
                    <td class="text-center">
                        <img src="image/<?php echo $d['gambar']; ?>" alt="Gambar HP">
                    </td>
                    <td class="text-center">
                        <a href="edit.php?id=<?php echo $d['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus.php?id=<?php echo $d['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                        <a href="cetakpdf.php?id=<?php echo $d['id']; ?>" class="btn btn-info btn-sm">Cetak PDF</a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Data HP by Muhammad Alfan Rizieq</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
