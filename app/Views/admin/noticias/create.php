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

    /* Form Elements */
    .form-section {
        padding: 32px;
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
        <h2><i class="fas fa-plus-circle text-gray-400 mr-2"></i> Nueva Noticia</h2>
        <a href="<?= url('admin/noticias') ?>" class="btn btn-light" style="border: 1px solid #e2e8f0; color: #475569; padding: 8px 16px; border-radius: 6px; font-weight: 500;">
            <i class="fas fa-arrow-left mr-1"></i> Cancelar
        </a>
    </div>

    <form action="<?= url('admin/noticias/crear') ?>" method="POST" enctype="multipart/form-data">
        <div class="form-section">
            <div class="row" style="display: flex; gap: 40px;">
                <div style="flex: 2;">
                    <div class="form-group-enterprise">
                        <label class="label-enterprise">Título de la Noticia <span class="text-red-500">*</span></label>
                        <input type="text" name="titulo" class="input-enterprise" placeholder="Ingrese el título principal" required>
                    </div>
                    
                    <div class="form-group-enterprise">
                        <label class="label-enterprise">Resumen Corto <span class="text-red-500">*</span></label>
                        <textarea name="resumen" rows="3" class="input-enterprise" placeholder="Breve introducción para el listado..." required style="resize: vertical;"></textarea>
                    </div>

                    <div class="form-group-enterprise">
                        <label class="label-enterprise">Contenido Completo</label>
                        <textarea name="contenido" class="editor"></textarea>
                    </div>
                </div>
                
                <div style="flex: 1;">
                     <div style="background: #f8fafc; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0; position: sticky; top: 20px;">
                        <div class="form-group-enterprise">
                            <label class="label-enterprise">Estado</label>
                            <select name="estado" class="input-enterprise">
                                <option value="borrador">Borrador</option>
                                <option value="publicado" selected>Publicado</option>
                            </select>
                        </div>

                        <div class="form-group-enterprise">
                            <label class="label-enterprise">Categoría</label>
                            <select name="categoria" class="input-enterprise">
                                <option value="institucional">Institucional</option>
                                <option value="academica">Académica</option>
                                <option value="eventos">Eventos</option>
                                <option value="general">General</option>
                            </select>
                        </div>
                        
                        <div class="form-group-enterprise">
                            <label class="label-enterprise">Fecha de Publicación</label>
                            <input type="datetime-local" name="fecha_publicacion" class="input-enterprise" value="<?= date('Y-m-d\TH:i') ?>">
                        </div>

                        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #e2e8f0;">

                        <div class="form-group-enterprise">
                            <label class="label-enterprise">HERO / ENCABEZADO (Multimedia)</label>
                            <select name="tipo_encabezado" id="tipoEncabezado" class="input-enterprise" onchange="toggleHeaderFields()">
                                <option value="imagen" selected>Imagen Hero</option>
                                <option value="video">Video Hero</option>
                            </select>
                        </div>

                        <div id="videoField" class="form-group-enterprise" style="display: none;">
                            <label class="label-enterprise">Video Hero (URL YouTube/Vimeo)</label>
                            <input type="text" name="video_encabezado" class="input-enterprise" placeholder="https://..." style="margin-bottom: 10px;">
                            
                            <label class="label-enterprise" style="font-size: 0.85rem; color: #64748b;">O subir video (MP4/WebM):</label>
                            <div class="drop-zone" id="drop-video">
                                <input type="file" name="video_file" id="video_file" class="hidden" accept="video/*" style="display:none;">
                                <i class="fas fa-video"></i>
                                <p>Arrastra video aquí o <span class="highlight-text">clic para subir</span></p>
                                <div id="preview-video" class="preview-grid" style="grid-template-columns: 1fr; margin-top: 15px;"></div>
                            </div>
                        </div>

                        <div id="imageField" class="form-group-enterprise">
                            <label class="label-enterprise mb-3">Imagen Hero (Destacada)</label>
                            <div class="drop-zone" id="drop-main">
                                <input type="file" name="imagen" id="imagen" class="hidden" accept="image/*" style="display:none;">
                                <i class="fas fa-camera"></i>
                                <p>Arrastra imagen aquí o <span class="highlight-text">clic para subir</span></p>
                                <div id="preview-main" class="preview-grid" style="grid-template-columns: 1fr; margin-top: 15px;"></div>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>

        <div style="padding: 24px 32px; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: right;">
            <button type="submit" class="btn-enterprise">
                <i class="fas fa-save mr-2"></i> Guardar Noticia
            </button>
        </div>
    </form>
</div>

<!-- CKEditor 5 -->
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">
<script src="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.umd.js"></script>

<style>
    .ck-editor__editable {
        min-height: 300px;
        max-height: 600px;
    }
</style>

<script>
// Drop Zone Logic
function setupDropZone(dropZoneId, inputId, previewId) {
    const dropZone = document.getElementById(dropZoneId);
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    if(!dropZone) return;

    dropZone.addEventListener("click", () => input.click());
    input.addEventListener("change", () => handleFiles(input.files, preview));
    
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
        
        // Ensure files are assigned to the input
        if (files.length > 0) {
            input.files = files;
            console.log("Files assigned to input:", input.files);
            handleFiles(files, preview);
        }
    });
}

function handleFiles(files, previewContainer) {
    previewContainer.innerHTML = "";
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
            const div = document.createElement("div");
            div.className = "preview-item";
            div.style.display = "flex";
            div.style.alignItems = "center";
            div.style.justifyContent = "center";
            div.style.background = "#000";
            div.style.color = "#fff";
            div.innerHTML = `<i class="fas fa-play-circle" style="font-size: 2rem; margin-right: 10px;"></i> <span style="font-size: 0.8rem;">${file.name}</span>`;
            previewContainer.appendChild(div);
        }
    });
}


function toggleHeaderFields() {
    const type = document.getElementById('tipoEncabezado').value;
    const videoField = document.getElementById('videoField');
    const imageField = document.getElementById('imageField');

    if (type === 'video') {
        videoField.style.display = 'block';
        imageField.style.display = 'none';
    } else {
        videoField.style.display = 'none';
        imageField.style.display = 'block';
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    toggleHeaderFields();

    // Video Drop Zone
    setupDropZone("drop-video", "video_file", "preview-video");
    
    // Image Drop Zone
    setupDropZone("drop-main", "imagen", "preview-main");

    // Verificar que CKEditor está disponible
    if (typeof CKEDITOR === 'undefined') {
        console.error('CKEditor 5 no está cargado correctamente');
        return;
    }

    const { ClassicEditor, Essentials, Bold, Italic, Link, List, Paragraph, Heading, BlockQuote, Table, TableToolbar, Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, LinkImage, SourceEditing, MediaEmbed, ImageUpload, SimpleUploadAdapter, Alignment, GeneralHtmlSupport } = CKEDITOR;

    const editorConfig = {
        licenseKey: 'GPL',
        plugins: [ Essentials, Bold, Italic, Link, List, Paragraph, Heading, BlockQuote, Table, TableToolbar, Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, LinkImage, SourceEditing, MediaEmbed, ImageUpload, SimpleUploadAdapter, Alignment, GeneralHtmlSupport ],
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
        toolbar: {
            items: [
                'sourceEditing', '|',
                'heading', '|',
                'bold', 'italic', 'link', 'alignment', '|',
                'bulletedList', 'numberedList', '|',
                'blockQuote', 'insertTable', '|',
                'imageUpload', 'mediaEmbed', '|',
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
        },
        image: {
            toolbar: [
                'imageTextAlternative',
                'toggleImageCaption',
                'imageStyle:inline',
                'imageStyle:block',
                'imageStyle:side'
            ]
        },
        simpleUpload: {
            uploadUrl: '<?= url("admin/upload-image") ?>'
        },
        mediaEmbed: {
            previewsInData: true
        },
        language: 'es'
    };

    document.querySelectorAll('.editor').forEach(textarea => {
        ClassicEditor
            .create(textarea, editorConfig)
            .catch(error => console.error(error));
    });


});
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
