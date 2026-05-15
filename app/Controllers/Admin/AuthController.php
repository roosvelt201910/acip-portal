<?php
/**
 * Controlador de Autenticación (Admin)
 */

class AuthController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function showLogin() {
        // Si ya está autenticado, redirigir al dashboard
        if (isAuthenticated()) {
            redirect(url('admin'));
        }
        
        require APP_PATH . '/Views/admin/login.php';
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/login'));
        }
        
        $email = sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Validar campos
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Por favor complete todos los campos';
            redirect(url('admin/login'));
        }
        
        // Buscar usuario
        $user = $this->db->fetchOne(
            "SELECT * FROM usuarios WHERE email = ? AND activo = 1",
            [$email]
        );
        
        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = 'Credenciales incorrectas';
            redirect(url('admin/login'));
        }
        
        // Iniciar sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_data'] = [
            'id' => $user['id'],
            'nombre' => $user['nombre'],
            'email' => $user['email'],
            'rol' => $user['rol'],
            'avatar' => $user['avatar']
        ];
        
        // Actualizar último login
        $this->db->update('usuarios',
            ['last_login' => date('Y-m-d H:i:s')],
            'id = :id',
            ['id' => $user['id']]
        );
        
        // Registrar log
        logActivity('login');
        
        redirect(url('admin'));
    }
    
    public function logout() {
        logActivity('logout');
        
        session_destroy();
        redirect(url('admin/login'));
    }
}
