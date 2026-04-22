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
            max-width: 960px;
            min-height: 560px;
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
            padding: 3rem 2.5rem;
        }

        .form-header { margin-bottom: 2rem; }

        .form-header h1 {
            font-size: 1.45rem;
            font-weight: 600;
            color: #1a1d23;
            margin-bottom: 0.35rem;
        }

        .form-header p { font-size: 0.875rem; color: #6b7280; }

        .form-group { margin-bottom: 1.25rem; }

        label {
            display: block;
            font-size: 0.75rem;
            font-weight: 500;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 0.5rem;
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
        input[type="password"] {
            width: 100%;
            padding: 0.7rem 0.9rem 0.7rem 2.4rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
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

        /* Requisitos de contraseña */
        .req-list {
            margin-top: 8px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .req-item {
            font-size: 0.75rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .req-item .req-icon {
            width: 14px; height: 14px;
            border-radius: 50%;
            border: 1.5px solid #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            flex-shrink: 0;
            transition: background 0.2s, border-color 0.2s;
        }

        .req-item.ok { color: #16a34a; }
        .req-item.ok .req-icon {
            background: #16a34a;
            border-color: #16a34a;
            color: #fff;
        }

        .req-item.bad { color: #dc2626; }
        .req-item.bad .req-icon {
            background: #dc2626;
            border-color: #dc2626;
            color: #fff;
        }

        .match-hint {
            font-size: 0.75rem;
            margin-top: 5px;
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
            margin-bottom: 1.25rem;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.5rem 0 1.25rem;
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
                if ($_GET['error'] === 'vacio')          echo 'Completá todos los campos.';
                if ($_GET['error'] === 'no_coinciden')   echo 'Las contraseñas no coinciden.';
                if ($_GET['error'] === 'existe')         echo 'Ese nombre de usuario ya está registrado.';
                if ($_GET['error'] === 'pass_debil')     echo 'La contraseña no cumple los requisitos mínimos.';
            ?>
        </div>
        <?php endif; ?>

        <form action="registro_proceso.php" method="POST" autocomplete="off" id="reg-form">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <div class="input-wrap">
                    <i class="input-icon">@</i>
                    <input type="text" id="usuario" name="usuario"
                           placeholder="elegí un nombre de usuario" required autocomplete="off"
                           value="<?= htmlspecialchars($_GET['usuario'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="reg-pass">Contraseña</label>
                <div class="input-wrap">
                    <i class="input-icon">*</i>
                    <input type="password" id="reg-pass" name="password"
                           placeholder="••••••••" required oninput="checkReqs(); checkMatch();">
                </div>
                <!-- Requisitos visuales -->
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
                <label for="reg-pass2">Confirmar contraseña</label>
                <div class="input-wrap">
                    <i class="input-icon">*</i>
                    <input type="password" id="reg-pass2" name="password2"
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
    function checkReqs() {
        const p = document.getElementById('reg-pass').value;

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
        if (ok) {
            el.classList.add('ok');
            icon.textContent = '✓';
        } else {
            el.classList.add('bad');
            icon.textContent = '✗';
        }
    }

    function checkMatch() {
        const p1   = document.getElementById('reg-pass').value;
        const p2   = document.getElementById('reg-pass2').value;
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
        const p1      = document.getElementById('reg-pass').value;
        const p2      = document.getElementById('reg-pass2').value;
        const okLen   = p1.length >= 8;
        const okUpper = /[A-Z]/.test(p1);
        const okMatch = p1 === p2 && p2 !== '';
        document.getElementById('btn-submit').disabled = !(okLen && okUpper && okMatch);
    }
</script>
</body>
</html>
