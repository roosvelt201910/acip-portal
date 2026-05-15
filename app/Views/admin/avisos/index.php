<?php ob_start(); ?>

<div class="actions" style="margin-bottom: 20px; text-align: right;">
    <a href="<?= url('admin/avisos/crear') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Aviso
    </a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Orden</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($avisos)): ?>
                <?php foreach ($avisos as $aviso): ?>
                <tr>
                    <td><?= e($aviso['titulo']) ?></td>
                    <td>
                        <?php if ($aviso['tipo_contenido'] === 'imagen'): ?>
                            <span class="badge badge-blue"><i class="fas fa-image"></i> Imagen</span>
                        <?php elseif ($aviso['tipo_contenido'] === 'video'): ?>
                            <span class="badge badge-purple"><i class="fas fa-video"></i> Video</span>
                        <?php else: ?>
                            <span class="badge badge-gray"><i class="fas fa-code"></i> HTML</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($aviso['estado'] === 'activo'): ?>
                            <span class="badge badge-green">Activo</span>
                        <?php else: ?>
                            <span class="badge badge-red">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $aviso['fecha_inicio'] ? date('d/m/Y', strtotime($aviso['fecha_inicio'])) : '-' ?></td>
                    <td><?= $aviso['fecha_fin'] ? date('d/m/Y', strtotime($aviso['fecha_fin'])) : '-' ?></td>
                    <td><?= $aviso['orden'] ?></td>
                    <td class="actions">
                        <a href="<?= url('admin/avisos/editar/' . $aviso['id']) ?>" class="action-btn" title="Editar"><i class="fas fa-edit"></i></a>
                        <button onclick="confirmDelete('<?= url('admin/avisos/eliminar/' . $aviso['id']) ?>')" class="action-btn text-danger" style="background:none; border:none; cursor:pointer;" title="Eliminar"><i class="fas fa-trash"></i></button>
                        <a href="<?= url('admin/avisos/toggle/' . $aviso['id']) ?>" class="action-btn" title="<?= $aviso['estado'] === 'activo' ? 'Desactivar' : 'Activar' ?>">
                            <i class="fas fa-<?= $aviso['estado'] === 'activo' ? 'toggle-on' : 'toggle-off' ?>"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" style="text-align: center; padding: 20px;">No hay avisos.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();

$extraJS = '
<script src="https://cdn.jsdelivr.net.npm/sweetalert2@11"></script>
<script>
function confirmDelete(url) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "No podrás revertir esto",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminarlo",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>
';

require APP_PATH . '/Views/layouts/admin.php';
?>
