<?php
session_start();

require_once "koneksi.php";

if(isset($_GET['success'])){
    $message = "Inquiry berhasil dikirim.";
    $message_type = "success";
}

// PHP Variable
$page_title = "Weather Station Configurator";

// Ambil semua produk aktif
$queryProduk = mysqli_query($koneksi,"
SELECT *
FROM produk
WHERE status='aktif'
ORDER BY kategori_id, urutan
");

// Function hitung total harga
function calculateTotal($koneksi, $selected_produk){
    $total = 0;
    if(empty($selected_produk)){
        return 0;
    }
    foreach($selected_produk as $id){
        $id = (int)$id;
        $q = mysqli_query($koneksi,"
        SELECT harga
        FROM produk
        WHERE id='$id'
        ");
        if($row = mysqli_fetch_assoc($q)){
            $total += $row['harga'];
        }
    }
    return $total;
}

// Proses POST dari form
if(isset($_POST['preview'])){

    $selected_produk = $_POST['produk'] ?? [];

    if(empty($selected_produk)){

        $message = "Pilih minimal 1 produk!";
        $message_type = "warning";

    }else{

        $total_price = calculateTotal($koneksi, $selected_produk);

    }

}

if(isset($_POST['simpan'])){

    if(!isset($_SESSION['user_id'])){

        $_SESSION['redirect_after_login'] = "ws_config.php";

        header("Location: login.php");

        exit;

    }

    $user_id = $_SESSION['user_id'];

    $selected_produk = $_POST['produk'] ?? [];
    if(empty($selected_produk)){

        $message = "Pilih minimal 1 produk.";
        $message_type = "warning";
    }

    $total_harga = calculateTotal(
        $koneksi,
        $selected_produk
    );

    $sql = "INSERT INTO konfigurasi
    (
        user_id,
        total_harga,
        status
    )
    VALUES
    (
        '$user_id',
        '$total_harga',
        'inquiry'
    )
    ";

    if(!mysqli_query($koneksi,$sql)){
        die("INSERT konfigurasi gagal : ".mysqli_error($koneksi));
    }

    $konfigurasi_id = mysqli_insert_id($koneksi);

    foreach($selected_produk as $produk_id){

        $produk_id = (int)$produk_id;

        $q = mysqli_query($koneksi,"
            SELECT harga
            FROM produk
            WHERE id='$produk_id'
        ");

        $row = mysqli_fetch_assoc($q);

        $harga = $row['harga'];

        $detail_sql = "
            INSERT INTO konfigurasi_detail
            (
                konfigurasi_id,
                produk_id,
                harga
            )
            VALUES
            (
                '$konfigurasi_id',
                '$produk_id',
                '$harga'
            )
        ";

        if(!mysqli_query($koneksi, $detail_sql)){
            die("INSERT detail gagal : ".mysqli_error($koneksi));
        }
        
    }

    header("Location: ws_config.php?success=1");
    exit;
}

// Ambil config yang tersimpan
$selected_produk = $selected_produk ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .produk-item {
            transition: all 0.3s ease;
            cursor: pointer;
            background: #fff;
        }

        .produk-item:hover {
            background: linear-gradient(135deg, #f8f9ff 0%, #e3f2fd 100%);
            border-color: #007bff;
            box-shadow: 0 4px 12px rgba(0,123,255,0.15);
            transform: translateY(-2px);
        }

        .form-switch-lg .form-check-input {
            width: 2.5em;
            height: 1.5em;
        }

        .hover-sensor:hover .form-check-input {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }
        .floating-alert {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
            min-width: 350px;
            max-width: 450px;
            animation: slideInRight 0.4s ease-out;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .floating-alert .btn-close {
            filter: drop-shadow(0 1px 2px rgba(0,0,0,0.3));
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="bg-light py-2">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php" class="fw-bold text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" class="fw-bold text-decoration-none"><?php echo $page_title; ?></li>
            </ol>
        </div>
    </nav>

    <div class="container my-5">
        <?php if (isset($message)): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if(isset($_POST['preview']) && !empty($selected_produk)): ?>
        <!-- Modal Konfirmasi Otomatis -->
        <div class="modal fade" id="configModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Konfirmasi Konfigurasi</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Produk yang dipilih:</h6>
                        <ul class="list-group mb-3" id="modalProductList">
                            <!-- Diisi via JS -->
                        </ul>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center fs-5 fw-bold">
                            <span>Total Estimasi:</span>
                            <span id="modalTotalPrice" class="text-success">Rp 0</span>
                        </div>
                    </div>
                    <div class="modal-footer">                        
                        <button type="submit"
                            class="btn btn-success"
                            name="simpan"
                            form="configForm">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Inquiry
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal/Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4><i class="fas fa-cogs me-2"></i>Pilih Sensor & Aksesoris</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="configForm">
                            <?php 
                            while($produk = mysqli_fetch_assoc($queryProduk)){
                                $produk_id = $produk['id'];
                                $checked = in_array($produk_id, $selected_produk) ? 'checked' : '';
                            ?>
                            <div class="produk-item mb-3 p-3 border rounded shadow-sm hover-sensor position-relative">
                                <div class="d-flex justify-content-between align-items-start">
                                    <!-- Nama & Harga (KIRI - 90% width) -->
                                    <div class="flex-grow-1 pe-3">
                                        <div class="fw-bold lh-sm mb-1"><?= htmlspecialchars($produk['nama_produk']); ?></div>
                                        <div class="h6 text-success fw-semibold mb-0">
                                            Rp <?= number_format($produk['harga'],0,',','.'); ?>
                                        </div>
                                    </div>
            
                                    <!-- Checkbox Toggle (KANAN - Rata kanan) -->
                                    <div class="form-check form-switch ms-auto">
                                        <input class="form-check-input form-switch-lg" 
                                            type="checkbox" 
                                            name="produk[]" 
                                            value="<?= $produk_id; ?>" 
                                            id="produk_<?= $produk_id; ?>" 
                                            <?= $checked; ?>
                                            style="transform: scale(1.3);">
                                        <label class="form-check-label visually-hidden" for="produk_<?= $produk_id; ?>">
                                            Toggle <?= htmlspecialchars($produk['nama_produk']); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
    
                            <button
                                type="submit"
                                id="submitConfigBtn"
                                class="btn btn-primary btn-lg w-100 mt-4"
                                name="preview">
                                <i class="fas fa-calculator me-2"></i>
                                Kirim Inquiry
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow sticky-top" style="top: 300px;">
                    <div class="card-header bg-success text-white">
                        <h5>Ringkasan</h5>
                    </div>
                    <div class="card-body">
                        <div id="summary">
                            <p class="text-muted">Belum ada item dipilih</p>
                        </div>
                        <hr>
                        <div class="h5 fw-bold text-success" id="total-price">Rp 0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Global variables
    let currentConfig = [];

    // DOM Ready - INISIALISASI SETELAH SEMUA ELEMENT LOADED
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - Init summary & modal');
        initSummary();
        initModal();
    });

    // *** INIT SUMMARY - EVENT LISTENER UNTUK SEMUA CHECKBOX ***
    function initSummary() {
        // Cari SEMUA checkbox di halaman (termasuk yang baru dibuat)
        const allCheckboxes = document.querySelectorAll('input[type="checkbox"][name="produk[]"]');
        console.log('Found checkboxes:', allCheckboxes.length);
    
        allCheckboxes.forEach(checkbox => {
            // Hapus event listener lama (jika ada)
            checkbox.removeEventListener('change', handleCheckboxChange);
            // Tambah event listener baru
            checkbox.addEventListener('change', handleCheckboxChange);
        });
    
        // Update summary awal
        updateSummary();
    }

    // *** HANDLER UNTUK CHECKBOX CHANGE ***
    function handleCheckboxChange() {
        console.log('Checkbox changed - updating summary');
        updateSummary();
        updateModalContent();
    }

    // Update summary panel - FIXED VERSION
    function updateSummary() {
        let total = 0;
        let items = [];
        currentConfig = [];
    
        // Cari SEMUA checkbox yang checked
        const checkedBoxes = document.querySelectorAll('input[type="checkbox"][name="produk[]"]:checked');
    
        checkedBoxes.forEach(cb => {
            const produkId = cb.value;
            const label = cb.closest('.produk-item')?.querySelector('.fw-bold')?.textContent || 
                        cb.nextElementSibling?.textContent || 'Unknown';
        
            // Extract price dari label atau data attribute
            const priceElement = cb.closest('.produk-item')?.querySelector('.text-success');
            const priceMatch = priceElement ? 
                priceElement.textContent.match(/Rp\s*([\d.]+)/i) : 
                label.match(/Rp\s*([\d.]+)/i);
        
            if (priceMatch) {
                const price = parseInt(priceMatch[1].replace(/\./g, ''));
                total += price;
                items.push(label.split('\n')[0].trim());
                currentConfig.push(produkId);
            }
        });
    
        // Update UI
        const summaryEl = document.getElementById('summary');
        const totalPriceEl = document.getElementById('total-price');
    
        if (summaryEl) {
            summaryEl.innerHTML = items.length ? 
                items.map(item => `<div class="mb-1 fw-medium">${item}</div>`).join('') : 
                '<p class="text-muted mb-0">Belum ada item dipilih</p>';
        }
    
        if (totalPriceEl) {
            totalPriceEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    
        console.log('Summary updated:', items.length, 'items, Total: Rp', total.toLocaleString('id-ID'));
    }

    // Update modal content
    function updateModalContent() {
        if (currentConfig.length === 0) return;
    
        let modalList = '';
        let modalTotal = 0;
    
        currentConfig.forEach(produkId => {
            const checkbox = document.querySelector(`input[value="${produkId}"]`);
            if (checkbox && checkbox.checked) {
                const produkItem = checkbox.closest('.produk-item');
                const productName = produkItem?.querySelector('.fw-bold')?.textContent || 'Unknown';
                const priceElement = produkItem?.querySelector('.text-success');
                const priceMatch = priceElement ? 
                    priceElement.textContent.match(/Rp\s*([\d.]+)/i) : null;
            
                const price = priceMatch ? parseInt(priceMatch[1].replace(/\./g, '')) : 0;
                modalTotal += price;
            
                modalList += `
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                        <span class="fw-medium">${productName}</span>
                        <span class="badge bg-success fs-6">Rp ${price.toLocaleString('id-ID')}</span>
                    </li>
                `;
            }
        });
    
        const modalListEl = document.getElementById('modalProductList');
        const modalTotalEl = document.getElementById('modalTotalPrice');
    
        if (modalListEl) modalListEl.innerHTML = modalList || '<li class="list-group-item text-center text-muted py-3">Tidak ada produk</li>';
        if (modalTotalEl) modalTotalEl.textContent = 'Rp ' + modalTotal.toLocaleString('id-ID');
    }

    // Initialize modal
    function initModal() {
        const modalElement = document.getElementById('configModal');

        if(modalElement){

            updateModalContent();

            const configModal = new bootstrap.Modal(modalElement,{
                backdrop:'static',
                keyboard:false
            });

            configModal.show();
        }
    }
    
    // Validasi form submit sebelum POST
    document.addEventListener('DOMContentLoaded', function() {
        const submitBtn = document.getElementById('submitConfigBtn');
        if (submitBtn) {
            submitBtn.addEventListener('click', function(e) {
                const checkedCount = document.querySelectorAll('input[type="checkbox"][name="produk[]"]:checked').length;
            
                if (checkedCount === 0) {
                    e.preventDefault();
                    e.stopPropagation();
                    showEmptySelectionAlert();
                    return false;
                }
            
                // Normal submit
                document.getElementById('configForm').submit();
            });
        }
    });

    // Floating Alert - No Selection
    function showEmptySelectionAlert() {
        // Remove existing alerts
        document.querySelectorAll('.empty-alert').forEach(el => el.remove());
    
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-warning shadow-lg empty-alert';
        alertDiv.style.cssText = `
            position: fixed;
            top: 120px;
            right: 20px;
            z-index: 99999;
            min-width: 380px;
            max-width: 420px;
            animation: slideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border: none;
            border-radius: 15px;
        `;
    
        alertDiv.innerHTML = `
            <div class="d-flex align-items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle fs-3 text-warning mt-1 me-3"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="fw-bold fs-5 mb-1">Pilih Produk Terlebih Dahulu!</div>
                    <div class="text-muted small mb-2">
                        Minimal 1 produk harus dipilih untuk submit konfigurasi.
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-light rounded-circle p-1">
                            <i class="fas fa-toggle-on text-success fs-6"></i>
                        </div>
                        <small class="text-muted">Klik toggle switch kanan produk</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white ms-2 flex-shrink-0" data-bs-dismiss="alert"></button>
            </div>
        `;
    
        document.body.appendChild(alertDiv);
    
        // Auto dismiss setelah 7 detik
        setTimeout(() => {
            if (alertDiv.parentNode) {
                const bsAlert = new bootstrap.Alert(alertDiv);
                bsAlert.close();
            }
        }, 7000);
    }
    </script>
    
</body>
</html>