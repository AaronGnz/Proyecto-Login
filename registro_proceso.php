<?php

session_start();
require 'db.php';

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: registro.php");
    exit();
}

$usr_name  = trim($_POST['usr_name']  ?? '');
$usr_email = trim($_POST['usr_email'] ?? '');
$usr_pass  = $_POST['usr_pass']  ?? '';
$usr_pass2 = $_POST['usr_pass2'] ?? '';


if (empty($usr_name) || empty($usr_email) || empty($usr_pass) || empty($usr_pass2)) {
    header("Location: registro.php?error=vacio&usr_name=" . urlencode($usr_name) . "&usr_email=" . urlencode($usr_email));
    exit();
}


if (!filter_var($usr_email, FILTER_VALIDATE_EMAIL)) {
    header("Location: registro.php?error=email&usr_name=" . urlencode($usr_name) . "&usr_email=" . urlencode($usr_email));
    exit();
}


if ($usr_pass !== $usr_pass2) {
    header("Location: registro.php?error=no_coinciden&usr_name=" . urlencode($usr_name) . "&usr_email=" . urlencode($usr_email));
    exit();
}


if (strlen($usr_pass) < 8 || !preg_match('/[A-Z]/', $usr_pass)) {
    header("Location: registro.php?error=pass_debil&usr_name=" . urlencode($usr_name) . "&usr_email=" . urlencode($usr_email));
    exit();
}

$conn = getConexion();


$stmt = $conn->prepare("SELECT id FROM usuario WHERE usr_email = ?");
$stmt->bind_param('s', $usr_email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    header("Location: registro.php?error=email_existe&usr_name=" . urlencode($usr_name) . "&usr_email=" . urlencode($usr_email));
    exit();
}
$stmt->close();


$imagen = null;

if (isset($_FILES['imagen_perfil']) && $_FILES['imagen_perfil']['error'] === UPLOAD_ERR_OK) {
    $archivo = $_FILES['imagen_perfil'];

  
    $finfo    = new finfo(FILEINFO_MIME_TYPE);
    $mimeReal = $finfo->file($archivo['tmp_name']);
    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (!in_array($mimeReal, $tiposPermitidos)) {
        header("Location: registro.php?error=imagen&usr_name=" . urlencode($usr_name) . "&usr_email=" . urlencode($usr_email));
        exit();
    }

    // Validar tamaño (máx. 2 MB)
    if ($archivo['size'] > 2 * 1024 * 1024) {
        header("Location: registro.php?error=imagen&usr_name=" . urlencode($usr_name) . "&usr_email=" . urlencode($usr_email));
        exit();
    }


    $directorio = "subidas/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0755, true);
    }

    $extension   = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nombreFinal = 'perfil_' . uniqid() . '.' . strtolower($extension);
    $rutaFinal   = $directorio . $nombreFinal;

    if (move_uploaded_file($archivo['tmp_name'], $rutaFinal)) {
        $imagen = $rutaFinal;
    }
}


$hash = password_hash($usr_pass, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO usuario (usr_name, usr_email, usr_pass, imagen) VALUES (?, ?, ?, ?)");
$stmt->bind_param('ssss', $usr_name, $usr_email, $hash, $imagen);
$stmt->execute();
$nuevo_id = $conn->insert_id;
$stmt->close();


session_regenerate_id(true);
$_SESSION['usuario_id'] = (int) $nuevo_id;
$_SESSION['usr_name']   = $usr_name;
$_SESSION['usr_email']  = $usr_email;
$_SESSION['imagen']     = $imagen;

header("Location: perfil.php?registered=1");
exit();
