<?php

// Clase Singleton para la conexion a base de datos
class Database {
    private static ?mysqli $connection = null;

    // Método para obtener la instancia única
    public static function getConnection(): mysqli {
        if (self::$connection === null) {
            self::$connection = new mysqli(
                $_ENV['DB_HOST'], 
                $_ENV['DB_USER'], 
                $_ENV['DB_PASS'], 
                $_ENV['DB_NAME']
            );
            
            if (self::$connection->connect_error) {
                die("Connection failed: " . self::$connection->connect_error);
            }
            
            self::$connection->set_charset('utf8');
        }
        return self::$connection;
    }

    // Método para cerrar la conexión (opcional)
    public static function closeConnection(): void {
        if (self::$connection !== null) {
            self::$connection->close();
            self::$connection = null;
        }
    }

    // Prevenir instanciación y clonación
    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = Database::getConnection();// Obtener la instancia única de conexión
$db->set_charset('utf8');

if (!$db) {
    echo "Error: Could not connect to MySQL.";
    echo "Debugging errno: " . mysqli_connect_errno();
    echo "Debugging error: " . mysqli_connect_error();
    exit;
}
