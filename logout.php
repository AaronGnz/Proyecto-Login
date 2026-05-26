<?php
// ============================================================
// logout.php — Controlador: cerrar sesión
// ============================================================
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
