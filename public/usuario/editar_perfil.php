<?php
session_start();
if (!isset($_SESSION['loggedin'])) { header('Location: ../login.html'); exit; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-md border border-gray-400 text-center">
        <h1 class="text-2xl font-bold text-yellow-700 mb-3">PÁGINA DE EDICIÓN DE PERFIL</h1>
        <p class="text-gray-600 mb-4">Esta página confirma que la navegación de Usuario funciona.</p>
        <a href="perfil.php" class="inline-block bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded-sm text-sm">
            ← Volver a Mi Perfil
        </a>
    </div>
</body>
</html>