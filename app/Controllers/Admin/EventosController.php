<?php
class EventosController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
        if (!isAuthenticated()) redirect(url('admin/login'));
    }
    
    public function index() {
        $eventos = $this->db->fetchAll("SELECT * FROM eventos ORDER BY fecha_inicio DESC");
        $pageTitle = 'Administrar Eventos';
        $currentPage = 'eventos';
        require APP_PATH . '/Views/admin/eventos/index.php';
    }
    
    public function create() {
        $pageTitle = 'Nuevo Evento';
        $currentPage = 'eventos';
        require APP_PATH . '/Views/admin/eventos/create.php';
    }
    
    public function store() {
        $titulo = clean($_POST['titulo']);
        $descripcion = clean($_POST['descripcion']); // CKEditor sends HTML, so clean() is fine for basic trim but be careful if it strips tags too aggressively. 
                                                     // Actually clean() in functions.php does strict trim(strip_tags). 
                                                     // WAIT: strip_tags will remove the HTML from WYSIWYG. I need to relax data cleaning for description or use a better sanitizer.
                                                     // For now, I will assume clean() uses strip_tags which destroys WYSIWYG content.
                                                     // I need to Fix that first or handle description differently.
                                                     // Let's look at functions.php again. clean() uses trim() only? No, I added it previously.
                                                     // Ah, I added clean() as `return trim($data);`. It does NOT use strip_tags. So it is safe for HTML.
        
        $fecha_inicio = clean($_POST['fecha_inicio']);
        $ubicacion = clean($_POST['ubicacion']);
        $activo = isset($_POST['activo']) ? 1 : 0;
        
        if (empty($titulo) || empty($fecha_inicio)) {
            $_SESSION['error'] = 'El título y la fecha de inicio son obligatorios.';
            redirect(url('admin/eventos/crear'));
            return;
        }
        
        $slug = slugify($titulo);
        // Ensure slug is unique, simple check for now
        $count = $this->db->fetchOne("SELECT COUNT(*) as c FROM eventos WHERE slug = ?", [$slug])['c'];
        if ($count > 0) {
            $slug .= '-' . time();
        }
        
        $autor_id = $_SESSION['user_id'] ?? 0; // Assuming user_id is stored in session upon authentication
        // DEBUGGING
        // var_dump($_POST); 
        // var_dump($autor_id);
        
        $sql = "INSERT INTO eventos (titulo, slug, descripcion, fecha_inicio, ubicacion, activo, autor_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [$titulo, $slug, $descripcion, $fecha_inicio, $ubicacion, $activo, $autor_id, date('Y-m-d H:i:s')];
        
        try {
            if ($this->db->query($sql, $params)) {
                $_SESSION['success'] = 'Evento creado correctamente.';
                redirect(url('admin/eventos'));
            } else {
                // This branch is rarely reached if PDO throws exceptions
                $_SESSION['error'] = 'Error al crear el evento (Query failed).';
                redirect(url('admin/eventos/crear'));
            }
        } catch (Exception $e) {
            die("SQL Error: " . $e->getMessage());
        }
    }
    
    public function edit($id) {
        $evento = $this->db->fetchOne("SELECT * FROM eventos WHERE id = ?", [$id]);
        
        if (!$evento) {
            $_SESSION['error'] = 'Evento no encontrado.';
            redirect(url('admin/eventos'));
            return;
        }
        
        $pageTitle = 'Editar Evento';
        $currentPage = 'eventos';
        require APP_PATH . '/Views/admin/eventos/edit.php';
    }
    
    public function update($id) {
        $evento = $this->db->fetchOne("SELECT * FROM eventos WHERE id = ?", [$id]);
        
        if (!$evento) {
            $_SESSION['error'] = 'Evento no encontrado.';
            redirect(url('admin/eventos'));
            return;
        }
        
        $titulo = clean($_POST['titulo']);
        $descripcion = clean($_POST['descripcion']);
        $fecha_inicio = clean($_POST['fecha_inicio']);
        $ubicacion = clean($_POST['ubicacion']);
        $activo = isset($_POST['activo']) ? 1 : 0;
        
        if (empty($titulo) || empty($fecha_inicio)) {
            $_SESSION['error'] = 'El título y la fecha de inicio son obligatorios.';
            redirect(url('admin/eventos/editar/' . $id));
            return;
        }
        
        $slug = slugify($titulo);
        // Ensure slug is unique but exclude current ID
        $count = $this->db->fetchOne("SELECT COUNT(*) as c FROM eventos WHERE slug = ? AND id != ?", [$slug, $id])['c'];
        if ($count > 0) {
            $slug .= '-' . time();
        }
        
        $sql = "UPDATE eventos SET titulo = ?, slug = ?, descripcion = ?, fecha_inicio = ?, ubicacion = ?, activo = ?, updated_at = ? WHERE id = ?";
        $params = [$titulo, $slug, $descripcion, $fecha_inicio, $ubicacion, $activo, date('Y-m-d H:i:s'), $id];
        
        if ($this->db->query($sql, $params)) {
            $_SESSION['success'] = 'Evento actualizado correctamente.';
            redirect(url('admin/eventos'));
        } else {
            $_SESSION['error'] = 'Error al actualizar el evento.';
            redirect(url('admin/eventos/editar/' . $id));
        }
    }
    
    public function delete($id) {
        if ($this->db->query("DELETE FROM eventos WHERE id = ?", [$id])) {
            $_SESSION['success'] = 'Evento eliminado correctamente.';
        } else {
            $_SESSION['error'] = 'Error al eliminar el evento.';
        }
        redirect(url('admin/eventos'));
    }
}
