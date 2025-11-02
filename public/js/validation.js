// validation.js
// Validaciones del lado del cliente para formularios

// Validar formulario de crear post
function validateCreatePostForm() {
  const form = document.getElementById('create-post-form');
  if (!form) return;

  form.addEventListener('submit', function(e) {
    let errors = [];
    
    // Validar título
    const title = document.getElementById('title');
    if (!title.value.trim()) {
      errors.push('El título es obligatorio');
    } else if (title.value.length > 50) {
      errors.push('El título no puede superar los 50 caracteres');
    }

    // Validar descripción
    const descripcion = document.getElementById('descripcion');
    if (!descripcion.value.trim()) {
      errors.push('La descripcion es obligatoria');
    } else if (descripcion.value.length > 100) {
      errors.push('La descripcion no puede superar los 100 caracteres');
    }

    // Validar contenido (TinyMCE)
    const contentEditor = tinymce.get('content');
    const content = contentEditor ? contentEditor.getContent() : '';
    if (!content || content.trim() === '' || content === '<p></p>' || content === '<p><br></p>') {
      errors.push('El contenido es obligatorio');
    }

    // Validar imagen si existe
    const imageInput = document.getElementById('image');
    if (imageInput && imageInput.files.length > 0) {
      const file = imageInput.files[0];
      const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

      if (!allowedTypes.includes(file.type)) {
        errors.push('El tipo de imagen no es válido (solo jpg, png, gif, webp)');
      }
    }

    // Si hay errores, prevenir envío y mostrar
    if (errors.length > 0) {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Errores de validación',
        html: '<ul class="text-left">' + errors.map(err => '<li>' + err + '</li>').join('') + '</ul>',
        background: '#1a202c',
        color: '#f1f5f9',
        confirmButtonColor: '#4f46e5'
      });
    }
  });
}

// Validar formulario de editar post
function validateEditPostForm() {
  const form = document.getElementById('edit-post-form');
  if (!form) return;

  form.addEventListener('submit', function(e) {
    let errors = [];
    
    // Validar título
    const title = document.getElementById('title');
    if (!title.value.trim()) {
      errors.push('El t�tulo es obligatorio');
    } else if (title.value.length > 50) {
      errors.push('El t�tulo no puede superar los 50 caracteres');
    }

    // Validar descripción
    const descripcion = document.getElementById('descripcion');
    if (!descripcion.value.trim()) {
      errors.push('La descripción es obligatoria');
    } else if (descripcion.value.length > 100) {
      errors.push('La descripción no puede superar los 100 caracteres');
    }

    // Validar imagen si se ha seleccionado una nueva
    const imageInput = document.getElementById('image');
    if (imageInput && imageInput.files.length > 0) {
      const file = imageInput.files[0];
      const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

      if (!allowedTypes.includes(file.type)) {
        errors.push('El tipo de imagen no es v�lido (solo jpg, png, gif, webp)');
      }
    }

    // Si hay errores, prevenir envío y mostrar
    if (errors.length > 0) {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Errores de validaci�n',
        html: '<ul class="text-left">' + errors.map(err => '<li>' + err + '</li>').join('') + '</ul>',
        background: '#1a202c',
        color: '#f1f5f9',
        confirmButtonColor: '#4f46e5'
      });
    }
  });
}

document.addEventListener('DOMContentLoaded', function() {
  validateCreatePostForm();
  validateEditPostForm();
  setupImageValidation();
});
