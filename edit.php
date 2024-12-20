<?php
// Menghubungkan ke database
include 'koneksi.php';

// Memeriksa apakah ID ada di URL dan valid
if (isset($_GET['id']) && intval($_GET['id']) > 0) {
    $id = intval($_GET['id']); // Mengubah ID ke integer untuk keamanan

    // Query untuk mengambil data berdasarkan ID
    $query = "SELECT * FROM hp WHERE id = $id";  // Mengubah query untuk tabel hp
    $result = mysqli_query($koneksi, $query);

    // Periksa apakah data ditemukan
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Data dengan ID $id tidak ditemukan. <br>";
        echo "<a href='index.php'>Kembali ke daftar HP</a>";
        exit;
    }
} else {
    echo "ID tidak valid atau tidak ditemukan! Pastikan ID yang benar telah diberikan di URL. <br>";
    echo "<a href='index.php'>Kembali ke daftar HP</a>";
    exit;
}

// Memeriksa jika formulir telah disubmit
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $spesifikasi = $_POST['spesifikasi'];

    // Query untuk memperbarui data, tanpa kolom id karena auto increment
    $updateQuery = "UPDATE hp SET nama = '$nama', harga = '$harga', spesifikasi = '$spesifikasi' WHERE id = $id";

    if (mysqli_query($koneksi, $updateQuery)) {
        // Setelah data diperbarui, alihkan pengguna ke index.php
        header("Location: index.php"); // Pengalihan ke index.php setelah sukses
        exit;
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data HP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="text"]:focus {
            border-color: #5b9bd5;
            outline: none;
        }

        button {
            background-color: #5b9bd5;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4a8cba;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }

        .back-link a {
            color: #5b9bd5;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .background-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
    </style>
</head>
<body>
<!-- Video Latar Belakang -->
<video class="background-video" autoplay loop muted>
    <source src="image/gambar_latarbelakang.MP4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<div class="container">
    <h2>Edit Data HP - ID: <?php echo $id; ?></h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="nama">Nama HP:</label>
            <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
        </div>

        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="text" name="harga" id="harga" value="<?php echo htmlspecialchars($data['harga']); ?>" required>
        </div>

        <div class="form-group">
            <label for="spesifikasi">Spesifikasi:</label>
            <input type="text" name="spesifikasi" id="spesifikasi" value="<?php echo htmlspecialchars($data['spesifikasi']); ?>" required>
        </div>

        <button type="submit" name="submit">Simpan Perubahan</button>
    </form>

    <div class="back-link">
        <a href="index.php">Kembali ke daftar HP</a>
    </div>
</div>

</body>
</html>
