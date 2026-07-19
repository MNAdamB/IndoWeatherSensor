<?php
session_start();

require_once "../koneksi.php";
require_once "cek_login.php";

// Pastikan hanya admin
if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: inquiry.php");
    exit;
}

$id = (int)$_GET['id'];

// Hapus inquiry
$stmt = mysqli_prepare($koneksi, "DELETE FROM konfigurasi WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if(mysqli_stmt_execute($stmt)){
    header("Location: inquiry.php?hapus=sukses");
}else{
    header("Location: inquiry.php?hapus=gagal");
}

exit;