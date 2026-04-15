<?php
session_start();

// Protección de sesión — debe ir ANTES de cualquier output HTML
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$nombre = htmlspecialchars($_SESSION['nombre']);
$foto   = !empty($_SESSION['foto']) ? htmlspecialchars($_SESSION['foto']) : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; min-height: 100vh; background: #0f0e17; display: flex; justify-content: center; align-items: center; padding: 2rem 1rem; color: #e0d5c5; }
        .card { background: #1a1825; border: 1px solid rgba(200,150,50,0.25); border-radius: 8px; width: 360px; padding: 2.5rem 2rem; box-shadow: 0 0 40px rgba(180,60,20,0.08); }
        .avatar-wrap { position: relative; width: 110px; height: 110px; margin: 0 auto 1.5rem; }
        .avatar-wrap::before { content: ''; position: absolute; inset: -4px; border-radius: 50%; border: 2px solid #c89632; }
        .avatar-wrap img, .avatar-wrap .avatar-placeholder { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid rgba(180,60,20,0.4); display: block; }
        .avatar-placeholder { background: rgba(140,50,15,0.3); display: flex; align-items: center; justify-content: center; font-size: 40px; color: rgba(200,150,50,0.5); }
        .profile-name { font-size: 20px; letter-spacing: 2px; color: #c89632; text-align: center; font-weight: 700; text-transform: uppercase; }
        .profile-role { font-size: 11px; color: rgba(180,160,120,0.5); text-align: center; letter-spacing: 3px; text-transform: uppercase; margin-top: 4px; margin-bottom: 1.5rem; }
        .divider { height: 1px; background: rgba(200,150,50,0.15); margin: 1rem 0; }
        .info-row { display: flex; justify-content: space-between; font-size: 13px; padding: 5px 0; }
        .info-row span:first-child { color: rgba(180,160,120,0.6); }
        .status-ok { color: #5dc475; }
        .upload-label { display: block; font-size: 11px; letter-spacing: 2px; color: rgba(180,160,120,0.6); text-transform: uppercase; margin-bottom: 8px; margin-top: 1rem; }
        .upload-zone { border: 1px dashed rgba(200,150,50,0.3); border-radius: 4px; padding: 1rem; text-align: center; cursor: pointer; transition: border-color 0.2s; position: relative; }
        .upload-zone:hover { border-color: rgba(200,150,50,0.6); }
        .upload-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
        .upload-zone p { font-size: 12px; color: rgba(180,160,120,0.5); pointer-events: none; }
        .msg-success { font-size: 12px; color: #5dc475; margin-top: 8px; text-align: center; }
        .msg-error   { font-size: 12px; color: #e24b4a; margin-top: 8px; text-align: center; }
        .btn-logout { width: 100%; padding: 10px; background: transparent; border: 1px solid rgba(200,150,50,0.2); border-radius: 4px; color: rgba(180,160,120,0.6); font-size: 12px; letter-spacing: 2px; cursor: pointer; margin-top: 1rem; text-transform: uppercase; transition: all 0.2s; }
        .btn-logout:hover { border-color: rgba(200,80,30,0.5); color: #e24b4a; }
    </style>
</head>
<body>
<div class="card">

    <div class="avatar-wrap">
        <?php if ($foto && file_exists($foto)): ?>
            <img src="<?= $foto ?>" alt="Foto de perfil">
        <?php else: ?>
            <div class="avatar-placeholder">&#128100;</div>
        <?php endif; ?>
    </div>

    <div class="profile-name"><?= $nombre ?></div>
    <div class="profile-role">Acceso nivel ALPHA</div>

    <div class="divider"></div>

    <div class="info-row"><span>Estado</span><span class="status-ok">● Activo</span></div>
    <div class="info-row"><span>Rol</span><span>Administrador</span></div>

    <div class="divider"></div>

    <span class="upload-label">Foto de perfil</span>
    <form action="subida_proceso.php" method="POST" enctype="multipart/form-data">
        <div class="upload-zone">
            <input type="file" name="imagen_usuario" accept="image/*" required onchange="this.form.submit()">
            <p>Haz clic para cambiar tu foto</p>
        </div>
    </form>

    <?php if (isset($_GET['upload']) && $_GET['upload'] === 'ok'): ?>
        <p class="msg-success">Foto actualizada correctamente.</p>
    <?php elseif (isset($_GET['upload']) && $_GET['upload'] === 'error'): ?>
        <p class="msg-error">Error al subir la imagen. Intenta de nuevo.</p>
    <?php endif; ?>

    <form action="logout.php" method="POST">
        <button type="submit" class="btn-logout">Cerrar sesión</button>
    </form>

</div>
</body>
</html>