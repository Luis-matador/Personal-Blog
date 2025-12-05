<?php
// Gestión de posts
?>
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="mb-6 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Gestión de Posts</h1>
            <p class="text-gray-400">Administra todas las publicaciones del blog</p>
        </div>
        <a href="<?= url('admin') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-700 text-gray-200 rounded-lg hover:bg-gray-600 transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al panel
        </a>
    </div>

    <!-- Mensajes flash -->
    <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="mb-4 p-4 bg-green-900 text-green-200 rounded-lg border border-green-700">
            <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="mb-4 p-4 bg-red-900 text-red-200 rounded-lg border border-red-700">
            <?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?>
        </div>
    <?php endif; ?>

    <!-- Estadísticas -->
    <div class="mb-6 bg-gray-800 rounded-lg shadow-xl border border-gray-700 p-4">
        <div class="text-center">
            <span class="text-2xl font-bold text-indigo-400"><?= count($posts) ?></span>
            <span class="text-gray-400 ml-2">posts totales</span>
        </div>
    </div>

    <!-- Tabla de posts -->
    <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden border border-gray-700">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Título</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Autor</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Fecha</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <?php if (empty($posts)): ?>
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                                No hay posts publicados
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($posts as $post): ?>
                            <tr class="hover:bg-gray-700 transition">
                                <td class="px-4 py-3 text-gray-300"><?= htmlspecialchars($post->id) ?></td>
                                <td class="px-4 py-3">
                                    <div class="flex items-start gap-3">
                                        <?php if (!empty($post->image)): ?>
                                            <img src="<?= asset(ltrim($post->image, '/')) ?>" 
                                                 alt="Miniatura" 
                                                 class="w-20 h-20 object-cover rounded border border-gray-600 flex-shrink-0">
                                        <?php endif; ?>
                                        <div class="flex-1 min-w-0">
                                            <a href="<?= url('post/' . $post->id . '?from=admin') ?>" 
                                               class="text-white font-medium hover:text-indigo-400 transition block truncate">
                                                <?= htmlspecialchars($post->title) ?>
                                            </a>
                                            <?php if (!empty($post->descripcion)): ?>
                                                <p class="text-sm text-gray-400 mt-1 line-clamp-2">
                                                    <?= htmlspecialchars(mb_substr($post->descripcion, 0, 60)) ?><?= mb_strlen($post->descripcion) > 60 ? '...' : '' ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-300">
                                    <?= htmlspecialchars($post->author_name) ?>
                                </td>
                                <td class="px-4 py-3 text-gray-400">
                                    <?= date('d/m/Y', strtotime($post->created_at)) ?>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2 justify-center">
                                        <a href="<?= url('post/' . $post->id . '/edit') ?>" 
                                           class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                            Editar
                                        </a>
                                        <form method="POST" 
                                              action="<?= url('admin/posts/' . $post->id . '/delete') ?>" 
                                              class="inline" 
                                              id="delete-post-form-<?= $post->id ?>">
                                            <button type="button" 
                                                    onclick="showDeletePostAlert(<?= $post->id ?>)"
                                                    class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function showDeletePostAlert(postId) {
    Swal.fire({
        title: '¿Eliminar post?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        background: '#1a202c',
        color: '#f1f5f9',
        customClass: {
            confirmButton: 'focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2',
            cancelButton: 'focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2',
            popup: 'rounded-lg shadow-lg',
            title: 'font-bold',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-post-form-' + postId).submit();
        }
    });
}
</script>
