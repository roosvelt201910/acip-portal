
<div class="admision-admin-page">
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

<div class="table-container admision-table-wrap">
    <table class="table admision-table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Estado</th>
                <th class="th-actions">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($procesos as $proceso): ?>
            <tr>
                <td class="td-title"><strong><?= e($proceso['titulo']) ?></strong></td>
                <td><?= date('d/m/Y', strtotime($proceso['fecha_inicio'])) ?></td>
                <td><?= date('d/m/Y', strtotime($proceso['fecha_fin'])) ?></td>
                <td>
                    <?php if ($proceso['activo']): ?>
                        <span class="badge badge-green">Activo</span>
                    <?php else: ?>
                        <span class="badge badge-red">Inactivo</span>
                    <?php endif; ?>
                </td>
                <td class="td-actions">
                    <div class="admision-actions" role="group" aria-label="Acciones del proceso">
                        <a href="<?= url('admin/admision/edit/' . $proceso['id']) ?>" class="admision-action admision-action--edit">
                            <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                            <span>Editar</span>
                        </a>
                        <a href="<?= url('admin/admision/requisitos/' . $proceso['id']) ?>" class="admision-action admision-action--req">
                            <i class="fas fa-list-check" aria-hidden="true"></i>
                            <span>Requisitos</span>
                        </a>
                        <a href="<?= url('admin/admision/modalidades/' . $proceso['id']) ?>" class="admision-action admision-action--mod">
                            <i class="fas fa-layer-group" aria-hidden="true"></i>
                            <span>Modalidades</span>
                        </a>
                        <a href="<?= url('admin/admision/resultados/' . $proceso['id']) ?>" class="admision-action admision-action--res">
                            <i class="fas fa-chart-column" aria-hidden="true"></i>
                            <span>Resultados</span>
                        </a>
                        <a href="<?= url('admin/admision/documentos/' . $proceso['id']) ?>" class="admision-action admision-action--doc">
                            <i class="fas fa-folder-open" aria-hidden="true"></i>
                            <span>Documentos</span>
                        </a>
                        <button type="button" onclick="confirmDelete(<?= (int) $proceso['id'] ?>)" class="admision-action admision-action--del">
                            <i class="fas fa-trash-can" aria-hidden="true"></i>
                            <span>Eliminar</span>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>

<style>
.admision-admin-page .admision-table-wrap {
    overflow-x: auto;
}

.admision-admin-page .admision-table .th-actions,
.admision-admin-page .admision-table .td-actions {
    min-width: 420px;
    width: 38%;
}

.admision-admin-page .td-title {
    min-width: 160px;
}

.admision-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    align-items: stretch;
}

.admision-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    padding: 0.5rem 0.75rem;
    min-height: 36px;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    line-height: 1.2;
    text-decoration: none;
    border: 1px solid transparent;
    cursor: pointer;
    white-space: nowrap;
    transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    font-family: inherit;
}

.admision-action i {
    font-size: 0.95rem;
    flex-shrink: 0;
}

.admision-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

.admision-action:focus-visible {
    outline: 2px solid #1e3a8a;
    outline-offset: 2px;
}

.admision-action--edit {
    background: #eff6ff;
    color: #1d4ed8;
    border-color: #bfdbfe;
}
.admision-action--edit:hover {
    background: #dbeafe;
    color: #1e40af;
}

.admision-action--req {
    background: #f0fdf4;
    color: #15803d;
    border-color: #bbf7d0;
}
.admision-action--req:hover {
    background: #dcfce7;
}

.admision-action--mod {
    background: #faf5ff;
    color: #7e22ce;
    border-color: #e9d5ff;
}
.admision-action--mod:hover {
    background: #f3e8ff;
}

.admision-action--res {
    background: #fff7ed;
    color: #c2410c;
    border-color: #fed7aa;
}
.admision-action--res:hover {
    background: #ffedd5;
}

.admision-action--doc {
    background: #ecfeff;
    color: #0e7490;
    border-color: #a5f3fc;
}
.admision-action--doc:hover {
    background: #cffafe;
}

.admision-action--del {
    background: #fef2f2;
    color: #b91c1c;
    border-color: #fecaca;
}
.admision-action--del:hover {
    background: #fee2e2;
    color: #991b1b;
}

@media (max-width: 1200px) {
    .admision-admin-page .admision-table .th-actions,
    .admision-admin-page .admision-table .td-actions {
        min-width: 320px;
    }

    .admision-action span {
        font-size: 0.75rem;
    }
}

@media (max-width: 768px) {
    .admision-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .admision-action {
        width: 100%;
        justify-content: flex-start;
    }
}
</style>

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

