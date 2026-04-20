<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Crimson+Text:wght@400;600&display=swap');
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Share Tech Mono', monospace; min-height: 100vh; background: #050508; display: flex; justify-content: center; align-items: center; padding: 2rem 1rem; }
        body::before { content: ''; position: fixed; inset: 0; background: radial-gradient(ellipse at center, #0d0b14 30%, #020204 100%); z-index: 0; }
        .wrap { position: relative; z-index: 1; width: 100%; max-width: 360px; }
        .site-title { text-align: center; margin-bottom: 2rem; }
        .site-title h1 { font-family: 'Crimson Text', serif; font-size: 32px; font-weight: 600; color: #6a3a3a; letter-spacing: 6px; text-transform: uppercase; }
        .site-title p { font-size: 10px; color: #2a2030; letter-spacing: 5px; margin-top: 4px; }
        .card { background: #0a0810; border: 1px solid #1a0f1f; padding: 2rem 1.8rem 2.2rem; }
        .msg { font-size: 12px; padding: 10px 12px; margin-bottom: 1.2rem; letter-spacing: 1px; }
        .msg.error   { color: #b03030; background: rgba(100,20,20,0.2); border: 1px solid #3a1010; }
        .msg.success { color: #4a8a4a; background: rgba(20,60,20,0.2); border: 1px solid #103010; }
        .field { margin-bottom: 1.1rem; }
        label { display: block; font-size: 10px; letter-spacing: 3px; color: #3a2a40; margin-bottom: 6px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px 12px; background: #06050c; border: 1px solid #1a0f1f; border-radius: 2px; color: #7a5a6a; font-family: 'Share Tech Mono', monospace; font-size: 14px; outline: none; transition: border-color 0.2s, color 0.2s; }
        input:focus { border-color: #4a1a2a; color: #c09090; }
        input::placeholder { color: #1e1628; }
        .btn { width: 100%; padding: 12px; background: #12080f; border: 1px solid #3a1520; border-radius: 2px; color: #7a3a3a; font-family: 'Share Tech Mono', monospace; font-size: 12px; letter-spacing: 4px; cursor: pointer; margin-top: 0.8rem; transition: background 0.2s, color 0.2s, border-color 0.2s; }
        .btn:hover { background: #1e0c16; border-color: #6a2a2a; color: #b05050; }
        .register-link { text-align: center; margin-top: 1.2rem; font-size: 11px; color: #2a1a30; letter-spacing: 2px; }
        .register-link a { color: #5a3040; text-decoration: none; transition: color 0.2s; }
        .register-link a:hover { color: #8a4a5a; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="site-title">
        <h1>SANCTUM</h1>
        <p>sistema de acceso</p>
    </div>

    <div class="card">
        <?php if (isset($_GET['error'])): ?>
            <div class="msg error">
                <?php
                    if ($_GET['error'] === 'credenciales') echo '// usuario o contraseña incorrectos';
                    if ($_GET['error'] === 'vacio')        echo '// completa todos los campos';
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['registered'])): ?>
            <div class="msg success">// registro exitoso — puedes ingresar</div>
        <?php endif; ?>

        <form action="login_proceso.php" method="POST">
            <div class="field">
                <label>usuario</label>
                <input type="text" name="usuario" placeholder="_ _ _ _ _ _" required autocomplete="off">
            </div>
            <div class="field">
                <label>contraseña</label>
                <input type="password" name="password" placeholder="• • • • • • • •" required>
            </div>
            <button type="submit" class="btn">[ ENTRAR ]</button>
        </form>

        <div class="register-link">
            ¿no tienes cuenta? <a href="registro.php">registrarse</a>
        </div>
    </div>
</div>
</body>
</html>
