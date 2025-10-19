<?php
/**
 * Configuración de la conexión a la base de datos
 * Define las constantes de conexión: DB_HOST, DB_NAME, DB_USER, DB_PASS
 * Crea y expone una instancia PDO para usar en toda la aplicación
 */

// Configura estos valores según tu entorno
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_NAME')) define('DB_NAME', 'personal_blog');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', '');

// Crear la instancia PDO
try {
    $db = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS
    );
    // Opciones recomendadas para PDO
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error de conexión a la base de datos: ' . $e->getMessage());
}