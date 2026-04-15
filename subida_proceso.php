<?php
session_start();
require 'db.php';

// Protección de sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['imagen_usuario'])) {
    header("Location: perfil.php");
    exit();
}

$archivo = $_FILES['imagen_usuario'];

// Verificar que no hubo error en la subida
if ($archivo['error'] !== UPLOAD_ERR_OK) {
    header("Location: perfil.php?upload=error");
    exit();
}

// Validar que sea una imagen real comprobando el tipo MIME real del archivo
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

// Generar nombre único para evitar sobreescrituras y conflictos
$extension  = pathinfo($archivo['name'], PATHINFO_EXTENSION);
$nombreFinal = 'perfil_' . $_SESSION['usuario_id'] . '_' . time() . '.' . strtolower($extension);
$rutaFinal   = $directorio . $nombreFinal;

// Mover el archivo
if (!move_uploaded_file($archivo['tmp_name'], $rutaFinal)) {
    header("Location: perfil.php?upload=error");
    exit();
}

// Guardar la ruta en la base de datos
$stmt = $pdo->prepare("UPDATE usuarios SET foto = ? WHERE id = ?");
$stmt->execute([$rutaFinal, $_SESSION['usuario_id']]);

// Actualizar la sesión con la nueva foto
$_SESSION['foto'] = $rutaFinal;

header("Location: perfil.php?upload=ok");
exit();
