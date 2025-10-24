<?php
/**
 * Vista para mostrar un post individual
 * Muestra el título, contenido y fecha de publicación
 */
?>
<article class="bg-gray-800 rounded shadow p-8 max-w-3xl mx-auto">
    <?php if (!empty($post->image)): ?>
        <img src="/Personal-Blog/public<?= htmlspecialchars($post->image) ?>" alt="Imagen del post" class="mb-6 rounded shadow border border-gray-700" style="max-width: 500px; height: auto;">
    <?php else: ?>
        <div class="mb-6 bg-gray-700 text-gray-400 rounded p-4 text-center">Sin imagen</div>
    <?php endif; ?>
    <h1 class="text-4xl font-bold mb-4"><?= htmlspecialchars($post->title) ?></h1>
    <p class="text-gray-400 text-sm mb-6">
        Publicado el <?= date('d/m/Y H:i', strtotime($post->created_at)) ?>
    </p>
    <div class="prose prose-invert text-gray-100" style="max-width: 100%; word-break: break-word; white-space: pre-line;">
        <?= $post->content ?>
    </div>
    <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="/Personal-Blog/public/" class="text-indigo-400 hover:text-indigo-200">&larr; Volver al listado</a>
        <?php
        require_once __DIR__ . '/../../includes/functions.php';
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post->user_id): ?>
            <form id="delete-post-form" method="POST" action="/Personal-Blog/public/post/<?= htmlspecialchars($post->id) ?>/delete" class="inline">
                <button type="button" id="delete-post-btn" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow cursor-pointer">
                    Eliminar post
                </button>
            </form>
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
    </div>
</article>