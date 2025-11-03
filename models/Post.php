<?php

class Post
{
    public $id;
    public $title;
    public $descripcion;
    public $content;
    public $user_id;
    public $created_at;
    public $updated_at;
    public $image;
    public $author_name;

    public function __construct($data = [])
    {
        $this->id         = $data['id'] ?? null;
        $this->title      = $data['title'] ?? null;
        $this->descripcion    = $data['descripcion'] ?? null;
        $this->content    = $data['content'] ?? null;
        $this->user_id    = $data['user_id'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        $this->image      = $data['image'] ?? null;
        $this->author_name = $data['author_name'] ?? 'Autor desconocido';
    }

    public static function getAll()
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM posts ORDER BY created_at DESC");
        $posts = [];
        while ($data = $stmt->fetch()) {
            $posts[] = new self($data);
        }
        return $posts;
    }

    /**
     * Obtiene todos los posts con información del autor
     * @return array
     */
    public static function allWithAuthors()
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT p.*, u.username as author_name 
            FROM posts p 
            LEFT JOIN users u ON p.user_id = u.id 
            ORDER BY p.created_at DESC
        ");
        $posts = [];
        while ($data = $stmt->fetch()) {
            $posts[] = new self($data);
        }
        return $posts;
    }

    /**
     * Obtiene posts paginados con información del autor
     * @param int $page Número de página (empieza en 1)
     * @param int $perPage Posts por página
     * @return array
     */
    public static function getPaginated($page = 1, $perPage = 6)
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        
        $offset = ($page - 1) * $perPage;
        $stmt = $db->prepare("
            SELECT p.*, u.username as author_name 
            FROM posts p 
            LEFT JOIN users u ON p.user_id = u.id 
            ORDER BY p.created_at DESC 
            LIMIT ? OFFSET ?
        ");
        $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $posts = [];
        while ($data = $stmt->fetch()) {
            $posts[] = new self($data);
        }
        return $posts;
    }

    /**
     * Cuenta el total de posts
     * @return int
     */
    public static function count()
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT COUNT(*) as total FROM posts");
        $result = $stmt->fetch();
        return (int)$result['total'];
    }

    /**
     * Busca posts por título o descripción con información del autor
     * @param string $query Término de búsqueda
     * @return array
     */
    public static function search($query)
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        
        $searchTerm = '%' . $query . '%';
        $stmt = $db->prepare("
            SELECT p.*, u.username as author_name 
            FROM posts p 
            LEFT JOIN users u ON p.user_id = u.id 
            WHERE p.title LIKE ? OR p.descripcion LIKE ? OR p.content LIKE ? 
            ORDER BY p.created_at DESC
        ");
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        
        $posts = [];
        while ($data = $stmt->fetch()) {
            $posts[] = new self($data);
        }
        return $posts;
    }

    public static function getById($id)
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT p.*, u.username as author_name 
            FROM posts p 
            LEFT JOIN users u ON p.user_id = u.id 
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return $data ? new self($data) : null;
    }

    public static function create($data)
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO posts (title, descripcion, content, user_id, image) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([
            $data['title'],
            $data['descripcion'],
            $data['content'],
            $data['user_id'],
            $data['image'] ?? null
        ]);
        if ($result) {
            $id = $db->lastInsertId();
            return self::getById($id);
        }
        return null;
    }

    public function update($data)
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE posts SET title = ?, descripcion = ?, content = ?, image = ?, updated_at = NOW() WHERE id = ?");
        $result = $stmt->execute([
            $data['title'],
            $data['descripcion'],
            $data['content'],
            $data['image'] ?? $this->image,
            $this->id
        ]);
        if ($result) {
            $this->title = $data['title'];
            $this->descripcion = $data['descripcion'];
            $this->content = $data['content'];
            $this->updated_at = date('Y-m-d H:i:s');
            if (isset($data['image'])) {
                $this->image = $data['image'];
            }
        }
        return $result;
    }

    public function delete()
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}