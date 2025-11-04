<?php
$errors = $errors ?? [];
$old = $old ?? [];
require_once __DIR__ . '/../../includes/functions.php';
?>
<div class="flex items-center justify-center min-h-[60vh] w-full">
  <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-white">Registro</h2>
    <?php if (!empty($errors)): ?>
      <div class="mb-4 p-3 bg-red-900 text-red-300 rounded">
        <?php foreach ($errors as $error): ?>
          <div><?= htmlspecialchars($error) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  <form method="POST" action="register" autocomplete="off">
      <div class="mb-4">
        <label class="block text-gray-300 mb-2" for="username">Nombre de usuario</label>
   <input class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500"
     type="text" name="username" id="username" required autocomplete="new-username"
     value="<?= (isset($old['username']) && $old['username'] !== 'admin') ? htmlspecialchars($old['username']) : '' ?>">
      </div>
      <div class="mb-4">
        <label class="block text-gray-300 mb-2" for="email">Email</label>
   <input class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500"
     type="email" name="email" id="email" required autocomplete="new-username"
     value="<?= (isset($old['email']) && $old['email'] !== 'admin@admin.com') ? htmlspecialchars($old['email']) : '' ?>">
      </div>
      <div class="mb-4">
        <label class="block text-gray-300 mb-2" for="password">Contraseña</label>
   <input class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500"
     type="password" name="password" id="password" required autocomplete="new-password" data-form-type="other" value="">
      </div>
      <div class="mb-6">
        <label class="block text-gray-300 mb-2" for="password_confirm">Repite la contraseña</label>
   <input class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500"
     type="password" name="password_confirm" id="password_confirm" required autocomplete="nope" data-form-type="other" value="">
      </div>
      
      <!-- Opción para registrarse como administrador -->
      <div class="mb-4">
        <label class="flex items-center text-gray-300 cursor-pointer">
          <input type="checkbox" name="is_admin" id="is_admin" class="w-4 h-4 text-indigo-600 bg-gray-700 border-gray-600 rounded focus:ring-indigo-500"
            <?= isset($old['is_admin']) && $old['is_admin'] ? 'checked' : '' ?>>
          <span class="ml-2">Registrarse como Administrador</span>
        </label>
      </div>

      <!-- Campo de contraseña de administrador (visible solo si el checkbox está marcado) -->
      <div class="mb-6" id="admin_password_field" style="display: none;">
        <label class="block text-gray-300 mb-2" for="admin_password">Contraseña de Administrador</label>
        <input class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500"
          type="password" name="admin_password" id="admin_password" autocomplete="new-password" data-form-type="other" value="">
        <p class="text-sm text-gray-400 mt-1">Debes conocer la contraseña maestra para registrarte como administrador.</p>
      </div>

      <button class="w-full bg-indigo-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-indigo-700 transition shadow-lg transform hover:scale-[1.02]" type="submit">
        Registrarse
      </button>
    </form>
    <p class="mt-4 text-center text-gray-400">
      ¿Ya tienes cuenta?
  <a href="login" class="text-indigo-400 hover:underline">Inicia sesión</a>
    </p>
  </div>
</div>

<script>
// Mostrar/ocultar campo de contraseña de administrador
document.getElementById('is_admin').addEventListener('change', function() {
    const adminPasswordField = document.getElementById('admin_password_field');
    const adminPasswordInput = document.getElementById('admin_password');
    
    if (this.checked) {
        adminPasswordField.style.display = 'block';
        adminPasswordInput.required = true;
    } else {
        adminPasswordField.style.display = 'none';
        adminPasswordInput.required = false;
        adminPasswordInput.value = '';
    }
});

// Verificar el estado inicial del checkbox (para cuando hay errores y se recarga el formulario)
if (document.getElementById('is_admin').checked) {
    document.getElementById('admin_password_field').style.display = 'block';
    document.getElementById('admin_password').required = true;
}
</script>