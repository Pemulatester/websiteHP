<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'];

$query = "DELETE FROM users WHERE id = $id";
if (mysqli_query($koneksi, $query)) {
    header("Location: lihat_user.php");
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>
