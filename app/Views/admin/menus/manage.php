<?php ob_start(); ?>
<div class="header-container">
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Inicio</a>
        <span>/</span>
        <a href="<?= url('admin/menus') ?>">Menús</a>
        <span>/</span>
        <span class="current">Gestionar <?= e($menu['nombre']) ?></span>
    </div>
</div>

<div class="card-enterprise">
    <div class="card-header-enterprise">
        <h2><i class="fas fa-link"></i> Enlaces del Menú: <?= e($menu['nombre']) ?></h2>
        <a href="<?= url('admin/menus/crear-item/' . $menu['id']) ?>" class="btn-enterprise">
            <i class="fas fa-plus"></i> Nuevo Enlace
        </a>
    </div>

    <div class="table-responsive">
        <table class="table-enterprise">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>URL</th>
                    <th>Jerarquía</th>
                    <th>Orden</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td class="font-weight-500">
                            <?php if ($item['parent_id']): ?>
                                <span style="color: #cbd5e1; margin-right: 8px;">↳</span>
                            <?php endif; ?>
                            <?= e($item['titulo']) ?>
                        </td>
                        <td class="text-muted"><?= e($item['url']) ?></td>
                        <td>
                            <?php if ($item['parent_id']): ?>
                                <span class="badge badge-gray">Sub-menú de <?= e($item['parent_name']) ?></span>
                            <?php else: ?>
                                <span class="badge badge-gray">Raíz</span>
                            <?php endif; ?>
                        </td>
                        <td><?= e($item['orden']) ?></td>
                        <td>
                            <?php if ($item['activo']): ?>
                                <span class="badge badge-green">Visble</span>
                            <?php else: ?>
                                <span class="badge badge-red">Oculto</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions-cell">
                            <a href="<?= url('admin/menus/editar-item/' . $item['id']) ?>" class="btn-icon-enterprise" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete(<?= $item['id'] ?>)" class="btn-icon-enterprise delete" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center p-5">No hay enlaces en este menú.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: '¿Confirmar eliminación?',
        text: "Si es un elemento padre, sus hijos podrían quedar huérfanos.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= url('admin/menus/eliminar-item/') ?>' + id;
        }
    })
}

// SweetAlert Success Check
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        Swal.fire({
            icon: 'success',
            title: '¡Guardado!',
            text: 'El elemento del menú ha sido actualizado.',
            timer: 2000,
            showConfirmButton: false
        });
    }
});
</script>

<?php
$content = ob_get_clean();
$extraJS = '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
require APP_PATH . '/Views/layouts/admin.php';
?>
