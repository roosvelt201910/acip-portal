<?php ob_start(); ?>
<div class="header-container">
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Inicio</a>
        <span>/</span>
        <span class="current">Menús</span>
    </div>
</div>

<div class="card-enterprise">
    <div class="card-header-enterprise">
        <h2><i class="fas fa-bars"></i> Administrar Menús</h2>
        <!-- No creating new menus for now, fixed set -->
    </div>

    <div class="table-responsive">
        <table class="table-enterprise">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Ubicación</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menus as $menu): ?>
                <tr>
                    <td class="font-weight-500"><?= e($menu['nombre']) ?></td>
                    <td><span class="badge badge-gray"><?= e($menu['ubicacion']) ?></span></td>
                    <td>
                        <?php if ($menu['activo']): ?>
                            <span class="badge badge-green">Activo</span>
                        <?php else: ?>
                            <span class="badge badge-red">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td class="actions-cell">
                        <a href="<?= url('admin/menus/gestionar/' . $menu['id']) ?>" class="btn-enterprise btn-sm">
                            <i class="fas fa-cog"></i> Gestionar Enlaces
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
