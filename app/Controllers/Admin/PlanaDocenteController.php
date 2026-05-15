<?php
class PlanaDocenteController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
        if (!isAuthenticated()) redirect(url('admin/login'));
    }

    public function index() {
        $sql = "SELECT pd.*, pe.nombre as programa_nombre 
                FROM plana_docente pd 
                LEFT JOIN programas_estudio pe ON pd.programa_id = pe.id 
                ORDER BY pe.orden ASC, pd.orden ASC, pd.created_at DESC";
        $docentes = $this->db->fetchAll($sql);
        
        $programas = $this->db->fetchAll("SELECT id, nombre FROM programas_estudio ORDER BY orden ASC");
        
        $pageTitle = 'Plana Docente';
        $currentPage = 'plana_docente';
        require APP_PATH . '/Views/admin/plana_docente/index.php';
    }

    public function create() {
        $programas = $this->db->fetchAll("SELECT id, nombre FROM programas_estudio ORDER BY orden ASC");
        $pageTitle = 'Nuevo Docente';
        $currentPage = 'plana_docente';
        require APP_PATH . '/Views/admin/plana_docente/form.php';
    }

    public function store() {
        $data = [
            'nombre' => $_POST['nombre'],
            'cargo' => $_POST['cargo'] ?? 'Docente',
            'programa_id' => !empty($_POST['programa_id']) ? $_POST['programa_id'] : null,
            'orden' => $_POST['orden'] ?? 0,
            'foto' => null,
            'cv' => null,
            'carga_horaria' => null,
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];

        // Upload Helper
        $uploadBase = PUBLIC_PATH . '/uploads/plana_docente/';
        if (!is_dir($uploadBase)) mkdir($uploadBase, 0777, true);

        // Handle Foto
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $filename = 'foto_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadBase . $filename)) {
                $data['foto'] = 'uploads/plana_docente/' . $filename;
            }
        }

        // Handle CV
        if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
            $filename = 'cv_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['cv']['tmp_name'], $uploadBase . $filename)) {
                $data['cv'] = 'uploads/plana_docente/' . $filename;
            }
        }

        // Handle Carga Horaria
        if (isset($_FILES['carga_horaria']) && $_FILES['carga_horaria']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['carga_horaria']['name'], PATHINFO_EXTENSION);
            $filename = 'ch_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['carga_horaria']['tmp_name'], $uploadBase . $filename)) {
                $data['carga_horaria'] = 'uploads/plana_docente/' . $filename;
            }
        }

        $sql = "INSERT INTO plana_docente (nombre, cargo, programa_id, orden, activo, foto, cv, carga_horaria) 
                VALUES (:nombre, :cargo, :programa_id, :orden, :activo, :foto, :cv, :carga_horaria)";
        
        try {
            $this->db->query($sql, $data);
            $_SESSION['success'] = 'Docente registrado correctamente';
            redirect(url('admin/plana-docente'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al registrar: ' . $e->getMessage();
            redirect(url('admin/plana-docente/crear'));
        }
    }

    public function edit($id) {
        $docente = $this->db->fetchOne("SELECT * FROM plana_docente WHERE id = :id", ['id' => $id]);
        if (!$docente) {
            $_SESSION['error'] = 'Docente no encontrado';
            redirect(url('admin/plana-docente'));
        }

        $programas = $this->db->fetchAll("SELECT id, nombre FROM programas_estudio ORDER BY orden ASC");
        
        $pageTitle = 'Editar Docente';
        $currentPage = 'plana_docente';
        require APP_PATH . '/Views/admin/plana_docente/form.php';
    }

    public function update($id) {
        $docente = $this->db->fetchOne("SELECT * FROM plana_docente WHERE id = :id", ['id' => $id]);
        if (!$docente) {
            redirect(url('admin/plana-docente'));
        }

        $data = [
            'id' => $id,
            'nombre' => $_POST['nombre'],
            'cargo' => $_POST['cargo'] ?? 'Docente',
            'programa_id' => !empty($_POST['programa_id']) ? $_POST['programa_id'] : null,
            'orden' => $_POST['orden'] ?? 0,
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];

        $uploadBase = PUBLIC_PATH . '/uploads/plana_docente/';
        if (!is_dir($uploadBase)) mkdir($uploadBase, 0777, true);

        // Helper to update file
        $fileUpdates = "";
        
        // Foto
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $filename = 'foto_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadBase . $filename)) {
                $data['foto'] = 'uploads/plana_docente/' . $filename;
                $fileUpdates .= ", foto = :foto";
                if ($docente['foto'] && file_exists(PUBLIC_PATH . '/' . $docente['foto'])) unlink(PUBLIC_PATH . '/' . $docente['foto']);
            }
        }

        // CV
        if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
            $filename = 'cv_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['cv']['tmp_name'], $uploadBase . $filename)) {
                $data['cv'] = 'uploads/plana_docente/' . $filename;
                $fileUpdates .= ", cv = :cv";
                if ($docente['cv'] && file_exists(PUBLIC_PATH . '/' . $docente['cv'])) unlink(PUBLIC_PATH . '/' . $docente['cv']);
            }
        }

        // Carga Horaria
        if (isset($_FILES['carga_horaria']) && $_FILES['carga_horaria']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['carga_horaria']['name'], PATHINFO_EXTENSION);
            $filename = 'ch_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['carga_horaria']['tmp_name'], $uploadBase . $filename)) {
                $data['carga_horaria'] = 'uploads/plana_docente/' . $filename;
                $fileUpdates .= ", carga_horaria = :carga_horaria";
                if ($docente['carga_horaria'] && file_exists(PUBLIC_PATH . '/' . $docente['carga_horaria'])) unlink(PUBLIC_PATH . '/' . $docente['carga_horaria']);
            }
        }

        $sql = "UPDATE plana_docente SET 
                nombre = :nombre, 
                cargo = :cargo, 
                programa_id = :programa_id, 
                orden = :orden,
                activo = :activo
                $fileUpdates
                WHERE id = :id";
                
        try {
            $this->db->query($sql, $data);
            $_SESSION['success'] = 'Docente actualizado correctamente';
            redirect(url('admin/plana-docente'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al actualizar: ' . $e->getMessage();
            redirect(url('admin/plana-docente/editar/' . $id));
        }
    }

    public function delete($id) {
        $docente = $this->db->fetchOne("SELECT * FROM plana_docente WHERE id = :id", ['id' => $id]);
        
        if ($docente) {
            if ($docente['foto'] && file_exists(PUBLIC_PATH . '/' . $docente['foto'])) unlink(PUBLIC_PATH . '/' . $docente['foto']);
            if ($docente['cv'] && file_exists(PUBLIC_PATH . '/' . $docente['cv'])) unlink(PUBLIC_PATH . '/' . $docente['cv']);
            if ($docente['carga_horaria'] && file_exists(PUBLIC_PATH . '/' . $docente['carga_horaria'])) unlink(PUBLIC_PATH . '/' . $docente['carga_horaria']);
            
            $this->db->query("DELETE FROM plana_docente WHERE id = :id", ['id' => $id]);
            $_SESSION['success'] = 'Docente eliminado correctamente';
        }
        
        redirect(url('admin/plana-docente'));
    }
}
