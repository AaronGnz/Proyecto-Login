<?php

session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: perfil.php");
    exit();
}

$mensaje    = trim($_POST['mensaje'] ?? '');
$usuario_id = (int) $_SESSION['usuario_id'];


if (empty($mensaje)) {
    header("Location: perfil.php?post=vacio");
    exit();
}

$conn = getConexion();
$stmt = $conn->prepare("INSERT INTO publicacion (usuario_id, mensaje) VALUES (?, ?)");
$stmt->bind_param('is', $usuario_id, $mensaje);
$stmt->execute();
$stmt->close();

header("Location: perfil.php?post=ok");
exit();
