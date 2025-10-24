<?php

class PostController
{
    // Muestra la lista de posts
    public function index()
    {
        require_once __DIR__ . '/../models/Post.php';
        $posts = Post::getAll();
        $pageTitle = "Inicio";
        ob_start();
        include __DIR__ . '/../views/posts/index.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }

    // Muestra un post individual
    public function view($id)
    {
        require_once __DIR__ . '/../models/Post.php';
        $post = Post::getById($id);
        if (!$post) {
            http_response_code(404);
            echo "Post no encontrado";
            exit;
        }
        $pageTitle = $post->title;
        ob_start();
        include __DIR__ . '/../views/posts/view.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }

    // Muestra el formulario para crear un post
    public function create($errors = [], $old = [])
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        $pageTitle = "Nuevo Post";
        ob_start();
        include __DIR__ . '/../views/posts/create.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }

    // Procesa el formulario y guarda un nuevo post
    public function store()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

    $title = trim($_POST['title'] ?? '');
    $content = $_POST['content'] ?? '';
    error_log('POST content: ' . $content);
        $errors = [];
        $old = ['title' => $title, 'content' => $content];

        // Validaciones
        if (empty($title)) {
            $errors[] = "El título es obligatorio.";
        }
        if (empty($content)) {
            $errors[] = "El contenido es obligatorio.";
        }

        // Validación y procesamiento de imagen
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $image = $_FILES['image'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($image['type'], $allowedTypes)) {
                $errors[] = "El tipo de imagen no es válido (solo jpg, png, gif, webp).";
            }
            if ($image['error'] !== UPLOAD_ERR_OK) {
                $errors[] = "Error al subir la imagen.";
            }
            if (!$errors) {
                $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
                $safeName = uniqid('img_') . '.' . strtolower($ext);
                $uploadDir = __DIR__ . '/../public/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $targetPath = $uploadDir . $safeName;
                if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                    $imagePath = '/uploads/' . $safeName;
                } else {
                    $errors[] = "No se pudo guardar la imagen.";
                }
            }
        }

        if ($errors) {
            return $this->create($errors, $old);
        }

        require_once __DIR__ . '/../models/Post.php';
    require_once __DIR__ . '/../includes/summarize_hf.php';
    $summary = obtenerResumenHF($content);
        $post = Post::create([
            'title' => $title,
            'content' => $content,
            'user_id' => $_SESSION['user_id'],
            'image' => $imagePath,
            'summary' => $summary
        ]);

        if ($post) {
            header('Location: /Personal-Blog/public/');
            exit;
        } else {
            $errors[] = "Error al crear el post.";
            return $this->create($errors, $old);
        }
    }

    // Muestra el formulario para editar un post
    public function edit($id, $errors = [], $old = [])
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        require_once __DIR__ . '/../models/Post.php';
        $post = Post::getById($id);
        if (!$post || $post->user_id != $_SESSION['user_id']) {
            http_response_code(403);
            echo "No tienes permiso para editar este post.";
            exit;
        }
        $pageTitle = "Editar Post";
        if (!$old) {
            $old = ['title' => $post->title, 'content' => $post->content];
        }
        ob_start();
        include __DIR__ . '/../views/posts/edit.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }

    // Procesa el formulario y actualiza el post
    public function update($id)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        require_once __DIR__ . '/../models/Post.php';
        $post = Post::getById($id);
        if (!$post || $post->user_id != $_SESSION['user_id']) {
            http_response_code(403);
            echo "No tienes permiso para editar este post.";
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $errors = [];
        $old = ['title' => $title, 'content' => $content];

        // Validaciones
        if (empty($title)) {
            $errors[] = "El título es obligatorio.";
        }
        if (empty($content)) {
            $errors[] = "El contenido es obligatorio.";
        }

        if ($errors) {
            return $this->edit($id, $errors, $old);
        }

        $result = $post->update([
            'title' => $title,
            'content' => $content
        ]);

        if ($result) {
            header('Location: /post/' . $id);
            exit;
        } else {
            $errors[] = "Error al actualizar el post.";
            return $this->edit($id, $errors, $old);
        }
    }

    // Elimina un post
    public function delete($id)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Personal-Blog/public/login');
            exit;
        }
        require_once __DIR__ . '/../models/Post.php';
        $post = Post::getById($id);
        if (!$post || $post->user_id != $_SESSION['user_id']) {
            http_response_code(403);
            echo "No tienes permiso para eliminar este post.";
            exit;
        }
        $result = $post->delete();
        require_once __DIR__ . '/../includes/functions.php';
        if ($result) {
            flashMessage('success', 'Post eliminado correctamente.');
            redirect('/Personal-Blog/public/');
        } else {
            flashMessage('error', 'Error al eliminar el post.');
            redirect('/Personal-Blog/public/post/' . $id);
        }
    }
}