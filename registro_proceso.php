<?php
require 'db.php';

$usuario   = trim($_POST['usuario']   ?? '');
$password  = $_POST['password']  ?? '';
$password2 = $_POST['password2'] ?? '';

if (empty($usuario) || empty($password) || empty($password2)) {
    header("Location: registro.php?error=vacio&usuario=" . urlencode($usuario));
    exit();
}

if ($password !== $password2) {
    header("Location: registro.php?error=no_coinciden&usuario=" . urlencode($usuario));
    exit();
}

// Validar requisitos de contraseña
if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password)) {
    header("Location: registro.php?error=pass_debil&usuario=" . urlencode($usuario));
    exit();
}

$conn = getConexion();

// Verificar si el usuario ya existe
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
$stmt->bind_param('s', $usuario);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    header("Location: registro.php?error=existe&usuario=" . urlencode($usuario));
    exit();
}
$stmt->close();

// Insertar nuevo usuario con contraseña hasheada
$hash   = password_hash($password, PASSWORD_DEFAULT);
$email  = $usuario . '@placeholder.com';
$nombre = $usuario;

$stmt = $conn->prepare("INSERT INTO usuarios (usuario, email, contrasena, nombre) VALUES (?, ?, ?, ?)");
$stmt->bind_param('ssss', $usuario, $email, $hash, $nombre);
$stmt->execute();
$stmt->close();

header("Location: login.php?registered=1");
exit();
