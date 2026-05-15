<?php

class AdmisionController {
    private $db;

    public function __construct() {
        if (!isAuthenticated() || !isAdmin()) {
            redirect(url('admin/login'));
        }
        $this->db = Database::getInstance();
    }

    public function index() {
        $procesos = $this->db->fetchAll("SELECT * FROM admision_procesos ORDER BY created_at DESC");
        $pageTitle = 'Gestión de Admisión';
        $currentPage = 'admision';
        
        ob_start();
        require APP_PATH . '/Views/admin/admision/index.php';
        $content = ob_get_clean();
        
        require APP_PATH . '/Views/layouts/admin.php';
    }

    public function create() {
        $pageTitle = 'Nuevo Proceso de Admisión';
        $currentPage = 'admision';
        
        ob_start();
        require APP_PATH . '/Views/admin/admision/form.php';
        $content = ob_get_clean();
        
        require APP_PATH . '/Views/layouts/admin.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titulo' => sanitize($_POST['titulo']),
                'descripcion' => sanitize($_POST['descripcion']),
                'fecha_inicio' => $_POST['fecha_inicio'] ?: null,
                'fecha_fin' => $_POST['fecha_fin'] ?: null,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];

            // Handle Banner Upload
            if (isset($_FILES['banner_url']) && $_FILES['banner_url']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = PUBLIC_PATH . '/uploads/admision/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $fileName = time() . '_banner_' . basename($_FILES['banner_url']['name']);
                if (move_uploaded_file($_FILES['banner_url']['tmp_name'], $uploadDir . $fileName)) {
                    $data['banner_url'] = 'uploads/admision/' . $fileName;
                }
            }

            // Handle Calendar Upload
            if (isset($_FILES['calendario_url']) && $_FILES['calendario_url']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = PUBLIC_PATH . '/uploads/admision/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $fileName = time() . '_cal_' . basename($_FILES['calendario_url']['name']);
                if (move_uploaded_file($_FILES['calendario_url']['tmp_name'], $uploadDir . $fileName)) {
                    $data['calendario_url'] = 'uploads/admision/' . $fileName;
                }
            }

            if ($data['activo'] == 1) {
                 // Deactivate others if this one is active
                 $this->db->query("UPDATE admision_procesos SET activo = 0");
            }

            $this->db->insert('admision_procesos', $data);
            $_SESSION['success'] = 'Proceso creado exitosamente';
            redirect(url('admin/admision'));
        }
    }

    public function edit($id) {
        $proceso = $this->db->fetchOne("SELECT * FROM admision_procesos WHERE id = ?", [$id]);
        if (!$proceso) redirect(url('admin/admision'));

        $pageTitle = 'Editar Proceso de Admisión';
        $currentPage = 'admision';
        
        ob_start();
        require APP_PATH . '/Views/admin/admision/form.php';
        $content = ob_get_clean();
        
        require APP_PATH . '/Views/layouts/admin.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titulo' => sanitize($_POST['titulo']),
                'descripcion' => sanitize($_POST['descripcion']),
                'fecha_inicio' => $_POST['fecha_inicio'] ?: null,
                'fecha_fin' => $_POST['fecha_fin'] ?: null,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];

             // Handle Banner Upload
             if (isset($_FILES['banner_url']) && $_FILES['banner_url']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = PUBLIC_PATH . '/uploads/admision/';
                if (!is_dir($uploadDir)) {
                    if (!mkdir($uploadDir, 0777, true)) {
                        $_SESSION['error'] = 'Error al crear el directorio de imágenes.';
                        redirect(url('admin/admision/edit/' . $id));
                    }
                }
                
                $fileName = time() . '_banner_' . basename($_FILES['banner_url']['name']);
                if (move_uploaded_file($_FILES['banner_url']['tmp_name'], $uploadDir . $fileName)) {
                    $data['banner_url'] = 'uploads/admision/' . $fileName;
                } else {
                    $_SESSION['error'] = 'Error al mover la imagen del banner.';
                    redirect(url('admin/admision/edit/' . $id));
                }
            } elseif (isset($_FILES['banner_url']) && $_FILES['banner_url']['error'] !== UPLOAD_ERR_NO_FILE) {
                // Log/Show specific error
                $errorMsg = 'Error al subir banner: ' . $this->getUploadErrorMessage($_FILES['banner_url']['error']);
                $_SESSION['error'] = $errorMsg;
                redirect(url('admin/admision/edit/' . $id));
            }

            // Handle Calendar Upload
            if (isset($_FILES['calendario_url']) && $_FILES['calendario_url']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = PUBLIC_PATH . '/uploads/admision/';
                // Dir check redundant if already checked above but good for safety
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $fileName = time() . '_cal_' . basename($_FILES['calendario_url']['name']);
                if (move_uploaded_file($_FILES['calendario_url']['tmp_name'], $uploadDir . $fileName)) {
                    $data['calendario_url'] = 'uploads/admision/' . $fileName;
                } else {
                    $_SESSION['error'] = 'Error al mover la imagen del calendario.';
                    redirect(url('admin/admision/edit/' . $id));
                }
            } elseif (isset($_FILES['calendario_url']) && $_FILES['calendario_url']['error'] !== UPLOAD_ERR_NO_FILE) {
                 $errorMsg = 'Error al subir calendario: ' . $this->getUploadErrorMessage($_FILES['calendario_url']['error']);
                 $_SESSION['error'] = $errorMsg;
                 redirect(url('admin/admision/edit/' . $id));
            }

            if ($data['activo'] == 1) {
                // Deactivate others
                $this->db->query("UPDATE admision_procesos SET activo = 0 WHERE id != ?", [$id]);
           }

            $this->db->update('admision_procesos', $data, "id = :id", ['id' => $id]);
            $_SESSION['success'] = 'Proceso actualizado exitosamente';
            redirect(url('admin/admision'));
        }
    }

    private function getUploadErrorMessage($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return 'El archivo excede el tamaño máximo permitido por el servidor.';
            case UPLOAD_ERR_FORM_SIZE:
                return 'El archivo excede el tamaño máximo permitido en el formulario.';
            case UPLOAD_ERR_PARTIAL:
                return 'El archivo se subió parcialmente.';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Falta la carpeta temporal.';
            case UPLOAD_ERR_CANT_WRITE:
                return 'No se pudo escribir el archivo en el disco.';
            case UPLOAD_ERR_EXTENSION:
                return 'Una extensión de PHP detuvo la subida.';
            default:
                return 'Error desconocido de subida.';
        }
    }

    public function delete($id) {
        $this->db->delete('admision_procesos', "id = ?", [$id]);
        $_SESSION['success'] = 'Proceso eliminado exitosamente';
        redirect(url('admin/admision'));
    }
    
    // Requirements Management
    public function requisitos($id) {
        $proceso = $this->db->fetchOne("SELECT * FROM admision_procesos WHERE id = ?", [$id]);
        if (!$proceso) redirect(url('admin/admision'));
        
        $requisitos = $this->db->fetchAll("SELECT * FROM admision_requisitos WHERE proceso_id = ? ORDER BY orden ASC", [$id]);

        $pageTitle = 'Requisitos - ' . $proceso['titulo'];
        $currentPage = 'admision';
        
        ob_start();
        require APP_PATH . '/Views/admin/admision/requisitos.php';
        $content = ob_get_clean();
        
        require APP_PATH . '/Views/layouts/admin.php';
    }

    public function storeRequisito($procesoId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['requisito_id']) && !empty($_POST['requisito_id'])) {
                // Update
                $this->updateRequisito($_POST['requisito_id'], $procesoId);
            } else {
                // Create
                $data = [
                    'proceso_id' => $procesoId,
                    'descripcion' => trim($_POST['descripcion']), // Allow HTML
                    'orden' => (int)$_POST['orden']
                ];
                $this->db->insert('admision_requisitos', $data);
                $_SESSION['success'] = 'Requisito agregado';
                redirect(url('admin/admision/requisitos/' . $procesoId));
            }
        }
    }

    private function updateRequisito($id, $procesoId) {
        $data = [
            'descripcion' => trim($_POST['descripcion']), // Allow HTML
            'orden' => (int)$_POST['orden']
        ];
        $this->db->update('admision_requisitos', $data, "id = :id", ['id' => $id]);
        $_SESSION['success'] = 'Requisito actualizado';
        redirect(url('admin/admision/requisitos/' . $procesoId));
    }
    
    public function deleteRequisito($id) {
        $req = $this->db->fetchOne("SELECT proceso_id FROM admision_requisitos WHERE id = ?", [$id]);
        if ($req) {
            $this->db->delete('admision_requisitos', "id = ?", [$id]);
            redirect(url('admin/admision/requisitos/' . $req['proceso_id']));
        }
    }

    // Modalities Management
    public function modalidades($id) {
        $proceso = $this->db->fetchOne("SELECT * FROM admision_procesos WHERE id = ?", [$id]);
        if (!$proceso) redirect(url('admin/admision'));
        
        $modalidades = $this->db->fetchAll("SELECT * FROM admision_modalidades WHERE proceso_id = ? ORDER BY orden ASC", [$id]);

        $pageTitle = 'Modalidades - ' . $proceso['titulo'];
        $currentPage = 'admision';
        
        ob_start();
        require APP_PATH . '/Views/admin/admision/modalidades.php';
        $content = ob_get_clean();
        
        require APP_PATH . '/Views/layouts/admin.php';
    }

    public function storeModalidad($procesoId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'proceso_id' => $procesoId,
                'titulo' => sanitize($_POST['titulo']),
                'descripcion' => trim($_POST['descripcion']), // Allow rich text/HTML
                'orden' => (int)$_POST['orden']
            ];
            $this->db->insert('admision_modalidades', $data);
            $_SESSION['success'] = 'Modalidad agregada';
            redirect(url('admin/admision/modalidades/' . $procesoId));
        }
    }

    public function deleteModalidad($id) {
        $mod = $this->db->fetchOne("SELECT proceso_id FROM admision_modalidades WHERE id = ?", [$id]);
        if ($mod) {
            $this->db->delete('admision_modalidades', "id = ?", [$id]);
            redirect(url('admin/admision/modalidades/' . $mod['proceso_id']));
        }
    }

    // Results Management
    public function resultados($id) {
        $proceso = $this->db->fetchOne("SELECT * FROM admision_procesos WHERE id = ?", [$id]);
        if (!$proceso) redirect(url('admin/admision'));
        
        // Fetch files with Program Name
        $sqlFiles = "SELECT f.*, p.nombre as programa_nombre 
                     FROM admision_resultados_archivos f 
                     LEFT JOIN programas_estudio p ON f.programa_id = p.id 
                     WHERE f.proceso_id = ? 
                     ORDER BY f.orden ASC";
        $archivos = $this->db->fetchAll($sqlFiles, [$id]);

        // Fetch Study Programs for Dropdown
        $programas = $this->db->fetchAll("SELECT id, nombre FROM programas_estudio WHERE activo = 1 ORDER BY nombre ASC");

        // Simple pagination could be added here
        $resultados = $this->db->fetchAll("SELECT * FROM admision_resultados WHERE proceso_id = ? ORDER BY orden_merito ASC, puntaje DESC", [$id]);

        $pageTitle = 'Resultados - ' . $proceso['titulo'];
        $currentPage = 'admision';
        
        ob_start();
        require APP_PATH . '/Views/admin/admision/resultados.php';
        $content = ob_get_clean();
        
        require APP_PATH . '/Views/layouts/admin.php';
    }

    public function storeResultadoArchivo($procesoId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = PUBLIC_PATH . '/uploads/resultados/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $fileName = time() . '_' . basename($_FILES['archivo']['name']);
                if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadDir . $fileName)) {
                    $programId = !empty($_POST['programa_id']) ? (int)$_POST['programa_id'] : null;
                    
                    $data = [
                        'proceso_id' => $procesoId,
                        'programa_id' => $programId,
                        'titulo' => sanitize($_POST['titulo']),
                        'archivo_url' => 'uploads/resultados/' . $fileName,
                        'orden' => (int)$_POST['orden']
                    ];
                    $this->db->insert('admision_resultados_archivos', $data);
                    $_SESSION['success'] = 'Archivo subido exitosamente';
                } else {
                    $_SESSION['error'] = 'Error al mover el archivo';
                }
            } else {
                $_SESSION['error'] = 'Error en la subida del archivo o no se seleccionó archivo';
            }
            redirect(url('admin/admision/resultados/' . $procesoId));
        }
    }

    public function deleteResultadoArchivo($id) {
        $archivo = $this->db->fetchOne("SELECT * FROM admision_resultados_archivos WHERE id = ?", [$id]);
        if ($archivo) {
            // Optional: Delete physical file if needed
            // if (file_exists(PUBLIC_PATH . '/' . $archivo['archivo_url'])) {
            //     unlink(PUBLIC_PATH . '/' . $archivo['archivo_url']);
            // }
            
            $this->db->delete('admision_resultados_archivos', "id = ?", [$id]);
            redirect(url('admin/admision/resultados/' . $archivo['proceso_id']));
        }
    }

    public function storeResultado($procesoId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'proceso_id' => $procesoId,
                'dni' => sanitize($_POST['dni']),
                'nombres_apellidos' => sanitize($_POST['nombres_apellidos']),
                'programa_estudio' => sanitize($_POST['programa_estudio']),
                'modalidad' => sanitize($_POST['modalidad']),
                'puntaje' => (float)$_POST['puntaje'],
                'condicion' => sanitize($_POST['condicion']),
                'orden_merito' => (int)$_POST['orden_merito']
            ];
            $this->db->insert('admision_resultados', $data);
            $_SESSION['success'] = 'Resultado agregado';
            redirect(url('admin/admision/resultados/' . $procesoId));
        }
    }

    public function deleteResultado($id) {
        $res = $this->db->fetchOne("SELECT proceso_id FROM admision_resultados WHERE id = ?", [$id]);
        if ($res) {
            $this->db->delete('admision_resultados', "id = ?", [$id]);
            redirect(url('admin/admision/resultados/' . $res['proceso_id']));
        }
    }

    // Documents Management (Descargas)
    public function documentos($id) {
        $proceso = $this->db->fetchOne("SELECT * FROM admision_procesos WHERE id = ?", [$id]);
        if (!$proceso) redirect(url('admin/admision'));
        
        $documentos = $this->db->fetchAll("SELECT * FROM admision_documentos WHERE proceso_id = ? ORDER BY orden ASC", [$id]);

        $pageTitle = 'Documentos - ' . $proceso['titulo'];
        $currentPage = 'admision';
        
        ob_start();
        require APP_PATH . '/Views/admin/admision/documentos.php';
        $content = ob_get_clean();
        
        require APP_PATH . '/Views/layouts/admin.php';
    }

    public function storeDocumento($procesoId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = PUBLIC_PATH . '/uploads/documentos/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $fileName = time() . '_' . basename($_FILES['archivo']['name']);
                if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadDir . $fileName)) {
                    $data = [
                        'proceso_id' => $procesoId,
                        'titulo' => sanitize($_POST['titulo']),
                        'archivo_url' => 'uploads/documentos/' . $fileName,
                        'orden' => (int)$_POST['orden']
                    ];
                    $this->db->insert('admision_documentos', $data);
                    $_SESSION['success'] = 'Documento subido exitosamente';
                } else {
                    $_SESSION['error'] = 'Error al mover el archivo';
                }
            } else {
                $_SESSION['error'] = 'Error en la subida del archivo o no se seleccionó archivo';
            }
            redirect(url('admin/admision/documentos/' . $procesoId));
        }
    }

    public function deleteDocumento($id) {
        $doc = $this->db->fetchOne("SELECT * FROM admision_documentos WHERE id = ?", [$id]);
        if ($doc) {
            // Optional: Delete physical file
            // if (file_exists(PUBLIC_PATH . '/' . $doc['archivo_url'])) {
            //     unlink(PUBLIC_PATH . '/' . $doc['archivo_url']);
            // }
            
            $this->db->delete('admision_documentos', "id = ?", [$id]);
            redirect(url('admin/admision/documentos/' . $doc['proceso_id']));
        }
    }
}
