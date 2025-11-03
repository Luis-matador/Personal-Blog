<?php

require_once __DIR__ . '/../includes/functions.php';

class PostController
{
    // Muestra la lista de posts
    public function index()
    {
        try {
            require_once __DIR__ . '/../models/Post.php';
            
            // Paginación
            $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
            $perPage = 6;
            $posts = Post::getPaginated($page, $perPage);
            $totalPosts = Post::count();
            $totalPages = ceil($totalPosts / $perPage);
            
            $pageTitle = "Inicio";
            ob_start();
            include __DIR__ . '/../views/posts/index.php';
            $content = ob_get_clean();
            include __DIR__ . '/../views/layouts/main.php';
        } catch (Exception $e) {
            $this->handleError($e);
        }
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
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . url('login'));
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
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . url('login'));
            exit;
        }

    $title = trim($_POST['title'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $content = $_POST['content'] ?? '';
        $errors = [];
        $old = ['title' => $title, 'descripcion' => $descripcion, 'content' => $content];

        // Validaciones
        if (empty($title)) {
            $errors[] = "El título es obligatorio.";
        } elseif (mb_strlen($title) > 30) {
            $errors[] = "El título no puede superar los 30 caracteres.";
        }
        if (empty($descripcion)) {
            $errors[] = "La descripción corta es obligatoria.";
        } elseif (mb_strlen($descripcion) > 60) {
            $errors[] = "La descripción corta no puede superar los 60 caracteres.";
        }
        if (empty($content)) {
            $errors[] = "El contenido es obligatorio.";
        }

        // Validación y procesamiento de imagen
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if (validateImage($_FILES['image'], $errors)) {
                $imagePath = uploadImage($_FILES['image']);
                if (!$imagePath) {
                    $errors[] = "No se pudo guardar la imagen.";
                }
            }
        }

        if ($errors) {
            return $this->create($errors, $old);
        }

        require_once __DIR__ . '/../models/Post.php';
        $post = Post::create([
            'title' => $title,
            'descripcion' => $descripcion,
            'content' => $content,
            'user_id' => $_SESSION['user_id'],
            'image' => $imagePath
        ]);

        if ($post) {
            header('Location: ' . url());
            exit;
        } else {
            $errors[] = "Error al crear el post.";
            return $this->create($errors, $old);
        }
    }

    // Muestra el formulario para editar un post
    public function edit($id, $errors = [], $old = [])
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . url('login'));
            exit;
        }
        require_once __DIR__ . '/../models/Post.php';
        $post = Post::getById($id);
        
        // Verificar si el usuario es admin o dueño del post
        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
        
        if (!$post || (!$isAdmin && $post->user_id != $_SESSION['user_id'])) {
            http_response_code(403);
            echo "No tienes permiso para editar este post.";
            exit;
        }
        $pageTitle = "Editar Post";
        if (!$old) {
            $old = ['title' => $post->title, 'descripcion' => $post->descripcion, 'content' => $post->content];
        }
        ob_start();
        include __DIR__ . '/../views/posts/edit.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/main.php';
    }

    // Procesa el formulario y actualiza el post
    public function update($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . url('login'));
            exit;
        }
        require_once __DIR__ . '/../models/Post.php';
        $post = Post::getById($id);
        
        // Verificar si el usuario es admin o dueño del post
        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
        
        if (!$post || (!$isAdmin && $post->user_id != $_SESSION['user_id'])) {
            http_response_code(403);
            echo "No tienes permiso para editar este post.";
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $content = $_POST['content'] ?? '';
        $errors = [];
        $old = ['title' => $title, 'descripcion' => $descripcion, 'content' => $content];

        // Validaciones
        if (empty($title)) {
            $errors[] = "El título es obligatorio.";
        } elseif (mb_strlen($title) > 30) {
            $errors[] = "El título no puede superar los 30 caracteres.";
        }
        if (empty($descripcion)) {
            $errors[] = "La descripción corta es obligatoria.";
        } elseif (mb_strlen($descripcion) > 60) {
            $errors[] = "La descripción corta no puede superar los 60 caracteres.";
        }
        if (empty($content)) {
            $errors[] = "El contenido es obligatorio.";
        }

        // Validación y procesamiento de imagen
        $imagePath = $post->image; // Mantener la imagen actual por defecto
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if (validateImage($_FILES['image'], $errors)) {
                $imagePath = uploadImage($_FILES['image'], $post->image);
                if (!$imagePath) {
                    $errors[] = "No se pudo guardar la imagen.";
                }
            }
        }

        if ($errors) {
            return $this->edit($id, $errors, $old);
        }

        $result = $post->update([
            'title' => $title,
            'descripcion' => $descripcion,
            'content' => $content,
            'image' => $imagePath
        ]);

        if ($result) {
            flashMessage('success', 'Post actualizado correctamente.');
            
            // Redirigir según si es admin o no
            if ($isAdmin) {
                header('Location: ' . url('admin/posts'));
            } else {
                header('Location: ' . url());
            }
            exit;
        } else {
            $errors[] = "Error al actualizar el post.";
            return $this->edit($id, $errors, $old);
        }
    }

    // Elimina un post
    public function delete($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . url('login'));
            exit;
        }
        require_once __DIR__ . '/../models/Post.php';
        $post = Post::getById($id);
        if (!$post || $post->user_id != $_SESSION['user_id']) {
            http_response_code(403);
            echo "No tienes permiso para eliminar este post.";
            exit;
        }
        
        // Eliminar imagen física si existe
        if (!empty($post->image)) {
            $imagePath = __DIR__ . '/../public' . $post->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $result = $post->delete();
        if ($result) {
            flashMessage('success', 'Post eliminado correctamente.');
            redirect(url());
        } else {
            flashMessage('error', 'Error al eliminar el post.');
            redirect(url('post/' . $id));
        }
    }

    // Búsqueda de posts
    public function search()
    {
        try {
            require_once __DIR__ . '/../models/Post.php';
            
            $query = isset($_GET['q']) ? trim($_GET['q']) : '';
            $posts = [];
            
            if (!empty($query)) {
                $posts = Post::search($query);
            }
            
            $pageTitle = "Búsqueda: " . htmlspecialchars($query);
            ob_start();
            include __DIR__ . '/../views/posts/search.php';
            $content = ob_get_clean();
            include __DIR__ . '/../views/layouts/main.php';
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    // Eliminar post desde admin (puede eliminar cualquier post)
    public function adminDelete($id)
    {
        require_once __DIR__ . '/../models/Post.php';
        $post = Post::getById($id);
        
        if (!$post) {
            $_SESSION['flash_error'] = "Post no encontrado.";
            redirect(url('admin/posts'));
            return;
        }

        // Eliminar imagen si existe
        if (!empty($post->image)) {
            $imagePath = __DIR__ . '/../public' . $post->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($post->delete()) {
            $_SESSION['flash_success'] = "Post eliminado correctamente.";
        } else {
            $_SESSION['flash_error'] = "Error al eliminar el post.";
        }
        
        redirect(url('admin/posts'));
    }

    /**
     * Maneja errores de forma centralizada
     * @param Exception $e Excepción capturada
     */
    private function handleError($e)
    {
        // Mostrar página de error 500
        http_response_code(500);
        $errorMessage = ini_get('display_errors') ? $e->getMessage() : '';
        require_once __DIR__ . '/../config/config.php';
        include __DIR__ . '/../views/errors/500.php';
        exit;
    }
}