<?php
// Controlador de usuarios y autenticación

require_once __DIR__ . '/../includes/functions.php';

class UserController
{
    // Muestra el formulario de login
    public function login($errors = [], $old = [], $mustChangePassword = false)
    {
        $pageTitle = 'Login';
        ob_start();
        include __DIR__ . '/../views/users/login.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }

    public function authenticate()
    {
        try {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $errors = [];
            $old = ['email' => $email];

            if (empty($email)) {
                $errors[] = "El email es obligatorio.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "El email no es válido.";
            }
            if (empty($password)) {
                $errors[] = "La contraseña es obligatoria.";
            }

            if ($errors) {
                return $this->login($errors, $old);
            }

            require_once __DIR__ . '/../models/User.php';
            $user = User::authenticate($email, $password);

            if ($user) {
                if ($user->must_change_password) {
                    $_SESSION['temp_user_id'] = $user->id;
                    $_SESSION['temp_username'] = $user->username;
                    $_SESSION['must_change_password'] = true;
                    return $this->login([], $old, true);
                }
                
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                $_SESSION['is_admin'] = $user->is_admin;
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
        $is_admin = isset($_POST['is_admin']) ? 1 : 0;
        $admin_password = trim($_POST['admin_password'] ?? '');
        $errors = [];
        $old = ['username' => $username, 'email' => $email, 'is_admin' => $is_admin];

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

        if ($is_admin) {
            require_once __DIR__ . '/../models/User.php';
            if (!User::verifyAdminPassword($admin_password)) {
                $errors[] = "La contraseña de administrador es incorrecta.";
            }
        }

        if ($errors) {
            return $this->register($errors, $old);
        }

        require_once __DIR__ . '/../models/User.php';
        $user = User::getByEmail($email);
        if ($user) {
            $errors[] = "El email ya está registrado.";
            return $this->register($errors, $old);
        }

        $newUser = User::create([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'is_admin' => $is_admin
        ]);

        if ($newUser) {
            flashMessage('success', 'Usuario registrado correctamente. Ahora puedes iniciar sesión.');
            redirect(url('login'));
        } else {
            $errors[] = "Error al registrar el usuario.";
            return $this->register($errors, $old);
        }
    }

    // Procesa el cambio de contraseña obligatorio
    public function changePasswordFirstTime()
    {
        try {
            if (!isset($_SESSION['must_change_password']) || !$_SESSION['must_change_password']) {
                redirect(url('login'));
                return;
            }

            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $errors = [];

            if (empty($newPassword)) {
                $errors[] = "La nueva contraseña es obligatoria.";
            } elseif (strlen($newPassword) < 6) {
                $errors[] = "La contraseña debe tener al menos 6 caracteres.";
            }

            if ($newPassword !== $confirmPassword) {
                $errors[] = "Las contraseñas no coinciden.";
            }

            if ($errors) {
                echo json_encode(['success' => false, 'message' => implode('<br>', $errors)]);
                return;
            }

            require_once __DIR__ . '/../models/User.php';
            $userId = $_SESSION['temp_user_id'];
            $result = User::changePasswordFirstTime($userId, $newPassword);

            if ($result) {
                $_SESSION['user_id'] = $_SESSION['temp_user_id'];
                $_SESSION['username'] = $_SESSION['temp_username'];
                unset($_SESSION['temp_user_id']);
                unset($_SESSION['temp_username']);
                unset($_SESSION['must_change_password']);

                $user = User::getById($_SESSION['user_id']);
                $_SESSION['is_admin'] = $user->is_admin;

                echo json_encode(['success' => true, 'message' => 'Contraseña actualizada correctamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar la contraseña.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error del servidor.']);
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

        // Crear con contraseña por defecto y flag para forzar cambio
        $defaultPassword = 'password123';
        $newUser = User::create([
            'username' => $username,
            'email' => $email,
            'password' => $defaultPassword,
            'must_change_password' => 1  // Forzar cambio de contraseña en primer login
        ]);

        if ($newUser) {
            $_SESSION['flash_success'] = "Usuario creado correctamente. Contraseña por defecto: $defaultPassword (deberá cambiarla en el primer login)";
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
        $is_admin = isset($_POST['is_admin']) ? 1 : 0;
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
            'email' => $email,
            'is_admin' => $is_admin
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

    // Manejar errores
    private function handleError($e)
    {
        http_response_code(500);
        $errorMessage = ini_get('display_errors') ? $e->getMessage() : '';
        require_once __DIR__ . '/../config/config.php';
        include __DIR__ . '/../views/errors/500.php';
        exit;
    }
}