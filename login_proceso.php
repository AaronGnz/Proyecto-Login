<?php
session_start();
require 'db.php';

$usuario   = trim($_POST['usuario']   ?? '');
$password  = $_POST['password']       ?? '';
$password2 = $_POST['password2']      ?? '';

if (empty($usuario) || empty($password) || empty($password2)) {
    header("Location: login.php?error=vacio");
    exit();
}

// Verificar que ambas contraseñas coincidan
if ($password !== $password2) {
    header("Location: login.php?error=no_coinciden");
    exit();
}

// Buscar usuario y comparar contraseña en texto plano
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ? AND password = ?");
$stmt->execute([$usuario, $password]);
$usuario_db = $stmt->fetch();

if ($usuario_db) {
    $_SESSION['usuario_id'] = $usuario_db['id'];
    $_SESSION['nombre']     = $usuario_db['usuario'];
    $_SESSION['foto']       = $usuario_db['foto'] ?? null;

    header("Location: perfil.php");
    exit();
} else {
    header("Location: login.php?error=credenciales");
    exit();
}