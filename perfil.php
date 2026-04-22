<?php
session_start();

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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f4f5f7;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a1d23;
        }

        .page-wrapper {
            display: flex;
            width: 100%;
            max-width: 960px;
            min-height: 560px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 40px rgba(0,0,0,0.10);
            margin: 2rem 1rem;
        }

        /* ── Panel izquierdo ── */
        .panel-left {
            flex: 1;
            background: #1e2235;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .panel-left::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: rgba(255,255,255,0.03);
        }

        .panel-left::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: rgba(255,255,255,0.03);
        }

        .brand-mark {
            width: 44px; height: 44px;
            background: #3b6bff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2.5rem;
            font-size: 20px;
        }

        .panel-left h2 {
            font-size: 1.65rem;
            font-weight: 600;
            color: #ffffff;
            line-height: 1.35;
            margin-bottom: 1rem;
        }

        .panel-left p {
            font-size: 0.9rem;
            color: #8b92a9;
            line-height: 1.7;
        }

        .feature-list {
            margin-top: 2rem;
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .feature-list li {
            font-size: 0.85rem;
            color: #8b92a9;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .feature-list li::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #3b6bff;
            flex-shrink: 0;
        }

        /* ── Panel derecho ── */
        .panel-right {
            flex: 1;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 2.5rem;
        }

        /* Avatar */
        .avatar-wrap {
            width: 88px; height: 88px;
            margin: 0 auto 1.25rem;
            position: relative;
        }

        .avatar-wrap img,
        .avatar-placeholder {
            width: 100%; height: 100%;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            border: 3px solid #e5e7eb;
        }

        .avatar-placeholder {
            background: #f0f2f8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: #9ca3af;
        }

        /* Nombre y rol */
        .profile-name {
            font-size: 1.15rem;
            font-weight: 600;
            color: #1a1d23;
            text-align: center;
        }

        .profile-role {
            font-size: 0.75rem;
            color: #6b7280;
            text-align: center;
            margin-top: 3px;
            letter-spacing: 0.04em;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 1.25rem 0;
        }

        /* Info rows */
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            padding: 4px 0;
        }

        .info-row span:first-child { color: #6b7280; }
        .info-row span:last-child  { color: #1a1d23; font-weight: 500; }
        .status-ok { color: #16a34a !important; }

        /* Upload */
        .upload-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 500;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 0.5rem;
            margin-top: 1rem;
        }

        .upload-zone {
            border: 1.5px dashed #d1d5db;
            border-radius: 8px;
            padding: 0.9rem;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s;
            position: relative;
        }

        .upload-zone:hover {
            border-color: #3b6bff;
            background: #f5f7ff;
        }

        .upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .upload-zone p {
            font-size: 0.8rem;
            color: #9ca3af;
            pointer-events: none;
        }

        /* Mensajes */
        .msg-success {
            font-size: 0.8rem;
            color: #16a34a;
            margin-top: 6px;
            text-align: center;
        }

        .msg-error {
            font-size: 0.8rem;
            color: #dc2626;
            margin-top: 6px;
            text-align: center;
        }

        /* Botón cerrar sesión */
        .btn-logout {
            width: 100%;
            padding: 0.8rem;
            background: transparent;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            color: #6b7280;
            cursor: pointer;
            margin-top: 1rem;
            letter-spacing: 0.02em;
            transition: border-color 0.15s, color 0.15s, background 0.15s;
        }

        .btn-logout:hover {
            border-color: #ef4444;
            color: #ef4444;
            background: #fff5f5;
        }

        @media (max-width: 640px) {
            .panel-left { display: none; }
            .panel-right { padding: 2rem 1.5rem; border-radius: 16px; }
            .page-wrapper { border-radius: 16px; }
        }
    </style>
</head>
<body>
<div class="page-wrapper">

    <!-- Panel izquierdo -->
    <div class="panel-left">
        <div class="brand-mark">&#9671;</div>
        <h2>Tu espacio personal</h2>
        <p>Gestioná tu cuenta y personalizá tu perfil desde acá.</p>
        <ul class="feature-list">
            <li>Sesión activa y protegida</li>
            <li>Foto de perfil personalizable</li>
            <li>Datos seguros con bcrypt</li>
        </ul>
    </div>

    <!-- Panel derecho -->
    <div class="panel-right">

        <!-- Avatar -->
        <div class="avatar-wrap">
            <?php if ($foto && file_exists($foto)): ?>
                <img src="<?= $foto ?>" alt="Foto de perfil">
            <?php else: ?>
                <div class="avatar-placeholder">&#128100;</div>
            <?php endif; ?>
        </div>

        <div class="profile-name"><?= $nombre ?></div>
        <div class="profile-role">Administrador</div>

        <div class="divider"></div>

        <div class="info-row">
            <span>Estado</span>
            <span class="status-ok">● Activo</span>
        </div>
        <div class="info-row">
            <span>Rol</span>
            <span>Administrador</span>
        </div>

        <div class="divider"></div>

        <!-- Subir foto -->
        <span class="upload-label">Foto de perfil</span>
        <form action="subida_proceso.php" method="POST" enctype="multipart/form-data">
            <div class="upload-zone">
                <input type="file" name="imagen_usuario" accept="image/*" required
                       onchange="this.form.submit()">
                <p>Hacé clic para cambiar tu foto</p>
            </div>
        </form>

        <?php if (isset($_GET['upload']) && $_GET['upload'] === 'ok'): ?>
            <p class="msg-success">Foto actualizada correctamente.</p>
        <?php elseif (isset($_GET['upload']) && $_GET['upload'] === 'error'): ?>
            <p class="msg-error">Error al subir la imagen. Intentá de nuevo.</p>
        <?php endif; ?>

        <!-- Cerrar sesión -->
        <form action="logout.php" method="POST">
            <button type="submit" class="btn-logout">Cerrar sesión</button>
        </form>

    </div>
</div>
</body>
</html>
