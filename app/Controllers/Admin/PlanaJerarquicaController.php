<?php
class PlanaJerarquicaController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
        if (!isAuthenticated()) redirect(url('admin/login'));
    }

    public function index() {
        $miembros = $this->db->fetchAll("SELECT * FROM plana_jerarquica ORDER BY orden ASC, created_at DESC");
        $pageTitle = 'Plana Jerárquica';
        $currentPage = 'plana_jerarquica';
        require APP_PATH . '/Views/admin/plana_jerarquica/index.php';
    }

    public function create() {
        $pageTitle = 'Nuevo Miembro';
        $currentPage = 'plana_jerarquica';
        require APP_PATH . '/Views/admin/plana_jerarquica/form.php';
    }

    public function store() {
        $data = [
            'nombre' => $_POST['nombre'],
            'cargo' => $_POST['cargo'],
            'email' => $_POST['email'] ?? '',
            'categoria' => $_POST['categoria'] ?? 'plana_jerarquica',
            'orden' => $_POST['orden'] ?? 0,
            'imagen' => null
        ];

        // Handle Image Upload
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
             $uploadDir = PUBLIC_PATH . '/uploads/plana_jerarquica/';
             if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
             
             $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
             $filename = uniqid() . '_' . time() . '.' . $extension;
             
             if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                 $data['imagen'] = 'uploads/plana_jerarquica/' . $filename;
             }
        }

        $sql = "INSERT INTO plana_jerarquica (nombre, cargo, email, categoria, orden, imagen) VALUES (:nombre, :cargo, :email, :categoria, :orden, :imagen)";
        
        try {
            $this->db->query($sql, $data);
            $_SESSION['success'] = 'Miembro registrado correctamente';
            redirect(url('admin/plana-jerarquica'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al registrar: ' . $e->getMessage();
            redirect(url('admin/plana-jerarquica/crear'));
        }
    }

    public function edit($id) {
        $miembro = $this->db->fetchOne("SELECT * FROM plana_jerarquica WHERE id = :id", ['id' => $id]);
        if (!$miembro) {
            $_SESSION['error'] = 'Miembro no encontrado';
            redirect(url('admin/plana-jerarquica'));
        }

        $pageTitle = 'Editar Miembro';
        $currentPage = 'plana_jerarquica';
        require APP_PATH . '/Views/admin/plana_jerarquica/form.php';
    }

    public function update($id) {
        $miembro = $this->db->fetchOne("SELECT * FROM plana_jerarquica WHERE id = :id", ['id' => $id]);
        if (!$miembro) {
            redirect(url('admin/plana-jerarquica'));
        }

        $data = [
            'id' => $id,
            'nombre' => $_POST['nombre'],
            'cargo' => $_POST['cargo'],
            'email' => $_POST['email'] ?? '',
            'categoria' => $_POST['categoria'] ?? 'plana_jerarquica',
            'orden' => $_POST['orden'] ?? 0
        ];

        // Handle Image Upload
        $imageSql = "";
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
             $uploadDir = PUBLIC_PATH . '/uploads/plana_jerarquica/';
             if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
             
             $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
             $filename = uniqid() . '_' . time() . '.' . $extension;
             
             if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                 $data['imagen'] = 'uploads/plana_jerarquica/' . $filename;
                 $imageSql = ", imagen = :imagen";
                 
                 // Delete old image
                 if ($miembro['imagen'] && file_exists(PUBLIC_PATH . '/' . $miembro['imagen'])) {
                     unlink(PUBLIC_PATH . '/' . $miembro['imagen']);
                 }
             }
        }

        $sql = "UPDATE plana_jerarquica SET 
                nombre = :nombre, 
                cargo = :cargo, 
                email = :email, 
                categoria = :categoria,
                orden = :orden
                $imageSql
                WHERE id = :id";
                
        try {
            $this->db->query($sql, $data);
            $_SESSION['success'] = 'Miembro actualizado correctamente';
            redirect(url('admin/plana-jerarquica'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al actualizar: ' . $e->getMessage();
            redirect(url('admin/plana-jerarquica/editar/' . $id));
        }
    }

    public function delete($id) {
        $miembro = $this->db->fetchOne("SELECT * FROM plana_jerarquica WHERE id = :id", ['id' => $id]);
        
        if ($miembro) {
            if ($miembro['imagen'] && file_exists(PUBLIC_PATH . '/' . $miembro['imagen'])) {
                unlink(PUBLIC_PATH . '/' . $miembro['imagen']);
            }
            $this->db->query("DELETE FROM plana_jerarquica WHERE id = :id", ['id' => $id]);
            $_SESSION['success'] = 'Miembro eliminado correctamente';
        }
        
        redirect(url('admin/plana-jerarquica'));
    }
}
