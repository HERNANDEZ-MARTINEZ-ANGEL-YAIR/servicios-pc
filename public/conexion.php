<?php
/**
 * Archivo de Conexión a la Base de Datos para RENDER
 * Versión PostgreSQL (GRATIS en Render)
 */

// ==============================================
// CONFIGURACIÓN PARA RENDER (PostgreSQL con PDO)
// ==============================================

// OPCIÓN 1: Variables de entorno de Render
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '5432';
$database = getenv('DB_NAME') ?: 'servicios_pc';
$user = getenv('DB_USER') ?: 'postgres';
$password = getenv('DB_PASSWORD') ?: '';

// OPCIÓN 2: Configuración local (desarrollo)
// Descomenta SOLO para desarrollo local con XAMPP/MySQL:
/*
$host = "localhost";
$user = "root";
$password = "";
$database = "servicios_pc";
$port = "3306";
*/

// ==============================================
// ESTABLECER LA CONEXIÓN
// ==============================================

try {
    // Para PostgreSQL en Render (usando PDO)
    if (getenv('DB_HOST') && strpos(getenv('DB_HOST'), 'postgres') !== false) {
        // Conexión PostgreSQL con PDO
        $dsn = "pgsql:host=$host;port=$port;dbname=$database";
        $db = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        // Crear también objeto mysqli para compatibilidad (solo para estructura)
        $mysqli = null;
        
    } else {
        // Para MySQL local (tu configuración actual)
        $db = new mysqli($host, $user, $password, $database, $port ?: 3306);
        
        if ($db->connect_error) {
            throw new Exception("MySQL Error: " . $db->connect_error);
        }
        $db->set_charset("utf8mb4");
    }

    // Variable de compatibilidad
    $conn = $db;
    
    // Mensaje de depuración (solo en desarrollo)
    if (getenv('ENVIRONMENT') !== 'production') {
        // echo "✅ Conexión establecida";
    }

} catch (Exception $e) {
    // Manejo de errores
    if (getenv('ENVIRONMENT') === 'production') {
        error_log("Error BD: " . $e->getMessage());
        die("Error de conexión con el servidor. Por favor, intente más tarde.");
    } else {
        die("Error de conexión: " . $e->getMessage());
    }
}
?>
