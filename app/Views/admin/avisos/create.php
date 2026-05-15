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

    .drop-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.2s ease;
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

    .preview-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
        margin-top: 16px;
    }
    .preview-item {
        position: relative;
        height: 150px;
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

    .radio-group {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }

    .radio-label {
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: var(--text-color);
    }

    .radio-label input[type="radio"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
</style>

<div class="card-enterprise">
    <div class="card-header-enterprise">
        <h2><i class="fas fa-plus-circle text-gray-400 mr-2"></i> Nuevo Aviso Modal</h2>
        <a href="<?= url('admin/avisos') ?>" class="btn btn-light" style="border: 1px solid #e2e8f0; color: #475569; padding: 8px 16px; border-radius: 6px; font-weight: 500;">
            <i class="fas fa-arrow-left mr-1"></i> Cancelar
        </a>
    </div>

    <form action="<?= url('admin/avisos/crear') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
        
        <div class="form-section">
            <div class="row" style="display: flex; gap: 40px;">
                <div style="flex: 2;">
                    <div class="form-group-enterprise">
                        <label class="label-enterprise">Título del Aviso <span class="text-red-500">*</span></label>
                        <input type="text" name="titulo" class="input-enterprise" placeholder="Ej: Importante: Proceso de Matrícula 2026" required>
                    </div>

                    <div class="form-group-enterprise">
                        <label class="label-enterprise">Tipo de Contenido</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="tipo_contenido" value="imagen" checked onclick="toggleContentType('imagen')">
                                <span>Imagen</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="tipo_contenido" value="video" onclick="toggleContentType('video')">
                                <span>Video</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="tipo_contenido" value="html" onclick="toggleContentType('html')">
                                <span>HTML</span>
                            </label>
                        </div>
                    </div>

                    <div id="content-imagen" class="form-group-enterprise">
                        <label class="label-enterprise">Imagen del Aviso</label>
                        <div class="drop-zone" id="drop-imagen">
                            <input type="file" name="imagen" id="imagen-input" class="hidden" accept="image/*" style="display:none;">
                            <i class="fas fa-image"></i>
                            <p>Arrastra imagen aquí o <span class="highlight-text">clic para subir</span></p>
                            <div id="preview-imagen" class="preview-grid"></div>
                        </div>
                    </div>

                    <div id="content-video" class="form-group-enterprise" style="display: none;">
                        <label class="label-enterprise">URL del Video (YouTube/Vimeo)</label>
                        <input type="url" name="video_url" class="input-enterprise" placeholder="https://youtube.com/...">
                    </div>

                    <div id="content-html" class="form-group-enterprise" style="display: none;">
                        <label class="label-enterprise">Contenido HTML</label>
                        <textarea name="contenido_html" class="input-enterprise" rows="8" placeholder="<div>Tu contenido HTML aquí...</div>"></textarea>
                    </div>
                </div>
                
                <div style="flex: 1;">
                     <div style="background: #f8fafc; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0; position: sticky; top: 20px;">
                        <div class="form-group-enterprise">
                            <label class="label-enterprise">Estado</label>
                            <select name="estado" class="input-enterprise">
                                <option value="activo" selected>Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>

                        <div class="form-group-enterprise">
                            <label class="label-enterprise">Enlace del Botón (Opcional)</label>
                            <input type="url" name="enlace_boton" class="input-enterprise" placeholder="https://...">
                        </div>

                        <div class="form-group-enterprise">
                            <label class="label-enterprise">Texto del Botón</label>
                            <input type="text" name="texto_boton" class="input-enterprise" value="Más información">
                        </div>

                        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #e2e8f0;">

                        <div class="form-group-enterprise">
                            <label class="label-enterprise">
                                <input type="checkbox" name="mostrar_una_vez" value="1" style="margin-right: 8px;">
                                Mostrar solo una vez por sesión
                            </label>
                        </div>

                        <div class="form-group-enterprise">
                            <label class="label-enterprise">Fecha de Inicio (Opcional)</label>
                            <input type="datetime-local" name="fecha_inicio" class="input-enterprise">
                        </div>

                        <div class="form-group-enterprise">
                            <label class="label-enterprise">Fecha de Fin (Opcional)</label>
                            <input type="datetime-local" name="fecha_fin" class="input-enterprise">
                        </div>

                        <div class="form-group-enterprise">
                            <label class="label-enterprise">Orden de Prioridad</label>
                            <input type="number" name="orden" class="input-enterprise" value="0" min="0">
                            <small style="color: #64748b; font-size: 0.8rem;">Mayor número = mayor prioridad</small>
                        </div>
                     </div>
                </div>
            </div>
        </div>

        <div style="padding: 24px 32px; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: right;">
            <button type="submit" class="btn-enterprise">
                <i class="fas fa-save mr-2"></i> Guardar Aviso
            </button>
        </div>
    </form>
</div>

<script>
function toggleContentType(type) {
    document.getElementById('content-imagen').style.display = type === 'imagen' ? 'block' : 'none';
    document.getElementById('content-video').style.display = type === 'video' ? 'block' : 'none';
    document.getElementById('content-html').style.display = type === 'html' ? 'block' : 'none';
}

// Drop Zone Logic
const dropZone = document.getElementById('drop-imagen');
const input = document.getElementById('imagen-input');
const preview = document.getElementById('preview-imagen');

if (dropZone && input) {
    dropZone.addEventListener('click', () => input.click());
    
    input.addEventListener('change', () => {
         if (input.files && input.files[0]) {
             const reader = new FileReader();
             reader.onload = (e) => {
                 preview.innerHTML = `<div class="preview-item"><img src="${e.target.result}"></div>`;
             };
             reader.readAsDataURL(input.files[0]);
         }
    });
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => { e.preventDefault(); e.stopPropagation(); }, false);
    });
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
    });
    
    dropZone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files.length > 0) {
            input.files = files;
            const event = new Event('change');
            input.dispatchEvent(event);
        }
    });
}
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
