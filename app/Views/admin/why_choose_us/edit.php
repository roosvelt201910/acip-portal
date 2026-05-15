<?php ob_start(); ?>
<style>
:root {
    --primary-color: #4f46e5;
    --primary-hover: #4338ca;
    --secondary-color: #64748b;
    --success-color: #10b981;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --dark: #1e293b;
    --light: #f8fafc;
    --border-color: #e2e8f0;
    --text-primary: #0f172a;
    --text-secondary: #64748b;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --radius-sm: 6px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    box-sizing: border-box;
}

/* Header Container */
.header-container {
    margin-bottom: 2rem;
    animation: slideDown 0.5s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    background: white;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    font-size: 0.875rem;
}

.breadcrumb a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.breadcrumb a::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--primary-color);
    transition: width 0.3s ease;
}

.breadcrumb a:hover::after {
    width: 100%;
}

.breadcrumb span {
    color: var(--text-secondary);
}

.breadcrumb .current {
    color: var(--text-primary);
    font-weight: 600;
}

/* Card Enterprise */
.card-enterprise {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card-header-enterprise {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    background: linear-gradient(135deg, var(--warning-color) 0%, #ea580c 100%);
    color: white;
    border-bottom: 4px solid rgba(255, 255, 255, 0.1);
}

.card-header-enterprise h2 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-header-enterprise h2 i {
    font-size: 1.25rem;
    opacity: 0.9;
}

.header-actions {
    display: flex;
    gap: 0.75rem;
}

/* Card Body */
.card-body-enterprise {
    padding: 2.5rem;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

/* Form Label */
.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-label.required::after {
    content: '*';
    color: var(--danger-color);
    margin-left: 0.25rem;
    font-size: 1rem;
}

/* Form Controls */
.form-control-enterprise {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    font-size: 0.9375rem;
    color: var(--text-primary);
    background: var(--light);
    transition: var(--transition);
    font-family: inherit;
}

.form-control-enterprise:focus {
    outline: none;
    border-color: var(--warning-color);
    background: white;
    box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
}

.form-control-enterprise::placeholder {
    color: var(--text-secondary);
    opacity: 0.6;
}

textarea.form-control-enterprise {
    resize: vertical;
    min-height: 120px;
}

/* Current Image Display */
.current-image-container {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
    padding: 1rem;
    background: var(--light);
    border-radius: var(--radius-md);
    border: 2px solid var(--border-color);
}

.current-image-badge {
    position: absolute;
    top: -10px;
    left: 10px;
    background: var(--warning-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    box-shadow: var(--shadow-md);
}

.current-image-container img {
    display: block;
    max-width: 250px;
    max-height: 250px;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-md);
    transition: var(--transition);
}

.current-image-container img:hover {
    transform: scale(1.02);
    box-shadow: var(--shadow-lg);
}

/* Image Upload Container */
.image-upload-container {
    position: relative;
}

.file-input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.file-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    border: 2px dashed var(--border-color);
    border-radius: var(--radius-md);
    background: var(--light);
    cursor: pointer;
    transition: var(--transition);
    text-align: center;
}

.file-label:hover {
    border-color: var(--warning-color);
    background: rgba(245, 158, 11, 0.05);
}

.file-label i {
    font-size: 2.5rem;
    color: var(--warning-color);
    margin-bottom: 0.5rem;
}

.file-label span {
    font-weight: 500;
    color: var(--text-secondary);
}

.file-label small {
    color: var(--text-secondary);
    margin-top: 0.5rem;
    font-size: 0.75rem;
}

.image-preview {
    margin-top: 1rem;
    text-align: center;
}

.image-preview img {
    border: 3px solid var(--border-color);
    box-shadow: var(--shadow-md);
    transition: var(--transition);
}

.image-preview img:hover {
    transform: scale(1.05);
    box-shadow: var(--shadow-lg);
}

/* Switch Container */
.switch-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--light);
    border-radius: var(--radius-md);
    border: 2px solid var(--border-color);
    cursor: pointer;
    transition: var(--transition);
}

.switch-container:hover {
    border-color: var(--success-color);
    background: rgba(16, 185, 129, 0.05);
}

.switch-container input[type="checkbox"] {
    position: absolute;
    opacity: 0;
}

.switch-slider {
    position: relative;
    width: 52px;
    height: 28px;
    background: var(--secondary-color);
    border-radius: 28px;
    transition: var(--transition);
    flex-shrink: 0;
}

.switch-slider::before {
    content: '';
    position: absolute;
    top: 3px;
    left: 3px;
    width: 22px;
    height: 22px;
    background: white;
    border-radius: 50%;
    transition: var(--transition);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.switch-container input[type="checkbox"]:checked ~ .switch-slider {
    background: var(--success-color);
}

.switch-container input[type="checkbox"]:checked ~ .switch-slider::before {
    transform: translateX(24px);
}

.switch-label {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.9375rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Buttons */
.btn-enterprise {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 0.9375rem;
    text-decoration: none;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
    font-family: inherit;
}

.btn-enterprise:not(.btn-secondary):not(.btn-cancel) {
    background: linear-gradient(135deg, var(--warning-color) 0%, #ea580c 100%);
    color: white;
}

.btn-enterprise:not(.btn-secondary):not(.btn-cancel):hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-enterprise:not(.btn-secondary):not(.btn-cancel):active {
    transform: translateY(0);
}

.btn-enterprise.btn-secondary {
    background: white;
    color: var(--text-primary);
    border: 2px solid var(--border-color);
}

.btn-enterprise.btn-secondary:hover {
    background: var(--light);
    border-color: var(--warning-color);
    color: var(--warning-color);
}

.btn-enterprise.btn-cancel {
    background: white;
    color: var(--text-secondary);
    border: 2px solid var(--border-color);
}

.btn-enterprise.btn-cancel:hover {
    background: var(--danger-color);
    color: white;
    border-color: var(--danger-color);
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 2px solid var(--border-color);
}

/* Image Preview with Remove Button */
.preview-container {
    position: relative;
    display: inline-block;
}

.remove-preview-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: var(--danger-color);
    color: white;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-md);
    transition: var(--transition);
}

.remove-preview-btn:hover {
    transform: scale(1.1);
    background: #dc2626;
}

.file-name-display {
    margin-top: 8px;
    font-size: 0.875rem;
    color: var(--text-secondary);
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .card-body-enterprise {
        padding: 1.5rem;
    }
    
    .card-header-enterprise {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-enterprise {
        width: 100%;
        justify-content: center;
    }

    .current-image-container img {
        max-width: 100%;
    }
}

/* Loading Animation */
.btn-enterprise.loading {
    pointer-events: none;
    opacity: 0.7;
    position: relative;
}

.btn-enterprise.loading::after {
    content: '';
    position: absolute;
    right: 1rem;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Focus Visible */
*:focus-visible {
    outline: 2px solid var(--warning-color);
    outline-offset: 2px;
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
}

/* MB helper */
.mb-2 {
    margin-bottom: 0.5rem;
}
</style>

<div class="header-container">
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">
            <i class="fas fa-home"></i> Inicio
        </a>
        <span>/</span>
        <a href="<?= url('admin/why-choose-us') ?>">Por qué elegirnos</a>
        <span>/</span>
        <span class="current">Editar Elemento</span>
    </div>
</div>

<div class="card-enterprise">
    <div class="card-header-enterprise">
        <h2>
            <i class="fas fa-edit"></i>
            Editar Elemento
        </h2>
        <div class="header-actions">
            <a href="<?= url('admin/why-choose-us') ?>" class="btn-enterprise btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="card-body-enterprise">
        <form action="<?= url('admin/why-choose-us/update/' . $item['id']) ?>" method="POST" enctype="multipart/form-data" id="formEditWhyChooseUs">
            <div class="form-grid">
                <!-- Título -->
                <div class="form-group full-width">
                    <label class="form-label required">Título</label>
                    <input type="text" 
                           name="titulo" 
                           class="form-control-enterprise" 
                           required 
                           value="<?= e($item['titulo']) ?>"
                           maxlength="100"
                           placeholder="Ej: Docentes Calificados">
                </div>

                <!-- Descripción -->
                <div class="form-group full-width">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" 
                              class="form-control-enterprise" 
                              rows="5"
                              maxlength="500"
                              placeholder="Describe el beneficio o característica que hace que tu institución destaque..."><?= e($item['descripcion']) ?></textarea>
                </div>

                <!-- Imagen/Icono -->
                <div class="form-group">
                    <label class="form-label">Icono / Imagen</label>
                    <div class="image-upload-container">
                        <?php if ($item['imagen']): ?>
                            <div class="current-image-container">
                                <span class="current-image-badge">
                                    <i class="fas fa-image"></i> Imagen Actual
                                </span>
                                <img src="<?= url('uploads/why_choose_us/' . $item['imagen']) ?>" 
                                     alt="Imagen actual"
                                     id="currentImage">
                            </div>
                        <?php endif; ?>
                        
                        <input type="file" 
                               name="imagen" 
                               id="imagen" 
                               class="file-input" 
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" 
                               onchange="previewImage(this)">
                        <label for="imagen" class="file-label">
                            <i class="fas fa-exchange-alt"></i>
                            <span><?= $item['imagen'] ? 'Cambiar imagen' : 'Seleccionar imagen' ?></span>
                            <small>JPG, PNG, SVG (Máx. 2MB)</small>
                        </label>
                        <div id="imagePreview" class="image-preview"></div>
                    </div>
                </div>

                <!-- Orden -->
                <div class="form-group">
                    <label class="form-label">Orden de visualización</label>
                    <input type="number" 
                           name="orden" 
                           class="form-control-enterprise" 
                           value="<?= e($item['orden']) ?>" 
                           min="0"
                           max="999"
                           placeholder="0">
                    <small style="color: var(--text-secondary); margin-top: 0.5rem; font-size: 0.75rem;">
                        Menor número = Mayor prioridad
                    </small>
                </div>

                <!-- Estado -->
                <div class="form-group full-width">
                    <label class="switch-container">
                        <input type="checkbox" name="activo" value="1" <?= $item['activo'] ? 'checked' : '' ?>>
                        <span class="switch-slider"></span>
                        <span class="switch-label">
                            <i class="fas fa-check-circle"></i> Elemento Activo
                        </span>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-enterprise">
                    <i class="fas fa-save"></i> Actualizar Elemento
                </button>
                <a href="<?= url('admin/why-choose-us') ?>" class="btn-enterprise btn-cancel">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const currentImage = document.getElementById('currentImage');
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validar tamaño (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('El archivo es demasiado grande. Máximo 2MB.');
            input.value = '';
            return;
        }
        
        // Ocultar imagen actual si existe
        if (currentImage) {
            currentImage.parentElement.style.opacity = '0.5';
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = document.createElement('div');
            container.className = 'preview-container';
            
            const badge = document.createElement('span');
            badge.className = 'current-image-badge';
            badge.innerHTML = '<i class="fas fa-sparkles"></i> Nueva Imagen';
            
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '250px';
            img.style.maxHeight = '250px';
            img.style.borderRadius = '12px';
            img.style.display = 'block';
            
            const removeBtn = document.createElement('button');
            removeBtn.className = 'remove-preview-btn';
            removeBtn.type = 'button';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.title = 'Eliminar vista previa';
            
            removeBtn.onclick = function() {
                input.value = '';
                preview.innerHTML = '';
                if (currentImage) {
                    currentImage.parentElement.style.opacity = '1';
                }
            };
            
            const fileName = document.createElement('p');
            fileName.className = 'file-name-display';
            fileName.innerHTML = `<i class="fas fa-file-image"></i> ${file.name}`;
            
            container.appendChild(badge);
            container.appendChild(img);
            container.appendChild(removeBtn);
            preview.appendChild(container);
            preview.appendChild(fileName);
        };
        
        reader.readAsDataURL(file);
    } else {
        // Restaurar imagen actual si se cancela la selección
        if (currentImage) {
            currentImage.parentElement.style.opacity = '1';
        }
    }
}

// Validación del formulario y estado de carga
let formSubmitted = false;
document.getElementById('formEditWhyChooseUs').addEventListener('submit', function(e) {
    if (formSubmitted) {
        e.preventDefault();
        return false;
    }
    
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;
    formSubmitted = true;
});

// Confirmación antes de salir si hay cambios sin guardar
const form = document.getElementById('formEditWhyChooseUs');
let formModified = false;

form.addEventListener('change', function() {
    formModified = true;
});

form.addEventListener('submit', function() {
    formModified = false;
});

window.addEventListener('beforeunload', function(e) {
    if (formModified) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// Prevenir que los enlaces de cancelar activen el beforeunload
document.querySelectorAll('.btn-cancel').forEach(btn => {
    btn.addEventListener('click', function() {
        formModified = false;
    });
});
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>