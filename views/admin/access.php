<?php
/**
 * Vista de acceso al panel de administración
 * Solicita clave de acceso
 */
?>
<div class="flex items-center justify-center min-h-[60vh]">
  <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-md p-8">
    <div class="text-center mb-6">
      <svg class="w-16 h-16 mx-auto mb-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
      </svg>
      <h2 class="text-2xl font-bold text-white">Acceso Restringido</h2>
      <p class="text-gray-400 mt-2">Ingresa la clave de administración</p>
    </div>
    
    <?php if (isset($error)): ?>
      <div class="mb-4 p-3 bg-red-900 text-red-300 rounded">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>
    
    <form method="POST" action="<?= url('admin') ?>">
      <div class="mb-6">
        <label class="block text-gray-300 mb-2" for="admin_password">Clave de Administración</label>
        <input class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500"
               type="password" name="admin_password" id="admin_password" required autofocus autocomplete="new-password" data-form-type="other">
      </div>
      <button class="w-full bg-indigo-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-indigo-700 transition shadow-lg transform hover:scale-[1.02]" type="submit">
        Acceder
      </button>
    </form>
    
    <p class="mt-4 text-center text-gray-400">
      <a href="<?= url() ?>" class="text-indigo-400 hover:underline">Volver al inicio</a>
    </p>
  </div>
</div>
