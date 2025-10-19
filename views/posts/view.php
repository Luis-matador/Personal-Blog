<?php
/**
 * Vista para mostrar un post individual
 * Muestra el título, contenido y fecha de publicación
 */
?>
<article class="bg-gray-800 rounded shadow p-8 max-w-3xl mx-auto">
    <h1 class="text-4xl font-bold mb-4"><?= htmlspecialchars($post->title) ?></h1>
    <p class="text-gray-400 text-sm mb-6">
        Publicado el <?= date('d/m/Y H:i', strtotime($post->created_at)) ?>
    </p>
    <div class="prose prose-invert max-w-none text-gray-100">
        <?= nl2br(htmlspecialchars($post->content)) ?>
    </div>
    <div class="mt-8">
        <a href="/" class="text-indigo-400 hover:text-indigo-200">&larr; Volver al listado</a>
    </div>
</article>