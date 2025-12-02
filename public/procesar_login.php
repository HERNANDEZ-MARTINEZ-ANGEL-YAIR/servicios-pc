<?php
// Inicia la sesión de PHP
session_start();

// Usa require_once para asegurar que la conexión se incluya.
// Si procesar_login.php y conexion.php están en el mismo nivel, 'conexion.php' es correcto.
require_once 'conexion.php'; 

// Usamos $db para mayor consistencia
if (!isset($db) || $db->connect_error) {
    // Si la conexión falla, muestra un error de servidor.
    $mensaje = "Error de conexión al servidor de base de datos. Verifica 'conexion.php'.";
    goto mostrar_error; 
}

// 1. Recibir y sanitizar los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $db->real_escape_string(trim($_POST['email'])); 
    $contrasena_plana = $_POST['contrasena'];
    $mensaje = "";

    // 2. Buscar al usuario por email usando Sentencia Preparada
    $sql = "SELECT id_usuario, nombre, contrasena, id_rol FROM usuarios WHERE email = ?";
    $stmt = $db->prepare($sql);
    
    if ($stmt === false) {
        $mensaje = "Error interno: No se pudo preparar la consulta SQL.";
    } else {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            
            // 3. Comparación de texto plano (ASUMIENDO PRUEBA ACADÉMICA)
            if ($contrasena_plana === $usuario['contrasena']) {
                
                // Credenciales correctas: Iniciar Sesión
                $_SESSION['loggedin'] = true;
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['id_rol'] = $usuario['id_rol']; // Guarda el rol

                // =================================================================
                // 4. LÓGICA DE REDIRECCIÓN POR ROL
                // =================================================================
                $rol = $_SESSION['id_rol'];
                
                // 🛑 ESTO ES CRUCIAL: Debes usar la URL base del proyecto.
                // Reemplaza esta línea si tu ruta es diferente.
                $base_url = "/4HMPHP/proyecto personal v1.5/"; 

                if ($rol == 1) {
                    // Rol 1: Administrador 
                    header('Location: ' . $base_url . 'admin/dashboard.php'); 
                } elseif ($rol == 2) {
                    // Rol 2: Usuario/Cliente Estándar 
                    header('Location: ' . $base_url . 'usuario/perfil.php'); 
                } else {
                    // Cualquier otro rol 
                    header('Location: ' . $base_url . 'index.html'); 
                }
                exit(); // Detiene la ejecución después de la redirección
                
            } else {
                // Contraseña incorrecta
                $mensaje = "Contraseña incorrecta.";
            }
        } else {
            // Usuario no encontrado
            $mensaje = "Correo electrónico no registrado.";
        }
        $stmt->close();
    }
    $db->close(); // Cierra la conexión usando $db

    // --- Etiqueta de salto para mostrar error ---
    mostrar_error:

    // Muestra el mensaje de error con un diseño básico de Tailwind
    echo '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error de Sesión</title>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>
        <body class="flex items-center justify-center min-h-screen bg-red-50">
            <div class="bg-white p-6 rounded-xl shadow-lg text-center">
                <h2 class="text-2xl font-bold text-red-600 mb-4">❌ Error de Inicio de Sesión</h2>
                <p class="text-gray-700">' . htmlspecialchars($mensaje) . '</p>
                <p class="mt-4"><a href="login.html" class="text-indigo-600 hover:underline">Volver a intentar</a></p>
            </div>
        </body>
        </html>
    ';

} else {
    // Si alguien intenta acceder a este archivo directamente sin POST, lo manda al login.
    header('Location: login.html');
    exit();
}
?>