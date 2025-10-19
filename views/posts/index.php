<?php
/**
 * Vista para mostrar lista de posts
 * Muestra título, extracto y fecha de cada post
 * Incluye enlaces para ver posts completos
 */
?>
<h1 class="text-3xl font-bold mb-8">Últimas publicaciones</h1>

<?php if (empty($posts)): ?>
    <div class="bg-gray-800 text-gray-300 p-6 rounded shadow text-center">
        No hay publicaciones aún.
    </div>
<?php else: ?>
    <div class="space-y-6">
        <?php foreach ($posts as $post): ?>
            <article class="bg-gray-800 rounded shadow p-6 hover:bg-gray-700 transition">
                <h2 class="text-2xl font-semibold mb-2">
                    <a href="/post/<?= htmlspecialchars($post->id) ?>" class="text-white hover:underline">
                        <?= htmlspecialchars($post->title) ?>
                    </a>
                </h2>
                <p class="text-gray-400 text-sm mb-2">
                    Publicado el <?= date('d/m/Y H:i', strtotime($post->created_at)) ?>
                </p>
                <p class="mb-4">
                    <?= nl2br(htmlspecialchars(mb_strimwidth($post->content, 0, 180, '...'))) ?>
                </p>
                <a href="/post/<?= htmlspecialchars($post->id) ?>" class="inline-block text-indigo-400 hover:text-indigo-200 font-medium">
                    Leer más &rarr;
                </a>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>