<?php
// Punto de entrada principal para Render
session_start();

// Incluir conexión
require_once 'conexion.php';

// Determinar qué mostrar según autenticación
if (isset($_SESSION['usuario_id'])) {
    // Usuario autenticado
    if ($_SESSION['rol'] === 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: usuario/perfil.php');
    }
    exit();
} else {
    // Usuario no autenticado - mostrar página principal
    if (file_exists('index.html')) {
        readfile('index.html');
    } else {
        echo '<h1>Sistema de Gestión de Servicios PC</h1>';
        echo '<p><a href="login.html">Iniciar Sesión</a></p>';
    }
}
?>