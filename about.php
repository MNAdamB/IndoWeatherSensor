<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - IndoWeatherSensor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .stats-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="bg-light py-2">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php" class="fw-bold text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" class="fw-bold text-decoration-none">Tentang Kami</li>
            </ol>
        </div>
    </nav>

    <!-- Hero About -->
    <section class="py-4 bg-primary text-white">
        <div class="container text-center">
            <h1 class="display-5 fw-bold mb-4"><i class="fas fa-cloud-sun me-2"></i>Tentang IndoWeatherSensor</h1>
            <p class="lead mb-0 fw-bold">Pemimpin dalam solusi monitoring cuaca dan lingkungan di Indonesia</p>
        </div>
    </section>

    <!-- Company Timeline -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <img src="assets/images/OurOffice.png" class="img-fluid rounded shadow" alt="Kantor Kami">
                </div>
                <div class="col-lg-6">
                    <h3 class="lead fw-bold">PT. IndoWeather Sentosa</h3>
                    <p class="lead">Alamat: Jl. Merdeka No. 123, Jakarta, Indonesia</p>
                    <p class="lead">Didirikan pada tahun 2014, IndoWeatherSensor telah melayani lebih dari 150 proyek di seluruh Indonesia, menyediakan solusi monitoring cuaca dan kualitas udara untuk berbagai sektor seperti pertanian, industri, dan pemerintahan. Dengan pengalaman lebih dari 10 tahun, kami terus berinovasi untuk memberikan produk dan layanan terbaik bagi pelanggan kami.</p>
                    <div class="row text-center">
                        <?php
                        // PHP Array & Looping untuk stats
                        $stats = [
                            ['icon' => 'fas fa-project-diagram', 'value' => '150+', 'label' => 'Proyek Selesai'],
                            ['icon' => 'fas fa-users', 'value' => '140+', 'label' => 'Klien Puas'],
                            ['icon' => 'fas fa-calendar', 'value' => '10+', 'label' => 'Tahun Pengalaman']
                        ];
                        
                        foreach ($stats as $stat):
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="stats-card p-4 rounded shadow-lg text-white">
                                <i class="<?php echo $stat['icon']; ?> fa-2x mb-2"></i>
                                <div class="h2 fw-bold mb-1"><?php echo $stat['value']; ?></div>
                                <div><?php echo $stat['label']; ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    // PHP Array tim dengan looping
    $team = [
        [
            'name' => 'Adam Bachtiar', 
            'role' => 'CEO & Founder', 
            'photo' => 'assets/images/team/adam.png'
        ],
        [
            'name' => 'Taslim Syafii', 
            'role' => 'Technical Manager', 
            'photo' => 'assets/images/team/taslim.png'
        ],
        [
            'name' => 'Haikal Sungkar', 
            'role' => 'Field Engineer', 
            'photo' => 'assets/images/team/haikal.png'
        ],
        [
            'name' => 'Zulkifli', 
            'role' => 'Sales Manager', 
            'photo' => 'assets/images/team/zulkifli.png'
        ]
    ];
    ?>

    <!-- Our Team -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center fw-bold mb-5" style="color: #070795;">Tim Profesional Kami</h2>
            <div class="row g-4">
                <?php foreach ($team as $member): ?>
                <div class="col-md-3 col-sm-6 text-center">
                    <div class="card h-100 shadow-lg border-0 overflow-hidden team-card">
                        <!-- FOTO DARI ARRAY -->
                        <div class="position-relative overflow-hidden">
                            <img src="<?php echo $member['photo']; ?>" 
                                class="card-img-top rounded-circle mx-auto mt-4 team-photo"
                                alt="<?php echo htmlspecialchars($member['name']); ?>"
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/150x150/6c757d/e8eaed?text=<?php echo urlencode(substr($member['name'], 0, 1)); ?>';">
                        
                            <!-- Online Status Indicator -->
                            <div class="position-absolute bottom-0 end-0 mb-3 me-3">
                                <span class="badge bg-success rounded-circle" style="width: 20px; height: 20px;"></span>
                            </div>
                        </div>
                    
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold mb-2"><?php echo htmlspecialchars($member['name']); ?></h5>
                            <p class="text-primary mb-3 fw-semibold"><?php echo $member['role']; ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>