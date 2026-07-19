<?php
session_start();
require_once "koneksi.php";

// Harus login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = "edit_profile.php";
    header("Location: login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];

$message = "";
$message_type = "";

// Proses simpan
if (isset($_POST['simpan'])) {

    $nama    = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
    $email   = mysqli_real_escape_string($koneksi, trim($_POST['email']));
    $no_hp   = mysqli_real_escape_string($koneksi, trim($_POST['no_hp']));
    $alamat  = mysqli_real_escape_string($koneksi, trim($_POST['alamat']));

    // Cek email sudah dipakai user lain atau belum
    if ($email != "") {

        $cek = mysqli_query($koneksi,"
            SELECT id
            FROM users
            WHERE email='$email'
            AND id<>'$user_id'
        ");

        if(mysqli_num_rows($cek) > 0){

            $message = "Email sudah digunakan oleh pengguna lain.";
            $message_type = "danger";

        }else{

            $sql = "
            UPDATE users
            SET
                nama='$nama',
                email='$email',
                no_hp='$no_hp',
                alamat='$alamat'
            WHERE id='$user_id'
            ";

            if(mysqli_query($koneksi,$sql)){

                $_SESSION['nama'] = $nama;

                $message = "Profil berhasil diperbarui.";
                $message_type = "success";

            }else{

                $message = "Gagal menyimpan profil.";
                $message_type = "danger";

            }

        }

    }else{

        $sql = "
        UPDATE users
        SET
            nama='$nama',
            email='',
            no_hp='$no_hp',
            alamat='$alamat'
        WHERE id='$user_id'
        ";

        if(mysqli_query($koneksi,$sql)){

            $_SESSION['nama'] = $nama;

            $message = "Profil berhasil diperbarui.";
            $message_type = "success";

        }else{

            $message = "Gagal menyimpan profil.";
            $message_type = "danger";

        }

    }

}

// Ambil data terbaru
$query = mysqli_query($koneksi,"
SELECT *
FROM users
WHERE id='$user_id'
");

$user = mysqli_fetch_assoc($query);

$page_title = "Edit Profil";
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
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-header bg-warning">
                            <h4 class="mb-0">
                                <i class="fas fa-user-edit me-2"></i>
                                Edit Profil
                            </h4>
                        </div>
                        <div class="card-body">
                            <?php if($message!=""){ ?>
                            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show">
                                <?php echo $message; ?>
                                <button class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php } ?>
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Nama
                                    </label>
                                    <input type="text" name="nama" class="form-control" required value=" <?php echo htmlspecialchars($user['nama']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Username
                                    </label>
                                    <input type="text" class="form-control" readonly value="<?php echo htmlspecialchars($user['username']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Email
                                    </label>
                                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Nomor HP
                                    </label>
                                    <input type="text" name="no_hp" class="form-control" value="<?php echo htmlspecialchars($user['no_hp']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Alamat
                                    </label>
                                    <textarea name="alamat" class="form-control" rows="4">
                                        <?php echo htmlspecialchars($user['alamat']); ?>
                                    </textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" name="simpan" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i>
                                        Simpan
                                    </button>
                                    <a href="profile.php" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include "includes/footer.php"; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>