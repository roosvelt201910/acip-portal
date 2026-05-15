

<div class="header-container">
    <h2 class="page-title">Resultados: <?= e($proceso['titulo']) ?></h2>
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Dashboard</a> / 
        <a href="<?= url('admin/admision') ?>">Admisión</a> / 
        <span>Resultados</span>
    </div>
</div>

<div class="form-grid">
    <!-- Archivos de Resultados PDF -->
    <div class="card-enterprise mb-4" style="grid-column: span 2;">
        <div class="card-header-enterprise">
            <h3><i class="fas fa-file-pdf"></i> Archivos de Resultados (PDF)</h3>
        </div>
        <div class="card-body-enterprise">
            <div class="row">
                <div class="col-md-5">
                    <form action="<?= url('admin/admision/storeResultadoArchivo/' . $proceso['id']) ?>" method="POST" enctype="multipart/form-data" id="uploadForm">
                        <div class="form-group-enterprise">
                            <label class="font-weight-bold text-dark text-uppercase small" style="letter-spacing: 0.5px;"><i class="fas fa-heading mr-1 text-primary"></i> Título del Documento</label>
                            <input type="text" name="titulo" class="input-enterprise" required placeholder="Ej: Resultados Examen Ordinario 2026-I">
                        </div>
                        
                        <div class="form-group-enterprise">
                            <label class="font-weight-bold text-dark text-uppercase small" style="letter-spacing: 0.5px;"><i class="fas fa-graduation-cap mr-1 text-primary"></i> Programa de Estudio (Opcional)</label>
                            <select name="programa_id" class="select-enterprise">
                                <option value="">-- General / Todos --</option>
                                <?php foreach ($programas as $prog): ?>
                                    <option value="<?= $prog['id'] ?>"><?= e($prog['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Drag & Drop Zone -->
                        <div class="form-group-enterprise">
                            <label class="font-weight-bold text-dark mb-2 text-uppercase small" style="letter-spacing: 0.5px;"><i class="fas fa-file-pdf mr-1 text-danger"></i> Archivo PDF</label>
                            <div class="upload-zone" id="uploadZone">
                                <input type="file" name="archivo" id="fileInput" accept="application/pdf" required hidden>
                                <div class="upload-content text-center py-5">
                                    <div class="icon-pulse mb-3">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-primary"></i>
                                    </div>
                                    <h6 class="font-weight-bold mb-1 text-dark">Arrastra tu PDF aquí</h6>
                                    <p class="text-muted small mb-0">o haz clic para buscar en tu equipo</p>
                                </div>
                                <div id="filePreviewContainer" class="mt-3 p-0 bg-white rounded border overflow-hidden position-relative" style="display: none;">
                                    <div class="p-2 bg-light border-bottom d-flex justify-content-between align-items-center">
                                        <small class="font-weight-bold text-truncate" id="fileName" style="max-width: 200px;"></small>
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0" id="clearFile" title="Quitar archivo">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <embed id="pdfEmbed" src="" type="application/pdf" width="100%" height="200px">
                                </div>
                            </div>
                        </div>

                        <div class="form-group-enterprise">
                            <label class="font-weight-bold text-dark text-uppercase small" style="letter-spacing: 0.5px;"><i class="fas fa-sort-numeric-down mr-1 text-primary"></i> Orden</label>
                            <input type="number" name="orden" class="input-enterprise" value="0">
                        </div>

                        <button type="submit" class="btn-enterprise btn-primary-enterprise w-100 py-3 shadow-sm font-weight-bold text-uppercase" style="letter-spacing: 1px;">
                            <i class="fas fa-save mr-2"></i> Publicar Resultado
                        </button>
                    </form>
                </div>
                
                <div class="col-md-7">
                    <h5 class="mb-3 font-weight-bold text-dark text-uppercase small border-bottom pb-2">
                        <i class="fas fa-list-alt mr-2 text-primary"></i> Archivos Publicados
                    </h5>

                    <?php
                    // Group files by Program
                    $groupedFiles = ['General' => []];
                    // Initialize groups for all active programs to ensure they appear even if empty (optional, but requested tabs often implies showing available sections)
                    // Actually, let's only show tabs for programs that have files + General, plus maybe a specialized 'All' tab?
                    // User Request "group them in TABS" typically means separating content.
                    
                    foreach ($archivos as $file) {
                        $key = !empty($file['programa_nombre']) ? $file['programa_nombre'] : 'General';
                        if (!isset($groupedFiles[$key])) {
                            $groupedFiles[$key] = [];
                        }
                        $groupedFiles[$key][] = $file;
                    }
                    
                    // If General is empty but others exist, maybe we can keep it or move it to end.
                    // Let's iterate valid groups.
                    ?>

                    <div class="card-body-enterprise p-0">
                        <!-- Custom Tabs Header -->
                        <div class="enterprise-tabs-header">
                            <?php $isFirst = true; ?>
                            <?php foreach ($groupedFiles as $groupName => $files): ?>
                                <?php if (empty($files) && $groupName !== 'General') continue; ?>
                                <button class="enterprise-tab-btn <?= $isFirst ? 'active' : '' ?>" onclick="switchTab(this, 'content-<?= md5($groupName) ?>')">
                                    <?= $groupName ?> 
                                    <span class="badge-enterprise badge-gray ml-2" style="font-size: 0.7em;"><?= count($files) ?></span>
                                </button>
                                <?php $isFirst = false; ?>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Tabs Content -->
                        <div class="enterprise-tabs-content">
                            <?php $isFirst = true; ?>
                            <?php foreach ($groupedFiles as $groupName => $files): ?>
                                <?php if (empty($files) && $groupName !== 'General') continue; ?>
                                <div id="content-<?= md5($groupName) ?>" class="enterprise-tab-pane <?= $isFirst ? 'active' : '' ?>">
                                    
                                    <div class="table-responsive">
                                        <table class="table-enterprise mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="text-center" width="50">#</th>
                                                    <th>Documento</th>
                                                    <th class="text-center" width="120">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($files as $arch): ?>
                                                <tr>
                                                    <td class="text-center font-weight-bold text-muted" style="vertical-align: middle;"><?= $arch['orden'] ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <!-- macOS Style Icon -->
                                                            <a href="<?= url($arch['archivo_url']) ?>" target="_blank" class="macos-icon mr-3" title="Ver PDF">
                                                                <div class="macos-icon-content">
                                                                    <i class="fas fa-file-pdf text-danger"></i>
                                                                    <div class="macos-icon-text">PDF</div>
                                                                </div>
                                                            </a>
                                                            
                                                            <div>
                                                                <h6 class="mb-0 font-weight-bold text-dark text-truncate" style="max-width: 300px;"><?= e($arch['titulo']) ?></h6>
                                                                <small class="text-muted"><i class="fas fa-clock mr-1"></i> <?= date('d/m/Y H:i', strtotime($arch['created_at'])) ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center" style="vertical-align: middle;">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn-icon-enterprise text-primary" onclick="previewPdf('<?= url($arch['archivo_url']) ?>', '<?= e($arch['titulo']) ?>')" title="Vista Previa">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <a href="<?= url('admin/admision/deleteResultadoArchivo/' . $arch['id']) ?>" class="btn-icon-enterprise text-danger ml-2" onclick="return confirm('¿Eliminar este archivo?')" title="Eliminar">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                                <?php if(empty($files)): ?>
                                                    <tr>
                                                        <td colspan="3" class="text-center py-5">
                                                            <div class="opacity-50">
                                                                <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                                                                <p class="text-muted mb-0">No hay archivos en esta sección.</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <?php $isFirst = false; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Preview Modal -->
    <div id="pdfModal" class="modal-overlay" style="display: none;">
        <div class="modal-container">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Vista Previa</h5>
                <button type="button" class="close-btn" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body p-0" style="height: 80vh;">
                <iframe id="modalPdfFrame" src="" width="100%" height="100%" style="border: none;"></iframe>
            </div>
        </div>
    </div>

    <style>
    /* macOS Icon Style */
    .macos-icon {
        width: 48px;
        height: 64px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-decoration: none !important;
        position: relative;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .macos-icon:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
    }
    /* Simple corner fold effect with gradient */
    .macos-icon::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        border-width: 0 12px 12px 0;
        border-style: solid;
        border-color: #f1f5f9 #fff;
        background: #e2e8f0; /* Darker shade for the back of the fold */
        display: block;
        width: 0;
        box-shadow: -1px 1px 1px rgba(0,0,0,0.1);
        border-bottom-left-radius: 4px;
    }
    
    .macos-icon-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-top: 8px; /* Offset for visual balance */
    }
    .macos-icon-content i {
        font-size: 24px;
        margin-bottom: 2px;
    }
    .macos-icon-text {
        font-size: 8px;
        font-weight: 800;
        color: #ef4444; /* Red for PDF */
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Styling Enhancements */
    .bg-danger-soft { background-color: rgba(220, 38, 38, 0.1); }
    .text-gray-300 { color: #d1d5db; }
    
    .upload-zone {
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        background-color: #f8fafc;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }
    .upload-zone:hover {
        border-color: var(--primary-color);
        background-color: #eff6ff;
    }
    .upload-zone.dragover {
        border-color: var(--primary-color);
        background-color: #dbeafe;
        transform: scale(1.01);
    }
    
    .icon-shape {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1050;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(2px);
    }
    
    /* Custom Tabs Styles */
    .enterprise-tabs-header {
        display: flex;
        overflow-x: auto;
        border-bottom: 2px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 8px 8px 0 0;
        padding: 0;
    }
    
    .enterprise-tab-btn {
        padding: 1rem 1.5rem;
        background: none;
        border: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
        font-size: 0.9rem;
    }
    .enterprise-tab-btn:hover {
        color: var(--primary-color);
        background-color: #f1f5f9;
    }
    .enterprise-tab-btn.active {
        color: var(--primary-color);
        border-bottom-color: var(--primary-color);
        background-color: white;
    }
    
    .enterprise-tabs-content {
        background: white;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
        border-top: none;
        border-radius: 0 0 8px 8px;
    }
    
    .enterprise-tab-pane {
        display: none;
        animation: fadeIn 0.3s ease;
    }
    .enterprise-tab-pane.active {
        display: block;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .modal-container {
        background: white;
        width: 90%;
        max-width: 1000px;
        border-radius: 8px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        animation: modalFadeIn 0.3s ease-out;
    }
    .modal-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f9fafb;
    }
    .modal-title { font-weight: 600; font-size: 1.1rem; color: #111827; margin: 0; }
    .close-btn {
        background: none;
        border: none;
        font-size: 1.25rem;
        color: #6b7280;
        cursor: pointer;
        padding: 0;
        transition: color 0.2s;
    }
    .close-btn:hover { color: #111827; }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    </style>

    <script>
    // Tab Switching Logic
    function switchTab(btn, targetId) {
        // Remove active class from all buttons
        document.querySelectorAll('.enterprise-tab-btn').forEach(b => b.classList.remove('active'));
        // Add active class to clicked button
        btn.classList.add('active');
        
        // Hide all tab panes
        document.querySelectorAll('.enterprise-tab-pane').forEach(p => p.classList.remove('active'));
        // Show target pane
        document.getElementById(targetId).classList.add('active');
    }

    // Preview Modal Logic
    function previewPdf(url, title) {
        document.getElementById('modalPdfFrame').src = url;
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('pdfModal').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('pdfModal').style.display = 'none';
        document.getElementById('modalPdfFrame').src = '';
    }
    
    // Close on click outside
    document.getElementById('pdfModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    // Upload Logic with Preview
    document.addEventListener('DOMContentLoaded', function() {
        const uploadZone = document.getElementById('uploadZone');
        const fileInput = document.getElementById('fileInput');
        
        // Elements for preview
        const filePreviewContainer = document.getElementById('filePreviewContainer');
        const pdfEmbed = document.getElementById('pdfEmbed');
        const fileName = document.getElementById('fileName');
        const clearFileBtn = document.getElementById('clearFile');
        const uploadContent = uploadZone.querySelector('.upload-content');

        // Click to browse (unless clicking clear button)
        uploadZone.addEventListener('click', (e) => {
            if (!e.target.closest('#clearFile') && !e.target.closest('#filePreviewContainer')) {
                 fileInput.click();
            }
        });

        // Update file info on change
        fileInput.addEventListener('change', handleFileSelect);
        
        // Clear file
        clearFileBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // Stop bubble
            fileInput.value = '';
            filePreviewContainer.style.display = 'none';
            uploadContent.style.display = 'block';
            pdfEmbed.src = '';
        });

        // Drag & Drop events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) { e.preventDefault(); e.stopPropagation(); }

        ['dragenter', 'dragover'].forEach(eventName => uploadZone.classList.add('dragover'));
        ['dragleave', 'drop'].forEach(eventName => uploadZone.classList.remove('dragover'));

        uploadZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            handleFileSelect();
        }

        function handleFileSelect() {
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                if (file.type === 'application/pdf') {
                    // Show filename
                    fileName.textContent = file.name;
                    
                    // Create object URL for preview
                    const objectUrl = URL.createObjectURL(file);
                    pdfEmbed.src = objectUrl;
                    
                    // Show preview container, hide default content
                    uploadContent.style.display = 'none';
                    filePreviewContainer.style.display = 'block';
                } else {
                    alert('Por favor, sube solo archivos PDF.');
                    fileInput.value = '';
                }
            }
        }
    });
    </script>
        </div>
    </div>

    <!-- Section Removed per user request -->
    <!--
    Individual Results Registration Form and List Hiden
    
    The user is migrating to a PDF-based workflow, so this section is hidden to avoid confusion.
    If database-stored individual results are needed again, uncomment this block.
    -->
</div>

<style>
/* Enterprise Design System */
:root {
    --primary-color: #2563eb;
    --primary-hover: #1d4ed8;
    --text-dark: #1e293b;
    --text-muted: #64748b;
    --border-color: #e2e8f0;
    --bg-light: #f8fafc;
}

.header-container {
    margin-bottom: 2rem;
}
.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}
.breadcrumb {
    font-size: 0.9rem;
    color: var(--text-muted);
    background: transparent;
    padding: 0;
}
.breadcrumb a {
    color: var(--primary-color);
    text-decoration: none;
}

.form-grid {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 2rem;
    align-items: start;
}

.card-enterprise {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}
.card-enterprise:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
}

.card-header-enterprise {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    background: white;
}
.card-header-enterprise h3 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.card-header-enterprise h3 i {
    color: var(--primary-color);
}

.card-body-enterprise {
    padding: 1.5rem;
}
.card-body-enterprise.p-0 {
    padding: 0;
}

.form-group-enterprise {
    margin-bottom: 1.25rem;
}
.form-group-enterprise label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-dark);
    font-size: 0.95rem;
}

.input-enterprise, .select-enterprise {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.95rem;
    color: var(--text-dark);
    background-color: #fff;
    transition: all 0.2s;
}
.input-enterprise:focus, .select-enterprise:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}
textarea.input-enterprise {
    resize: vertical;
    min-height: 100px;
}

.btn-enterprise {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    gap: 0.5rem;
}
.btn-primary-enterprise {
    background-color: var(--primary-color);
    color: white;
}
.btn-primary-enterprise:hover {
    background-color: var(--primary-hover);
    transform: translateY(-1px);
}
.w-100 { width: 100%; }

/* Table Styles */
.table-responsive {
    overflow-x: auto;
}
.table-enterprise {
    width: 100%;
    border-collapse: collapse;
}
.table-enterprise th {
    background-color: var(--bg-light);
    color: var(--text-muted);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    padding: 1rem 1.5rem;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
}
.table-enterprise td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-dark);
    vertical-align: middle;
}
.table-enterprise tr:last-child td {
    border-bottom: none;
}
.table-enterprise tr:hover td {
    background-color: #f8fafc;
}

.badge-enterprise {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}
.badge-gray {
    background-color: #f1f5f9;
    color: #475569;
}
.badge-green {
    background-color: #dcfce7;
    color: #166534;
}
.badge-red {
    background-color: #fee2e2;
    color: #991b1b;
}

.btn-icon-enterprise {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: all 0.2s;
    color: var(--text-muted);
}
.btn-icon-enterprise:hover {
    background-color: #f1f5f9;
    color: var(--text-dark);
}
.btn-delete:hover {
    background-color: #fee2e2;
    color: #ef4444;
}

@media (max-width: 992px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    .card-enterprise[style*="span 2"] {
        grid-column: span 1 !important;
    }
}
</style>

