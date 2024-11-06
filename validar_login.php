<?php
session_start();
include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Verificar las credenciales
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute([':email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user;
    header('Location: bienvenida.php');
} else {
    header('Location: login.php?error=1');
}
?>
