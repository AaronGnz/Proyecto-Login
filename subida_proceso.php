<?php
// ============================================================
// subida_proceso.php — Controlador: subir imagen de perfil
// ============================================================
session_start();
require 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['imagen_usuario'])) {
    header("Location: perfil.php");
    exit();
}

$archivo = $_FILES['imagen_usuario'];

if ($archivo['error'] !== UPLOAD_ERR_OK) {
    header("Location: perfil.php?upload=error");
    exit();
}

// Validar MIME real
$finfo    = new finfo(FILEINFO_MIME_TYPE);
$mimeReal = $finfo->file($archivo['tmp_name']);
$tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

if (!in_array($mimeReal, $tiposPermitidos)) {
    header("Location: perfil.php?upload=error");
    exit();
}

// Validar tamaño (máx. 2 MB)
if ($archivo['size'] > 2 * 1024 * 1024) {
    header("Location: perfil.php?upload=error");
    exit();
}

// Crear carpeta si no existe
$directorio = "subidas/";
if (!is_dir($directorio)) {
    mkdir($directorio, 0755, true);
}

$extension   = pathinfo($archivo['name'], PATHINFO_EXTENSION);
$nombreFinal = 'perfil_' . $_SESSION['usuario_id'] . '_' . time() . '.' . strtolower($extension);
$rutaFinal   = $directorio . $nombreFinal;

if (!move_uploaded_file($archivo['tmp_name'], $rutaFinal)) {
    header("Location: perfil.php?upload=error");
    exit();
}

// Actualizar campo "imagen" en la tabla usuario
$conn = getConexion();
$stmt = $conn->prepare("UPDATE usuario SET imagen = ? WHERE id = ?");
$stmt->bind_param('si', $rutaFinal, $_SESSION['usuario_id']);
$stmt->execute();
$stmt->close();

// Actualizar sesión
$_SESSION['imagen'] = $rutaFinal;

header("Location: perfil.php?upload=ok");
exit();
