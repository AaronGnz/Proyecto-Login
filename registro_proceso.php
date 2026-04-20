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

// Verificar si el usuario ya existe
$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = ?");
$stmt->execute([$usuario]);
if ($stmt->fetch()) {
    header("Location: registro.php?error=existe&usuario=" . urlencode($usuario));
    exit();
}

// Insertar nuevo usuario
$stmt = $pdo->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
$stmt->execute([$usuario, $password]);

header("Location: login.php?registered=1");
exit();