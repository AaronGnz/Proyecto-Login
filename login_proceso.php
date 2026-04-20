<?php
session_start();
require 'db.php';

$usuario  = trim($_POST['usuario']  ?? '');
$password = $_POST['password'] ?? '';

if (empty($usuario) || empty($password)) {
    header("Location: login.php?error=vacio");
    exit();
}

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
