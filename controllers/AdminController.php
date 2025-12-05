<?php
// Controlador del panel de administración

require_once __DIR__ . '/../includes/functions.php';

class AdminController
{
    private function isAdmin()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . url('login'));
            exit;
        }

        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            http_response_code(403);
            $pageTitle = 'Acceso Denegado';
            $errorMessage = 'No tienes permisos para acceder a esta sección.';
            ob_start();
            include __DIR__ . '/../views/errors/403.php';
            $content = ob_get_clean();
            include __DIR__ . '/../views/layouts/main.php';
            exit;
        }

        return true;
    }

    // Muestra el panel principal de administración
    public function index()
    {
        $this->isAdmin();

        $pageTitle = 'Panel de Administración';
        ob_start();
        include __DIR__ . '/../views/admin/index.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }

    // Muestra la gestión de usuarios
    public function users()
    {
        $this->isAdmin();

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
        $this->isAdmin();

        require_once __DIR__ . '/../models/Post.php';
        $posts = Post::allWithAuthors();

        $pageTitle = 'Gestión de Posts';
        ob_start();
        include __DIR__ . '/../views/admin/posts.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: ' . url());
        exit;
    }
}
