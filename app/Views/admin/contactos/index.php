<?php ob_start(); ?>

<style>
.modal-enterprise {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.modal-content-enterprise {
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    max-height: 90vh;
    overflow-y: auto;
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header-enterprise {
    padding: 20px 30px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8fafc;
    border-radius: 12px 12px 0 0;
}

.modal-header-enterprise h3 {
    margin: 0;
    font-size: 1.25rem;
    color: #1e3a8a;
    font-weight: 700;
}

.modal-body-enterprise {
    padding: 30px;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}

.detail-item {
    margin-bottom: 0;
}

.detail-label {
    display: block;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    font-weight: 600;
    margin-bottom: 6px;
}

.detail-value {
    font-size: 1rem;
    color: #334155;
    font-weight: 500;
    word-break: break-word;
}

.detail-value.highlight {
    color: #1e3a8a;
    font-weight: 600;
    font-family: monospace;
    font-size: 1.1rem;
}

.detail-full {
    grid-column: 1 / -1;
    background: #f8fafc;
    padding: 16px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.modal-footer-enterprise {
    padding: 20px 30px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    background: #f8fafc;
    border-radius: 0 0 12px 12px;
}

.btn-icon-enterprise.delete:hover {
    color: #ef4444;
    background: #fee2e2;
}

.btn-icon-enterprise.warning:hover {
    color: #f59e0b;
    background: #fef3c7;
}

.row-new {
    background-color: #f0f9ff; /* Light blue background for new strings */
}
.row-new:hover {
    background-color: #e0f2fe !important;
}
.row-new td:first-child {
    box-shadow: inset 4px 0 0 #0ea5e9; /* Blue visual indicator */
}
</style>

<div class="header-container">
    <h2 class="page-title">Mesajes de Contacto</h2>
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Dashboard</a> / 
        <span>Contactos</span>
    </div>
</div>

<div class="card-enterprise">
    <div class="table-responsive">
        <table class="table-enterprise">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Asunto</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($contactos)): ?>
                    <?php foreach ($contactos as $item): ?>
                    <tr class="<?= ($item['estado'] ?? 'nuevo') === 'nuevo' ? 'row-new' : '' ?>">
                        <td style="font-weight: 500; color: var(--text-dark);"><?= e($item['nombre']) ?></td>
                        <td><a href="mailto:<?= e($item['email']) ?>" style="color: var(--primary); text-decoration: none;"><?= e($item['email']) ?></a></td>
                        <td><?= e($item['asunto']) ?></td>
                        <td>
                            <?php if (($item['estado'] ?? 'nuevo') === 'nuevo'): ?>
                                <span class="badge-enterprise badge-success">Nuevo</span>
                            <?php else: ?>
                                <span class="badge-enterprise badge-gray"><?= e(ucfirst($item['estado'] ?? '')) ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= formatDateTime($item['created_at']) ?></td>
                        <td class="actions-cell">
                            <a href="#" class="btn-icon-enterprise edit" title="Ver Mensaje" onclick="viewMessage(<?= htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') ?>); return false;"><i class="fas fa-eye"></i></a>
                            <a href="#" class="btn-icon-enterprise warning" title="Cambiar Estado" onclick="toggleStatus(<?= $item['id'] ?>, '<?= $item['estado'] ?? 'nuevo' ?>'); return false;"><i class="fas fa-check-circle"></i></a>
                            <a href="#" class="btn-icon-enterprise delete" title="Eliminar" onclick="confirmDelete('<?= url('admin/contactos/eliminar/' . ($item['id'] ?? 0)) ?>'); return false;"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-light);">No hay mensajes de contacto.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para ver detalles del mensaje -->
<div id="viewModal" class="modal-enterprise" style="display: none;">
    <div class="modal-content-enterprise" style="max-width: 800px; width: 90%;">
        <div class="modal-header-enterprise">
            <h3><i class="fas fa-envelope-open-text me-2"></i> Detalles del Mensaje</h3>
            <button class="close-modal-enterprise" onclick="closeViewModal()">&times;</button>
        </div>
        <div class="modal-body-enterprise">
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Nombre</span>
                    <div id="view-nombre" class="detail-value highlight"></div>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Estado</span>
                    <div id="view-estado" class="detail-value"></div>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Email</span>
                    <div id="view-email" class="detail-value"></div>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Teléfono</span>
                    <div id="view-telefono" class="detail-value"></div>
                </div>
                <div class="detail-item detail-full">
                    <span class="detail-label">Asunto</span>
                    <div id="view-asunto" class="detail-value"></div>
                </div>
                <div class="detail-item detail-full">
                    <span class="detail-label">Mensaje</span>
                    <div id="view-mensaje" class="detail-value" style="white-space: pre-line; line-height: 1.6;"></div>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Fecha de Recepción</span>
                    <div id="view-fecha" class="detail-value"></div>
                </div>
                <div class="detail-item">
                    <span class="detail-label">IP Address</span>
                    <div id="view-ip" class="detail-value" style="font-family: monospace;"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer-enterprise">
            <button type="button" class="btn-enterprise btn-secondary" onclick="closeViewModal()">Cerrar</button>
        </div>
    </div>
</div>

<script>
function viewMessage(item) {
    document.getElementById('view-nombre').textContent = item.nombre || '';
    document.getElementById('view-email').textContent = item.email || '';
    document.getElementById('view-telefono').textContent = item.telefono || '';
    document.getElementById('view-asunto').textContent = item.asunto || '';
    document.getElementById('view-mensaje').textContent = item.mensaje || '';
    document.getElementById('view-fecha').textContent = item.created_at || '';
    document.getElementById('view-ip').textContent = item.ip_address || 'N/A';
    
    const estadoBadge = item.estado === 'nuevo' 
        ? '<span class="badge-enterprise badge-success">Nuevo</span>'
        : '<span class="badge-enterprise badge-gray">' + (item.estado || '').charAt(0).toUpperCase() + (item.estado || '').slice(1) + '</span>';
    document.getElementById('view-estado').innerHTML = estadoBadge;
    
    document.getElementById('viewModal').style.display = 'flex';
}

function closeViewModal() {
    document.getElementById('viewModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('viewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeViewModal();
    }
});

function toggleStatus(id, currentStatus) {
    const newStatus = currentStatus === 'nuevo' ? 'leido' : 'nuevo';
    const confirmMsg = currentStatus === 'nuevo' 
        ? '¿Marcar este mensaje como LEÍDO?' 
        : '¿Marcar este mensaje como NUEVO?';
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: confirmMsg,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cambiar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('<?= url("admin/contactos/actualizar-estado/") ?>' + id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ estado: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Actualizado!',
                        text: 'El estado ha sido actualizado.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error',
                        'Error al actualizar estado: ' + (data.message || 'Error desconocido'),
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'Error al procesar la solicitud',
                    'error'
                );
            });
        }
    });
}

function confirmDelete(deleteUrl) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = deleteUrl;
        }
    });
}
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
