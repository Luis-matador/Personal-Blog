<?php
/**
 * Vista para mostrar lista de posts
 * Muestra título, extracto y fecha de cada post
 * Incluye enlaces para ver posts completos
 */
?>
<h1 class="text-4xl font-extrabold mb-6 text-center">Últimas publicaciones</h1>

<!-- Barra de búsqueda -->
<form action="<?= url('search') ?>" method="GET" class="max-w-2xl mx-auto mb-8">
    <div class="flex gap-2">
        <input type="text" name="q" placeholder="Buscar posts por título, descripción o contenido..." 
               class="flex-1 px-4 py-3 rounded-lg bg-gray-800 text-gray-100 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" 
               value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Buscar
        </button>
    </div>
</form>

<?php if (empty($posts)): ?>
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 text-gray-300 p-8 rounded-2xl shadow-xl text-center max-w-2xl mx-auto border border-gray-700">
        <!-- Ilustración SVG -->
    <svg class="w-30 h-30 mx-auto mb-4 text-indigo-500 custom-size-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
        </svg>
        
        <h2 class="text-2xl font-bold text-white mb-3">¡Bienvenido a tu blog!</h2>
        <p class="text-gray-400 mb-6">Aún no hay publicaciones. ¿Por qué no empiezas creando tu primer post?</p>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="flex justify-center">
                <a href="<?= url('post/create') ?>" class="flex items-center gap-3 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-lg hover:from-indigo-500 hover:to-purple-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                    </svg>
                    <span>Crear mi primer post</span>
                </a>
            </div>
        <?php else: ?>
            <div class="space-y-3">
                <p class="text-gray-400">Inicia sesión para crear tu primera publicación</p>
                <div class="flex gap-3 justify-center">
                    <a href="<?= url('login') ?>" class="px-6 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition font-semibold">
                        Iniciar sesión
                    </a>
                    <a href="<?= url('register') ?>" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                        Registrarse
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="max-w-4xl mx-auto space-y-6 px-4">
        <?php foreach ($posts as $post): ?>
            <a href="<?= url('post/' . htmlspecialchars($post->id)) ?>" class="block transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <article class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-lg overflow-hidden cursor-pointer transform border border-gray-700/50 hover:border-indigo-500/50">
                    <div class="flex flex-col md:flex-row min-h-[200px]">
                    <!-- Imagen -->
                    <div class="md:w-1/3 flex-shrink-0">
                        <?php if (!empty($post->image)): ?>
                            <img src="<?= asset(ltrim($post->image, '/')) ?>"
                                 alt="Imagen del post"
                                 class="w-full h-48 md:h-full object-cover"
                                 loading="lazy">
                        <?php else: ?>
                            <div class="w-full h-48 md:h-full bg-gray-700 flex items-center justify-center">
                                <div class="text-gray-400 text-center">
                                    <svg class="w-12 h-12 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm">Sin imagen</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Contenido -->
                    <div class="md:w-2/3 flex flex-col p-8">
                        <h2 class="text-2xl font-bold text-white leading-tight text-center mb-4 line-clamp-2 overflow-hidden">
                            <?php 
                            $title = htmlspecialchars($post->title);
                            echo mb_strlen($title) > 50 ? mb_substr($title, 0, 50) . '...' : $title;
                            ?>
                        </h2>
                        
                        <div class="flex-1 flex flex-col justify-center items-center space-y-3">
                            <div class="flex items-center text-sm text-gray-400 space-x-2">
                                <svg class="w-4 h-4 flex-shrink-0 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium text-indigo-300"><?= htmlspecialchars($post->author_name) ?></span>
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-400 space-x-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <?php if (!empty($post->updated_at) && $post->updated_at !== $post->created_at): ?>
                                    <span class="whitespace-nowrap">Actualizado el <?= date('d/m/Y', strtotime($post->updated_at)) ?></span>
                                <?php else: ?>
                                    <span class="whitespace-nowrap"><?= date('d/m/Y', strtotime($post->created_at)) ?></span>
                                    <span class="text-gray-500">•</span>
                                    <span class="whitespace-nowrap"><?= date('H:i', strtotime($post->created_at)) ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <p class="text-gray-300 text-base leading-relaxed text-center overflow-hidden w-full px-4" style="display: -webkit-box; -webkit-line-clamp: 3; line-clamp: 3; -webkit-box-orient: vertical; word-wrap: break-word;">
                                <?= htmlspecialchars($post->descripcion ?? '') ?>
                            </p>
                        </div>
                    </div>
                </div>
            </article>
        </a>
        <?php endforeach; ?>
    </div>
    
    <!-- Paginación -->
    <?php if ($totalPages > 1): ?>
        <div class="flex justify-center items-center gap-2 mt-12">
            <?php if ($page > 1): ?>
                <a href="<?= url('?page=' . ($page - 1)) ?>" class="px-4 py-2 bg-gray-700 text-gray-200 rounded-lg hover:bg-gray-600 transition font-medium">
                    ← Anterior
                </a>
            <?php endif; ?>
            
            <div class="flex gap-1">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if ($i == $page): ?>
                        <span class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold"><?= $i ?></span>
                    <?php else: ?>
                        <a href="<?= url('?page=' . $i) ?>" class="px-4 py-2 bg-gray-700 text-gray-200 rounded-lg hover:bg-gray-600 transition"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            
            <?php if ($page < $totalPages): ?>
                <a href="<?= url('?page=' . ($page + 1)) ?>" class="px-4 py-2 bg-gray-700 text-gray-200 rounded-lg hover:bg-gray-600 transition font-medium">
                    Siguiente →
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>