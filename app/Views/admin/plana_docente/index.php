<?php ob_start(); ?>

<?php
// Calculate stats
$totalDocentes = count($docentes);
$docentesActivos = count(array_filter($docentes, fn($d) => $d['activo']));
$docentesInactivos = $totalDocentes - $docentesActivos;
$conCV = count(array_filter($docentes, fn($d) => !empty($d['cv'])));
?>

<div class="docentes-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="header-text">
                <h1>Plana Docente</h1>
                <p>Gestiona los docentes y su información académica</p>
            </div>
        </div>
        <div class="header-actions">
            <button class="btn-secondary" onclick="toggleView()">
                <i class="fas fa-th-large" id="viewIcon"></i>
                <span id="viewText">Vista Tarjetas</span>
            </button>
            <a href="<?= url('admin/plana-docente/crear') ?>" class="btn-primary">
                <i class="fas fa-plus"></i>
                <span>Nuevo Docente</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value"><?= $totalDocentes ?></span>
                <span class="stat-label">Total Docentes</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value"><?= $docentesActivos ?></span>
                <span class="stat-label">Activos</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value"><?= $docentesInactivos ?></span>
                <span class="stat-label">Inactivos</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value"><?= $conCV ?></span>
                <span class="stat-label">Con CV</span>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="filters-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Buscar por nombre, cargo..." onkeyup="filterDocentes()">
        </div>
        <div class="filter-group">
            <select id="filterPrograma" class="filter-select" onchange="filterDocentes()">
                <option value="">Todos los programas</option>
                <?php 
                $programas = array_unique(array_filter(array_column($docentes, 'programa_nombre')));
                foreach ($programas as $prog): 
                ?>
                    <option value="<?= htmlspecialchars($prog) ?>"><?= htmlspecialchars($prog) ?></option>
                <?php endforeach; ?>
            </select>
            <select id="filterEstado" class="filter-select" onchange="filterDocentes()">
                <option value="">Todos los estados</option>
                <option value="1">Activos</option>
                <option value="0">Inactivos</option>
            </select>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper">
        <?php if (empty($docentes)): ?>
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3>No hay docentes registrados</h3>
                <p>Comienza registrando al personal docente de la institución</p>
                <a href="<?= url('admin/plana-docente/crear') ?>" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    <span>Registrar Primer Docente</span>
                </a>
            </div>
        <?php else: ?>
            
            <!-- Table View -->
            <div class="table-container" id="tableView">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="th-photo">Foto</th>
                            <th class="th-name">Docente</th>
                            <th class="th-program">Programa</th>
                            <th class="th-docs">Documentos</th>
                            <th class="th-order">Orden</th>
                            <th class="th-status">Estado</th>
                            <th class="th-actions">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($docentes as $index => $row): ?>
                        <tr class="docente-row" 
                            data-nombre="<?= strtolower(htmlspecialchars($row['nombre'])) ?>"
                            data-cargo="<?= strtolower(htmlspecialchars($row['cargo'])) ?>"
                            data-programa="<?= htmlspecialchars($row['programa_nombre'] ?? '') ?>"
                            data-activo="<?= $row['activo'] ?>"
                            style="--delay: <?= $index * 0.03 ?>s">
                            
                            <!-- Photo -->
                            <td class="td-photo">
                                <div class="avatar <?= $row['activo'] ? '' : 'inactive' ?>">
                                    <?php if ($row['foto']): ?>
                                        <img src="<?= url($row['foto']) ?>" alt="<?= htmlspecialchars($row['nombre']) ?>">
                                    <?php else: ?>
                                        <div class="avatar-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                    <span class="avatar-status <?= $row['activo'] ? 'online' : 'offline' ?>"></span>
                                </div>
                            </td>
                            
                            <!-- Name & Role -->
                            <td class="td-name">
                                <div class="name-cell">
                                    <span class="docente-name"><?= htmlspecialchars($row['nombre']) ?></span>
                                    <span class="docente-cargo"><?= htmlspecialchars($row['cargo']) ?></span>
                                </div>
                            </td>
                            
                            <!-- Program -->
                            <td class="td-program">
                                <?php if ($row['programa_nombre']): ?>
                                    <span class="program-badge">
                                        <i class="fas fa-graduation-cap"></i>
                                        <?= htmlspecialchars($row['programa_nombre']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="program-badge general">
                                        <i class="fas fa-building"></i>
                                        General
                                    </span>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Documents -->
                            <td class="td-docs">
                                <div class="docs-container">
                                    <?php if ($row['cv']): ?>
                                        <a href="<?= url($row['cv']) ?>" target="_blank" class="doc-chip cv" title="Ver Curriculum Vitae">
                                            <i class="fas fa-file-pdf"></i>
                                            <span>CV</span>
                                        </a>
                                    <?php else: ?>
                                        <span class="doc-chip empty" title="Sin CV">
                                            <i class="fas fa-file-pdf"></i>
                                            <span>CV</span>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($row['carga_horaria']): ?>
                                        <a href="<?= url($row['carga_horaria']) ?>" target="_blank" class="doc-chip horario" title="Ver Carga Horaria">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>Horario</span>
                                        </a>
                                    <?php else: ?>
                                        <span class="doc-chip empty" title="Sin Carga Horaria">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>Horario</span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            
                            <!-- Order -->
                            <td class="td-order">
                                <span class="order-badge"><?= $row['orden'] ?></span>
                            </td>
                            
                            <!-- Status -->
                            <td class="td-status">
                                <?php if ($row['activo']): ?>
                                    <span class="status-badge active">
                                        <i class="fas fa-check-circle"></i>
                                        Activo
                                    </span>
                                <?php else: ?>
                                    <span class="status-badge inactive">
                                        <i class="fas fa-minus-circle"></i>
                                        Inactivo
                                    </span>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Actions -->
                            <td class="td-actions">
                                <div class="actions-group">
                                    <a href="<?= url('admin/plana-docente/editar/' . $row['id']) ?>" 
                                       class="action-btn edit" 
                                       title="Editar docente">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button" 
                                            class="action-btn delete" 
                                            onclick="confirmDelete(<?= $row['id'] ?>, '<?= htmlspecialchars(addslashes($row['nombre'])) ?>')"
                                            title="Eliminar docente">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Cards View (Hidden by default) -->
            <div class="cards-container" id="cardsView" style="display: none;">
                <div class="cards-grid">
                    <?php foreach ($docentes as $index => $row): ?>
                    <div class="docente-card <?= $row['activo'] ? '' : 'inactive' ?>"
                         data-nombre="<?= strtolower(htmlspecialchars($row['nombre'])) ?>"
                         data-cargo="<?= strtolower(htmlspecialchars($row['cargo'])) ?>"
                         data-programa="<?= htmlspecialchars($row['programa_nombre'] ?? '') ?>"
                         data-activo="<?= $row['activo'] ?>"
                         style="--delay: <?= $index * 0.05 ?>s">
                        
                        <!-- Card Header -->
                        <div class="card-header">
                            <div class="card-avatar">
                                <?php if ($row['foto']): ?>
                                    <img src="<?= url($row['foto']) ?>" alt="<?= htmlspecialchars($row['nombre']) ?>">
                                <?php else: ?>
                                    <div class="avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-status-dot <?= $row['activo'] ? 'active' : 'inactive' ?>"></div>
                        </div>
                        
                        <!-- Card Body -->
                        <div class="card-body">
                            <h3 class="card-name"><?= htmlspecialchars($row['nombre']) ?></h3>
                            <p class="card-cargo"><?= htmlspecialchars($row['cargo']) ?></p>
                            
                            <?php if ($row['programa_nombre']): ?>
                                <span class="card-program">
                                    <i class="fas fa-graduation-cap"></i>
                                    <?= htmlspecialchars($row['programa_nombre']) ?>
                                </span>
                            <?php else: ?>
                                <span class="card-program general">
                                    <i class="fas fa-building"></i>
                                    General
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Card Documents -->
                        <div class="card-docs">
                            <?php if ($row['cv']): ?>
                                <a href="<?= url($row['cv']) ?>" target="_blank" class="card-doc-btn cv">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($row['carga_horaria']): ?>
                                <a href="<?= url($row['carga_horaria']) ?>" target="_blank" class="card-doc-btn horario">
                                    <i class="fas fa-calendar-alt"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Card Footer -->
                        <div class="card-footer">
                            <a href="<?= url('admin/plana-docente/editar/' . $row['id']) ?>" class="card-action edit">
                                <i class="fas fa-pen"></i>
                                <span>Editar</span>
                            </a>
                            <button type="button" class="card-action delete" 
                                    onclick="confirmDelete(<?= $row['id'] ?>, '<?= htmlspecialchars(addslashes($row['nombre'])) ?>')">
                                <i class="fas fa-trash-alt"></i>
                                <span>Eliminar</span>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- No Results Message -->
            <div class="no-results" id="noResults" style="display: none;">
                <div class="no-results-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>No se encontraron resultados</h3>
                <p>Intenta con otros términos de búsqueda o filtros</p>
                <button class="btn-secondary" onclick="clearFilters()">
                    <i class="fas fa-times"></i>
                    <span>Limpiar filtros</span>
                </button>
            </div>
            
        <?php endif; ?>
    </div>
</div>

<style>
/* ============================================
   CSS Variables
   ============================================ */
:root {
    --primary: #3b82f6;
    --primary-dark: #2563eb;
    --primary-light: #dbeafe;
    
    --success: #10b981;
    --success-light: #d1fae5;
    
    --danger: #ef4444;
    --danger-light: #fee2e2;
    
    --warning: #f59e0b;
    --warning-light: #fef3c7;
    
    --purple: #8b5cf6;
    --purple-light: #ede9fe;
    
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
    
    --radius-sm: 6px;
    --radius-md: 10px;
    --radius-lg: 14px;
    --radius-xl: 20px;
    
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    
    --transition: 200ms ease;
}

/* ============================================
   Base Styles
   ============================================ */
.docentes-page {
    padding: 1.5rem;
    background: var(--gray-50);
    min-height: 100vh;
}

/* ============================================
   Page Header
   ============================================ */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    width: 52px;
    height: 52px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.4rem;
    box-shadow: 0 4px 14px -3px rgba(59, 130, 246, 0.5);
}

.header-text h1 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0;
}

.header-text p {
    font-size: 0.875rem;
    color: var(--gray-500);
    margin: 0.25rem 0 0;
}

.header-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-primary,
.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: var(--radius-md);
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all var(--transition);
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    box-shadow: 0 4px 14px -3px rgba(59, 130, 246, 0.4);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px -3px rgba(59, 130, 246, 0.5);
}

.btn-secondary {
    background: white;
    color: var(--gray-700);
    border: 1px solid var(--gray-200);
}

.btn-secondary:hover {
    background: var(--gray-50);
    border-color: var(--gray-300);
}

/* ============================================
   Stats Grid
   ============================================ */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

.stat-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-100);
    transition: all var(--transition);
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.stat-icon.blue { background: var(--primary-light); color: var(--primary); }
.stat-icon.green { background: var(--success-light); color: var(--success); }
.stat-icon.orange { background: var(--warning-light); color: var(--warning); }
.stat-icon.purple { background: var(--purple-light); color: var(--purple); }

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-900);
    line-height: 1;
}

.stat-label {
    font-size: 0.8rem;
    color: var(--gray-500);
    margin-top: 0.25rem;
}

/* ============================================
   Filters Bar
   ============================================ */
.filters-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.search-box {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
}

.search-box input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-md);
    font-size: 0.9rem;
    background: white;
    transition: all var(--transition);
}

.search-box input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.filter-group {
    display: flex;
    gap: 0.75rem;
}

.filter-select {
    padding: 0.75rem 2.5rem 0.75rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-md);
    font-size: 0.875rem;
    background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 1rem center;
    cursor: pointer;
    transition: all var(--transition);
}

.filter-select:focus {
    outline: none;
    border-color: var(--primary);
}

/* ============================================
   Table Styles
   ============================================ */
.table-container {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    border: 1px solid var(--gray-100);
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: var(--gray-50);
    border-bottom: 2px solid var(--gray-100);
}

.data-table th {
    padding: 1rem 1.25rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--gray-500);
}

.data-table tbody tr {
    border-bottom: 1px solid var(--gray-100);
    transition: all var(--transition);
    animation: fadeIn 0.3s ease both;
    animation-delay: var(--delay);
}

.data-table tbody tr:last-child {
    border-bottom: none;
}

.data-table tbody tr:hover {
    background: var(--gray-50);
}

.data-table td {
    padding: 1rem 1.25rem;
    vertical-align: middle;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Avatar */
.avatar {
    position: relative;
    width: 48px;
    height: 48px;
}

.avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid white;
    box-shadow: var(--shadow-sm);
}

.avatar.inactive img {
    filter: grayscale(50%);
    opacity: 0.7;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
    font-size: 1.25rem;
}

.avatar-status {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}

.avatar-status.online { background: var(--success); }
.avatar-status.offline { background: var(--gray-400); }

/* Name Cell */
.name-cell {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.docente-name {
    font-weight: 600;
    color: var(--gray-900);
    font-size: 0.95rem;
}

.docente-cargo {
    font-size: 0.8rem;
    color: var(--gray-500);
}

/* Program Badge */
.program-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.75rem;
    background: var(--primary-light);
    color: var(--primary-dark);
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 500;
}

.program-badge.general {
    background: var(--gray-100);
    color: var(--gray-600);
}

/* Documents */
.docs-container {
    display: flex;
    gap: 0.5rem;
}

.doc-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.65rem;
    border-radius: var(--radius-sm);
    font-size: 0.7rem;
    font-weight: 600;
    text-decoration: none;
    transition: all var(--transition);
}

.doc-chip.cv {
    background: var(--danger-light);
    color: #b91c1c;
}

.doc-chip.cv:hover {
    background: var(--danger);
    color: white;
}

.doc-chip.horario {
    background: var(--warning-light);
    color: #b45309;
}

.doc-chip.horario:hover {
    background: var(--warning);
    color: white;
}

.doc-chip.empty {
    background: var(--gray-100);
    color: var(--gray-400);
    cursor: default;
}

/* Order Badge */
.order-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: var(--gray-100);
    color: var(--gray-600);
    border-radius: var(--radius-sm);
    font-size: 0.85rem;
    font-weight: 600;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-badge.active {
    background: var(--success-light);
    color: #047857;
}

.status-badge.inactive {
    background: var(--gray-100);
    color: var(--gray-500);
}

/* Actions */
.actions-group {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: all var(--transition);
    text-decoration: none;
}

.action-btn.edit {
    background: var(--primary-light);
    color: var(--primary);
}

.action-btn.edit:hover {
    background: var(--primary);
    color: white;
}

.action-btn.delete {
    background: var(--danger-light);
    color: var(--danger);
}

.action-btn.delete:hover {
    background: var(--danger);
    color: white;
}

/* ============================================
   Cards View
   ============================================ */
.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

.docente-card {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    border: 1px solid var(--gray-100);
    transition: all var(--transition);
    animation: fadeIn 0.4s ease both;
    animation-delay: var(--delay);
}

.docente-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.docente-card.inactive {
    opacity: 0.7;
}

.docente-card .card-header {
    position: relative;
    height: 100px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding-bottom: 0;
}

.card-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid white;
    box-shadow: var(--shadow-lg);
    transform: translateY(40px);
    background: white;
}

.card-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-avatar .avatar-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gray-100);
    color: var(--gray-400);
    font-size: 2rem;
}

.card-status-dot {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}

.card-status-dot.active { background: var(--success); }
.card-status-dot.inactive { background: var(--gray-400); }

.docente-card .card-body {
    padding: 3rem 1.5rem 1.5rem;
    text-align: center;
}

.card-name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0 0 0.25rem;
}

.card-cargo {
    font-size: 0.85rem;
    color: var(--gray-500);
    margin: 0 0 0.75rem;
}

.card-program {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.75rem;
    background: var(--primary-light);
    color: var(--primary-dark);
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 500;
}

.card-program.general {
    background: var(--gray-100);
    color: var(--gray-600);
}

.card-docs {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    padding: 0 1.5rem 1rem;
}

.card-doc-btn {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-md);
    text-decoration: none;
    transition: all var(--transition);
}

.card-doc-btn.cv {
    background: var(--danger-light);
    color: #b91c1c;
}

.card-doc-btn.cv:hover {
    background: var(--danger);
    color: white;
}

.card-doc-btn.horario {
    background: var(--warning-light);
    color: #b45309;
}

.card-doc-btn.horario:hover {
    background: var(--warning);
    color: white;
}

.docente-card .card-footer {
    display: flex;
    border-top: 1px solid var(--gray-100);
}

.card-action {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    border: none;
    background: none;
    cursor: pointer;
    transition: all var(--transition);
}

.card-action.edit {
    color: var(--primary);
    border-right: 1px solid var(--gray-100);
}

.card-action.edit:hover {
    background: var(--primary-light);
}

.card-action.delete {
    color: var(--danger);
}

.card-action.delete:hover {
    background: var(--danger-light);
}

/* ============================================
   Empty State
   ============================================ */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: var(--gray-100);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.5rem;
    color: var(--gray-400);
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0 0 0.5rem;
}

.empty-state p {
    color: var(--gray-500);
    margin: 0 0 1.5rem;
}

/* No Results */
.no-results {
    text-align: center;
    padding: 3rem 2rem;
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
}

.no-results-icon {
    width: 80px;
    height: 80px;
    background: var(--gray-100);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2rem;
    color: var(--gray-400);
}

.no-results h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--gray-700);
    margin: 0 0 0.5rem;
}

.no-results p {
    font-size: 0.9rem;
    color: var(--gray-500);
    margin: 0 0 1.25rem;
}

/* ============================================
   Responsive
   ============================================ */
@media (max-width: 768px) {
    .docentes-page {
        padding: 1rem;
    }
    
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .header-actions {
        width: 100%;
    }
    
    .header-actions .btn-primary,
    .header-actions .btn-secondary {
        flex: 1;
        justify-content: center;
    }
    
    .filters-bar {
        flex-direction: column;
    }
    
    .search-box {
        max-width: 100%;
    }
    
    .filter-group {
        width: 100%;
    }
    
    .filter-select {
        flex: 1;
    }
    
    .data-table {
        font-size: 0.85rem;
    }
    
    .th-docs,
    .td-docs,
    .th-order,
    .td-order {
        display: none;
    }
}
</style>

<script>
// View Toggle
let isCardView = false;

function toggleView() {
    isCardView = !isCardView;
    const tableView = document.getElementById('tableView');
    const cardsView = document.getElementById('cardsView');
    const viewIcon = document.getElementById('viewIcon');
    const viewText = document.getElementById('viewText');
    
    if (isCardView) {
        tableView.style.display = 'none';
        cardsView.style.display = 'block';
        viewIcon.className = 'fas fa-list';
        viewText.textContent = 'Vista Tabla';
    } else {
        tableView.style.display = 'block';
        cardsView.style.display = 'none';
        viewIcon.className = 'fas fa-th-large';
        viewText.textContent = 'Vista Tarjetas';
    }
}

// Filter Function
function filterDocentes() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const programaFilter = document.getElementById('filterPrograma').value;
    const estadoFilter = document.getElementById('filterEstado').value;
    
    const rows = document.querySelectorAll('.docente-row');
    const cards = document.querySelectorAll('.docente-card');
    let visibleCount = 0;
    
    // Filter table rows
    rows.forEach(row => {
        const nombre = row.dataset.nombre;
        const cargo = row.dataset.cargo;
        const programa = row.dataset.programa;
        const activo = row.dataset.activo;
        
        const matchSearch = nombre.includes(searchTerm) || cargo.includes(searchTerm);
        const matchPrograma = !programaFilter || programa === programaFilter;
        const matchEstado = !estadoFilter || activo === estadoFilter;
        
        if (matchSearch && matchPrograma && matchEstado) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Filter cards
    cards.forEach(card => {
        const nombre = card.dataset.nombre;
        const cargo = card.dataset.cargo;
        const programa = card.dataset.programa;
        const activo = card.dataset.activo;
        
        const matchSearch = nombre.includes(searchTerm) || cargo.includes(searchTerm);
        const matchPrograma = !programaFilter || programa === programaFilter;
        const matchEstado = !estadoFilter || activo === estadoFilter;
        
        if (matchSearch && matchPrograma && matchEstado) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
    
    // Show/hide no results message
    const noResults = document.getElementById('noResults');
    const tableContainer = document.getElementById('tableView');
    const cardsContainer = document.getElementById('cardsView');
    
    if (visibleCount === 0) {
        noResults.style.display = 'block';
        tableContainer.style.display = 'none';
        cardsContainer.style.display = 'none';
    } else {
        noResults.style.display = 'none';
        if (isCardView) {
            cardsContainer.style.display = 'block';
        } else {
            tableContainer.style.display = 'block';
        }
    }
}

// Clear Filters
function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('filterPrograma').value = '';
    document.getElementById('filterEstado').value = '';
    filterDocentes();
}

// Delete Confirmation
function confirmDelete(id, nombre) {
    Swal.fire({
        title: '¿Eliminar docente?',
        html: `<p>Está a punto de eliminar a <strong>${nombre}</strong></p><p class="text-muted">Esta acción no se puede deshacer.</p>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash-alt"></i> Sí, eliminar',
        cancelButtonText: 'Cancelar',
        customClass: {
            popup: 'swal-modern'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= url('admin/plana-docente/eliminar/') ?>' + id;
        }
    });
}
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>