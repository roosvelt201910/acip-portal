

<div class="header-container">
    <h2 class="page-title">Procesos de Admisión</h2>
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Dashboard</a> / 
        <span>Admisión</span>
    </div>
    <a href="<?= url('admin/admision/crear') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Proceso
    </a>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($procesos as $proceso): ?>
            <tr>
                <td><?= e($proceso['titulo']) ?></td>
                <td><?= date('d/m/Y', strtotime($proceso['fecha_inicio'])) ?></td>
                <td><?= date('d/m/Y', strtotime($proceso['fecha_fin'])) ?></td>
                <td>
                    <?php if ($proceso['activo']): ?>
                        <span class="badge badge-green">Activo</span>
                    <?php else: ?>
                        <span class="badge badge-red">Inactivo</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="actions">
                        <a href="<?= url('admin/admision/edit/' . $proceso['id']) ?>" class="action-btn" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= url('admin/admision/requisitos/' . $proceso['id']) ?>" class="action-btn" title="Requisitos">
                            <i class="fas fa-list-check"></i>
                        </a>
                        <a href="<?= url('admin/admision/modalidades/' . $proceso['id']) ?>" class="action-btn" title="Modalidades">
                            <i class="fas fa-layer-group"></i>
                        </a>
                        <a href="<?= url('admin/admision/resultados/' . $proceso['id']) ?>" class="action-btn" title="Resultados">
                            <i class="fas fa-poll"></i>
                        </a>
                        <a href="<?= url('admin/admision/documentos/' . $proceso['id']) ?>" class="action-btn" title="Documentos / Descargas">
                            <i class="fas fa-folder"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmDelete(<?= $proceso['id'] ?>)" class="action-btn" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto! Se eliminarán todos los requisitos, modalidades y resultados asociados.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= url('admin/admision/delete/') ?>' + id;
        }
    })
}
</script>


