<?php
require_once "../koneksi.php";
require_once "cek_login.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data produk
$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id='$id'");

if(mysqli_num_rows($query)==0){
    echo "<script>
            alert('Produk tidak ditemukan');
            window.location='produk.php';
          </script>";
    exit;
}

$data = mysqli_fetch_assoc($query);

// Hapus gambar jika ada
if(!empty($data['gambar'])){
    $file = "../assets/images/".$data['gambar'];
    if(file_exists($file)){
        unlink($file);
    }
}

// Hapus datasheet jika ada
if(!empty($data['datasheet'])){
    $file = "../assets/datasheets/".$data['datasheet'];
    if(file_exists($file)){
        unlink($file);
    }
}

// Hapus data dari database
$hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE id='$id'");

if($hapus){
    echo "<script>
            alert('Produk berhasil dihapus');
            window.location='produk.php';
          </script>";
}else{
    echo "<script>
            alert('Gagal menghapus produk');
            window.location='produk.php';
          </script>";
}
?>