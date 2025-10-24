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
    <div class="space-y-8">
        <?php foreach ($posts as $post): ?>
            <article class="bg-gray-800 rounded shadow p-10 hover:bg-gray-700 transition flex flex-col mx-auto" style="max-width: 1200px; min-height: 320px; margin-bottom: 40px;">
                <div class="flex flex-row items-center w-full" style="gap: 48px; min-height: 240px;">
                    <div class="flex flex-col justify-center items-start h-full flex-1" style="margin-left: 32px;">
                        <h2 class="text-4xl font-extrabold mb-8 text-left">
                            <a href="./post/<?= htmlspecialchars($post->id) ?>" class="text-white hover:underline">
                                <?= htmlspecialchars($post->title) ?>
                            </a>
                        </h2>
                        <p class="text-gray-400 text-3xl">
                            <?= date('d/m/Y H:i', strtotime($post->created_at)) ?>
                        </p>
                    </div>
                    <div class="flex flex-col items-center justify-center h-full flex-1">
                        <?php if (!empty($post->image)): ?>
                            <img src="/Personal-Blog/public<?= htmlspecialchars($post->image) ?>" alt="Imagen del post" class="rounded shadow border border-gray-700 mb-4" style="max-width: 400px; height: auto; margin-top: 32px;">
                        <?php endif; ?>
                        <a href="./post/<?= htmlspecialchars($post->id) ?>" class="px-8 py-3 rounded bg-indigo-600 text-white text-xl font-bold hover:bg-indigo-700 transition text-center mt-6">
                            Leer más &rarr;
                        </a>
                    </div>
                    <div class="flex flex-col justify-center items-start h-full flex-1">
                        <p class="text-gray-100 text-2xl" style="max-width: 340px; word-break: break-word; white-space: pre-line;">
                            <?= htmlspecialchars($post->summary ?? '') ?>
                        </p>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>