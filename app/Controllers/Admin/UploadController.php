<?php

require_once __DIR__ . '/../../../includes/Database.php';
require_once __DIR__ . '/../../../includes/functions.php';

class UploadController {
    
    public function uploadImage() {
        if (!isAuthenticated()) {
            http_response_code(403);
            echo json_encode(['error' => ['message' => 'No autorizado.']]);
            return;
        }

        if (isset($_FILES['upload']) && $_FILES['upload']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['upload'];
            
            // Validate image
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file['type'], $allowedTypes)) {
                echo json_encode(['error' => ['message' => 'Tipo de archivo no permitido. Solo JPG, PNG, GIF y WebP.']]);
                return;
            }
            
            // Create uploads dir
            $uploadDir = __DIR__ . '/../../../public/uploads/content/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Generate unique name
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid('content_') . '.' . $extension;
            $targetPath = $uploadDir . $filename;
            
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                // Return JSON URL for CKEditor
                $url = url('uploads/content/' . $filename);
                echo json_encode([
                    'url' => $url
                ]);
            } else {
                echo json_encode(['error' => ['message' => 'Error al mover el archivo.']]);
            }
        } else {
            echo json_encode(['error' => ['message' => 'No se recibió ningún archivo.']]);
        }
    }
}
