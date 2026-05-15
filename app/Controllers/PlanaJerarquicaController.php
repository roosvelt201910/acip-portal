<?php

class PlanaJerarquicaController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function index() {
        // Fetch members sorted by order
        $miembros = $this->db->fetchAll("SELECT * FROM plana_jerarquica ORDER BY orden ASC, created_at DESC");
        
        // Page metadata
        $pageTitle = 'Plana Jerárquica';
        
        // Load view
        require APP_PATH . '/Views/pages/plana_jerarquica.php';
    }
}
