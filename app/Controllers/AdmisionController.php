<?php

class AdmisionController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function index() {
        $proceso = null;

        // Check for preview ID
        if (isset($_GET['id'])) {
            $proceso = $this->db->fetchOne("SELECT * FROM admision_procesos WHERE id = ?", [$_GET['id']]);
        }

        // Get active process if no preview or preview not found
        if (!$proceso) {
            $proceso = $this->db->fetchOne("SELECT * FROM admision_procesos WHERE activo = 1 ORDER BY created_at DESC LIMIT 1");
        }
        
        // If no active process, get latest one
        if (!$proceso) {
            $proceso = $this->db->fetchOne("SELECT * FROM admision_procesos ORDER BY created_at DESC LIMIT 1");
        }

        $requisitos = [];
        $modalidades = [];
        
        if ($proceso) {
            $requisitos = $this->db->fetchAll("SELECT * FROM admision_requisitos WHERE proceso_id = ? ORDER BY orden ASC", [$proceso['id']]);
            $modalidades = $this->db->fetchAll("SELECT * FROM admision_modalidades WHERE proceso_id = ? ORDER BY orden ASC", [$proceso['id']]);
            $sqlFiles = "SELECT f.*, p.nombre as programa_nombre 
                        FROM admision_resultados_archivos f 
                        LEFT JOIN programas_estudio p ON f.programa_id = p.id 
                        WHERE f.proceso_id = ? 
                        ORDER BY f.orden ASC";
            $resultadosArchivos = $this->db->fetchAll($sqlFiles, [$proceso['id']]);
            $documentos = $this->db->fetchAll("SELECT * FROM admision_documentos WHERE proceso_id = ? ORDER BY orden ASC", [$proceso['id']]);
        }
        else {
             // Avoid undefined variable errors in view if no process
             $documentos = [];
             $resultadosArchivos = [];
        }

        $pageTitle = 'Admisión ' . ($proceso['titulo'] ?? '');
        $metaDescription = 'Información sobre el proceso de admisión en el Instituto ACIP.';
        
        ob_start();
        require APP_PATH . '/Views/admision/index.php';
        $content = ob_get_clean();
        
        require APP_PATH . '/Views/layouts/main.php';
    }

    public function resultados() {
        // Get active process
        $proceso = $this->db->fetchOne("SELECT * FROM admision_procesos WHERE activo = 1 LIMIT 1");
        
        // If no active process, try to find the latest one
        if (!$proceso) {
            $proceso = $this->db->fetchOne("SELECT * FROM admision_procesos ORDER BY created_at DESC LIMIT 1");
        }

        $dni = $_GET['dni'] ?? '';
        $programa_selected = $_GET['programa'] ?? '';
        
        $resultado = null;
        $resultados_programa = [];
        $programas = [];
        $error = null;

        if ($proceso) {
            // Fetch distinct programs for the dropdown/buttons
            $programas = $this->db->fetchAll(
                "SELECT DISTINCT programa_estudio FROM admision_resultados WHERE proceso_id = ? ORDER BY programa_estudio", 
                [$proceso['id']]
            );

            // Fetch result files for the file widget
            $sqlFiles = "SELECT f.*, p.nombre as programa_nombre 
                        FROM admision_resultados_archivos f 
                        LEFT JOIN programas_estudio p ON f.programa_id = p.id 
                        WHERE f.proceso_id = ? 
                        ORDER BY f.orden ASC";
            $resultadosArchivos = $this->db->fetchAll($sqlFiles, [$proceso['id']]);

            if (!empty($dni)) {
                 $sql = "SELECT * FROM admision_resultados WHERE dni = ? AND proceso_id = ?";
                 $resultado = $this->db->fetchOne($sql, [$dni, $proceso['id']]);
                
                 if (!$resultado) {
                     $error = "No se encontraron resultados para el DNI ingresado en el proceso: " . htmlspecialchars($proceso['titulo']);
                 }
            } elseif (!empty($programa_selected)) {
                // Fetch all results for the selected program
                $resultados_programa = $this->db->fetchAll(
                    "SELECT * FROM admision_resultados WHERE proceso_id = ? AND programa_estudio = ? ORDER BY orden_merito ASC, puntaje DESC",
                    [$proceso['id'], $programa_selected]
                );
            }
        } else {
             $error = "No hay procesos de admisión activos en este momento.";
        }

        $pageTitle = 'Resultados de Admisión';
        
        ob_start();
        require APP_PATH . '/Views/admision/resultados.php';
        $content = ob_get_clean();
        
        require APP_PATH . '/Views/layouts/main.php';
    }
}
