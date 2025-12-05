<?php
// Panel de administración
?>
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-white mb-2">Panel de Administración</h1>
        <p class="text-gray-400">Gestiona usuarios y publicaciones del blog</p>
    </div>

    <!-- Tarjetas de opciones -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <!-- Tarjeta de Usuarios -->
        <a href="<?= url('admin/users') ?>" class="block bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-xl border-2 border-gray-700 p-8 hover:shadow-2xl hover:scale-105 hover:border-indigo-500 transition-all transform duration-300">
            <div class="flex flex-col items-center text-center">
                <div class="bg-indigo-600 rounded-full p-5 mb-5 shadow-lg">
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-3">Opciones de Usuario</h2>
                <p class="text-gray-400 text-sm">Gestiona los usuarios del sistema: crear, editar y eliminar cuentas</p>
            </div>
        </a>

        <!-- Tarjeta de Posts -->
        <a href="<?= url('admin/posts') ?>" class="block bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-xl border-2 border-gray-700 p-8 hover:shadow-2xl hover:scale-105 hover:border-purple-500 transition-all transform duration-300">
            <div class="flex flex-col items-center text-center">
                <div class="bg-purple-600 rounded-full p-5 mb-5 shadow-lg">
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"></path>
                        <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-3">Opciones de Posts</h2>
                <p class="text-gray-400 text-sm">Administra las publicaciones: editar y eliminar cualquier post</p>
            </div>
        </a>
    </div>
</div>
