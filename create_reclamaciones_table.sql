-- Crear tabla de reclamaciones
CREATE TABLE IF NOT EXISTS `reclamaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_contacto` varchar(50) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `numero_documento` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `domicilio` text NOT NULL,
  `apoderado` varchar(255) DEFAULT NULL,
  `tipo_reclamo` varchar(50) NOT NULL,
  `detalle` text NOT NULL,
  `pedido` text NOT NULL,
  `estado` varchar(50) DEFAULT 'pendiente',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
