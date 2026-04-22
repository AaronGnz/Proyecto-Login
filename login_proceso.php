<?php
// ============================================================
// login_proceso.php — Procesa el formulario de login
// ============================================================
session_start();

// Si ya está logueado, ir a perfil (solo si la sesión es válida)
if (!empty($_SESSION['usuario_id'])) {
    header("Location: perfil.php");
    exit();
}

// Solo aceptar POST; si llegan por GET, volver al login SIN loop
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

// Incluir DB después de validar método para evitar errores innecesarios
require_once __DIR__ . '/db.php';

$usuario    = trim($_POST['usuario']    ?? '');
$contrasena = trim($_POST['contrasena'] ?? '');

if ($usuario === '' || $contrasena === '') {
    header("Location: login.php?error=campos");
    exit();
}

$conn = getConexion();

$stmt = $conn->prepare(
    "SELECT id, usuario, nombre, contrasena
     FROM usuarios
     WHERE (usuario = ? OR email = ?) AND activo = 1
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

if (!password_verify($contrasena, $fila['contrasena'])) {
    header("Location: login.php?error=credenciales");
    exit();
}

// Login exitoso
session_regenerate_id(true);
$_SESSION['usuario_id'] = (int) $fila['id'];
$_SESSION['usuario']    = $fila['usuario'];
$_SESSION['nombre']     = $fila['nombre'];

// IMPORTANTE: usá una ruta relativa directa a perfil.php
// Si perfil.php también verifica sesión, asegurate de que NO redirija
// a login.php cuando la sesión ya existe (ver nota abajo)
header("Location: perfil.php");
exit();

/*
 * NOTA ANTI-LOOP:
 * Si perfil.php tiene algo como:
 *   if (!isset($_SESSION['usuario_id'])) { header("Location: login.php"); exit(); }
 *
 * Y login.php tiene:
 *   if (isset($_SESSION['usuario_id'])) { header("Location: perfil.php"); exit(); }
 *
 * El loop ocurre si la sesión NO se guarda correctamente entre requests.
 * Causas comunes:
 *   1. session_save_path no tiene permisos de escritura
 *   2. El servidor tiene cookies deshabilitadas
 *   3. Se llama session_start() más de una vez
 *   4. Headers ya enviados (espacios/BOM antes de <?php)
 *
 * Para diagnosticar, agregá temporalmente en perfil.php:
 *   var_dump($_SESSION); exit();
 */
