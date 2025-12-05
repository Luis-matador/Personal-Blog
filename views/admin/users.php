<?php
// Gestión de usuarios
?>
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="mb-6 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Gestión de Usuarios</h1>
            <p class="text-gray-400">Administra las cuentas de usuario del blog</p>
        </div>
        <a href="<?= url('admin') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-700 text-gray-200 rounded-lg hover:bg-gray-600 transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al panel
        </a>
    </div>

    <!-- Mensajes flash -->
    <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="mb-4 p-4 bg-green-900 text-green-200 rounded-lg border border-green-700">
            <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="mb-4 p-4 bg-red-900 text-red-200 rounded-lg border border-red-700">
            <?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?>
        </div>
    <?php endif; ?>

    <!-- Botón crear usuario -->
    <div class="mb-6">
        <button onclick="document.getElementById('create-user-modal').classList.remove('hidden')" 
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Crear nuevo usuario
        </button>
    </div>

    <!-- Tabla de usuarios -->
    <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden border border-gray-700">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Usuario</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Rol</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Fecha de registro</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-gray-700 transition">
                            <td class="px-4 py-3 text-gray-300"><?= htmlspecialchars($user->id) ?></td>
                            <td class="px-4 py-3 text-white font-medium"><?= htmlspecialchars($user->username) ?></td>
                            <td class="px-4 py-3 text-gray-300"><?= htmlspecialchars($user->email) ?></td>
                            <td class="px-4 py-3">
                                <?php if ($user->is_admin): ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-purple-900 text-purple-200 border border-purple-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Admin
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-700 text-gray-300">
                                        Usuario
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-gray-400"><?= date('d/m/Y', strtotime($user->created_at)) ?></td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2 justify-center">
                                    <button onclick='openEditModal(<?= json_encode([
                                        "id" => $user->id,
                                        "username" => $user->username,
                                        "email" => $user->email,
                                        "is_admin" => $user->is_admin
                                    ]) ?>)' 
                                            class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                        Editar
                                    </button>
                                    <button onclick='openPasswordModal(<?= $user->id ?>)' 
                                            class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                                        Contraseña
                                    </button>
                                    <?php if ($user->id != $_SESSION['user_id']): ?>
                                        <form method="POST" action="<?= url('admin/users/' . $user->id . '/delete') ?>" class="inline" id="delete-user-form-<?= $user->id ?>">
                                            <button type="button" onclick="showDeleteUserAlert(<?= $user->id ?>)" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                                                Eliminar
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para crear usuario -->
<div id="create-user-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-800 rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-white mb-4">Crear nuevo usuario</h3>
        <form method="POST" action="<?= url('admin/users/create') ?>">
            <div class="mb-4">
                <label class="block text-gray-300 mb-2" for="new-username">Nombre de usuario</label>
                <input type="text" name="username" id="new-username" required
                       class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500">
            </div>
            <div class="mb-4">
                <label class="block text-gray-300 mb-2" for="new-email">Email</label>
                <input type="email" name="email" id="new-email" required
                       class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500">
            </div>
            <p class="text-sm text-gray-400 mb-4">La contraseña por defecto será: password123</p>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="document.getElementById('create-user-modal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-700 text-gray-300 rounded hover:bg-gray-600 transition">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                    Crear usuario
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para editar usuario -->
<div id="edit-user-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-800 rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-white mb-4">Editar usuario</h3>
        <form method="POST" id="edit-user-form" action="">
            <input type="hidden" name="id" id="edit-id">
            <div class="mb-4">
                <label class="block text-gray-300 mb-2" for="edit-username">Nombre de usuario</label>
                <input type="text" name="username" id="edit-username" required
                       class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500">
            </div>
            <div class="mb-4">
                <label class="block text-gray-300 mb-2" for="edit-email">Email</label>
                <input type="email" name="email" id="edit-email" required
                       class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500">
            </div>
            <div class="mb-4">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_admin" id="edit-is-admin" value="1"
                           class="w-4 h-4 rounded border-gray-700 bg-gray-900 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-gray-300">Rol de Administrador</span>
                </label>
                <p class="text-xs text-gray-400 mt-1 ml-6">Los administradores pueden gestionar todos los posts y usuarios</p>
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="document.getElementById('edit-user-modal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-700 text-gray-300 rounded hover:bg-gray-600 transition">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para cambiar contraseña -->
<div id="password-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-800 rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-white mb-4">Cambiar contraseña</h3>
        <form method="POST" id="password-form" action="">
            <div class="mb-4">
                <label class="block text-gray-300 mb-2" for="new-password">Nueva contraseña</label>
                <input type="password" name="new_password" id="new-password" required minlength="6"
                       autocomplete="new-password" data-form-type="other"
                       class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500">
                <p class="text-xs text-gray-400 mt-1">Mínimo 6 caracteres</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-300 mb-2" for="confirm-password">Confirmar contraseña</label>
                <input type="password" name="confirm_password" id="confirm-password" required minlength="6"
                       autocomplete="new-password" data-form-type="other"
                       class="w-full px-3 py-2 border border-gray-700 bg-gray-900 text-gray-100 rounded focus:outline-none focus:ring focus:border-indigo-500">
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="document.getElementById('password-modal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-700 text-gray-300 rounded hover:bg-gray-600 transition">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                    Cambiar contraseña
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(user) {
    document.getElementById('edit-id').value = user.id;
    document.getElementById('edit-username').value = user.username;
    document.getElementById('edit-email').value = user.email;
    document.getElementById('edit-is-admin').checked = user.is_admin ? true : false;
    document.getElementById('edit-user-form').action = '<?= url('admin/users/') ?>' + user.id + '/update';
    document.getElementById('edit-user-modal').classList.remove('hidden');
}

function openPasswordModal(userId) {
    document.getElementById('password-form').action = '<?= url('admin/users/') ?>' + userId + '/change-password';
    document.getElementById('new-password').value = '';
    document.getElementById('confirm-password').value = '';
    document.getElementById('password-modal').classList.remove('hidden');
}

function showDeleteUserAlert(userId) {
    Swal.fire({
        title: '¿Eliminar usuario?',
        text: 'Esta acción no se puede deshacer. Se eliminarán también todos sus posts.',
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
            document.getElementById('delete-user-form-' + userId).submit();
        }
    });
}
</script>
