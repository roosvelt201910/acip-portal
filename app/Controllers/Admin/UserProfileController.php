<?php
require_once __DIR__ . '/../../../config/database.php';

class UserProfileController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->ensureAuthenticated();
    }

    private function ensureAuthenticated() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . url('admin/login'));
            exit;
        }
    }

    public function index() {
        $userId = $_SESSION['user_id'];
        
        // Fetch fresh user data using fetchOne
        $user = $this->db->fetchOne("SELECT * FROM usuarios WHERE id = ?", [$userId]);

        if (!$user) {
            // Should not happen if logged in, but handle safely
            session_destroy();
            header('Location: ' . url('admin/login'));
            exit;
        }

        // Pass user data to view
        $title = 'Mi Perfil';
        $currentPage = 'perfil';
        require __DIR__ . '/../../Views/admin/perfil/index.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/perfil'));
            exit;
        }

        $userId = $_SESSION['user_id'];
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        $errors = [];
        $success = false;

        // Basic validation
        if (empty($nombre)) {
            $errors[] = "El nombre es obligatorio.";
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El correo electrónico no es válido.";
        }

        // Check email uniqueness if changed
        if (empty($errors)) {
            $existingUser = $this->db->fetchOne("SELECT id FROM usuarios WHERE email = ? AND id != ?", [$email, $userId]);
            if ($existingUser) {
                $errors[] = "El correo electrónico ya está en uso.";
            }
        }

        // Password validation
        if (!empty($password)) {
            if (strlen($password) < 6) {
                $errors[] = "La contraseña debe tener al menos 6 caracteres.";
            }
            if ($password !== $confirmPassword) {
                $errors[] = "Las contraseñas no coinciden.";
            }
        }

        // Avatar Upload
        $avatarPath = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $fileType = mime_content_type($_FILES['avatar']['tmp_name']);
            
            if (!in_array($fileType, $allowedTypes)) {
                $errors[] = "El archivo debe ser una imagen (JPG, PNG, GIF, WEBP).";
            } else {
                $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $filename = 'avatar_' . $userId . '_' . time() . '.' . $ext;
                $uploadDir = __DIR__ . '/../../../public/uploads/avatars/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $filename)) {
                    $avatarPath = 'uploads/avatars/' . $filename;
                } else {
                    $errors[] = "Error al subir la imagen.";
                }
            }
        }

        if (empty($errors)) {
            try {
                // Prepare update data
                $updateData = [
                    'nombre' => $nombre,
                    'email' => $email
                ];

                if (!empty($password)) {
                    $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
                }

                if ($avatarPath) {
                    $updateData['avatar'] = $avatarPath;
                }

                // Use the update helper method
                $this->db->update('usuarios', $updateData, 'id = :id', ['id' => $userId]);

                // Update Session
                if (isset($_SESSION['user_data'])) {
                    $_SESSION['user_data']['nombre'] = $nombre;
                    $_SESSION['user_data']['email'] = $email;
                    if ($avatarPath) {
                        $_SESSION['user_data']['avatar'] = $avatarPath;
                    }
                }

                $success = "Perfil actualizado correctamente.";
                
            } catch (Exception $e) {
                $errors[] = "Error al actualizar la base de datos: " . $e->getMessage();
            }
        }

        // Redirect back with messages
        if (!empty($errors)) {
            $_SESSION['flash_errors'] = $errors;
        }
        if ($success) {
            $_SESSION['flash_success'] = $success;
        }

        header('Location: ' . url('admin/perfil'));
        exit;
    }
}
