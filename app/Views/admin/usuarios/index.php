<?php ob_start(); ?>

<style>
    .users-page { padding: 0; }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .page-title { font-size: 24px; font-weight: 700; color: #1e293b; }
    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
        transition: all 0.2s ease;
    }
    .btn-create:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5); }
    
    .users-table {
        width: 100%;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }
    .users-table th {
        background: #f8fafc;
        padding: 16px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }
    .users-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .users-table tr:last-child td { border-bottom: none; }
    .users-table tr:hover { background: #f8fafc; }
    
    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
    }
    .user-name { font-weight: 600; color: #1e293b; }
    .user-email { font-size: 13px; color: #64748b; }
    
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .role-admin { background: #fef3c7; color: #d97706; }
    .role-usuario { background: #dbeafe; color: #2563eb; }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-active { background: #dcfce7; color: #16a34a; }
    .status-inactive { background: #fee2e2; color: #dc2626; }
    .status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }
    
    .actions {
        display: flex;
        gap: 8px;
    }
    .btn-action {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-edit { background: #dbeafe; color: #2563eb; }
    .btn-edit:hover { background: #bfdbfe; }
    .btn-toggle { background: #fef3c7; color: #d97706; }
    .btn-toggle:hover { background: #fde68a; }
    .btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-delete:hover { background: #fecaca; }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
    }
    .empty-state i { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
    
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .stat-value { font-size: 28px; font-weight: 700; color: #1e293b; }
    .stat-label { font-size: 13px; color: #64748b; margin-top: 4px; }
</style>

<div class="users-page">
    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-value"><?= count($users) ?></div>
            <div class="stat-label">Total Usuarios</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= count(array_filter($users, fn($u) => $u['rol'] === 'administrador')) ?></div>
            <div class="stat-label">Administradores</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= count(array_filter($users, fn($u) => $u['activo'])) ?></div>
            <div class="stat-label">Activos</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= count(array_filter($users, fn($u) => !$u['activo'])) ?></div>
            <div class="stat-label">Inactivos</div>
        </div>
    </div>

    <!-- Header -->
    <div class="page-header">
        <h1 class="page-title">Gestión de Usuarios</h1>
        <a href="<?= url('admin/usuarios/create') ?>" class="btn-create">
            <i class="fas fa-plus"></i>
            Nuevo Usuario
        </a>
    </div>

    <!-- Table -->
    <?php if (empty($users)): ?>
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <p>No hay usuarios registrados</p>
        </div>
    <?php else: ?>
        <table class="users-table">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <?php 
                    $avatar = !empty($u['avatar']) 
                        ? asset($u['avatar']) 
                        : "https://ui-avatars.com/api/?name=" . urlencode($u['nombre']) . "&background=6366f1&color=ffffff&size=88";
                    $isCurrentUser = $u['id'] == $_SESSION['user_id'];
                    ?>
                    <tr>
                        <td>
                            <div class="user-cell">
                                <img src="<?= $avatar ?>" alt="Avatar" class="user-avatar">
                                <div>
                                    <div class="user-name">
                                        <?= htmlspecialchars($u['nombre']) ?>
                                        <?php if ($isCurrentUser): ?>
                                            <span style="font-size: 11px; color: #6366f1;">(Tú)</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="user-email"><?= htmlspecialchars($u['email']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="role-badge role-<?= $u['rol'] ?>">
                                <i class="fas <?= $u['rol'] === 'administrador' ? 'fa-shield-alt' : 'fa-user' ?>"></i>
                                <?= ucfirst($u['rol']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="status-badge <?= $u['activo'] ? 'status-active' : 'status-inactive' ?>">
                                <?= $u['activo'] ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
                        <td>
                            <div class="actions">
                                <a href="<?= url('admin/usuarios/edit/' . $u['id']) ?>" class="btn-action btn-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if (!$isCurrentUser): ?>
                                    <form action="<?= url('admin/usuarios/toggle/' . $u['id']) ?>" method="POST" style="display:inline;">
                                        <button type="submit" class="btn-action btn-toggle" title="<?= $u['activo'] ? 'Desactivar' : 'Activar' ?>">
                                            <i class="fas <?= $u['activo'] ? 'fa-toggle-on' : 'fa-toggle-off' ?>"></i>
                                        </button>
                                    </form>
                                    <form action="<?= url('admin/usuarios/delete/' . $u['id']) ?>" method="POST" style="display:inline;" 
                                          onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                        <button type="submit" class="btn-action btn-delete" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../../layouts/admin.php'; ?>
