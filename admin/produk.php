<?php
require_once "../koneksi.php";
require_once "cek_login.php";

// Pencarian
$cari = "";
$where = "";

if (isset($_GET['cari'])) {
    $cari = trim($_GET['cari']);
    $where = "WHERE
        produk.nama_produk LIKE '%$cari%'
        OR produk.kode_produk LIKE '%$cari%'
        OR kategori.nama_kategori LIKE '%$cari%'";
}

// Query
$sql = "
SELECT
    produk.*,
    kategori.nama_kategori
FROM produk
LEFT JOIN kategori
ON produk.kategori_id = kategori.id
$where
ORDER BY produk.urutan ASC, produk.nama_produk ASC
";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die(mysqli_error($koneksi));
}
?>

<!doctype html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Manajemen Produk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-3">

<h2>Manajemen Produk</h2>

<a href="dashboard.php" class="btn btn-secondary">
Kembali
</a>

</div>

<div class="card">

<div class="card-header bg-primary text-white">

Daftar Produk

</div>

<div class="card-body">

<div class="row mb-3">

<div class="col-md-3">

<a href="produk_tambah.php" class="btn btn-success">
+ Tambah Produk
</a>

</div>

<div class="col-md-9">

<form method="GET">

<div class="input-group">

<input
type="text"
name="cari"
class="form-control"
placeholder="Cari nama produk, kode atau kategori..."
value="<?= htmlspecialchars($cari); ?>">

<button class="btn btn-primary">
Cari
</button>

<?php
if($cari!=""){
?>

<a href="produk.php" class="btn btn-secondary">
Reset
</a>

<?php
}
?>

</div>

</form>

</div>

</div>

<table class="table table-bordered table-hover align-middle">

<thead class="table-dark">

<tr>

<th width="50">No</th>

<th width="90">Foto</th>

<th>Kode</th>

<th>Nama Produk</th>

<th>Kategori</th>

<th>Harga</th>

<th>Stok</th>

<th>Status</th>

<th width="160">Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($row=mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++; ?></td>

<td>

<?php

if($row['gambar']!=""){

?>

<img src="../assets/images/<?= $row['gambar']; ?>" width="80">

<?php

}else{

echo "<span class='text-muted'>Tidak ada</span>";

}

?>

</td>

<td><?= htmlspecialchars($row['kode_produk']); ?></td>

<td><?= htmlspecialchars($row['nama_produk']); ?></td>

<td><?= htmlspecialchars($row['nama_kategori']); ?></td>

<td>

Rp <?= number_format($row['harga'],0,",","."); ?>

</td>

<td><?= $row['stok']; ?></td>

<td>

<?php

if($row['status']=="aktif"){

echo "<span class='badge bg-success'>Aktif</span>";

}else{

echo "<span class='badge bg-danger'>Nonaktif</span>";

}

?>

</td>

<td>

<a
href="produk_edit.php?id=<?= $row['id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="produk_hapus.php?id=<?= $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin ingin menghapus produk ini?')">

Hapus

</a>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

</body>

</html>