-- Verificar y actualizar tabla configuracion
-- Este script agrega las columnas faltantes si no existen

-- Agregar columnas si no existen
ALTER TABLE `configuracion` 
ADD COLUMN IF NOT EXISTS `contact_phone` varchar(50) DEFAULT NULL AFTER `contact_email`,
ADD COLUMN IF NOT EXISTS `address` text DEFAULT NULL AFTER `contact_phone`,
ADD COLUMN IF NOT EXISTS `facebook_url` varchar(255) DEFAULT NULL AFTER `address`,
ADD COLUMN IF NOT EXISTS `instagram_url` varchar(255) DEFAULT NULL AFTER `facebook_url`,
ADD COLUMN IF NOT EXISTS `youtube_url` varchar(255) DEFAULT NULL AFTER `instagram_url`,
ADD COLUMN IF NOT EXISTS `linkedin_url` varchar(255) DEFAULT NULL AFTER `youtube_url`,
ADD COLUMN IF NOT EXISTS `show_programs` tinyint(1) DEFAULT 1 AFTER `maintenance_mode`,
ADD COLUMN IF NOT EXISTS `show_news` tinyint(1) DEFAULT 1 AFTER `show_programs`,
ADD COLUMN IF NOT EXISTS `show_events` tinyint(1) DEFAULT 1 AFTER `show_news`,
ADD COLUMN IF NOT EXISTS `allow_registration` tinyint(1) DEFAULT 1 AFTER `show_events`;

-- Verificar que existe el registro principal
INSERT IGNORE INTO `configuracion` (`id`, `site_title`, `contact_email`, `show_programs`, `show_news`, `show_events`, `allow_registration`) 
VALUES (1, 'Portal ACIP', 'contacto@acip.edu.pe', 1, 1, 1, 1);
