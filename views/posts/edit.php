<?php
$pageTitle = "Editar publicación";
ob_start();
// Mostrar errores si existen
if (!empty($errors)) {
  echo '<div class="mb-6 p-4 rounded bg-red-900 text-red-200 border border-red-700">';
  echo '<ul class="list-disc pl-6">';
  foreach ($errors as $error) {
    echo '<li>' . htmlspecialchars($error) . '</li>';
  }
  echo '</ul></div>';
}
?>
<div class="max-w-2xl mx-auto bg-gray-800 rounded-lg shadow p-8 mt-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Editar publicación</h1>
  <form action="<?= url('post/' . htmlspecialchars($post->id) . '/update') ?>" method="POST" enctype="multipart/form-data" id="edit-post-form" class="space-y-6">
    <div>
  <label for="title" class="block text-lg font-semibold mb-2">Título</label>
  <input type="text" name="title" id="title" class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" required maxlength="30" value="<?= htmlspecialchars($old['title'] ?? $post->title) ?>">
    <div class="text-sm text-gray-400 mt-1"><span id="title-count">0/30</span></div>
    </div>
    <div>
  <label for="descripcion" class="block text-lg font-semibold mb-2">Descripción corta</label>
  <textarea name="descripcion" id="descripcion" rows="1" class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none overflow-hidden" required maxlength="60"><?= htmlspecialchars($old['descripcion'] ?? $post->descripcion) ?></textarea>
    <div class="text-sm text-gray-400 mt-1"><span id="desc-count">0/60</span></div>
    </div>
    <div>
      <label class="block text-lg font-semibold mb-2">Imagen destacada</label>
      <?php if (!empty($post->image)): ?>
        <div class="mb-3">
          <p class="text-sm text-gray-400 mb-2">Imagen actual:</p>
          <img src="<?= asset(ltrim($post->image, '/')) ?>" alt="Imagen actual" class="rounded shadow border border-gray-700 max-w-[200px] h-auto">
        </div>
      <?php endif; ?>
      <button type="button" id="image-select-btn" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition font-semibold">Cambiar imagen</button>
      <input type="file" name="image" id="image" accept="image/*" class="hidden">
      <p class="text-sm text-gray-400 mt-2">Deja vacío si no quieres cambiar la imagen</p>
      <div id="preview-container" class="mt-4"></div>
    </div>
    <div>
      <label for="content" class="block text-lg font-semibold mb-2">Contenido</label>
      <div id="content-editor" style="min-height: 400px;"></div>
      <textarea name="content" id="content" class="hidden"><?= htmlspecialchars($old['content'] ?? $post->content) ?></textarea>
    </div>
        <div class="flex justify-end gap-4">
            <?php 
            // Determinar la URL de cancelar según si el usuario es admin
            $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
            $cancelUrl = $isAdmin ? url('admin/posts') : url('post/' . htmlspecialchars($post->id));
            ?>
            <a href="<?= $cancelUrl ?>" class="px-6 py-2 rounded bg-gray-700 text-gray-300 hover:bg-gray-600 transition">Cancelar</a>
            <button type="submit" class="px-6 py-2 rounded bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">Actualizar</button>
        </div>
    </form>
</div>
<!-- Quill Editor - Editor de texto rico sin necesidad de API key -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="<?= asset('css/quill-custom.css') ?>" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="<?= asset('js/quill-init.js') ?>"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Contadores de caracteres
    setupCharCounter('#title', '#title-count', 30);
    setupCharCounter('#descripcion', '#desc-count', 60, true);

    // Inicializar Quill Editor
    const quill = initQuillEditor('#content-editor', '#content');
    
    // Cargar contenido existente
    const contentTextarea = document.querySelector('#content');
    if (contentTextarea && contentTextarea.value) {
      quill.root.innerHTML = contentTextarea.value;
    }

    // Preview de imagen con etiqueta personalizada
    const fileInput = document.querySelector('#image');
    const previewContainer = document.querySelector('#preview-container');
    const imageSelectBtn = document.querySelector('#image-select-btn');
    
    if (imageSelectBtn) {
      imageSelectBtn.addEventListener('click', function(e) {
        e.preventDefault();
        fileInput.click();
      });
    }
    
    if (fileInput) {
      fileInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';
        if (fileInput.files.length && fileInput.files[0].type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = function(e) {
            const label = document.createElement('p');
            label.className = 'text-sm text-green-400 mt-2 mb-1';
            label.textContent = 'Nueva imagen seleccionada:';
            previewContainer.appendChild(label);
            
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'rounded shadow border border-gray-700 max-w-[200px] h-auto';
            previewContainer.appendChild(img);
          };
          reader.readAsDataURL(fileInput.files[0]);
        }
      });
    }
  });
</script>

