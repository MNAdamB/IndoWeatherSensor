<?php
require_once __DIR__ . "/config.php";

$host = "localhost";
$user = "root";
$pass = "";
$db = "indo_weather";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal : " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8");