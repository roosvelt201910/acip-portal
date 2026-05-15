<?php

class AdminBecasController {
    private $db;

    public function __construct() {
        if (!isAuthenticated() || !isAdmin()) {
            redirect(url('admin/login'));
        }
        $this->db = Database::getInstance();
    }

    public function index() {
        $becasData = $this->db->fetchAll("SELECT * FROM becas_info ORDER BY order_index ASC");
        
        $becas = [];
        foreach ($becasData as $item) {
            $becas[$item['key_name']] = $item;
        }

        require APP_PATH . '/Views/admin/becas/index.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Manejar campos de texto
                foreach ($_POST as $key => $content) {
                    if ($key === 'csrf_token') continue;
                    $this->updateContent($key, $content);
                }

                // Manejar subida de archivos
                if (!empty($_FILES)) {
                    foreach ($_FILES as $key => $file) {
                        if ($file['error'] === 0) {
                            $this->uploadFile($key, $file);
                        }
                    }
                }

                $_SESSION['success'] = 'Información actualizada correctamente.';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Error al actualizar: ' . $e->getMessage();
            }
            
            header('Location: ' . url('admin/becas'));
            exit;
        }
    }

    private function updateContent($key, $content) {
        $exists = $this->db->fetchOne("SELECT id FROM becas_info WHERE key_name = :key", [':key' => $key]);
        
        if ($exists) {
            $this->db->query(
                "UPDATE becas_info SET contenido = :content WHERE key_name = :key",
                [':content' => $content, ':key' => $key]
            );
        } else {
            $this->db->query(
                "INSERT INTO becas_info (key_name, titulo, contenido) VALUES (:key, :titulo, :content)",
                [':key' => $key, ':titulo' => ucfirst(str_replace('_', ' ', $key)), ':content' => $content]
            );
        }
    }
    
    private function uploadFile($key, $file) {
        $uploadDir = PUBLIC_PATH . '/uploads/becas/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $allowedTypes = ['application/pdf'];
        $errorMsg = "Solo se permiten archivos PDF para la clave: $key";

        if ($key === 'hero_image') {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $errorMsg = "Solo se permiten imágenes (JPG, PNG, WEBP) para el Hero";
        }
        
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception($errorMsg);
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $key . '_' . time() . '.' . $ext;
        $targetPath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $publicPath = 'uploads/becas/' . $filename;
            
            // Verificamos si existe el registro antes de actualizar
            $exists = $this->db->fetchOne("SELECT id FROM becas_info WHERE key_name = :key", [':key' => $key]);
            
            if ($exists) {
                $this->db->query(
                    "UPDATE becas_info SET archivo_url = :url WHERE key_name = :key",
                    [':url' => $publicPath, ':key' => $key]
                );
            } else {
                // Si no existe, lo insertamos
                $this->db->query(
                    "INSERT INTO becas_info (key_name, titulo, archivo_url) VALUES (:key, :titulo, :url)",
                    [
                        ':key' => $key, 
                        ':titulo' => ucfirst(str_replace('_', ' ', $key)), 
                        ':url' => $publicPath
                    ]
                );
            }
        } else {
            throw new Exception("Error al subir el archivo para la clave: $key");
        }
    }

    public function deleteFile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $key = $_POST['key_name'] ?? '';
            
            // Obtener archivo actual
            $curr = $this->db->fetchOne("SELECT archivo_url FROM becas_info WHERE key_name = :k", [':k' => $key]);
            
            if ($curr && !empty($curr['archivo_url'])) {
                // Construir ruta absoluta correctamente
                // Si la URL empieza con uploads/, añadir PUBLIC_PATH
                $path = PUBLIC_PATH . '/' . $curr['archivo_url'];
                
                if (file_exists($path)) {
                    unlink($path);
                }
                
                $this->db->query("UPDATE becas_info SET archivo_url = NULL WHERE key_name = :k", [':k' => $key]);
                $_SESSION['success'] = 'Archivo eliminado correctamente.';
            }
            
            header('Location: ' . url('admin/becas'));
            exit;
        }
    }
}
