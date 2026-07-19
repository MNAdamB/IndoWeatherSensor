<?php
session_start();
require_once "koneksi.php";

// Harus login
if(!isset($_SESSION['user_id'])){
    $_SESSION['redirect_after_login'] = "inquiry_detail.php";
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role    = $_SESSION['role'];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id <= 0){
    die("ID Inquiry tidak valid.");
}

// ============================
// Ambil data inquiry
// ============================

if($role == "admin"){

    $sql = "
    SELECT
        konfigurasi.*,
        users.nama,
        users.username
    FROM konfigurasi
    JOIN users
        ON konfigurasi.user_id = users.id
    WHERE konfigurasi.id='$id'
    ";

}else{

    $sql = "
    SELECT
        konfigurasi.*,
        users.nama,
        users.username
    FROM konfigurasi
    JOIN users
        ON konfigurasi.user_id = users.id
    WHERE konfigurasi.id='$id'
    AND konfigurasi.user_id='$user_id'
    ";

}

$query = mysqli_query($koneksi,$sql);

if(mysqli_num_rows($query)==0){
    die("Inquiry tidak ditemukan.");
}

$konfigurasi = mysqli_fetch_assoc($query);

// ============================
// Ambil detail produk
// ============================

$queryDetail = mysqli_query($koneksi,"
SELECT
    konfigurasi_detail.*,
    produk.nama_produk
FROM konfigurasi_detail
JOIN produk
ON konfigurasi_detail.produk_id = produk.id
WHERE konfigurasi_id='$id'
ORDER BY konfigurasi_detail.id
");

$page_title = "Detail Inquiry";
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $page_title; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    </head>
    <body>
        <?php include "includes/navbar.php"; ?>
        <div class="container my-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4>
                        <i class="fas fa-file-alt me-2"></i>
                        Detail Inquiry
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="180">ID Inquiry</th>
                                    <td><?php echo $konfigurasi['id']; ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td><?php echo $konfigurasi['tanggal']; ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?php echo ucfirst($konfigurasi['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="180">Nama</th>
                                    <td><?php echo htmlspecialchars($konfigurasi['nama']); ?></td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td><?php echo htmlspecialchars($konfigurasi['username']); ?></td>
                                </tr>
                                <tr>
                                    <th>Total Estimasi</th>
                                    <td class="fw-bold text-success">
                                        Rp <?php echo number_format($konfigurasi['total_harga'],0,",","."); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <h5 class="mb-3">
                        Produk yang Dipilih
                    </h5>
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="60">No</th>
                                <th>Produk</th>
                                <th class="text-end">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; while($detail=mysqli_fetch_assoc($queryDetail)){?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($detail['nama_produk']); ?></td>
                                <td class="text-end">
                                    Rp <?php echo number_format($detail['harga'],0,",","."); ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-end">
                                    Total
                                </th>
                                <th class="text-end text-success">
                                    Rp <?php echo number_format($konfigurasi['total_harga'],0,",","."); ?>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                    <?php
                    if($_SESSION['role'] == "admin"){
                        $back_url = "admin/inquiry.php";
                    }else{
                        $back_url = "my_inquiry.php";
                    }
                    ?>
                    <a href="<?php echo $back_url; ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
        <?php include "includes/footer.php"; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>