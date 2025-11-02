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