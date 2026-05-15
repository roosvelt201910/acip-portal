<?php

class PlanaDocenteController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function index() {
        // Fetch teachers active with their program name
        $sql = "SELECT pd.*, pe.nombre as programa_nombre 
                FROM plana_docente pd 
                LEFT JOIN programas_estudio pe ON pd.programa_id = pe.id 
                WHERE pd.activo = 1
                ORDER BY pe.orden ASC, pd.orden ASC, pd.created_at DESC";
        
        $docentes = $this->db->fetchAll($sql);
        
        $pageTitle = 'Plana Docente';
        
        require APP_PATH . '/Views/pages/plana_docente.php';
    }
}
