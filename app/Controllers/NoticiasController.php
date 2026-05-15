<?php
/**
 * Controlador de Noticias (Público)
 */

class NoticiasController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function index() {
        $noticias = $this->db->fetchAll(
            "SELECT n.*, u.nombre as autor_nombre 
             FROM noticias n 
             INNER JOIN usuarios u ON n.autor_id = u.id 
             WHERE n.estado = 'publicado' 
             ORDER BY n.fecha_publicacion DESC"
        );
        
        // Obtener enlaces destacados
        $enlaces = $this->db->fetchAll(
            "SELECT * FROM enlaces WHERE estado = 'activo' ORDER BY orden ASC"
        );
        
        $pageTitle = 'Noticias';
        require APP_PATH . '/Views/noticias/index.php';
    }
    
    public function show($slug) {
        $noticia = $this->db->fetchOne(
            "SELECT n.*, u.nombre as autor_nombre 
             FROM noticias n 
             INNER JOIN usuarios u ON n.autor_id = u.id 
             WHERE n.slug = ? AND n.estado = 'publicado'",
            [$slug]
        );
        
        if (!$noticia) {
            http_response_code(404);
            require APP_PATH . '/Views/errors/404.php';
            return;
        }
        
        $pageTitle = $noticia['titulo'];
        require APP_PATH . '/Views/noticias/show.php';
    }
}
