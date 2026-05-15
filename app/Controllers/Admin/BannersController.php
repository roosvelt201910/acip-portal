<?php
class BannersController {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance();
        if (!isAuthenticated()) redirect(url('admin/login'));
    }
    public function index() {
        $banners = $this->db->fetchAll("SELECT * FROM banners ORDER BY orden ASC");
        $pageTitle = 'Administrar Banners';
        $currentPage = 'banners';
        require APP_PATH . '/Views/admin/banners/index.php';
    }

    public function create() {
        $pageTitle = 'Nuevo Banner';
        $currentPage = 'banners';
        require APP_PATH . '/Views/admin/banners/create.php';
    }

    public function store() {
        $data = [
            'titulo' => $_POST['titulo'],
            'descripcion' => $_POST['descripcion'] ?? '',
            'enlace' => $_POST['enlace'] ?? '',
            'boton_texto' => $_POST['boton_texto'] ?? '',
            'orden' => $_POST['orden'] ?? 0,
            'activo' => isset($_POST['activo']) ? 1 : 0,
            'tipo_multimedia' => $_POST['tipo_multimedia'] ?? 'imagen',
            'video_url' => $_POST['video_url'] ?? null
        ];

        // Handle Image Upload
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
             $uploadDir = PUBLIC_PATH . '/uploads/banners/';
             if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
             
             $filename = uniqid() . '_' . basename($_FILES['imagen']['name']);
             if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                 $data['imagen'] = $filename;
             }
        }
        
        // Validation
        if ($data['tipo_multimedia'] === 'imagen' && !isset($data['imagen'])) {
             $_SESSION['error'] = 'La imagen es obligatoria para el tipo Imagen';
             redirect(url('admin/banners/crear'));
             return;
        }

        if (!isset($data['imagen'])) $data['imagen'] = null;

        $sql = "INSERT INTO banners (
            titulo, descripcion, enlace, boton_texto, orden, activo, imagen, tipo_multimedia, video_url
        ) VALUES (
            :titulo, :descripcion, :enlace, :boton_texto, :orden, :activo, :imagen, :tipo_multimedia, :video_url
        )";

        $this->db->query($sql, $data);
        redirect(url('admin/banners'));
    }

    public function edit($id) {
        $banner = $this->db->fetchOne("SELECT * FROM banners WHERE id = :id", ['id' => $id]);
        if (!$banner) {
            redirect(url('admin/banners'));
        }

        $pageTitle = 'Editar Banner';
        $currentPage = 'banners';
        require APP_PATH . '/Views/admin/banners/edit.php';
    }

    public function update($id) {
        $banner = $this->db->fetchOne("SELECT * FROM banners WHERE id = :id", ['id' => $id]);
        if (!$banner) {
            redirect(url('admin/banners'));
        }

        $data = [
            'id' => $id,
            'titulo' => $_POST['titulo'],
            'descripcion' => $_POST['descripcion'] ?? '',
            'enlace' => $_POST['enlace'] ?? '',
            'boton_texto' => $_POST['boton_texto'] ?? '',
            'orden' => $_POST['orden'] ?? 0,
            'activo' => isset($_POST['activo']) ? 1 : 0,
            'tipo_multimedia' => $_POST['tipo_multimedia'] ?? 'imagen',
            'video_url' => $_POST['video_url'] ?? null
        ];

        // Handle Image Upload
        $imageUpdate = "";
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
             $uploadDir = PUBLIC_PATH . '/uploads/banners/';
             if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
             
             $filename = uniqid() . '_' . basename($_FILES['imagen']['name']);
             if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                 $imageUpdate = ", imagen = :imagen";
                 $data['imagen'] = $filename;
                 
                 // Delete old image
                 if ($banner['imagen'] && file_exists($uploadDir . $banner['imagen'])) {
                     unlink($uploadDir . $banner['imagen']);
                 }
             }
        }

        $sql = "UPDATE banners SET 
                titulo = :titulo, 
                descripcion = :descripcion, 
                enlace = :enlace, 
                boton_texto = :boton_texto, 
                orden = :orden, 
                activo = :activo,
                tipo_multimedia = :tipo_multimedia,
                video_url = :video_url
                $imageUpdate
                WHERE id = :id";
                
        $this->db->query($sql, $data);
        redirect(url('admin/banners/editar/' . $id . '?success=1'));
    }

    public function delete($id) {
        $banner = $this->db->fetchOne("SELECT * FROM banners WHERE id = :id", ['id' => $id]);
        
        if ($banner) {
            if ($banner['imagen'] && file_exists(PUBLIC_PATH . '/uploads/banners/' . $banner['imagen'])) {
                unlink(PUBLIC_PATH . '/uploads/banners/' . $banner['imagen']);
            }
            $this->db->query("DELETE FROM banners WHERE id = :id", ['id' => $id]);
        }
        
        redirect(url('admin/banners'));
    }
}
