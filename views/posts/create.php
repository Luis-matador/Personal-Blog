
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
  <form action="/Personal-Blog/public/post/store" method="POST" enctype="multipart/form-data" id="create-post-form" class="space-y-6">
    <div>
      <label for="title" class="block text-lg font-semibold mb-2">Título</label>
      <input type="text" name="title" id="title" class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" required maxlength="120" value="<?= htmlspecialchars($old['title'] ?? '') ?>">
    </div>
    <div>
      <label for="descripcion" class="block text-lg font-semibold mb-2">Descripción corta (máx. 180 caracteres)</label>
      <input type="text" name="descripcion" id="descripcion" class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" required maxlength="180" value="<?= htmlspecialchars($old['descripcion'] ?? '') ?>">
    </div>
    <div>
      <label for="image" class="block text-lg font-semibold mb-2">Imagen destacada</label>
      <div>
        <label for="image" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded cursor-pointer hover:bg-indigo-700 transition font-semibold mb-0">Seleccionar archivo</label>
        <input type="file" name="image" id="image" accept="image/*" style="display:none;">
      </div>
      <div id="preview-container" class="mt-4"></div>
    </div>
    <div>
      <label for="content" class="block text-lg font-semibold mb-2">Contenido</label>
            <div id="quill-editor" class="bg-gray-900 text-gray-100 rounded border border-gray-700 h-[300px]"></div>
            <textarea name="content" id="content" class="hidden"><?= htmlspecialchars($old['content'] ?? '') ?></textarea>
    </div>
        <div class="flex justify-end gap-4">
            <a href="/Personal-Blog/public/" class="px-6 py-2 rounded bg-gray-700 text-gray-300 hover:bg-gray-600 transition">Cancelar</a>
            <button type="submit" class="px-6 py-2 rounded bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">Publicar</button>
        </div>
    </form>
</div>
<!-- Quill WYSIWYG -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
  #quill-editor .ql-editor {
    background-color: #1a202c;
    color: #f3f4f6;
    min-height: 200px;
    border-radius: 0.5rem;
  }
  #quill-editor .ql-toolbar {
    background-color: #2d3748;
    border-radius: 0.5rem 0.5rem 0 0;
    color: #f3f4f6;
  }
</style>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var quill = new Quill('#quill-editor', {
      theme: 'snow',
      placeholder: 'Escribe el contenido del post...'
    });
    // Si hay contenido previo, repoblar el editor
    var oldContent = document.getElementById('content').value;
    if (oldContent) {
      quill.root.innerHTML = oldContent;
    }
    // Al enviar el formulario, copiar el contenido HTML al textarea oculto
    document.getElementById('create-post-form').addEventListener('submit', function(e) {
      var html = quill.root.innerHTML;
      document.getElementById('content').value = html;
      quill.disable();
    });

    // Mostrar nombre de archivo seleccionado
    var fileInput = document.getElementById('image');
    var previewContainer = document.getElementById('preview-container');
    document.querySelector('label[for="image"]').addEventListener('click', function() {
      fileInput.click();
    });
    fileInput.addEventListener('change', function() {
      previewContainer.innerHTML = '';
      if (fileInput.files.length && fileInput.files[0].type.startsWith('image/')) {
        var reader = new FileReader();
        reader.onload = function(e) {
          var img = document.createElement('img');
          img.src = e.target.result;
          img.className = 'rounded shadow border border-gray-700 max-w-[200px] h-auto';
          previewContainer.appendChild(img);
        };
        reader.readAsDataURL(fileInput.files[0]);
      }
    });
  });
</script>


