<?php
/**
 * Archivo de Conexión a la Base de Datos para RENDER
 * Versión adaptada para producción en la nube
 */

// ==============================================
// CONFIGURACIÓN PARA RENDER (MySQL)
// ==============================================

// OPCIÓN 1: Usar variables de entorno de Render (RECOMENDADO)
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$database = getenv('DB_NAME') ?: 'servicios_pc';

// OPCIÓN 2: Configuración manual (para desarrollo local)
// Descomenta estas líneas SOLO para desarrollo local:
/*
$host = "localhost";
$user = "root";
$password = "";
$database = "servicios_pc";
*/

// ==============================================
// ESTABLECER LA CONEXIÓN
// ==============================================

$db = new mysqli($host, $user, $password, $database);

// Manejo de errores
if ($db->connect_error) {
    // En producción, no mostrar detalles específicos
    if (getenv('ENVIRONMENT') === 'production') {
        error_log("Error de conexión a BD: [" . $db->connect_errno . "] " . $db->connect_error);
        die("Error de conexión con el servidor. Por favor, intente más tarde.");
    } else {
        die("Error de conexión: [" . $db->connect_errno . "] " . $db->connect_error);
    }
}

// Configurar charset
$db->set_charset("utf8mb4");  // Mejor que utf8 para compatibilidad completa

// Variable de compatibilidad
$conn = $db;

// Mensaje de depuración (solo en desarrollo)
if (getenv('ENVIRONMENT') !== 'production') {
    // echo "✅ Conexión establecida a: " . $database;
}

?>