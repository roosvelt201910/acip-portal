
<div class="header-container">
    <h2 class="page-title">Documentos: <?= e($proceso['titulo']) ?></h2>
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Dashboard</a> / 
        <a href="<?= url('admin/admision') ?>">Admisión</a> / 
        <span>Documentos</span>
    </div>
</div>

<div class="row">
    <!-- Formulario (Full Width) -->
    <div class="col-12 mb-4">
        <div class="card-enterprise">
            <div class="card-header-enterprise">
                <h3><i class="fas fa-file-upload"></i> Subir Documento</h3>
            </div>
            <div class="card-body-enterprise">
                <form action="<?= url('admin/admision/storeDocumento/' . $proceso['id']) ?>" method="POST" enctype="multipart/form-data" id="uploadForm">
                    
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group-enterprise">
                                <label>Título del Documento</label>
                                <input type="text" name="titulo" class="input-enterprise" required placeholder="Ej: Prospecto de Admisión">
                            </div>
                            <div class="form-group-enterprise">
                                <label>Orden</label>
                                <input type="number" name="orden" value="0" class="input-enterprise">
                            </div>
                        </div>
                        <div class="col-md-7">
                             <div class="form-group-enterprise h-100">
                                <label>Archivo (PDF)</label>
                                <div class="drag-drop-zone" id="dropZone">
                                    <input type="file" name="archivo" class="file-input-hidden" accept=".pdf" required id="fileInput">
                                    
                                    <div class="drop-content" id="dropContent">
                                        <div class="upload-icon-wrapper mb-3">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-primary"></i>
                                        </div>
                                        <p class="mb-1 font-weight-bold">Arrastra y suelta tu archivo aquí</p>
                                        <p class="text-muted small mb-3">o haz clic para explorar</p>
                                        <span class="badge badge-gray">Solo archivos PDF</span>
                                    </div>
                                    
                                    <!-- Preview (Hidden by default) -->
                                    <div class="file-preview" id="filePreview" style="display: none;">
                                        <div class="macos-file-item preview-item">
                                            <div class="macos-icon-sm">
                                                <div class="macos-icon-corner"></div>
                                                <div class="macos-icon-type">PDF</div>
                                                <i class="fas fa-file-pdf text-danger"></i>
                                            </div>
                                            <div class="macos-file-info">
                                                <span class="macos-file-title" id="previewFileName">filename.pdf</span>
                                                <span class="macos-file-action" id="previewFileSize">0 KB</span>
                                            </div>
                                            <button type="button" class="remove-file-btn" id="removeFileBtn" title="Quitar archivo">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-enterprise w-100 mb-0 mt-3 border-top pt-3">
                        <button type="submit" class="btn-enterprise btn-primary-enterprise w-100">
                            <i class="fas fa-upload"></i> Subir Documento
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Lista de Documentos -->
    <div class="col-12">
        <div class="card-enterprise">
            <div class="card-header-enterprise">
                <h3><i class="fas fa-folder-open"></i> Documentos Publicados</h3>
            </div>
            <div class="card-body-enterprise p-0">
                <div class="table-responsive">
                    <table class="table-enterprise">
                        <thead>
                            <tr>
                                <th width="80" class="text-center">Orden</th>
                                <th>Vista Previa / Documento</th>
                                <th>Fecha Subida</th>
                                <th width="100" class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($documentos as $doc): ?>
                            <tr>
                                <td class="text-center"><span class="badge-enterprise badge-gray"><?= $doc['orden'] ?></span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <!-- MacOS Style Icon -->
                                        <a href="<?= url($doc['archivo_url']) ?>" target="_blank" class="macos-file-item-sm mr-3" title="Ver Documento">
                                            <div class="macos-icon-xs">
                                                <div class="macos-icon-corner"></div>
                                                <div class="macos-icon-type">PDF</div>
                                                <i class="fas fa-file-pdf text-danger"></i>
                                            </div>
                                        </a>
                                        
                                        <div>
                                            <div class="font-weight-bold text-dark"><?= e($doc['titulo']) ?></div>
                                            <a href="<?= url($doc['archivo_url']) ?>" target="_blank" class="small text-primary hover-underline">
                                                <i class="fas fa-external-link-alt"></i> Abrir en nueva pestaña
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted small">
                                    <i class="far fa-clock mr-1"></i> <?= date('d/m/Y H:i', strtotime($doc['created_at'])) ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= url('admin/admision/deleteDocumento/' . $doc['id']) ?>" class="btn-icon-enterprise btn-delete" onclick="return confirm('¿Eliminar este documento?')" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                            <?php if (empty($documentos)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <div class="empty-state">
                                            <div class="empty-icon-bg">
                                                <i class="fas fa-file-upload fa-2x text-muted"></i>
                                            </div>
                                            <p class="mt-3 mb-0">No hay documentos publicados.</p>
                                            <small>Usa el formulario de arriba para agregar uno.</small>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Base Colors */
:root {
    --primary-color: #2563eb;
    --primary-hover: #1d4ed8;
    --primary-light: #eff6ff;
    --text-dark: #1e293b;
    --text-muted: #64748b;
    --border-color: #e2e8f0;
    --bg-light: #f8fafc;
}

/* Layout & Typography */
.header-container { margin-bottom: 2rem; }
.page-title { font-size: 1.5rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem; }
.breadcrumb { font-size: 0.9rem; color: var(--text-muted); padding: 0; }
.breadcrumb a { color: var(--primary-color); text-decoration: none; }

.row { display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px; }
.col-12 { flex: 0 0 100%; max-width: 100%; padding: 0 15px; }
.col-md-5 { flex: 0 0 41.666667%; max-width: 41.666667%; padding: 0 15px; }
.col-md-7 { flex: 0 0 58.333333%; max-width: 58.333333%; padding: 0 15px; }

.mb-4 { margin-bottom: 1.5rem; }
.mb-3 { margin-bottom: 1rem; }
.mt-3 { margin-top: 1rem; }
.mb-0 { margin-bottom: 0 !important; }
.mr-3 { margin-right: 1rem; }
.mr-1 { margin-right: 0.25rem; }
.w-100 { width: 100%; }
.h-100 { height: 100%; }
.d-flex { display: flex !important; }
.align-items-center { align-items: center !important; }
.pt-3 { padding-top: 1rem; }
.border-top { border-top: 1px solid var(--border-color); }
.text-center { text-align: center; }
.font-weight-bold { font-weight: 600; }
.small { font-size: 0.875rem; }

/* Drag & Drop Zone */
.drag-drop-zone {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    background-color: #f8fafc;
    position: relative;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    cursor: pointer;
    overflow: hidden;
}
.drag-drop-zone:hover, .drag-drop-zone.dragover {
    border-color: var(--primary-color);
    background-color: var(--primary-light);
}
.drag-drop-zone.has-file {
    border-style: solid;
    border-color: var(--border-color);
    background-color: white;
}
.file-input-hidden {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 10;
}
.drop-content {
    text-align: center;
    pointer-events: none;
    padding: 2rem;
}
.upload-icon-wrapper {
    width: 64px; height: 64px;
    background: white;
    border-radius: 50%;
    display: inline-flex;
    align-items: center; justify-content: center;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    margin-bottom: 1rem;
}

/* MacOS File Icon Style (Large for Preview) */
.macos-file-item {
    display: flex; align-items: center;
    background: white; padding: 12px;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    border: 1px solid var(--border-color);
    min-width: 250px;
    max-width: 100%;
}
.remove-file-btn {
    width: 28px; height: 28px;
    border-radius: 50%; border: none;
    background: #fee2e2; color: #ef4444;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; margin-left: 10px;
    z-index: 20; position: relative;
    transition: all 0.2s;
}
.remove-file-btn:hover { background: #fecaca; transform: scale(1.1); }

.macos-icon-sm {
    width: 48px; height: 60px;
    background: white; border: 1px solid #cbd5e1;
    border-radius: 6px; position: relative;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    margin-right: 15px; flex-shrink: 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
.macos-icon-corner {
    position: absolute; top: 0; right: 0;
    border-width: 0 12px 12px 0;
    border-style: solid;
    border-color: #f1f5f9 #fff;
    background: #cbd5e1;
    display: block; width: 0;
    border-bottom-left-radius: 3px;
}
.macos-icon-type {
    font-size: 8px; font-weight: 800; color: #ef4444; margin-bottom: 4px;
}
.macos-icon-sm .fa-file-pdf { font-size: 24px; color: #ef4444; }

.macos-file-info {
    flex: 1; display: flex; flex-direction: column; overflow: hidden;
}
.macos-file-title {
    font-weight: 600; font-size: 0.95rem; color: var(--text-dark);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.macos-file-action {
    font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;
}

/* MacOS File Icon Style (Small for Table) */
.macos-file-item-sm {
    display: inline-block;
    transition: transform 0.2s;
}
.macos-file-item-sm:hover { transform: translateY(-2px); }
.macos-icon-xs {
    width: 32px; height: 40px;
    background: white; border: 1px solid #cbd5e1;
    border-radius: 4px; position: relative;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}
.macos-icon-xs .macos-icon-corner { border-width: 0 8px 8px 0; }
.macos-icon-xs .macos-icon-type { font-size: 5px; margin-bottom: 2px; }
.macos-icon-xs .fa-file-pdf { font-size: 16px; color: #ef4444; }

/* Card & Table Styles */
.card-enterprise {
    background: white; border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--border-color); overflow: hidden;
}
.card-header-enterprise { padding: 1.5rem; border-bottom: 1px solid var(--border-color); background: white; }
.card-body-enterprise { padding: 1.5rem; }
.card-body-enterprise.p-0 { padding: 0; }
.form-group-enterprise { margin-bottom: 1.25rem; }
.form-group-enterprise label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-dark); }
.input-enterprise { width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color); border-radius: 8px; }

.btn-enterprise {
    display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem 1.5rem;
    border-radius: 8px; font-weight: 600; cursor: pointer; border: none; gap: 0.5rem; transition: all 0.2s;
}
.btn-primary-enterprise { background-color: var(--primary-color); color: white; }
.btn-primary-enterprise:hover { background-color: var(--primary-hover); transform: translateY(-1px); }

.table-responsive { overflow-x: auto; }
.table-enterprise { width: 100%; border-collapse: collapse; }
.table-enterprise th {
    background-color: var(--bg-light); color: var(--text-muted); font-weight: 600; text-transform: uppercase;
    font-size: 0.75rem; padding: 1rem 1.5rem; text-align: left; border-bottom: 1px solid var(--border-color);
}
.table-enterprise td { padding: 1rem 1.5rem; border-bottom: 1px solid var(--border-color); vertical-align: middle; }
.hover-underline:hover { text-decoration: underline; }

.badge-enterprise { padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600; background: #f1f5f9; color: #475569; }
.btn-icon-enterprise {
    width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;
    border-radius: 6px; color: var(--text-muted); background: transparent; transition: all 0.2s;
}
.btn-icon-enterprise:hover { background-color: #f1f5f9; color: var(--text-dark); }
.btn-delete:hover { background-color: #fee2e2; color: #ef4444; }

.empty-state { padding: 2rem; display: flex; flex-direction: column; align-items: center; justify-content: center; }
.empty-icon-bg { width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const dropContent = document.getElementById('dropContent');
    const filePreview = document.getElementById('filePreview');
    const previewFileName = document.getElementById('previewFileName');
    const previewFileSize = document.getElementById('previewFileSize');
    const removeFileBtn = document.getElementById('removeFileBtn');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight drop zone
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('dragover');
    }
    function unhighlight(e) {
        dropZone.classList.remove('dragover');
    }

    // Handle Drop
    dropZone.addEventListener('drop', handleDrop, false);
    fileInput.addEventListener('change', handleFiles, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files; // Assign dropped files to input
        handleFiles();
    }

    function handleFiles() {
        const files = fileInput.files;
        if (files.length > 0) {
            const file = files[0];
            
            // Validate PDF
            if (file.type !== 'application/pdf') {
                alert('Por favor, selecciona solo archivos PDF.');
                resetFile();
                return;
            }

            // Update UI
            previewFileName.textContent = file.name;
            previewFileSize.textContent = formatBytes(file.size);
            
            dropContent.style.display = 'none';
            filePreview.style.display = 'flex';
            dropZone.classList.add('has-file');
        }
    }

    // Remove File
    removeFileBtn.addEventListener('click', function(e) {
        e.stopPropagation(); // Prevent opening file dialog
        resetFile();
    });

    function resetFile() {
        fileInput.value = '';
        dropContent.style.display = 'block';
        filePreview.style.display = 'none';
        dropZone.classList.remove('has-file');
    }

    function formatBytes(bytes, decimals = 2) {
        if (!+bytes) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
    }
});
</script>
