<?php
/**
 * Configuración de Email
 * Portal Institucional ACIP
 */

return [
    'driver' => 'smtp',
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'encryption' => 'tls',
    'username' => '', // Configurar email institucional
    'password' => '', // Configurar contraseña de aplicación
    'from' => [
        'address' => 'noreply@acip.edu.pe',
        'name' => 'Instituto ACIP'
    ],
];
