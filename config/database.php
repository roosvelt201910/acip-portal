<?php
/**
 * Configuración de Base de Datos
 * Portal Institucional ACIP
 */

$isProduction = (isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'iespacip.edu.pe'))
    || getenv('APP_ENV') === 'production';

if ($isProduction) {
    return [
        'host'      => 'localhost',
        'database'  => 'iespacipedu_portal_acip',
        'username'  => 'iespacipedu_user_portal_acip',
        'password'  => 'qXd($&L~Zz244c&+',
        'charset'   => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix'    => '',
        'options'   => [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ],
    ];
}

return [
    'host'      => 'localhost',
    'database'  => 'acip_portal',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
    'options'   => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ],
];
