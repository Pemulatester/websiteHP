<?php
session_start();

// Mengecek apakah user sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php'; // Koneksi database
require_once('tcpdf/tcpdf.php'); // Memasukkan pustaka TCPDF

// Mendapatkan ID HP dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Mendapatkan ID HP
    $query = "SELECT * FROM hp WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($result);
} else {
    header("Location: index.php"); // Jika tidak ada ID yang diterima
    exit;
}

// Membuat objek TCPDF
$pdf = new TCPDF();
$pdf->AddPage(); // Menambahkan halaman

// Menambahkan judul
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Data HP - ' . $data['nama'], 0, 1, 'C');

// Menambahkan gambar di atas tabel
$pdf->SetFont('helvetica', '', 12);
$pdf->Ln(10); // Jarak
$pdf->Cell(0, 10, 'Gambar ' . $data['nama'], 0, 1, 'C'); // Menampilkan teks "Gambar [nama HP]"

// Menampilkan gambar
$imagePath = 'image/' . $data['gambar'];
$pdf->Image($imagePath, 10, $pdf->GetY(), 50, 50); // Gambar lebih besar (50x50)
$pdf->Ln(60); // Memberikan jarak setelah gambar

// Menambahkan tabel untuk data HP
$pdf->SetFont('helvetica', '', 12);

// Menggambar tabel header
$pdf->Cell(40, 10, 'Nama HP', 1, 0, 'C');
$pdf->Cell(40, 10, 'Harga', 1, 0, 'C');
$pdf->Cell(60, 10, 'Spesifikasi', 1, 1, 'C');

// Menambahkan data HP ke tabel
$pdf->Cell(40, 10, $data['nama'], 1, 0, 'C');
$pdf->Cell(40, 10, number_format($data['harga'], 0, ',', '.') . ' IDR', 1, 0, 'C');
$pdf->Cell(60, 10, $data['spesifikasi'], 1, 1, 'C');

// Menyelesaikan dan menampilkan PDF
$pdf->Output('Data_HP_' . $data['nama'] . '.pdf', 'I'); // Menampilkan PDF di browser
?>
