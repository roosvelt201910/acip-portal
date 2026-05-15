<?php ob_start(); ?>

<div class="header-container">
    <h2 class="page-title">Administrar Programas</h2>
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Dashboard</a> / 
        <span>Programas</span>
    </div>
</div>

<style>
.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.action-btn i {
    font-size: 16px;
    position: relative;
    z-index: 2;
    transition: transform 0.3s ease;
}

.action-btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
    transform: translate(-50%, -50%);
    transition: width 0.4s ease, height 0.4s ease;
}

.action-btn:hover::before {
    width: 100px;
    height: 100px;
}

.action-btn:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.action-btn:hover i {
    transform: scale(1.1);
}

.action-btn:active {
    transform: translateY(-1px) scale(1.02);
}

/* Preview Button - Blue Gradient */
.action-preview {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.action-preview:hover {
    background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

/* Link Button - Purple Gradient */
.action-link {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.action-link:hover {
    background: linear-gradient(135deg, #e082ea 0%, #e4465b 100%);
    box-shadow: 0 8px 25px rgba(240, 147, 251, 0.4);
}

/* Edit Button - Orange Gradient */
.action-edit {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    color: white;
}

.action-edit:hover {
    background: linear-gradient(135deg, #e95f89 0%, #edd02f 100%);
    box-shadow: 0 8px 25px rgba(250, 112, 154, 0.4);
}

/* Delete Button - Red Gradient */
.action-delete {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
    color: white;
}

.action-delete:hover {
    background: linear-gradient(135deg, #ee5a5a 0%, #dd495e 100%);
    box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
}

/* Pulse animation on hover */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

.action-btn:hover {
    animation: pulse 1.5s ease-in-out infinite;
}
</style>

<div class="actions-bar-enterprise">
    <a href="<?= url('admin/programas/crear') ?>" class="btn-enterprise">
        <i class="fas fa-plus"></i> Nuevo Programa
    </a>
</div>

<div class="card-enterprise">
    <div class="table-responsive">
        <table class="table-enterprise">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Modalidad</th>
                    <th>Duración</th>
                    <th>Estado</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($programas)): ?>
                    <?php foreach ($programas as $item): ?>
                    <tr>
                        <td style="font-weight: 500; color: var(--text-dark);"><?= e($item['nombre']) ?></td>
                        <td><span class="badge-enterprise badge-gray"><?= e(ucfirst($item['modalidad'])) ?></span></td>
                        <td><?= e($item['duracion_semestres']) ?> semestres</td>
                        <td>
                            <?php if ($item['activo']): ?>
                                <span class="badge-enterprise badge-success">Activo</span>
                            <?php else: ?>
                                <span class="badge-enterprise badge-danger">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions-cell" style="text-align: right;">
                            <div style="display: inline-flex; gap: 8px; align-items: center;">
                                <a href="<?= url('programas/' . $item['slug']) ?>" target="_blank" class="action-btn action-preview" title="Vista Previa">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button onclick="editSlug(<?= $item['id'] ?>, '<?= $item['slug'] ?>')" class="action-btn action-link" title="Editar Enlace">
                                    <i class="fas fa-link"></i>
                                </button>
                                <a href="<?= url('admin/programas/editar/' . $item['id']) ?>" class="action-btn action-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete('<?= url('admin/programas/eliminar/' . $item['id']) ?>')" class="action-btn action-delete" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-light);">No hay programas registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(url) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "No podrás revertir esto",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminarlo",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}

function editSlug(id, currentSlug) {
    const baseUrl = '<?= url('programas/') ?>';
    
    Swal.fire({
        title: '<i class="fas fa-link" style="color: #9b59b6;"></i> Editar Enlace del Programa',
        html: `
            <div style="text-align: left; margin: 20px 0;">
                <label style="font-weight: 600; color: #34495e; display: block; margin-bottom: 5px;">URL Personalizada (Slug)</label>
                <div style="display: flex; align-items: stretch; border: 2px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                    <span style="background: #f8f9fa; padding: 10px; color: #7f8c8d; font-size: 14px; display: flex; align-items: center; border-right: 1px solid #e9ecef;">
                        ${baseUrl}
                    </span>
                    <input type="text" id="slug-input" value="${currentSlug}" 
                           style="flex: 1; border: none; padding: 10px; font-size: 14px; outline: none; color: #2c3e50;">
                </div>
                <small style="color: #95a5a6; margin-top: 5px; display: block;">Solo se permiten letras minúsculas, números y guiones.</small>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Guardar Cambios',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#9b59b6',
        width: 600,
        preConfirm: () => {
            const newSlug = document.getElementById('slug-input').value;
            if (!newSlug) {
                Swal.showValidationMessage('El slug no puede estar vacío');
                return false;
            }
            return newSlug;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const newSlug = result.value;
            
            // Send request to update slug
            const formData = new FormData();
            formData.append('slug', newSlug);
            
            fetch(`<?= url('admin/programas/update-slug/') ?>${id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: 'El enlace del programa ha sido actualizado.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message || 'No se pudo actualizar', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Error de conexión', 'error');
            });
        }
    });
}
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
