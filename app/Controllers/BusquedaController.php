<?php
/**
 * Controlador de Búsqueda (Público)
 */

class BusquedaController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function index() {
        $query = $_GET['q'] ?? '';
        $resultados = [];
        
        if (!empty($query)) {
            $q = "%$query%";
            // Buscar en páginas y noticias
            $resultados = $this->db->fetchAll(
                "SELECT id, titulo, slug, 'pagina' as tipo FROM contenidos WHERE titulo LIKE ? 
                 UNION 
                 SELECT id, titulo, slug, 'noticia' as tipo FROM noticias WHERE titulo LIKE ?",
                [$q, $q]
            );
        }
        
        $pageTitle = 'Resultados de Búsqueda';
        require APP_PATH . '/Views/busqueda/index.php';
    }
}
