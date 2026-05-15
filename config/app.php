<?php
/**
 * Configuración General de la Aplicación
 * Portal Institucional ACIP
 */

return [
    'name' => 'Portal ACIP',
    'url' => 'http://localhost/web/acip-portal/public',
    'timezone' => 'America/Lima',
    'locale' => 'es',
    'debug' => true, // Cambiar a false en producción
    'key' => 'base64:' . base64_encode(random_bytes(32)),
    
    // Configuración de sesión
    'session' => [
        'lifetime' => 7200, // 2 horas
        'name' => 'ACIP_SESSION',
        'secure' => false, // true en producción con HTTPS
        'httponly' => true,
    ],
    
    // Configuración de uploads
    'upload' => [
        'max_size' => 20 * 1024 * 1024, // 20MB
        'allowed_types' => [
            'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            'documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx'],
        ],
    ],
];
