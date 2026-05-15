<?php


class AdminMatriculaController {
    private $db;
    
    public function __construct() {
        // Verificar autenticación
        if (!isAuthenticated() || !isAdmin()) {
            redirect(url('admin/login'));
        }
        
        $this->db = Database::getInstance();
    }
    
    public function index() {
        // Obtener toda la información de matrícula
        $info = $this->db->fetchAll("SELECT * FROM matricula_info ORDER BY order_index ASC");
        
        // Organizar en un array asociativo por key_name para fácil acceso en la vista
        $matriculaData = [];
        foreach ($info as $item) {
            $matriculaData[$item['key_name']] = $item;
        }
        
        // Manejar mensaje de feedback
        $success = $_SESSION['success'] ?? null;
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['success'], $_SESSION['error']); // Limpiar mensajes flash
        
        require APP_PATH . '/Views/admin/matricula/index.php';
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Handle Banner Upload
                if (isset($_FILES['banner_vertical']) && $_FILES['banner_vertical']['error'] === 0) {
                    $uploadDir = PUBLIC_PATH . '/uploads/banners/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                    
                    $ext = strtolower(pathinfo($_FILES['banner_vertical']['name'], PATHINFO_EXTENSION));
                    $filename = 'matricula_vertical_' . uniqid() . '.' . $ext;
                    $targetPath = $uploadDir . $filename;
                    
                    if (move_uploaded_file($_FILES['banner_vertical']['tmp_name'], $targetPath)) {
                        // Save path to DB
                        $this->saveOrUpdate('banner_vertical', 'uploads/banners/' . $filename);
                    }
                }

                // Handle Hero Image Upload
                if (isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] === 0) {
                    $uploadDir = PUBLIC_PATH . '/uploads/heroes/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                    
                    $ext = strtolower(pathinfo($_FILES['hero_image']['name'], PATHINFO_EXTENSION));
                    $filename = 'matricula_hero_' . uniqid() . '.' . $ext;
                    $targetPath = $uploadDir . $filename;
                    
                    if (move_uploaded_file($_FILES['hero_image']['tmp_name'], $targetPath)) {
                        // Save path to DB
                        $this->saveOrUpdate('hero_image', 'uploads/heroes/' . $filename);
                    }
                }

                // Iterar sobre los campos enviados y actualizar
                foreach ($_POST as $key => $content) {
                    // Ignorar token CSRF y campos del hero (estos se procesan por separado arriba)
                    if ($key === 'csrf_token') continue;
                    if (in_array($key, ['hero_type', 'hero_video_url', 'hero_image'])) {
                        // Para campos que NO son de CKEditor, guardar sin etiquetas HTML
                        $cleanContent = strip_tags(trim($content));
                        $this->saveOrUpdate($key, $cleanContent);
                        continue;
                    }
                    
                    $this->saveOrUpdate($key, $content);
                }
                
                $_SESSION['success'] = 'Información actualizada correctamente.';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Error al actualizar: ' . $e->getMessage();
            }
            
            header('Location: ' . url('admin/matricula'));
            exit;
        }
    }

    private function saveOrUpdate($key, $content) {
        // Verificar si la key existe en la base de datos
        $exists = $this->db->fetchOne("SELECT id FROM matricula_info WHERE key_name = :key", [':key' => $key]);
        
        if ($exists) {
            $this->db->update(
                'matricula_info',
                ['contenido' => $content],
                'key_name = :key',
                [':key' => $key]
            );
        } else {
            // Generar título apropiado según el key
            $titles = [
                'hero_type' => 'Tipo de Hero',
                'hero_image' => 'Imagen del Hero',
                'hero_video_url' => 'Video del Hero',
                'banner_vertical' => 'Banner Vertical'
            ];
            $titulo = $titles[$key] ?? ucfirst(str_replace('_', ' ', $key));
            
            $this->db->insert(
                'matricula_info',
                [
                    'key_name' => $key, 
                    'titulo' => $titulo, 
                    'contenido' => $content,
                    'order_index' => 999 // Al final para que no interfiera con el orden existente
                ]
            );
        }
    }
    public function updateOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            if (isset($input['order']) && is_array($input['order'])) {
                try {
                    foreach ($input['order'] as $index => $keyName) {
                        $this->db->update(
                            'matricula_info',
                            ['order_index' => $index + 1],
                            'key_name = :key',
                            [':key' => $keyName]
                        );
                    }
                    echo json_encode(['success' => true]);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Invalid data']);
            }
            exit;
        }
    }
}
