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
        session_start();
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
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
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
            return $this->create($errors, $old);
        }

        require_once __DIR__ . '/../models/Post.php';
        $post = Post::create([
            'title' => $title,
            'content' => $content,
            'user_id' => $_SESSION['user_id']
        ]);

        if ($post) {
            header('Location: /');
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
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
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
        if ($result) {
            header('Location: /');
            exit;
        } else {
            echo "Error al eliminar el post.";
        }
    }
}