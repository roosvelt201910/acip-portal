<?php ob_start(); ?>

<style>
    /* Tabs Styling */
    .tabs-container {
        margin-bottom: 2rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .tabs-nav {
        display: flex;
        gap: 1.5rem;
        overflow-x: auto;
        padding-bottom: 2px; /* For active border overlap */
    }
    
    .tab-btn {
        background: none;
        border: none;
        padding: 0.75rem 0.5rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: #64748b;
        cursor: pointer;
        position: relative;
        transition: all 0.2s;
        white-space: nowrap;
    }
    
    .tab-btn:hover {
        color: #4f46e5;
    }
    
    .tab-btn.active {
        color: #4f46e5;
        font-weight: 600;
    }
    
    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -3px; /* Align with border-bottom */
        left: 0;
        right: 0;
        height: 2px;
        background: #4f46e5;
        border-radius: 2px 2px 0 0;
    }
    
    .tab-content {
        display: none;
        animation: fadeIn 0.3s ease;
    }
    
    .tab-content.active {
        display: block;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .badge-gray { background: #f1f5f9; color: #475569; }
    .badge-primary { background: #eef2ff; color: #4f46e5; }
    .badge-success { background: #f0fdf4; color: #16a34a; }
    .badge-purple { background: #faf5ff; color: #9333ea; }
    .badge-warning { background: #fffbeb; color: #d97706; }
</style>

<div class="header-container">
    <h2 class="page-title">Administrar Documentos</h2>
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Dashboard</a> / 
        <span>Documentos</span>
    </div>
</div>

<div class="actions-bar-enterprise">
    <a href="<?= url('admin/documentos/crear') ?>" class="btn-enterprise">
        <i class="fas fa-plus"></i> Nuevo Documento
    </a>
</div>

<!-- Tabs Navigation -->
<div class="tabs-container">
    <div class="tabs-nav">
        <button class="tab-btn active" onclick="switchTab('all')">Todas</button>
        <?php if (!empty($categorias)): ?>
            <?php foreach ($categorias as $cat): ?>
                <button class="tab-btn" onclick="switchTab('cat-<?= $cat['id'] ?>')">
                    <?= e($cat['nombre']) ?>
                </button>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Tab Content: ALL -->
<div id="tab-all" class="tab-content active">
    <div class="card-enterprise">
        <div class="table-responsive">
            <?php renderDocumentTable($documentos); ?>
        </div>
    </div>
</div>

<!-- Tab Content: Dynamic Categories -->
<?php if (!empty($categorias)): ?>
    <?php foreach ($categorias as $cat): ?>
        <div id="tab-cat-<?= $cat['id'] ?>" class="tab-content">
            <div class="card-enterprise">
                <div class="table-responsive">
                    <?php 
                    // Filter documents for this category
                    $catDocs = array_filter($documentos, function($doc) use ($cat) {
                        return trim($doc['categoria']) === trim($cat['nombre']);
                    });
                    renderDocumentTable($catDocs); 
                    ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php
// Helper function to render table (DRY)
function renderDocumentTable($docs) {
    ?>
    <table class="table-enterprise">
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoría</th>
                <th>Tipo</th>
                <th>Archivo</th>
                <th>Tamaño</th>
                <th style="text-align: right;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($docs)): ?>
                <?php foreach ($docs as $item): ?>
                <tr>
                    <td style="font-weight: 500; color: var(--text-dark);"><?= e($item['titulo']) ?></td>
                    <td><span class="badge-enterprise badge-gray"><?= e($item['categoria']) ?></span></td>
                    <td>
                        <?php
                        $badgeClass = 'badge-primary';
                        if ($item['tipo_documento'] === 'resolucion') $badgeClass = 'badge-success';
                        if ($item['tipo_documento'] === 'directiva') $badgeClass = 'badge-purple';
                        if ($item['tipo_documento'] === 'informe') $badgeClass = 'badge-warning';
                        ?>
                        <span class="badge-enterprise <?= $badgeClass ?>"><?= ucfirst($item['tipo_documento']) ?></span>
                    </td>
                    <td>
                        <a href="<?= url('uploads/documentos/' . e($item['archivo'])) ?>" target="_blank" class="document-link" style="color: var(--primary); text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                            <?php
                            $icon = 'fa-file';
                            if ($item['extension'] === 'pdf') $icon = 'fa-file-pdf';
                            if (in_array($item['extension'], ['doc', 'docx'])) $icon = 'fa-file-word';
                            if (in_array($item['extension'], ['xls', 'xlsx'])) $icon = 'fa-file-excel';
                            ?>
                            <i class="fas <?= $icon ?>"></i> Ver Archivo
                        </a>
                    </td>
                    <td style="color: var(--text-light); font-size: 0.9rem;"><?= formatFileSize($item['tamanio']) ?></td>
                    <td class="actions-cell">
                        <button onclick="confirmDelete(<?= $item['id'] ?>)" class="btn-icon-enterprise delete" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-light);">No hay documentos registrados en esta categoría.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php
}
?>

<!-- SweetAlert2 for Delete Confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= url('admin/documentos/eliminar/') ?>" + id;
            }
        })
    }

    function switchTab(tabId) {
        // Toggle Buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.currentTarget.classList.add('active');

        // Toggle Content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });
        document.getElementById('tab-' + tabId).classList.add('active');
    }
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
