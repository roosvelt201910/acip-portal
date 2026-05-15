<?php
/**
 * Controlador de Avisos Modales - Admin
 */

class AvisosController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
        
        // Verificar autenticación
        if (!isAuthenticated()) {
            redirect(url('admin/login'));
        }
    }
    
    public function index() {
        // Obtener todos los avisos
        $avisos = $this->db->fetchAll(
            "SELECT * FROM avisos_modales ORDER BY orden DESC, created_at DESC"
        );
        
        $pageTitle = 'Administrar Avisos';
        $currentPage = 'avisos';
        require APP_PATH . '/Views/admin/avisos/index.php';
    }
    
    public function create() {
        $pageTitle = 'Nuevo Aviso';
        $currentPage = 'avisos';
        require APP_PATH . '/Views/admin/avisos/create.php';
    }
    
    public function store() {
        // Validar CSRF
        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            die('Token CSRF inválido');
        }
        
        $titulo = sanitize($_POST['titulo']);
        $tipo_contenido = $_POST['tipo_contenido'];
        $contenido_html = $_POST['contenido_html'] ?? '';
        $video_url = sanitize($_POST['video_url'] ?? '');
        $enlace_boton = sanitize($_POST['enlace_boton'] ?? '');
        $texto_boton = sanitize($_POST['texto_boton'] ?? 'Más información');
        $estado = $_POST['estado'];
        $mostrar_una_vez = isset($_POST['mostrar_una_vez']) ? 1 : 0;
        $fecha_inicio = !empty($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
        $fecha_fin = !empty($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;
        $orden = intval($_POST['orden'] ?? 0);
        
        // Manejar Subida de Imagen
        $imagenPath = null;
        if ($tipo_contenido === 'imagen' && !empty($_FILES['imagen']['name'])) {
            $uploadDir = PUBLIC_PATH . '/uploads/avisos/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = time() . '_' . slugify(pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME)) . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $targetPath)) {
                $imagenPath = 'uploads/avisos/' . $fileName;
            }
        }

        // Insertar
        $this->db->insert('avisos_modales', [
            'titulo' => $titulo,
            'tipo_contenido' => $tipo_contenido,
            'imagen' => $imagenPath,
            'video_url' => $video_url,
            'contenido_html' => $contenido_html,
            'enlace_boton' => $enlace_boton,
            'texto_boton' => $texto_boton,
            'estado' => $estado,
            'mostrar_una_vez' => $mostrar_una_vez,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'orden' => $orden,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        redirect(url('admin/avisos'));
    }
    
    public function edit($id) {
        $aviso = $this->db->fetchOne("SELECT * FROM avisos_modales WHERE id = ?", [$id]);
        
        if (!$aviso) {
            redirect(url('admin/avisos'));
        }
        
        $pageTitle = 'Editar Aviso';
        $currentPage = 'avisos';
        require APP_PATH . '/Views/admin/avisos/edit.php';
    }
    
    public function update($id) {
        // Validar CSRF
        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            die('Token CSRF inválido');
        }
        
        $titulo = sanitize($_POST['titulo']);
        $tipo_contenido = $_POST['tipo_contenido'];
        $contenido_html = $_POST['contenido_html'] ?? '';
        $video_url = sanitize($_POST['video_url'] ?? '');
        $enlace_boton = sanitize($_POST['enlace_boton'] ?? '');
        $texto_boton = sanitize($_POST['texto_boton'] ?? 'Más información');
        $estado = $_POST['estado'];
        $mostrar_una_vez = isset($_POST['mostrar_una_vez']) ? 1 : 0;
        $fecha_inicio = !empty($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
        $fecha_fin = !empty($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;
        $orden = intval($_POST['orden'] ?? 0);
        
        // Datos a actualizar básicos
        $data = [
            'titulo' => $titulo,
            'tipo_contenido' => $tipo_contenido,
            'contenido_html' => $contenido_html,
            'video_url' => $video_url,
            'enlace_boton' => $enlace_boton,
            'texto_boton' => $texto_boton,
            'estado' => $estado,
            'mostrar_una_vez' => $mostrar_una_vez,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'orden' => $orden,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Manejar Subida de Imagen (Solo si se sube una nueva)
        if ($tipo_contenido === 'imagen' && !empty($_FILES['imagen']['name'])) {
            $uploadDir = PUBLIC_PATH . '/uploads/avisos/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = time() . '_' . slugify(pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME)) . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $targetPath)) {
                $data['imagen'] = 'uploads/avisos/' . $fileName;
            }
        }
        
        // Actualizar
        $this->db->update('avisos_modales', $data, "id = $id");
        
        redirect(url('admin/avisos'));
    }
    
    public function delete($id) {
        $aviso = $this->db->fetchOne("SELECT * FROM avisos_modales WHERE id = ?", [$id]);
        
        if ($aviso) {
            // Delete image if exists
            if ($aviso['imagen'] && file_exists(PUBLIC_PATH . '/' . $aviso['imagen'])) {
                unlink(PUBLIC_PATH . '/' . $aviso['imagen']);
            }
            
            $this->db->query("DELETE FROM avisos_modales WHERE id = ?", [$id]);
        }
        
        redirect(url('admin/avisos'));
    }
    
    public function toggleStatus($id) {
        $aviso = $this->db->fetchOne("SELECT estado FROM avisos_modales WHERE id = ?", [$id]);
        
        if ($aviso) {
            $newStatus = $aviso['estado'] === 'activo' ? 'inactivo' : 'activo';
            $this->db->update('avisos_modales', ['estado' => $newStatus], "id = $id");
        }
        
        redirect(url('admin/avisos'));
    }
}
