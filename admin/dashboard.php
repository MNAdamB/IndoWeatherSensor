<?php
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../koneksi.php";
require_once __DIR__ . "/cek_login.php";

// Hitung jumlah produk
$qProduk = mysqli_query($koneksi,"SELECT COUNT(*) total FROM produk");
$jProduk = mysqli_fetch_assoc($qProduk);

// Hitung kategori
$qKategori = mysqli_query($koneksi,"SELECT COUNT(*) total FROM kategori");
$jKategori = mysqli_fetch_assoc($qKategori);

// Hitung konfigurasi / inquiry
$qInquiry = mysqli_query($koneksi,"
SELECT COUNT(*) AS total
FROM konfigurasi
");

$jInquiry = mysqli_fetch_assoc($qInquiry);

$qUser = mysqli_query($koneksi,"
SELECT COUNT(*) AS total
FROM users
");

$jUser = mysqli_fetch_assoc($qUser);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include "../includes/navbar.php"; ?>

<div class="container mt-5">

<h2>Dashboard Administrator</h2>

<hr>

<p>Selamat datang,
<b><?php echo $_SESSION['nama']; ?></b></p>

<div class="row">

<div class="col-md-4">

<div class="card">

<div class="card-body">

<h5>Jumlah Produk</h5>

<h2><?php echo $jProduk['total']; ?></h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card">

<div class="card-body">

<h5>Jumlah Kategori</h5>

<h2><?php echo $jKategori['total']; ?></h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card">

<div class="card-body">

<h5>Inquiry</h5>

<h2><?php echo $jInquiry['total']; ?></h2>

</div>

</div>

</div>

</div>

<div class="mt-4">

<a href="<?php echo BASE_URL; ?>admin/produk.php" class="btn btn-primary">
Kelola Produk
</a>


</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>