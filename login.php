<?php
session_start();
require_once 'koneksi.php';

$error = '';
$success = '';

// Simpan halaman asal hanya sekali
if(isset($_GET['redirect']) && $_GET['redirect'] != ""){
    $_SESSION['redirect_after_login'] = $_GET['redirect'];
}

// Ambil halaman tujuan
$previous_page = $_SESSION['redirect_after_login'] ?? "index.php";

if ($_POST) {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";

    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {

        if (password_verify($password, $row['password'])) {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['nama'] = $row['nama'];

            header("Location: ".$previous_page);

            unset($_SESSION['redirect_after_login']);

            exit;

        } else {

            $error = "Password salah!";

        }

    } else {

        $error = "Username tidak ditemukan!";

    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IndoWeatherSensor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .login-container { min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .login-card { box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: none; }
    </style>
</head>
<body class="login-container d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card login-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-cloud-sun fa-3x text-primary mb-3"></i>
                            <h2 class="fw-bold text-primary">IndoWeatherSensor</h2>
                            <p class="text-muted">Silahkan login untuk melanjutkan</p>
                        </div>

                        <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-4">
                                <label class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                                <i class="fas fa-sign-in-alt me-2"></i>Masuk
                            </button>
                        </form>

                        <div class="mt-4 text-center">
                            <small class="text-muted">Belum Punya akun?, silakan daftar di sini</small><br>
                            <a href="register.php" class="btn btn-outline-primary btn-sm mt-2">
                                <i class="fas fa-user-plus me-1"></i>Daftar
                            </a>
                            <a href="<?php echo htmlspecialchars($previous_page); ?>"class="btn btn-secondary btn-sm mt-2 w-100">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>