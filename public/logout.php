<?php
// 1. Inicia la sesión.
// Esto es necesario para poder acceder a la información de la sesión.
session_start();

// Ruta base del proyecto
$base_url = "/4HMPHP/proyecto personal v1.5/";

// 2. Destruye la sesión actual

// A. Elimina todas las variables de sesión
$_SESSION = array();

// B. Si se desea destruir la sesión completamente, borra también la cookie de sesión.
// Nota: Esto destruirá la sesión, y no solo los datos de la sesión.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// C. Finalmente, destruye la sesión
session_destroy();

// 3. Redirige al usuario a la página de inicio de sesión o a la página principal
header('Location: ' . $base_url . 'login.html');
exit;
?>