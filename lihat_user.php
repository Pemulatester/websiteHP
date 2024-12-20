<?php
session_start(); // Memulai sesi untuk mengecek login

// Mengecek apakah user sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit;
}

include 'koneksi.php'; // Hubungkan dengan file koneksi
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat User</title>
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
        }
        .navbar-brand {
            font-weight: bold;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        footer {
            margin-top: 30px;
            text-align: center;
            color: #777;
            font-size: 12px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .search-bar input {
            border-radius: 20px;
            padding: 10px 20px;
        }
        .search-bar button {
            border-radius: 20px;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Lihat User</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="index.php">Beranda</a></li>
                            <li><a class="dropdown-item" href="index.php?logout=true">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Container -->
    <div class="container">
        <h2 class="text-primary mb-4">Daftar User</h2>

        <!-- Search Bar -->
        <div class="search-bar d-flex justify-content-between">
            <form class="d-flex w-100" method="GET" action="">
                <input type="text" class="form-control me-2" name="search" placeholder="Cari user..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>

        <!-- Tombol Tambah User -->
        <div class="mb-3">
            <a href="tambah_user.php" class="btn btn-success"><i class="fas fa-plus"></i> Tambah User</a>
        </div>

        <!-- Tabel Data User -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $query = "SELECT * FROM users WHERE username LIKE '%$search%'";
                    $data = mysqli_query($koneksi, $query);
                    while ($d = mysqli_fetch_array($data)) {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td><?php echo $d['username']; ?></td>
                        <td><?php echo $d['password']; ?></td>
                        <td class="text-center">
                            <a href="edit_user.php?id=<?php echo $d['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <a href="hapus_user.php?id=<?php echo $d['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?');"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Lihat User by Muhammad Alfan Rizieq</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
