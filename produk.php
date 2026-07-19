<?php session_start(); ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Produk - IndoWeatherSensor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .product-category {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 300px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .product-category:hover {
            transform: translateY(-15px) scale(1.05);
            box-shadow: 0 25px 50px rgba(0,0,0,0.3) !important;
            color: white !important;
            text-decoration: none !important;
        }
        .product-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
            transition: all 0.4s ease;
        }
        .product-category:hover .product-icon {
            transform: scale(1.2);
            opacity: 1;
        }
        .product-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .product-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }
        .category-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            padding: 2rem 1.5rem 1.5rem;
            transform: translateY(100%);
            transition: all 0.4s ease;
        }
        .product-category:hover .category-overlay {
            transform: translateY(0);
        }
        @media (max-width: 768px) {
            .product-category { height: 280px; margin-bottom: 1.5rem; }
            .product-icon { font-size: 3rem; }
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="bg-light py-2">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php" class="fw-bold text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page" class="fw-bold">Produk</li>
            </ol>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-4 bg-primary text-white">
        <div class="container text-center">
            <h1 class="display-5 fw-bold mb-4"><i class="fas fa-cloud-sun me-2"></i>Semua Kategori Produk</h1>
            <p class="lead mb-0 fw-bold">Silakan pilih kategori produk yang Anda butuhkan</p>
        </div>
    </section>

    <!-- Product Categories Grid -->
    <div class="container my-5">
        <div class="row g-4 justify-content-center">
            <!-- 1. Data Logger Telemetri -->
            <div class="col-lg-5 col-md-6">
                <a href="produk_datalogger.php" class="product-category d-block text-white text-decoration-none">
                    <div class="d-flex flex-column h-100 justify-content-center align-items-center p-5 position-relative">
                        <div class="product-icon">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <div class="text-center">
                            <h2 class="product-title">Data Logger Telemetri</h2>
                            <p class="product-subtitle mb-0">Data acquisition & transmisi real-time</p>
                        </div>
                        <div class="category-overlay">
                            <div class="h4 fw-bold mb-2">Lihat Produk</div>
                            <small class="opacity-90">Data Logger Terlengkap</small>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 2. Sensor Cuaca -->
            <div class="col-lg-5 col-md-6">
                <a href="produk_sensor_cuaca.php" class="product-category d-block text-white text-decoration-none" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <div class="d-flex flex-column h-100 justify-content-center align-items-center p-5 position-relative">
                        <div class="product-icon">
                            <i class="fas fa-cloud-sun-rain"></i>
                        </div>
                        <div class="text-center">
                            <h2 class="product-title">Sensor Cuaca</h2>
                            <p class="product-subtitle mb-0">Angin, hujan, suhu, radiasi</p>
                        </div>
                        <div class="category-overlay">
                            <div class="h4 fw-bold mb-2">Lihat Sensor</div>
                            <small class="opacity-90">Weather Station Lengkap</small>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 3. Sensor Kualitas Udara -->
            <div class="col-lg-5 col-md-6">
                <a href="produk_sensor_udara.php" class="product-category d-block text-white text-decoration-none" style="background: linear-gradient(135deg, #b068d6 0%, #b982a7 100%);">
                    <div class="d-flex flex-column h-100 justify-content-center align-items-center p-5 position-relative">
                        <div class="product-icon">
                            <i class="fas fa-lungs-virus"></i>
                        </div>
                        <div class="text-center">
                            <h2 class="product-title">Sensor Kualitas Udara</h2>
                            <p class="product-subtitle mb-0">CO, CO2, O2, PM2.5, H2S</p>
                        </div>
                        <div class="category-overlay">
                            <div class="h4 fw-bold mb-2">Lihat Sensor</div>
                            <small class="opacity-90">Air Quality Monitoring</small>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 4. Aksesoris -->
            <div class="col-lg-5 col-md-6">
                <a href="produk_aksesoris.php" class="product-category d-block text-white text-decoration-none" style="background: linear-gradient(135deg, #b20237 0%, #7a6d20 100%);">
                    <div class="d-flex flex-column h-100 justify-content-center align-items-center p-5 position-relative">
                        <div class="product-icon">
                            <i class="fas fa-solar-panel"></i>
                        </div>
                        <div class="text-center">
                            <h2 class="product-title">Aksesoris</h2>
                            <p class="product-subtitle mb-0">Solar panel, tripod, monopole</p>
                        </div>
                        <div class="category-overlay">
                            <div class="h4 fw-bold mb-2">Lihat Aksesoris</div>
                            <small class="opacity-90">Support System Lengkap</small>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 5. Jasa Instalasi -->
            <div class="col-lg-5 col-md-6">
                <a href="produk_jasa.php" class="product-category d-block text-white text-decoration-none" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                    <div class="d-flex flex-column h-100 justify-content-center align-items-center p-5 position-relative">
                        <div class="product-icon text-dark">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="text-center text-dark">
                            <h2 class="product-title fw-bold">Jasa Instalasi</h2>
                            <p class="product-subtitle mb-0 fs-5">Instalasi profesional di seluruh Indonesia</p>
                        </div>
                        <div class="category-overlay">
                            <div class="h4 fw-bold mb-2 text-dark">Hubungi Tim</div>
                            <small class="opacity-90 fw-semibold">Garansi 1 Tahun</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>