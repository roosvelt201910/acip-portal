<?php
class WhyChooseUsController {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance();
        if (!isAuthenticated()) redirect(url('admin/login'));
    }

    public function index() {
        $items = $this->db->fetchAll("SELECT * FROM why_choose_us ORDER BY orden ASC");
        $pageTitle = 'Por qué elegirnos';
        $currentPage = 'why_choose_us';
        require APP_PATH . '/Views/admin/why_choose_us/index.php';
    }

    public function create() {
        $pageTitle = 'Nuevo Elemento';
        $currentPage = 'why_choose_us';
        require APP_PATH . '/Views/admin/why_choose_us/create.php';
    }

    public function store() {
        $data = [
            'titulo' => $_POST['titulo'],
            'descripcion' => $_POST['descripcion'] ?? '',
            'orden' => $_POST['orden'] ?? 0,
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];

        // Handle Image/Icon Upload
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
             $uploadDir = PUBLIC_PATH . '/uploads/why_choose_us/';
             if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
             
             $filename = uniqid() . '_' . basename($_FILES['imagen']['name']);
             if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                 $data['imagen'] = $filename;
             }
        }
        
        if (!isset($data['imagen'])) $data['imagen'] = null;

        $sql = "INSERT INTO why_choose_us (
            titulo, descripcion, orden, activo, imagen
        ) VALUES (
            :titulo, :descripcion, :orden, :activo, :imagen
        )";

        $this->db->query($sql, $data);
        redirect(url('admin/why-choose-us'));
    }

    public function edit($id) {
        $item = $this->db->fetchOne("SELECT * FROM why_choose_us WHERE id = :id", ['id' => $id]);
        if (!$item) {
            redirect(url('admin/why-choose-us'));
        }

        $pageTitle = 'Editar Elemento';
        $currentPage = 'why_choose_us';
        require APP_PATH . '/Views/admin/why_choose_us/edit.php';
    }

    public function update($id) {
        $item = $this->db->fetchOne("SELECT * FROM why_choose_us WHERE id = :id", ['id' => $id]);
        if (!$item) {
            redirect(url('admin/why-choose-us'));
        }

        $data = [
            'id' => $id,
            'titulo' => $_POST['titulo'],
            'descripcion' => $_POST['descripcion'] ?? '',
            'orden' => $_POST['orden'] ?? 0,
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];

        // Handle Image Upload
        $imageUpdate = "";
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
             $uploadDir = PUBLIC_PATH . '/uploads/why_choose_us/';
             if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
             
             $filename = uniqid() . '_' . basename($_FILES['imagen']['name']);
             if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                 $imageUpdate = ", imagen = :imagen";
                 $data['imagen'] = $filename;
                 
                 // Delete old image
                 if ($item['imagen'] && file_exists($uploadDir . $item['imagen'])) {
                     unlink($uploadDir . $item['imagen']);
                 }
             }
        }

        $sql = "UPDATE why_choose_us SET 
                titulo = :titulo, 
                descripcion = :descripcion, 
                orden = :orden, 
                activo = :activo
                $imageUpdate
                WHERE id = :id";
                
        $this->db->query($sql, $data);
        redirect(url('admin/why-choose-us/editar/' . $id . '?success=1'));
    }

    public function delete($id) {
        $item = $this->db->fetchOne("SELECT * FROM why_choose_us WHERE id = :id", ['id' => $id]);
        
        if ($item) {
            if ($item['imagen'] && file_exists(PUBLIC_PATH . '/uploads/why_choose_us/' . $item['imagen'])) {
                unlink(PUBLIC_PATH . '/uploads/why_choose_us/' . $item['imagen']);
            }
            $this->db->query("DELETE FROM why_choose_us WHERE id = :id", ['id' => $id]);
        }
        
        redirect(url('admin/why-choose-us'));
    }
}
