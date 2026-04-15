-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS mi_sistema CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mi_sistema;

-- Crear la tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    usuario  VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,          -- hash bcrypt, NO texto plano
    foto     VARCHAR(255) DEFAULT NULL,      -- ruta a la foto de perfil
    creado   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar un usuario de prueba con contraseña hasheada
-- Contraseña en texto plano: admin123
-- Genera el hash en PHP con: echo password_hash('admin123', PASSWORD_DEFAULT);
INSERT INTO usuarios (usuario, password) VALUES
('admin', '$2y$12$exampleHashAqui...');      -- reemplaza con un hash real

-- Para generar el hash desde la terminal PHP:
-- php -r "echo password_hash('admin123', PASSWORD_DEFAULT);"
