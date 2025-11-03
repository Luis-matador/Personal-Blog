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
    } else if (title.value.length > 30) {
      errors.push('El título no puede superar los 30 caracteres');
    }

    // Validar descripción
    const descripcion = document.getElementById('descripcion');
    if (!descripcion.value.trim()) {
      errors.push('La descripción es obligatoria');
    } else if (descripcion.value.length > 60) {
      errors.push('La descripción no puede superar los 60 caracteres');
    }

    // Validar contenido (Quill)
    const contentInput = document.getElementById('content');
    if (!contentInput || !contentInput.value.trim() || contentInput.value === '<p><br></p>') {
      errors.push('El contenido es obligatorio');
    }

    // Validar imagen si existe
    const imageInput = document.getElementById('image');
    if (imageInput && imageInput.files.length > 0) {
      const file = imageInput.files[0];
      const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
      const maxSize = 5 * 1024 * 1024; // 5MB

      if (!allowedTypes.includes(file.type)) {
        errors.push('El tipo de imagen no es válido (solo jpg, png, gif, webp)');
      }
      
      if (file.size > maxSize) {
        errors.push('La imagen no puede superar los 5MB');
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
      errors.push('El título es obligatorio');
    } else if (title.value.length > 30) {
      errors.push('El título no puede superar los 30 caracteres');
    }

    // Validar descripción
    const descripcion = document.getElementById('descripcion');
    if (!descripcion.value.trim()) {
      errors.push('La descripción es obligatoria');
    } else if (descripcion.value.length > 60) {
      errors.push('La descripción no puede superar los 60 caracteres');
    }

    // Validar imagen si se ha seleccionado una nueva
    const imageInput = document.getElementById('image');
    if (imageInput && imageInput.files.length > 0) {
      const file = imageInput.files[0];
      const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
      const maxSize = 5 * 1024 * 1024; // 5MB

      if (!allowedTypes.includes(file.type)) {
        errors.push('El tipo de imagen no es válido (solo jpg, png, gif, webp)');
      }
      
      if (file.size > maxSize) {
        errors.push('La imagen no puede superar los 5MB');
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

// Validar formularios de usuario (login/registro)
function validateUserForms() {
  // Validar login
  const loginForm = document.querySelector('form[action*="authenticate"]');
  if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
      let errors = [];
      
      const email = document.getElementById('email');
      const password = document.getElementById('password');
      
      if (!email.value.trim()) {
        errors.push('El email es obligatorio');
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        errors.push('El email no es válido');
      }
      
      if (!password.value.trim()) {
        errors.push('La contraseña es obligatoria');
      }
      
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

  // Validar registro
  const registerForm = document.querySelector('form[action*="register"]');
  if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
      let errors = [];
      
      const username = document.getElementById('username');
      const email = document.getElementById('email');
      const password = document.getElementById('password');
      const passwordConfirm = document.getElementById('password_confirm');
      
      if (!username.value.trim()) {
        errors.push('El nombre de usuario es obligatorio');
      } else if (username.value.length < 3) {
        errors.push('El nombre de usuario debe tener al menos 3 caracteres');
      }
      
      if (!email.value.trim()) {
        errors.push('El email es obligatorio');
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        errors.push('El email no es válido');
      }
      
      if (!password.value.trim()) {
        errors.push('La contraseña es obligatoria');
      } else if (password.value.length < 6) {
        errors.push('La contraseña debe tener al menos 6 caracteres');
      }
      
      if (password.value !== passwordConfirm.value) {
        errors.push('Las contraseñas no coinciden');
      }
      
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
}

// Inicializar validaciones cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
  validateCreatePostForm();
  validateEditPostForm();
  validateUserForms();
});

