<?php ob_start(); ?>

<div class="header-container">
    <h2 class="page-title">Administrar Eventos</h2>
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Dashboard</a> / 
        <span>Eventos</span>
    </div>
</div>

<div class="actions-bar-enterprise">
    <a href="<?= url('admin/eventos/crear') ?>" class="btn-enterprise">
        <i class="fas fa-plus"></i> Nuevo Evento
    </a>
</div>

<div class="card-enterprise">
    <div class="table-responsive">
        <table class="table-enterprise">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Fecha Inicio</th>
                    <th>Ubicación</th>
                    <th>Estado</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($eventos)): ?>
                    <?php foreach ($eventos as $item): ?>
                    <tr>
                        <td style="font-weight: 500; color: var(--text-dark);"><?= e($item['titulo']) ?></td>
                        <td><?= formatDateTime($item['fecha_inicio']) ?></td>
                        <td><?= e($item['ubicacion']) ?></td>
                        <td>
                            <?php if ($item['activo']): ?>
                                <span class="badge-enterprise badge-success">Activo</span>
                            <?php else: ?>
                                <span class="badge-enterprise badge-danger">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions-cell">
                            <a href="<?= url('admin/eventos/editar/' . $item['id']) ?>" class="btn-icon-enterprise edit" title="Editar"><i class="fas fa-edit"></i></a>
                            <a href="<?= url('admin/eventos/eliminar/' . $item['id']) ?>" class="btn-icon-enterprise delete" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este evento?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-light);">No hay eventos registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
