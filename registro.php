<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
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
            max-width: 980px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 40px rgba(0,0,0,0.10);
            margin: 2rem 1rem;
        }

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

        .panel-right {
            flex: 1;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2.5rem 2.5rem;
            overflow-y: auto;
        }

        .form-header { margin-bottom: 1.5rem; }

        .form-header h1 {
            font-size: 1.45rem;
            font-weight: 600;
            color: #1a1d23;
            margin-bottom: 0.35rem;
        }

        .form-header p { font-size: 0.875rem; color: #6b7280; }

        .form-group { margin-bottom: 1.1rem; }

        label {
            display: block;
            font-size: 0.75rem;
            font-weight: 500;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 0.45rem;
        }

        .input-wrap { position: relative; }

        .input-icon {
            position: absolute;
            left: 12px; top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 14px;
            pointer-events: none;
            font-style: normal;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.65rem 0.9rem 0.65rem 2.4rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            color: #1a1d23;
            background: #fafafa;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
            outline: none;
        }

        input:focus {
            border-color: #3b6bff;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59,107,255,0.1);
        }

        /* Avatar preview */
        .avatar-upload-wrap {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        #avatar-preview {
            width: 60px; height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e5e7eb;
            background: #f0f2f8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: #9ca3af;
            flex-shrink: 0;
            overflow: hidden;
        }

        #avatar-preview img { width: 100%; height: 100%; object-fit: cover; }

        .upload-btn-label {
            flex: 1;
            display: block;
            padding: 0.65rem 1rem;
            border: 1.5px dashed #d1d5db;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            font-size: 0.82rem;
            color: #6b7280;
            transition: border-color 0.15s, background 0.15s;
        }

        .upload-btn-label:hover {
            border-color: #3b6bff;
            background: #f5f7ff;
            color: #3b6bff;
        }

        #imagen_perfil { display: none; }

        /* Requisitos de contraseña */
        .req-list {
            margin-top: 6px;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .req-item {
            font-size: 0.73rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .req-item .req-icon {
            width: 13px; height: 13px;
            border-radius: 50%;
            border: 1.5px solid #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            flex-shrink: 0;
            transition: background 0.2s, border-color 0.2s;
        }

        .req-item.ok { color: #16a34a; }
        .req-item.ok .req-icon { background: #16a34a; border-color: #16a34a; color: #fff; }
        .req-item.bad { color: #dc2626; }
        .req-item.bad .req-icon { background: #dc2626; border-color: #dc2626; color: #fff; }

        .match-hint {
            font-size: 0.73rem;
            margin-top: 4px;
            height: 16px;
            letter-spacing: 0.02em;
        }

        .match-hint.ok  { color: #16a34a; }
        .match-hint.bad { color: #dc2626; }

        .btn-submit {
            width: 100%;
            padding: 0.8rem;
            background: #1e2235;
            border: none;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            color: #ffffff;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s, opacity 0.15s;
            margin-top: 0.5rem;
            letter-spacing: 0.02em;
        }

        .btn-submit:hover:not(:disabled) { background: #2d3450; }
        .btn-submit:active:not(:disabled) { transform: scale(0.99); }
        .btn-submit:disabled { opacity: 0.45; cursor: not-allowed; }

        .error-box {
            background: #fff5f5;
            border: 1px solid #fecaca;
            border-left: 3px solid #ef4444;
            border-radius: 6px;
            padding: 0.65rem 0.9rem;
            font-size: 0.83rem;
            color: #b91c1c;
            margin-bottom: 1.1rem;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.25rem 0 1rem;
            color: #d1d5db;
            font-size: 0.8rem;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .login-link {
            text-align: center;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .login-link a {
            color: #3b6bff;
            font-weight: 500;
            text-decoration: none;
        }

        .login-link a:hover { text-decoration: underline; }

        @media (max-width: 640px) {
            .panel-left { display: none; }
            .panel-right { padding: 2rem 1.5rem; border-radius: 16px; }
            .page-wrapper { border-radius: 16px; }
        }
    </style>
</head>
<body>
<div class="page-wrapper">

    <div class="panel-left">
        <div class="brand-mark">&#9671;</div>
        <h2>Creá tu cuenta en segundos</h2>
        <p>Registrate para acceder a la plataforma con autenticación segura.</p>
        <ul class="feature-list">
            <li>Registro rápido y sin complicaciones</li>
            <li>Contraseñas cifradas con bcrypt</li>
            <li>Acceso inmediato tras el registro</li>
        </ul>
    </div>

    <div class="panel-right">
        <div class="form-header">
            <h1>Crear cuenta</h1>
            <p>Completá los datos para registrarte</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
        <div class="error-box">
            <?php
                $err = $_GET['error'];
                if ($err === 'vacio')        echo 'Completá todos los campos obligatorios.';
                elseif ($err === 'email')    echo 'Ingresá un correo electrónico válido.';
                elseif ($err === 'no_coinciden') echo 'Las contraseñas no coinciden.';
                elseif ($err === 'email_existe') echo 'Ese correo electrónico ya está registrado.';
                elseif ($err === 'pass_debil')   echo 'La contraseña no cumple los requisitos mínimos.';
                elseif ($err === 'imagen')       echo 'Formato de imagen no permitido (JPG, PNG, GIF, WEBP).';
                else echo htmlspecialchars($err);
            ?>
        </div>
        <?php endif; ?>

        <form action="registro_proceso.php" method="POST" enctype="multipart/form-data" autocomplete="off" id="reg-form">

            <div class="form-group">
                <label for="usr_name">Nombre completo</label>
                <div class="input-wrap">
                    <i class="input-icon">✎</i>
                    <input type="text" id="usr_name" name="usr_name"
                           placeholder="Tu nombre completo" required autocomplete="off"
                           value="<?= htmlspecialchars($_GET['usr_name'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="usr_email">Correo electrónico</label>
                <div class="input-wrap">
                    <i class="input-icon">@</i>
                    <input type="email" id="usr_email" name="usr_email"
                           placeholder="tu@correo.com" required autocomplete="off"
                           value="<?= htmlspecialchars($_GET['usr_email'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Imagen de perfil <span style="color:#9ca3af;font-size:0.7rem;">(opcional)</span></label>
                <div class="avatar-upload-wrap">
                    <div id="avatar-preview">&#128100;</div>
                    <label class="upload-btn-label" for="imagen_perfil">
                        📷 Elegir imagen...
                    </label>
                    <input type="file" id="imagen_perfil" name="imagen_perfil"
                           accept="image/jpeg,image/png,image/gif,image/webp"
                           onchange="previewAvatar(this)">
                </div>
            </div>

            <div class="form-group">
                <label for="usr_pass">Contraseña</label>
                <div class="input-wrap">
                    <i class="input-icon">*</i>
                    <input type="password" id="usr_pass" name="usr_pass"
                           placeholder="••••••••" required oninput="checkReqs(); checkMatch();">
                </div>
                <div class="req-list">
                    <div class="req-item" id="req-length">
                        <span class="req-icon"></span>
                        Mínimo 8 caracteres
                    </div>
                    <div class="req-item" id="req-upper">
                        <span class="req-icon"></span>
                        Al menos una letra mayúscula
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="usr_pass2">Confirmar contraseña</label>
                <div class="input-wrap">
                    <i class="input-icon">*</i>
                    <input type="password" id="usr_pass2" name="usr_pass2"
                           placeholder="••••••••" required oninput="checkMatch()">
                </div>
                <div class="match-hint" id="match-hint"></div>
            </div>

            <button type="submit" class="btn-submit" id="btn-submit" disabled>Registrarse</button>
        </form>

        <div class="divider">o</div>

        <p class="login-link">
            ¿Ya tenés cuenta? <a href="login.php">Iniciar sesión</a>
        </p>
    </div>

</div>

<script>
    function previewAvatar(input) {
        const preview = document.getElementById('avatar-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.innerHTML = '<img src="' + e.target.result + '" alt="preview">';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function checkReqs() {
        const p = document.getElementById('usr_pass').value;
        const okLength = p.length >= 8;
        const okUpper  = /[A-Z]/.test(p);
        setReq('req-length', okLength, p.length > 0);
        setReq('req-upper',  okUpper,  p.length > 0);
        updateBtn();
    }

    function setReq(id, ok, touched) {
        const el   = document.getElementById(id);
        const icon = el.querySelector('.req-icon');
        el.classList.remove('ok', 'bad');
        icon.textContent = '';
        if (!touched) return;
        if (ok) { el.classList.add('ok'); icon.textContent = '✓'; }
        else    { el.classList.add('bad'); icon.textContent = '✗'; }
    }

    function checkMatch() {
        const p1   = document.getElementById('usr_pass').value;
        const p2   = document.getElementById('usr_pass2').value;
        const hint = document.getElementById('match-hint');
        hint.textContent = '';
        hint.className   = 'match-hint';
        if (!p2) { updateBtn(); return; }
        if (p1 === p2) {
            hint.textContent = '✓ Las contraseñas coinciden';
            hint.className   = 'match-hint ok';
        } else {
            hint.textContent = '✗ No coinciden';
            hint.className   = 'match-hint bad';
        }
        updateBtn();
    }

    function updateBtn() {
        const name    = document.getElementById('usr_name').value.trim();
        const email   = document.getElementById('usr_email').value.trim();
        const p1      = document.getElementById('usr_pass').value;
        const p2      = document.getElementById('usr_pass2').value;
        const okLen   = p1.length >= 8;
        const okUpper = /[A-Z]/.test(p1);
        const okMatch = p1 === p2 && p2 !== '';
        const okName  = name.length > 0;
        const okEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        document.getElementById('btn-submit').disabled = !(okLen && okUpper && okMatch && okName && okEmail);
    }


    document.getElementById('usr_name').addEventListener('input', updateBtn);
    document.getElementById('usr_email').addEventListener('input', updateBtn);
</script>
</body>
</html>
