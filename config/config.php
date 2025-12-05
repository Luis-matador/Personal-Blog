<?php
// Configuración global

$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$baseUrl = rtrim($scriptName, '/');
define('BASE_URL', $baseUrl);

// Función auxiliar para generar URLs
function url($path = '') {
    $path = ltrim($path, '/');
    return BASE_URL . ($path ? '/' . $path : '');
}

// Función para assets (CSS, JS, imágenes)
function asset($path) {
    $path = ltrim($path, '/');
    return BASE_URL . '/' . $path;
}
