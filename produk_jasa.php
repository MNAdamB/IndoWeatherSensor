<?php 
session_start(); 

require_once "koneksi.php";


// Ambil semua produk kategori Jasa
$kategori_id = 5;

$query = mysqli_query($koneksi,"
SELECT *
FROM produk
WHERE kategori_id='$kategori_id'
AND status='aktif'
ORDER BY urutan ASC, nama_produk ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jasa Instalasi - IndoWeatherSensor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .service-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%);
        }
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
            background: linear-gradient(145deg, #fff 0%, #f1f3f4 100%);
        }
        .hero-section {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 4rem 0;
        }
        .contact-card {
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }
        .form-floating-custom label {
            color: #6c757d;
            font-weight: 500;
        }
        @media (max-width: 768px) {
            .hero-section { padding: 2rem 0; }
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
                <li class="breadcrumb-item active">Jasa Instalasi</li>
            </ol>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-2">
                        <i class="fas fa-tools me-3"></i>Jasa Instalasi Profesional
                    </h1>
                    <div class="h2 mb-4 text-white-50">Mulai dari <span class="text-warning">Rp 7.500.000</span></div>
                    <p class="lead fs-5 mb-0">Tim teknisi bersertifikat siap menginstalasi weather station di seluruh Indonesia.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container my-5">
        

        <!-- Services Grid -->
        <div class="row g-4 mb-5">
            <?php
            // PHP Array layanan dengan looping
            $services = [
                [
                    'icon' => 'fas fa-tools', 
                    'title' => 'Instalasi Hardware', 
                    'desc' => 'Pemasangan semua sensor, mounting, kabel wiring, dan grounding lengkap'
                ],
                [
                    'icon' => 'fas fa-laptop-code', 
                    'title' => 'Setup Software', 
                    'desc' => 'Konfigurasi data logger, cloud dashboard, dan integrasi sistem'
                ],
                [
                    'icon' => 'fas fa-headset', 
                    'title' => 'Training Penggunaan', 
                    'desc' => 'Pelatihan hands-on 8 jam untuk operator dan maintenance team'
                ],
                [
                    'icon' => 'fas fa-shield-alt', 
                    'title' => 'Garansi Instalasi', 
                    'desc' => '1 tahun garansi instalasi + support teknis 24/7 via hotline'
                ]
            ];
            ?>
            <?php foreach ($services as $service): ?>
            <div class="col-md-6 col-lg-3">
                <div class="service-card h-100 p-4 rounded-3 text-center">
                    <div class="display-4 text-success mb-4">
                        <i class="<?php echo $service['icon']; ?>"></i>
                    </div>
                    <h5 class="fw-bold mb-3"><?php echo $service['title']; ?></h5>
                    <p class="text-muted mb-0"><?php echo $service['desc']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pricing Tiers -->
        <div class="row justify-content-center mb-5 g-4">
            <div class="row g-4">
                <?php while($row = mysqli_fetch_assoc($query)){ ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-lg border-0">
                        <?php if($row['gambar']!=""){ ?>
                        <img src="assets/images/<?= $row['gambar']; ?>" class="card-img-top" style="height:230px;object-fit:cover;">
                        <?php } ?>
                        <div class="card-body d-flex flex-column">
                            <h4 class="card-title">
                                <?= htmlspecialchars($row['nama_produk']); ?>
                            </h4>
                            <p class="text-muted">
                                <?= nl2br(htmlspecialchars(substr($row['deskripsi'],0))); ?>
                            </p>
                            <div class="mt-auto">
                                <h4 class="text-success fw-bold">
                                    Rp <?= number_format($row['harga'],0,",","."); ?>
                                </h4>
                                <?php if($row['datasheet']!=""){ ?>
                                <a href="assets/datasheets/<?= $row['datasheet']; ?>" target="_blank" class="btn btn-outline-primary w-100 mb-2">
                                    <i class="fas fa-file-pdf"></i>
                                    Brosur
                                </a>
                                <?php } ?>
                                <button class="btn btn-success w-100 btn-pesan" 
                                    data-id="<?= $row['id']; ?>" 
                                    data-nama="<?= htmlspecialchars($row['nama_produk']); ?>"
                                    data-login="<?= isset($_SESSION['user_id']) ? 1 : 0; ?>">
                                    <i class="fas fa-shopping-cart"></i>
                                    Pesan Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>        
    </div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="modalPesan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    Konfirmasi Pemesanan
                </h5>
                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Anda akan diarahkan ke
                    <strong>Weather Station Configurator</strong>.
                </p>
                <p>
                    Nanti silakan pilih:
                </p>
                <h5 id="namaProduk" class="text-success"></h5>
                <p>
                    Silakan lanjutkan konfigurasi Weather Station.
                </p>
            </div>
            <div class="modal-footer">
                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Batal
                </button>
                <a
                    href="#"
                    id="btnLanjut"
                    class="btn btn-success">
                    Ya, Lanjut
                </a>
            </div>
        </div>
    </div>
</div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        
        // Tombol Pesan Sekarang
        document.querySelectorAll('.btn-pesan').forEach(function(btn){

            btn.addEventListener('click',function(){

                const id = this.dataset.id;
                const nama = this.dataset.nama;
                const login = this.dataset.login;

                if(login=="0"){

                    window.location =
                        "login.php?redirect=produk_jasa.php";

                    return;
                }

                document.getElementById("namaProduk").innerHTML = nama;

                document.getElementById("btnLanjut").href =
                    "ws_config.php?produk="+id;

                let modal = new bootstrap.Modal(
                    document.getElementById("modalPesan")
                );

                modal.show();

            });

        });

    </script>
</body>
</html>