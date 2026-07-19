<?php 
session_start(); 

require_once "koneksi.php";

// kategori Datalogger
$kategori_id = 3;

$query = mysqli_query($koneksi,"
SELECT *
FROM produk
WHERE kategori_id='$kategori_id'
AND status='aktif'
ORDER BY urutan ASC
");

$category = [
    "title"=>"Data Logger",
    "subtitle"=>"Data logger profesional untuk akuisisi dan penyimpanan data sensor"
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category['title']; ?> - IndoWeatherSensor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .sensor-full-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .sensor-full-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0,123,255,0.2) !important;
        }
        .sensor-image {
            height: 350px;
            object-fit: contain;
            transition: transform 0.4s ease;
        }
        .sensor-full-card:hover .sensor-image {
            transform: scale(1.1);
        }
        .spec-list {
            column-count: 2;
            column-gap: 20px;
            font-size: 0.9rem;
        }
        .spec-item {
            break-inside: avoid;
            margin-bottom: 8px;
            padding: 4px 0;
        }
        .spec-label {
            font-weight: 600;
            color: #495057;
            display: inline-block;
            width: 110px;
        }
        .spec-value {
            color: #28a745;
            font-weight: 500;
        }
        @media (max-width: 768px) {
            .spec-list { column-count: 1; }
            .sensor-image { height: 250px; }
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="bg-light py-2">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="produk.php">Produk</a></li>
                <li class="breadcrumb-item active"><?php echo $category['title']; ?></li>
            </ol>
        </div>
    </nav>

    <!-- Hero About -->
    <section class="py-4 bg-primary text-white">
        <div class="container text-center">
            <h1 class="display-5 fw-bold mb-4">
                <i class="fas fa-microchip me-2"></i><?= $category['title']; ?>
            </h1>

            <p class="lead mb-0 fw-bold">
                <?= $category['subtitle']; ?>
            </p>
        </div>
    </section>

    <div class="container my-5">

<?php
$index = 1;

if(mysqli_num_rows($query) > 0){

    while($sensor = mysqli_fetch_assoc($query)){
?>

    <!-- SENSOR #<?= $index ?> -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="sensor-full-card h-100">
                <div class="row g-0">

                    <!-- GAMBAR -->
                    <div class="col-lg-5">
                        <img src="assets/images/<?= htmlspecialchars($sensor['gambar']); ?>"
                             class="sensor-image w-100"
                             alt="<?= htmlspecialchars($sensor['nama_produk']); ?>">
                    </div>

                    <!-- INFO -->
                    <div class="col-lg-7 p-5">

                        <div class="d-flex justify-content-between align-items-start mb-4">

                            <div>

                                <h2 class="h3 fw-bold mb-2">
                                    <?= htmlspecialchars($sensor['nama_produk']); ?>
                                </h2>

                                <div class="h2 text-primary fw-bold">
                                    Rp <?= number_format($sensor['harga'],0,',','.'); ?>
                                </div>

                            </div>

                            <div class="text-end">

                                <?php if($sensor['stok'] > 0){ ?>

                                    <span class="badge bg-success fs-6 px-3 py-2 mb-2 d-block">
                                        Stok : <?= $sensor['stok']; ?>
                                    </span>

                                <?php }else{ ?>

                                    <span class="badge bg-danger fs-6 px-3 py-2 mb-2 d-block">
                                        Stok Habis
                                    </span>

                                <?php } ?>

                                <small class="text-muted">
                                    Inc. PPN 11%
                                </small>

                            </div>

                        </div>

                        <p class="lead mb-4">
                            <?= $sensor['deskripsi']; ?>
                        </p>

                        <div class="row g-3">

                            <div class="col-md-6">

                                <?php if(!empty($sensor['datasheet'])){ ?>

                                <a href="assets/datasheets/<?= htmlspecialchars($sensor['datasheet']); ?>"
                                   class="btn btn-outline-primary w-100"
                                   target="_blank">

                                    <i class="fas fa-download me-2"></i>
                                    Download Datasheet

                                </a>

                                <?php } ?>

                            </div>

                            <div class="col-md-6">

                                <a href="ws_config.php#sensor_<?php echo strtolower(str_replace([' ','(',')'],'',$sensor['nama_produk'])); ?>"
                                   class="btn btn-primary w-100">

                                    <i class="fas fa-cogs me-2"></i>
                                    Konfigurasi Sekarang

                                </a>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

<?php
        $index++;
    }

}else{
?>

<div class="alert alert-warning text-center">

    <h4>Belum Ada Produk</h4>

    <p class="mb-0">
        Produk Datalogger belum tersedia.
    </p>

</div>

<?php
}
?>
        <!-- CTA Final -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8 text-center">
                <div class="card border-0 shadow-lg p-4 bg-primary text-white">
                    <h2 class="display-6 fw-bold mb-4 text-white">
                        <i class="fas fa-rocket me-3"></i>Siapkan Weather Station Anda!
                    </h2>
                    <a href="ws_config.php" class="btn btn-outline-light btn-lg w-100">
                        <i class="fas fa-cogs me-2"></i>Mulai Konfigurasi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>