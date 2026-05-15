-- Create configuration table
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `site_title` varchar(255) DEFAULT 'Portal ACIP',
  `contact_email` varchar(255) DEFAULT 'contacto@acip.edu.pe',
  `contact_phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `maintenance_mode` tinyint(1) DEFAULT 0,
  `show_programs` tinyint(1) DEFAULT 1,
  `show_news` tinyint(1) DEFAULT 1,
  `show_events` tinyint(1) DEFAULT 1,
  `allow_registration` tinyint(1) DEFAULT 1,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default configuration
INSERT INTO `configuracion` (`id`, `site_title`, `contact_email`, `show_programs`, `show_news`, `show_events`, `allow_registration`) 
VALUES (1, 'Portal ACIP', 'contacto@acip.edu.pe', 1, 1, 1, 1)
ON DUPLICATE KEY UPDATE id=id;
