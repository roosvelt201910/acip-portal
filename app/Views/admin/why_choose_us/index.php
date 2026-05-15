<?php ob_start(); ?>
<style>
:root {
    --primary-color: #4f46e5;
    --primary-hover: #4338ca;
    --secondary-color: #64748b;
    --success-color: #10b981;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --dark: #1e293b;
    --light: #f8fafc;
    --border-color: #e2e8f0;
    --text-primary: #0f172a;
    --text-secondary: #64748b;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --radius-sm: 6px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    box-sizing: border-box;
}

/* Header Container */
.header-container {
    margin-bottom: 2rem;
    animation: slideDown 0.5s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    background: white;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    font-size: 0.875rem;
}

.breadcrumb a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.breadcrumb a::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--primary-color);
    transition: width 0.3s ease;
}

.breadcrumb a:hover::after {
    width: 100%;
}

.breadcrumb span {
    color: var(--text-secondary);
}

.breadcrumb .current {
    color: var(--text-primary);
    font-weight: 600;
}

/* Card Enterprise */
.card-enterprise {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card-header-enterprise {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
    color: white;
    border-bottom: 4px solid rgba(255, 255, 255, 0.1);
}

.card-header-enterprise h2 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-header-enterprise h2 i {
    font-size: 1.25rem;
    opacity: 0.9;
}

.header-actions {
    display: flex;
    gap: 0.75rem;
}

/* Buttons */
.btn-enterprise {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 0.9375rem;
    text-decoration: none;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
    font-family: inherit;
    background: white;
    color: var(--primary-color);
}

.btn-enterprise:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    background: var(--light);
}

.btn-enterprise:active {
    transform: translateY(0);
}

/* Table */
.table-responsive {
    overflow-x: auto;
    margin: 0;
}

.table-enterprise {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9375rem;
}

.table-enterprise thead {
    background: linear-gradient(135deg, var(--light) 0%, #e0e7ff 100%);
}

.table-enterprise thead tr {
    border-bottom: 2px solid var(--primary-color);
}

.table-enterprise th {
    padding: 1.25rem 1.5rem;
    text-align: left;
    font-weight: 700;
    color: var(--text-primary);
    text-transform: uppercase;
    font-size: 0.8125rem;
    letter-spacing: 0.5px;
}

.table-enterprise tbody tr {
    border-bottom: 1px solid var(--border-color);
    transition: var(--transition);
}

.table-enterprise tbody tr:hover {
    background: var(--light);
    transform: scale(1.01);
    box-shadow: var(--shadow-sm);
}

.table-enterprise tbody tr:last-child {
    border-bottom: none;
}

.table-enterprise td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    color: var(--text-primary);
}

/* Table Image Preview */
.table-img-preview {
    width: 40px;
    height: 40px;
    object-fit: contain;
    border-radius: var(--radius-sm);
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    background: var(--light);
    padding: 0.25rem;
}

.table-img-preview:hover {
    transform: scale(2.5);
    box-shadow: var(--shadow-lg);
    z-index: 10;
    position: relative;
    cursor: zoom-in;
}

/* Font Weight */
.font-weight-500 {
    font-weight: 500;
}

/* Text Muted */
.text-muted {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

/* Badges */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-green {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-color);
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.badge-green::before {
    content: '●';
    font-size: 0.75rem;
}

.badge-red {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger-color);
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.badge-red::before {
    content: '●';
    font-size: 0.75rem;
}

.badge-gray {
    background: rgba(100, 116, 139, 0.1);
    color: var(--secondary-color);
    border: 1px solid rgba(100, 116, 139, 0.2);
    font-weight: 700;
}

/* Actions Cell */
.actions-cell {
    text-align: center;
}

.btn-icon-enterprise {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-sm);
    background: white;
    color: var(--text-secondary);
    cursor: pointer;
    transition: var(--transition);
    margin: 0 0.25rem;
    text-decoration: none;
}

.btn-icon-enterprise:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-icon-enterprise:not(.delete):hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.btn-icon-enterprise.delete:hover {
    background: var(--danger-color);
    color: white;
    border-color: var(--danger-color);
}

.btn-icon-enterprise:active {
    transform: translateY(0);
}

/* Text Center */
.text-center {
    text-align: center;
}

/* Padding */
.p-5 {
    padding: 3rem !important;
}

/* Empty State */
.empty-state {
    padding: 4rem 2rem;
    text-align: center;
    color: var(--text-secondary);
}

.empty-state i {
    font-size: 4rem;
    color: var(--border-color);
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 0.9375rem;
    margin-bottom: 1.5rem;
}

/* Stats Bar (opcional) */
.stats-bar {
    display: flex;
    gap: 1rem;
    padding: 1.5rem 2rem;
    background: var(--light);
    border-bottom: 1px solid var(--border-color);
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.25rem;
    background: white;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.stat-icon.primary {
    background: rgba(79, 70, 229, 0.1);
    color: var(--primary-color);
}

.stat-icon.success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-color);
}

.stat-icon.danger {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger-color);
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
}

.stat-label {
    font-size: 0.75rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 0.25rem;
}

/* Responsive */
@media (max-width: 768px) {
    .card-header-enterprise {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .header-actions {
        width: 100%;
    }

    .btn-enterprise {
        width: 100%;
        justify-content: center;
    }

    .table-enterprise {
        font-size: 0.875rem;
    }

    .table-enterprise th,
    .table-enterprise td {
        padding: 0.75rem;
    }

    .stats-bar {
        flex-direction: column;
    }

    .stat-item {
        width: 100%;
    }

    /* Ocultar columnas en móviles */
    .table-enterprise th:nth-child(3),
    .table-enterprise td:nth-child(3) {
        display: none;
    }
}

/* SweetAlert2 Custom Styling */
.swal2-popup {
    border-radius: var(--radius-lg) !important;
    box-shadow: var(--shadow-xl) !important;
}

.swal2-title {
    color: var(--text-primary) !important;
    font-weight: 700 !important;
}

.swal2-html-container {
    color: var(--text-secondary) !important;
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
}

/* Loading Overlay */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.loading-overlay.active {
    display: flex;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>

<div class="header-container">
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">
            <i class="fas fa-home"></i> Inicio
        </a>
        <span>/</span>
        <span class="current">Por qué elegirnos</span>
    </div>
</div>

<div class="card-enterprise">
    <div class="card-header-enterprise">
        <h2>
            <i class="fas fa-check-circle"></i>
            Por qué elegirnos
        </h2>
        <div class="header-actions">
            <a href="<?= url('admin/why-choose-us/crear') ?>" class="btn-enterprise">
                <i class="fas fa-plus-circle"></i> Nuevo Elemento
            </a>
        </div>
    </div>

    <!-- Barra de estadísticas (opcional) -->
    <?php if (!empty($items)): ?>
    <div class="stats-bar">
        <div class="stat-item">
            <div class="stat-icon primary">
                <i class="fas fa-list"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value"><?= count($items) ?></span>
                <span class="stat-label">Total elementos</span>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon success">
                <i class="fas fa-check"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value"><?= count(array_filter($items, fn($i) => $i['activo'])) ?></span>
                <span class="stat-label">Activos</span>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon danger">
                <i class="fas fa-times"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value"><?= count(array_filter($items, fn($i) => !$i['activo'])) ?></span>
                <span class="stat-label">Inactivos</span>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table-enterprise">
            <thead>
                <tr>
                    <th width="80">Icono</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th width="100">Orden</th>
                    <th width="120">Estado</th>
                    <th width="150">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <?php if ($item['imagen']): ?>
                                    <img src="<?= url('uploads/why_choose_us/' . e($item['imagen'])) ?>" 
                                         class="table-img-preview" 
                                         alt="<?= e($item['titulo']) ?>"
                                         title="<?= e($item['titulo']) ?>">
                                <?php else: ?>
                                    <span class="text-muted" style="font-size: 1.5rem;">
                                        <i class="fas fa-image"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span class="font-weight-500"><?= e($item['titulo']) ?></span>
                            </div>
                        </td>
                        <td class="text-muted">
                            <?php 
                            $desc = e($item['descripcion']);
                            echo strlen($desc) > 60 ? substr($desc, 0, 60) . '...' : $desc;
                            ?>
                        </td>
                        <td>
                            <span class="badge badge-gray">
                                <i class="fas fa-sort-amount-down"></i>
                                <?= e($item['orden']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($item['activo']): ?>
                                <span class="badge badge-green">
                                    Activo
                                </span>
                            <?php else: ?>
                                <span class="badge badge-red">
                                    Inactivo
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="actions-cell">
                            <a href="<?= url('admin/why-choose-us/editar/' . $item['id']) ?>" 
                               class="btn-icon-enterprise" 
                               title="Editar elemento">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete(<?= $item['id'] ?>, '<?= e(addslashes($item['titulo'])) ?>')" 
                                    class="btn-icon-enterprise delete" 
                                    title="Eliminar elemento"
                                    type="button">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h3>No hay elementos registrados</h3>
                                <p>Comienza agregando tu primer elemento para mostrar las ventajas de tu institución</p>
                                <a href="<?= url('admin/why-choose-us/crear') ?>" class="btn-enterprise" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%); color: white;">
                                    <i class="fas fa-plus-circle"></i> Crear Primer Elemento
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<script>
function confirmDelete(id, titulo) {
    Swal.fire({
        title: '¿Eliminar elemento?',
        html: `¿Estás seguro de que deseas eliminar <strong>"${titulo}"</strong>?<br><small>Esta acción no se puede revertir.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
        cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
        reverseButtons: true,
        customClass: {
            popup: 'swal-custom-popup',
            confirmButton: 'swal-custom-confirm',
            cancelButton: 'swal-custom-cancel'
        },
        buttonsStyling: true,
        showClass: {
            popup: 'animate__animated animate__fadeInDown animate__faster'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp animate__faster'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            document.getElementById('loadingOverlay').classList.add('active');
            
            // Redirigir
            window.location.href = '<?= url('admin/why-choose-us/eliminar/') ?>' + id;
        }
    });
}

// Animación de entrada para las filas
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.table-enterprise tbody tr');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease-out';
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, index * 50);
    });
});
</script>

<?php
$content = ob_get_clean();
$extraJS = '
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
';
require APP_PATH . '/Views/layouts/admin.php';
?>