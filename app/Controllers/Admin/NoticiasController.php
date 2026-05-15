<?php
class NoticiasController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
        if (!isAuthenticated()) redirect(url('admin/login'));
    }
    
    public function index() {
        $noticias = $this->db->fetchAll("SELECT * FROM noticias ORDER BY fecha_publicacion DESC");
        $pageTitle = 'Administrar Noticias';
        $currentPage = 'noticias';
        require APP_PATH . '/Views/admin/noticias/index.php';
    }

    public function create() {
        $pageTitle = 'Nueva Noticia';
        $currentPage = 'noticias';
        require APP_PATH . '/Views/admin/noticias/create.php';
    }

    public function store() {
        $data = [
            'titulo' => $_POST['titulo'],
            'slug' => slugify($_POST['titulo']),
            'resumen' => $_POST['resumen'],
            'contenido' => $_POST['contenido'],
            'categoria' => $_POST['categoria'],
            'tipo_encabezado' => $_POST['tipo_encabezado'] ?? 'imagen',
            'video_encabezado' => $_POST['video_encabezado'] ?? null,
            'autor_id' => $_SESSION['user_id'] ?? 1,
            'fecha_publicacion' => $_POST['fecha_publicacion'] ?: date('Y-m-d H:i:s'),
            'estado' => $_POST['estado'] ?? 'borrador'
        ];

        // Debug Log
        $logFile = BASE_PATH . '/logs/upload_debug.log';
        if (!is_dir(dirname($logFile))) mkdir(dirname($logFile), 0777, true);
        
        file_put_contents($logFile, date('[Y-m-d H:i:s] ') . "Store Request: " . print_r($_FILES, true) . "\n", FILE_APPEND);

        // Handle Image Upload
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
             $uploadDir = PUBLIC_PATH . '/uploads/noticias/';
             if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
             
             $filename = uniqid() . '_' . basename($_FILES['imagen']['name']);
             if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                 $data['imagen'] = 'uploads/noticias/' . $filename;
             }
        } elseif (isset($_FILES['imagen'])) {
             // Log error if needed
        }
        
        // Handle Video Upload
        if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
             $videoDir = PUBLIC_PATH . '/uploads/videos/';
             if (!is_dir($videoDir)) mkdir($videoDir, 0777, true);
             
             $videoName = uniqid() . '_' . basename($_FILES['video_file']['name']);
             if (move_uploaded_file($_FILES['video_file']['tmp_name'], $videoDir . $videoName)) {
                 $data['video_encabezado'] = 'uploads/videos/' . $videoName; // Override URL if file uploaded
             }
        }
        
        if (!isset($data['imagen'])) $data['imagen'] = null;

        $sql = "INSERT INTO noticias (
            titulo, slug, resumen, contenido, categoria, tipo_encabezado, video_encabezado,
            autor_id, fecha_publicacion, estado, imagen
        ) VALUES (
            :titulo, :slug, :resumen, :contenido, :categoria, :tipo_encabezado, :video_encabezado,
            :autor_id, :fecha_publicacion, :estado, :imagen
        )";

        $this->db->query($sql, $data);
        redirect(url('admin/noticias'));
    }

    public function edit($id) {
        $noticia = $this->db->fetchOne("SELECT * FROM noticias WHERE id = :id", ['id' => $id]);
        if (!$noticia) {
            redirect(url('admin/noticias'));
        }

        $pageTitle = 'Editar Noticia';
        $currentPage = 'noticias';
        require APP_PATH . '/Views/admin/noticias/edit.php';
    }

    public function update($id) {
        $noticia = $this->db->fetchOne("SELECT * FROM noticias WHERE id = :id", ['id' => $id]);
        if (!$noticia) {
            redirect(url('admin/noticias'));
        }

        $data = [
            'id' => $id,
            'titulo' => $_POST['titulo'],
            'resumen' => $_POST['resumen'],
            'contenido' => $_POST['contenido'],
            'categoria' => $_POST['categoria'],
            'tipo_encabezado' => $_POST['tipo_encabezado'] ?? 'imagen',
            'video_encabezado' => $_POST['video_encabezado'] ?? null,
            'fecha_publicacion' => $_POST['fecha_publicacion'],
            'estado' => $_POST['estado']
        ];
        
        // Debug Log
        // ...

        // Handle Image Update
        $imageUpdate = "";
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
             $uploadDir = PUBLIC_PATH . '/uploads/noticias/';
             if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
             
             $filename = uniqid() . '_' . basename($_FILES['imagen']['name']);
             if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                 $imageUpdate = ", imagen = :imagen";
                 $data['imagen'] = 'uploads/noticias/' . $filename;
             }
        }

        // Handle Video Upload (Update)
        if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
             $videoDir = PUBLIC_PATH . '/uploads/videos/';
             if (!is_dir($videoDir)) mkdir($videoDir, 0777, true);
             
             $videoName = uniqid() . '_' . basename($_FILES['video_file']['name']);
             if (move_uploaded_file($_FILES['video_file']['tmp_name'], $videoDir . $videoName)) {
                 $data['video_encabezado'] = 'uploads/videos/' . $videoName;
             }
        }

        $sql = "UPDATE noticias SET 
                titulo = :titulo, 
                resumen = :resumen, 
                contenido = :contenido, 
                categoria = :categoria, 
                tipo_encabezado = :tipo_encabezado,
                video_encabezado = :video_encabezado,
                fecha_publicacion = :fecha_publicacion,
                estado = :estado
                $imageUpdate
                WHERE id = :id";
                
        $this->db->query($sql, $data);
        
        // Redirect back to edit page with success parameter
        redirect(url('admin/noticias/editar/' . $id . '?success=1'));
    }

    public function delete($id) {
        $noticia = $this->db->fetchOne("SELECT * FROM noticias WHERE id = :id", ['id' => $id]);
        
        if ($noticia) {
            // Delete image if exists
            if ($noticia['imagen'] && file_exists(PUBLIC_PATH . '/' . $noticia['imagen'])) {
                unlink(PUBLIC_PATH . '/' . $noticia['imagen']);
            }
            
            $this->db->query("DELETE FROM noticias WHERE id = :id", ['id' => $id]);
        }
        
        redirect(url('admin/noticias'));
    }
}
