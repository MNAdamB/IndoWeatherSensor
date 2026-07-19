<?php
session_start();
require_once "koneksi.php";

// Harus login
if(!isset($_SESSION['user_id'])){
    $_SESSION['redirect_after_login'] = "profile.php";
    header("Location: login.php");
    exit;
}

// Ambil data user
$user_id = $_SESSION['user_id'];

$query = mysqli_query($koneksi,"
SELECT *
FROM users
WHERE id='$user_id'
");

$user = mysqli_fetch_assoc($query);

$page_title = "Profil Saya";
$password_success = isset($_GET['password']) && $_GET['password']=="success";
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
                    <h4><i class="fas fa-user-circle me-2"></i>Profil Saya</h4>
                </div>
                <div class="card-body">
                    <?php if($password_success){ ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>
                        Password berhasil diubah.
                        <button 
                            type="button" class="btn-close" data-bs-dismiss="alert">
                        </button>
                    </div>
                    <?php } ?>
                    <table class="table">
                        <tr>
                            <th width="180">Nama</th>
                            <td><?php echo htmlspecialchars($user['nama']); ?></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                       </tr>
                        <tr>
                            <th>No. HP</th>
                            <td><?php echo htmlspecialchars($user['no_hp']); ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?php echo nl2br(htmlspecialchars($user['alamat'])); ?></td>
                        </tr>
                    </table>
            
                    <div class="mt-3">
                        <a href="edit_profile.php" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Edit Profil
                        </a>
                        <a href="change_password.php" class="btn btn-primary">
                            <i class="fas fa-key me-2"></i>
                            Ganti Password
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <?php include "includes/footer.php"; ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>