<?php ob_start(); ?>

<style>
    /* Enterprise Style Variables */
    :root {
        --primary-color: #0f172a; 
        --accent-color: #2563eb; 
        --bg-gray: #f8fafc;
        --border-color: #e2e8f0;
        --text-color: #334155;
    }

    /* General Layout */
    .card-enterprise {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    .card-header-enterprise {
        background: #fff;
        padding: 24px 32px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header-enterprise h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
        letter-spacing: -0.025em;
    }

    /* Tabs Styling */
    .nav-tabs-enterprise {
        display: flex;
        padding: 0 20px;
        background: #fff;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 30px;
    }

    .nav-tab-enterprise {
        padding: 16px 24px;
        cursor: pointer;
        font-weight: 500;
        color: #64748b;
        border-bottom: 2px solid transparent;
        transition: all 0.2s ease;
        font-size: 0.95rem;
    }

    .nav-tab-enterprise:hover {
        color: var(--accent-color);
        background: #f1f5f9;
    }

    .nav-tab-enterprise.active {
        color: var(--accent-color);
        border-bottom-color: var(--accent-color);
    }

    /* Form Elements */
    .form-section {
        padding: 0 32px 32px;
    }

    .form-group-enterprise {
        margin-bottom: 24px;
    }

    .label-enterprise {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 8px;
    }

    .input-enterprise {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 0.95rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #fcfcfc;
    }

    .input-enterprise:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: #fff;
    }

    /* Drag & Drop Zones */
    .drop-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .drop-zone:hover, .drop-zone.dragover {
        border-color: var(--accent-color);
        background: #eff6ff;
    }

    .drop-zone i {
        font-size: 2.5rem;
        color: #94a3b8;
        margin-bottom: 12px;
    }

    .drop-zone p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    .drop-zone .highlight-text {
        color: var(--accent-color);
        font-weight: 600;
    }

    /* Preview Grids */
    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 12px;
        margin-top: 16px;
    }
    .preview-item {
        position: relative;
        height: 100px;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid var(--border-color);
    }
    .preview-item img {
        width: 100%; height: 100%; object-fit: cover;
    }

    .tab-content { display: none; }
    .tab-content.active { display: block; animation: fadeIn 0.3s; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

    .btn-enterprise {
        background: var(--accent-color);
        color: white;
        padding: 12px 28px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(37,99,235,0.2);
        transition: transform 0.1s, box-shadow 0.1s;
    }
    .btn-enterprise:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 6px rgba(37,99,235,0.3);
        transform: translateY(-1px);
    }
</style>

<div class="card-enterprise">
    <div class="card-header-enterprise">
        <h2><i class="fas fa-plus-circle text-gray-400 mr-2"></i> Nuevo Programa</h2>
        <a href="<?= url('admin/programas') ?>" class="btn btn-light" style="border: 1px solid #e2e8f0; color: #475569; padding: 8px 16px; border-radius: 6px; font-weight: 500;">
            <i class="fas fa-arrow-left mr-1"></i> Cancelar
        </a>
    </div>

    <form action="<?= url('admin/programas/crear') ?>" method="POST" enctype="multipart/form-data">
        
        <!-- Enterprise Tabs -->
        <div class="nav-tabs-enterprise">
            <div class="nav-tab-enterprise active" onclick="switchTab('general')">Información General</div>
            <div class="nav-tab-enterprise" onclick="switchTab('academico')">Detalles Académicos</div>
            <div class="nav-tab-enterprise" onclick="switchTab('documentos')">Gestión y Documentos</div>
            <div class="nav-tab-enterprise" onclick="switchTab('galeria')">Galería y Aliados</div>
        </div>

        <div class="form-section">
            <!-- TAB: GENERAL -->
            <div id="tab-general" class="tab-content active">
                <div class="row" style="display: flex; gap: 40px;">
                    <div style="flex: 2;">
                        <div class="form-group-enterprise">
                            <label class="label-enterprise">Nombre del Programa <span class="text-red-500">*</span></label>
                            <input type="text" name="nombre" class="input-enterprise" placeholder="Ej. Ingeniería de Sistemas" required>
                        </div>
                        <div class="form-group-enterprise">
                            <label class="label-enterprise">Descripción Corta <span class="text-red-500">*</span></label>
                            <textarea name="descripcion" rows="4" class="input-enterprise" placeholder="Breve resumen para tarjetas..." required></textarea>
                        </div>
                    </div>
                    <div style="flex: 1;">
                         <div style="background: #f8fafc; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <div class="form-group-enterprise">
                                <label class="label-enterprise">Modalidad</label>
                                <select name="modalidad" class="input-enterprise">
                                    <option value="presencial">Presencial</option>
                                    <option value="semipresencial">Semipresencial</option>
                                    <option value="virtual">Virtual</option>
                                </select>
                            </div>
                            
                            <div class="row" style="display:flex; gap: 15px;">
                                <div class="form-group-enterprise" style="flex:1">
                                    <label class="label-enterprise">Duración (Sem)</label>
                                    <input type="number" name="duracion_semestres" class="input-enterprise" value="6">
                                </div>
                                <div class="form-group-enterprise" style="flex:1">
                                    <label class="label-enterprise">Orden</label>
                                    <input type="number" name="orden" class="input-enterprise" value="0">
                                </div>
                            </div>

                            <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-white rounded transition">
                                <input type="checkbox" name="activo" value="1" checked style="width: 18px; height: 18px;">
                                <span class="text-sm font-semibold text-gray-700">Publicar en Web</span>
                            </label>
                         </div>
                    </div>
                </div>

                <hr style="margin: 30px 0; border: 0; border-top: 1px solid #e2e8f0;">

                <div class="row" style="display: flex; gap: 40px;">
                    <div style="flex: 1;">
                         <label class="label-enterprise mb-3">Imagen Destacada (Portada)</label>
                         <div class="drop-zone" id="drop-main">
                            <input type="file" name="imagen" id="imagen" class="hidden" accept="image/*" style="display:none;">
                            <i class="fas fa-camera"></i>
                            <p>Arrastra imagen aquí o <span class="highlight-text">clic para subir</span></p>
                            <div id="preview-main" class="preview-grid" style="grid-template-columns: 1fr; margin-top: 15px;"></div>
                         </div>
                    </div>
                    <div style="flex: 1;">
                        <div class="form-group-enterprise">
                            <label class="label-enterprise">Video Promocional (URL)</label>
                            <input type="url" name="video_url" class="input-enterprise" placeholder="https://youtube.com/...">
                            <small style="display: block; margin-top: 5px; color: #64748b;">Enlace directo a YouTube o Vimeo</small>
                        </div>
                    </div>
                </div>

                <div class="row" style="display: flex; gap: 40px; margin-top: 30px;">
                    <div style="flex: 1;">
                         <label class="label-enterprise mb-3">Video Hero (Archivo o URL)</label>
                         <div class="form-group-enterprise" style="margin-bottom: 15px;">
                             <input type="url" name="video_hero_url" class="input-enterprise" placeholder="https://youtube.com/watch?v=...">
                             <small style="display: block; margin-top: 5px; color: #64748b;">O ingresa URL de YouTube para el hero</small>
                         </div>
                         <div class="drop-zone" id="drop-video">
                            <input type="file" name="video_hero" id="video_hero" class="hidden" accept="video/*" style="display:none;">
                            <i class="fas fa-video"></i>
                            <p>O arrastra video aquí / <span class="highlight-text">clic para subir archivo</span></p>
                            <small style="color: #64748b;">Formatos: MP4, WebM, MOV (máx. 50MB)</small>
                            <div id="preview-video" style="margin-top: 15px;"></div>
                         </div>
                    </div>
                    <div style="flex: 1; display: flex; align-items: center; justify-content: center; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px;">
                        <div style="text-align: center; color: #64748b;">
                            <i class="fas fa-info-circle" style="font-size: 2rem; margin-bottom: 10px; color: #2563eb;"></i>
                            <p style="margin: 0; font-size: 0.9rem;"><strong>Tip:</strong> Puedes usar imagen, video subido O video de YouTube para el hero del programa.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: ACADEMICO -->
            <div id="tab-academico" class="tab-content">
                <div class="form-group-enterprise">
                    <label class="label-enterprise">Perfil del Egresado</label>
                    <textarea name="perfil_egresado" class="editor"></textarea>
                </div>
                <div class="form-group-enterprise">
                    <label class="label-enterprise">Ámbito Laboral</label>
                    <textarea name="ambito_laboral" class="editor"></textarea>
                </div>
                <div class="form-group-enterprise">
                    <label class="label-enterprise">Certificaciones</label>
                    <textarea name="certificaciones" class="editor"></textarea>
                </div>
                <div class="form-group-enterprise">
                    <label class="label-enterprise">Plan de Estudios</label>
                    <textarea name="plan_estudios" class="editor"></textarea>
                </div>
            </div>

            <!-- TAB: DOCUMENTOS -->
            <div id="tab-documentos" class="tab-content">
                <div class="form-group-enterprise">
                    <label class="label-enterprise">Horario de Clases</label>
                    <textarea name="horario_clases" class="editor"></textarea>
                </div>
                <div class="form-group-enterprise">
                    <label class="label-enterprise">Oficio de Autorización</label>
                    <textarea name="oficio_autorizacion" class="editor"></textarea>
                </div>
                <div class="form-group-enterprise">
                    <label class="label-enterprise">Información de Matrícula</label>
                    <textarea name="matricula_info" class="editor"></textarea>
                </div>
                <div class="form-group-enterprise">
                    <label class="label-enterprise">EFSRT (Experiencias Formativas)</label>
                    <textarea name="efsrt" class="editor"></textarea>
                </div>
            </div>

            <!-- TAB: GALERIA -->
            <div id="tab-galeria" class="tab-content">
                <div class="mb-5">
                    <label class="label-enterprise mb-3">Galería de Fotos</label>
                    <div class="drop-zone" id="drop-gallery">
                        <input type="file" name="galeria[]" id="galeria" multiple class="hidden" accept="image/*" style="display:none;">
                        <i class="fas fa-images"></i>
                        <p>Arrastra múltiples fotos aquí o <span class="highlight-text">haz clic</span></p>
                        <div id="preview-gallery" class="preview-grid"></div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200">
                    <label class="label-enterprise mb-3">Aliados / Convenios</label>
                    <div class="drop-zone" id="drop-aliados">
                        <input type="file" name="aliados[]" id="aliados" multiple class="hidden" accept="image/*" style="display:none;">
                        <i class="fas fa-handshake"></i>
                        <p>Sube logotipos de aliados aquí</p>
                        <div id="preview-aliados" class="preview-grid"></div>
                    </div>
                </div>
            </div>
        </div>

        <div style="padding: 24px 32px; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: right;">
            <button type="submit" class="btn-enterprise">
                <i class="fas fa-plus-circle mr-2"></i> Crear Programa
            </button>
        </div>
    </form>
</div>

<!-- CKEditor 5 Official CDN with GPL License (UMD Build) -->
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">
<script src="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.umd.js"></script>

<style>
    /* CSS FIX: Use Off-Screen positioning instead of display:none */
    .tab-content {
        position: absolute;
        top: 0;
        left: -9999px;
        opacity: 0;
        visibility: hidden;
        width: 100%;
        z-index: -1;
    }
    
    .tab-content.active {
        position: relative;
        left: 0;
        opacity: 1;
        visibility: visible;
        z-index: 1;
        animation: fadeIn 0.3s;
    }

    .ck-editor__editable {
        min-height: 200px;
        max-height: 600px;
    }
    
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>

<script>
// Tab Logic - Define globally first
window.switchTab = function(tabName) {
    document.querySelectorAll(".nav-tab-enterprise").forEach(t => t.classList.remove("active"));
    document.querySelectorAll(".tab-content").forEach(c => c.classList.remove("active"));
    
    document.getElementById("tab-" + tabName).classList.add("active");
    
    if(window.event && window.event.currentTarget) {
         window.event.currentTarget.classList.add("active");
    }
}

// Drop Zone Logic
function setupDropZone(dropZoneId, inputId, previewId, isMultiple = false) {
    const dropZone = document.getElementById(dropZoneId);
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    if(!dropZone) return;

    dropZone.addEventListener("click", () => input.click());
    input.addEventListener("change", () => handleFiles(input.files, preview, isMultiple));
    ["dragenter", "dragover", "dragleave", "drop"].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => { e.preventDefault(); e.stopPropagation(); }, false);
    });
    ["dragenter", "dragover"].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.add("dragover"), false);
    });
    ["dragleave", "drop"].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.remove("dragover"), false);
    });
    dropZone.addEventListener("drop", (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        input.files = files; 
        handleFiles(files, preview, isMultiple);
    });
}

function handleFiles(files, previewContainer, isMultiple) {
    if (!isMultiple) previewContainer.innerHTML = "";
    ([...files]).forEach(file => {
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = () => {
                const div = document.createElement("div");
                div.className = "preview-item";
                div.innerHTML = `<img src="${reader.result}">`;
                previewContainer.appendChild(div);
            }
        } else if (file.type.startsWith("video/")) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = () => {
                const div = document.createElement("div");
                div.style.marginTop = "10px";
                div.innerHTML = `
                    <video controls style="width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <source src="${reader.result}" type="${file.type}">
                    </video>
                    <p style="margin-top: 8px; font-size: 0.85rem; color: #64748b;">
                        <i class="fas fa-file-video"></i> ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)
                    </p>
                `;
                previewContainer.appendChild(div);
            }
        }
    });
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    // Verificar que CKEditor está disponible
    if (typeof CKEDITOR === 'undefined') {
        console.error('CKEditor 5 no está cargado correctamente');
        return;
    }

    // Extraer plugins necesarios del objeto global CKEDITOR
    const {
        ClassicEditor,
        SourceEditing,
        Essentials,
        Bold,
        Italic,
        Underline,
        Strikethrough,
        Heading,
        Link,
        List,
        BlockQuote,
        Table,
        TableToolbar,
        Paragraph,
        Undo,
        Indent,
        IndentBlock,
        Alignment,
        GeneralHtmlSupport,
        Image,
        ImageToolbar,
        ImageUpload,
        ImageResize,
        ImageStyle,
        MediaEmbed
    } = CKEDITOR;

    // Almacenar instancias de editores
    const editors = {};
    
    // Configuración común para todos los editores
    const editorConfig = {
        licenseKey: 'GPL',
        plugins: [
            SourceEditing,
            Essentials,
            Bold,
            Italic,
            Underline,
            Strikethrough,
            Heading,
            Link,
            List,
            BlockQuote,
            Table,
            TableToolbar,
            Paragraph,
            Undo,
            Indent,
            IndentBlock,
            Alignment,
            GeneralHtmlSupport,
            Image,
            ImageToolbar,
            ImageUpload,
            ImageResize,
            ImageStyle,
            MediaEmbed
        ],
        toolbar: [
            'sourceEditing', '|',
            'heading', '|',
            'bold', 'italic', 'underline', 'strikethrough', '|',
            'bulletedList', 'numberedList', '|',
            'alignment', 'outdent', 'indent', '|',
            'link', 'blockQuote', 'insertTable', '|',
            'uploadImage', 'mediaEmbed', '|',
            'undo', 'redo'
        ],
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
        },
        image: {
            toolbar: [
                'imageStyle:inline',
                'imageStyle:block',
                'imageStyle:side',
                '|',
                'toggleImageCaption',
                'imageTextAlternative',
                '|',
                'linkImage'
            ],
            resizeOptions: [
                {
                    name: 'resizeImage:original',
                    label: 'Original',
                    value: null
                },
                {
                    name: 'resizeImage:50',
                    label: '50%',
                    value: '50'
                },
                {
                    name: 'resizeImage:75',
                    label: '75%',
                    value: '75'
                }
            ]
        },
        htmlSupport: {
            allow: [
                {
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }
            ]
        },
        language: 'es'
    };

    // Inicializar editores
    document.querySelectorAll('.editor').forEach(textarea => {
        ClassicEditor
            .create(textarea, editorConfig)
            .then(editor => {
                // Add custom upload adapter for base64 images
                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                    return {
                        upload: () => {
                            return loader.file.then(file => new Promise((resolve, reject) => {
                                const reader = new FileReader();
                                reader.onload = () => {
                                    resolve({ default: reader.result });
                                };
                                reader.onerror = error => reject(error);
                                reader.readAsDataURL(file);
                            }));
                        }
                    };
                };
                
                editors[textarea.getAttribute('name')] = editor;
                console.log('CKEditor initialized successfully on:', textarea.getAttribute('name'));
            })
            .catch(error => {
                console.error('Error initializing editor:', error);
            });
    });

    // Setup drop zones
    setupDropZone("drop-main", "imagen", "preview-main", false);
    setupDropZone("drop-video", "video_hero", "preview-video", false);
    setupDropZone("drop-gallery", "galeria", "preview-gallery", true);
    setupDropZone("drop-aliados", "aliados", "preview-aliados", true);
});
</script>

<?php
$content = ob_get_clean();
// No extraJS needed since we inlined it
require APP_PATH . '/Views/layouts/admin.php';
?>
