<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center" id="ini">
    <form action="validar_login.php" method="POST" class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Iniciar Sesión</h2>

        <?php if (isset($_GET['error'])): ?>
            <p class="text-red-500 text-center mb-4">Credenciales incorrectas. Intenta de nuevo.</p>
        <?php endif; ?>

        <input type="email" name="email" placeholder="Correo electrónico" 
               class="w-full p-3 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" required>

        <input type="password" name="password" placeholder="Contraseña" 
               class="w-full p-3 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" required>

        <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white p-3 rounded">
            Iniciar Sesión
        </button>

        <p class="text-center mt-4">¿Aún no te has registrado? 
            <a href="registro.php" class="text-indigo-500">Registrarse</a>
        </p>
        <p class="text-center mt-4">TravelWorld 
            <a href="index.html" class="text-indigo-500"><strong>TravelWorld</strong></a>
        </p>
    </form>
</body>
</html>
