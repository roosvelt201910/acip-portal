<?php
/**
 * Controlador de Páginas Dinámicas
 */

class PageController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function show($slug) {
        // Buscar página por slug
        $page = $this->db->fetchOne(
            "SELECT c.*, u.nombre as autor_nombre 
             FROM contenidos c 
             INNER JOIN usuarios u ON c.autor_id = u.id 
             WHERE c.slug = ? AND c.estado = 'publicado'",
            [$slug]
        );
        
        if (!$page) {
            http_response_code(404);
            require APP_PATH . '/Views/errors/404.php';
            return;
        }
        
        // Incrementar contador de visitas
        $this->db->update('contenidos', 
            ['visitas' => $page['visitas'] + 1],
            'id = :id',
            ['id' => $page['id']]
        );
        
        // Obtener subpáginas si las tiene
        $subpages = $this->db->fetchAll(
            "SELECT id, titulo, slug FROM contenidos 
             WHERE parent_id = ? AND estado = 'publicado' 
             ORDER BY orden ASC",
            [$page['id']]
        );

        // Obtener documentos si hay categoría vinculada
        $documentos = [];
        if (!empty($page['categoria_documentos_id'])) {
            // Join with categories to get category name if needed
            $documentos = $this->db->fetchAll(
                "SELECT d.*, c.nombre as categoria_nombre 
                 FROM documentos d 
                 JOIN documento_categorias c ON d.categoria = c.nombre 
                 WHERE c.id = ? AND d.activo = 1 
                 ORDER BY d.created_at DESC", 
                 [$page['categoria_documentos_id']]
            );
            
            // NOTE: The above query assumes 'categoria' column in 'documentos' table stores the NAME of the category,
            // while 'documento_categorias' table has ID and NAME.
            // If 'documentos' table is updated to use ID, this query needs adjustment.
            // Based on previous context, 'documentos' table uses 'categoria' (varchar) column.
            // So we join on name.
        }
        
        // Cargar vista
        $pageTitle = $page['meta_title'] ?: $page['titulo'];
        $metaDescription = $page['meta_description'];
        require APP_PATH . '/Views/pages/page.php';
    }
}
