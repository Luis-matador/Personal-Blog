<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>404 - Página no encontrada</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center">
    <div class="text-center px-4">
        <div class="mb-8">
            <svg class="w-24 h-24 mx-auto text-indigo-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h1 class="text-8xl font-extrabold text-indigo-600 mb-4">404</h1>
            <h2 class="text-3xl font-bold text-white mb-4">Página no encontrada</h2>
            <p class="text-gray-400 text-lg mb-8 max-w-md mx-auto">
                Lo sentimos, la página que buscas no existe o ha sido movida.
            </p>
        </div>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="<?= url() ?>" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-lg transition transform hover:scale-105">
                Volver al inicio
            </a>
            <a href="javascript:history.back()" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-lg transition transform hover:scale-105">
                Volver atrás
            </a>
        </div>
    </div>
</body>
</html>
