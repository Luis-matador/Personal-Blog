<?php
/**
 * Vista para mostrar lista de posts
 * Muestra título, extracto y fecha de cada post
 * Incluye enlaces para ver posts completos
 */
?>
<h1 class="text-4xl font-extrabold mb-8 text-center">Últimas publicaciones</h1>

<?php if (empty($posts)): ?>
    <div class="bg-gray-800 text-gray-300 p-6 rounded shadow text-center">
        No hay publicaciones aún.
    </div>
<?php else: ?>
    <div class="max-w-4xl mx-auto space-y-6 px-4">
        <?php foreach ($posts as $post): ?>
            <a href="./post/<?= htmlspecialchars($post->id) ?>" class="block transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <article class="bg-gray-800 rounded-2xl shadow-lg overflow-hidden cursor-pointer transform">
                    <div class="flex flex-col md:flex-row min-h-[200px]">
                    <!-- Imagen -->
                    <div class="md:w-1/3 flex-shrink-0">
                        <?php if (!empty($post->image)): ?>
                            <img src="/Personal-Blog/public<?= htmlspecialchars($post->image) ?>"
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
                        <h2 class="text-2xl font-bold text-white leading-tight text-center mb-4">
                            <?= htmlspecialchars($post->title) ?>
                        </h2>
                        
                        <div class="flex-1 flex flex-col justify-center items-center space-y-3">
                            <div class="flex items-center text-sm text-gray-400 space-x-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <span><?= date('d/m/Y', strtotime($post->created_at)) ?></span>
                                <span class="text-gray-500">•</span>
                                <span><?= date('H:i', strtotime($post->created_at)) ?></span>
                            </div>
                            
                            <p class="text-gray-300 text-base leading-relaxed line-clamp-3 text-center">
                                <?= htmlspecialchars($post->descripcion ?? '') ?>
                            </p>
                        </div>
                    </div>
                </div>
            </article>
        </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>