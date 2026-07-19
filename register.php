<?php
session_start();
require_once "koneksi.php";

$error = "";
$success = "";

$previous_page = $_SESSION['redirect_after_login'] ?? "index.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nama      = trim($_POST['nama']);
    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $no_hp     = trim($_POST['no_hp']);
    $alamat    = trim($_POST['alamat']);
    $password  = $_POST['password'];
    $konfirmasi= $_POST['konfirmasi'];

    // Validasi
    if(
        empty($nama) ||
        empty($username) ||
        empty($email) ||
        empty($no_hp) ||
        empty($password)
    ){
        $error = "Semua field wajib diisi.";
    }

    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $error = "Format email tidak valid.";
    }

    elseif(strlen($password) < 6){
        $error = "Password minimal 6 karakter.";
    }

    elseif($password != $konfirmasi){
        $error = "Konfirmasi password tidak sama.";
    }

    else{

        // cek username
        $cek = mysqli_query($koneksi,"
            SELECT id
            FROM users
            WHERE username='$username'
        ");

        if(mysqli_num_rows($cek)>0){

            $error = "Username sudah digunakan.";

        }else{

            // cek email
            $cek = mysqli_query($koneksi,"
                SELECT id
                FROM users
                WHERE email='$email'
            ");

            if(mysqli_num_rows($cek)>0){

                $error = "Email sudah digunakan.";

            }else{

                $hash = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                mysqli_query($koneksi,"
                    INSERT INTO users
                    (
                        nama,
                        username,
                        email,
                        no_hp,
                        alamat,
                        password,
                        role
                    )
                    VALUES
                    (
                        '$nama',
                        '$username',
                        '$email',
                        '$no_hp',
                        '$alamat',
                        '$hash',
                        'user'
                    )
                ");

                $redirect = "";
                if(isset($_SESSION['redirect_after_login'])){
                    $redirect = "&redirect=" .
                    urlencode($_SESSION['redirect_after_login']);
                }
                
                header("Location: login.php?register=success".$redirect);
                exit;

            }

        }

    }

}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - IndoWeatherSensor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        .register-container{
            min-height:100vh;
            background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);
        }

        .register-card{
            border:none;
            box-shadow:0 15px 35px rgba(0,0,0,.15);
        }
    </style>
</head>

<body class="register-container d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card register-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                            <h2 class="fw-bold text-primary">
                                <i class="fas fa-cloud-sun me-2"></i>IndoWeatherSensor
                            </h2>
                            <p class="text-muted">
                                Registrasi Pengguna Baru
                            </p>
                        </div>
                        <?php if($error): ?>
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                            </div>
                            <?php endif; ?>
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Nama Lengkap
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control" name="nama" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Username
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-at"></i>
                                        </span>
                                        <input type="text" class="form-control" name="username" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Email
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Nomor HP
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input type="text" class="form-control" name="no_hp" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Alamat
                                    </label>
                                    <textarea class="form-control" name="alamat" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">
                                        Konfirmasi Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" name="konfirmasi" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success w-100 py-3 fw-bold">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Daftar
                                </button>
                                <div class="text-center mt-4">
                                    Sudah punya akun?
                                    <a href="login.php<?php
                                    if(isset($_SESSION['redirect_after_login'])){
                                        echo '?redirect=' . urlencode($_SESSION['redirect_after_login']);
                                    }
                                    ?>">
                                        Login disini
                                    </a>
                                    <br>
                                    <a
                                        href="<?= htmlspecialchars($previous_page); ?>"
                                        class="btn btn-secondary w-100 mt-3">
                                        <i class="fas fa-times me-1"></i>
                                        Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>