<?php
$errors = $errors ?? [];
$old = $old ?? [];
?>
<div class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Iniciar sesión</h2>
    <?php if (!empty($errors)): ?>
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <?php foreach ($errors as $error): ?>
          <div><?php echo htmlspecialchars($error); ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <form method="POST" action="/authenticate">
      <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="email">Email</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300"
               type="email" name="email" id="email" required
               value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>">
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 mb-2" for="password">Contraseña</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300"
               type="password" name="password" id="password" required>
      </div>
      <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition" type="submit">
        Entrar
      </button>
    </form>
    <p class="mt-4 text-center text-gray-600">
      ¿No tienes cuenta?
      <a href="/register" class="text-blue-600 hover:underline">Regístrate</a>
    </p>
  </div>
</div>