<?php
class DocumentosController {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance();
        if (!isAuthenticated()) redirect(url('admin/login'));
    }
    public function index() {
        $documentos = $this->db->fetchAll("SELECT * FROM documentos ORDER BY created_at DESC");
        // Fetch all categories for tabs
        $categorias = $this->db->fetchAll("SELECT * FROM documento_categorias ORDER BY nombre ASC");
        
        $pageTitle = 'Administrar Documentos';
        $currentPage = 'documentos';
        require APP_PATH . '/Views/admin/documentos/index.php';
    }
    public function create() {
        $pageTitle = 'Nuevo Documento';
        $currentPage = 'documentos';
        $categorias = $this->db->fetchAll("SELECT * FROM documento_categorias ORDER BY nombre ASC");
        require APP_PATH . '/Views/admin/documentos/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? '';
            $categoria = $_POST['categoria'] ?? 'General';
            $tipo = $_POST['tipo_documento'] ?? 'otro';
            
            // Handle File Upload
            if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['archivo']['tmp_name'];
                $fileName = $_FILES['archivo']['name'];
                $fileSize = $_FILES['archivo']['size'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                
                // Sanitize filename
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                
                // Directory
                $uploadFileDir = PUBLIC_PATH . '/uploads/documentos/';
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0755, true);
                }
                
                $dest_path = $uploadFileDir . $newFileName;
                
                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    // Insert into DB
                    $autorId = $_SESSION['user_id'] ?? 1; // Default to 1 if not set
                    
                    $this->db->query("INSERT INTO documentos (titulo, categoria, archivo, tipo_documento, tamanio, extension, autor_id, activo) VALUES (:titulo, :categoria, :archivo, :tipo, :tamanio, :extension, :autor, 1)", [
                        'titulo' => $titulo,
                        'categoria' => $categoria,
                        'archivo' => $newFileName,
                        'tipo' => $tipo,
                        'tamanio' => $fileSize,
                        'extension' => $fileExtension,
                        'autor' => $autorId
                    ]);
                    
                    redirect(url('admin/documentos'));
                } else {
                    $error = "Error al mover el archivo subido.";
                    $categorias = $this->db->fetchAll("SELECT * FROM documento_categorias ORDER BY nombre ASC");
                    require APP_PATH . '/Views/admin/documentos/create.php';
                }
            } else {
                $error = "Debe seleccionar un archivo válido.";
                $categorias = $this->db->fetchAll("SELECT * FROM documento_categorias ORDER BY nombre ASC");
                require APP_PATH . '/Views/admin/documentos/create.php';
            }
        }
    }

    public function delete($id) {
        // Get file info first to delete from disk
        $doc = $this->db->fetchOne("SELECT archivo FROM documentos WHERE id = :id", ['id' => $id]);
        
        if ($doc) {
            $filePath = PUBLIC_PATH . '/uploads/documentos/' . $doc['archivo'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            $this->db->query("DELETE FROM documentos WHERE id = :id", ['id' => $id]);
        }
        
        redirect(url('admin/documentos'));
    }

    // Category Management
    public function getCategories() {
        header('Content-Type: application/json');
        $categorias = $this->db->fetchAll("SELECT * FROM documento_categorias ORDER BY nombre ASC");
        echo json_encode(['success' => true, 'data' => $categorias]);
        exit;
    }

    public function storeCategory() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $nombre = trim($data['nombre'] ?? '');
            
            if (empty($nombre)) {
                echo json_encode(['success' => false, 'message' => 'El nombre es obligatorio']);
                exit;
            }

            try {
                $this->db->query("INSERT INTO documento_categorias (nombre) VALUES (:nombre)", ['nombre' => $nombre]);
                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                // Determine if integrity violation
                if (strpos($e->getMessage(), 'Duplicate') !== false) {
                    echo json_encode(['success' => false, 'message' => 'La categoría ya existe']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al guardar']);
                }
            }
            exit;
        }
    }

    public function deleteCategory() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'] ?? null;
            
            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                exit;
            }

            $this->db->query("DELETE FROM documento_categorias WHERE id = :id", ['id' => $id]);
            echo json_encode(['success' => true]);
            exit;
        }
    }
}
