<?php
session_start();

require_once "koneksi.php";

$q = trim($_GET['q'] ?? '');

$produk = [];

if($q != ""){

    $keyword = mysqli_real_escape_string($koneksi,$q);

    $sql = "
    SELECT
        produk.*,
        kategori.nama_kategori
    FROM produk
    LEFT JOIN kategori
        ON produk.kategori_id = kategori.id
    WHERE
    (
        produk.nama_produk LIKE '%$keyword%'
        OR produk.kode_produk LIKE '%$keyword%'
        OR produk.deskripsi LIKE '%$keyword%'
        OR kategori.nama_kategori LIKE '%$keyword%'
    )
    AND produk.status='aktif'
    ORDER BY
        produk.nama_produk ASC
    ";

    $query = mysqli_query($koneksi,$sql);

}
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>
            Hasil Pencarian
        </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    </head>
    <body>
        <?php include "includes/navbar.php"; ?>
        <div class="container py-5">
            <h2 class="mb-2">
                <i class="fas fa-search me-2"></i>
                Hasil Pencarian
            </h2>
            <p class="text-muted">
                Kata kunci :
                <strong>
                    <?= htmlspecialchars($q); ?>
                </strong>
            </p>
            <hr>
            <?php
            if($q==""){ ?>
            <div class="alert alert-warning">
                Silakan masukkan kata kunci pencarian.
            </div>
            <?php }else{
                if(mysqli_num_rows($query)==0){ ?>
            <div class="alert alert-danger">
                Produk tidak ditemukan.
            </div>
            <?php }else{ ?>
            <div class="row">
                <?php while($row=mysqli_fetch_assoc($query)) { ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if($row['gambar']!=""){ ?>
                        <img src="assets/images/<?= $row['gambar']; ?>"class="card-img-top" style="height:220px;object-fit:contain;">
                        <?php } ?>
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-primary mb-2 w-50 text-center fs-6">
                                <?= $row['nama_kategori']; ?>
                            </span>
                            <h5>
                                <?= htmlspecialchars($row['nama_produk']); ?>
                            </h5>
                            <p class="text-muted small">
                                <?= substr(strip_tags($row['deskripsi']),0,120); ?>
                                ...
                            </p>
                            <h5 class="text-success">
                                Rp <?= number_format($row['harga'],0,",","."); ?>
                            </h5>
                            <div class="mt-auto">
                                <?php $link="produk.php"; switch($row['kategori_id']){
                                    case 1: $link="produk_sensor_cuaca.php"; break;
                                    case 2: $link="produk_sensor_udara.php"; break;
                                    case 3: $link="produk_datalogger.php"; break;
                                    case 4: $link="produk_aksesoris.php"; break;
                                    case 5: $link="produk_jasa.php"; break;
                                    } ?>
                                    <a href="<?= $link; ?>"class="btn btn-success w-100">
                                        Lihat Produk
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            <?php }
            } ?>
            </div>
                    
            <?php include "includes/footer.php"; ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</html>