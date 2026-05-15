<?php ob_start(); ?>
<div class="header-container">
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Inicio</a>
        <span>/</span>
        <a href="<?= url('admin/banners') ?>">Banners</a>
        <span>/</span>
        <span class="current">Editar Banner</span>
    </div>
</div>

<div class="card-enterprise">
    <div class="card-header-enterprise">
        <h2><i class="fas fa-edit"></i> Editar Banner</h2>
        <p class="subtitle">Modifica la información del banner seleccionado.</p>
    </div>

    <form action="<?= url('admin/banners/editar/' . $banner['id']) ?>" method="POST" enctype="multipart/form-data">
        <div class="form-grid">
            <!-- Columna Izquierda -->
            <div class="form-column">
                <div class="form-group">
                    <label class="label-enterprise">Título del Banner <span class="required">*</span></label>
                    <div class="input-group-enterprise">
                        <i class="fas fa-heading"></i>
                        <input type="text" name="titulo" class="input-enterprise" value="<?= e($banner['titulo']) ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="label-enterprise">Descripción</label>
                    <textarea name="descripcion" class="input-enterprise" rows="4"><?= e($banner['descripcion']) ?></textarea>
                </div>

                <div class="form-group">
                    <label class="label-enterprise">Enlace de Acción</label>
                    <div class="input-group-enterprise">
                        <i class="fas fa-link"></i>
                        <input type="text" name="enlace" class="input-enterprise" value="<?= e($banner['enlace']) ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="label-enterprise">Texto del Botón</label>
                            <input type="text" name="boton_texto" class="input-enterprise" value="<?= e($banner['boton_texto']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="label-enterprise">Orden</label>
                            <input type="number" name="orden" class="input-enterprise" value="<?= e($banner['orden']) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 20px;">
                     <label class="checkbox-container">
                        <input type="checkbox" name="activo" <?= $banner['activo'] ? 'checked' : '' ?>>
                        <span class="checkmark"></span>
                        <span class="checkbox-label">Banner Activado (Visible al público)</span>
                    </label>
                </div>
            </div>

            <!-- Columna Derecha - Multimedia -->
            <div class="form-column">
                 <div class="form-group">
                    <label class="label-enterprise">Tipo de Contenido</label>
                    <div class="input-group-enterprise">
                        <i class="fas fa-photo-video"></i>
                        <select name="tipo_multimedia" id="tipoMultimedia" class="input-enterprise" onchange="toggleBannerFields()">
                            <option value="imagen" <?= (!isset($banner['tipo_multimedia']) || $banner['tipo_multimedia'] === 'imagen') ? 'selected' : '' ?>>Imagen</option>
                            <option value="video" <?= (isset($banner['tipo_multimedia']) && $banner['tipo_multimedia'] === 'video') ? 'selected' : '' ?>>Video (URL)</option>
                        </select>
                    </div>
                 </div>

                 <div id="videoField" class="form-group" style="display: none;">
                    <label class="label-enterprise">URL del Video (YouTube/Vimeo/MP4)</label>
                    <div class="input-group-enterprise">
                        <i class="fas fa-play-circle"></i>
                        <input type="text" name="video_url" class="input-enterprise" placeholder="https://youtube.com/..." value="<?= e($banner['video_url'] ?? '') ?>">
                    </div>
                 </div>

                 <div id="imageField" class="form-group">
                     <label class="label-enterprise">Imagen del Banner</label>
                     <div class="image-upload-wrapper">
                        <div class="drop-zone" id="drop-main">
                            <input type="file" name="imagen" id="imagen" class="hidden" accept="image/*" style="display:none;">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Arrastra nueva imagen para cambiar, o <span class="highlight-text">clic para buscar</span></p>
                            <p class="file-info">Dejar vacío para mantener la actual.</p>
                            <div id="preview-main" class="preview-grid" style="grid-template-columns: 1fr; margin-top: 15px;">
                                <?php if ($banner['imagen']): ?>
                                    <div class="preview-item">
                                        <img src="<?= url('uploads/banners/' . e($banner['imagen'])) ?>" style="width:100%; height:auto;">
                                        <p style="text-align:center; font-size:12px; color:#666;">Imagen Actual</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                     </div>
                 </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="button" class="btn-cancel" onclick="window.location.href='<?= url('admin/banners') ?>'">Cancelar</button>
            <button type="submit" class="btn-enterprise">
                <i class="fas fa-save mr-2"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>

<script>
function setupDropZone(dropZoneId, inputId, previewId) {
    const dropZone = document.getElementById(dropZoneId);
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    
    if(!dropZone) return;

    dropZone.addEventListener("click", () => input.click());
    
    input.addEventListener("change", () => {
        handleFiles(input.files, preview);
    });
    
    ["dragenter", "dragover", "dragleave", "drop"].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
        }, false);
    });
    
    dropZone.addEventListener("dragover", () => dropZone.classList.add("dragover"));
    dropZone.addEventListener("dragleave", () => dropZone.classList.remove("dragover"));
    dropZone.addEventListener("drop", (e) => {
        dropZone.classList.remove("dragover");
        const dt = e.dataTransfer;
        const files = dt.files;
        input.files = files; // Ensure assignment
        handleFiles(files, preview);
    });
}

function handleFiles(files, previewContainer) {
    if(files.length > 0) previewContainer.innerHTML = "";
    [...files].forEach(file => {
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = () => {
                const div = document.createElement("div");
                div.className = "preview-item";
                div.innerHTML = `<img src="${reader.result}" style="width:100%; height:auto;">`;
                previewContainer.appendChild(div);
            }
        }
    });
}


function toggleBannerFields() {
    const type = document.getElementById('tipoMultimedia').value;
    const videoField = document.getElementById('videoField');
    const imageField = document.getElementById('imageField');
    
    if (type === 'video') {
        videoField.style.display = 'block';
        imageField.style.display = 'none';
        document.querySelector('input[name="video_url"]').required = true;
    } else {
        videoField.style.display = 'none';
        imageField.style.display = 'block';
        document.querySelector('input[name="video_url"]').required = false;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    setupDropZone("drop-main", "imagen", "preview-main");
    toggleBannerFields();

    // SweetAlert Success Check
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        Swal.fire({
            icon: 'success',
            title: '¡Guardado!',
            text: 'El banner ha sido actualizado correctamente.',
            timer: 2000,
            showConfirmButton: false
        });
    }
});
</script>

<?php
$content = ob_get_clean();
$extraJS = '
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
';
require APP_PATH . '/Views/layouts/admin.php';
?>
