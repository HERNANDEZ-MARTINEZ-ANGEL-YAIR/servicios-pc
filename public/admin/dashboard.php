<?php
session_start();
// Verifica el rol de administrador
if (!isset($_SESSION['loggedin']) || $_SESSION['id_rol'] != 1) {
    header('Location: ../login.html');
    exit;
}

// 1. Incluir el archivo de conexión (usa $db)
require_once '../conexion.php'; 

// Variables de la sesión
$nombre_admin = htmlspecialchars($_SESSION['nombre']);
$fecha_hoy = date("d/m/Y"); 

// Variables por defecto (Si la conexión falla o la consulta es errónea)
$total_usuarios = '...'; 
$servicios_activos = 'ERROR DB'; 
$db_status_message = ''; // Mensaje de estado de la DB

// === INICIO DE COMPROBACIÓN DE CONEXIÓN Y CONSULTAS ===
if (isset($db)) {
    // 2. Consulta a la base de datos para contar usuarios
    // ASUMIMOS que existe la tabla 'usuarios'
    $sql_count_users = "SELECT COUNT(id_usuario) AS total FROM usuarios";
    $result_count = $db->query($sql_count_users);

    if ($result_count && $result_count->num_rows > 0) {
        $fila_count = $result_count->fetch_assoc();
        $total_usuarios = $fila_count['total'];
    }

    // 3. Consulta para contar servicios (Corregido a 'actividades', que es el nombre correcto de tu tabla)
    $sql_count_servicios = "SELECT COUNT(*) AS total FROM actividades";
    $result_servicios = $db->query($sql_count_servicios);

    if ($result_servicios) {
        $fila_servicios = $result_servicios->fetch_assoc();
        // Cambiamos el texto para reflejar que es el TOTAL
        $servicios_activos = $fila_servicios['total'];
    } else {
        // Muestra el error de MySQL si la tabla o consulta es incorrecta
        $db_status_message .= " | Fallo al consultar la tabla 'actividades'. Posible error: " . $db->error;
    }
    
    // Cierra la conexión a la base de datos al finalizar
    $db->close();
} else {
    // Si $db no está definida, algo falló en conexion.php o la ruta es incorrecta.
    $db_status_message = '¡ERROR CRÍTICO! No se pudo conectar a la base de datos (Verifica conexion.php).';
}
// === FIN DE COMPROBACIÓN DE CONEXIÓN Y CONSULTAS ===
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Admin Básico</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-xl bg-white p-6 rounded-md border border-gray-400">
        
        <!-- Encabezado -->
        <header class="text-center mb-6 border-b pb-3">
            <h1 class="text-3xl font-bold text-blue-700">PANEL DE ADMINISTRADOR</h1>
            <p class="text-sm text-gray-500">Bienvenido, <?php echo $nombre_admin; ?> | Fecha: <?php echo $fecha_hoy; ?></p>
        </header>
        
        <!-- Mensaje de Error (ahora más detallado si la DB falla) -->
        <?php if (!empty($db_status_message)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <p class="font-bold">Error de Consulta de Datos</p>
                <p class="text-sm"><?php echo $db_status_message; ?></p>
            </div>
        <?php endif; ?>

        <!-- Sección de Estadísticas Simples -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            
            <!-- Tarjeta 1: Usuarios -->
            <div class="bg-blue-100 p-4 rounded-sm border border-blue-500">
                <p class="text-xs text-blue-800 font-semibold">USUARIOS</p>
                <p class="text-4xl font-bold text-blue-900"><?php echo $total_usuarios; ?></p>
            </div>

            <!-- Tarjeta 2: Servicios -->
            <div class="bg-green-100 p-4 rounded-sm border border-green-500">
                <p class="text-xs text-green-800 font-semibold">TOTAL DE SERVICIOS</p>
                <p class="text-4xl font-bold text-green-900"><?php echo $servicios_activos; ?></p>
            </div>
        </div>

        <!-- Botones de Navegación Funcionales -->
        <h2 class="text-xl font-semibold text-gray-700 mb-3 border-b border-gray-300 pb-2">Opciones Rápidas</h2>
        <div class="grid grid-cols-1 gap-3">
            
            <a href="usuarios.php" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-sm text-center">
                Gestión de Usuarios
            </a>
            
            <a href="servicios.php" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-sm text-center">
                Ver Servicios
            </a>

            <a href="../index.html" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-sm text-center">
                Ir a la Web Principal
            </a>
        </div>

        <!-- Botón de Cerrar Sesión -->
        <div class="text-center mt-6 pt-4 border-t border-gray-300">
            <a href="../logout.php" class="inline-block bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-6 rounded-sm">
                CERRAR SESIÓN
            </a>
        </div>
        
    </div>
</body>
</html>