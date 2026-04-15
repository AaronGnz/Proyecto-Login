<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #0f0e17; }
        .login-container { background: #1a1825; padding: 2.5rem 2rem; border-radius: 8px; border: 1px solid rgba(200,150,50,0.25); width: 340px; box-shadow: 0 0 40px rgba(180,60,20,0.08); }
        .logo { text-align: center; margin-bottom: 2rem; }
        .logo h2 { font-size: 22px; letter-spacing: 4px; color: #c89632; font-weight: 700; }
        .logo p { font-size: 11px; color: rgba(180,160,120,0.5); letter-spacing: 3px; text-transform: uppercase; margin-top: 4px; }
        .error { color: #e24b4a; background: rgba(226,75,74,0.1); border: 1px solid rgba(226,75,74,0.3); border-radius: 4px; font-size: 13px; padding: 10px 12px; margin-bottom: 1.2rem; text-align: center; }
        label { display: block; font-size: 11px; letter-spacing: 2px; color: rgba(180,160,120,0.6); text-transform: uppercase; margin-bottom: 6px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px 12px; margin-bottom: 1.2rem; background: rgba(10,8,20,0.8); border: 1px solid rgba(200,150,50,0.2); border-radius: 4px; color: #e0d5c5; font-size: 15px; outline: none; transition: border-color 0.2s; }
        input[type="text"]:focus, input[type="password"]:focus { border-color: rgba(200,150,50,0.6); }
        button { width: 100%; padding: 12px; background: linear-gradient(135deg, #8b3010, #c84820, #8b3010); border: 1px solid rgba(200,80,30,0.5); border-radius: 4px; color: #f5e0c5; font-size: 13px; letter-spacing: 3px; cursor: pointer; margin-top: 0.4rem; transition: opacity 0.2s; }
        button:hover { opacity: 0.85; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h2>Bienvenido</h2>
            <p>Valide su ingreso</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="error">
                <?php
                    if ($_GET['error'] === 'credenciales')  echo 'Usuario o contraseña incorrectos.';
                    if ($_GET['error'] === 'vacio')         echo 'Por favor, rellena todos los campos.';
                    if ($_GET['error'] === 'no_coinciden')  echo 'Las contraseñas no coinciden.'; 
                ?>
            </div>
        <?php endif; ?>

        <form action="login_proceso.php" method="POST">
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" placeholder="Ej: admin" required autocomplete="off">

            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" placeholder="••••••••" required>

            <label for="password2">Confirmar contraseña</label>
            <input type="password" name="password2" id="password2" placeholder="••••••••" required>

            <button type="submit">INGRESAR</button>
        </form>
    </div>
</body>
</html>