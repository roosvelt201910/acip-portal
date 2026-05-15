<?php ob_start(); ?>
<div class="header-container">
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Inicio</a>
        <span>/</span>
        <span class="current">Banners</span>
    </div>
</div>

<div class="card-enterprise">
    <div class="card-header-enterprise">
        <h2><i class="fas fa-images"></i> Administrar Banners</h2>
        <div class="header-actions">
            <a href="<?= url('admin/banners/crear') ?>" class="btn-enterprise">
                <i class="fas fa-plus"></i> Nuevo Banner
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table-enterprise">
            <thead>
                <tr>
                    <th width="100">Imagen</th>
                    <th>Título</th>
                    <th>Enlace</th>
                    <th>Orden</th>
                    <th>Estado</th>
                    <th width="150">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($banners)): ?>
                    <?php foreach ($banners as $item): ?>
                    <tr>
                        <td>
                            <img src="<?= url('uploads/banners/' . e($item['imagen'])) ?>" 
                                 class="table-img-preview" 
                                 style="height: 50px; width: 80px; object-fit: cover; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        </td>
                        <td class="font-weight-500"><?= e($item['titulo']) ?></td>
                        <td class="text-muted"><?= e($item['enlace']) ?></td>
                        <td><span class="badge badge-gray"><?= e($item['orden']) ?></span></td>
                        <td>
                            <?php if ($item['activo']): ?>
                                <span class="badge badge-green">Activo</span>
                            <?php else: ?>
                                <span class="badge badge-red">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions-cell">
                            <a href="<?= url('admin/banners/editar/' . $item['id']) ?>" class="btn-icon-enterprise" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete(<?= $item['id'] ?>)" class="btn-icon-enterprise delete" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center p-5">No hay banners registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esta acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= url('admin/banners/eliminar/') ?>' + id;
        }
    })
}
</script>

<?php
$content = ob_get_clean();
$extraJS = '
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
';
require APP_PATH . '/Views/layouts/admin.php';
?>
