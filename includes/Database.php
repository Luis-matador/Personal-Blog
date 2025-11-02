<?php
/**
 * Clase para gestionar la conexión a la base de datos
 * Implementa el patrón Singleton para mantener una única conexión
 * Proporciona métodos para ejecutar consultas y obtener resultados
 */
class Database
{
    private static $instance = null;
    private $connection;

    /**
     * Constructor privado para evitar instanciación directa
     */
    private function __construct()
    {
        require_once __DIR__ . '/../config/database.php';
        
        try {
            $this->connection = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER,
                DB_PASS
            );
            // Opciones recomendadas para PDO
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Error de conexión a la base de datos: ' . $e->getMessage());
        }
    }

    /**
     * Evitar clonación del objeto
     */
    private function __clone() {}

    /**
     * Evitar deserialización
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }

    /**
     * Obtener la única instancia de la clase
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Obtener la conexión PDO
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }
}