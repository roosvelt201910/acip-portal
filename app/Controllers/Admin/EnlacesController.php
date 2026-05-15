<?php
require_once __DIR__ . '/../../../includes/Database.php';

class EnlacesController {
    private $db;
    private $table = 'enlaces';

    public function __construct() {
        if (!isAuthenticated()) {
            redirect(url('admin/login'));
        }
        $this->db = Database::getInstance();
        $this->ensureTableExists();
    }

    // Ensure table exists
    private function ensureTableExists() {
        $sql = "CREATE TABLE IF NOT EXISTS enlaces (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(255) NOT NULL,
            descripcion TEXT,
            enlace VARCHAR(255) NOT NULL,
            icono VARCHAR(255),
            orden INT DEFAULT 0,
            estado ENUM('activo', 'inactivo') DEFAULT 'activo',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        $this->db->query($sql);
    }

    // List all links
    public function index() {
        $sql = "SELECT * FROM {$this->table} ORDER BY orden ASC, created_at DESC";
        $enlaces = $this->db->fetchAll($sql);
        
        $pageTitle = 'Administrar Enlaces Destacados';
        $content = $this->render(__DIR__ . '/../../Views/admin/enlaces/index.php', ['enlaces' => $enlaces]);
        
        require __DIR__ . '/../../Views/layouts/admin.php';
    }

    // Show create form
    public function create() {
        $pageTitle = 'Nuevo Enlace Destacado';
        $content = $this->render(__DIR__ . '/../../Views/admin/enlaces/create.php');
        require __DIR__ . '/../../Views/layouts/admin.php';
    }

    // Store new link
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? '';
            $enlace = $_POST['enlace'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $orden = $_POST['orden'] ?? 0;
            $estado = $_POST['estado'] ?? 'activo';
            
            // Handle Icon Upload
            $iconoPath = '';
            if (isset($_FILES['icono']) && $_FILES['icono']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../../public/uploads/icons/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $extension = pathinfo($_FILES['icono']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('icon_') . '.' . $extension;
                
                if (move_uploaded_file($_FILES['icono']['tmp_name'], $uploadDir . $filename)) {
                    $iconoPath = 'uploads/icons/' . $filename;
                }
            }
            
            $data = [
                'titulo' => $titulo,
                'enlace' => $enlace,
                'descripcion' => $descripcion,
                'icono' => $iconoPath,
                'orden' => $orden,
                'estado' => $estado
            ];
            
            if ($this->db->insert($this->table, $data)) {
                $_SESSION['success'] = 'Enlace creado correctamente.';
                header('Location: ' . url('admin/enlaces'));
                exit;
            } else {
                $_SESSION['error'] = 'Error al crear el enlace.';
            }
        }
    }

    // Show edit form
    public function edit($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $enlace = $this->db->fetchOne($sql, ['id' => $id]);
        
        if (!$enlace) {
            header('Location: ' . url('admin/enlaces'));
            exit;
        }
        
        $pageTitle = 'Editar Enlace Destacado';
        $content = $this->render(__DIR__ . '/../../Views/admin/enlaces/edit.php', ['enlace' => $enlace]);
        require __DIR__ . '/../../Views/layouts/admin.php';
    }

    // Update link
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? '';
            $enlace = $_POST['enlace'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $orden = $_POST['orden'] ?? 0;
            $estado = $_POST['estado'] ?? 'activo';
            
            $data = [
                'titulo' => $titulo,
                'enlace' => $enlace,
                'descripcion' => $descripcion,
                'orden' => $orden,
                'estado' => $estado
            ];
            
            // Handle Icon Upload (Update)
            if (isset($_FILES['icono']) && $_FILES['icono']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../../public/uploads/icons/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $extension = pathinfo($_FILES['icono']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('icon_') . '.' . $extension;
                
                if (move_uploaded_file($_FILES['icono']['tmp_name'], $uploadDir . $filename)) {
                    $data['icono'] = 'uploads/icons/' . $filename;
                }
            }
            
            if ($this->db->update($this->table, $data, "id = :id", ['id' => $id])) {
                $_SESSION['success'] = 'Enlace actualizado correctamente.';
                header('Location: ' . url('admin/enlaces'));
                exit;
            } else {
                $_SESSION['error'] = 'Error al actualizar el enlace.';
            }
        }
    }

    // Delete link
    public function delete($id) {
        if ($this->db->delete($this->table, "id = :id", ['id' => $id])) {
            $_SESSION['success'] = 'Enlace eliminado correctamente.';
        } else {
            $_SESSION['error'] = 'Error al eliminar el enlace.';
        }
        header('Location: ' . url('admin/enlaces'));
        exit;
    }

    // Helper to render views (similar to other controllers)
    private function render($viewPath, $data = []) {
        extract($data);
        ob_start();
        require $viewPath;
        return ob_get_clean();
    }
}
