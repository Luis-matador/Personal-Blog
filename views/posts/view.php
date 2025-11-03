<?php
/**
 * Vista para mostrar un post individual
 * Muestra el título, contenido y fecha de publicación
 */
?>
<div class="max-w-3xl mx-auto px-4 py-8">
    <!-- Botón volver arriba -->
    <div class="mb-6">
        <?php 
        // Detectar si vienes desde el panel de admin
        $fromAdmin = isset($_GET['from']) && $_GET['from'] === 'admin';
        $backUrl = $fromAdmin ? url('admin/posts') : url();
        $backText = $fromAdmin ? 'Volver al panel de posts' : 'Volver al listado';
        ?>
        <a href="<?= $backUrl ?>" class="inline-flex items-center gap-2 px-6 py-2 bg-gray-700 text-gray-200 rounded-lg hover:bg-gray-600 transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <?= $backText ?>
        </a>
    </div>

    <!-- Card principal del post -->
    <article class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-2xl overflow-hidden border border-gray-700">
        <!-- Imagen destacada -->
        <?php if (!empty($post->image)): ?>
            <div class="w-full cursor-pointer group relative" onclick="openImageModal()">
                <img src="<?= asset(ltrim($post->image, '/')) ?>" 
                     alt="Imagen del post" 
                     class="w-full block transition-transform duration-300 group-hover:scale-[1.02]"
                     id="post-image">
            </div>
        <?php endif; ?>
        
        <!-- Contenido del post -->
        <div class="p-6 md:p-8">
            <!-- Título -->
            <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-3 break-words leading-tight">
                <?= htmlspecialchars($post->title) ?>
            </h1>
            
            <!-- Metadatos -->
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400 mb-6 pb-4 border-b border-gray-700">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium text-indigo-300"><?= htmlspecialchars($post->author_name) ?></span>
                </div>
                <span class="text-gray-600">•</span>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    <?php if (!empty($post->updated_at) && $post->updated_at !== $post->created_at): ?>
                        <span>Actualizado el <?= date('d/m/Y', strtotime($post->updated_at)) ?> a las <?= date('H:i', strtotime($post->updated_at)) ?></span>
                        <span class="text-gray-600 ml-2">(Publicado el <?= date('d/m/Y', strtotime($post->created_at)) ?>)</span>
                    <?php else: ?>
                        <span>Publicado el <?= date('d/m/Y', strtotime($post->created_at)) ?> a las <?= date('H:i', strtotime($post->created_at)) ?></span>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Descripción corta -->
            <?php if (!empty($post->descripcion)): ?>
                <div class="bg-indigo-900/30 border-l-4 border-indigo-500 p-3 mb-6 rounded-r-lg">
                    <p class="text-gray-300 text-base italic leading-relaxed">
                        <?= htmlspecialchars($post->descripcion) ?>
                    </p>
                </div>
            <?php endif; ?>
            
            <!-- Contenido principal -->
            <div class="prose prose-invert prose-base max-w-none text-gray-100 break-words">
                <?= $post->content ?>
            </div>
        </div>
        
        <!-- Footer con acciones -->
        <?php
        require_once __DIR__ . '/../../includes/functions.php';
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post->user_id): ?>
            <div class="bg-gray-800/50 border-t border-gray-700 p-4">
                <div class="flex flex-wrap gap-3 justify-end">
                    <a href="<?= url('post/' . htmlspecialchars($post->id) . '/edit') ?>" 
                       class="inline-flex flex-row items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition transform hover:scale-105">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="whitespace-nowrap">Editar post</span>
                    </a>
                    <form id="delete-post-form" method="POST" action="<?= url('post/' . htmlspecialchars($post->id) . '/delete') ?>" class="inline">
                        <button type="button" id="delete-post-btn" 
                                class="inline-flex flex-row items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition transform hover:scale-105">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span class="whitespace-nowrap">Eliminar post</span>
                        </button>
                    </form>
                </div>
            </div>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                var btn = document.getElementById('delete-post-btn');
                if (btn) {
                    btn.addEventListener('click', function(e) {
                        showDeleteAlert('delete-post-form');
                    });
                }
            });
            </script>
        <?php endif; ?>
    </article>
</div>

<!-- Modal de imagen ampliada -->
<?php if (!empty($post->image)): ?>
<div id="image-modal" class="hidden fixed inset-0 bg-black bg-opacity-90 z-[200] flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-7xl max-h-full">
        <!-- Botón cerrar -->
        <button onclick="closeImageModal()" class="absolute top-4 right-4 bg-red-600 hover:bg-red-700 text-white rounded-full p-3 shadow-lg transition z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <!-- Imagen ampliada -->
        <img src="<?= asset(ltrim($post->image, '/')) ?>" 
             alt="Imagen ampliada" 
             class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl"
             onclick="event.stopPropagation()">
    </div>
</div>

<script>
function openImageModal() {
    document.getElementById('image-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('image-modal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Cerrar con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
<?php endif; ?>