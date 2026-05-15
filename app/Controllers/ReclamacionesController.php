<?php
/**
 * Controlador de Libro de Reclamaciones (Público)
 */

class ReclamacionesController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function index() {
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->crear();
            return;
        }
        
        $pageTitle = 'Libro de Reclamaciones';
        require APP_PATH . '/Views/reclamaciones/index.php';
    }
    
    public function crear() {
        try {
            // Generate unique complaint code
            // Generar correlativo secuencial anual (REC-YYYY-XXXX)
            $anio = date('Y');
            $prefix = "REC-$anio-";
            
            // Obtener el último código del año actual
            // Nota: Buscamos códigos que empiecen con REC-2026- (para distinguir de los anteriores REC-YYYYMMDD-)
            $sql = "SELECT codigo FROM reclamaciones WHERE codigo LIKE ? ORDER BY id DESC LIMIT 1";
            // The Database class has a 'query' method that prepares and executes
            $stmt = $this->db->query($sql, [$prefix . '%']);
            $ultimo = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $correlativo = 1;
            if ($ultimo) {
                // Extraer el número final: REC-2026-0001 -> 0001
                $parts = explode('-', $ultimo['codigo']);
                $lastNum = end($parts);
                if (is_numeric($lastNum)) {
                    $correlativo = intval($lastNum) + 1;
                }
            }
            
            $codigo = $prefix . str_pad($correlativo, 4, '0', STR_PAD_LEFT);
            
            // Map tipo_reclamo to database ENUM values
            $tipoReclamo = $_POST['tipo_reclamo'] ?? '';
            $tipoMap = [
                'reclamo' => 'reclamo',
                'queja' => 'queja',
                'sugerencia' => 'sugerencia'
            ];
            $tipo = $tipoMap[$tipoReclamo] ?? 'reclamo';
            
            // Map tipo_documento to ENUM value
            $tipoDocForm = $_POST['tipo_documento'] ?? 'DNI';
            $tipoDocumento = ($tipoDocForm === 'DNI' || $tipoDocForm === 'CE') ? 'DNI' : 'DNI';
            
            // Collect and sanitize form data
            $data = [
                'codigo' => $codigo,
                'tipo_reclamo' => $tipo, 
                'tipo_contacto' => $_POST['tipo_contacto'] ?? '',
                'nombres' => $_POST['nombres'] ?? '',
                'email' => $_POST['email'] ?? '',
                'telefono' => $_POST['telefono'] ?? '',
                'tipo_documento' => $tipoDocumento,
                'numero_documento' => $_POST['numero_documento'] ?? '',
                'domicilio' => $_POST['domicilio'] ?? '',
                'apoderado' => $_POST['apoderado'] ?? null,
                'detalle' => $_POST['detalle'] ?? '',
                'pedido' => $_POST['pedido'] ?? '',
                'estado' => 'pendiente',
            ];
            
            // Validate required fields
            if (empty($data['nombres']) || empty($data['email']) || empty($data['detalle'])) {
                $_SESSION['error'] = 'Por favor complete todos los campos requeridos';
                redirect(url('libro-reclamaciones'));
                return;
            }
            
            // Insert into database
            $id = $this->db->insert('reclamaciones', $data);
            
            if ($id) {
                // Store complaint data in session for PDF generation
                $_SESSION['last_complaint'] = [
                    'id' => $id,
                    'codigo' => $codigo,
                    'nombre' => $data['nombres'], 
                    'email' => $data['email'],
                    'telefono' => $data['telefono'],
                    'tipo_documento' => $data['tipo_documento'],
                    'documento' => $data['numero_documento'],
                    'tipo' => $data['tipo_reclamo'],
                    'detalle' => $data['detalle'],
                    'fecha' => date('d/m/Y H:i:s')
                ];
                
                $_SESSION['success'] = 'Su reclamo ha sido registrado exitosamente. Código: ' . $codigo;
                $_SESSION['show_pdf_download'] = true;
            } else {
                $_SESSION['error'] = 'Hubo un error al registrar su reclamo. Por favor intente nuevamente.';
            }
            
        } catch (Exception $e) {
            // Log error to file for debugging
            file_put_contents(__DIR__ . '/../../public/debug_error_log.txt', date('Y-m-d H:i:s') . " - Error: " . $e->getMessage() . "\n", FILE_APPEND);
            $_SESSION['error'] = 'Error al procesar su solicitud: ' . $e->getMessage();
        }
        
        // Redirect back to form
        redirect(url('libro-reclamaciones'));
        exit;
    }
    
    public function generatePDF() {
        if (!isset($_SESSION['last_complaint'])) {
            redirect(url('libro-reclamaciones'));
            return;
        }
        
        $complaint = $_SESSION['last_complaint'];
        
        // Generate HTML receipt
        $pageTitle = 'Constancia de Reclamo';
        require APP_PATH . '/Views/reclamaciones/constancia.php';
        
        // Clear the session data after displaying
        unset($_SESSION['last_complaint']);
        unset($_SESSION['show_pdf_download']);
    }
}
