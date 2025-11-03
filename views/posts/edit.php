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
            $isAdmin = isset($_SESSION['admin_access']) && $_SESSION['admin_access'] === true;
            $cancelUrl = $isAdmin ? url('admin/posts') : url('post/' . htmlspecialchars($post->id));
            ?>
            <a href="<?= $cancelUrl ?>" class="px-6 py-2 rounded bg-gray-700 text-gray-300 hover:bg-gray-600 transition">Cancelar</a>
            <button type="submit" class="px-6 py-2 rounded bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">Actualizar</button>
        </div>
    </form>
</div>
<!-- Quill Editor - Editor de texto rico sin necesidad de API key -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<style>
  .ql-toolbar {
    background-color: #2d3748 !important;
    border: 1px solid #4a5568 !important;
    border-radius: 0.5rem 0.5rem 0 0 !important;
  }
  .ql-container {
    background-color: #1a202c !important;
    border: 1px solid #4a5568 !important;
    border-top: none !important;
    border-radius: 0 0 0.5rem 0.5rem !important;
    color: #f3f4f6 !important;
    font-size: 16px !important;
    min-height: 400px;
  }
  .ql-editor {
    color: #f3f4f6 !important;
    min-height: 400px;
  }
  .ql-editor.ql-blank::before {
    color: #a0aec0 !important;
    font-style: normal !important;
  }
  .ql-stroke {
    stroke: #e2e8f0 !important;
  }
  .ql-fill {
    fill: #e2e8f0 !important;
  }
  .ql-picker-label, .ql-picker-item {
    color: #e2e8f0 !important;
  }
  
  /* Estilos para los dropdowns del editor */
  .ql-picker-options {
    background-color: #2d3748 !important;
    border: 1px solid #4a5568 !important;
    border-radius: 0.375rem !important;
    padding: 0.25rem !important;
  }
  .ql-picker-item {
    color: #e2e8f0 !important;
  }
  .ql-picker-item:hover {
    background-color: #4a5568 !important;
    color: #fff !important;
  }
  .ql-picker.ql-expanded .ql-picker-label {
    border-color: #4a5568 !important;
  }
  
  /* Selector de color - mostrar el color seleccionado */
  .ql-color-picker .ql-picker-options,
  .ql-background .ql-picker-options {
    background-color: #2d3748 !important;
    padding: 5px !important;
  }
  
  .ql-color-picker .ql-picker-item,
  .ql-background .ql-picker-item {
    width: 24px !important;
    height: 24px !important;
    border: 2px solid #4a5568 !important;
    margin: 2px !important;
  }
  
  /* Mostrar el color actual en el botón */
  /* El color se aplicará dinámicamente vía JavaScript */
  .ql-color .ql-picker-label .ql-stroke.ql-color-label {
    stroke: currentColor !important;
  }
  
  .ql-background .ql-picker-label .ql-fill.ql-color-label {
    fill: currentColor !important;
  }
  
  /* Clase para aplicar el color seleccionado */
  .ql-picker-label[data-value]:not([data-value=""]) {
    color: inherit;
  }
  
  /* Estados activos/seleccionados */
  .ql-toolbar button.ql-active,
  .ql-toolbar .ql-picker-label.ql-active,
  .ql-toolbar .ql-picker-item.ql-selected {
    background-color: #4a5568 !important;
    border-radius: 4px !important;
  }
  
  .ql-toolbar button:hover,
  .ql-toolbar .ql-picker-label:hover {
    background-color: #374151 !important;
    border-radius: 4px !important;
  }
  
  /* Mejoras responsive para móviles */
  @media (max-width: 640px) {
    .ql-toolbar {
      padding: 8px 4px !important;
    }
    .ql-toolbar .ql-formats {
      margin-right: 8px !important;
    }
    .ql-toolbar button {
      width: 32px !important;
      height: 32px !important;
      padding: 4px !important;
    }
    .ql-toolbar button svg {
      width: 16px !important;
      height: 16px !important;
    }
    .ql-picker-label {
      padding: 4px 8px !important;
      font-size: 13px !important;
    }
    /* Scroll horizontal si es necesario */
    .ql-toolbar {
      overflow-x: auto !important;
      white-space: nowrap !important;
      -webkit-overflow-scrolling: touch;
    }
    /* Mejorar usabilidad táctil */
    .ql-toolbar button,
    .ql-picker-label {
      touch-action: manipulation;
      -webkit-tap-highlight-color: rgba(99, 102, 241, 0.3);
    }
  }
</style>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Contador de caracteres para título y descripción
    var titleInput = document.getElementById('title');
    var titleCount = document.getElementById('title-count');
    titleInput.addEventListener('input', function() {
      titleCount.textContent = this.value.length + '/30 caracteres';
    });
    titleCount.textContent = titleInput.value.length + '/30 caracteres';

    var descInput = document.getElementById('descripcion');
    var descCount = document.getElementById('desc-count');
    descInput.addEventListener('input', function() {
      descCount.textContent = this.value.length + '/60 caracteres';
      // Auto-resize del textarea
      this.style.height = 'auto';
      this.style.height = this.scrollHeight + 'px';
    });
    descCount.textContent = descInput.value.length + '/60 caracteres';
    // Ajustar altura inicial si hay contenido
    descInput.style.height = 'auto';
    descInput.style.height = descInput.scrollHeight + 'px';

    // Crear el editor Quill
    var contentTextarea = document.getElementById('content');
    var quill = new Quill('#content-editor', {
      theme: 'snow',
      placeholder: 'Escribe el contenido de tu post aquí...',
      modules: {
        toolbar: [
          [{ 'header': [1, 2, 3, false] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          [{ 'align': [] }],
          ['link', 'blockquote', 'code-block'],
          ['clean']
        ]
      }
    });

    // Cargar el contenido existente
    if (contentTextarea.value) {
      quill.root.innerHTML = contentTextarea.value;
    }

    // Sincronizar el contenido de Quill con el textarea oculto
    quill.on('text-change', function() {
      contentTextarea.value = quill.root.innerHTML;
    });

    // Actualizar el color de la línea indicadora en los selectores de color
    function updateColorIndicators() {
      // Selector de color de texto
      const colorPicker = document.querySelector('.ql-color .ql-picker-label');
      if (colorPicker) {
        const colorValue = colorPicker.getAttribute('data-value');
        const strokeElement = colorPicker.querySelector('.ql-stroke.ql-color-label');
        if (strokeElement && colorValue) {
          strokeElement.style.stroke = colorValue;
        }
      }
      
      // Selector de color de fondo
      const bgPicker = document.querySelector('.ql-background .ql-picker-label');
      if (bgPicker) {
        const bgValue = bgPicker.getAttribute('data-value');
        const fillElement = bgPicker.querySelector('.ql-fill.ql-color-label');
        if (fillElement && bgValue) {
          fillElement.style.fill = bgValue;
        }
      }
    }
    
    // Observar cambios en los atributos data-value
    const observer = new MutationObserver(updateColorIndicators);
    const colorButton = document.querySelector('.ql-color');
    const bgButton = document.querySelector('.ql-background');
    
    if (colorButton) {
      observer.observe(colorButton, { 
        attributes: true, 
        subtree: true, 
        attributeFilter: ['data-value'] 
      });
    }
    
    if (bgButton) {
      observer.observe(bgButton, { 
        attributes: true, 
        subtree: true, 
        attributeFilter: ['data-value'] 
      });
    }
    
    // Actualizar al inicio
    updateColorIndicators();

    // Vista previa de imagen - FIX: Botón específico sin duplicados
    var fileInput = document.getElementById('image');
    var previewContainer = document.getElementById('preview-container');
    var imageSelectBtn = document.getElementById('image-select-btn');
    
    imageSelectBtn.addEventListener('click', function(e) {
      e.preventDefault();
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
          var label = document.createElement('p');
          label.className = 'text-sm text-green-400 mt-2';
          label.textContent = 'Nueva imagen seleccionada:';
          previewContainer.appendChild(label);
          previewContainer.appendChild(img);
        };
        reader.readAsDataURL(fileInput.files[0]);
      }
    });
  });
</script>
