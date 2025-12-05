<?php
// Error 403
?>
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="text-center">
        <!-- Icono de candado -->
        <div class="mb-8 flex justify-center">
            <div class="bg-red-900/20 p-8 rounded-full">
                <svg class="w-24 h-24 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
        </div>

        <!-- Título y mensaje -->
        <h1 class="text-6xl font-extrabold text-red-500 mb-4">403</h1>
        <h2 class="text-3xl font-bold text-white mb-4">Acceso Denegado</h2>
        <p class="text-xl text-gray-400 mb-8 max-w-md mx-auto">
            <?= htmlspecialchars($errorMessage ?? 'No tienes permisos para acceder a esta sección.') ?>
        </p>

        <!-- Botón volver -->
        <a href="<?= url() ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al inicio
        </a>
    </div>
</div>
