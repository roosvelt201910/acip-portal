<?php
class ConfiguracionController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
        if (!isAuthenticated()) redirect(url('admin/login'));
    }
    
    public function index() {
        // Get all configuration as key-value pairs
        $configRows = $this->db->fetchAll("SELECT clave, valor FROM configuracion");
        $config = [];
        foreach ($configRows as $row) {
            $config[$row['clave']] = $row['valor'];
        }
        
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Update each configuration value
            $updates = [
                'site_title' => $_POST['site_title'] ?? '',
                'site_description' => $_POST['site_description'] ?? '',
                'site_about_snippet' => $_POST['site_about_snippet'] ?? '',
                'site_email' => $_POST['site_email'] ?? '',
                'site_phone' => $_POST['site_phone'] ?? '',
                'site_direccion' => $_POST['site_direccion'] ?? '',
                'site_horario' => $_POST['site_horario'] ?? '',
                'site_map_embed' => $_POST['site_map_embed'] ?? '',
                'redes_facebook' => $_POST['redes_facebook'] ?? '',
                'redes_instagram' => $_POST['redes_instagram'] ?? '',
                'redes_youtube' => $_POST['redes_youtube'] ?? '',
                'redes_twitter' => $_POST['redes_twitter'] ?? '',
                'redes_tiktok' => $_POST['redes_tiktok'] ?? '',
                'whatsapp_numero' => $_POST['whatsapp_numero'] ?? '',
                'whatsapp_mensaje' => $_POST['whatsapp_mensaje'] ?? '',
                'seo_keywords' => $_POST['seo_keywords'] ?? '',
                'email_smtp_host' => $_POST['email_smtp_host'] ?? '',
                'email_smtp_port' => $_POST['email_smtp_port'] ?? '',
                'email_smtp_user' => $_POST['email_smtp_user'] ?? '',
                'mantenimiento_activo' => isset($_POST['mantenimiento_activo']) ? '1' : '0',
                // Home Page Welcome Section
                'home_welcome_title' => $_POST['home_welcome_title'] ?? '',
                'home_welcome_subtitle' => $_POST['home_welcome_subtitle'] ?? '',
                'home_welcome_description' => $_POST['home_welcome_description'] ?? '',
                'home_welcome_button_text' => $_POST['home_welcome_button_text'] ?? '',
                'home_welcome_button_url' => $_POST['home_welcome_button_url'] ?? '',
                'home_welcome_media_type' => $_POST['home_welcome_media_type'] ?? 'image',
                'home_welcome_video_url' => $_POST['home_welcome_video_url'] ?? '',
            ];
            
            // Handle Logo Upload
            if (!empty($_FILES['site_logo']['name'])) {
                $uploadDir = PUBLIC_PATH . '/uploads/config/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileExt = strtolower(pathinfo($_FILES['site_logo']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
                
                if (in_array($fileExt, $allowed)) {
                    $fileName = 'logo_' . time() . '.' . $fileExt;
                    $targetPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $targetPath)) {
                        $updates['site_logo'] = 'uploads/config/' . $fileName;
                    }
                }
            }
            
            // Handle Home Welcome Image Upload
            if (!empty($_FILES['home_welcome_image']['name'])) {
                $uploadDir = PUBLIC_PATH . '/uploads/config/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileExt = strtolower(pathinfo($_FILES['home_welcome_image']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                
                if (in_array($fileExt, $allowed)) {
                    $fileName = 'home_welcome_' . time() . '.' . $fileExt;
                    $targetPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['home_welcome_image']['tmp_name'], $targetPath)) {
                        $updates['home_welcome_image'] = 'uploads/config/' . $fileName;
                    }
                }
            }
            
            // Only update password if provided
            if (!empty($_POST['email_smtp_pass'])) {
                $updates['email_smtp_pass'] = $_POST['email_smtp_pass'];
            }
            
            foreach ($updates as $clave => $valor) {
                // Check if config exists
                $exists = $this->db->fetchOne(
                    "SELECT id FROM configuracion WHERE clave = ?",
                    [$clave]
                );
                
                if ($exists) {
                    // Update existing
                    $this->db->update(
                        'configuracion',
                        ['valor' => $valor],
                        'clave = :clave',
                        ['clave' => $clave]
                    );
                } else {
                    // Insert new
                    $this->db->insert('configuracion', [
                        'clave' => $clave,
                        'valor' => $valor,
                        'tipo' => 'texto',
                        'grupo' => 'general'
                    ]);
                }
            }
            
            $_SESSION['success'] = 'Configuración guardada exitosamente';
            redirect(url('admin/configuracion'));
            return;
        }
        
        $pageTitle = 'Configuración del Sitio';
        $currentPage = 'configuracion';
        require APP_PATH . '/Views/admin/configuracion/index.php';
    }
}
