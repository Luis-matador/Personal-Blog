<?php

class User
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $created_at;

    public function __construct($data = [])
    {
        $this->id         = $data['id'] ?? null;
        $this->username   = $data['username'] ?? null;
        $this->email      = $data['email'] ?? null;
        $this->password   = $data['password'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
    }

    public static function getById($id)
    {
        require __DIR__ . '/../config/database.php';
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return $data ? new self($data) : null;
    }

    public static function getByEmail($email)
    {
        require __DIR__ . '/../config/database.php';
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $data = $stmt->fetch();
        return $data ? new self($data) : null;
    }

    public static function create($data)
    {
        require __DIR__ . '/../config/database.php';
        $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $result = $stmt->execute([
            $data['username'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
        if ($result) {
            $id = $db->lastInsertId();
            return self::getById($id);
        }
        return null;
    }

    public static function authenticate($email, $password)
    {
        $user = self::getByEmail($email);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return null;
    }
}