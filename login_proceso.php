<?php
// ============================================================
// login_proceso.php — Procesa el formulario de login
// ============================================================
session_start();
require_once 'db.php';

// Redirigir si ya está logueado
if (isset($_SESSION['usuario_id'])) {
    header("Location: perfil.php");
    exit();
}

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

$usuario    = trim($_POST['usuario']    ?? '');
$contrasena = trim($_POST['contrasena'] ?? '');

// Validar que no estén vacíos
if ($usuario === '' || $contrasena === '') {
    header("Location: login.php?error=campos");
    exit();
}

$conn = getConexion();

// Buscar por usuario O por email (prepared statement para evitar SQL injection)
$stmt = $conn->prepare(
    "SELECT id, usuario, nombre, contrasena 
     FROM usuarios 
     WHERE usuario = ? OR email = ? 
     LIMIT 1"
);
$stmt->bind_param('ss', $usuario, $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    header("Location: login.php?error=credenciales");
    exit();
}

$fila = $result->fetch_assoc();
$stmt->close();

// Verificar contraseña con password_hash
if (!password_verify($contrasena, $fila['contrasena'])) {
    header("Location: login.php?error=credenciales");
    exit();
}

// Login exitoso — guardar en sesión
$_SESSION['usuario_id'] = $fila['id'];
$_SESSION['usuario']    = $fila['usuario'];
$_SESSION['nombre']     = $fila['nombre'];

// Regenerar ID de sesión para prevenir session fixation
session_regenerate_id(true);

header("Location: perfil.php");
exit();
