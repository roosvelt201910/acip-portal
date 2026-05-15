<?php
class ContactosController {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance();
        if (!isAuthenticated()) redirect(url('admin/login'));
    }
    public function index() {
        $contactos = $this->db->fetchAll("SELECT * FROM contactos ORDER BY created_at DESC");
        $pageTitle = 'Administrar Contactos';
        $currentPage = 'contactos';
        require APP_PATH . '/Views/admin/contactos/index.php';
    }
    public function updateStatus($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $estado = $data['estado'] ?? 'leido';
        
        try {
            $this->db->query("UPDATE contactos SET estado = ? WHERE id = ?", [$estado, $id]);
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function delete($id) {
        try {
            $this->db->query("DELETE FROM contactos WHERE id = ?", [$id]);
            $_SESSION['success'] = 'Mensaje eliminado correctamente.';
            redirect(url('admin/contactos'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar el mensaje: ' . $e->getMessage();
            redirect(url('admin/contactos'));
        }
    }
}
