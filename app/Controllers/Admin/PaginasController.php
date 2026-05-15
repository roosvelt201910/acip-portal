<?php
/**
 * Controlador de Páginas - Admin
 */

class PaginasController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
        
        // Verificar autenticación
        if (!isAuthenticated()) {
            redirect(url('admin/login'));
        }
    }
    
    public function index() {
        // Obtener páginas
        $paginas = $this->db->fetchAll(
            "SELECT * FROM contenidos WHERE tipo = 'pagina' ORDER BY created_at DESC"
        );
        
        $pageTitle = 'Administrar Páginas';
        $currentPage = 'paginas';
        require APP_PATH . '/Views/admin/paginas/index.php';
    }
    
    public function create() {
        $pageTitle = 'Nueva Página';
        $currentPage = 'paginas';
        $categorias = $this->db->fetchAll("SELECT * FROM documento_categorias ORDER BY nombre ASC");
        require APP_PATH . '/Views/admin/paginas/create.php';
    }
    
    public function store() {
        // Validar CSRF
        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Token CSRF inválido';
            redirect(url('admin/paginas/crear'));
        }
        
        $titulo = sanitize($_POST['titulo']);
        $contenido = $_POST['contenido']; 
        $slug = empty($_POST['slug']) ? slugify($titulo) : slugify($_POST['slug']);
        $estado = $_POST['estado'];
        $media_type = $_POST['media_type'] ?? 'image';
        $video_url = sanitize($_POST['video_url'] ?? '');
        $categoria_documentos_id = !empty($_POST['categoria_documentos_id']) ? $_POST['categoria_documentos_id'] : null;
        
        // Manejar Subida de Imagen
        $imagenPath = null;
        if ($media_type === 'image' && !empty($_FILES['imagen']['name'])) {
            $uploadDir = PUBLIC_PATH . '/uploads/paginas/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = time() . '_' . slugify(pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME)) . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $targetPath)) {
                $imagenPath = 'uploads/paginas/' . $fileName;
            }
        }

        // Insertar
        $this->db->insert('contenidos', [
            'tipo' => 'pagina',
            'titulo' => $titulo,
            'contenido' => $contenido,
            'slug' => $slug,
            'estado' => $estado,
            'media_type' => $media_type,
            'video_url' => $video_url,
            'imagen_destacada' => $imagenPath,
            'categoria_documentos_id' => $categoria_documentos_id,
            'autor_id' => $_SESSION['user_id'],
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $_SESSION['success'] = 'Página creada correctamente';
        redirect(url('admin/paginas'));
    }
    
    public function edit($id) {
        $pagina = $this->db->fetchOne("SELECT * FROM contenidos WHERE id = ? AND tipo = 'pagina'", [$id]);
        
        if (!$pagina) {
            redirect(url('admin/paginas'));
        }
        
        $categorias = $this->db->fetchAll("SELECT * FROM documento_categorias ORDER BY nombre ASC");
        
        $pageTitle = 'Editar Página';
        $currentPage = 'paginas';
        require APP_PATH . '/Views/admin/paginas/edit.php';
    }
    
    public function update($id) {
        // Validar CSRF
        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Token CSRF inválido';
            redirect(url('admin/paginas/editar/' . $id));
        }
        
        $titulo = sanitize($_POST['titulo']);
        $contenido = $_POST['contenido'];
        $slug = empty($_POST['slug']) ? slugify($titulo) : slugify($_POST['slug']);
        $estado = $_POST['estado'];
        $media_type = $_POST['media_type'] ?? 'image';
        $video_url = sanitize($_POST['video_url'] ?? '');
        $categoria_documentos_id = !empty($_POST['categoria_documentos_id']) ? $_POST['categoria_documentos_id'] : null;
        
        // Datos a actualizar básicos
        $data = [
            'titulo' => $titulo,
            'contenido' => $contenido,
            'slug' => $slug,
            'estado' => $estado,
            'media_type' => $media_type,
            'video_url' => $video_url,
            'categoria_documentos_id' => $categoria_documentos_id,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Manejar Subida de Imagen (Solo si se sube una nueva)
        if ($media_type === 'image' && !empty($_FILES['imagen']['name'])) {
            $uploadDir = PUBLIC_PATH . '/uploads/paginas/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = time() . '_' . slugify(pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME)) . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $targetPath)) {
                $data['imagen_destacada'] = 'uploads/paginas/' . $fileName;
            }
        }
        
        // Actualizar
        $this->db->update('contenidos', $data, "id = $id");
        
        $_SESSION['success'] = 'Página actualizada correctamente';
        redirect(url('admin/paginas'));
    }
    
    public function delete($id) {
        $this->db->query("DELETE FROM contenidos WHERE id = ? AND tipo = 'pagina'", [$id]);
        $_SESSION['success'] = 'Página eliminada correctamente';
        redirect(url('admin/paginas'));
    }
}
