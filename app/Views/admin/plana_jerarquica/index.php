<?php ob_start(); ?>

<div class="header-container d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title">Plana Jerárquica</h2>
        <div class="breadcrumb">
            <a href="<?= url('admin/dashboard') ?>">Dashboard</a> / 
            <span>Plana Jerárquica</span>
        </div>
    </div>
    <a href="<?= url('admin/plana-jerarquica/crear') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Miembro
    </a>
</div>

<div class="card bg-white shadow-sm border-0 rounded-lg">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th width="80">Orden</th>
                        <th width="100">Foto</th>
                        <th>Nombre</th>
                        <th>Cargo</th>
                        <th>Email</th>
                        <th width="150" class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($miembros)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                No hay miembros registrados aún.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($miembros as $miembro): ?>
                            <tr>
                                <td>
                                    <span class="badge badge-light border"><?= $miembro['orden'] ?></span>
                                </td>
                                <td>
                                    <?php if ($miembro['imagen']): ?>
                                        <img src="<?= url($miembro['imagen']) ?>" alt="<?= e($miembro['nombre']) ?>" class="rounded-circle border" width="40" height="40" style="object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="font-weight-bold"><?= e($miembro['nombre']) ?></td>
                                <td>
                                    <span class="badge badge-info"><?= e($miembro['cargo']) ?></span>
                                </td>
                                <td>
                                    <?php if($miembro['email']): ?>
                                        <a href="mailto:<?= e($miembro['email']) ?>" class="text-muted text-decoration-none">
                                            <i class="fas fa-envelope mr-1"></i> <?= e($miembro['email']) ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <div class="actions justify-content-end">
                                        <a href="<?= url('admin/plana-jerarquica/editar/' . $miembro['id']) ?>" class="action-btn" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" onclick="confirmDelete(<?= $miembro['id'] ?>)" class="action-btn text-danger" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esta acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= url("admin/plana-jerarquica/eliminar/") ?>' + id;
        }
    })
}
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
