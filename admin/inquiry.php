<?php
session_start();

require_once "../koneksi.php";
require_once "cek_login.php";

$page_title = "Inquiry Masuk";

$query = mysqli_query($koneksi,"
SELECT
    konfigurasi.*,
    users.nama,
    users.username
FROM konfigurasi
JOIN users
ON konfigurasi.user_id = users.id
ORDER BY konfigurasi.tanggal DESC
");

// Update status
if(isset($_POST['update_status'])){

    $id = (int)$_POST['id'];
    $status = mysqli_real_escape_string($koneksi,$_POST['status']);

    mysqli_query($koneksi,"
        UPDATE konfigurasi
        SET status='$status'
        WHERE id='$id'
    ");

    header("Location: inquiry.php?status=updated");
    exit;
}
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
        <?php include "../includes/navbar.php"; ?>
        <div class="container my-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4>
                        <i class="fas fa-inbox me-2"></i>
                        Inquiry Masuk
                    </h4>
                </div>
                <div class="card-body">
                    <?php if(isset($_GET['hapus']) && $_GET['hapus']=="sukses"): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            Inquiry berhasil dihapus.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($_GET['hapus']) && $_GET['hapus']=="gagal"): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            Inquiry gagal dihapus.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($_GET['status']) && $_GET['status']=="updated"){ ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            Status inquiry berhasil diperbarui.
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php } ?>
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row=mysqli_fetch_assoc($query)){ ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo date("d-m-Y H:i",strtotime($row['tanggal'])); ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($row['nama']); ?></strong><br>
                                    <small><?php echo htmlspecialchars($row['username']); ?></small>
                                </td>
                                <td>
                                    Rp <?php echo number_format($row['total_harga'],0,",","."); ?>
                                </td>
                                <td>
                                    <form method="POST" class="d-flex">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="inquiry"<?= $row['status']=="inquiry"?"selected":""; ?>>
                                            Inquiry
                                        </option>
                                        <option value="diproses"<?= $row['status']=="diproses"?"selected":""; ?>>
                                            Diproses
                                        </option>
                                        <option value="selesai"<?= $row['status']=="selesai"?"selected":""; ?>>
                                            Selesai
                                        </option>
                                        <option value="dibatalkan"<?= $row['status']=="dibatalkan"?"selected":""; ?>>
                                             Dibatalkan
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="../inquiry_detail.php?id=<?php echo $row['id']; ?>"class="btn btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="submit" name="update_status" class="btn btn-success" title="Simpan Status">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        <a href="inquiry_hapus.php?id=<?php echo $row['id']; ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus inquiry ini?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include "../includes/footer.php"; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>