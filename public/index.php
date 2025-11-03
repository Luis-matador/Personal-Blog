<?php
/**
 * Punto de entrada único de la aplicación
 * Inicializa la configuración y el enrutador
 * Define las rutas disponibles
 * Ejecuta el controlador correspondiente a la ruta actual
 */

// Mostrar errores en desarrollo (puedes quitar esto en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión
session_start();

// Cargar configuración y dependencias
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/Router.php';
require_once __DIR__ . '/../controllers/PostController.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/AdminController.php';

// Instanciar el router
$router = new Router();

// Rutas de posts
$router->add('GET', '/', [new PostController, 'index']);
$router->add('GET', '/search', [new PostController, 'search']);
$router->add('GET', '/post/create', [new PostController, 'create']);
$router->add('POST', '/post/store', [new PostController, 'store']);
$router->add('GET', '/post/{id}', [new PostController, 'view']);
$router->add('GET', '/post/{id}/edit', [new PostController, 'edit']);
$router->add('POST', '/post/{id}/update', [new PostController, 'update']);
$router->add('POST', '/post/{id}/delete', [new PostController, 'delete']);

// Rutas de autenticación (puedes añadir más según avances)
$router->add('GET', '/login', [new UserController, 'login']);
$router->add('POST', '/login', [new UserController, 'authenticate']);
$router->add('GET', '/register', [new UserController, 'register']);
$router->add('POST', '/register', [new UserController, 'store']);
$router->add('GET', '/logout', [new UserController, 'logout']);

// Rutas de administración
$router->add('GET', '/admin', [new AdminController, 'index']);
$router->add('POST', '/admin', [new AdminController, 'index']);
$router->add('GET', '/admin/logout', [new AdminController, 'logout']);
$router->add('GET', '/admin/users', [new AdminController, 'users']);
$router->add('POST', '/admin/users/create', [new UserController, 'adminCreate']);
$router->add('POST', '/admin/users/{id}/update', [new UserController, 'adminUpdate']);
$router->add('POST', '/admin/users/{id}/delete', [new UserController, 'adminDelete']);
$router->add('POST', '/admin/users/{id}/change-password', [new UserController, 'adminChangePassword']);
$router->add('GET', '/admin/posts', [new AdminController, 'posts']);
$router->add('POST', '/admin/posts/{id}/delete', [new PostController, 'adminDelete']);

// Ejecutar el router
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

