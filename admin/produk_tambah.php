<?php
require_once "../koneksi.php";
require_once "cek_login.php";

// Simpan data
if(isset($_POST['simpan'])){

    $kategori_id = mysqli_real_escape_string($koneksi,$_POST['kategori_id']);
    $kode_produk = mysqli_real_escape_string($koneksi,$_POST['kode_produk']);
    $nama_produk = mysqli_real_escape_string($koneksi,$_POST['nama_produk']);
    $harga       = mysqli_real_escape_string($koneksi,$_POST['harga']);
    $stok        = mysqli_real_escape_string($koneksi,$_POST['stok']);
    $deskripsi   = mysqli_real_escape_string($koneksi,$_POST['deskripsi']);
    $status      = mysqli_real_escape_string($koneksi,$_POST['status']);
    $urutan      = mysqli_real_escape_string($koneksi,$_POST['urutan']);

    // Upload gambar
    $gambar="";

    if($_FILES['gambar']['name']!=""){

        $ext = strtolower(pathinfo($_FILES['gambar']['name'],PATHINFO_EXTENSION));

        $namaBaru = time()."_img.".$ext;

        move_uploaded_file(
            $_FILES['gambar']['tmp_name'],
            "../assets/images/".$namaBaru
        );

        $gambar=$namaBaru;

    }

    // Upload datasheet

    $datasheet="";

    if($_FILES['datasheet']['name']!=""){

        $ext = strtolower(pathinfo($_FILES['datasheet']['name'],PATHINFO_EXTENSION));

        $namaBaru = time()."_pdf.".$ext;

        move_uploaded_file(
            $_FILES['datasheet']['tmp_name'],
            "../assets/datasheets/".$namaBaru
        );

        $datasheet=$namaBaru;

    }

    $sql = "INSERT INTO produk
    (
        kategori_id,
        kode_produk,
        nama_produk,
        harga,
        stok,
        gambar,
        datasheet,
        deskripsi,
        status,
        urutan
    )

    VALUES

    (
        '$kategori_id',
        '$kode_produk',
        '$nama_produk',
        '$harga',
        '$stok',
        '$gambar',
        '$datasheet',
        '$deskripsi',
        '$status',
        '$urutan'
    )";

    mysqli_query($koneksi,$sql);

    echo "<script>
    alert('Produk berhasil ditambahkan');
    window.location='produk.php';
    </script>";

}

// Ambil kategori

$kategori = mysqli_query($koneksi,"
SELECT *
FROM kategori
ORDER BY nama_kategori ASC
");

?>

<!doctype html>

<html lang="id">

<head>

<meta charset="UTF-8">

<title>Tambah Produk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<div class="card">

<div class="card-header bg-success text-white">

Tambah Produk

</div>

<div class="card-body">

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">

<label>Kategori</label>

<select
name="kategori_id"
class="form-control"
required>

<option value="">-- Pilih Kategori --</option>

<?php

while($k=mysqli_fetch_assoc($kategori)){

?>

<option value="<?= $k['id']; ?>">

<?= $k['nama_kategori']; ?>

</option>

<?php
}
?>

</select>

</div>

<div class="mb-3">

<label>Kode Produk</label>

<input
type="text"
name="kode_produk"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Nama Produk</label>

<input
type="text"
name="nama_produk"
class="form-control"
required>

</div>

<div class="row">

<div class="col-md-6">

<label>Harga</label>

<input
type="number"
name="harga"
class="form-control"
required>

</div>

<div class="col-md-6">

<label>Stok</label>

<input
type="number"
name="stok"
class="form-control"
required>

</div>

</div>

<br>

<div class="mb-3">

<label>Gambar</label>

<input
type="file"
name="gambar"
class="form-control">

</div>

<div class="mb-3">

<label>Datasheet PDF</label>

<input
type="file"
name="datasheet"
class="form-control">

</div>

<div class="mb-3">

<label>Deskripsi</label>

<textarea
name="deskripsi"
class="form-control"
rows="5"></textarea>

</div>

<div class="row">

<div class="col-md-6">

<label>Status</label>

<select
name="status"
class="form-control">

<option value="aktif">Aktif</option>

<option value="nonaktif">Nonaktif</option>

</select>

</div>

<div class="col-md-6">

<label>Urutan</label>

<input
type="number"
name="urutan"
class="form-control"
value="1">

</div>

</div>

<br>

<button
type="submit"
name="simpan"
class="btn btn-success">

Simpan Produk

</button>

<a
href="produk.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

</body>

</html>