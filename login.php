<?php
// ============================================================
// login.php — Vista: Formulario de inicio de sesión
// ============================================================
session_start();

if (!empty($_SESSION['usuario_id'])) {
    header("Location: perfil.php");
    exit();
}

$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
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

        .panel-left p { font-size: 0.9rem; color: #8b92a9; line-height: 1.7; }

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

        input[type="email"],
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
            transition: background 0.15s, transform 0.1s;
            margin-top: 0.5rem;
            letter-spacing: 0.02em;
        }

        .btn-submit:hover { background: #2d3450; }
        .btn-submit:active { transform: scale(0.99); }

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

        .success-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 3px solid #16a34a;
            border-radius: 6px;
            padding: 0.65rem 0.9rem;
            font-size: 0.83rem;
            color: #15803d;
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

        .register-link {
            text-align: center;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .register-link a {
            color: #3b6bff;
            font-weight: 500;
            text-decoration: none;
        }

        .register-link a:hover { text-decoration: underline; }

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
        <h2>Accedé a tu cuenta de forma segura</h2>
        <p>Plataforma de gestión con autenticación segura y control de acceso.</p>
        <ul class="feature-list">
            <li>Sesiones protegidas con PHP</li>
            <li>Contraseñas cifradas con bcrypt</li>
            <li>Acceso desde cualquier dispositivo</li>
        </ul>
    </div>

    <div class="panel-right">
        <div class="form-header">
            <h1>Iniciar sesión</h1>
            <p>Ingresá tus credenciales para continuar</p>
        </div>

        <?php if ($error): ?>
        <div class="error-box">
            <?php
                if ($error === 'credenciales') echo 'Correo o contraseña incorrectos.';
                elseif ($error === 'campos')    echo 'Completá todos los campos.';
                else echo htmlspecialchars($error);
            ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['registered'])): ?>
        <div class="success-box">¡Cuenta creada! Ya podés iniciar sesión.</div>
        <?php endif; ?>

        <form action="login_proceso.php" method="POST" autocomplete="off"
              onsubmit="return validarLogin()">
            <div class="form-group">
                <label for="usr_email">Correo electrónico</label>
                <div class="input-wrap">
                    <i class="input-icon">@</i>
                    <input type="email" id="usr_email" name="usr_email"
                           placeholder="tu@correo.com" required autocomplete="email">
                </div>
            </div>

            <div class="form-group">
                <label for="usr_pass">Contraseña</label>
                <div class="input-wrap">
                    <i class="input-icon">*</i>
                    <input type="password" id="usr_pass" name="usr_pass"
                           placeholder="••••••••" required autocomplete="current-password">
                </div>
            </div>

            <button type="submit" class="btn-submit">Ingresar</button>
        </form>

        <div class="divider">o</div>

        <p class="register-link">
            ¿No tenés cuenta? <a href="registro.php">Crear cuenta</a>
        </p>
    </div>

</div>

<script>
    // Validación cliente: campos vacíos
    function validarLogin() {
        const email = document.getElementById('usr_email').value.trim();
        const pass  = document.getElementById('usr_pass').value;
        if (!email || !pass) {
            alert('Completá todos los campos.');
            return false;
        }
        if (pass.length < 8) {
            alert('La contraseña debe tener al menos 8 caracteres.');
            return false;
        }
        return true;
    }
</script>
</body>
</html>
