<?php
$errors = $errors ?? [];
$old = $old ?? [];
require_once __DIR__ . '/../../includes/functions.php';
?>
<div class="flex items-center justify-center w-full h-full">
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
     type="password" name="password" id="password" required autocomplete="new-password" value="">
      </div>
      <div class="mb-6">
        <label class="block text-gray-300 mb-2" for="password_confirm">Repite la contraseña</label>
   <input class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500"
     type="password" name="password_confirm" id="password_confirm" required autocomplete="new-password" value="">
      </div>
      <button class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition" type="submit">
        Registrarse
      </button>
    </form>
    <p class="mt-4 text-center text-gray-400">
      ¿Ya tienes cuenta?
  <a href="login" class="text-indigo-400 hover:underline">Inicia sesión</a>
    </p>
  </div>
</div>