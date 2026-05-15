<?php
class ReclamacionesController {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance();
        if (!isAuthenticated()) redirect(url('admin/login'));
    }
    public function index() {
        $reclamaciones = $this->db->fetchAll("SELECT * FROM reclamaciones ORDER BY created_at DESC");
        $pageTitle = 'Libro de Reclamaciones';
        $currentPage = 'reclamaciones';
        require APP_PATH . '/Views/admin/reclamaciones/index.php';
    }

    public function updateStatus($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $estado = $data['estado'] ?? 'pendiente';
        
        // Ensure valid status
        if (!in_array($estado, ['pendiente', 'atendido'])) {
            $estado = 'pendiente';
        }

        try {
            $this->db->query("UPDATE reclamaciones SET estado = ? WHERE id = ?", [$estado, $id]);
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
            $this->db->query("DELETE FROM reclamaciones WHERE id = ?", [$id]);
            $_SESSION['success'] = 'Reclamo eliminado correctamente.';
            redirect(url('admin/reclamaciones'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar el reclamo: ' . $e->getMessage();
            redirect(url('admin/reclamaciones'));
        }
    }

    public function downloadPdf($id) {
        $complaintData = $this->db->fetchOne("SELECT * FROM reclamaciones WHERE id = ?", [$id]);
        
        if (!$complaintData) {
            redirect(url('admin/reclamaciones'));
            return;
        }

        // Map data to match the format expected by constancia.php
        $complaint = [
            'id' => $complaintData['id'],
            'codigo' => $complaintData['codigo'],
            'nombre' => $complaintData['nombres'] ?? $complaintData['nombre'] ?? '', // Schema has 'nombres'
            'email' => $complaintData['email'],
            'telefono' => $complaintData['telefono'],
            'tipo_documento' => $complaintData['tipo_documento'],
            'documento' => $complaintData['numero_documento'] ?? '', // Schema has 'numero_documento'
            'tipo' => $complaintData['tipo_reclamo'] ?? '', // Schema has 'tipo_reclamo'
            'detalle' => $complaintData['detalle'],
            'fecha' => date('d/m/Y H:i:s', strtotime($complaintData['created_at']))
        ];

        require APP_PATH . '/Views/reclamaciones/constancia.php';
    }
}
