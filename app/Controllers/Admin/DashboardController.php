<?php
/**
 * Controlador del Dashboard Admin
 */

class DashboardController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
        
        // Verificar autenticación
        if (!isAuthenticated()) {
            redirect(url('admin/login'));
        }
    }
    
    public function index() {
        // Obtener estadísticas
        $stats = [
            'paginas' => $this->db->fetchOne("SELECT COUNT(*) as total FROM contenidos")['total'],
            'noticias' => $this->db->fetchOne("SELECT COUNT(*) as total FROM noticias")['total'],
            'eventos' => $this->db->fetchOne("SELECT COUNT(*) as total FROM eventos")['total'],
            'documentos' => $this->db->fetchOne("SELECT COUNT(*) as total FROM documentos")['total'],
            'usuarios' => $this->db->fetchOne("SELECT COUNT(*) as total FROM usuarios")['total'],
            'contactos_nuevos' => $this->db->fetchOne("SELECT COUNT(*) as total FROM contactos WHERE estado = 'nuevo'")['total'],
            'reclamaciones_pendientes' => $this->db->fetchOne("SELECT COUNT(*) as total FROM reclamaciones WHERE estado = 'pendiente'")['total'],
        ];
        
        // Obtener actividad reciente
        $actividad = $this->db->fetchAll(
            "SELECT l.*, u.nombre as usuario_nombre 
             FROM logs l 
             LEFT JOIN usuarios u ON l.usuario_id = u.id 
             ORDER BY l.created_at DESC 
             LIMIT 10"
        );
        
        // Cargar vista
        $pageTitle = 'Dashboard';
        require APP_PATH . '/Views/admin/dashboard.php';
    }
}
