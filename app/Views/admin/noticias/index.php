<?php ob_start(); ?>

<div class="actions" style="margin-bottom: 20px; text-align: right;">
    <a href="<?= url('admin/noticias/crear') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nueva Noticia
    </a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Fecha Publicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($noticias)): ?>
                <?php foreach ($noticias as $item): ?>
                <tr>
                    <td><?= e($item['titulo']) ?></td>
                    <td><?= e(ucfirst($item['categoria'])) ?></td>
                    <td>
                        <?php if ($item['estado'] === 'publicado'): ?>
                            <span class="badge badge-green">Publicado</span>
                        <?php else: ?>
                            <span class="badge badge-red"><?= e(ucfirst($item['estado'])) ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?= formatDate($item['fecha_publicacion']) ?></td>
                    <td class="actions">
                        <a href="<?= url('admin/noticias/editar/' . $item['id']) ?>" class="action-btn"><i class="fas fa-edit"></i></a>
                        <button onclick="confirmDelete('<?= url('admin/noticias/eliminar/' . $item['id']) ?>')" class="action-btn text-danger" style="background:none; border:none; cursor:pointer;"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align: center; padding: 20px;">No hay noticias.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();

$extraJS = '
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
