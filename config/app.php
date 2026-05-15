<?php
/**
 * Configuración General de la Aplicación
 * Portal Institucional ACIP
 *
 * En producción (cPanel) las variables de entorno se definen en .htaccess
 * En desarrollo (XAMPP) usa los valores por defecto aquí definidos.
 */

$isProduction = getenv('APP_ENV') === 'production';

return [
    'name'     => getenv('APP_NAME') ?: 'Portal ACIP',
    'url'      => getenv('APP_URL')  ?: 'http://localhost/acip-portal/public',
    'timezone' => 'America/Lima',
    'locale'   => 'es',
    'debug'    => !$isProduction,   // false en producción, true en local

    // Configuración de sesión
    'session'  => [
        'lifetime' => 7200,         // 2 horas
        'name'     => 'ACIP_SESSION',
        'secure'   => $isProduction, // HTTPS en producción
        'httponly' => true,
    ],

    // Configuración de uploads
    'upload'   => [
        'max_size'      => 20 * 1024 * 1024, // 20MB
        'allowed_types' => [
            'images'    => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            'documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx'],
        ],
    ],
];

