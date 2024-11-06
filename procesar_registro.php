<?php
include 'db.php';

$username = $_POST['username'];
$edad = $_POST['edad'];
$fecha = $_POST['fecha'];
$vip = $_POST['vip'];
$provincia = $_POST['provincia'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar contraseña

// Subir imagen
$targetDir = "uploads/";
$profilePicture = $targetDir . basename($_FILES["profile_picture"]["name"]);
move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $profilePicture);

// Insertar usuario en la base de datos
$sql = "INSERT INTO users (username, edad, fecha, vip, provincia, email, password, profile_picture) 
        VALUES (:username, :edad, :fecha, :vip, :provincia, :email, :password, :profile_picture)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':username' => $username,
    ':edad' => $edad,
    ':fecha' => $fecha,
    ':vip' => $vip,
    ':provincia' => $provincia,
    ':email' => $email,
    ':password' => $password,
    ':profile_picture' => $profilePicture
]);

header('Location: login.php');
?>
