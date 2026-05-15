<?php
/**
 * Punto de Entrada Principal
 * Portal Institucional ACIP
 */

// Iniciar sesión
session_start();

// Definir constantes
define('BASE_PATH', dirname(__DIR__));
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

// Crear instancia del router
$router = new Router();

// ============================================
// MIDDLEWARE: Verificar Modo Mantenimiento
// ============================================
$db = Database::getInstance();
$maintenanceConfig = $db->fetchOne("SELECT valor FROM configuracion WHERE clave = 'mantenimiento_activo'");
$isMaintenanceMode = !empty($maintenanceConfig['valor']) && $maintenanceConfig['valor'] == '1';

// Si está en modo mantenimiento y no es admin, mostrar página de mantenimiento
if ($isMaintenanceMode) {
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $isAdminRoute = strpos($currentPath, '/admin') !== false;
    
    // Permitir acceso a admin y a la página de mantenimiento
    if (!$isAdminRoute && $currentPath !== '/mantenimiento') {
        require APP_PATH . '/Views/maintenance.php';
        exit;
    }
}

// ============================================
// RUTAS PÚBLICAS
// ============================================

// Página de inicio
$router->get('/', function() {
    require APP_PATH . '/Controllers/HomeController.php';
    $controller = new HomeController();
    $controller->index();
});

// Reseña Histórica
$router->get('/resena-historica', function() {
    require APP_PATH . '/Views/pages/resena.php';
});

// Plana Jerárquica
$router->get('/plana-jerarquica', function() {
    require APP_PATH . '/Controllers/PlanaJerarquicaController.php';
    $controller = new PlanaJerarquicaController();
    $controller->index();
});
// Plana Docente
$router->get('/plana-docente', function() {
    require APP_PATH . '/Controllers/PlanaDocenteController.php';
    $controller = new PlanaDocenteController();
    $controller->index();
});



// Noticias
$router->get('/noticias', function() {
    require APP_PATH . '/Controllers/NoticiasController.php';
    $controller = new NoticiasController();
    $controller->index();
});

$router->get('/noticias/{slug}', function($slug) {
    require APP_PATH . '/Controllers/NoticiasController.php';
    $controller = new NoticiasController();
    $controller->show($slug);
});

// Eventos
$router->get('/eventos', function() {
    require APP_PATH . '/Controllers/EventosController.php';
    $controller = new EventosController();
    $controller->index();
});

// Programas de estudio
$router->get('/programas', function() {
    require APP_PATH . '/Controllers/ProgramasController.php';
    $controller = new ProgramasController();
    $controller->index();
});

$router->get('/programas/{slug}', function($slug) {
    require APP_PATH . '/Controllers/ProgramasController.php';
    $controller = new ProgramasController();
    $controller->show($slug);
});

// Contacto
$router->get('/contacto', function() {
    require APP_PATH . '/Controllers/ContactoController.php';
    $controller = new ContactoController();
    $controller->index();
});

$router->post('/contacto', function() {
    require APP_PATH . '/Controllers/ContactoController.php';
    $controller = new ContactoController();
    $controller->enviar();
});

// Libro de reclamaciones
$router->get('/libro-reclamaciones', function() {
    require APP_PATH . '/Controllers/ReclamacionesController.php';
    $controller = new ReclamacionesController();
    $controller->index();
});

$router->post('/libro-reclamaciones', function() {
    require APP_PATH . '/Controllers/ReclamacionesController.php';
    $controller = new ReclamacionesController();
    $controller->crear();
});

$router->get('/libro-reclamaciones/pdf', function() {
    require APP_PATH . '/Controllers/ReclamacionesController.php';
    $controller = new ReclamacionesController();
    $controller->generatePDF();
});

// Búsqueda
$router->get('/buscar', function() {
    require APP_PATH . '/Controllers/BusquedaController.php';
    $controller = new BusquedaController();
    $controller->index();
});
// Por qué elegirnos
$router->get('/por-que-elegirnos', function() {
    require APP_PATH . '/Controllers/WhyChooseUsController.php';
    $controller = new WhyChooseUsController();
    $controller->index();
});


// ============================================
// ADMISIÓN PUBLIC
// ============================================
$router->get('/admision', function() {
    require APP_PATH . '/Controllers/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->index();
});

$router->get('/admision/resultados', function() {
    require APP_PATH . '/Controllers/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->resultados();
});

// Matrícula
$router->get('/matricula', function() {
    require APP_PATH . '/Controllers/MatriculaController.php';
    $controller = new MatriculaController();
    $controller->index();
});

// ============================================
// RUTAS DE ADMINISTRACIÓN
// ============================================

// Login
$router->get('/admin/login', function() {
    require APP_PATH . '/Controllers/Admin/AuthController.php';
    $controller = new AuthController();
    $controller->showLogin();
});

$router->post('/admin/login', function() {
    require APP_PATH . '/Controllers/Admin/AuthController.php';
    $controller = new AuthController();
    $controller->login();
});

$router->get('/admin/logout', function() {
    require APP_PATH . '/Controllers/Admin/AuthController.php';
    $controller = new AuthController();
    $controller->logout();
});

// Dashboard
$router->get('/admin', function() {
    require APP_PATH . '/Controllers/Admin/DashboardController.php';
    $controller = new DashboardController();
    $controller->index();
});

// Páginas
$router->get('/admin/paginas', function() {
    require APP_PATH . '/Controllers/Admin/PaginasController.php';
    $controller = new PaginasController();
    $controller->index();
});

$router->get('/admin/paginas/crear', function() {
    require APP_PATH . '/Controllers/Admin/PaginasController.php';
    $controller = new PaginasController();
    $controller->create();
});

$router->post('/admin/paginas/crear', function() {
    require APP_PATH . '/Controllers/Admin/PaginasController.php';
    $controller = new PaginasController();
    $controller->store();
});

$router->get('/admin/paginas/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/PaginasController.php';
    $controller = new PaginasController();
    $controller->edit($id);
});

$router->post('/admin/paginas/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/PaginasController.php';
    $controller = new PaginasController();
    $controller->update($id);
});

$router->get('/admin/paginas/eliminar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/PaginasController.php';
    $controller = new PaginasController();
    $controller->delete($id);
});

// Avisos Modales
$router->get('/admin/avisos', function() {
    require APP_PATH . '/Controllers/Admin/AvisosController.php';
    $controller = new AvisosController();
    $controller->index();
});

$router->get('/admin/avisos/crear', function() {
    require APP_PATH . '/Controllers/Admin/AvisosController.php';
    $controller = new AvisosController();
    $controller->create();
});

$router->post('/admin/avisos/crear', function() {
    require APP_PATH . '/Controllers/Admin/AvisosController.php';
    $controller = new AvisosController();
    $controller->store();
});

$router->get('/admin/avisos/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AvisosController.php';
    $controller = new AvisosController();
    $controller->edit($id);
});

$router->post('/admin/avisos/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AvisosController.php';
    $controller = new AvisosController();
    $controller->update($id);
});

$router->get('/admin/avisos/eliminar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AvisosController.php';
    $controller = new AvisosController();
    $controller->delete($id);
});

$router->get('/admin/avisos/toggle/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AvisosController.php';
    $controller = new AvisosController();
    $controller->toggleStatus($id);
});

// Noticias
$router->get('/admin/noticias', function() {
    require APP_PATH . '/Controllers/Admin/NoticiasController.php';
    $controller = new NoticiasController();
    $controller->index();
});

$router->get('/admin/noticias/crear', function() {
    require APP_PATH . '/Controllers/Admin/NoticiasController.php';
    $controller = new NoticiasController();
    $controller->create();
});

$router->post('/admin/noticias/crear', function() {
    require APP_PATH . '/Controllers/Admin/NoticiasController.php';
    $controller = new NoticiasController();
    $controller->store();
});

$router->get('/admin/noticias/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/NoticiasController.php';
    $controller = new NoticiasController();
    $controller->edit($id);
});

$router->post('/admin/noticias/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/NoticiasController.php';
    $controller = new NoticiasController();
    $controller->update($id);
});

$router->get('/admin/noticias/eliminar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/NoticiasController.php';
    $controller = new NoticiasController();
    $controller->delete($id);
});

// Documentos Routes
// Documentos Routes
$router->get('/admin/documentos/crear', function() {
    require APP_PATH . '/Controllers/Admin/DocumentosController.php';
    $controller = new DocumentosController();
    $controller->create();
});

$router->post('/admin/documentos/guardar', function() {
    require APP_PATH . '/Controllers/Admin/DocumentosController.php';
    $controller = new DocumentosController();
    $controller->store();
});

$router->get('/admin/documentos/eliminar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/DocumentosController.php';
    $controller = new DocumentosController();
    $controller->delete($id);
});

// Documentos Categories
$router->get('/admin/documentos/categorias/listar', function() {
    require APP_PATH . '/Controllers/Admin/DocumentosController.php';
    $controller = new DocumentosController();
    $controller->getCategories();
});

$router->post('/admin/documentos/categorias/guardar', function() {
    require APP_PATH . '/Controllers/Admin/DocumentosController.php';
    $controller = new DocumentosController();
    $controller->storeCategory();
});

$router->post('/admin/documentos/categorias/eliminar', function() {
    require APP_PATH . '/Controllers/Admin/DocumentosController.php';
    $controller = new DocumentosController();
    $controller->deleteCategory();
});

// Eventos
$router->get('/admin/eventos', function() {
    require APP_PATH . '/Controllers/Admin/EventosController.php';
    $controller = new EventosController();
    $controller->index();
});

$router->get('/admin/eventos/crear', function() {
    require APP_PATH . '/Controllers/Admin/EventosController.php';
    $controller = new EventosController();
    $controller->create();
});

$router->post('/admin/eventos/crear', function() {
    require APP_PATH . '/Controllers/Admin/EventosController.php';
    $controller = new EventosController();
    $controller->store();
});

$router->get('/admin/eventos/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/EventosController.php';
    $controller = new EventosController();
    $controller->edit($id);
});

$router->post('/admin/eventos/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/EventosController.php';
    $controller = new EventosController();
    $controller->update($id);
});

$router->get('/admin/eventos/eliminar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/EventosController.php';
    $controller = new EventosController();
    $controller->delete($id);
});

// Documentos
$router->get('/admin/documentos', function() {
    require APP_PATH . '/Controllers/Admin/DocumentosController.php';
    $controller = new DocumentosController();
    $controller->index();
});

// Menús
$router->get('/admin/menus', function() {
    require APP_PATH . '/Controllers/Admin/MenusController.php';
    $controller = new MenusController();
    $controller->index();
});

$router->get('/admin/menus/gestionar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/MenusController.php';
    $controller = new MenusController();
    $controller->manage($id);
});

$router->get('/admin/menus/crear-item/{menuId}', function($menuId) {
    require APP_PATH . '/Controllers/Admin/MenusController.php';
    $controller = new MenusController();
    $controller->createItem($menuId);
});

$router->post('/admin/menus/crear-item/{menuId}', function($menuId) {
    require APP_PATH . '/Controllers/Admin/MenusController.php';
    $controller = new MenusController();
    $controller->storeItem($menuId);
});

$router->get('/admin/menus/editar-item/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/MenusController.php';
    $controller = new MenusController();
    $controller->editItem($id);
});

$router->post('/admin/menus/editar-item/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/MenusController.php';
    $controller = new MenusController();
    $controller->updateItem($id);
});

$router->get('/admin/menus/eliminar-item/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/MenusController.php';
    $controller = new MenusController();
    $controller->deleteItem($id);
});

// Banners
// Banners
$router->get('/admin/banners', function() {
    require APP_PATH . '/Controllers/Admin/BannersController.php';
    $controller = new BannersController();
    $controller->index();
});

$router->get('/admin/banners/crear', function() {
    require APP_PATH . '/Controllers/Admin/BannersController.php';
    $controller = new BannersController();
    $controller->create();
});

$router->post('/admin/banners/crear', function() {
    require APP_PATH . '/Controllers/Admin/BannersController.php';
    $controller = new BannersController();
    $controller->store();
});

$router->get('/admin/banners/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/BannersController.php';
    $controller = new BannersController();
    $controller->edit($id);
});

$router->post('/admin/banners/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/BannersController.php';
    $controller = new BannersController();
    $controller->update($id);
});

$router->get('/admin/banners/eliminar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/BannersController.php';
    $controller = new BannersController();
    $controller->delete($id);
});

// Por qué elegirnos
$router->get('/admin/why-choose-us', function() {
    require APP_PATH . '/Controllers/Admin/WhyChooseUsController.php';
    $controller = new WhyChooseUsController();
    $controller->index();
});

$router->get('/admin/why-choose-us/crear', function() {
    require APP_PATH . '/Controllers/Admin/WhyChooseUsController.php';
    $controller = new WhyChooseUsController();
    $controller->create();
});

$router->post('/admin/why-choose-us/store', function() {
    require APP_PATH . '/Controllers/Admin/WhyChooseUsController.php';
    $controller = new WhyChooseUsController();
    $controller->store();
});

$router->get('/admin/why-choose-us/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/WhyChooseUsController.php';
    $controller = new WhyChooseUsController();
    $controller->edit($id);
});

$router->post('/admin/why-choose-us/update/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/WhyChooseUsController.php';
    $controller = new WhyChooseUsController();
    $controller->update($id);
});

$router->get('/admin/why-choose-us/eliminar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/WhyChooseUsController.php';
    $controller = new WhyChooseUsController();
    $controller->delete($id);
});

// Programas
$router->get('/admin/programas', function() {
    require APP_PATH . '/Controllers/Admin/ProgramasController.php';
    $controller = new ProgramasController();
    $controller->index();
});

$router->get('/admin/programas/crear', function() {
    require APP_PATH . '/Controllers/Admin/ProgramasController.php';
    $controller = new ProgramasController();
    $controller->create();
});

$router->post('/admin/programas/crear', function() {
    require APP_PATH . '/Controllers/Admin/ProgramasController.php';
    $controller = new ProgramasController();
    $controller->store();
});

$router->get('/admin/programas/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/ProgramasController.php';
    $controller = new ProgramasController();
    $controller->edit($id);
});

$router->post('/admin/programas/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/ProgramasController.php';
    $controller = new ProgramasController();
    $controller->update($id);
});

$router->get('/admin/programas/eliminar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/ProgramasController.php';
    $controller = new ProgramasController();
    $controller->delete($id);
});

$router->get('/admin/programas/eliminar-imagen/{type}/{id}', function($type, $id) {
    require APP_PATH . '/Controllers/Admin/ProgramasController.php';
    $controller = new ProgramasController();
    $controller->deleteImage($type, $id);
});

$router->post('/admin/programas/update-slug/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/ProgramasController.php';
    $controller = new ProgramasController();
    $controller->updateSlug($id);
});

// Enlaces Destacados
$router->get('/admin/enlaces', function() {
    require APP_PATH . '/Controllers/Admin/EnlacesController.php';
    $controller = new EnlacesController();
    $controller->index();
});

$router->get('/admin/enlaces/create', function() {
    require APP_PATH . '/Controllers/Admin/EnlacesController.php';
    $controller = new EnlacesController();
    $controller->create();
});

$router->post('/admin/enlaces/store', function() {
    require APP_PATH . '/Controllers/Admin/EnlacesController.php';
    $controller = new EnlacesController();
    $controller->store();
});

$router->get('/admin/enlaces/edit/(\d+)', function($id) {
    require APP_PATH . '/Controllers/Admin/EnlacesController.php';
    $controller = new EnlacesController();
    $controller->edit($id);
});

$router->post('/admin/enlaces/update/(\d+)', function($id) {
    require APP_PATH . '/Controllers/Admin/EnlacesController.php';
    $controller = new EnlacesController();
    $controller->update($id);
});

$router->get('/admin/enlaces/delete/(\d+)', function($id) {
    require APP_PATH . '/Controllers/Admin/EnlacesController.php';
    $controller = new EnlacesController();
    $controller->delete($id);
});

// Contactos
$router->get('/admin/contactos', function() {
    require APP_PATH . '/Controllers/Admin/ContactosController.php';
    $controller = new ContactosController();
    $controller->index();
});

$router->post('/admin/contactos/actualizar-estado/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/ContactosController.php';
    $controller = new ContactosController();
    $controller->updateStatus($id);
});

$router->get('/admin/contactos/eliminar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/ContactosController.php';
    $controller = new ContactosController();
    $controller->delete($id);
});

// CKEditor Image Upload
$router->post('/admin/upload-image', function() {
    require APP_PATH . '/Controllers/Admin/UploadController.php';
    $controller = new UploadController();
    $controller->uploadImage();
});

// Reclamaciones
$router->get('/admin/reclamaciones', function() {
    require APP_PATH . '/Controllers/Admin/ReclamacionesController.php';
    $controller = new ReclamacionesController();
    $controller->index();
});

$router->post('/admin/reclamaciones/actualizar-estado/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/ReclamacionesController.php';
    $controller = new ReclamacionesController();
    $controller->updateStatus($id);
});

$router->get('/admin/reclamaciones/eliminar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/ReclamacionesController.php';
    $controller = new ReclamacionesController();
    $controller->delete($id);
});

$router->get('/admin/reclamaciones/pdf/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/ReclamacionesController.php';
    $controller = new ReclamacionesController();
    $controller->downloadPdf($id);
});

// Configuración
$router->get('/admin/configuracion', function() {
    require APP_PATH . '/Controllers/Admin/ConfiguracionController.php';
    $controller = new ConfiguracionController();
    $controller->index();
});

$router->post('/admin/configuracion', function() {
    require APP_PATH . '/Controllers/Admin/ConfiguracionController.php';
    $controller = new ConfiguracionController();
    $controller->index();
});

// Admisión Admin
$router->get('/admin/admision', function() {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->index();
});

$router->get('/admin/admision/crear', function() {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->create();
});

$router->post('/admin/admision/store', function() {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->store();
});

$router->get('/admin/admision/edit/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->edit($id);
});

$router->post('/admin/admision/update/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->update($id);
});

$router->get('/admin/admision/delete/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->delete($id);
});

// Admisión - Requisitos
$router->get('/admin/admision/requisitos/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->requisitos($id);
});

$router->post('/admin/admision/storeRequisito/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->storeRequisito($id);
});

$router->get('/admin/admision/deleteRequisito/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->deleteRequisito($id);
});

// Admisión - Modalidades
$router->get('/admin/admision/modalidades/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->modalidades($id);
});

$router->post('/admin/admision/storeModalidad/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->storeModalidad($id);
});

$router->get('/admin/admision/deleteModalidad/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->deleteModalidad($id);
});

// Admisión - Resultados
$router->get('/admin/admision/resultados/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->resultados($id);
});

$router->post('/admin/admision/storeResultado/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->storeResultado($id);
});

$router->get('/admin/admision/deleteResultado/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->deleteResultado($id);
});

// Admisión - Archivos Resultados
$router->post('/admin/admision/storeResultadoArchivo/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->storeResultadoArchivo($id);
});

$router->get('/admin/admision/deleteResultadoArchivo/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->deleteResultadoArchivo($id);
});

// Matrícula Admin
$router->get('/admin/matricula', function() {
    require APP_PATH . '/Controllers/Admin/MatriculaController.php';
    $controller = new AdminMatriculaController();
    $controller->index();
});

$router->post('/admin/matricula/update', function() {
    require APP_PATH . '/Controllers/Admin/MatriculaController.php';
    $controller = new AdminMatriculaController();
    $controller->update();
});

$router->post('/admin/matricula/update-order', function() {
    require APP_PATH . '/Controllers/Admin/MatriculaController.php';
    $controller = new AdminMatriculaController();
    $controller->updateOrder();
});

// Admisión - Documentos
$router->get('/admin/admision/documentos/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->documentos($id);
});

$router->post('/admin/admision/storeDocumento/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->storeDocumento($id);
});

$router->get('/admin/admision/deleteDocumento/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/AdmisionController.php';
    $controller = new AdmisionController();
    $controller->deleteDocumento($id);
});

// Becas y Créditos - Público
$router->get('/becas', function() {
    require APP_PATH . '/Controllers/BecasController.php';
    $controller = new BecasController();
    $controller->index();
});

// Becas y Créditos - Admin
$router->get('/admin/becas', function() {
    require APP_PATH . '/Controllers/Admin/BecasController.php';
    $controller = new AdminBecasController();
    $controller->index();
});

$router->post('/admin/becas/update', function() {
    require APP_PATH . '/Controllers/Admin/BecasController.php';
    $controller = new AdminBecasController();
    $controller->update();
});

$router->post('/admin/becas/delete-file', function() {
    require APP_PATH . '/Controllers/Admin/BecasController.php';
    $controller = new AdminBecasController();
    $controller->deleteFile();
});

// Plana Jerárquica
$router->get('/admin/plana-jerarquica', function() {
    require APP_PATH . '/Controllers/Admin/PlanaJerarquicaController.php';
    $controller = new PlanaJerarquicaController();
    $controller->index();
});

$router->get('/admin/plana-jerarquica/crear', function() {
    require APP_PATH . '/Controllers/Admin/PlanaJerarquicaController.php';
    $controller = new PlanaJerarquicaController();
    $controller->create();
});

$router->post('/admin/plana-jerarquica/guardar', function() {
    require APP_PATH . '/Controllers/Admin/PlanaJerarquicaController.php';
    $controller = new PlanaJerarquicaController();
    $controller->store();
});

$router->get('/admin/plana-jerarquica/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/PlanaJerarquicaController.php';
    $controller = new PlanaJerarquicaController();
    $controller->edit($id);
});

$router->post('/admin/plana-jerarquica/actualizar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/PlanaJerarquicaController.php';
    $controller = new PlanaJerarquicaController();
    $controller->update($id);
});

$router->get('/admin/plana-jerarquica/eliminar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/PlanaJerarquicaController.php';
    $controller = new PlanaJerarquicaController();
    $controller->delete($id);
});

// Plana Docente
$router->get('/admin/plana-docente', function() {
    require APP_PATH . '/Controllers/Admin/PlanaDocenteController.php';
    $controller = new PlanaDocenteController();
    $controller->index();
});

$router->get('/admin/plana-docente/crear', function() {
    require APP_PATH . '/Controllers/Admin/PlanaDocenteController.php';
    $controller = new PlanaDocenteController();
    $controller->create();
});

$router->post('/admin/plana-docente/guardar', function() {
    require APP_PATH . '/Controllers/Admin/PlanaDocenteController.php';
    $controller = new PlanaDocenteController();
    $controller->store();
});

$router->get('/admin/plana-docente/editar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/PlanaDocenteController.php';
    $controller = new PlanaDocenteController();
    $controller->edit($id);
});

$router->post('/admin/plana-docente/actualizar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/PlanaDocenteController.php';
    $controller = new PlanaDocenteController();
    $controller->update($id);
});

$router->get('/admin/plana-docente/eliminar/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/PlanaDocenteController.php';
    $controller = new PlanaDocenteController();
    $controller->delete($id);
});

// Gestión de Usuarios
$router->get('/admin/usuarios', function() {
    require APP_PATH . '/Controllers/Admin/UsersController.php';
    $controller = new UsersController();
    $controller->index();
});

$router->get('/admin/usuarios/create', function() {
    require APP_PATH . '/Controllers/Admin/UsersController.php';
    $controller = new UsersController();
    $controller->create();
});

$router->post('/admin/usuarios/store', function() {
    require APP_PATH . '/Controllers/Admin/UsersController.php';
    $controller = new UsersController();
    $controller->store();
});

$router->get('/admin/usuarios/edit/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/UsersController.php';
    $controller = new UsersController();
    $controller->edit($id);
});

$router->post('/admin/usuarios/update/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/UsersController.php';
    $controller = new UsersController();
    $controller->update($id);
});

$router->post('/admin/usuarios/delete/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/UsersController.php';
    $controller = new UsersController();
    $controller->destroy($id);
});

$router->post('/admin/usuarios/toggle/{id}', function($id) {
    require APP_PATH . '/Controllers/Admin/UsersController.php';
    $controller = new UsersController();
    $controller->toggleStatus($id);
});

// Perfil de Usuario
$router->get('/admin/perfil', function() {
    require APP_PATH . '/Controllers/Admin/UserProfileController.php';
    $controller = new UserProfileController();
    $controller->index();
});

$router->post('/admin/perfil/update', function() {
    require APP_PATH . '/Controllers/Admin/UserProfileController.php';
    $controller = new UserProfileController();
    $controller->update();
});

// 404
$router->notFound(function() {
    http_response_code(404);
    require APP_PATH . '/Views/errors/404.php';
});

// Página de contenido dinámico (Catch-all)
$router->get('/{slug}', function($slug) {
    require APP_PATH . '/Controllers/PageController.php';
    $controller = new PageController();
    $controller->show($slug);
});

// Despachar ruta
$router->dispatch();
