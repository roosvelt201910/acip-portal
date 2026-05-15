<?php
require_once __DIR__ . '/../../../config/database.php';

class UsersController {
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
        $users = $this->db->fetchAll("SELECT id, nombre, email, rol, avatar, activo, created_at FROM usuarios ORDER BY created_at DESC");
        
        $title = 'Gestión de Usuarios';
        $currentPage = 'usuarios';
        require __DIR__ . '/../../Views/admin/usuarios/index.php';
    }

    public function create() {
        $title = 'Crear Usuario';
        $currentPage = 'usuarios';
        require __DIR__ . '/../../Views/admin/usuarios/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/usuarios'));
            exit;
        }

        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $rol = $_POST['rol'] ?? 'usuario';
        
        $errors = [];

        // Validation
        if (empty($nombre)) {
            $errors[] = "El nombre es obligatorio.";
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El correo electrónico no es válido.";
        }
        if (empty($password) || strlen($password) < 6) {
            $errors[] = "La contraseña debe tener al menos 6 caracteres.";
        }

        // Check email uniqueness
        if (empty($errors)) {
            $existingUser = $this->db->fetchOne("SELECT id FROM usuarios WHERE email = ?", [$email]);
            if ($existingUser) {
                $errors[] = "El correo electrónico ya está en uso.";
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
                $filename = 'avatar_' . time() . '_' . uniqid() . '.' . $ext;
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
                $this->db->insert('usuarios', [
                    'nombre' => $nombre,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'rol' => $rol,
                    'avatar' => $avatarPath,
                    'activo' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                
                $_SESSION['success'] = "Usuario creado correctamente.";
                header('Location: ' . url('admin/usuarios'));
                exit;
            } catch (Exception $e) {
                $errors[] = "Error al crear el usuario: " . $e->getMessage();
            }
        }

        $_SESSION['flash_errors'] = $errors;
        $_SESSION['flash_old'] = $_POST;
        header('Location: ' . url('admin/usuarios/create'));
        exit;
    }

    public function edit($id) {
        $user = $this->db->fetchOne("SELECT * FROM usuarios WHERE id = ?", [$id]);
        
        if (!$user) {
            $_SESSION['error'] = "Usuario no encontrado.";
            header('Location: ' . url('admin/usuarios'));
            exit;
        }

        $title = 'Editar Usuario';
        $currentPage = 'usuarios';
        require __DIR__ . '/../../Views/admin/usuarios/edit.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/usuarios'));
            exit;
        }

        $user = $this->db->fetchOne("SELECT * FROM usuarios WHERE id = ?", [$id]);
        if (!$user) {
            $_SESSION['error'] = "Usuario no encontrado.";
            header('Location: ' . url('admin/usuarios'));
            exit;
        }

        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $rol = $_POST['rol'] ?? $user['rol'];
        
        $errors = [];

        if (empty($nombre)) {
            $errors[] = "El nombre es obligatorio.";
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El correo electrónico no es válido.";
        }

        // Check email uniqueness (excluding current user)
        if (empty($errors)) {
            $existingUser = $this->db->fetchOne("SELECT id FROM usuarios WHERE email = ? AND id != ?", [$email, $id]);
            if ($existingUser) {
                $errors[] = "El correo electrónico ya está en uso.";
            }
        }

        // Password validation (optional for update)
        if (!empty($password) && strlen($password) < 6) {
            $errors[] = "La contraseña debe tener al menos 6 caracteres.";
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
                $filename = 'avatar_' . $id . '_' . time() . '.' . $ext;
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
                $updateData = [
                    'nombre' => $nombre,
                    'email' => $email,
                    'rol' => $rol
                ];

                if (!empty($password)) {
                    $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
                }

                if ($avatarPath) {
                    $updateData['avatar'] = $avatarPath;
                }

                $this->db->update('usuarios', $updateData, 'id = :id', ['id' => $id]);
                
                $_SESSION['success'] = "Usuario actualizado correctamente.";
                header('Location: ' . url('admin/usuarios'));
                exit;
            } catch (Exception $e) {
                $errors[] = "Error al actualizar el usuario.";
            }
        }

        $_SESSION['flash_errors'] = $errors;
        header('Location: ' . url('admin/usuarios/edit/' . $id));
        exit;
    }

    public function destroy($id) {
        // Prevent self-delete
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = "No puedes eliminar tu propia cuenta.";
            header('Location: ' . url('admin/usuarios'));
            exit;
        }

        $user = $this->db->fetchOne("SELECT id FROM usuarios WHERE id = ?", [$id]);
        if (!$user) {
            $_SESSION['error'] = "Usuario no encontrado.";
            header('Location: ' . url('admin/usuarios'));
            exit;
        }

        try {
            $this->db->delete('usuarios', 'id = :id', ['id' => $id]);
            $_SESSION['success'] = "Usuario eliminado correctamente.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al eliminar el usuario.";
        }

        header('Location: ' . url('admin/usuarios'));
        exit;
    }

    public function toggleStatus($id) {
        // Prevent self-toggle
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = "No puedes desactivar tu propia cuenta.";
            header('Location: ' . url('admin/usuarios'));
            exit;
        }

        $user = $this->db->fetchOne("SELECT id, activo FROM usuarios WHERE id = ?", [$id]);
        if (!$user) {
            $_SESSION['error'] = "Usuario no encontrado.";
            header('Location: ' . url('admin/usuarios'));
            exit;
        }

        try {
            $newStatus = $user['activo'] ? 0 : 1;
            $this->db->update('usuarios', ['activo' => $newStatus], 'id = :id', ['id' => $id]);
            
            $statusText = $newStatus ? 'activado' : 'desactivado';
            $_SESSION['success'] = "Usuario {$statusText} correctamente.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al cambiar el estado del usuario.";
        }

        header('Location: ' . url('admin/usuarios'));
        exit;
    }
}
