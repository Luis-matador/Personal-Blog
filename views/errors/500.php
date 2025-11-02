<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 500 - Error del Servidor</title>
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center">
    <div class="text-center px-4">
        <!-- Icono de error -->
        <svg class="w-32 h-32 mx-auto mb-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        
        <h1 class="text-6xl font-extrabold text-red-500 mb-4">500</h1>
        <h2 class="text-3xl font-bold text-white mb-4">Error del Servidor</h2>
        <p class="text-gray-400 text-lg mb-8 max-w-md mx-auto">
            Lo sentimos, algo salió mal en nuestro servidor. Estamos trabajando para solucionarlo.
        </p>
        
        <?php if (isset($errorMessage) && !empty($errorMessage)): ?>
            <div class="bg-red-900/30 border border-red-700 rounded-lg p-4 mb-8 max-w-2xl mx-auto">
                <p class="text-red-300 text-sm font-mono break-words">
                    <?= htmlspecialchars($errorMessage) ?>
                </p>
            </div>
        <?php endif; ?>
        
        <div class="flex gap-4 justify-center">
            <a href="javascript:history.back()" class="px-6 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition font-semibold">
                ← Volver atrás
            </a>
            <a href="<?= url() ?>" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                Ir al inicio
            </a>
        </div>
    </div>
</body>
</html>
