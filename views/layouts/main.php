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
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= asset('js/alerts.js') ?>"></script>
    <script src="<?= asset('js/validation.js') ?>"></script>
    <style>
        /* Asegurar que el header siempre sea visible */
        header {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Mejorar contraste de colores */
        body {
            background: linear-gradient(to bottom, #1a202c 0%, #2d3748 100%) !important;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col">
    <!-- Header Moderno -->
    <header class="bg-gradient-to-r from-purple-900 via-indigo-900 to-blue-900 shadow-2xl sticky top-0 z-[100] border-b border-purple-700">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex justify-between items-center gap-4">
                <!-- Logo -->
                <a href="<?= url() ?>" class="flex items-center space-x-3 group flex-shrink-0">
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-2 rounded-lg shadow-lg transform group-hover:scale-110 transition">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="text-xl lg:text-2xl font-extrabold text-white tracking-tight whitespace-nowrap">Mi Blog Personal</span>
                </a>
                
                <!-- Navegación Desktop -->
                <nav class="hidden md:flex items-center space-x-3 lg:space-x-4">
                    <a href="<?= url() ?>" class="px-3 lg:px-4 py-2 rounded-lg text-gray-200 hover:bg-white/10 hover:text-white transition-all duration-200 font-medium whitespace-nowrap">
                        <span class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Inicio</span>
                        </span>
                    </a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="<?= url('post/create') ?>" class="px-3 lg:px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-500 hover:to-purple-500 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-[1.02] whitespace-nowrap">
                            <span class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Crear post</span>
                            </span>
                        </a>
                        <a href="<?= url('admin') ?>" class="px-3 lg:px-4 py-2 rounded-lg bg-gradient-to-r from-purple-600 to-pink-600 text-white hover:from-purple-500 hover:to-pink-500 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-[1.02] whitespace-nowrap">
                            <span class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Admin</span>
                            </span>
                        </a>
                        
                        <!-- Usuario logueado -->
                        <div class="flex items-center space-x-3 pl-3 ml-2 border-l border-indigo-700">
                            <div class="flex items-center space-x-2 px-3 py-2 bg-white/10 rounded-lg">
                                <div class="bg-gradient-to-br from-indigo-400 to-purple-500 p-1.5 rounded-full">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <span class="text-sm font-medium text-white block"><?= htmlspecialchars($_SESSION['username'] ?? 'Usuario') ?></span>
                                    <?php
                                    require_once __DIR__ . '/../../models/User.php';
                                    $postCount = User::getPostCount($_SESSION['user_id']);
                                    ?>
                                    <span class="text-xs text-gray-300"><?= $postCount ?> <?= $postCount == 1 ? 'post' : 'posts' ?></span>
                                </div>
                            </div>
                            <a href="<?= url('logout') ?>" class="px-4 py-2 rounded-lg text-gray-300 hover:bg-red-600/20 hover:text-red-400 transition-all duration-200 font-medium">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Salir</span>
                                </span>
                            </a>
                        </div>
                    <?php else: ?>
                        <a href="<?= url('login') ?>" class="px-4 py-2 rounded-lg text-gray-200 hover:bg-white/10 hover:text-white transition-all duration-200 font-medium">
                            Login
                        </a>
                        <a href="<?= url('register') ?>" class="px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-500 hover:to-purple-500 transition-all duration-200 font-semibold shadow-lg">
                            Registro
                        </a>
                    <?php endif; ?>
                </nav>
                
                <!-- Menú móvil hamburguesa -->
                <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg hover:bg-white/10 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Menú móvil desplegable -->
            <div id="mobile-menu" class="md:hidden hidden mt-4 pb-4 space-y-2">
                <a href="<?= url() ?>" class="block px-4 py-2 rounded-lg text-gray-200 hover:bg-white/10 hover:text-white transition">Inicio</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="px-4 py-2 flex items-center justify-between text-sm text-gray-300 bg-white/5 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium"><?= htmlspecialchars($_SESSION['username'] ?? 'Usuario') ?></span>
                        </div>
                        <?php
                        require_once __DIR__ . '/../../models/User.php';
                        $postCount = User::getPostCount($_SESSION['user_id']);
                        ?>
                        <span class="text-xs bg-indigo-600 px-2 py-1 rounded-full"><?= $postCount ?> <?= $postCount == 1 ? 'post' : 'posts' ?></span>
                    </div>
                    <a href="<?= url('post/create') ?>" class="block px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 transition font-semibold">Crear post</a>
                    <a href="<?= url('admin') ?>" class="block px-4 py-2 rounded-lg bg-purple-600 text-white hover:bg-purple-500 transition font-semibold">Administrador</a>
                    <a href="<?= url('logout') ?>" class="block px-4 py-2 rounded-lg text-red-400 hover:bg-red-600/20 transition">Salir</a>
                <?php else: ?>
                    <a href="<?= url('login') ?>" class="block px-4 py-2 rounded-lg text-gray-200 hover:bg-white/10 transition">Login</a>
                    <a href="<?= url('register') ?>" class="block px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 transition font-semibold">Registro</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <script>
    // Toggle menú móvil
    document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
    </script>

    <!-- Mensajes flash con SweetAlert2 -->
    <?php 
    require_once __DIR__ . '/../../includes/functions.php';
    if ($msg = getFlashMessage('success')): 
    ?>
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

