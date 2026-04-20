-- ============================================================
-- setup.sql — Estructura de la base de datos
-- Ejecutá este archivo una sola vez para crear todo
-- ============================================================

CREATE DATABASE IF NOT EXISTS nueva_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE nueva_db;

-- -----------------------------------------------------------
-- Tabla: usuarios
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
    id           INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    usuario      VARCHAR(50)     NOT NULL,
    email        VARCHAR(120)    NOT NULL,
    contrasena   VARCHAR(255)    NOT NULL,   -- siempre guardar con password_hash()
    nombre       VARCHAR(100)    NOT NULL DEFAULT '',
    avatar       VARCHAR(255)    NULL,
    activo       TINYINT(1)      NOT NULL DEFAULT 1,
    creado_en    DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_usuario (usuario),
    UNIQUE KEY uq_email   (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- Tabla: sesiones  (opcional — para auditoría de logins)
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS sesiones (
    id           INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    usuario_id   INT UNSIGNED    NOT NULL,
    ip           VARCHAR(45)     NOT NULL,
    user_agent   VARCHAR(255)    NULL,
    creado_en    DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    KEY fk_sesiones_usuario (usuario_id),
    CONSTRAINT fk_sesiones_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------
-- Usuario de prueba  (contraseña: 123456)
-- Para generar otro hash en PHP: echo password_hash('tupass', PASSWORD_DEFAULT);
-- -----------------------------------------------------------
INSERT INTO usuarios (usuario, email, contrasena, nombre)
VALUES (
    'admin',
    'admin@ejemplo.com',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Administrador'
)
ON DUPLICATE KEY UPDATE id = id;
