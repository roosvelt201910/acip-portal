<?php
/**
 * Controlador de Inicio
 */

class HomeController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function index() {
        // Obtener banners activos
        $banners = $this->db->fetchAll(
            "SELECT * FROM banners WHERE activo = 1 ORDER BY orden ASC"
        );
        
        // Obtener noticias destacadas
        $noticias = $this->db->fetchAll(
            "SELECT n.*, u.nombre as autor_nombre 
             FROM noticias n 
             INNER JOIN usuarios u ON n.autor_id = u.id 
             WHERE n.estado = 'publicado' 
             ORDER BY n.fecha_publicacion DESC 
             LIMIT 6"
        );
        
        // Obtener próximos eventos
        $eventos = $this->db->fetchAll(
             "SELECT * FROM eventos 
             WHERE activo = 1 AND fecha_inicio >= NOW() 
             ORDER BY fecha_inicio ASC 
             LIMIT 9"
        );
        
        // Obtener programas de estudio
        $programas = $this->db->fetchAll(
            "SELECT * FROM programas_estudio 
             WHERE activo = 1 
             ORDER BY orden ASC"
        );

        // Obtener enlaces destacados
        $enlaces = $this->db->fetchAll(
            "SELECT * FROM enlaces 
             WHERE estado = 'activo' 
             ORDER BY orden ASC"
        );

        // Obtener aviso modal activo
        $aviso = $this->db->fetchOne(
            "SELECT * FROM avisos_modales 
             WHERE estado = 'activo' 
             AND (fecha_inicio IS NULL OR fecha_inicio <= NOW())
             AND (fecha_fin IS NULL OR fecha_fin >= NOW())
             ORDER BY orden DESC, created_at DESC 
             LIMIT 1"
        );

        // Obtener configuración del sitio para la sección de bienvenida
        $configRows = $this->db->fetchAll("SELECT clave, valor FROM configuracion WHERE clave LIKE 'home_welcome_%'");
        $siteConfig = [];
        foreach ($configRows as $row) {
            $siteConfig[$row['clave']] = $row['valor'];
        }
        
        // Cargar vista
        $pageTitle = 'Inicio';
        require APP_PATH . '/Views/pages/home.php';
    }
}
