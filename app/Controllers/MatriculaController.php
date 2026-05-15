<?php


class MatriculaController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function index() {
        // Obtener configuración global
        $config = $this->db->fetchOne("SELECT * FROM configuracion LIMIT 1");
        
        // Obtener programas para el menú o header si es necesario
        $programas = $this->db->fetchAll("SELECT * FROM programas_estudio WHERE activo = 1 ORDER BY orden ASC");
        
        // Obtener toda la información de matrícula
        $info = $this->db->fetchAll("SELECT * FROM matricula_info ORDER BY order_index ASC");
        
        // Obtener enlaces destacados
        $enlaces = $this->db->fetchAll("SELECT * FROM enlaces WHERE estado = 'activo' ORDER BY orden ASC");
        
        // Organizar en un array asociativo
        $matriculaData = [];
        foreach ($info as $item) {
            $matriculaData[$item['key_name']] = $item;
        }
        
        $pageTitle = 'Matrícula';
        $currentPage = 'matricula';
        
        require APP_PATH . '/Views/matricula/index.php';
    }
}
