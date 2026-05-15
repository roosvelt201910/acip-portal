<?php

class BecasController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function index() {
        $becasData = $this->db->fetchAll("SELECT * FROM becas_info ORDER BY order_index ASC");
        
        $becas = [];
        foreach ($becasData as $item) {
            $becas[$item['key_name']] = $item;
        }

        // Configuración de la página
        $pageTitle = 'Becas y Créditos Educativos - ' . site_config('sitio_nombre', 'IESP ACIP');
        
        require APP_PATH . '/Views/becas/index.php';
    }
}
