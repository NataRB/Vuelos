<?php
$host = 'localhost';
$dbname = 'simple_login_system';
$user = 'root'; // Cambia si tienes un usuario diferente
$password = ''; // Cambia si tienes una contraseña

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>
