// alerts.js
// Lógica para mostrar alertas SweetAlert2 con el estilo del blog

function showAppAlert(type, message) {
  let config = {
    icon: type,
    title: type === 'success' ? '¡Éxito!' : 'Error',
    text: message,
    timer: 2500,
    timerProgressBar: true,
    showConfirmButton: false,
    background: '#1a202c', // bg-gray-900
    color: '#f1f5f9', // text-gray-100
    iconColor: type === 'success' ? '#22c55e' : '#ef4444', // verde o rojo Tailwind
    customClass: {
      popup: 'rounded-lg shadow-lg',
      title: 'font-bold',
      timerProgressBar: type === 'success' ? 'bg-green-700' : 'bg-red-700'
    }
  };
  Swal.fire(config);
}

// Confirmación para eliminar post
function showDeleteAlert(formId) {
  // Animación visual inmediata en el botón
  const btn = document.getElementById('delete-post-btn');
  if (btn) {
    btn.classList.add('scale-95');
    setTimeout(() => btn.classList.remove('scale-95'), 120);
  }
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
      document.getElementById(formId).submit();
    }
  });
}
