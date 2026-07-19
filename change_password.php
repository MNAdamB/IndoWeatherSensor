<?php
session_start();
require_once "koneksi.php";

// Harus login
if(!isset($_SESSION['user_id'])){
    $_SESSION['redirect_after_login'] = "change_password.php";
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$error = "";
$success = "";

// Ambil password user
$query = mysqli_query($koneksi,"
SELECT password
FROM users
WHERE id='$user_id'
");

$user = mysqli_fetch_assoc($query);

// Proses ganti password
if(isset($_POST['simpan'])){

    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi    = $_POST['konfirmasi'];

    if(empty($password_lama) ||
       empty($password_baru) ||
       empty($konfirmasi)){

        $error = "Semua field wajib diisi.";

    }

    elseif(!password_verify($password_lama,$user['password'])){

        $error = "Password lama tidak sesuai.";

    }

    elseif(strlen($password_baru) < 6){

        $error = "Password baru minimal 6 karakter.";

    }

    elseif($password_baru != $konfirmasi){

        $error = "Konfirmasi password tidak sama.";

    }

    else{

        $hash = password_hash(
            $password_baru,
            PASSWORD_DEFAULT
        );

        mysqli_query($koneksi,"
        UPDATE users
        SET password='$hash'
        WHERE id='$user_id'
        ");

        header("Location: profile.php?password=success");
        exit;

    }

}

$page_title = "Ganti Password";
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

        <div class="col-lg-6">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <h4>
                        <i class="fas fa-key me-2"></i>
                        Ganti Password
                    </h4>

                </div>

                <div class="card-body">

                    <?php if($error!=""){ ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                    <?php } ?>

                    <?php if($success!=""){ ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                    </div>
                    <?php } ?>

                    <form method="POST">

                        <div class="mb-3">

                            <label>Password Lama</label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    name="password_lama"
                                    id="password_lama"
                                    class="form-control"
                                    required>

                                <button
                                    class="btn btn-outline-secondary"
                                    type="button"
                                    onclick="togglePassword('password_lama',this)">

                                    <i class="fas fa-eye"></i>

                                </button>

                            </div>

                        </div>

                        <div class="mb-3">

                            <label>Password Baru</label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    name="password_baru"
                                    id="password_baru"
                                    class="form-control"
                                    required>

                                <button
                                    class="btn btn-outline-secondary"
                                    type="button"
                                    onclick="togglePassword('password_baru',this)">

                                    <i class="fas fa-eye"></i>

                                </button>

                            </div>

                        </div>

                        <div class="mb-4">

                            <label>Konfirmasi Password Baru</label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    name="konfirmasi"
                                    id="konfirmasi"
                                    class="form-control"
                                    required>

                                <button
                                    class="btn btn-outline-secondary"
                                    type="button"
                                    onclick="togglePassword('konfirmasi',this)">

                                    <i class="fas fa-eye"></i>

                                </button>

                            </div>

                        </div>

                        <button
                            type="submit"
                            name="simpan"
                            class="btn btn-primary">

                            <i class="fas fa-save me-2"></i>
                            Simpan Password

                        </button>

                        <a
                            href="profile.php"
                            class="btn btn-secondary">

                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "includes/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

function togglePassword(id,button){

    let input=document.getElementById(id);

    let icon=button.querySelector("i");

    if(input.type==="password"){

        input.type="text";

        icon.classList.remove("fa-eye");

        icon.classList.add("fa-eye-slash");

    }else{

        input.type="password";

        icon.classList.remove("fa-eye-slash");

        icon.classList.add("fa-eye");

    }

}

</script>

</body>
</html>