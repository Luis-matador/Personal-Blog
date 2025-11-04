<?php
$errors = $errors ?? [];
$old = $old ?? [];
$mustChangePassword = $mustChangePassword ?? false;
require_once __DIR__ . '/../../includes/functions.php';
?>
<div class="flex items-center justify-center min-h-[60vh]">
  <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-white">Iniciar sesión</h2>
    <?php if (!empty($errors)): ?>
      <div class="mb-4 p-3 bg-red-900 text-red-300 rounded">
        <?php foreach ($errors as $error): ?>
          <div><?php echo htmlspecialchars($error); ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  <form method="POST" action="login" autocomplete="off">
      <div class="mb-4">
        <label class="block text-gray-300 mb-2" for="email">Email</label>
   <input class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500"
     type="email" name="email" id="email" required autocomplete="new-username"
     value="<?php echo isset($old['email']) ? htmlspecialchars($old['email']) : ''; ?>">
      </div>
      <div class="mb-6">
        <label class="block text-gray-300 mb-2" for="password">Contraseña</label>
   <input class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500"
     type="password" name="password" id="password" required autocomplete="new-password" data-form-type="other">
      </div>
      <button class="w-full bg-indigo-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-indigo-700 transition shadow-lg transform hover:scale-[1.02]" type="submit">
        Entrar
      </button>
    </form>
    <p class="mt-4 text-center text-gray-400">
      ¿No tienes cuenta?
  <a href="register" class="text-indigo-400 hover:underline">Regístrate</a>
    </p>
  </div>
</div>

<?php if ($mustChangePassword): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Cambiar contraseña',
        html: `
            <div class="text-left">
                <p class="mb-4 text-gray-300">Debes cambiar tu contraseña antes de continuar.</p>
                <div class="mb-4">
                    <label class="block text-gray-300 mb-2">Nueva contraseña</label>
                    <input type="password" id="new_password" class="swal2-input w-full" placeholder="Mínimo 6 caracteres" autocomplete="new-password" data-form-type="other">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-300 mb-2">Confirmar contraseña</label>
                    <input type="password" id="confirm_password" class="swal2-input w-full" placeholder="Repite la contraseña" autocomplete="new-password" data-form-type="other">
                </div>
            </div>
        `,
        background: '#1a202c',
        color: '#f1f5f9',
        showCancelButton: false,
        confirmButtonText: 'Cambiar contraseña',
        confirmButtonColor: '#4f46e5',
        allowOutsideClick: false,
        allowEscapeKey: false,
        preConfirm: () => {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (!newPassword) {
                Swal.showValidationMessage('La nueva contraseña es obligatoria');
                return false;
            }
            if (newPassword.length < 6) {
                Swal.showValidationMessage('La contraseña debe tener al menos 6 caracteres');
                return false;
            }
            if (newPassword !== confirmPassword) {
                Swal.showValidationMessage('Las contraseñas no coinciden');
                return false;
            }

            return { newPassword, confirmPassword };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar petición AJAX para cambiar contraseña
            fetch('<?= url('change-password-first-time') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `new_password=${encodeURIComponent(result.value.newPassword)}&confirm_password=${encodeURIComponent(result.value.confirmPassword)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        background: '#1a202c',
                        color: '#f1f5f9',
                        confirmButtonColor: '#4f46e5'
                    }).then(() => {
                        window.location.href = '<?= url() ?>';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        background: '#1a202c',
                        color: '#f1f5f9',
                        confirmButtonColor: '#4f46e5'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error de conexión con el servidor',
                    background: '#1a202c',
                    color: '#f1f5f9',
                    confirmButtonColor: '#4f46e5'
                });
            });
        }
    });
});
</script>
<?php endif; ?>
