<?php
session_start(); // Memulai sesi untuk menyimpan data login

// Koneksi ke database
include 'koneksi.php';

// Memeriksa jika formulir registrasi disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($koneksi, $_POST['confirm_password']);

    // Validasi password dan konfirmasi password
    if ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok!";
    } else {
        // Hash password sebelum disimpan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Periksa apakah username sudah ada
        $check_query = "SELECT * FROM users WHERE username = '$username'";
        $check_result = mysqli_query($koneksi, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Username sudah terdaftar!"; // Username sudah ada
        } else {
            // Query untuk menambahkan pengguna baru
            $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

            if (mysqli_query($koneksi, $insert_query)) {
                $_SESSION['user'] = $username; // Menyimpan data login ke sesi
                header("Location: index_user.php"); // Arahkan ke halaman pengguna setelah registrasi berhasil
                exit;
            } else {
                $error = "Gagal mendaftar: " . mysqli_error($koneksi);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Pengguna</title>
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
            background-color: #f4f4f4;
        }

        .register-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-left: -10px;
        }

        button {
            width: 100%;
            padding: px;
            border: none;
            background-color: #4CAF50;
            color: white;
            font-size: 20px;
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
            margin-top: 20px;
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
            right: 5px;
            top: 20px;
            cursor: pointer;
        }
    </style>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('confirm_password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                confirmPasswordField.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                confirmPasswordField.type = 'password';
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

<div class="register-container">
    <h2>Registrasi Pengguna</h2>
    <form action="register.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Password:</label>
        <div class="password-container">
            <input type="password" name="password" id="password" required>
            <i id="eye-icon" class="fa fa-eye-slash eye-icon" onclick="togglePassword()"></i>
        </div><br><br>

        <label for="confirm_password">Konfirmasi Password:</label>
        <div class="password-container">
            <input type="password" name="confirm_password" id="confirm_password" required>
            <i id="eye-icon" class="fa fa-eye-slash eye-icon" onclick="togglePassword()"></i>
        </div><br><br>

        <button type="submit">Daftar</button>
    </form>

    <?php
    if (isset($error)) {
        echo "<p class='error'>$error</p>";
    }
    ?>

    <div class="back-link">
        <p>Sudah punya akun? <a href="login.php">Segera Login</a></p>
    </div> 
</div>

</body>
</html>
