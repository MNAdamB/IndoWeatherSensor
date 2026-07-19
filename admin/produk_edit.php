<?php
require_once "../koneksi.php";
require_once "cek_login.php";

// Ambil ID Produk
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data produk
$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id='$id'");

if (mysqli_num_rows($query) == 0) {
    echo "<script>
            alert('Produk tidak ditemukan');
            window.location='produk.php';
          </script>";
    exit;
}

$produk = mysqli_fetch_assoc($query);

// Ambil kategori
$kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");

// Proses Update
if (isset($_POST['simpan'])) {

    $kategori_id = mysqli_real_escape_string($koneksi, $_POST['kategori_id']);
    $kode_produk = mysqli_real_escape_string($koneksi, $_POST['kode_produk']);
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga       = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $stok        = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $deskripsi   = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $status      = mysqli_real_escape_string($koneksi, $_POST['status']);
    $urutan      = mysqli_real_escape_string($koneksi, $_POST['urutan']);

    // Gunakan file lama
    $gambar = $produk['gambar'];
    $datasheet = $produk['datasheet'];

    // Upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {

        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $namaGambar = time() . "_img." . $ext;

        move_uploaded_file(
            $_FILES['gambar']['tmp_name'],
            "../assets/images/" . $namaGambar
        );

        $gambar = $namaGambar;
    }

    // Upload datasheet baru
    if (!empty($_FILES['datasheet']['name'])) {

        $ext = strtolower(pathinfo($_FILES['datasheet']['name'], PATHINFO_EXTENSION));
        $namaPdf = time() . "_pdf." . $ext;

        move_uploaded_file(
            $_FILES['datasheet']['tmp_name'],
            "../assets/datasheets/" . $namaPdf
        );

        $datasheet = $namaPdf;
    }

    $update = mysqli_query($koneksi, "
        UPDATE produk SET
            kategori_id='$kategori_id',
            kode_produk='$kode_produk',
            nama_produk='$nama_produk',
            harga='$harga',
            stok='$stok',
            gambar='$gambar',
            datasheet='$datasheet',
            deskripsi='$deskripsi',
            status='$status',
            urutan='$urutan'
        WHERE id='$id'
    ");

    if ($update) {
        echo "<script>
                alert('Produk berhasil diperbarui');
                window.location='produk.php';
              </script>";
    } else {
        echo "<div class='alert alert-danger'>
                Gagal mengupdate data :
                ".mysqli_error($koneksi)."
              </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Edit Produk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<div class="card">

<div class="card-header bg-warning text-dark">

<h4>Edit Produk</h4>

</div>

<div class="card-body">

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">

<label class="form-label">Kategori</label>

<select name="kategori_id" class="form-select" required>

<?php while($k=mysqli_fetch_assoc($kategori)){ ?>

<option
value="<?= $k['id']; ?>"
<?= ($produk['kategori_id']==$k['id']) ? "selected" : ""; ?>>

<?= $k['nama_kategori']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label class="form-label">Kode Produk</label>

<input
type="text"
name="kode_produk"
class="form-control"
value="<?= htmlspecialchars($produk['kode_produk']); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Nama Produk</label>

<input
type="text"
name="nama_produk"
class="form-control"
value="<?= htmlspecialchars($produk['nama_produk']); ?>"
required>

</div>

<div class="row">

<div class="col-md-6">

<label class="form-label">Harga</label>

<input
type="number"
name="harga"
class="form-control"
value="<?= $produk['harga']; ?>"
required>

</div>

<div class="col-md-6">

<label class="form-label">Stok</label>

<input
type="number"
name="stok"
class="form-control"
value="<?= $produk['stok']; ?>"
required>

</div>

</div>

<br>

<div class="mb-3">

<label class="form-label">Gambar</label>

<input
type="file"
name="gambar"
class="form-control">

<?php if($produk['gambar']!=""){ ?>

<div class="mt-2">

<small class="text-muted">Gambar Saat Ini</small><br>

<img
src="../assets/images/<?= $produk['gambar']; ?>"
width="180"
class="img-thumbnail">

</div>

<?php } ?>

</div>

<div class="mb-3">

<label class="form-label">Datasheet PDF</label>

<input
type="file"
name="datasheet"
class="form-control">

<?php if($produk['datasheet']!=""){ ?>

<div class="mt-2">

<a
href="../assets/datasheets/<?= $produk['datasheet']; ?>"
target="_blank"
class="btn btn-outline-primary btn-sm">

Lihat Datasheet Saat Ini

</a>

</div>

<?php } ?>

</div>

<div class="mb-3">

<label class="form-label">Deskripsi</label>

<textarea
name="deskripsi"
rows="5"
class="form-control"><?= htmlspecialchars($produk['deskripsi']); ?></textarea>

</div>

<div class="row">

<div class="col-md-6">

<label class="form-label">Status</label>

<select
name="status"
class="form-select">

<option
value="aktif"
<?= ($produk['status']=="aktif") ? "selected" : ""; ?>>

Aktif

</option>

<option
value="nonaktif"
<?= ($produk['status']=="nonaktif") ? "selected" : ""; ?>>

Nonaktif

</option>

</select>

</div>

<div class="col-md-6">

<label class="form-label">Urutan</label>

<input
type="number"
name="urutan"
class="form-control"
value="<?= $produk['urutan']; ?>"
required>

</div>

</div>

<br>

<button
type="submit"
name="simpan"
class="btn btn-warning">

Update Produk

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