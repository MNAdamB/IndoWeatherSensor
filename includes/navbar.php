<?php
require_once __DIR__ . "/../config.php";

$is_logged_in = isset($_SESSION['user']);
$username = $is_logged_in ? $_SESSION['user'] : '';

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php">
            <i class="fas fa-cloud-sun me-2"></i>IndoWeatherSensor
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo strpos(basename($_SERVER['PHP_SELF']), 'produk') !== false ? 'active' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown">
                        Produk
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>produk_datalogger.php">Data Logger Telemetri</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>produk_sensor_cuaca.php">Sensor Cuaca</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>produk_sensor_udara.php">Sensor Kualitas Udara</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>produk_aksesoris.php">Aksesoris</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>produk_jasa.php">Jasa Instalasi</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item fw-bold" href="<?php echo BASE_URL; ?>produk.php">Produk</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'ws_config.php' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>ws_config.php">
                        <i class="fas fa-cogs me-1"></i>WS Config
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'aplikasi.php' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>aplikasi.php">Aplikasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>about.php">About Us</a>
                </li>
            </ul>
            
            <!-- Search Bar -->
            <form class="d-flex me-3" action="<?php echo BASE_URL; ?>search_result.php" method="GET">
                <div class="input-group input-group-sm">
                    <input class="form-control" type="search" name="q" placeholder="Cari produk..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" required>
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            
            <!-- Login Status -->
            <?php if ($is_logged_in): ?>
			    <div class="dropdown">
			        <a class="btn btn-outline-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
			            <i class="fas fa-user me-1"></i><?php echo $username; ?>
			        </a>
			        <ul class="dropdown-menu dropdown-menu-end">
                        <?php if($_SESSION['role']=="admin"): ?>
                        <li>
                            <a class="dropdown-item" href="<?php echo BASE_URL; ?>admin/dashboard.php">
                                Dashboard Admin
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo BASE_URL; ?>admin/produk.php">
                                Kelola Produk
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo BASE_URL; ?>admin/inquiry.php">
                                Kelola Inquiry
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="<?php echo BASE_URL; ?>profile.php">
                                Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo BASE_URL; ?>edit_profile.php">
                                Edit Profil
                            </a>
                        </li>
                        <?php else: ?>
                        <li>
                            <a class="dropdown-item" href="<?php echo BASE_URL; ?>profile.php">
                                Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo BASE_URL; ?>edit_profile.php">
                            Edit Profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo BASE_URL; ?>my_inquiry.php">
                            My Inquiry
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo BASE_URL; ?>ws_config.php">
                            Konfigurasi WS
                            </a>
                        </li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>logout.php">
                            Logout
                            </a>
                        </li>
                    </ul>
			    </div>
			<?php else: ?>
			    <?php 
			    // Simpan halaman saat ini sebagai parameter redirect
			    $current_page = basename($_SERVER['PHP_SELF']);
			    $query_string = http_build_query(['redirect' => $current_page]);
			    ?>
			    <a href="<?php echo BASE_URL; ?>login.php?<?php echo $query_string; ?>" class="btn btn-outline-light">Login</a>
			<?php endif; ?>
        </div>
    </div>
</nav>