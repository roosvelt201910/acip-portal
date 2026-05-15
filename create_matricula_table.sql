-- Tabla para información de matrícula
CREATE TABLE IF NOT EXISTS matricula_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    key_name VARCHAR(50) NOT NULL UNIQUE, -- Identificador único (ej: 'cronograma', 'costos')
    titulo VARCHAR(255) NOT NULL,       -- Título de la sección
    contenido LONGTEXT,                 -- Contenido HTML rico
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar secciones por defecto si no existen
INSERT IGNORE INTO matricula_info (key_name, titulo, contenido) VALUES 
('proceso', 'Proceso de Matrícula', '<p>Información sobre el proceso de matrícula...</p>'),
('cronograma', 'Cronograma de Matrícula', '<p>Detalle del cronograma...</p>'),
('costos', 'Costo de Matrícula', '<p>Detalle de costos (Regular y Extemporáneo)...</p>'),
('requisitos_primera', 'Requisitos para Matricular por Primera Vez', '<p>Lista de requisitos...</p>'),
('matricula_ingresantes', 'Matrícula para Ingresantes', '<p>Información para ingresantes (Ordinaria y Extraordinaria)...</p>'),
('exonerados', 'Matrícula Exonerados por Víctima de Violencia Social', '<p>Información para exonerados...</p>'),
('ratificacion', 'Requisitos para Ratificación de Matrícula', '<p>Requisitos para ratificación...</p>'),
('ciclos_mayores', 'Para Ciclos Mayores', '<p>Información para ciclos mayores...</p>');
