<?php
/**
 * Punto de Entrada Principal (Producción cPanel)
 * Portal Institucional ACIP
 */

// Iniciar sesión
session_start();

// Definir constantes (Ajustadas para estar en la raíz)
define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', __DIR__);

// Cargar archivos necesarios
require_once BASE_PATH . '/includes/Database.php';
require_once BASE_PATH . '/includes/functions.php';
require_once BASE_PATH . '/includes/Router.php';

// Configurar zona horaria
date_default_timezone_set(config('app.timezone', 'America/Lima'));

// Configurar manejo de errores
if (config('app.debug')) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Cargar rutas y despachar
require_once BASE_PATH . '/app/routes.php';
