<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen flex items-center justify-center" id="regis">
    <form action="procesar_registro.php" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Registro de Usuario</h2>

        <input type="text" name="username" placeholder="Nombre de usuario" class="w-full p-3 mb-4 border rounded" required>
        <input type="number" name="edad" placeholder="Edad" class="w-full p-3 mb-4 border rounded" required>
        <label><strong>Fecha en la que desea viajar o viajo</strong></label>
        <br>
        <input type="date" name="fecha" class="w-full p-3 mb-4 border rounded" required>
        <label><strong>¿Eres VIP?</strong></label>
        <br>
        <select name="vip" class="w-full p-3 mb-4 border rounded">
            <option value="No">No</option>
            <option value="Sí">Sí</option>
        </select>
        <input type="text" name="provincia" placeholder="Provincia" class="w-full p-3 mb-4 border rounded" required>
        <input type="email" name="email" placeholder="Correo electrónico" class="w-full p-3 mb-4 border rounded" required>
        <input type="password" name="password" placeholder="Contraseña" class="w-full p-3 mb-4 border rounded" required>
        <div class="w-full max-w-md mx-auto p-6">
        <div class="relative">
            <input
                type="file"
                name="profile_picture"
                id="profile_picture"
                accept="image/*"
                class="sr-only"
                aria-label="Subir foto de perfil"
            >
            <label
                for="profile_picture"
                class="w-full p-4 border-2 border-dashed border-gray-300 rounded-lg text-center hover:border-gray-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 transition-all duration-300 ease-in-out cursor-pointer flex flex-col items-center justify-center"
            >
                <i data-lucide="camera" class="w-8 h-8 text-gray-400 mb-2"></i>
                <span class="text-sm font-medium text-gray-600" id="file-name">
                    Haz clic para subir foto de perfil
                </span>
            </label>
        </div>
        <p class="mt-2 text-sm text-gray-500 text-center" id="file-selected"></p>
    </div>

        <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white p-3 rounded">
            Registrarse
        </button>
        <br>
        <p class="text-center mt-4">¿Ya tienes una cuenta?
            <a href="login.php" class="text-indigo-500">Inicia sesión</a>
        </p>
        <p class="text-center mt-4">TravelWorld
            <a href="index.html" class="text-indigo-500"><strong>TravelWorld</strong></a>
        </p>
    </form>
    <script>
        // Inicializar los iconos de Lucide
        lucide.createIcons();

        // Manejar el cambio de archivo
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                document.getElementById('file-name').textContent = fileName;
                document.getElementById('file-selected').textContent = `Archivo seleccionado: ${fileName}`;
                document.querySelector('[data-lucide="camera"]').dataset.lucide = 'upload';
                lucide.createIcons();
            } else {
                document.getElementById('file-name').textContent = 'Haz clic para subir foto de perfil';
                document.getElementById('file-selected').textContent = '';
                document.querySelector('[data-lucide="upload"]').dataset.lucide = 'camera';
                lucide.createIcons();
            }
        });
    </script>
</body>

</html>