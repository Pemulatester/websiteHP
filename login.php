<?php
session_start(); // Memulai sesi untuk menyimpan data login

// Koneksi database
include 'koneksi.php';

// Mengecek apakah form login telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $role = $_POST['role']; // Mendapatkan jenis login (user/admin)

    if ($role == 'admin') {
        // Cek login untuk admin
        $query_admin = "SELECT * FROM admin WHERE username = '$username'";
        $result_admin = mysqli_query($koneksi, $query_admin);

        if (mysqli_num_rows($result_admin) > 0) {
            $data = mysqli_fetch_assoc($result_admin);

            // Verifikasi password untuk admin
            if ($data['password'] == $password || password_verify($password, $data['password'])) {
                $_SESSION['admin'] = $data['username']; // Menyimpan data login ke session
                header("Location: index.php"); // Arahkan ke halaman admin
                exit;
            } else {
                $error = "Password admin salah!";
            }
        } else {
            $error = "Username admin tidak ditemukan!";
        }
    } elseif ($role == 'user') {
        // Cek login untuk user biasa
        $query_user = "SELECT * FROM users WHERE username = '$username'";
        $result_user = mysqli_query($koneksi, $query_user);

        if (mysqli_num_rows($result_user) > 0) {
            $data = mysqli_fetch_assoc($result_user);

            // Verifikasi password untuk user
            if ($data['password'] == $password || password_verify($password, $data['password'])) {
                $_SESSION['user'] = $data['username']; // Menyimpan data login ke session
                header("Location: index_user.php"); // Arahkan ke halaman user
                exit;
            } else {
                $error = "Password user salah!";
            }
        } else {
            $error = "Username user tidak ditemukan!";
        }
    } else {
        $error = "Pilih jenis login (Admin atau User)!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Font Awesome CDN untuk ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            background-color: #f4f4f4;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9); /* Semi transparan */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 280px; /* Lebar box lebih kecil */
            text-align: center;
            z-index: 10;
        }

        h2 {
            margin-bottom: 20px;
        }

        input, select {
            font-family: 'Times New Roman', Times, serif; /* Mengubah font menjadi Times New Roman */
            font-size: 14px; /* Mengatur ukuran font lebih kecil */
            width: 100%;
            padding: 5px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-left: -10px;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #4CAF50;
            color: white;
            font-size: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .footer {
            margin-top: 20px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }

        .back-link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        /* Video latar belakang */
        .background-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .password-container {
            position: relative;
        }

        .eye-icon {
            position: absolute;
            right: 10px;
            top: 20px;
            cursor: pointer;
            font-size: 10x;
        }

        /* Mengatur jarak antara h2 dan h6 */
        .login-container h2 {
            margin-bottom: 10px; /* Mengatur jarak bawah h2 agar lebih rapat dengan h6 */
        }

        h6.text-muted {
            font-weight: normal;  /* Menghapus bold */
            color: #6c757d;  /* Menambahkan warna abu-abu untuk tampilan yang lebih ringan */
            font-size: 16px;  /* Ukuran font bisa disesuaikan */
            margin-top: 0;  /* Menghilangkan margin atas */
        }
    </style>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
</head>
<body>

<!-- Video Latar Belakang -->
<video class="background-video" autoplay loop muted>
    <source src="image/gambar_latarbelakang.MP4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<!-- Form Login -->
<div class="login-container">
    <h2>Login</h2>
    <h6 class="text-muted">Jika Sudah Punya Akun!</h6>

    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Password:</label>
        <div class="password-container">
            <input type="password" name="password" id="password" required>
            <i id="eye-icon" class="fa fa-eye-slash eye-icon" onclick="togglePassword()"></i>
        </div><br><br>

        <!-- Dropdown Pemilihan Jenis Login -->
        <label for="role">Login Sebagai:</label>
        <select name="role" id="role" required>
            <option value="">Pilih</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select><br><br>

        <button type="submit">Login</button>
    </form>

    <?php
    if (isset($error)) {
        echo "<p class='error'>$error</p>";
    }
    ?>

    <!-- Link untuk registrasi -->
    <div class="back-link">
        <p>Belum punya akun? <a href="register.php">Segera Daftar</a></p>
    </div>

    <div class="footer">
        <p><span>By</span> <span>Muhammad Alfan Rizieq</span></p>
    </div>

</div>

</body>
</html>
