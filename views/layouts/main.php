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
    <link href="/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-gray-800 shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-white">Mi Blog Personal</a>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="/" class="hover:text-gray-400">Inicio</a></li>
                    <li><a href="/login" class="hover:text-gray-400">Login</a></li>
                    <li><a href="/register" class="hover:text-gray-400">Registro</a></li>
                </ul>
            </nav>
        </div>
    </header>

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

