<?php
session_start(); 

$base_url = "/4HMPHP/proyecto personal v1.5/"; 

// 1. Verificación de Sesión y Rol (Rol 2)
if (!isset($_SESSION['loggedin']) || ($_SESSION['id_rol'] ?? 0) != 2) {
    header('Location: ' . $base_url . 'login.html');
exit();
}

// 2. Datos del Usuario (Usando Sesión y Estáticos)
$id_usuario = $_SESSION['id_usuario'];
$nombre_usuario_completo = $_SESSION['nombre'] ?? "Usuario Desconocido";
$nombre_partes = explode(" ", $nombre_usuario_completo);
$nombre_usuario_corto = htmlspecialchars($nombre_partes[0]); 

$email_estatico = "usuario_{$id_usuario}@ejemplo.com";
$telefono_estatico = "55-1234-5678";
$fecha_registro_estatica = "01/01/2025"; 

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f3f4f6; /* Fondo gris claro */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
    </style>
</head>
<body class="bg-gray-100">

        <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md border border-gray-100">
        
                <div class="text-center mb-8">
                        <div class="w-16 h-16 mx-auto bg-indigo-500 rounded-full flex items-center justify-center text-white mb-3 shadow-lg">
                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Bienvenido, <?php echo $nombre_usuario_corto; ?></h1>
            <p class="text-sm text-gray-500 mt-1">
                Tu cuenta de usuario (ID: <?php echo $id_usuario; ?>)
            </p>
        </div>

                <div class="mb-8 border border-gray-200 rounded-lg overflow-hidden">
            <h2 class="text-lg font-semibold bg-gray-50 text-gray-700 p-3 border-b">Información del Perfil</h2>
            
            <div class="divide-y divide-gray-200">
                <div class="flex justify-between p-3 text-sm">
                    <span class="font-medium text-gray-600">Email:</span> 
                    <span class="text-gray-900 font-mono"><?php echo $email_estatico; ?></span>
                </div>
                <div class="flex justify-between p-3 bg-gray-50 text-sm">
                    <span class="font-medium text-gray-600">Teléfono:</span> 
                    <span class="text-gray-900"><?php echo $telefono_estatico; ?></span>
                </div>
                <div class="flex justify-between p-3 text-sm">
                    <span class="font-medium text-gray-600">Miembro desde:</span> 
                    <span class="text-gray-900"><?php echo $fecha_registro_estatica; ?></span>
                </div>
            </div>
        </div>

                <div class="mb-6">
            <a href="../servicios.html" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg text-center block transition duration-300 shadow-md">
                🛠️ Solicitar Nuevo Servicio
            </a>
        </div>

                <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-3">Historial de Pedidos (0)</h2>
            
            <div class="text-center p-4 bg-gray-100 rounded-lg text-sm border border-dashed border-gray-300">
                <p class="text-gray-500 font-medium">No hay pedidos registrados en este momento.</p>
            </div>
        </div>

                <div class="pt-4 border-t border-gray-200">
            <a href="../logout.php" class="w-full inline-block bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-lg transition duration-300 text-center text-md shadow-md">
                🚪 CERRAR SESIÓN
            </a>
        </div>

    </div>

</body>
</html>