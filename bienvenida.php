<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Conexión a la base de datos
$host = 'localhost';
$dbname = 'simple_login_system';
$db_user = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Obtener los datos actuales del usuario desde la sesión
$user = $_SESSION['user'];
$message = ''; // Variable para mensajes

// Procesar el formulario para actualizar datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar los campos del formulario
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $edad = filter_input(INPUT_POST, 'edad', FILTER_VALIDATE_INT);
    $fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Sanitiza la fecha para evitar inyecciones
    $vip = filter_input(INPUT_POST, 'vip', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $provincia = filter_input(INPUT_POST, 'provincia', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    // Validación adicional para la fecha
    if ($fecha && DateTime::createFromFormat('Y-m-d', $fecha)) {
        // La fecha es válida y en el formato esperado
    } else {
        $message = "Fecha no válida. Debe estar en formato AAAA-MM-DD.";
    }

    // Manejar la subida de imagen
    $profile_picture = $user['profile_picture'];  // Ruta anterior
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';  // Directorio donde guardar imágenes
        $filename = basename($_FILES['profile_picture']['name']);
        $target_path = $upload_dir . $filename;

        // Verificar que sea un archivo de imagen
        $file_type = mime_content_type($_FILES['profile_picture']['tmp_name']);
        if (strpos($file_type, 'image/') === 0) {
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_path)) {
                $profile_picture = $target_path;  // Nueva ruta de la imagen
            } else {
                $message = "Error al subir la imagen.";
            }
        } else {
            $message = "El archivo subido no es una imagen válida.";
        }
    }

    // Solo actualizar si todos los campos son válidos
    if ($message === '') {
        // Consulta SQL para actualizar los datos
        $sql = "UPDATE users
                SET username = :username, edad = :edad, fecha = :fecha, 
                    vip = :vip, provincia = :provincia, email = :email, 
                    profile_picture = :profile_picture 
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':edad', $edad, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':vip', $vip);
        $stmt->bindParam(':provincia', $provincia);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':profile_picture', $profile_picture);
        $stmt->bindParam(':id', $user['id'], PDO::PARAM_INT);

        try {
            if ($stmt->execute()) {
                // Actualizar los datos en la sesión
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $username,
                    'edad' => $edad,
                    'fecha' => $fecha,
                    'vip' => $vip,
                    'provincia' => $provincia,
                    'email' => $email,
                    'profile_picture' => $profile_picture
                ];
                $message = "Datos actualizados correctamente.";
            } else {
                $message = "Error al actualizar los datos.";
            }
            $user = $_SESSION['user'];
        } catch (PDOException $e) {
            die("Error al ejecutar la consulta: " . $e->getMessage());
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class=" flex items-center justify-center bg-blue-100">
    <div class="bg-white shadow-2xl rounded-lg overflow-hidden w-full max-w-md mx-4">
        <form method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800">Bienvenid@, <?php echo htmlspecialchars($user['username']); ?></h1>
                <p class="text-gray-600 mt-2">Edita tu perfil</p>
            </div>
            
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de Usuario</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"
                        class="block w-full pr-10 border-gray-300 focus:ring-black focus:border-black rounded-md" required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="fas fa-pencil-alt text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Edad</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="number" name="edad" value="<?php echo htmlspecialchars($user['edad']); ?>"
                        class="block w-full pr-10 border-gray-300 focus:ring-black focus:border-black rounded-md" required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="fas fa-pencil-alt text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Viaje</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="date" name="fecha" value="<?php echo htmlspecialchars($user['fecha']); ?>"
                        class="block w-full pr-10 border-gray-300 focus:ring-black focus:border-black rounded-md" required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="fas fa-pencil-alt text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">VIP</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="text" name="vip" value="<?php echo htmlspecialchars($user['vip']); ?>"
                        class="block w-full pr-10 border-gray-300 focus:ring-black focus:border-black rounded-md" required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="fas fa-pencil-alt text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Provincia</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="text" name="provincia" value="<?php echo htmlspecialchars($user['provincia']); ?>"
                        class="block w-full pr-10 border-gray-300 focus:ring-black focus:border-black rounded-md" required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="fas fa-pencil-alt text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                        class="block w-full pr-10 border-gray-300 focus:ring-black focus:border-black rounded-md" required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="fas fa-pencil-alt text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto de Perfil</label>
                <div class="mt-1 flex items-center space-x-4">
                    <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>"
                        alt="Foto de perfil" class="w-16 h-16 rounded-full object-cover">
                    <label for="profile_picture" class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                        <span>Cambiar foto</span>
                        <input id="profile_picture" name="profile_picture" type="file" class="sr-only">
                    </label>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="bg-gray-100 border-l-4 border-gray-500 text-gray-700 p-4 mb-4" role="alert">
                    <p><?php echo htmlspecialchars($message); ?></p>
                </div>
            <?php endif; ?>

            <button type="submit" class="w-full bg-black text-white py-2 px-4 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition duration-300">
                Guardar cambios
            </button>
        </form>
        <div class=" p-4 text-center">
            <a href="consulta2.php" class="inline-block bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300">
                Consultar Usuarios
            </a>
        </div>
        <div class=" p-4 text-center">
            <a href="logout.php" class="inline-block bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300">
                Cerrar Sesión
            </a>
        </div>
        <br><br>
    </div>
</body>
</html>