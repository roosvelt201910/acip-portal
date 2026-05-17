<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Admin') ?> - Panel Administrativo ACIP</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= url('assets/css/admin.css') ?>">
    <link rel="stylesheet" href="<?= url('assets/css/admin-enterprise.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
            color: #1f2937;
        }
        
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 260px;
            background: #1e3a8a;
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-header h2 {
            font-size: 20px;
            font-weight: 700;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .menu-item:hover,
        .menu-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .menu-item i {
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            flex: 1;
            margin-left: 260px;
        }
        
        .topbar {
            background: white;
            padding: 16px 32px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .topbar h1 {
            font-size: 24px;
            color: #1e3a8a;
            margin: 0;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 14px;
        }
        
        .user-role {
            font-size: 12px;
            color: #6b7280;
        }
        
        .logout-btn {
            padding: 8px 16px;
            background: #881337;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        
        .logout-btn:hover {
            background: #6d102b;
        }
        
        .content-area {
            padding: 32px;
        }

        .content-area.content-area--wide {
            padding: 12px 16px;
        }
        
        /* Utility Classes */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-primary {
            background: #1e3a8a;
            color: white;
        }
        
        .btn-primary:hover {
            background: #1e40af;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        th, td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #f3f4f6;
        }
        
        th {
            background: #f9fafb;
            font-weight: 600;
            color: #4b5563;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .badge-green {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge-red {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .actions {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            color: #6b7280;
            padding: 4px;
        }
        
        .action-btn:hover {
            color: #1e3a8a;
        }
        
        /* Custom Extra CSS */
        <?= $extraCSS ?? '' ?>
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>ACIP Admin</h2>
                <p style="font-size: 12px; opacity: 0.7;">Panel de Administración</p>
            </div>
            
            <nav class="sidebar-menu">
                <a href="<?= url('admin') ?>" class="menu-item <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="<?= url('admin/paginas') ?>" class="menu-item <?= ($currentPage ?? '') === 'paginas' ? 'active' : '' ?>">
                    <i class="fas fa-file-alt"></i>
                    <span>Páginas</span>
                </a>
                <a href="<?= url('admin/avisos') ?>" class="menu-item <?= ($currentPage ?? '') === 'avisos' ? 'active' : '' ?>">
                    <i class="fas fa-bullhorn"></i>
                    <span>Avisos</span>
                </a>
                <a href="<?= url('admin/noticias') ?>" class="menu-item <?= ($currentPage ?? '') === 'noticias' ? 'active' : '' ?>">
                    <i class="fas fa-newspaper"></i>
                    <span>Noticias</span>
                </a>
                <a href="<?= url('admin/eventos') ?>" class="menu-item <?= ($currentPage ?? '') === 'eventos' ? 'active' : '' ?>">
                    <i class="fas fa-calendar"></i>
                    <span>Eventos</span>
                </a>
                <a href="<?= url('admin/documentos') ?>" class="menu-item <?= ($currentPage ?? '') === 'documentos' ? 'active' : '' ?>">
                    <i class="fas fa-folder"></i>
                    <span>Documentos</span>
                </a>
                <a href="<?= url('admin/menus') ?>" class="menu-item <?= ($currentPage ?? '') === 'menus' ? 'active' : '' ?>">
                    <i class="fas fa-bars"></i>
                    <span>Menús</span>
                </a>
                <a href="<?= url('admin/banners') ?>" class="menu-item <?= ($currentPage ?? '') === 'banners' ? 'active' : '' ?>">
                    <i class="fas fa-image"></i>
                    <span>Banners</span>
                </a>
                <a href="<?= url('admin/why-choose-us') ?>" class="menu-item <?= ($currentPage ?? '') === 'why_choose_us' ? 'active' : '' ?>">
                    <i class="fas fa-check-circle"></i>
                    <span>Por qué elegirnos</span>
                </a>
                <a href="<?= url('admin/enlaces') ?>" class="menu-item <?= ($currentPage ?? '') === 'enlaces' ? 'active' : '' ?>">
                    <i class="fas fa-link"></i>
                    <span>Enlaces</span>
                </a>
                <a href="<?= url('admin/programas') ?>" class="menu-item <?= ($currentPage ?? '') === 'programas' ? 'active' : '' ?>">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Programas</span>
                </a>
                <a href="<?= url('admin/contactos') ?>" class="menu-item <?= ($currentPage ?? '') === 'contactos' ? 'active' : '' ?>">
                    <i class="fas fa-envelope"></i>
                    <span>Contactos</span>
                </a>
                <a href="<?= url('admin/plana-jerarquica') ?>" class="menu-item <?= ($currentPage ?? '') === 'plana_jerarquica' ? 'active' : '' ?>">
                    <i class="fas fa-users-cog"></i>
                    <span>Plana Jerárquica</span>
                </a>
                <a href="<?= url('admin/plana-docente') ?>" class="menu-item <?= ($currentPage ?? '') === 'plana_docente' ? 'active' : '' ?>">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Plana Docente</span>
                </a>
                <a href="<?= url('admin/reclamaciones') ?>" class="menu-item <?= ($currentPage ?? '') === 'reclamaciones' ? 'active' : '' ?>">
                    <i class="fas fa-book"></i>
                    <span>Reclamaciones</span>
                </a>
                <a href="<?= url('admin/admision') ?>" class="menu-item <?= ($currentPage ?? '') === 'admision' ? 'active' : '' ?>">
                    <i class="fas fa-user-graduate"></i>
                    <span>Admisión</span>
                </a>

                <a href="<?= url('admin/matricula') ?>" class="menu-item <?= strpos($currentPage ?? '', 'matricula') !== false ? 'active' : '' ?>">
                    <i class="fas fa-id-card"></i>
                    <span>Matrícula</span>
                </a>

                <a href="<?= url('admin/becas') ?>" class="menu-item <?= ($currentPage ?? '') === 'becas' ? 'active' : '' ?>">
                    <i class="fas fa-award"></i>
                    <span>Becas y Créditos</span>
                </a>

                <a href="<?= url('admin/usuarios') ?>" class="menu-item <?= ($currentPage ?? '') === 'usuarios' ? 'active' : '' ?>">
                    <i class="fas fa-users-cog"></i>
                    <span>Usuarios</span>
                </a>

                <a href="<?= url('admin/perfil') ?>" class="menu-item <?= ($currentPage ?? '') === 'perfil' ? 'active' : '' ?>">
                    <i class="fas fa-user-circle"></i>
                    <span>Mi Perfil</span>
                </a>

                <a href="<?= url('admin/configuracion') ?>" class="menu-item <?= ($currentPage ?? '') === 'configuracion' ? 'active' : '' ?>">
                    <i class="fas fa-cog"></i>
                    <span>Configuración</span>
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Topbar -->
            <div class="topbar">
                <h1><?= e($pageTitle ?? 'Admin') ?></h1>
                
                <div class="user-menu">
                    <a href="<?= url('admin/perfil') ?>" class="user-info" style="text-decoration: none; cursor: pointer; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                        <div class="user-name"><?= e(currentUser()['nombre'] ?? 'Usuario') ?></div>
                        <div class="user-role"><?= e(ucfirst(currentUser()['rol'] ?? 'Rol')) ?></div>
                    </a>
                    <a href="<?= url('admin/logout') ?>" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </a>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="content-area <?= ($currentPage ?? '') === 'matricula' ? 'content-area--wide' : '' ?>">
                <?php if (isset($_SESSION['success'])): ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: '<?= e($_SESSION['success']) ?>',
                                confirmButtonColor: '#1e3a8a'
                            });
                        });
                    </script>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: '<?= e($_SESSION['error']) ?>',
                                confirmButtonColor: '#d33'
                            });
                        });
                    </script>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?= $content ?? '' ?>
            </div>
        </main>
    </div>
    
    <?= $extraJS ?? '' ?>
</body>
</html>
