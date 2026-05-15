<?php
/**
 * Controlador de Programas (Público)
 */

class ProgramasController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function index() {
        $programas = $this->db->fetchAll(
            "SELECT * FROM programas_estudio WHERE activo = 1 ORDER BY orden ASC"
        );
        
        // Obtener enlaces destacados
        $enlaces = $this->db->fetchAll(
            "SELECT * FROM enlaces WHERE estado = 'activo' ORDER BY orden ASC"
        );
        
        $pageTitle = 'Programas de Estudio';
        require APP_PATH . '/Views/programas/index.php';
    }
    
    public function show($slug) {
        // En un caso real, buscaríamos en la tabla programas_estudio con detalle
        // Para este ejemplo, usaremos la tabla contenidos si existe una página asociada, 
        // o mostraremos un placeholder si no hay detalle específico.
        // Asumiremos que por ahora listamos programas.
        
        $programa = $this->db->fetchOne(
            "SELECT * FROM programas_estudio WHERE slug = ? AND activo = 1",
            [$slug]
        );
        
        if (!$programa) {
             // Fallback: Check if it's a static page acting as a program page
            require APP_PATH . '/Controllers/PageController.php';
            $pageController = new PageController();
            $pageController->show($slug);
            return;
        }
        
        // Fetch gallery images
        $galeria = $this->db->fetchAll(
            "SELECT * FROM programas_galeria WHERE programa_id = ? ORDER BY id ASC",
            [$programa['id']]
        );
        
        // Fetch partners/allies
        $aliados = $this->db->fetchAll(
            "SELECT * FROM programas_aliados WHERE programa_id = ? ORDER BY id ASC",
            [$programa['id']]
        );
        
        $pageTitle = $programa['nombre'];
        require APP_PATH . '/Views/programas/show.php';
    }
}
