<?php
$errors = $errors ?? [];
$old = $old ?? [];
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
     type="password" name="password" id="password" required autocomplete="current-password">
      </div>
      <button class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition" type="submit">
        Entrar
      </button>
    </form>
    <p class="mt-4 text-center text-gray-400">
      ¿No tienes cuenta?
  <a href="register" class="text-indigo-400 hover:underline">Regístrate</a>
    </p>
  </div>
</div>