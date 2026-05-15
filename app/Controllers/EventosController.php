<?php
/**
 * Controlador de Eventos (Público)
 */

class EventosController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function index() {
        $eventos = $this->db->fetchAll(
            "SELECT * FROM eventos 
             WHERE activo = 1 
             ORDER BY fecha_inicio ASC"
        );
        
        $pageTitle = 'Eventos';
        require APP_PATH . '/Views/eventos/index.php';
    }
}
