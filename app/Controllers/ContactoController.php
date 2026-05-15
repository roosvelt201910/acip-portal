<?php
/**
 * Controlador de Contacto (Público)
 */

class ContactoController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function index() {
        $pageTitle = 'Contacto';
        require APP_PATH . '/Views/contacto/index.php';
    }
    
    public function enviar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => $_POST['nombre'] ?? '',
                'email' => $_POST['email'] ?? '',
                'telefono' => $_POST['celular'] ?? '',
                'asunto' => $_POST['asunto'] ?? '',
                'mensaje' => $_POST['mensaje'] ?? '',
                'estado' => 'nuevo',
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Basic validation
            if (!empty($data['nombre']) && !empty($data['email']) && !empty($data['mensaje'])) {
                try {
                    $this->db->insert('contactos', $data);
                } catch (Exception $e) {
                     // Log error or handle it silently? For now, we proceed to redirect.
                     // maybe: error_log($e->getMessage());
                }
            }
        }
        
        header('Location: ' . url('contacto?status=success'));
        exit;
    }
}
