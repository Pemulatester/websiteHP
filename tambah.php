<?php
// Menyertakan file koneksi
include 'koneksi.php';

// Mengecek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form dan membersihkan input untuk keamanan
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $spesifikasi = mysqli_real_escape_string($koneksi, $_POST['spesifikasi']);
    
    // Menangani file gambar
    if (isset($_FILES['gambar'])) {
        $gambar = $_FILES['gambar'];
        
        // Mengecek apakah file gambar berhasil di-upload
        if ($gambar['error'] == 0) {
            // Menentukan path file tujuan
            $targetDir = "image/"; // Folder tempat gambar akan disimpan
            $targetFile = $targetDir . basename($gambar["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            
            // Validasi ekstensi file gambar (misalnya hanya jpg, jpeg, png)
            if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png") {
                // Mengupload file gambar ke server
                if (move_uploaded_file($gambar["tmp_name"], $targetFile)) {
                    // Query untuk menambahkan data ke database
                    $query = "INSERT INTO hp (nama, harga, spesifikasi, gambar) VALUES ('$nama', '$harga', '$spesifikasi', '" . basename($gambar["name"]) . "')";
                    
                    // Mengeksekusi query
                    if (mysqli_query($koneksi, $query)) {
                        // Jika sukses, arahkan ke halaman utama dengan pesan sukses
                        header("Location: index.php?message=Success");
                    } else {
                        // Jika gagal, tampilkan pesan kesalahan
                        echo "Error: " . mysqli_error($koneksi);
                    }
                } else {
                    echo "Gambar gagal diupload.";
                }
            } else {
                echo "Hanya file gambar dengan ekstensi JPG, JPEG, atau PNG yang diperbolehkan.";
            }
        } else {
            echo "Error saat meng-upload gambar.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data HP</title>
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

        input[type="text"], input[type="file"], button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="text"]:focus, input[type="file"]:focus {
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

        .image-preview {
            text-align: center;
            margin-bottom: 20px;
        }

        .image-preview img {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            margin-top: 10px;
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
    <h2>Tambah Data HP</h2>
    <form action="tambah.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama">Nama HP:</label>
            <input type="text" name="nama" id="nama" required>
        </div>

        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="text" name="harga" id="harga" required>
        </div>

        <div class="form-group">
            <label for="spesifikasi">Spesifikasi:</label>
            <input type="text" name="spesifikasi" id="spesifikasi" required>
        </div>

        <div class="form-group">
            <label for="gambar">Gambar:</label>
            <input type="file" name="gambar" id="gambar" accept="image/*" required>
        </div>

        <div class="image-preview" id="imagePreview"></div>

        <button type="submit">Tambah</button>
    </form>
</div>

<script>
    // Menampilkan preview gambar sebelum diupload
    document.getElementById('gambar').addEventListener('change', function (e) {
        var reader = new FileReader();
        reader.onload = function (event) {
            var image = new Image();
            image.src = event.target.result;
            image.classList.add('preview-image');
            
            var previewDiv = document.getElementById('imagePreview');
            previewDiv.innerHTML = ''; // Kosongkan preview lama
            previewDiv.appendChild(image); // Menampilkan gambar baru
        }
        reader.readAsDataURL(e.target.files[0]);
    });
</script>

</body>
</html>
