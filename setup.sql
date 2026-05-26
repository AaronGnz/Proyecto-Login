-- ============================================================
-- setup.sql — Estructura de la base de datos
-- Ejecutá este archivo UNA sola vez en phpMyAdmin o MySQL CLI
-- ============================================================

CREATE DATABASE IF NOT EXISTS base_usuarios
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE base_usuarios;

-- Tabla de usuarios (exactamente como pide la consigna)
CREATE TABLE IF NOT EXISTS base_usuarios.usuario (
  id        INT(11)      NOT NULL AUTO_INCREMENT,
  usr_name  VARCHAR(100) NOT NULL,
  usr_email VARCHAR(100) UNIQUE NOT NULL,
  usr_pass  VARCHAR(100) NOT NULL,
  imagen    VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de publicaciones (opcional requerida por la consigna)
CREATE TABLE IF NOT EXISTS base_usuarios.publicacion (
  id          INT(11)      NOT NULL AUTO_INCREMENT,
  usuario_id  INT(11)      NOT NULL,
  mensaje     TEXT         NOT NULL,
  creado_en   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY fk_pub_usuario (usuario_id),
  CONSTRAINT fk_pub_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuario (id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
