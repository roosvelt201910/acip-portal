<?php ob_start(); ?>

<div class="actions" style="margin-bottom: 20px; text-align: right;">
    <a href="<?= url('admin/paginas/crear') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nueva Página
    </a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Slug</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($paginas)): ?>
                <?php foreach ($paginas as $pagina): ?>
                <tr>
                    <td>
                        <strong><?= e($pagina['titulo']) ?></strong>
                    </td>
                    <td>/<?= e($pagina['slug']) ?></td>
                    <td>
                        <?php if ($pagina['estado'] === 'publicado'): ?>
                            <span class="badge badge-green">Publicado</span>
                        <?php else: ?>
                            <span class="badge badge-red"><?= e(ucfirst($pagina['estado'])) ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?= formatDate($pagina['created_at']) ?></td>
                    <td class="actions">
                        <a href="<?= url('admin/paginas/editar/' . $pagina['id']) ?>" class="action-btn" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= url('admin/paginas/eliminar/' . $pagina['id']) ?>" class="action-btn" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta página?')">
                            <i class="fas fa-trash"></i>
                        </a>
                        <a href="<?= url('/' . $pagina['slug']) ?>" target="_blank" class="action-btn" title="Ver">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px; color: #6b7280;">
                        No hay páginas creadas.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
