<?php
$errors = $errors ?? [];
$old = $old ?? [];
?>
<div class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Registro</h2>
    <?php if (!empty($errors)): ?>
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <?php foreach ($errors as $error): ?>
          <div><?= htmlspecialchars($error) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <form method="POST" action="/store">
      <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="username">Nombre de usuario</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300"
               type="text" name="username" id="username" required
               value="<?= htmlspecialchars($old['username'] ?? '') ?>">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="email">Email</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300"
               type="email" name="email" id="email" required
               value="<?= htmlspecialchars($old['email'] ?? '') ?>">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="password">Contraseña</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300"
               type="password" name="password" id="password" required>
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 mb-2" for="password_confirm">Repite la contraseña</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300"
               type="password" name="password_confirm" id="password_confirm" required>
      </div>
      <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition" type="submit">
        Registrarse
      </button>
    </form>
    <p class="mt-4 text-center text-gray-600">
      ¿Ya tienes cuenta?
      <a href="/login" class="text-blue-600 hover:underline">Inicia sesión</a>
    </p>
  </div>
</div>