<?php
/**
 * Funciones Helper Globales
 * Portal Institucional ACIP
 */

/**
 * Escapar HTML para prevenir XSS
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Generar URL de la aplicación
 */
function url($path = '') {
    $config = require __DIR__ . '/../config/app.php';
    return rtrim($config['url'], '/') . '/' . ltrim($path, '/');
}

/**
 * Generar URL de asset
 */
function asset($path) {
    return url('assets/' . ltrim($path, '/'));
}

/**
 * Redireccionar
 */
function redirect($url) {
    header("Location: " . $url);
    exit;
}

/**
 * Obtener configuración
 */
function config($key, $default = null) {
    static $config = null;
    
    if ($config === null) {
        $config = [
            'app' => require __DIR__ . '/../config/app.php',
            'database' => require __DIR__ . '/../config/database.php',
            'mail' => require __DIR__ . '/../config/mail.php',
        ];
    }
    
    $keys = explode('.', $key);
    $value = $config;
    
    foreach ($keys as $k) {
        if (!isset($value[$k])) {
            return $default;
        }
        $value = $value[$k];
    }
    
    return $value;
}

/**
 * Obtener configuración del sitio (Dynámica desde DB)
 */
function site_config($key, $default = '') {
    static $siteConfig = null;
    
    // Cargar configuración solo una vez
    if ($siteConfig === null) {
        $db = Database::getInstance();
        $rows = $db->fetchAll("SELECT clave, valor FROM configuracion");
        $siteConfig = [];
        foreach ($rows as $row) {
            $siteConfig[$row['clave']] = $row['valor'];
        }
    }
    
    return $siteConfig[$key] ?? $default;
}


/**
 * Generar slug desde texto
 */
function slugify($text) {
    // Reemplazar caracteres especiales
    $text = str_replace(
        ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ'],
        ['a', 'e', 'i', 'o', 'u', 'n', 'a', 'e', 'i', 'o', 'u', 'n'],
        $text
    );
    
    // Convertir a minúsculas
    $text = strtolower($text);
    
    // Reemplazar espacios y caracteres especiales por guiones
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    
    // Eliminar guiones al inicio y final
    $text = trim($text, '-');
    
    return $text;
}

/**
 * Formatear fecha
 */
function formatDate($date, $format = 'd/m/Y') {
    if (empty($date)) return '';
    $timestamp = is_numeric($date) ? $date : strtotime($date);
    return date($format, $timestamp);
}

/**
 * Formatear fecha y hora
 */
function formatDateTime($datetime, $format = 'd/m/Y H:i') {
    return formatDate($datetime, $format);
}

/**
 * Obtener extensión de archivo
 */
function getFileExtension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

/**
 * Validar email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Generar token CSRF
 */
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verificar token CSRF
 */
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Sanitizar input
 */
function sanitize($input) {
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }
    return trim(strip_tags($input));
}

/**
 * Verificar si usuario está autenticado
 */
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

/**
 * Obtener usuario actual
 */
function currentUser() {
    if (!isAuthenticated()) {
        return null;
    }
    
    if (!isset($_SESSION['user_data'])) {
        $db = Database::getInstance();
        $_SESSION['user_data'] = $db->fetchOne(
            "SELECT id, nombre, email, rol, avatar FROM usuarios WHERE id = ?",
            [$_SESSION['user_id']]
        );
    }
    
    return $_SESSION['user_data'];
}

/**
 * Verificar si usuario es administrador
 */
function isAdmin() {
    $user = currentUser();
    return $user && $user['rol'] === 'administrador';
}

/**
 * Truncar texto
 */
function truncate($text, $length = 100, $suffix = '...') {
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . $suffix;
}

/**
 * Formatear tamaño de archivo
 */
function formatFileSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $i = 0;
    
    while ($bytes >= 1024 && $i < count($units) - 1) {
        $bytes /= 1024;
        $i++;
    }
    
    return round($bytes, 2) . ' ' . $units[$i];
}

/**
 * Registrar log
 */
function logActivity($accion, $tabla = null, $registro_id = null, $datos = null) {
    if (!isAuthenticated()) return;
    
    $db = Database::getInstance();
    $db->insert('logs', [
        'usuario_id' => $_SESSION['user_id'],
        'accion' => $accion,
        'tabla' => $tabla,
        'registro_id' => $registro_id,
        'datos_nuevos' => $datos ? json_encode($datos) : null,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
    ]);
}

/**
 * Obtener URL de embed para video
 */
function getEmbedUrl($url) {
    if (empty($url)) return '';

    // YouTube
    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1] . '?autoplay=0&controls=1&rel=0';
    }
    
    // Vimeo
    if (preg_match('/vimeo\.com\/(?:channels\/(?:[^\/]+\/)?|groups\/(?:[^\/]*\/)?videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)/', $url, $matches)) {
        return 'https://player.vimeo.com/video/' . $matches[1];
    }
    
    // Si no es YT/Vimeo, asumimos que es un MP4 directo o similar, o se devuelve tal cual
    return $url;
}

/**
 * Limpiar datos de entrada básico
 */
function clean($data) {
    if (is_array($data)) {
        return array_map('clean', $data);
    }
    return trim($data);
}
