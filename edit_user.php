<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'];
$query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "UPDATE users SET username='$username', password='$password' WHERE id=$id";
    if (mysqli_query($koneksi, $query)) {
        header("Location: lihat_user.php");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-primary">Edit User</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo $user['username']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" value="<?php echo $user['password']; ?>" required>
        </div>
        <button type="submit" class="btn btn-warning">Edit</button>
        <a href="lihat_user.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
