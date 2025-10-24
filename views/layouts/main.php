<?php
/**
 * Plantilla principal que contiene la estructura HTML base
 * Incluye header, navegación, footer y un espacio para el contenido
 * Las vistas específicas se cargarán dentro de esta plantilla
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Mi Blog' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/Personal-Blog/public/css/style.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/Personal-Blog/public/js/alerts.js"></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-gray-800 shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/Personal-Blog/public/" class="text-2xl font-bold text-white">Mi Blog Personal</a>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="/Personal-Blog/public/" class="hover:text-gray-400">Inicio</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="/Personal-Blog/public/post/create" class="hover:text-gray-400">Crear post</a></li>
                        <li><a href="/Personal-Blog/public/logout" class="hover:text-gray-400">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/Personal-Blog/public/login" class="hover:text-gray-400">Login</a></li>
                        <li><a href="/Personal-Blog/public/register" class="hover:text-gray-400">Registro</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

        <!-- Mensajes flash con SweetAlert2 -->
        <?php require_once __DIR__ . '/../../includes/functions.php'; ?>
                <?php if ($msg = getFlashMessage('success')): ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showAppAlert('success', <?= json_encode($msg) ?>);
                        });
                    </script>
                <?php endif; ?>
    <!-- Contenido principal -->
    <main class="flex-1 container mx-auto px-4 py-8">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-400 py-4 mt-8">
        <div class="container mx-auto px-4 text-center">
            &copy; <?= date('Y') ?> Mi Blog Personal. Todos los derechos reservados.
        </div>
    </footer>
</body>
</html>

