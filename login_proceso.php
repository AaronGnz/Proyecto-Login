<?php

session_start();

if (!empty($_SESSION['usuario_id'])) {
    header("Location: perfil.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/db.php';

$usr_email = trim($_POST['usr_email'] ?? '');
$usr_pass  = $_POST['usr_pass'] ?? '';

if (empty($usr_email) || empty($usr_pass)) {
    header("Location: login.php?error=campos");
    exit();
}

if (strlen($usr_pass) < 8) {
    header("Location: login.php?error=credenciales");
    exit();
}

$conn = getConexion();

$stmt = $conn->prepare(
    "SELECT id, usr_name, usr_email, usr_pass, imagen
     FROM usuario
     WHERE usr_email = ?
     LIMIT 1"
);
$stmt->bind_param('s', $usr_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    header("Location: login.php?error=credenciales");
    exit();
}

$fila = $result->fetch_assoc();
$stmt->close();

if (!password_verify($usr_pass, $fila['usr_pass'])) {
    header("Location: login.php?error=credenciales");
    exit();
}


session_regenerate_id(true);
$_SESSION['usuario_id'] = (int) $fila['id'];
$_SESSION['usr_name']   = $fila['usr_name'];
$_SESSION['usr_email']  = $fila['usr_email'];
$_SESSION['imagen']     = $fila['imagen'];

header("Location: perfil.php");
exit();
