<?php
class ProgramasController {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance();
        if (!isAuthenticated()) redirect(url('admin/login'));
    }
    public function index() {
        $programas = $this->db->fetchAll("SELECT * FROM programas_estudio ORDER BY orden ASC");
        $pageTitle = 'Administrar Programas';
        $currentPage = 'programas';
        require APP_PATH . '/Views/admin/programas/index.php';
    }

    public function create() {
        $pageTitle = 'Nuevo Programa';
        $currentPage = 'programas';
        require APP_PATH . '/Views/admin/programas/create.php';
    }

    public function store() {
        $data = [
            'nombre' => $_POST['nombre'],
            'slug' => slugify($_POST['nombre']),
            'descripcion' => $_POST['descripcion'],
            'modalidad' => $_POST['modalidad'],
            'duracion_semestres' => (int)$_POST['duracion_semestres'],
            'perfil_egresado' => $_POST['perfil_egresado'] ?? '',
            'plan_estudios' => $_POST['plan_estudios'] ?? '',
            'ambito_laboral' => $_POST['ambito_laboral'] ?? '',
            'certificaciones' => $_POST['certificaciones'] ?? '',
            'horario_clases' => $_POST['horario_clases'] ?? '',
            'oficio_autorizacion' => $_POST['oficio_autorizacion'] ?? '',
            'matricula_info' => $_POST['matricula_info'] ?? '',
            'efsrt' => $_POST['efsrt'] ?? '',
            'orden' => (int)$_POST['orden'],
            'video_url' => $_POST['video_url'] ?? '',
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];

        // Handle Image Upload
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
             $uploadDir = PUBLIC_PATH . '/uploads/programas/';
             if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
             
             $filename = uniqid() . '_' . basename($_FILES['imagen']['name']);
             if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                 $data['imagen'] = 'uploads/programas/' . $filename;
             }
        }
        if (!isset($data['imagen'])) $data['imagen'] = null;

        // Handle Video Hero Upload or URL
        if (!empty($_POST['video_hero_url'])) {
            // Priority to URL if provided
            $data['video_hero'] = $_POST['video_hero_url'];
        } elseif (isset($_FILES['video_hero']) && $_FILES['video_hero']['error'] === UPLOAD_ERR_OK) {
             $uploadDir = PUBLIC_PATH . '/uploads/programas/videos/';
             if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
             
             $filename = uniqid() . '_' . basename($_FILES['video_hero']['name']);
             if (move_uploaded_file($_FILES['video_hero']['tmp_name'], $uploadDir . $filename)) {
                 $data['video_hero'] = 'uploads/programas/videos/' . $filename;
             }
        }
        if (!isset($data['video_hero'])) $data['video_hero'] = null;

        // Insert Program
        $sql = "INSERT INTO programas_estudio (
            nombre, slug, descripcion, modalidad, duracion_semestres, 
            perfil_egresado, plan_estudios, ambito_laboral, certificaciones, 
            horario_clases, oficio_autorizacion, matricula_info, efsrt,
            orden, activo, imagen, video_url, video_hero
        ) VALUES (
            :nombre, :slug, :descripcion, :modalidad, :duracion_semestres,
            :perfil_egresado, :plan_estudios, :ambito_laboral, :certificaciones,
            :horario_clases, :oficio_autorizacion, :matricula_info, :efsrt,
            :orden, :activo, :imagen, :video_url, :video_hero
        )";

        $this->db->query($sql, $data);
        $programaId = $this->db->lastInsertId();

        // Handle Gallery Uploads
        $this->handleMultiUpload('galeria', $programaId, 'programas_galeria');
        
        // Handle Logos/Aliados Uploads
        $this->handleMultiUpload('aliados', $programaId, 'programas_aliados');

        redirect(url('admin/programas'));
    }

    public function edit($id) {
        $programa = $this->db->fetchOne("SELECT * FROM programas_estudio WHERE id = :id", ['id' => $id]);
        if (!$programa) {
            redirect(url('admin/programas'));
        }
        
        // Fetch Gallery and Aliados
        $galeria = $this->db->fetchAll("SELECT * FROM programas_galeria WHERE programa_id = ?", [$id]);
        $aliados = $this->db->fetchAll("SELECT * FROM programas_aliados WHERE programa_id = ?", [$id]);

        $pageTitle = 'Editar Programa';
        $currentPage = 'programas';
        require APP_PATH . '/Views/admin/programas/edit.php';
    }

    public function update($id) {
        $programa = $this->db->fetchOne("SELECT * FROM programas_estudio WHERE id = :id", ['id' => $id]);
        if (!$programa) {
            redirect(url('admin/programas'));
        }

        $data = [
            'id' => $id,
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'modalidad' => $_POST['modalidad'],
            'duracion_semestres' => (int)$_POST['duracion_semestres'],
            'perfil_egresado' => $_POST['perfil_egresado'] ?? '',
            'plan_estudios' => $_POST['plan_estudios'] ?? '',
            'ambito_laboral' => $_POST['ambito_laboral'] ?? '',
            'certificaciones' => $_POST['certificaciones'] ?? '',
            'horario_clases' => $_POST['horario_clases'] ?? '',
            'oficio_autorizacion' => $_POST['oficio_autorizacion'] ?? '',
            'matricula_info' => $_POST['matricula_info'] ?? '',
            'efsrt' => $_POST['efsrt'] ?? '',
            'orden' => (int)$_POST['orden'],
            'video_url' => $_POST['video_url'] ?? '',
            'portada_media_type' => $_POST['portada_media_type'] ?? 'image',
            'portada_video_url' => $_POST['portada_video_url'] ?? '',
            'hero_media_type' => $_POST['hero_media_type'] ?? 'image',
            'hero_youtube_url' => $_POST['hero_youtube_url'] ?? '',
            'promo_media_type' => $_POST['promo_media_type'] ?? 'video',
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];
        
        // Handle Helper Image (Portada)
        $imageUpdate = "";
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
             $uploadDir = PUBLIC_PATH . '/uploads/programas/';
             if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
             
             $filename = uniqid() . '_' . basename($_FILES['imagen']['name']);
             if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                 $imageUpdate = ", imagen = :imagen";
                 $data['imagen'] = 'uploads/programas/' . $filename;
             }
        }

        // Handle Hero Image Upload
        $heroImageUpdate = "";
        if (isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] === UPLOAD_ERR_OK) {
             $uploadDir = PUBLIC_PATH . '/uploads/programas/hero/';
             if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
             
             $filename = uniqid() . '_' . basename($_FILES['hero_image']['name']);
             if (move_uploaded_file($_FILES['hero_image']['tmp_name'], $uploadDir . $filename)) {
                 $heroImageUpdate = ", hero_image = :hero_image";
                 $data['hero_image'] = 'uploads/programas/hero/' . $filename;
             }
        }

        // Handle Video Hero Upload or URL
        $videoUpdate = "";
        if (!empty($_POST['hero_youtube_url']) && ($_POST['hero_media_type'] ?? '') === 'youtube') {
            // YouTube URL for hero
            $videoUpdate = ", video_hero = :video_hero";
            $data['video_hero'] = $_POST['hero_youtube_url'];
        } elseif (isset($_FILES['video_hero']) && $_FILES['video_hero']['error'] === UPLOAD_ERR_OK) {
             $uploadDir = PUBLIC_PATH . '/uploads/programas/videos/';
             if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
             
             $filename = uniqid() . '_' . basename($_FILES['video_hero']['name']);
             if (move_uploaded_file($_FILES['video_hero']['tmp_name'], $uploadDir . $filename)) {
                 $videoUpdate = ", video_hero = :video_hero";
                 $data['video_hero'] = 'uploads/programas/videos/' . $filename;
             }
        }

        // Handle Promo Image Upload
        $promoImageUpdate = "";
        if (isset($_FILES['promo_image']) && $_FILES['promo_image']['error'] === UPLOAD_ERR_OK) {
             $uploadDir = PUBLIC_PATH . '/uploads/programas/promo/';
             if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
             
             $filename = uniqid() . '_' . basename($_FILES['promo_image']['name']);
             if (move_uploaded_file($_FILES['promo_image']['tmp_name'], $uploadDir . $filename)) {
                 $promoImageUpdate = ", promo_image = :promo_image";
                 $data['promo_image'] = 'uploads/programas/promo/' . $filename;
             }
        }

        $sql = "UPDATE programas_estudio SET 
                nombre = :nombre, 
                descripcion = :descripcion, 
                modalidad = :modalidad, 
                duracion_semestres = :duracion_semestres, 
                perfil_egresado = :perfil_egresado, 
                plan_estudios = :plan_estudios,
                ambito_laboral = :ambito_laboral,
                certificaciones = :certificaciones,
                horario_clases = :horario_clases,
                oficio_autorizacion = :oficio_autorizacion,
                matricula_info = :matricula_info,
                efsrt = :efsrt,
                orden = :orden, 
                activo = :activo,
                video_url = :video_url,
                portada_media_type = :portada_media_type,
                portada_video_url = :portada_video_url,
                hero_media_type = :hero_media_type,
                hero_youtube_url = :hero_youtube_url,
                promo_media_type = :promo_media_type
                $imageUpdate
                $heroImageUpdate
                $videoUpdate
                $promoImageUpdate
                WHERE id = :id";
        
        try {
            $this->db->query($sql, $data);
            
            // Handle Gallery Uploads
            $this->handleMultiUpload('galeria', $id, 'programas_galeria');
            
            // Handle Logos/Aliados Uploads
            $this->handleMultiUpload('aliados', $id, 'programas_aliados');
            
            $_SESSION['flash_success'] = 'Programa actualizado correctamente';
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = 'Error al actualizar el programa: ' . $e->getMessage();
        }
        
        redirect(url('admin/programas/editar/' . $id));
    }

    private function handleMultiUpload($inputName, $programaId, $tableName) {
        if (isset($_FILES[$inputName])) {
            $files = $_FILES[$inputName];
            $count = count($files['name']);
            $uploadDir = PUBLIC_PATH . '/uploads/programas/' . $inputName . '/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            for ($i = 0; $i < $count; $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $filename = uniqid() . '_' . basename($files['name'][$i]);
                    if (move_uploaded_file($files['tmp_name'][$i], $uploadDir . $filename)) {
                        $this->db->query("INSERT INTO $tableName (programa_id, imagen_path) VALUES (?, ?)", [
                            $programaId, 
                            'uploads/programas/' . $inputName . '/' . $filename
                        ]);
                    }
                }
            }
        }
    }

    public function delete($id) {
        $this->db->query("DELETE FROM programas_estudio WHERE id = :id", ['id' => $id]);
        redirect(url('admin/programas'));
    }

    public function deleteImage($type, $id) {
        $table = ($type === 'galeria') ? 'programas_galeria' : 'programas_aliados';
        $image = $this->db->fetchOne("SELECT * FROM $table WHERE id = ?", [$id]);
        
        if ($image) {
            // Delete file from server
            if (file_exists(PUBLIC_PATH . '/' . $image['imagen_path'])) {
                unlink(PUBLIC_PATH . '/' . $image['imagen_path']);
            }
            // Delete record
            $this->db->query("DELETE FROM $table WHERE id = ?", [$id]);
        }
        
        // Return JSON if AJAX, or redirect back
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['success' => true]);
            exit;
        }
        
        // Fallback redirect (though we usually call this via AJAX)
        redirect(url('admin/programas/editar/' . $image['programa_id']));
    }

    public function updateSlug($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $slug = $_POST['slug'] ?? '';
            if (empty($slug)) {
                echo json_encode(['success' => false, 'message' => 'El slug no puede estar vacío']);
                exit;
            }

            // Simple sanitation
            $slug = strtolower(trim($slug));
            $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
            $slug = preg_replace('/-+/', '-', $slug);

            $this->db->query("UPDATE programas_estudio SET slug = :slug WHERE id = :id", [
                'slug' => $slug,
                'id' => $id
            ]);

            echo json_encode(['success' => true, 'new_slug' => $slug, 'new_url' => url('programas/' . $slug)]);
            exit;
        }
    }
}
