<?php

class Post
{
    public $id;
    public $title;
    public $content;
    public $user_id;
    public $created_at;
    public $image;
    public $summary;

    public function __construct($data = [])
    {
    $this->id         = $data['id'] ?? null;
    $this->title      = $data['title'] ?? null;
    $this->content    = $data['content'] ?? null;
    $this->user_id    = $data['user_id'] ?? null;
    $this->created_at = $data['created_at'] ?? null;
    $this->image      = $data['image'] ?? null;
    $this->summary    = $data['summary'] ?? null;
    }

    public static function getAll()
    {
        require __DIR__ . '/../config/database.php';
        $stmt = $db->query("SELECT * FROM posts ORDER BY created_at DESC");
        $posts = [];
        while ($data = $stmt->fetch()) {
            $posts[] = new self($data);
        }
        return $posts;
    }

    public static function getById($id)
    {
        require __DIR__ . '/../config/database.php';
        $stmt = $db->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return $data ? new self($data) : null;
    }

    public static function create($data)
    {
        require __DIR__ . '/../config/database.php';
        $stmt = $db->prepare("INSERT INTO posts (title, content, user_id, image, summary) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([
            $data['title'],
            $data['content'],
            $data['user_id'],
            $data['image'] ?? null,
            $data['summary'] ?? null
        ]);
        if ($result) {
            $id = $db->lastInsertId();
            return self::getById($id);
        }
        return null;
    }

    public function update($data)
    {
        require __DIR__ . '/../config/database.php';
        $stmt = $db->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $result = $stmt->execute([
            $data['title'],
            $data['content'],
            $this->id
        ]);
        if ($result) {
            $this->title = $data['title'];
            $this->content = $data['content'];
        }
        return $result;
    }

    public function delete()
    {
        require __DIR__ . '/../config/database.php';
        $stmt = $db->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}