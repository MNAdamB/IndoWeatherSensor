<?php
session_start();
require_once "koneksi.php";

// Harus login
if(!isset($_SESSION['user_id'])){
    $_SESSION['redirect_after_login']="my_inquiry.php";
    header("Location: login.php");
    exit;
}

$page_title="My Inquiry";

$user_id=(int)$_SESSION['user_id'];

$query=mysqli_query($koneksi,"
SELECT *
FROM konfigurasi
WHERE user_id='$user_id'
ORDER BY tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0">
        <title><?php echo $page_title; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    </head>
    <body>
        <?php include "includes/navbar.php"; ?>
        <div class="container my-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        My Inquiry
                    </h4>
                </div>
                <div class="card-body">
                    <?php if(mysqli_num_rows($query)==0){ ?>
                    <div class="alert alert-info mb-0">
                        Anda belum memiliki inquiry.
                    </div>
                    <?php }else{ ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="70">ID</th>
                                    <th width="180">Tanggal</th>
                                    <th>Total</th>
                                    <th width="150">Status</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row=mysqli_fetch_assoc($query)){
                                $status=$row['status'];
                                switch($status){
                                case "inquiry": $badge="warning";
                                break;
                                case "diproses": $badge="primary";
                                break;
                                case "selesai": $badge="success";
                                break;
                                default: $badge="danger";
                                }
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo date("d-m-Y H:i", strtotime($row['tanggal'])); ?></td>
                                    <td>Rp <?php echo number_format($row['total_harga'], 0,',','.');?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $badge; ?>">
                                        <?php echo ucfirst($status); ?></span>
                                    </td>
                                    <td>
                                        <a href="inquiry_detail.php?id=<?php echo $row['id']; ?>"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>Detail</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php include "includes/footer.php"; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>