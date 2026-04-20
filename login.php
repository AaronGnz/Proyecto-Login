<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
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
    <title>Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Nunito', sans-serif;
            background: #f0f4ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image:
                radial-gradient(circle at 20% 20%, #d6e6ff 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, #ffd6f0 0%, transparent 50%),
                radial-gradient(circle at 60% 10%, #d6ffd6 0%, transparent 40%);
        }

        .container {
            width: 100%;
            max-width: 420px;
            padding: 1.5rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 8px 32px rgba(100, 100, 180, 0.08);
        }

        .logo-area {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #a8c8ff, #d4a8ff);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 28px;
        }

        h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #3d3580;
            letter-spacing: -0.3px;
        }

        .subtitle {
            font-size: 0.9rem;
            color: #8b8fa8;
            margin-top: 0.3rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #5c5f7a;
            margin-bottom: 0.45rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e2e4f0;
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-size: 0.95rem;
            color: #3d3580;
            background: #f8f9ff;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }

        input:focus {
            border-color: #a8c8ff;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(168, 200, 255, 0.2);
        }

        .btn-primary {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, #a8c8ff, #c4a8ff);
            border: none;
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: #3d3580;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
            margin-top: 0.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(168, 200, 255, 0.5);
            opacity: 0.95;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .error-msg {
            background: #fff0f3;
            border: 1px solid #ffc4ce;
            border-radius: 10px;
            padding: 0.7rem 1rem;
            font-size: 0.85rem;
            color: #c0384e;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .divider {
            text-align: center;
            margin: 1.2rem 0;
            color: #b0b4cc;
            font-size: 0.85rem;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 38%;
            height: 1px;
            background: #e2e4f0;
        }

        .divider::before { left: 0; }
        .divider::after { right: 0; }

        .link-register {
            text-align: center;
            font-size: 0.9rem;
            color: #8b8fa8;
        }

        .link-register a {
            color: #7b6fd4;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .link-register a:hover {
            color: #5c50b0;
            text-decoration: underline;
        }

        .forgot {
            text-align: right;
            margin-top: 0.3rem;
        }

        .forgot a {
            font-size: 0.82rem;
            color: #a8a4cc;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot a:hover {
            color: #7b6fd4;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="logo-area">
            <div class="logo-icon">🌸</div>
            <h1>¡Bienvenido!</h1>
            <p class="subtitle">Ingresá tus datos para continuar</p>
        </div>

        <?php if ($error): ?>
        <div class="error-msg">
            ⚠️
            <?php
                if ($error === 'credenciales') echo 'Usuario o contraseña incorrectos.';
                elseif ($error === 'campos') echo 'Por favor completá todos los campos.';
                else echo htmlspecialchars($error);
            ?>
        </div>
        <?php endif; ?>

        <form action="login_proceso.php" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario o email</label>
                <input type="text" id="usuario" name="usuario" placeholder="tucorreo@ejemplo.com" required>
            </div>

            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="••••••••" required>
                <div class="forgot"><a href="#">¿Olvidaste tu contraseña?</a></div>
            </div>

            <button type="submit" class="btn-primary">Iniciar sesión ✨</button>
        </form>

        <div class="divider">o</div>

        <p class="link-register">
            ¿No tenés cuenta? <a href="registro.php">Registrate gratis</a>
        </p>
    </div>
</div>
</body>
</html>
