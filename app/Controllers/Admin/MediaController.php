<?php
/**
 * Media Controller - Handles File Uploads for CKEditor
 */

class MediaController {
    public function uploadImage() {
        // Enforce JSON response
        header('Content-Type: application/json');

        // Check authentication
        if (!isAuthenticated()) {
            http_response_code(401);
            echo json_encode(['error' => ['message' => 'No autorizado']]);
            return;
        }

        if (empty($_FILES['upload'])) {
            http_response_code(400);
            echo json_encode(['error' => ['message' => 'No se recibió ningún archivo']]);
            return;
        }

        $file = $_FILES['upload'];
        
        // Validation
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            http_response_code(400);
            echo json_encode(['error' => ['message' => 'Tipo de archivo no permitido. Solo JPG, PNG, GIF, WEBP.']]);
            return;
        }

        // Create Upload Directory
        $uploadDir = 'uploads/media/' . date('Y/m/');
        $fullPath = APP_ROOT . '/public/' . $uploadDir;
        
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        // Generate Filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('img_') . '.' . $extension;
        $target = $fullPath . $filename;

        // Move File
        if (move_uploaded_file($file['tmp_name'], $target)) {
            $url = url($uploadDir . $filename);
            
            // CKEditor expects { "url": "..." } on success
            echo json_encode(['url' => $url]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => ['message' => 'Error al guardar el archivo en el servidor.']]);
        }
    }
}
