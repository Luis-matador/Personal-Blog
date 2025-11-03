<?php
/**
 * Controlador para gestionar usuarios y autenticación
 * Métodos:
 * - login(): mostrar formulario de login
 * - authenticate(): procesar login
 * - register(): mostrar formulario de registro
 * - store(): guardar un nuevo usuario
 * - logout(): cerrar sesión
 */

class UserController
{
    // Muestra el formulario de login
    public function login($errors = [], $old = [])
    {
        $pageTitle = 'Login';
        ob_start();
        include __DIR__ . '/../views/users/login.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }

    // Procesa el formulario de login
    public function authenticate()
    {
        try {
            // Recoge datos del formulario
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $errors = [];
            $old = ['email' => $email];

            // Validación básica
            if (empty($email)) {
                $errors[] = "El email es obligatorio.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "El email no es válido.";
            }
            if (empty($password)) {
                $errors[] = "La contraseña es obligatoria.";
            }

            // Si hay errores, vuelve a mostrar el formulario con mensajes
            if ($errors) {
                return $this->login($errors, $old);
            }

            // Autenticación
            require_once __DIR__ . '/../models/User.php';
            $user = User::authenticate($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                require_once __DIR__ . '/../includes/functions.php';
                flashMessage('success', '¡Bienvenido, ' . htmlspecialchars($user->username) . '! Has iniciado sesión.');
                redirect(url());
            } else {
                $errors[] = "Email o contraseña incorrectos.";
                return $this->login($errors, $old);
            }
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    // Muestra el formulario de registro
    public function register($errors = [], $old = [])
    {
        $pageTitle = 'Registro';
        ob_start();
        include __DIR__ . '/../views/users/register.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }

    // Procesa el formulario de registro y guarda el usuario
    public function store()
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        $errors = [];
        $old = ['username' => $username, 'email' => $email];

        // Validaciones
        if (empty($username)) {
            $errors[] = "El nombre de usuario es obligatorio.";
        }
        if (empty($email)) {
            $errors[] = "El email es obligatorio.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El email no es válido.";
        }
        if (empty($password)) {
            $errors[] = "La contraseña es obligatoria.";
        }
        if ($password !== $password_confirm) {
            $errors[] = "Las contraseñas no coinciden.";
        }

        // Si hay errores, vuelve a mostrar el formulario con mensajes
        if ($errors) {
            return $this->register($errors, $old);
        }

        // Crear usuario
        require_once __DIR__ . '/../models/User.php';
        $user = User::getByEmail($email);
        if ($user) {
            $errors[] = "El email ya está registrado.";
            return $this->register($errors, $old);
        }

        $newUser = User::create([
            'username' => $username,
            'email' => $email,
            'password' => $password
        ]);

        if ($newUser) {
            require_once __DIR__ . '/../includes/functions.php';
            flashMessage('success', 'Usuario registrado correctamente. Ahora puedes iniciar sesión.');
            redirect(url('login'));
        } else {
            $errors[] = "Error al registrar el usuario.";
            return $this->register($errors, $old);
        }
    }

    // Cierra la sesión del usuario
    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: ' . url('login'));
        exit;
    }

    // Crear usuario desde admin
    public function adminCreate()
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $errors = [];

        // Validaciones
        if (empty($username)) {
            $errors[] = "El nombre de usuario es obligatorio.";
        }
        if (empty($email)) {
            $errors[] = "El email es obligatorio.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El email no es válido.";
        }

        if ($errors) {
            $_SESSION['flash_error'] = implode('<br>', $errors);
            redirect(url('admin/users'));
            return;
        }

        require_once __DIR__ . '/../models/User.php';
        $existingUser = User::getByEmail($email);
        if ($existingUser) {
            $_SESSION['flash_error'] = "El email ya está registrado.";
            redirect(url('admin/users'));
            return;
        }

        // Crear con contraseña por defecto
        $defaultPassword = 'password123';
        $newUser = User::create([
            'username' => $username,
            'email' => $email,
            'password' => $defaultPassword
        ]);

        if ($newUser) {
            $_SESSION['flash_success'] = "Usuario creado correctamente. Contraseña por defecto: $defaultPassword";
        } else {
            $_SESSION['flash_error'] = "Error al crear el usuario.";
        }
        redirect(url('admin/users'));
    }

    // Actualizar usuario desde admin
    public function adminUpdate($id)
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $errors = [];

        // Validaciones
        if (empty($username)) {
            $errors[] = "El nombre de usuario es obligatorio.";
        }
        if (empty($email)) {
            $errors[] = "El email es obligatorio.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El email no es válido.";
        }

        if ($errors) {
            $_SESSION['flash_error'] = implode('<br>', $errors);
            redirect(url('admin/users'));
            return;
        }

        require_once __DIR__ . '/../models/User.php';
        $result = User::update($id, [
            'username' => $username,
            'email' => $email
        ]);

        if ($result) {
            $_SESSION['flash_success'] = "Usuario actualizado correctamente.";
        } else {
            $_SESSION['flash_error'] = "Error al actualizar el usuario.";
        }
        redirect(url('admin/users'));
    }

    // Eliminar usuario desde admin
    public function adminDelete($id)
    {
        require_once __DIR__ . '/../models/User.php';
        
        // No permitir eliminar el usuario actual
        if ($id == $_SESSION['user_id']) {
            $_SESSION['flash_error'] = "No puedes eliminar tu propio usuario.";
            redirect(url('admin/users'));
            return;
        }

        $result = User::delete($id);

        if ($result) {
            $_SESSION['flash_success'] = "Usuario eliminado correctamente.";
        } else {
            $_SESSION['flash_error'] = "Error al eliminar el usuario.";
        }
        redirect(url('admin/users'));
    }

    // Cambiar contraseña de usuario desde admin
    public function adminChangePassword($id)
    {
        $newPassword = trim($_POST['new_password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');
        $errors = [];

        // Validaciones
        if (empty($newPassword)) {
            $errors[] = "La nueva contraseña es obligatoria.";
        } elseif (strlen($newPassword) < 6) {
            $errors[] = "La contraseña debe tener al menos 6 caracteres.";
        }
        
        if ($newPassword !== $confirmPassword) {
            $errors[] = "Las contraseñas no coinciden.";
        }

        if ($errors) {
            $_SESSION['flash_error'] = implode('<br>', $errors);
            redirect(url('admin/users'));
            return;
        }

        require_once __DIR__ . '/../models/User.php';
        $result = User::updatePassword($id, $newPassword);

        if ($result) {
            $_SESSION['flash_success'] = "Contraseña actualizada correctamente.";
        } else {
            $_SESSION['flash_error'] = "Error al actualizar la contraseña.";
        }
        redirect(url('admin/users'));
    }

    /**
     * Maneja errores de forma centralizada
     * @param Exception $e Excepción capturada
     */
    private function handleError($e)
    {
        // Log del error
        error_log('[' . date('Y-m-d H:i:s') . '] Error en UserController: ' . $e->getMessage());
        error_log('Trace: ' . $e->getTraceAsString());
        
        // Mostrar página de error 500
        http_response_code(500);
        $errorMessage = ini_get('display_errors') ? $e->getMessage() : '';
        require_once __DIR__ . '/../config/config.php';
        include __DIR__ . '/../views/errors/500.php';
        exit;
    }
}