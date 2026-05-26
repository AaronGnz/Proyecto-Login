<?php
// ============================================================
// perfil.php — Vista: Perfil de usuario
// ============================================================
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$conn = getConexion();

// Determinar qué perfil ver (propio o ajeno)
$ver_id    = isset($_GET['id']) ? (int)$_GET['id'] : (int)$_SESSION['usuario_id'];
$es_propio = ($ver_id === (int)$_SESSION['usuario_id']);

// Datos del perfil a visualizar
$stmt = $conn->prepare("SELECT id, usr_name, usr_email, imagen FROM usuario WHERE id = ?");
$stmt->bind_param('i', $ver_id);
$stmt->execute();
$res  = $stmt->get_result();
if ($res->num_rows === 0) {
    header("Location: perfil.php");
    exit();
}
$perfil = $res->fetch_assoc();
$stmt->close();

// Lista de todos los usuarios (para el panel social)
$todos = $conn->query("SELECT id, usr_name, imagen FROM usuario ORDER BY usr_name ASC");

// Publicaciones del perfil visitado (más reciente primero)
$stmt = $conn->prepare(
    "SELECT mensaje, creado_en FROM publicacion WHERE usuario_id = ? ORDER BY creado_en DESC"
);
$stmt->bind_param('i', $ver_id);
$stmt->execute();
$publicaciones = $stmt->get_result();
$stmt->close();

// Nombre a mostrar en sesión actual
$mi_nombre = htmlspecialchars($_SESSION['usr_name']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil — <?= htmlspecialchars($perfil['usr_name']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f4f5f7;
            min-height: 100vh;
            color: #1a1d23;
        }

        /* ── Topbar ── */
        .topbar {
            background: #1e2235;
            padding: 0.9rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
        }

        .brand-dot {
            width: 32px; height: 32px;
            background: #3b6bff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #fff;
        }

        .brand-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: #ffffff;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar-user {
            font-size: 0.85rem;
            color: #8b92a9;
        }

        .topbar-user strong { color: #ffffff; }

        .btn-logout-top {
            padding: 0.4rem 0.9rem;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 6px;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            color: #8b92a9;
            cursor: pointer;
            transition: border-color 0.15s, color 0.15s;
            text-decoration: none;
        }

        .btn-logout-top:hover { border-color: #ef4444; color: #ef4444; }

        /* ── Layout principal ── */
        .main-layout {
            display: flex;
            max-width: 1100px;
            margin: 2rem auto;
            gap: 1.5rem;
            padding: 0 1.5rem;
        }

        /* ── Sidebar izquierdo: usuarios ── */
        .sidebar {
            width: 230px;
            flex-shrink: 0;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            overflow: hidden;
        }

        .card-header {
            padding: 0.85rem 1.1rem;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.75rem;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.07em;
        }

        .user-list { list-style: none; }

        .user-list li a {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.65rem 1.1rem;
            text-decoration: none;
            color: #1a1d23;
            font-size: 0.85rem;
            transition: background 0.12s;
            border-bottom: 1px solid #f9f9f9;
        }

        .user-list li a:hover { background: #f5f7ff; }
        .user-list li a.active { background: #eef1ff; color: #3b6bff; font-weight: 500; }

        .user-avatar-sm {
            width: 32px; height: 32px;
            border-radius: 50%;
            object-fit: cover;
            background: #f0f2f8;
            border: 1.5px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #9ca3af;
            flex-shrink: 0;
            overflow: hidden;
        }

        .user-avatar-sm img { width: 100%; height: 100%; object-fit: cover; }

        /* ── Contenido central ── */
        .content { flex: 1; min-width: 0; }

        /* Tarjeta de perfil */
        .profile-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .avatar-lg {
            width: 80px; height: 80px;
            border-radius: 50%;
            object-fit: cover;
            background: #f0f2f8;
            border: 3px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: #9ca3af;
            flex-shrink: 0;
            overflow: hidden;
        }

        .avatar-lg img { width: 100%; height: 100%; object-fit: cover; }

        .profile-info { flex: 1; }

        .profile-info h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.2rem;
        }

        .profile-info .email {
            font-size: 0.85rem;
            color: #6b7280;
        }

        .profile-badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.6rem;
            background: #eef1ff;
            color: #3b6bff;
            border-radius: 20px;
            font-weight: 500;
            margin-top: 0.5rem;
            display: inline-block;
        }

        /* Upload imagen propio perfil */
        .upload-form-inline {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .upload-label-sm {
            padding: 0.35rem 0.75rem;
            border: 1.5px dashed #d1d5db;
            border-radius: 6px;
            font-size: 0.78rem;
            color: #6b7280;
            cursor: pointer;
            transition: border-color 0.15s, color 0.15s;
            white-space: nowrap;
        }

        .upload-label-sm:hover { border-color: #3b6bff; color: #3b6bff; }

        /* Mensajes inline */
        .msg-ok  { font-size: 0.8rem; color: #16a34a; }
        .msg-err { font-size: 0.8rem; color: #dc2626; }

        /* ── Publicaciones ── */
        .section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 0.75rem;
        }

        /* Formulario de publicación */
        .post-form-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .post-form-card textarea {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.75rem 0.9rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            color: #1a1d23;
            background: #fafafa;
            resize: vertical;
            min-height: 80px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .post-form-card textarea:focus {
            border-color: #3b6bff;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59,107,255,0.1);
        }

        .post-form-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 0.75rem;
        }

        .btn-post {
            padding: 0.55rem 1.25rem;
            background: #1e2235;
            border: none;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            color: #fff;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-post:hover { background: #2d3450; }

        /* Lista de publicaciones */
        .pub-list { display: flex; flex-direction: column; gap: 1rem; }

        .pub-item {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 1.1rem 1.5rem;
        }

        .pub-header {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 0.65rem;
        }

        .pub-name { font-size: 0.88rem; font-weight: 600; }

        .pub-date {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-left: auto;
        }

        .pub-msg {
            font-size: 0.88rem;
            color: #374151;
            line-height: 1.6;
            word-break: break-word;
        }

        .empty-state {
            text-align: center;
            padding: 2.5rem 1rem;
            color: #9ca3af;
            font-size: 0.88rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }

        .empty-state .icon { font-size: 2rem; margin-bottom: 0.5rem; }

        /* Mensajes de alerta */
        .alert {
            padding: 0.65rem 1rem;
            border-radius: 8px;
            font-size: 0.83rem;
            margin-bottom: 1rem;
        }

        .alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-error   { background: #fff5f5; color: #b91c1c; border: 1px solid #fecaca; }

        @media (max-width: 768px) {
            .main-layout { flex-direction: column; padding: 0 1rem; }
            .sidebar { width: 100%; }
            .profile-card { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

<!-- Topbar -->
<nav class="topbar">
    <a class="topbar-brand" href="perfil.php">
        <div class="brand-dot">&#9671;</div>
        <span class="brand-name">RedSocial</span>
    </a>
    <div class="topbar-right">
        <span class="topbar-user">Hola, <strong><?= $mi_nombre ?></strong></span>
        <form action="logout.php" method="POST" style="display:inline;">
            <button type="submit" class="btn-logout-top">Cerrar sesión</button>
        </form>
    </div>
</nav>

<!-- Layout -->
<div class="main-layout">

    <!-- Sidebar: Lista de usuarios -->
    <aside class="sidebar">
        <div class="card">
            <div class="card-header">👥 Usuarios registrados</div>
            <ul class="user-list">
                <?php while ($u = $todos->fetch_assoc()): ?>
                <li>
                    <a href="perfil.php?id=<?= $u['id'] ?>"
                       class="<?= ($u['id'] == $ver_id) ? 'active' : '' ?>">
                        <div class="user-avatar-sm">
                            <?php if ($u['imagen'] && file_exists($u['imagen'])): ?>
                                <img src="<?= htmlspecialchars($u['imagen']) ?>" alt="">
                            <?php else: ?>
                                &#128100;
                            <?php endif; ?>
                        </div>
                        <?= htmlspecialchars($u['usr_name']) ?>
                        <?php if ($u['id'] == (int)$_SESSION['usuario_id']): ?>
                            <span style="font-size:0.7rem;color:#9ca3af;margin-left:auto;">tú</span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </aside>

    <!-- Contenido principal -->
    <main class="content">

        <!-- Alertas -->
        <?php if (isset($_GET['registered'])): ?>
            <div class="alert alert-success">¡Bienvenido/a! Tu cuenta fue creada correctamente.</div>
        <?php endif; ?>
        <?php if (isset($_GET['upload']) && $_GET['upload'] === 'ok'): ?>
            <div class="alert alert-success">Foto de perfil actualizada.</div>
        <?php elseif (isset($_GET['upload']) && $_GET['upload'] === 'error'): ?>
            <div class="alert alert-error">Error al subir la imagen. Verificá el formato y tamaño (máx. 2MB).</div>
        <?php endif; ?>
        <?php if (isset($_GET['post']) && $_GET['post'] === 'ok'): ?>
            <div class="alert alert-success">Publicación enviada.</div>
        <?php elseif (isset($_GET['post']) && $_GET['post'] === 'vacio'): ?>
            <div class="alert alert-error">El mensaje no puede estar vacío.</div>
        <?php endif; ?>

        <!-- Tarjeta de perfil -->
        <div class="profile-card">
            <div class="avatar-lg">
                <?php if ($perfil['imagen'] && file_exists($perfil['imagen'])): ?>
                    <img src="<?= htmlspecialchars($perfil['imagen']) ?>" alt="Avatar">
                <?php else: ?>
                    &#128100;
                <?php endif; ?>
            </div>

            <div class="profile-info">
                <h2><?= htmlspecialchars($perfil['usr_name']) ?></h2>
                <div class="email">✉ <?= htmlspecialchars($perfil['usr_email']) ?></div>
                <span class="profile-badge">
                    <?= $es_propio ? '● Mi perfil' : '👤 Perfil de usuario' ?>
                </span>

                <!-- Cambiar foto solo en perfil propio -->
                <?php if ($es_propio): ?>
                <form action="subida_proceso.php" method="POST" enctype="multipart/form-data"
                      style="margin-top:0.75rem;">
                    <div class="upload-form-inline">
                        <label class="upload-label-sm" for="img-up">📷 Cambiar foto</label>
                        <input type="file" id="img-up" name="imagen_usuario"
                               accept="image/*" style="display:none;"
                               onchange="this.form.submit()">
                        <span id="img-name" style="font-size:0.78rem;color:#9ca3af;"></span>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- Formulario de publicación (solo en perfil propio) -->
        <?php if ($es_propio): ?>
        <div class="post-form-card">
            <div class="section-title">✏️ Nueva publicación</div>
            <form action="publicacion_proceso.php" method="POST"
                  onsubmit="return validarPost()">
                <textarea id="mensaje" name="mensaje"
                          placeholder="¿Qué estás pensando, <?= htmlspecialchars($perfil['usr_name']) ?>?"></textarea>
                <div class="post-form-footer">
                    <button type="submit" class="btn-post">Publicar</button>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <!-- Publicaciones -->
        <div class="section-title">
            📝 Publicaciones de <?= htmlspecialchars($perfil['usr_name']) ?>
        </div>

        <?php if ($publicaciones->num_rows > 0): ?>
        <div class="pub-list">
            <?php while ($pub = $publicaciones->fetch_assoc()): ?>
            <div class="pub-item">
                <div class="pub-header">
                    <div class="user-avatar-sm">
                        <?php if ($perfil['imagen'] && file_exists($perfil['imagen'])): ?>
                            <img src="<?= htmlspecialchars($perfil['imagen']) ?>" alt="">
                        <?php else: ?>
                            &#128100;
                        <?php endif; ?>
                    </div>
                    <span class="pub-name"><?= htmlspecialchars($perfil['usr_name']) ?></span>
                    <span class="pub-date">
                        <?= date('d/m/Y H:i', strtotime($pub['creado_en'])) ?>
                    </span>
                </div>
                <div class="pub-msg"><?= nl2br(htmlspecialchars($pub['mensaje'])) ?></div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <div class="icon">📭</div>
            <?= $es_propio
                ? 'Todavía no publicaste nada. ¡Sé el primero!'
                : 'Este usuario aún no tiene publicaciones.' ?>
        </div>
        <?php endif; ?>

    </main>
</div>

<script>
    function validarPost() {
        const msg = document.getElementById('mensaje').value.trim();
        if (!msg) {
            alert('El mensaje no puede estar vacío.');
            return false;
        }
        return true;
    }

    // Mostrar nombre del archivo seleccionado
    const imgInput = document.getElementById('img-up');
    if (imgInput) {
        imgInput.addEventListener('change', function() {
            const label = document.getElementById('img-name');
            if (this.files[0]) label.textContent = this.files[0].name;
        });
    }
</script>

</body>
</html>
