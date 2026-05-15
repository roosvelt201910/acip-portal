<?php
/**
 * Controlador Público para "Por qué elegirnos"
 */

class WhyChooseUsController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function index() {
        // Obtener elementos activos ordenados
        $items = $this->db->fetchAll(
            "SELECT * FROM why_choose_us WHERE activo = 1 ORDER BY orden ASC"
        );
        
        $pageTitle = 'Por qué elegirnos';
        $metaDescription = 'Descubre las razones para elegir nuestra institución. Excelencia académica, infraestructura moderna y docentes calificados.';
        
        require APP_PATH . '/Views/pages/why_choose_us.php';
    }
}
