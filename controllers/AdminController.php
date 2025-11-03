<?php
/**
 * Controlador para gestionar el panel de administración
 * Métodos:
 * - index(): mostrar panel principal de administración
 * - checkAccess(): verificar acceso con clave
 */

class AdminController
{
    private const ADMIN_PASSWORD = '1234';

    // Verifica si el usuario ha ingresado la clave de admin
    private function checkAccess()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . url('login'));
            exit;
        }

        // Verificar si ya tiene acceso de admin en esta sesión
        if (isset($_SESSION['admin_access']) && $_SESSION['admin_access'] === true) {
            return true;
        }

        // Si se envió el formulario de clave
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_password'])) {
            $password = $_POST['admin_password'] ?? '';
            
            if ($password === self::ADMIN_PASSWORD) {
                $_SESSION['admin_access'] = true;
                return 'success'; // Indicar acceso exitoso
            } else {
                return 'incorrect';
            }
        }

        return false;
    }

    // Muestra el panel principal de administración
    public function index()
    {
        $access = $this->checkAccess();
        
        // Si no tiene acceso, mostrar formulario de clave
        if ($access !== true && $access !== 'success') {
            $error = ($access === 'incorrect') ? 'Clave incorrecta' : null;
            $pageTitle = 'Acceso a Administración';
            ob_start();
            include __DIR__ . '/../views/admin/access.php';
            $content = ob_get_clean();
            include __DIR__ . '/../views/layouts/main.php';
            return;
        }

        // Si tiene acceso, mostrar panel de admin
        $showSuccessAlert = ($access === 'success'); // Mostrar alerta si acaba de acceder
        $pageTitle = 'Panel de Administración';
        ob_start();
        include __DIR__ . '/../views/admin/index.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }

    // Muestra la gestión de usuarios
    public function users()
    {
        $access = $this->checkAccess();
        
        if ($access !== true) {
            header('Location: ' . url('admin'));
            exit;
        }

        require_once __DIR__ . '/../models/User.php';
        $users = User::all();

        $pageTitle = 'Gestión de Usuarios';
        ob_start();
        include __DIR__ . '/../views/admin/users.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }

    // Muestra la gestión de posts
    public function posts()
    {
        $access = $this->checkAccess();
        
        if ($access !== true) {
            header('Location: ' . url('admin'));
            exit;
        }

        require_once __DIR__ . '/../models/Post.php';
        $posts = Post::allWithAuthors();

        $pageTitle = 'Gestión de Posts';
        ob_start();
        include __DIR__ . '/../views/admin/posts.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }

    // Cerrar sesión de admin (mantiene la sesión de usuario)
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        unset($_SESSION['admin_access']);
        header('Location: ' . url());
        exit;
    }
}
