<?php
/**
 * Vista del Dashboard Administrativo
 */
?>
<?php
ob_start();
?>

<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 4px solid transparent;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .stat-content h3 {
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    /* Card Colors */
    .card-purple { border-color: #7c3aed; }
    .card-purple .stat-icon { background: #f3e8ff; color: #7c3aed; }

    .card-blue { border-color: #2563eb; }
    .card-blue .stat-icon { background: #eff6ff; color: #2563eb; }

    .card-green { border-color: #059669; }
    .card-green .stat-icon { background: #ecfdf5; color: #059669; }

    .card-orange { border-color: #ea580c; }
    .card-orange .stat-icon { background: #fff7ed; color: #ea580c; }

    .card-cyan { border-color: #0891b2; }
    .card-cyan .stat-icon { background: #ecfeff; color: #0891b2; }

    .card-red { border-color: #dc2626; }
    .card-red .stat-icon { background: #fef2f2; color: #dc2626; }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #3b82f6;
    }

    /* Activity Table */
    .activity-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .activity-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .activity-table th {
        background: #f8fafc;
        padding: 16px 24px;
        text-align: left;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }

    .activity-table td {
        padding: 16px 24px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    .activity-table tr:last-child td {
        border-bottom: none;
    }

    .activity-table tr:hover {
        background: #fcfcfc;
    }

    .user-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
    }

    .user-avatar {
        width: 28px;
        height: 28px;
        background: #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        color: #64748b;
    }

    .action-tag {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }
    
    .action-login { background: #eff6ff; color: #2563eb; }
    .action-logout { background: #f1f5f9; color: #64748b; }
    .action-create { background: #ecfdf5; color: #059669; }
    .action-update { background: #fff7ed; color: #ea580c; }
    .action-delete { background: #fef2f2; color: #dc2626; }
</style>

<div class="dashboard-header" style="margin-bottom: 30px;">
    <h1 style="font-size: 28px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Panel de Control</h1>
    <p style="color: #64748b;">Bienvenido al sistema de administración del portal ACIP.</p>
</div>

<!-- Estadísticas -->
<div class="dashboard-grid">
    <!-- Páginas -->
    <div class="stat-card card-purple">
        <div class="stat-content">
            <h3>Páginas</h3>
            <div class="stat-value"><?= number_format($stats['paginas']) ?></div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-file-alt"></i>
        </div>
    </div>
    
    <!-- Noticias -->
    <div class="stat-card card-blue">
        <div class="stat-content">
            <h3>Noticias</h3>
            <div class="stat-value"><?= number_format($stats['noticias']) ?></div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-newspaper"></i>
        </div>
    </div>
    
    <!-- Eventos -->
    <div class="stat-card card-green">
        <div class="stat-content">
            <h3>Eventos</h3>
            <div class="stat-value"><?= number_format($stats['eventos']) ?></div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-calendar-alt"></i>
        </div>
    </div>
    
    <!-- Documentos -->
    <div class="stat-card card-orange">
        <div class="stat-content">
            <h3>Documentos</h3>
            <div class="stat-value"><?= number_format($stats['documentos']) ?></div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-folder-open"></i>
        </div>
    </div>
    
    <!-- Usuarios -->
    <div class="stat-card card-cyan">
        <div class="stat-content">
            <h3>Usuarios</h3>
            <div class="stat-value"><?= number_format($stats['usuarios']) ?></div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
    </div>

    <!-- Reclamaciones -->
    <?php if ($stats['reclamaciones_pendientes'] > 0): ?>
    <div class="stat-card card-red">
        <div class="stat-content">
            <h3>Reclamos Pendientes</h3>
            <div class="stat-value"><?= number_format($stats['reclamaciones_pendientes']) ?></div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Actividad Reciente -->
<h2 class="section-title">
    <i class="fas fa-history"></i>
    Actividad Reciente del Sistema
</h2>

<div class="activity-container">
    <div class="table-responsive">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Detalle</th>
                    <th>Fecha y Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($actividad)): ?>
                    <?php foreach ($actividad as $log): ?>
                    <tr>
                        <td>
                            <div class="user-badge">
                                <div class="user-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <?= e($log['usuario_nombre'] ?? 'Sistema') ?>
                            </div>
                        </td>
                        <td>
                            <?php 
                                $actionClass = 'action-logout';
                                if (stripos($log['accion'], 'login') !== false) $actionClass = 'action-login';
                                elseif (stripos($log['accion'], 'crear') !== false) $actionClass = 'action-create';
                                elseif (stripos($log['accion'], 'actualizar') !== false || stripos($log['accion'], 'editar') !== false) $actionClass = 'action-update';
                                elseif (stripos($log['accion'], 'eliminar') !== false) $actionClass = 'action-delete';
                            ?>
                            <span class="action-tag <?= $actionClass ?>">
                                <?= e($log['accion']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($log['tabla']): ?>
                                En <strong><?= e(ucfirst($log['tabla'])) ?></strong>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td style="color: #64748b;">
                            <i class="far fa-clock" style="margin-right: 6px;"></i>
                            <?= date('d/m/Y h:i A', strtotime($log['created_at'])) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8;">
                            No hay actividad reciente registrada.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
$currentPage = 'dashboard';
require APP_PATH . '/Views/layouts/admin.php';
?>
