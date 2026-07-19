<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
// PHP Variable
$company_name = "IndoWeatherSensor";
$tagline = "Solusi Terlengkap Stasiun Cuaca & Sensor Lingkungan";
$slogan = "Monitoring Cuaca Akurat, Data Terpercaya";

// Array Produk Top Sales
$top_products = [
    [
        "name" => "Data Logger Telemetri", 
        "price" => 15500000, 
        "image" => "assets/images/products/DLT-101.png",
        "Link" => "produk_datalogger.php"
    ],
    [
        "name" => "Sensor Cuaca", 
        "price" => 3800000, 
        "image" => "assets/images/products/sensor-cuaca.png",
        "Link" => "produk_sensor_cuaca.php"
    ],
    [
        "name" => "Sensor Kualitas Udara", 
        "price" => 4500000, 
        "image" => "assets/images/products/sensor-kualitas-udara.png",
        "Link" => "produk_sensor_udara.php"
    ]
];

// Function untuk format harga
function formatRupiah($harga) {
    return "Rp " . number_format($harga, 0, ',', '.');
}

// Procedure untuk set cookie kunjungan
function setVisitCookie() {
    if (!isset($_COOKIE['visit_count'])) {
        setcookie('visit_count', 1, time() + (86400 * 30), "/");
    } else {
        $count = $_COOKIE['visit_count'] + 1;
        setcookie('visit_count', $count, time() + (86400 * 30), "/");
    }
}
setVisitCookie();

$visit_count = isset($_COOKIE['visit_count']) ? $_COOKIE['visit_count'] : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $company_name; ?> - <?php echo $tagline; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-slide { height: 500px; background-size: cover; background-position: center; }
        .navbar-brand { font-weight: bold; font-size: 1.5rem; }
        .top-sales-card { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); overflow: hidden;}
        .top-sales-card:hover { transform: translateY(-15px) scale(1.02); box-shadow: 0 25px 50px rgba(0,0,0,0.2) !important;}
        .top-sales-card img { transition: transform 0.4s ease;}
        .top-sales-card:hover img { transform: scale(1.1);}
        .card-body { background: linear-gradient(135deg, #f8f9ff 0%, #e8ecff 100%);}
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="bg-light py-2">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '>';">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php" class="fw-bold text-decoration-none">Home</a></li>
                </ol>
            </nav>
        </div>
    </nav>

    <!-- Banner Slider -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active hero-slide" style="background-image: url('assets/images/CarouselWS1.jpg');">
                <a href="produk.php" target="_blank" class="stretched-link"></a>
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4 fw-bold text-white" style="text-shadow: 0 0 10px rgb(0, 0, 4), 0 0 30px rgba(0, 0, 4, 0.7);"><?php echo "Weather Station Set"; ?></h1>
                    <p class="lead fw-bold" style="text-shadow: 0 0 5px rgb(0, 0, 4), 0 0 10px rgba(0, 0, 4, 0.7);"><?php echo "mulai dari " . formatRupiah(75500000); ?></p>
                </div>
            </div>
            <div class="carousel-item hero-slide" style="background-image: url('assets/images/CarouselWS2.jpg');">
                <a href="produk_datalogger.php" target="_blank" class="stretched-link"></a>
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4 fw-bold text-white" style="text-shadow: 0 0 10px rgb(0, 0, 4), 0 0 30px rgba(0, 0, 4, 0.7);"><?php echo "Data Logger with Cloud Services"; ?></h1>
                    <p class="lead fw-bold" style="text-shadow: 0 0 5px rgb(0, 0, 4), 0 0 10px rgba(0, 0, 4, 0.7);"><?php echo "mulai dari " . formatRupiah(15000000); ?></p>
                </div>
            </div>
            <div class="carousel-item hero-slide" style="background-image: url('assets/images/CarouselWS3.jpg');">
                <a href="ws_config.php" target="_blank" class="stretched-link"></a>
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4 fw-bold text-white" style="text-shadow: 0 0 10px rgb(0, 0, 4), 0 0 30px rgba(0, 0, 4, 0.7);"><?php echo "Rakit Weather Stationmu"; ?></h1>
                    <p class="lead fw-bold" style="text-shadow: 0 0 5px rgb(0, 0, 4), 0 0 10px rgba(0, 0, 4, 0.7);"><?php echo "mulai dari " . formatRupiah(45000000); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Company Intro -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold"><?php echo $company_name; ?></h2>
                    <p class="lead"><?php echo $tagline; ?></p>
                    <p><?php echo $slogan; ?></p>
                    <p class="text-muted">Kami menyediakan solusi lengkap untuk monitoring cuaca dan kualitas udara dengan teknologi terkini. Pengalaman lebih dari 10 tahun melayani berbagai industri di seluruh Indonesia. Mengadopsi teknologi IoT terkini dengan layanan free cloud dan maintenance 1 tahun. Hardware yang kami gunakan merupakan teknologi terbaru berbahan material tahan cuaca yang mampu bertahan hingga 10 tahun. Sudah lebih dari 150 station kami pasang di seluruh Indonesia.</p>
                    <p class="text-muted">Data Logger telemetri kami bisa di integrasikan dengan berbagai sensor cuaca/kualitas udara/water level atau sensor lainnya dengan output analog atau digital (serial RS485 Modbus). Integrasi cloud bisa menggunakan http/https, MQTT, atau API khusus by request.</p>
                    <p class="text-muted">Anda bisa mengkonfigurasikan sendiri Weather station anda di website ini, dan estimasi harga sudah dapat anda lihat di konfigurasi anda. Jangan ragu hubungi kami jika anda memiliki konfigurasi spesial atau kebutuhan sensor cuaca/kualitas udara/water level yang tidak ada di website kami.</p>
                    <div class="mb-3">
                        <strong>Jumlah Pengunjung: <?php echo $visit_count; ?></strong>
                    </div>
                    <a href="produk.php" target="_blank" class="btn btn-primary btn-lg">Lihat Produk Kami</a>
                </div>
                <div class="col-lg-6">
                    <img src="assets/images/Home-image1.jpg" class="img-fluid rounded shadow" alt="Perusahaan">
                </div>
            </div>
        </div>
    </section>

    <!-- Top Sales -->
    <section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold text-primary">Produk Unggulan</h2>
        <div class="row">
            <?php
            // PHP Looping #1 - foreach dengan gambar asli
            foreach ($top_products as $index => $product): 
            ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 top-sales-card shadow-lg border-0 overflow-hidden">
                    <!-- GAMBAR DARI ARRAY -->
                    <img src="<?php echo $product['image']; ?>" 
                         class="card-img-top" 
                         alt="<?php echo $product['name']; ?>"
                         style="height: 250px; object-fit: contain;"
                         onerror="this.src='https://via.placeholder.com/400x250/007BFF/FFFFFF?text=<?php echo urlencode($product['name']); ?>'">
                    
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title fw-bold mb-3"><?php echo $product['name']; ?></h5>
                        <div class="h4 text-primary fw-bold mb-3"><?php echo formatRupiah($product['price']); ?></div>
                        <p class="card-text flex-grow-1 text-muted small mb-3">
                            <?php 
                            // Deskripsi singkat berdasarkan index
                            $descriptions = [
                                "Data logging 16 channel dengan koneksi 4G",
                                "Ultrasonic wind sensor tahan cuaca ekstrem", 
                                "Sistem solar power 200W dengan battery backup"
                            ];
                            echo $descriptions[$index] ?? "Produk berkualitas tinggi";
                            ?>
                        </p>
                        <a href="<?php echo $product['Link']; ?>" target="_blank" 
                           class="btn btn-primary w-100 mt-auto">
                            <i class="fas fa-eye me-2"></i>Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

    <!-- Video Embed -->
    <section class="py-5 bg-dark text-white">
        <div class="container">
            <h2 class="text-center mb-5">Video Produk Kami</h2>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/0ViSbQ9PuNw" title="Ambient Weather Station. Solusi Monitoring Cuaca" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/Ml9M8vldIC8" title="Instalasi Automatic Weather Station di Malang, Jawa Timur" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Buttons -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="mb-4">Coba konfigurasi Weather Station?, atau ingin tahu lebih tentang kami</h2>
            <div class="row justify-content-center g-4">
                <div class="col-md-3">
                    <a href="ws_config.php" class="btn btn-outline-light btn-lg w-100">Konfigurasi WS</a>
                </div>
                <div class="col-md-3">
                    <a href="aplikasi.php" class="btn btn-outline-light btn-lg w-100">Aplikasi</a>
                </div>
                <div class="col-md-3">
                    <a href="about.php" class="btn btn-outline-light btn-lg w-100">Tentang Kami</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>