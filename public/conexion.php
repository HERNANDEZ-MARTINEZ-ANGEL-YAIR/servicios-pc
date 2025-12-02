<?php
/**
 * Conexión PostgreSQL para Render - VERSIÓN SIMPLE
 */

// Solo mostrar errores en desarrollo
if (getenv('ENVIRONMENT') !== 'production') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

// Configuración para Render PostgreSQL
$host = 'localhost'; // Cambia esto por tu host real
$port = '5432';
$dbname = 'servicios_pc';
$user = 'postgres';
$password = '';

// SOBRESCRIBIR con variables de entorno si existen
if (getenv('DB_HOST')) {
    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT') ?: '5432';
    $dbname = getenv('DB_NAME') ?: 'servicios_pc';
    $user = getenv('DB_USER') ?: 'postgres';
    $password = getenv('DB_PASSWORD') ?: '';
}

// Intentar conexión PostgreSQL
try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    $conn = $pdo;
    
    // Para compatibilidad con código que espera mysqli
    class FakeMySQLi {
        public function query($sql) {
            global $pdo;
            return $pdo->query($sql);
        }
        public function real_escape_string($str) {
            return str_replace("'", "''", $str);
        }
    }
    $db = new FakeMySQLi();
    
} catch (PDOException $e) {
    // Error amigable en producción
    if (getenv('ENVIRONMENT') === 'production') {
        error_log("PostgreSQL Error: " . $e->getMessage());
        die("Error de conexión con la base de datos. Contacte al administrador.");
    } else {
        die("PostgreSQL Error: " . $e->getMessage() . 
            "<br>Configuración usada:<br>" .
            "Host: $host<br>DB: $dbname<br>User: $user");
    }
}
?>
