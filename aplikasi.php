<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi - IndoWeatherSensor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="bg-light py-2">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php" class="fw-bold text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" class="fw-bold text-decoration-none">Aplikasi</li>
            </ol>
        </div>
    </nav>
    
    <!-- Hero Portfolio -->
    <section class="py-4 bg-primary text-white">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-4"><i class="fas fa-cloud-sun me-2"></i>Portfolio Proyek</h2>
            <p class="lead mb-0 fw-bold">pada beberapa lini di Indonesia</p>
        </div>
    </section>

    <?php
    // Array proyek dengan gambar dan link external
    $projects = [
        [
            'title' => 'Pemantauan Badai', 
            'desc' => 'Sistem monitoring cuaca lengkap untuk antisipasi badai.',
            'image' => 'assets/images/projects/pemantauan-badai.jpg',
            'link' => 'https://youtu.be/HYJMroEpYN0'  // ← Link external
        ],
        [
            'title' => 'Pertanian Presisi', 
            'desc' => 'Monitoring iklim untuk optimalisasi panen dan irigasi otomatis.',
            'image' => 'assets/images/projects/pertanian-presisi.jpg',
            'link' => 'https://youtu.be/ZAT0IEY9CRQ'  // ← Link external
        ],
        [
            'title' => 'Industri Pertambangan', 
            'desc' => 'Sensor kualitas udara untuk keselamatan kerja dan kepatuhan regulasi.',
            'image' => 'assets/images/projects/industri-pertambangan.jpg',
            'link' => 'https://youtu.be/bxGlTMKBow8'  // ← Link external
        ],
        [
            'title' => 'Pemantauan Banjir', 
            'desc' => 'Sistem early warning banjir real-time dengan sensor level air.',
            'image' => 'assets/images/projects/pemantauan-banjir.jpg',
            'link' => 'https://youtu.be/GYLKbHUnSpA'  // ← Link external
        ]
    ];
    ?>
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <?php foreach ($projects as $project): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-lg border-0 project-card position-relative overflow-hidden">
                        <!-- GAMBAR DENGAN LINK EXTERNAL -->
                        <a href="<?php echo htmlspecialchars($project['link']); ?>" 
                        target="_blank" 
                        class="project-link"
                        rel="noopener noreferrer">
                            <img src="<?php echo $project['image']; ?>" 
                                class="card-img-top project-image"
                                alt="<?php echo htmlspecialchars($project['title']); ?>"
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/400x250/28A745/FFFFFF?text=<?php echo urlencode($project['title']); ?>';">
                        
                            <!-- Overlay Hover Effect -->
                            <div class="project-overlay">
                                <i class="fas fa-external-link-alt fa-2x text-white"></i>
                                <span class="text-white fw-bold mt-2 d-block">Lihat Proyek</span>
                            </div>
                        </a>
                    
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3"><?php echo htmlspecialchars($project['title']); ?></h5>
                            <p class="card-text text-muted small lh-sm"><?php echo htmlspecialchars($project['desc']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <style>
    .project-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: #fff;
        border: none !important;
        overflow: hidden;
    }

    .project-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(40, 167, 69, 0.2) !important;
    }

    .project-image {
        height: 200px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .project-link {
        position: relative;
        display: block;
        text-decoration: none;
        color: inherit;
    }

    .project-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(40, 167, 69, 0.9);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.4s ease;
        transform: scale(0.8);
    }

    .project-link:hover .project-overlay {
        opacity: 1;
        transform: scale(1);
    }

    .project-link:hover .project-image {
        transform: scale(1.1);
    }

    .project-card .card-body {
        border-top: 2px solid #28a745;
    }
    </style>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Fallback untuk gambar proyek
    document.querySelectorAll('.project-image').forEach(img => {
        img.onerror = function() {
            const title = this.alt;
            this.src = `https://via.placeholder.com/400x250/28A745/FFFFFF?text=${encodeURIComponent(title)}`;
        };
    
        // New tab confirmation
        const link = this.closest('.project-link');
        if (link) {
            link.addEventListener('click', function(e) {
                if (!confirm('Buka link proyek di tab baru?')) {
                    e.preventDefault();
                }
            });
        }
    });
    </script>
</body>
</html>