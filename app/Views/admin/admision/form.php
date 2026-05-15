

<div class="header-container">
    <div class="title-area">
        <h2 class="page-title"><?= isset($proceso) ? 'Editar Proceso' : 'Nuevo Proceso' ?></h2>
        <div class="breadcrumb">
            <a href="<?= url('admin/dashboard') ?>">Dashboard</a> / 
            <a href="<?= url('admin/admision') ?>">Admisión</a> / 
            <span class="current"><?= isset($proceso) ? 'Editar' : 'Nuevo' ?></span>
        </div>
    </div>
</div>

<div class="card-enterprise">
    <div class="card-header-enterprise">
        <h2>
            <i class="fas fa-file-signature"></i> 
            <?= isset($proceso) ? 'Información del Proceso' : 'Datos Generales' ?>
        </h2>
    </div>
    
    <form action="<?= isset($proceso) ? url('admin/admision/update/' . $proceso['id']) : url('admin/admision/store') ?>" method="POST" enctype="multipart/form-data">
        <div class="form-grid">
            
            <!-- Título -->
            <div class="form-group span-2">
                <label class="label-enterprise">Título del Proceso</label>
                <div class="input-group-enterprise">
                    <i class="fas fa-heading"></i>
                    <input type="text" name="titulo" class="input-enterprise" value="<?= e($proceso['titulo'] ?? '') ?>" placeholder="Ej: Admisión 2026-I" required>
                </div>
            </div>

            <!-- Descripción -->
            <div class="form-group span-2">
                <label class="label-enterprise">Descripción General</label>
                <textarea name="descripcion" class="input-enterprise" rows="4" placeholder="Breve descripción del proceso..."><?= e($proceso['descripcion'] ?? '') ?></textarea>
            </div>

            <!-- Fechas -->
            <div class="form-group">
                <label class="label-enterprise">Fecha Inicio</label>
                <div class="input-group-enterprise">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="date" name="fecha_inicio" class="input-enterprise" value="<?= e($proceso['fecha_inicio'] ?? '') ?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="label-enterprise">Fecha Fin</label>
                <div class="input-group-enterprise">
                    <i class="fas fa-calendar-check"></i>
                    <input type="date" name="fecha_fin" class="input-enterprise" value="<?= e($proceso['fecha_fin'] ?? '') ?>" required>
                </div>
            </div>

            <!-- Banner Upload -->
            <div class="form-group span-2">
                <label class="label-enterprise">Banner Publicitario</label>
                <?php if (!empty($proceso['banner_url'])): ?>
                    <div class="current-image mb-3">
                        <img src="<?= url($proceso['banner_url']) ?>" alt="Banner" style="height: 100px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <p class="file-info">Imagen actual. Sube otra para reemplazarla.</p>
                    </div>
                <?php endif; ?>
                
                <div class="drop-zone" id="drop-zone-banner">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Arrastra y suelta tu imagen aquí o haz clic para buscar</p>
                    <p class="file-info">JPG, PNG o WEBP. Máx 2MB. (1920x600 px recomendado)</p>
                    <input type="file" name="banner_url" id="banner_input" accept="image/*" hidden>
                </div>
                <div id="preview-banner" style="margin-top: 10px; display: none; color: #10b981; font-weight: 500;"></div>
            </div>

            <!-- Calendario Upload -->
            <div class="form-group span-2">
                <label class="label-enterprise">Calendario Académico (Imagen)</label>
                <?php if (!empty($proceso['calendario_url'])): ?>
                    <div class="current-image mb-3">
                        <img src="<?= url($proceso['calendario_url']) ?>" alt="Calendario" style="height: 100px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>
                <?php endif; ?>

                <div class="drop-zone" id="drop-zone-calendar">
                    <i class="fas fa-calendar-plus"></i>
                    <p>Arrastra y suelta el calendario aquí</p>
                    <p class="file-info">JPG, PNG o WEBP. Máx 2MB.</p>
                    <input type="file" name="calendario_url" id="calendar_input" accept="image/*" hidden>
                </div>
                <div id="preview-calendar" style="margin-top: 10px; display: none; color: #10b981; font-weight: 500;"></div>
            </div>

            <!-- Activo -->
            <div class="form-group span-2">
                <div class="checkbox-wrapper-enterprise">
                    <label class="checkbox-container">
                        <input type="checkbox" name="activo" <?= (!empty($proceso['activo'])) ? 'checked' : '' ?>>
                        <span class="checkmark"></span>
                        <span class="checkbox-label">
                            <strong>Activar Proceso Publicamente</strong>
                            <span class="d-block text-muted small" style="margin-top: 2px;">Si activas este proceso, cualquier otro proceso activo se desactivará automáticamente.</span>
                        </span>
                    </label>
                </div>
            </div>

        </div>

        <div class="form-actions">
            <?php if (isset($proceso)): ?>
                <a href="<?= url('admision?id=' . $proceso['id']) ?>" target="_blank" class="btn-cancel" style="margin-right: auto; border-color: var(--primary-color); color: var(--primary-color);">
                    <i class="fas fa-eye"></i> Vista Previa
                </a>
            <?php endif; ?>
            
            <a href="<?= url('admin/admision') ?>" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-enterprise">
                <i class="fas fa-save"></i> Guardar Proceso
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    setupDropZone('drop-zone-banner', 'banner_input', 'preview-banner');
    setupDropZone('drop-zone-calendar', 'calendar_input', 'preview-calendar');
});

function setupDropZone(zoneId, inputId, previewId) {
    const zone = document.getElementById(zoneId);
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);

    if (!zone || !input) return;

    // Click handler
    zone.addEventListener('click', () => input.click());

    // Drag handlers
    zone.addEventListener('dragover', (e) => {
        e.preventDefault();
        zone.classList.add('dragover');
    });

    zone.addEventListener('dragleave', () => {
        zone.classList.remove('dragover');
    });

    zone.addEventListener('drop', (e) => {
        e.preventDefault();
        zone.classList.remove('dragover');
        
        if (e.dataTransfer.files.length > 0) {
            input.files = e.dataTransfer.files;
            handleFileSelect(input.files[0], preview);
        }
    });

    // Input change handler
    input.addEventListener('change', () => {
        if (input.files.length > 0) {
            handleFileSelect(input.files[0], preview);
        }
    });
}

function handleFileSelect(file, previewElement) {
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewElement.style.display = 'block';
            previewElement.innerHTML = `
                <div style="margin-top: 10px; border: 1px solid #e2e8f0; padding: 10px; border-radius: 8px; background: #fff; text-align: center;">
                    <img src="${e.target.result}" style="max-width: 100%; max-height: 250px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);" alt="Vista previa">
                    <p style="margin: 8px 0 0; font-size: 0.9rem; color: #10b981; font-weight: 500;">
                        <i class="fas fa-check-circle"></i> Archivo seleccionado: ${file.name}
                    </p>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    } else {
         previewElement.style.display = 'block';
         previewElement.innerHTML = `<p style="color: red;">El archivo seleccionado no es una imagen válida.</p>`;
    }
}
</script>


