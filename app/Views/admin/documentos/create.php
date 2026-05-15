<?php ob_start(); ?>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
        --glass-bg: rgba(255, 255, 255, 0.95);
        --glass-border: 1px solid rgba(226, 232, 240, 0.8);
        --glass-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        --input-focus-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
    }

    .page-header {
        margin-bottom: 2rem;
        animation: fadeInDown 0.5s ease-out;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
        letter-spacing: -0.025em;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748b;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .breadcrumb a {
        color: #64748b;
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb a:hover {
        color: #4f46e5;
    }

    .card-modern {
        background: var(--glass-bg);
        border: var(--glass-border);
        box-shadow: var(--glass-shadow);
        border-radius: 1rem;
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out;
        position: relative;
    }

    /* Decorative top accent */
    .card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
    }

    .card-body {
        padding: 2.5rem;
    }

    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-section-title i {
        color: #4f46e5;
        background: #eef2ff;
        padding: 0.5rem;
        border-radius: 0.5rem;
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 1.75rem;
        position: relative;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
        transition: all 0.2s;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        color: #1e293b;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        transition: all 0.25s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: var(--input-focus-shadow);
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    select.form-control {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        appearance: none;
    }

    /* File Upload Styling */
    .file-upload-wrapper {
        margin-top: 0.5rem;
    }

    .drop-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 1rem;
        padding: 3rem 2rem;
        text-align: center;
        background: #f8fafc;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .drop-zone:hover, .drop-zone.dragover {
        border-color: #4f46e5;
        background: #eef2ff;
        transform: translateY(-2px);
    }

    .drop-zone-content {
        pointer-events: none;
    }

    .drop-zone-icon {
        font-size: 3rem;
        color: #94a3b8;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .drop-zone:hover .drop-zone-icon {
        color: #4f46e5;
        transform: scale(1.1);
    }

    .drop-zone-text {
        color: #64748b;
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .drop-zone-hint {
        color: #94a3b8;
        font-size: 0.85rem;
    }

    #fileInput {
        display: none;
    }

    /* File Preview Card */
    .file-preview {
        display: none;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-top: 1rem;
        align-items: center;
        gap: 1rem;
        animation: fadeIn 0.3s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .file-icon-wrapper {
        width: 48px;
        height: 48px;
        background: #eef2ff;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4f46e5;
        font-size: 1.5rem;
    }

    .file-info {
        flex: 1;
        overflow: hidden;
    }

    .file-name {
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
    }

    .file-size {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 0.25rem;
        display: block;
    }

    .btn-remove-file {
        color: #ef4444;
        background: #fef2f2;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-remove-file:hover {
        background: #fee2e2;
        transform: rotate(90deg);
    }

    /* Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 1px solid #f1f5f9;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.95rem;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-cancel {
        background: white;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .btn-cancel:hover {
        background: #f8fafc;
        color: #475569;
        border-color: #cbd5e1;
    }

    .btn-submit {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
    }

    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 8px -1px rgba(79, 70, 229, 0.25);
    }
    
    .btn-icon {
        padding: 0.75rem;
        border-right: 50%;
    }
    
    .input-group {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-manage {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1rem;
    }
    
    .btn-manage:hover {
        background: #e2e8f0;
        color: #334155;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        backdrop-filter: blur(4px);
    }
    
    .modal-content {
        background: white;
        border-radius: 1rem;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        animation: fadeInDown 0.3s ease-out;
    }
    
    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
    }
    
    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #94a3b8;
        cursor: pointer;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .cat-list {
        max-height: 300px;
        overflow-y: auto;
        margin-top: 1rem;
    }
    
    .cat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .cat-item:last-child {
        border-bottom: none;
    }
    
    .cat-name {
        font-weight: 500;
        color: #334155;
    }
    
    .btn-delete-cat {
        color: #ef4444;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 0.25rem;
    }
    
    .btn-delete-cat:hover {
        background: #fef2f2;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>

<div class="page-container">
    <div class="header-container page-header">
        <h2 class="page-title">Nuevo Documento</h2>
        <div class="breadcrumb">
            <a href="<?= url('admin/dashboard') ?>"><i class="fas fa-home"></i></a>
            <i class="fas fa-chevron-right" style="font-size: 0.7em;"></i>
            <a href="<?= url('admin/documentos') ?>">Documentos</a>
            <i class="fas fa-chevron-right" style="font-size: 0.7em;"></i>
            <span>Nuevo</span>
        </div>
    </div>

    <div class="card-modern">
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem; border-radius: 0.75rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="<?= url('admin/documentos/guardar') ?>" method="POST" enctype="multipart/form-data">
                <div class="form-section-title">
                    <i class="far fa-file-alt"></i>
                    <span>Información Principal</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Título del Documento</label>
                    <input type="text" name="titulo" class="form-control" required placeholder="Ej: Reglamento Interno 2025" autocomplete="off">
                </div>

                <div class="row" style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                    <div class="col-md-6" style="flex: 1; min-width: 250px;">
                        <div class="form-group">
                            <label class="form-label">Categoría</label>
                            <div class="input-group">
                                <input type="text" name="categoria" id="categoriaInput" class="form-control" placeholder="Ej: Gestión Institucional" required list="categorias" autocomplete="off">
                                <button type="button" class="btn btn-manage" id="btnManageCats" title="Gestionar Categorías">
                                    <i class="fas fa-cog"></i>
                                </button>
                            </div>
                            <datalist id="categorias">
                                <?php if(isset($categorias) && is_array($categorias)): ?>
                                    <?php foreach($categorias as $cat): ?>
                                        <option value="<?= htmlspecialchars($cat['nombre']) ?>">
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="col-md-6" style="flex: 1; min-width: 250px;">
                        <div class="form-group">
                            <label class="form-label">Tipo de Documento</label>
                            <select name="tipo_documento" class="form-control" required>
                                <option value="" disabled selected>Seleccione tipo...</option>
                                <option value="otro">Otro</option>
                                <option value="resolucion">Resolución</option>
                                <option value="directiva">Directiva</option>
                                <option value="reglamento">Reglamento</option>
                                <option value="manual">Manual</option>
                                <option value="informe">Informe</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1rem;">
                    <label class="form-label">Archivo Adjunto</label>
                    <div class="file-upload-wrapper">
                        <div class="drop-zone" id="dropZone">
                            <div class="drop-zone-content">
                                <i class="fas fa-cloud-upload-alt drop-zone-icon"></i>
                                <h4 class="drop-zone-text">Arrastra tu archivo aquí</h4>
                                <p class="drop-zone-hint">O haz clic para explorar (PDF, Word, Excel)</p>
                            </div>
                            <input type="file" name="archivo" id="fileInput" required accept=".pdf,.doc,.docx,.xls,.xlsx">
                        </div>
                        
                        <div id="filePreview" class="file-preview">
                            <div class="file-icon-wrapper">
                                <i class="far fa-file-pdf" id="fileTypeIcon"></i>
                            </div>
                            <div class="file-info">
                                <span class="file-name" id="fileName">documento.pdf</span>
                                <span class="file-size" id="fileSize">0 KB</span>
                            </div>
                            <button type="button" class="btn-remove-file" id="removeFile" title="Eliminar archivo">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= url('admin/documentos') ?>" class="btn btn-cancel">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-save"></i> Guardar Documento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Manage Categories -->
<div id="modalCategories" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Gestionar Categorías</h3>
            <button type="button" class="modal-close" id="btnCloseModal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="input-group" style="margin-bottom: 1rem;">
                <input type="text" id="newCatName" class="form-control" placeholder="Nueva categoría...">
                <button type="button" id="btnAddCat" class="btn btn-submit" style="white-space: nowrap;">
                    <i class="fas fa-plus"></i> Agregar
                </button>
            </div>
            
            <div id="categoryList" class="cat-list">
                <!-- Categories will be loaded here -->
                <div style="text-align: center; color: #94a3b8; padding: 1rem;">Cargando...</div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- Category Management ---
        const modal = document.getElementById('modalCategories');
        const btnManage = document.getElementById('btnManageCats');
        const btnClose = document.getElementById('btnCloseModal');
        const btnAddCat = document.getElementById('btnAddCat');
        const newCatInput = document.getElementById('newCatName');
        const categoryList = document.getElementById('categoryList');
        const datalist = document.getElementById('categorias');
        const baseUrl = '<?= url('') ?>';

        btnManage.addEventListener('click', () => {
            modal.style.display = 'flex';
            loadCategories();
        });

        btnClose.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.style.display = 'none';
        });

        btnAddCat.addEventListener('click', async () => {
            const name = newCatInput.value.trim();
            if(!name) return;

            try {
                const res = await fetch(baseUrl + 'admin/documentos/categorias/guardar', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({nombre: name})
                });
                const data = await res.json();
                
                if(data.success) {
                    newCatInput.value = '';
                    loadCategories();
                    refreshDatalist();
                } else {
                    alert(data.message || 'Error al guardar');
                }
            } catch(err) {
                console.error(err);
                alert('Error de conexión');
            }
        });

        async function loadCategories() {
            try {
                const res = await fetch(baseUrl + 'admin/documentos/categorias/listar');
                const data = await res.json();
                
                if(data.success) {
                    renderCategories(data.data);
                }
            } catch(err) {
                console.error(err);
                categoryList.innerHTML = '<div style="text-align:center; color:red;">Error al cargar</div>';
            }
        }

        function renderCategories(cats) {
            if(!cats.length) {
                categoryList.innerHTML = '<div style="text-align:center; color:#94a3b8;">No hay categorías</div>';
                return;
            }
            
            let html = '';
            cats.forEach(cat => {
                html += `
                    <div class="cat-item">
                        <span class="cat-name">${cat.nombre}</span>
                        <button class="btn-delete-cat" onclick="deleteCategory(${cat.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
            });
            categoryList.innerHTML = html;
        }

        window.deleteCategory = async (id) => {
            if(!confirm('¿Estás seguro de eliminar esta categoría?')) return;
            
            try {
                const res = await fetch(baseUrl + 'admin/documentos/categorias/eliminar', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({id: id})
                });
                const data = await res.json();
                
                if(data.success) {
                    loadCategories();
                    refreshDatalist();
                } else {
                    alert(data.message || 'Error al eliminar');
                }
            } catch(err) {
                console.error(err);
                alert('Error de conexión');
            }
        };

        async function refreshDatalist() {
            try {
                const res = await fetch(baseUrl + 'admin/documentos/categorias/listar');
                const data = await res.json();
                
                if(data.success) {
                    let html = '';
                    data.data.forEach(cat => {
                        html += `<option value="${cat.nombre}">`;
                    });
                    datalist.innerHTML = html;
                }
            } catch(err) {
                console.error(err);
            }
        }


        // --- File Upload Logic ---
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const removeFile = document.getElementById('removeFile');
        const fileTypeIcon = document.getElementById('fileTypeIcon');

        // Styles for drag events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

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

        // Handle drop
        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        // Handle click
        dropZone.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                fileInput.files = files; // Important for form submission if coming from drag/drop
                updatePreview(file);
            }
        }

        function updatePreview(file) {
            fileName.textContent = file.name;
            fileSize.textContent = formatBytes(file.size);
            
            // Update Icon based on extension
            const ext = file.name.split('.').pop().toLowerCase();
            fileTypeIcon.className = getIconClass(ext);
            
            dropZone.style.display = 'none';
            filePreview.style.display = 'flex';
        }

        removeFile.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent form submit
            fileInput.value = '';
            dropZone.style.display = 'block';
            filePreview.style.display = 'none';
        });

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

        function getIconClass(ext) {
            switch(ext) {
                case 'pdf': return 'far fa-file-pdf';
                case 'doc':
                case 'docx': return 'far fa-file-word';
                case 'xls':
                case 'xlsx': return 'far fa-file-excel';
                default: return 'far fa-file-alt';
            }
        }
    });
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
