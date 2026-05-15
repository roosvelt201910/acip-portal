-- Crear tabla de avisos modales
CREATE TABLE IF NOT EXISTS avisos_modales (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    tipo_contenido ENUM('imagen', 'video', 'html') NOT NULL DEFAULT 'imagen',
    imagen VARCHAR(255) NULL,
    video_url TEXT NULL,
    contenido_html TEXT NULL,
    enlace_boton VARCHAR(255) NULL,
    texto_boton VARCHAR(100) NULL DEFAULT 'Más información',
    estado ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo',
    mostrar_una_vez BOOLEAN DEFAULT 0,
    fecha_inicio DATETIME NULL,
    fecha_fin DATETIME NULL,
    orden INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
