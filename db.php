<?php
// ============================================================
// db.php — Conexión a la base de datos
// ============================================================

define('DB_HOST',    'localhost');
define('DB_USER',    'root');          // <-- cambiá por tu usuario
define('DB_PASS',    '');              // <-- cambiá por tu contraseña
define('DB_NAME',    'nueva_db');
define('DB_CHARSET', 'utf8mb4');

function getConexion(): mysqli {
    static $conn = null;

    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($conn->connect_error) {
            // En producción: logueá el error en vez de mostrarlo
            error_log("Error de conexión: " . $conn->connect_error);
            die(json_encode(['error' => 'No se pudo conectar a la base de datos.']));
        }

        $conn->set_charset(DB_CHARSET);
    }

    return $conn;
}
