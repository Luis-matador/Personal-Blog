<?php

class User
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $is_admin;
    public $created_at;

    // Contraseña maestra para crear administradores
    private const ADMIN_MASTER_PASSWORD = 'admin2024';

    public function __construct($data = [])
    {
        $this->id         = $data['id'] ?? null;
        $this->username   = $data['username'] ?? null;
        $this->email      = $data['email'] ?? null;
        $this->password   = $data['password'] ?? null;
        $this->is_admin   = isset($data['is_admin']) ? (bool)$data['is_admin'] : false;
        $this->created_at = $data['created_at'] ?? null;
    }

    /**
     * Verifica si la contraseña maestra de admin es correcta
     * @param string $password Contraseña a verificar
     * @return bool True si la contraseña es correcta
     */
    public static function verifyAdminPassword($password)
    {
        return $password === self::ADMIN_MASTER_PASSWORD;
    }

    public static function getById($id)
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return $data ? new self($data) : null;
    }

    public static function getByEmail($email)
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $data = $stmt->fetch();
        return $data ? new self($data) : null;
    }

    public static function create($data)
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        
        $isAdmin = isset($data['is_admin']) ? (int)$data['is_admin'] : 0;
        
        $stmt = $db->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([
            $data['username'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $isAdmin
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

    /**
     * Obtiene la cantidad de posts creados por un usuario
     * @param int $userId ID del usuario
     * @return int Cantidad de posts
     */
    public static function getPostCount($userId)
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM posts WHERE user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        return (int)$result['total'];
    }

    /**
     * Obtiene todos los usuarios
     * @return array Array de objetos User
     */
    public static function all()
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM users ORDER BY created_at DESC");
        $users = [];
        while ($row = $stmt->fetch()) {
            $users[] = new self($row);
        }
        return $users;
    }

    /**
     * Actualiza los datos de un usuario (excepto la contraseña)
     * @param int $id ID del usuario
     * @param array $data Datos a actualizar
     * @return bool True si se actualizó correctamente
     */
    public static function update($id, $data)
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        return $stmt->execute([
            $data['username'],
            $data['email'],
            $id
        ]);
    }

    /**
     * Elimina un usuario y todos sus posts asociados
     * @param int $id ID del usuario
     * @return bool True si se eliminó correctamente
     */
    public static function delete($id)
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        
        try {
            // Iniciar transacción
            $db->beginTransaction();
            
            // Primero eliminar todos los posts del usuario
            $stmt = $db->prepare("DELETE FROM posts WHERE user_id = ?");
            $stmt->execute([$id]);
            
            // Luego eliminar el usuario
            $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);
            
            // Confirmar transacción
            $db->commit();
            return true;
        } catch (Exception $e) {
            // Si hay error, revertir cambios
            $db->rollBack();
            return false;
        }
    }

    /**
     * Actualiza la contraseña de un usuario
     * @param int $id ID del usuario
     * @param string $newPassword Nueva contraseña
     * @return bool True si se actualizó correctamente
     */
    public static function updatePassword($id, $newPassword)
    {
        require_once __DIR__ . '/../includes/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([
            password_hash($newPassword, PASSWORD_DEFAULT),
            $id
        ]);
    }
}
