
<?php
$pageTitle = "Crear nueva publicación";
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
    <h1 class="text-3xl font-bold mb-6 text-center">Crear nueva publicación</h1>
  <form action="<?= url('post/store') ?>" method="POST" enctype="multipart/form-data" id="create-post-form" class="space-y-6">
    <div>
  <label for="title" class="block text-lg font-semibold mb-2">Título</label>
  <input type="text" name="title" id="title" class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" required maxlength="30" value="<?= htmlspecialchars($old['title'] ?? '') ?>">
  <div class="text-sm text-gray-400 mt-1"><span id="title-count">0/30</span></div>
    </div>
    <div>
  <label for="descripcion" class="block text-lg font-semibold mb-2">Descripción corta</label>
  <textarea name="descripcion" id="descripcion" rows="1" class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none overflow-hidden" required maxlength="60"><?= htmlspecialchars($old['descripcion'] ?? '') ?></textarea>
  <div class="text-sm text-gray-400 mt-1"><span id="desc-count">0/60</span></div>
    </div>
    <div>
      <label class="block text-lg font-semibold mb-2">Imagen destacada</label>
      <button type="button" id="image-select-btn" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition font-semibold">Seleccionar archivo</button>
      <input type="file" name="image" id="image" accept="image/*" class="hidden">
      <div id="preview-container" class="mt-4"></div>
    </div>
    <div>
      <label for="content" class="block text-lg font-semibold mb-2">Contenido</label>
      <div id="content-editor" style="min-height: 400px;"></div>
      <textarea name="content" id="content" class="hidden"><?= htmlspecialchars($old['content'] ?? '') ?></textarea>
    </div>
        <div class="flex justify-end gap-4">
            <a href="<?= url() ?>" class="px-6 py-2 rounded bg-gray-700 text-gray-300 hover:bg-gray-600 transition">Cancelar</a>
            <button type="submit" class="px-6 py-2 rounded bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">Publicar</button>
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
    initQuillEditor('#content-editor', '#content');

    // Preview de imagen
    setupImagePreview('#image', '#image-select-btn', '#preview-container');
  });
</script>


