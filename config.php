<?php

// ======================================================
// Konfigurasi Website IndoWeatherSensor
// ======================================================

// URL dasar website
define("BASE_URL", "/web_lanjutan/indo_weather/");

// Nama Website
define("SITE_NAME", "IndoWeatherSensor");


// ======================================================
// Helper Function
// ======================================================

// Membuat URL lengkap
function base_url($path = "")
{
    return BASE_URL . ltrim($path, "/");
}

// Redirect halaman
function redirect($path = "")
{
    header("Location: " . base_url($path));
    exit;
}