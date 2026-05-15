<?php
ob_start();
?>
<div class="matricula-admin-wrapper">
    
    <!-- Admin Header -->
    <div class="admin-header-modern">
        <div class="header-content">
            <div class="header-titles">
                <h2 class="page-title">Gestión de Matrícula</h2>
                <div class="breadcrumb-modern">
                    <a href="<?= url('admin/dashboard') ?>"><i class="fas fa-home"></i></a>
                    <span class="separator">/</span>
                    <span class="current">Matrícula</span>
                </div>
            </div>
            <div class="header-actions">
                <a href="<?= url('matricula') ?>" target="_blank" class="btn-modern btn-outline">
                    <i class="fas fa-external-link-alt"></i> 
                    <span>Vista Pública</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    <?php if (isset($success)): ?>
        <div class="notification-banner success animate-slide-down">
            <div class="banner-icon"><i class="fas fa-check-circle"></i></div>
            <div class="banner-content"><?= $success ?></div>
            <button class="banner-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="notification-banner error animate-slide-down">
            <div class="banner-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="banner-content"><?= $error ?></div>
            <button class="banner-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
        </div>
    <?php endif; ?>

    <!-- Main Card -->
    <div class="main-card-modern animate-fade-up">
        <div class="card-header-modern">
            <div class="header-icon-box">
                <i class="fas fa-pen-nib"></i>
            </div>
            <div class="header-info">
                <h3>Editor de Contenido</h3>
                <p>Personaliza la información y el diseño de la página de matrícula</p>
            </div>
        </div>

        <div class="card-body-modern">
            
            <!-- Tabs Navigation -->
            <div class="modern-tabs-wrapper">
                <div class="modern-tabs">
                    <button type="button" class="tab-btn active" onclick="switchTab('designer')">
                        <i class="fas fa-layer-group"></i> 
                        <span>Diseñador</span>
                    </button>
                    <button type="button" class="tab-btn" onclick="switchTab('hero')">
                        <i class="fas fa-desktop"></i> 
                        <span>Hero</span>
                    </button>
                    <button type="button" class="tab-btn" onclick="switchTab('banner')">
                        <i class="fas fa-image"></i> 
                        <span>Banner</span>
                    </button>
                    <div class="tab-divider"></div>
                    <?php 
                    foreach ($matriculaData as $key => $data): 
                        if (in_array($key, ['banner_vertical', 'hero_type', 'hero_image', 'hero_video_url'])) continue;
                    ?>
                    <button type="button" class="tab-btn" onclick="switchTab('<?= $key ?>')">
                        <span><?= e($data['titulo']) ?></span>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <form action="<?= url('admin/matricula/update') ?>" method="POST" enctype="multipart/form-data" id="matriculaForm">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                
                <div class="tab-content-container">
                    
                    <!-- Designer Tab -->
                    <div id="content-designer" class="tab-pane active">
                        <div class="designer-grid">
                            <!-- Left Column: Sortable List -->
                            <div class="designer-column list-column">
                                <div class="column-header">
                                    <h4>Estructura de Página</h4>
                                    <span class="badge-tip"><i class="fas fa-info-circle"></i> Arrastra para reordenar</span>
                                </div>
                                
                                <div id="sortable-list" class="sortable-list">
                                    <?php 
                                    $heroFieldsList = ['hero_type', 'hero_image', 'hero_video_url'];
                                    foreach ($matriculaData as $key => $data): 
                                        if (in_array($key, $heroFieldsList)) continue;
                                    ?>
                                    <div class="sortable-item" data-id="<?= $key ?>">
                                        <div class="drag-handle">
                                            <i class="fas fa-grip-lines"></i>
                                        </div>
                                        <div class="item-content">
                                            <span class="item-title"><?= e($data['titulo']) ?></span>
                                            <?php if($key === 'banner_vertical'): ?>
                                                <span class="item-badge blue">Imagen Lateral</span>
                                            <?php else: ?>
                                                <span class="item-badge gray">Sección de Texto</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="item-actions">
                                            <button type="button" class="btn-icon-small" onclick="switchTab('<?= $key ?>')" title="Editar Contenido">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div id="save-status" class="save-status">
                                    <div class="spinner"></div>
                                    <span>Guardando cambios...</span>
                                </div>
                            </div>

                            <!-- Right Column: Live Preview -->
                            <div class="designer-column preview-column">
                                <div class="device-mockup macbook">
                                    <div class="device-header">
                                        <div class="window-dots">
                                            <span class="dot red"></span>
                                            <span class="dot yellow"></span>
                                            <span class="dot green"></span>
                                        </div>
                                        <div class="address-bar">
                                            <i class="fas fa-lock speed-icon"></i>
                                            <span>acip.edu.pe/matricula</span>
                                            <i class="fas fa-redo-alt refresh-icon" id="preview-refresh-icon"></i>
                                        </div>
                                    </div>
                                    <div class="device-screen">
                                        <iframe id="live-preview-frame" src="<?= url('matricula') ?>"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hero Tab -->
                    <div id="content-hero" class="tab-pane">
                        <?php 
                        $heroType = $matriculaData['hero_type']['contenido'] ?? 'default';
                        $heroImage = $matriculaData['hero_image']['contenido'] ?? '';
                        $heroVideoUrl = $matriculaData['hero_video_url']['contenido'] ?? '';
                        ?>
                        
                        <div class="config-grid">
                            <div class="config-panel">
                                <div class="form-group-modern">
                                    <label>Tipo de Hero</label>
                                    <input type="hidden" name="hero_type" id="hero_type_input" value="<?= e($heroType) ?>">
                                    <div class="type-selector">
                                        <div class="type-option <?= $heroType === 'default' ? 'active' : '' ?>" onclick="selectHeroType('default', this)">
                                            <div class="option-icon"><i class="fas fa-layer-group"></i></div>
                                            <span>Por Defecto</span>
                                        </div>
                                        <div class="type-option <?= $heroType === 'image' ? 'active' : '' ?>" onclick="selectHeroType('image', this)">
                                            <div class="option-icon"><i class="fas fa-image"></i></div>
                                            <span>Imagen Estática</span>
                                        </div>
                                        <div class="type-option <?= $heroType === 'video' ? 'active' : '' ?>" onclick="selectHeroType('video', this)">
                                            <div class="option-icon"><i class="fab fa-youtube"></i></div>
                                            <span>Video YouTube</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Config -->
                                <div id="hero-image-section" class="config-section" style="display: <?= $heroType === 'image' ? 'block' : 'none' ?>;">
                                    <label>Imagen de Fondo</label>
                                    <div class="upload-zone" id="drop-hero-image">
                                        <input type="file" name="hero_image" id="hero-image-input" accept="image/*">
                                        <div class="upload-content">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <h4>Subir Imagen</h4>
                                            <p>Recomendado: 1920x600px (JPG, PNG)</p>
                                        </div>
                                    </div>
                                    <!-- Simple Preview for uploaded image context -->
                                    <div id="hero-image-mini-preview" class="mini-preview mt-3">
                                        <?php if (!empty($heroImage)): ?>
                                            <div class="current-file">
                                                <i class="fas fa-check-circle text-success"></i>
                                                <span>Imagen actual cargada</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Video Config -->
                                <div id="hero-video-section" class="config-section" style="display: <?= $heroType === 'video' ? 'block' : 'none' ?>;">
                                    <div class="form-group-modern">
                                        <label>URL del Video</label>
                                        <div class="input-group-modern">
                                            <span class="input-icon"><i class="fab fa-youtube"></i></span>
                                            <input type="text" name="hero_video_url" id="hero-video-url-input" value="<?= e($heroVideoUrl) ?>" placeholder="https://youtube.com/watch?v=...">
                                        </div>
                                        <p class="form-hint">El video se reproducirá automáticamente en bucle como fondo.</p>
                                    </div>
                                </div>
                                
                                <div class="action-footer">
                                    <button type="submit" class="btn-modern btn-primary">
                                        <i class="fas fa-save"></i> Guardar Cambios
                                    </button>
                                </div>
                            </div>

                            <div class="preview-panel">
                                <label class="panel-label">Vista Previa del Componente</label>
                                <div class="hero-component-preview">
                                    <div class="hero-mockup">
                                        <div class="hero-bg-layer" id="hero-preview-layer">
                                            <?php if ($heroType === 'video' && !empty($heroVideoUrl)): ?>
                                                <?php 
                                                    preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $heroVideoUrl, $matches);
                                                    $videoId = $matches[1] ?? '';
                                                ?>
                                                <div class="preview-iframe-wrapper">
                                                    <iframe src="https://www.youtube.com/embed/<?= $videoId ?>?autoplay=0&mute=1&controls=0&showinfo=0&modestbranding=1" frameborder="0"></iframe>
                                                </div>
                                            <?php elseif ($heroType === 'image' && !empty($heroImage)): ?>
                                                <img src="<?= url($heroImage) ?>" class="preview-img">
                                            <?php else: ?>
                                                <div class="preview-default-bg"></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="hero-content-layer">
                                            <h1 class="mockup-title">MATRÍCULAS</h1>
                                            <p class="mockup-subtitle">Portal Académico 2026</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Banner Tab -->
                    <div id="content-banner" class="tab-pane">
                         <div class="config-grid">
                            <div class="config-panel">
                                <div class="form-group-modern">
                                    <label>Banner Vertical Lateral</label>
                                    <p class="form-desc">Esta imagen se muestra en la barra lateral de la página pública.</p>
                                    
                                    <div class="upload-zone smaller" id="drop-banner">
                                        <input type="file" name="banner_vertical" id="banner_input" accept="image/*">
                                        <div class="upload-content">
                                            <i class="fas fa-image"></i>
                                            <h4>Subir Banner</h4>
                                            <p>Vertical (400x800px)</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="action-footer">
                                    <button type="submit" class="btn-modern btn-primary">
                                        <i class="fas fa-save"></i> Guardar Banner
                                    </button>
                                </div>
                            </div>
                            
                            <div class="preview-panel">
                                <label class="panel-label">Visualización</label>
                                <div class="banner-preview-container">
                                    <?php if (isset($matriculaData['banner_vertical']) && !empty($matriculaData['banner_vertical']['contenido'])): ?>
                                        <img src="<?= url($matriculaData['banner_vertical']['contenido']) ?>" class="banner-img">
                                    <?php else: ?>
                                        <div class="banner-placeholder">
                                            <i class="fas fa-image"></i>
                                            <span>Sin Banner</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Editors Tabs -->
                    <?php 
                    $heroFields = ['banner_vertical', 'hero_type', 'hero_image', 'hero_video_url'];
                    foreach ($matriculaData as $key => $data): 
                        if (in_array($key, $heroFields)) continue;
                    ?>
                    <div id="content-<?= $key ?>" class="tab-pane">
                        <div class="editor-container">
                            <div class="editor-header">
                                <div class="editor-title">
                                    <i class="fas fa-paragraph"></i>
                                    <span><?= e($data['titulo']) ?></span>
                                </div>
                            </div>
                            <div class="editor-wrapper">
                                <textarea name="<?= $key ?>" id="editor_<?= $key ?>"><?= $data['contenido'] ?></textarea>
                            </div>
                            <div class="editor-footer">
                                <button type="submit" class="btn-modern btn-primary">
                                    <i class="fas fa-save"></i> Guardar Contenido
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts & Styles -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Sortable Initialization
    const sortableEl = document.getElementById('sortable-list');
    if(sortableEl) {
        Sortable.create(sortableEl, {
            animation: 200,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function() {
                saveOrder();
            }
        });
    }

    // 2. CKEditor Initialization
    const editorConfig = {
        height: 400,
        removePlugins: 'exportpdf',
        uiColor: '#ffffff',
        toolbar: [
            { name: 'styles', items: [ 'Format', 'FontSize' ] },
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat' ] },
            { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight' ] },
            { name: 'links', items: [ 'Link', 'Unlink' ] },
            { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ] },
            { name: 'tools', items: [ 'Maximize', 'Source' ] }
        ],
        contentsCss: [
             'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css',
             'body { font-family: "Inter", system-ui, -apple-system, sans-serif; padding: 20px; color: #334155; }'
        ]
    };

    <?php foreach ($matriculaData as $key => $data): 
        if (in_array($key, ['banner_vertical', 'hero_type', 'hero_image', 'hero_video_url'])) continue;
    ?>
        if (document.getElementById('editor_<?= $key ?>')) {
            CKEDITOR.replace('editor_<?= $key ?>', editorConfig);
        }
    <?php endforeach; ?>

    // 3. File Input Interactions
    setupFileUpload('drop-hero-image', 'hero-image-input');
    setupFileUpload('drop-banner', 'banner_input');

    function setupFileUpload(dropZoneId, inputId) {
        const dropZone = document.getElementById(dropZoneId);
        const input = document.getElementById(inputId);
        if(!dropZone || !input) return;

        dropZone.addEventListener('click', () => input.click());
        input.addEventListener('change', () => updateFileStatus(dropZone, input));
        
        ['dragenter', 'dragover'].forEach(e => {
            dropZone.addEventListener(e, (evt) => {
                evt.preventDefault();
                dropZone.classList.add('dragover');
            });
        });
        
        ['dragleave', 'drop'].forEach(e => {
            dropZone.addEventListener(e, (evt) => {
                evt.preventDefault();
                dropZone.classList.remove('dragover');
            });
        });

        dropZone.addEventListener('drop', (e) => {
            if(e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                updateFileStatus(dropZone, input);
            }
        });
    }

    function updateFileStatus(dropZone, input) {
        if(input.files && input.files[0]) {
            const content = dropZone.querySelector('.upload-content');
            content.innerHTML = `
                <i class="fas fa-check-circle text-success" style="font-size: 2rem; color: #10b981; margin-bottom: 0.5rem;"></i>
                <h4 style="color: #0f172a;">${input.files[0].name}</h4>
                <p>Listo para guardar</p>
            `;
            dropZone.style.borderColor = '#10b981';
            dropZone.style.background = '#ecfdf5';
        }
    }
});

// Tab Switching
window.switchTab = function(key) {
    // Content
    document.querySelectorAll('.tab-pane').forEach(el => el.classList.remove('active'));
    document.getElementById('content-' + key).classList.add('active');
    
    // Buttons
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    // Find button that called this or matches the key
    const btns = document.querySelectorAll('.tab-btn');
    btns.forEach(btn => {
        if(btn.getAttribute('onclick').includes(key)) {
            btn.classList.add('active');
        }
    });
};

// Hero Type Selection
window.selectHeroType = function(type, element) {
    document.getElementById('hero_type_input').value = type;
    
    // Update UI options
    document.querySelectorAll('.type-option').forEach(el => el.classList.remove('active'));
    element.classList.add('active');
    
    // Toggle Sections
    const imgSection = document.getElementById('hero-image-section');
    const vidSection = document.getElementById('hero-video-section');
    
    if(imgSection) imgSection.style.display = 'none';
    if(vidSection) vidSection.style.display = 'none';
    
    if(type === 'image' && imgSection) imgSection.style.display = 'block';
    if(type === 'video' && vidSection) vidSection.style.display = 'block';
};

// Save Order API
function saveOrder() {
    const statusEl = document.getElementById('save-status');
    const refreshIcon = document.getElementById('preview-refresh-icon');
    const list = document.getElementById('sortable-list');
    
    if(statusEl) statusEl.classList.add('saving');
    if(refreshIcon) refreshIcon.classList.add('fa-spin');

    const order = [];
    list.querySelectorAll('.sortable-item').forEach(item => {
        order.push(item.getAttribute('data-id'));
    });

    fetch('<?= url('admin/matricula/update-order') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ order: order })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            if(statusEl) {
                statusEl.classList.remove('saving');
                statusEl.innerHTML = '<i class="fas fa-check text-success"></i> <span>Guardado</span>';
                setTimeout(() => {
                   statusEl.innerHTML = '<div class="spinner"></div><span>Guardando...</span>'; 
                }, 2000);
            }
            
            // Reload iframe
            const iframe = document.getElementById('live-preview-frame');
            if(iframe) {
                iframe.src = iframe.src;
                iframe.onload = () => {
                    if(refreshIcon) refreshIcon.classList.remove('fa-spin');
                };
            }
        }
    })
    .catch(err => console.error(err));
}
</script>

<style>
/* =========================================
   Variables & Reset
   ========================================= */
:root {
    --primary: #4f46e5;
    --primary-dark: #4338ca;
    --primary-light: #e0e7ff;
    --text-main: #0f172a;
    --text-secondary: #64748b;
    --bg-page: #f1f5f9;
    --bg-card: #ffffff;
    --border: #e2e8f0;
    --accent-red: #ef4444;
    --accent-green: #10b981;
    --accent-blue: #3b82f6;
    --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
    --shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
    --radius: 12px;
}

.matricula-admin-wrapper {
    max-width: 1600px;
    margin: 0 auto;
    font-family: 'Inter', system-ui, sans-serif;
    color: var(--text-main);
}

/* =========================================
   Header
   ========================================= */
.admin-header-modern {
    margin-bottom: 2rem;
    padding: 0 0.5rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
}

.page-title {
    font-size: 1.875rem;
    font-weight: 800;
    color: var(--text-main);
    margin: 0 0 0.5rem 0;
    letter-spacing: -0.025em;
}

.breadcrumb-modern {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.breadcrumb-modern a {
    color: var(--text-secondary);
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumb-modern a:hover { color: var(--primary); }
.breadcrumb-modern .current { font-weight: 500; color: var(--primary); }

.btn-modern {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s;
    cursor: pointer;
    text-decoration: none;
    border: 1px solid transparent;
}

.btn-modern.btn-outline {
    background: white;
    border-color: var(--border);
    color: var(--text-secondary);
    box-shadow: var(--shadow-sm);
}

.btn-modern.btn-outline:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-1px);
}

.btn-modern.btn-primary {
    background: var(--primary);
    color: white;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.btn-modern.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

/* =========================================
   Main Card
   ========================================= */
.main-card-modern {
    background: var(--bg-card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
}

.card-header-modern {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #f8fafc;
}

.header-icon-box {
    width: 48px;
    height: 48px;
    background: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.25rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border);
}

.header-info h3 {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 700;
}

.header-info p {
    margin: 0.25rem 0 0 0;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.card-body-modern {
    padding: 0;
}

/* =========================================
   Tabs
   ========================================= */
.modern-tabs-wrapper {
    background: white;
    padding: 0 1.5rem;
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0;
    z-index: 10;
}

.modern-tabs {
    display: flex;
    gap: 2rem;
    overflow-x: auto;
    scrollbar-width: none;
}

.tab-btn {
    background: none;
    border: none;
    padding: 1.25rem 0;
    font-size: 0.95rem;
    font-weight: 500;
    color: var(--text-secondary);
    cursor: pointer;
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
    transition: color 0.2s;
}

.tab-btn i { font-size: 1rem; margin-bottom: 2px; }

.tab-btn::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    height: 2px;
    background: var(--primary);
    transform: scaleX(0);
    transition: transform 0.2s;
}

.tab-btn:hover { color: var(--primary); }

.tab-btn.active {
    color: var(--primary);
    font-weight: 600;
}

.tab-btn.active::after {
    transform: scaleX(1);
}

.tab-divider {
    width: 1px;
    background: var(--border);
    margin: 1rem 0;
}

/* =========================================
   Content Areas
   ========================================= */
.tab-content-container {
    padding: 2rem;
    background: #fdfdfd;
    min-height: 600px;
}

.tab-pane {
    display: none;
    animation: fadeIn 0.3s ease;
}

.tab-pane.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* =========================================
   Designer Grid
   ========================================= */
.designer-grid {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 2rem;
    align-items: start;
}

.column-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.column-header h4 {
    font-size: 1rem;
    font-weight: 700;
    margin: 0;
}

.badge-tip {
    font-size: 0.75rem;
    color: var(--text-secondary);
    background: var(--bg-page);
    padding: 4px 8px;
    border-radius: 4px;
}

.sortable-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding-bottom: 2rem;
}

.sortable-item {
    background: white;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    cursor: grab;
    transition: all 0.2s;
    box-shadow: var(--shadow-sm);
}

.sortable-item:hover {
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.sortable-item:active {
    cursor: grabbing;
}

.drag-handle {
    color: var(--border);
    cursor: grab;
    padding: 0.5rem;
}

.sortable-item:hover .drag-handle { color: var(--text-secondary); }

.item-content { flex: 1; }

.item-title {
    display: block;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.item-badge {
    font-size: 0.7rem;
    padding: 2px 6px;
    border-radius: 4px;
    text-transform: uppercase;
    font-weight: 600;
}

.item-badge.blue { background: #dbeafe; color: #1e40af; }
.item-badge.gray { background: #f1f5f9; color: #475569; }

.item-actions .btn-icon-small {
    background: transparent;
    border: none;
    color: var(--text-secondary);
    padding: 0.5rem;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s;
}

.item-actions .btn-icon-small:hover {
    background: var(--bg-page);
    color: var(--primary);
}

/* =========================================
   Device Mockup
   ========================================= */
.device-mockup {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border);
    overflow: hidden;
    height: 700px;
    display: flex;
    flex-direction: column;
}

.device-header {
    background: #f1f5f9;
    padding: 0.75rem 1rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.window-dots {
    display: flex;
    gap: 6px;
}

.dot { width: 10px; height: 10px; border-radius: 50%; }
.dot.red { background: #ef4444; }
.dot.yellow { background: #f59e0b; }
.dot.green { background: #10b981; }

.address-bar {
    flex: 1;
    background: white;
    border-radius: 6px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    color: var(--text-secondary);
    border: 1px solid var(--border);
    box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    position: relative;
}

.speed-icon { margin-right: 6px; font-size: 0.7rem; color: #10b981; }
.refresh-icon {
    position: absolute;
    right: 8px;
    cursor: pointer;
    font-size: 0.75rem;
    color: var(--text-secondary);
}
.refresh-icon:hover { color: var(--primary); }

.device-screen {
    flex: 1;
    background: white;
    position: relative;
}

.device-screen iframe {
    width: 100%;
    height: 100%;
    border: none;
}

/* =========================================
   Config Panels
   ========================================= */
.config-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2rem;
}

.config-panel {
    background: white;
    padding: 2rem;
    border-radius: var(--radius);
    border: 1px solid var(--border);
}

.form-group-modern { margin-bottom: 1.5rem; }
.form-group-modern label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: var(--text-main);
}

.type-selector {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.type-option {
    border: 2px solid var(--border);
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: var(--bg-page);
}

.type-option:hover {
    border-color: var(--primary);
    background: white;
    transform: translateY(-2px);
}

.type-option.active {
    border-color: var(--primary);
    background: var(--primary-light);
}

.option-icon {
    font-size: 1.5rem;
    color: var(--text-secondary);
    margin-bottom: 0.75rem;
}

.type-option.active .option-icon { color: var(--primary); }

.type-option span {
    font-size: 0.85rem;
    font-weight: 600;
}

/* Upload Zone */
.upload-zone {
    border: 2px dashed var(--border);
    border-radius: 12px;
    padding: 2.5rem;
    text-align: center;
    cursor: pointer;
    background: var(--bg-page);
    transition: all 0.2s;
    position: relative;
    overflow: hidden;
}

.upload-zone:hover {
    border-color: var(--primary);
    background: #fdfdfd;
}

.upload-zone input {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    opacity: 0;
    cursor: pointer;
}

.upload-content i {
    font-size: 2.5rem;
    color: var(--text-secondary);
    margin-bottom: 1rem;
}

.upload-content h4 {
    font-size: 1rem;
    margin: 0 0 0.5rem;
}

.upload-content p {
    font-size: 0.85rem;
    color: var(--text-secondary);
    margin: 0;
}

/* Preview Panel */
.preview-panel {
    background: var(--bg-page);
    padding: 1.5rem;
    border-radius: var(--radius);
    border: 1px solid var(--border);
}

.panel-label {
    display: block;
    font-size: 0.75rem;
    text-transform: uppercase;
    color: var(--text-secondary);
    font-weight: 700;
    margin-bottom: 1rem;
    letter-spacing: 0.05em;
}

.hero-component-preview {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow-md);
}

.hero-mockup {
    height: 220px;
    position: relative;
    background: #1e293b;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.hero-bg-layer {
    position: absolute;
    inset: 0;
    z-index: 1;
}

.preview-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.preview-iframe-wrapper {
    width: 100%;
    height: 100%;
    position: relative;
}

.preview-iframe-wrapper iframe {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(1.5);
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.hero-content-layer {
    position: relative;
    z-index: 2;
    color: white;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.mockup-title { font-size: 1.5rem; font-weight: 800; margin: 0; }
.mockup-subtitle { font-size: 0.9rem; opacity: 0.8; margin: 0; }

/* Editor */
.editor-container {
    background: white;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    overflow: hidden;
}

.editor-header {
    background: var(--bg-page);
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border);
    font-weight: 600;
}

.editor-wrapper {
    padding: 0;
}

.editor-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border);
    background: var(--bg-page);
    text-align: right;
}

/* Utils */
.banner-img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: var(--shadow);
}
.banner-placeholder {
    height: 300px;
    background: white;
    border: 2px dashed var(--border);
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
}

.save-status {
    margin-top: 1rem;
    text-align: center;
    font-size: 0.85rem;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity 0.3s;
}

.save-status.saving { opacity: 1; }

.spinner {
    width: 16px;
    height: 16px;
    border: 2px solid var(--border);
    border-top-color: var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin { to { transform: rotate(360deg); } }

/* Notification */
.notification-banner {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    min-width: 350px;
    background: white;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    display: flex;
    align-items: flex-start;
    gap: 12px;
    animation: slideInRight 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.notification-banner.success { border-left: 4px solid var(--accent-green); }
.notification-banner.error { border-left: 4px solid var(--accent-red); }

.banner-icon { font-size: 1.25rem; }
.success .banner-icon { color: var(--accent-green); }
.error .banner-icon { color: var(--accent-red); }

.banner-close {
    background: none;
    border: none;
    color: var(--text-secondary);
    cursor: pointer;
    margin-left: auto;
}

@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
</style>

<?php
$content = ob_get_clean();
$currentPage = 'matricula'; // Ensure active state in sidebar
require APP_PATH . '/Views/layouts/admin.php';
?>
