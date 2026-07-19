<?php
session_start();
require_once "koneksi.php";

session_destroy();

// Hapus cookie jika ada
setcookie('visit_count', '', time() - 3600, "/");

// Redirect ke halaman utama
redirect("index.php");
?>