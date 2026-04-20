<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap');

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Share Tech Mono', monospace;
            min-height: 100vh;
            background: #050508;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
        }

        /* fondo con vignette */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse at center, #0d0b14 30%, #020204 100%);
            z-index: 0;
        }

        .wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 380px;
        }

        /* título superior */
        .site-title {
            text-align: center;
            margin-bottom: 2rem;
        }

        .site-title h1 {
            font-family: 'Crimson Text', serif;
            font-size: 32px;
            font-weight: 600;
            color: #6a3a3a;
            letter-spacing: 6px;
            text-transform: uppercase;
        }

        .site-title p {
            font-size: 10px;
            color: #2a2030;
            letter-spacing: 5px;
            margin-top: 4px;
        }

        /* tabs */
        .tabs {
            display: flex;
            border-bottom: 1px solid #1a0f1f;
            margin-bottom: 0;
        }

        .tab {
            flex: 1;
            padding: 12px;
            text-align: center;
            font-size: 11px;
            letter-spacing: 3px;
            cursor: pointer;
            color: #3a2a40;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
            user-select: none;
        }

        .tab.active {
            color: #8a4a4a;
            border-bottom: 2px solid #6a2a2a;
        }

        /* card */
        .card {
            background: #0a0810;
            border: 1px solid #1a0f1f;
            border-top: none;
            padding: 2rem 1.8rem 2.2rem;
        }

        /* mensajes */
        .msg {
            font-size: 12px;
            padding: 10px 12px;
            border-radius: 2px;
            margin-bottom: 1.2rem;
            letter-spacing: 1px;
            display: none;
        }
        .msg.show { display: block; }
        .msg.error   { color: #b03030; background: rgba(100,20,20,0.2); border: 1px solid #3a1010; }
        .msg.success { color: #4a8a4a; background: rgba(20,60,20,0.2); border: 1px solid #103010; }

        /* campos */
        .field { margin-bottom: 1.1rem; }

        label {
            display: block;
            font-size: 10px;
            letter-spacing: 3px;
            color: #3a2a40;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            background: #06050c;
            border: 1px solid #1a0f1f;
            border-radius: 2px;
            color: #7a5a6a;
            font-family: 'Share Tech Mono', monospace;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, color 0.2s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #4a1a2a;
            color: #c09090;
        }

        input::placeholder { color: #1e1628; }

        /* indicador de coincidencia */
        .match-hint {
            font-size: 10px;
            letter-spacing: 2px;
            margin-top: 5px;
            height: 14px;
        }
        .match-hint.ok  { color: #4a8a4a; }
        .match-hint.bad { color: #8a2a2a; }

        /* botón */
        .btn {
            width: 100%;
            padding: 12px;
            background: #12080f;
            border: 1px solid #3a1520;
            border-radius: 2px;
            color: #7a3a3a;
            font-family: 'Share Tech Mono', monospace;
            font-size: 12px;
            letter-spacing: 4px;
            cursor: pointer;
            margin-top: 0.8rem;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
        }

        .btn:hover {
            background: #1e0c16;
            border-color: #6a2a2a;
            color: #b05050;
        }

        /* panel oculto */
        .panel { display: none; }
        .panel.active { display: block; }
    </style>
</head>
<body>
<div class="wrap">

    <div class="site-title">
        <h1>SANCTUM</h1>
        <p>sistema de acceso</p>
    </div>

    <div class="tabs">
        <div class="tab active" onclick="switchTab('login')">INGRESAR</div>
        <div class="tab" onclick="switchTab('registro')">REGISTRARSE</div>
    </div>

    <div class="card">

        <!-- ── LOGIN ── -->
        <div class="panel active" id="panel-login">

            <?php if (isset($_GET['error'])): ?>
                <div class="msg error show">
                    <?php
                        if ($_GET['error'] === 'credenciales') echo '// usuario o contraseña incorrectos';
                        if ($_GET['error'] === 'vacio')        echo '// completa todos los campos';
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['registered']) && $_GET['registered'] === '1'): ?>
                <div class="msg success show">// registro exitoso — puedes ingresar</div>
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
        </div>

        <!-- ── REGISTRO ── -->
        <div class="panel" id="panel-registro">

            <?php if (isset($_GET['reg_error'])): ?>
                <div class="msg error show">
                    <?php
                        if ($_GET['reg_error'] === 'vacio')        echo '// completa todos los campos';
                        if ($_GET['reg_error'] === 'no_coinciden') echo '// las contraseñas no coinciden';
                        if ($_GET['reg_error'] === 'existe')       echo '// ese usuario ya está registrado';
                    ?>
                </div>
            <?php endif; ?>

            <form action="registro_proceso.php" method="POST">
                <div class="field">
                    <label>usuario</label>
                    <input type="text" name="usuario" placeholder="_ _ _ _ _ _" required autocomplete="off">
                </div>
                <div class="field">
                    <label>contraseña</label>
                    <input type="password" name="password" id="reg-pass" placeholder="• • • • • • • •" required oninput="checkMatch()">
                </div>
                <div class="field">
                    <label>confirmar contraseña</label>
                    <input type="password" name="password2" id="reg-pass2" placeholder="• • • • • • • •" required oninput="checkMatch()">
                    <div class="match-hint" id="match-hint"></div>
                </div>
                <button type="submit" class="btn">[ REGISTRAR ]</button>
            </form>
        </div>

    </div>
</div>

<script>
    // Abrir en el tab correcto según parámetro GET
    const params = new URLSearchParams(window.location.search);
    if (params.has('reg_error') || params.get('tab') === 'registro') {
        switchTab('registro');
    }

    function switchTab(tab) {
        document.querySelectorAll('.tab').forEach((t, i) => {
            t.classList.toggle('active', (i === 0 && tab === 'login') || (i === 1 && tab === 'registro'));
        });
        document.getElementById('panel-login').classList.toggle('active', tab === 'login');
        document.getElementById('panel-registro').classList.toggle('active', tab === 'registro');
    }

    function checkMatch() {
        const p1 = document.getElementById('reg-pass').value;
        const p2 = document.getElementById('reg-pass2').value;
        const hint = document.getElementById('match-hint');
        if (!p2) { hint.textContent = ''; hint.className = 'match-hint'; return; }
        if (p1 === p2) { hint.textContent = '// coinciden'; hint.className = 'match-hint ok'; }
        else           { hint.textContent = '// no coinciden'; hint.className = 'match-hint bad'; }
    }
</script>
</body>
</html>
