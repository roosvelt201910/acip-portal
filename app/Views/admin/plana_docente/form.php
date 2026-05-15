<?php ob_start(); ?>

<div class="docente-form-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <a href="<?= url('admin/plana-docente') ?>" class="back-link">
                <i class="fas fa-arrow-left"></i>
                <span>Volver al listado</span>
            </a>
            <div class="header-title-group">
                <div class="header-icon">
                    <i class="fas fa-<?= isset($docente) ? 'user-edit' : 'user-plus' ?>"></i>
                </div>
                <div>
                    <h1 class="page-title"><?= $pageTitle ?></h1>
                    <p class="page-subtitle"><?= isset($docente) ? 'Modifique los datos del docente' : 'Complete el formulario para registrar un nuevo docente' ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form Container -->
    <div class="form-container">
        <form action="<?= isset($docente) ? url('admin/plana-docente/actualizar/' . $docente['id']) : url('admin/plana-docente/guardar') ?>" 
              method="POST" 
              enctype="multipart/form-data" 
              class="docente-form"
              id="docenteForm">
            
            <div class="form-grid">
                <!-- Left Column: Main Information -->
                <div class="form-main">
                    
                    <!-- Personal Information Section -->
                    <section class="form-section">
                        <div class="section-header">
                            <div class="section-icon blue">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="section-title">
                                <h2>Información Personal</h2>
                                <p>Datos básicos del docente</p>
                            </div>
                        </div>
                        
                        <div class="section-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label required">
                                        <span>Nombre Completo</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <i class="fas fa-id-card"></i>
                                        </div>
                                        <input type="text" 
                                               name="nombre" 
                                               class="form-input" 
                                               value="<?= htmlspecialchars($docente['nombre'] ?? '') ?>" 
                                               placeholder="Ingrese nombre completo del docente"
                                               required>
                                    </div>
                                    <span class="input-hint">Ingrese nombres y apellidos completos</span>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <span>Cargo</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <i class="fas fa-briefcase"></i>
                                        </div>
                                        <input type="text" 
                                               name="cargo" 
                                               class="form-input" 
                                               value="<?= htmlspecialchars($docente['cargo'] ?? 'Docente') ?>"
                                               placeholder="Ej: Docente, Coordinador, etc.">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <span>Programa de Estudios</span>
                                </label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <select name="programa_id" class="form-input form-select">
                                        <option value="">-- Ninguno (General) --</option>
                                        <?php foreach ($programas as $prog): ?>
                                            <option value="<?= $prog['id'] ?>" <?= (isset($docente) && $docente['programa_id'] == $prog['id']) ? 'selected' : '' ?>>
                                                <?= e($prog['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="select-arrow">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                                <span class="input-hint">Seleccione el programa al que pertenece el docente</span>
                            </div>
                        </div>
                    </section>

                    <!-- Documents Section -->
                    <section class="form-section">
                        <div class="section-header">
                            <div class="section-icon purple">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <div class="section-title">
                                <h2>Documentos</h2>
                                <p>Archivos y documentación del docente</p>
                            </div>
                        </div>
                        
                        <div class="section-body">
                            <div class="documents-grid">
                                <!-- CV Upload -->
                                <div class="document-card">
                                    <div class="document-header">
                                        <div class="document-icon red">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>
                                        <div class="document-info">
                                            <h4>Curriculum Vitae</h4>
                                            <span>Formato PDF</span>
                                        </div>
                                        <?php if (isset($docente['cv']) && $docente['cv']): ?>
                                            <span class="document-status uploaded">
                                                <i class="fas fa-check-circle"></i>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if (isset($docente['cv']) && $docente['cv']): ?>
                                        <div class="document-current">
                                            <a href="<?= url($docente['cv']) ?>" target="_blank" class="current-file-link">
                                                <i class="fas fa-eye"></i>
                                                <span>Ver CV actual</span>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="document-upload">
                                        <input type="file" name="cv" id="cv_file" accept=".pdf" class="file-input">
                                        <label for="cv_file" class="upload-label">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <span><?= (isset($docente['cv']) && $docente['cv']) ? 'Reemplazar archivo' : 'Seleccionar archivo' ?></span>
                                        </label>
                                        <span class="file-name" id="cv_name"></span>
                                    </div>
                                </div>

                                <!-- Carga Horaria Upload -->
                                <div class="document-card">
                                    <div class="document-header">
                                        <div class="document-icon green">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <div class="document-info">
                                            <h4>Carga Horaria</h4>
                                            <span>PDF o Imagen</span>
                                        </div>
                                        <?php if (isset($docente['carga_horaria']) && $docente['carga_horaria']): ?>
                                            <span class="document-status uploaded">
                                                <i class="fas fa-check-circle"></i>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if (isset($docente['carga_horaria']) && $docente['carga_horaria']): ?>
                                        <div class="document-current">
                                            <a href="<?= url($docente['carga_horaria']) ?>" target="_blank" class="current-file-link">
                                                <i class="fas fa-eye"></i>
                                                <span>Ver documento actual</span>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="document-upload">
                                        <input type="file" name="carga_horaria" id="carga_file" accept=".pdf,image/*" class="file-input">
                                        <label for="carga_file" class="upload-label">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <span><?= (isset($docente['carga_horaria']) && $docente['carga_horaria']) ? 'Reemplazar archivo' : 'Seleccionar archivo' ?></span>
                                        </label>
                                        <span class="file-name" id="carga_name"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Settings Section -->
                    <section class="form-section">
                        <div class="section-header">
                            <div class="section-icon gray">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="section-title">
                                <h2>Configuración</h2>
                                <p>Opciones de visualización</p>
                            </div>
                        </div>
                        
                        <div class="section-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span>Orden de visualización</span>
                                    </label>
                                    <div class="input-wrapper small">
                                        <div class="input-icon">
                                            <i class="fas fa-sort-numeric-up"></i>
                                        </div>
                                        <input type="number" 
                                               name="orden" 
                                               class="form-input" 
                                               value="<?= $docente['orden'] ?? 0 ?>"
                                               min="0">
                                    </div>
                                    <span class="input-hint">Menor número = mayor prioridad</span>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <span>Estado del registro</span>
                                    </label>
                                    <div class="toggle-wrapper">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="activo" <?= (!isset($docente) || $docente['activo']) ? 'checked' : '' ?>>
                                            <span class="toggle-slider"></span>
                                        </label>
                                        <span class="toggle-label">
                                            <span class="status-active">Activo</span>
                                            <span class="status-inactive">Inactivo</span>
                                        </span>
                                    </div>
                                    <span class="input-hint">Los docentes inactivos no se mostrarán en la página pública</span>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Right Column: Photo & Preview -->
                <div class="form-sidebar">
                    <div class="sidebar-sticky">
                        <!-- Photo Upload Card -->
                        <div class="photo-card">
                            <div class="photo-header">
                                <h3>Foto de Perfil</h3>
                                <span class="photo-hint">JPG, PNG o WEBP</span>
                            </div>
                            
                            <div class="photo-preview" id="photoPreview">
                                <?php if (isset($docente['foto']) && $docente['foto']): ?>
                                    <img src="<?= url($docente['foto']) ?>" alt="Foto actual" id="previewImage">
                                <?php else: ?>
                                    <div class="photo-placeholder" id="photoPlaceholder">
                                        <i class="fas fa-user"></i>
                                        <span>Sin foto</span>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="photo-overlay">
                                    <i class="fas fa-camera"></i>
                                    <span>Cambiar foto</span>
                                </div>
                            </div>
                            
                            <input type="file" name="foto" id="foto_input" accept="image/*" class="file-input">
                            
                            <div class="photo-actions">
                                <button type="button" class="btn-photo-upload" onclick="document.getElementById('foto_input').click()">
                                    <i class="fas fa-upload"></i>
                                    <span>Subir Foto</span>
                                </button>
                                <?php if (isset($docente['foto']) && $docente['foto']): ?>
                                    <button type="button" class="btn-photo-remove" onclick="removePhoto()">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                            
                            <div class="photo-tips">
                                <p><i class="fas fa-info-circle"></i> Recomendaciones:</p>
                                <ul>
                                    <li>Foto tipo carnet o formal</li>
                                    <li>Fondo claro preferiblemente</li>
                                    <li>Resolución mínima 300x300px</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Quick Info Card -->
                        <?php if (isset($docente)): ?>
                        <div class="info-card">
                            <h4>Información del registro</h4>
                            <div class="info-item">
                                <span class="info-label">ID</span>
                                <span class="info-value">#<?= $docente['id'] ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Creado</span>
                                <span class="info-value"><?= date('d/m/Y', strtotime($docente['created_at'] ?? 'now')) ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Actualizado</span>
                                <span class="info-value"><?= date('d/m/Y H:i', strtotime($docente['updated_at'] ?? 'now')) ?></span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit">
                            <div class="btn-content">
                                <i class="fas fa-save"></i>
                                <span><?= isset($docente) ? 'Actualizar Docente' : 'Guardar Docente' ?></span>
                            </div>
                            <div class="btn-loader">
                                <div class="spinner"></div>
                            </div>
                        </button>
                        
                        <a href="<?= url('admin/plana-docente') ?>" class="btn-cancel">
                            <i class="fas fa-times"></i>
                            <span>Cancelar</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
/* ============================================
   CSS Variables
   ============================================ */
:root {
    --primary: #2563eb;
    --primary-dark: #1d4ed8;
    --primary-light: #dbeafe;
    
    --success: #10b981;
    --success-light: #d1fae5;
    
    --danger: #ef4444;
    --danger-light: #fee2e2;
    
    --warning: #f59e0b;
    --warning-light: #fef3c7;
    
    --purple: #8b5cf6;
    --purple-light: #ede9fe;
    
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
    
    --radius-sm: 6px;
    --radius-md: 10px;
    --radius-lg: 14px;
    --radius-xl: 20px;
    
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    
    --transition: 200ms ease;
}

/* ============================================
   Base Styles
   ============================================ */
.docente-form-page {
    background: var(--gray-50);
    min-height: 100vh;
    padding-bottom: 3rem;
}

/* ============================================
   Page Header
   ============================================ */
.page-header {
    background: white;
    border-bottom: 1px solid var(--gray-200);
    padding: 1.5rem 2rem;
    margin-bottom: 2rem;
}

.header-content {
    max-width: 1400px;
    margin: 0 auto;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-500);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 1rem;
    transition: color var(--transition);
}

.back-link:hover {
    color: var(--primary);
}

.header-title-group {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 4px 14px -3px rgba(37, 99, 235, 0.4);
}

.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0;
}

.page-subtitle {
    font-size: 0.9rem;
    color: var(--gray-500);
    margin: 0.25rem 0 0;
}

/* ============================================
   Form Container
   ============================================ */
.form-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 2rem;
    align-items: start;
}

@media (max-width: 1024px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}

/* ============================================
   Form Sections
   ============================================ */
.form-section {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    margin-bottom: 1.5rem;
    border: 1px solid var(--gray-100);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 1.5rem;
    background: var(--gray-50);
    border-bottom: 1px solid var(--gray-100);
}

.section-icon {
    width: 44px;
    height: 44px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.section-icon.blue {
    background: var(--primary-light);
    color: var(--primary);
}

.section-icon.purple {
    background: var(--purple-light);
    color: var(--purple);
}

.section-icon.gray {
    background: var(--gray-200);
    color: var(--gray-600);
}

.section-title h2 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
}

.section-title p {
    font-size: 0.8rem;
    color: var(--gray-500);
    margin: 0.15rem 0 0;
}

.section-body {
    padding: 1.5rem;
}

/* ============================================
   Form Elements
   ============================================ */
.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-group:last-child {
    margin-bottom: 0;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
}

.form-label.required span::after {
    content: ' *';
    color: var(--danger);
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-wrapper.small {
    max-width: 150px;
}

.input-icon {
    position: absolute;
    left: 1rem;
    color: var(--gray-400);
    font-size: 0.9rem;
    pointer-events: none;
    transition: color var(--transition);
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-md);
    font-size: 0.95rem;
    color: var(--gray-800);
    background: white;
    transition: all var(--transition);
}

.form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
}

.form-input:focus + .input-icon,
.input-wrapper:focus-within .input-icon {
    color: var(--primary);
}

.form-input::placeholder {
    color: var(--gray-400);
}

.form-select {
    appearance: none;
    padding-right: 2.5rem;
    cursor: pointer;
}

.select-arrow {
    position: absolute;
    right: 1rem;
    color: var(--gray-400);
    pointer-events: none;
    font-size: 0.75rem;
}

.input-hint {
    display: block;
    margin-top: 0.4rem;
    font-size: 0.75rem;
    color: var(--gray-500);
}

/* ============================================
   Documents Grid
   ============================================ */
.documents-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

@media (max-width: 768px) {
    .documents-grid {
        grid-template-columns: 1fr;
    }
}

.document-card {
    background: var(--gray-50);
    border: 2px dashed var(--gray-200);
    border-radius: var(--radius-lg);
    padding: 1.25rem;
    transition: all var(--transition);
}

.document-card:hover {
    border-color: var(--gray-300);
    background: white;
}

.document-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.document-icon {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.document-icon.red {
    background: var(--danger-light);
    color: var(--danger);
}

.document-icon.green {
    background: var(--success-light);
    color: var(--success);
}

.document-info {
    flex: 1;
}

.document-info h4 {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
}

.document-info span {
    font-size: 0.75rem;
    color: var(--gray-500);
}

.document-status {
    font-size: 1.1rem;
}

.document-status.uploaded {
    color: var(--success);
}

.document-current {
    margin-bottom: 0.75rem;
}

.current-file-link {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.75rem;
    background: white;
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-sm);
    font-size: 0.8rem;
    color: var(--primary);
    text-decoration: none;
    transition: all var(--transition);
}

.current-file-link:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.document-upload {
    position: relative;
}

.file-input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.upload-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.6rem 1rem;
    background: white;
    border: 1px solid var(--gray-300);
    border-radius: var(--radius-md);
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--gray-600);
    cursor: pointer;
    transition: all var(--transition);
}

.upload-label:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: var(--primary-light);
}

.file-name {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.75rem;
    color: var(--success);
    font-weight: 500;
    text-align: center;
}

/* ============================================
   Toggle Switch
   ============================================ */
.toggle-wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.toggle-switch {
    position: relative;
    width: 52px;
    height: 28px;
    cursor: pointer;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    inset: 0;
    background: var(--gray-300);
    border-radius: 50px;
    transition: all var(--transition);
}

.toggle-slider::before {
    content: '';
    position: absolute;
    width: 22px;
    height: 22px;
    left: 3px;
    top: 3px;
    background: white;
    border-radius: 50%;
    box-shadow: var(--shadow-sm);
    transition: all var(--transition);
}

.toggle-switch input:checked + .toggle-slider {
    background: var(--success);
}

.toggle-switch input:checked + .toggle-slider::before {
    transform: translateX(24px);
}

.toggle-label {
    font-size: 0.875rem;
    font-weight: 500;
}

.toggle-label .status-inactive {
    display: inline;
    color: var(--gray-500);
}

.toggle-label .status-active {
    display: none;
    color: var(--success);
}

.toggle-switch input:checked ~ .toggle-label .status-inactive,
.toggle-wrapper:has(input:checked) .status-inactive {
    display: none;
}

.toggle-switch input:checked ~ .toggle-label .status-active,
.toggle-wrapper:has(input:checked) .status-active {
    display: inline;
}

/* ============================================
   Sidebar
   ============================================ */
.form-sidebar {
    position: relative;
}

.sidebar-sticky {
    position: sticky;
    top: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* Photo Card */
.photo-card {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    border: 1px solid var(--gray-100);
}

.photo-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.25rem;
    background: var(--gray-50);
    border-bottom: 1px solid var(--gray-100);
}

.photo-header h3 {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
}

.photo-hint {
    font-size: 0.75rem;
    color: var(--gray-500);
}

.photo-preview {
    position: relative;
    aspect-ratio: 1;
    background: var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    overflow: hidden;
}

.photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-400);
}

.photo-placeholder i {
    font-size: 4rem;
}

.photo-placeholder span {
    font-size: 0.9rem;
    font-weight: 500;
}

.photo-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    color: white;
    opacity: 0;
    transition: opacity var(--transition);
}

.photo-overlay i {
    font-size: 1.5rem;
}

.photo-overlay span {
    font-size: 0.85rem;
    font-weight: 500;
}

.photo-preview:hover .photo-overlay {
    opacity: 1;
}

.photo-actions {
    display: flex;
    gap: 0.5rem;
    padding: 1rem 1.25rem;
}

.btn-photo-upload {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.65rem 1rem;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all var(--transition);
}

.btn-photo-upload:hover {
    background: var(--primary-dark);
}

.btn-photo-remove {
    width: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--danger-light);
    color: var(--danger);
    border: none;
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: all var(--transition);
}

.btn-photo-remove:hover {
    background: var(--danger);
    color: white;
}

.photo-tips {
    padding: 1rem 1.25rem;
    background: var(--gray-50);
    border-top: 1px solid var(--gray-100);
}

.photo-tips p {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--gray-600);
    margin: 0 0 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.photo-tips ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.photo-tips li {
    font-size: 0.75rem;
    color: var(--gray-500);
    padding-left: 1rem;
    position: relative;
    margin-bottom: 0.25rem;
}

.photo-tips li::before {
    content: '•';
    position: absolute;
    left: 0;
    color: var(--gray-400);
}

/* Info Card */
.info-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 1.25rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-100);
}

.info-card h4 {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--gray-700);
    margin: 0 0 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid var(--gray-100);
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.4rem 0;
}

.info-label {
    font-size: 0.8rem;
    color: var(--gray-500);
}

.info-value {
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--gray-700);
}

/* Submit Button */
.btn-submit {
    position: relative;
    width: 100%;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    border: none;
    border-radius: var(--radius-lg);
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    overflow: hidden;
    transition: all var(--transition);
    box-shadow: 0 4px 14px -3px rgba(37, 99, 235, 0.4);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px -3px rgba(37, 99, 235, 0.5);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-loader {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: inherit;
    opacity: 0;
    pointer-events: none;
}

.btn-submit.loading .btn-content {
    opacity: 0;
}

.btn-submit.loading .btn-loader {
    opacity: 1;
}

.spinner {
    width: 24px;
    height: 24px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.btn-cancel {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: white;
    color: var(--gray-600);
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-lg);
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all var(--transition);
}

.btn-cancel:hover {
    background: var(--gray-50);
    border-color: var(--gray-300);
    color: var(--gray-700);
}

/* ============================================
   Responsive
   ============================================ */
@media (max-width: 1024px) {
    .form-sidebar {
        order: -1;
    }
    
    .sidebar-sticky {
        position: relative;
        top: 0;
    }
    
    .photo-preview {
        max-height: 300px;
    }
}

@media (max-width: 768px) {
    .page-header {
        padding: 1rem 1.5rem;
    }
    
    .form-container {
        padding: 0 1rem;
    }
    
    .header-icon {
        width: 48px;
        height: 48px;
        font-size: 1.25rem;
    }
    
    .page-title {
        font-size: 1.25rem;
    }
    
    .section-body {
        padding: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Photo preview
    const photoInput = document.getElementById('foto_input');
    const photoPreview = document.getElementById('photoPreview');
    const placeholder = document.getElementById('photoPlaceholder');
    
    photoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let img = photoPreview.querySelector('img');
                if (!img) {
                    img = document.createElement('img');
                    img.id = 'previewImage';
                    if (placeholder) placeholder.remove();
                    photoPreview.insertBefore(img, photoPreview.firstChild);
                }
                img.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Click on preview to upload
    photoPreview.addEventListener('click', function() {
        photoInput.click();
    });

    // File name display for document uploads
    const fileInputs = ['cv_file', 'carga_file'];
    fileInputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        const nameId = inputId.replace('_file', '_name');
        const nameEl = document.getElementById(nameId);
        
        if (input && nameEl) {
            input.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    nameEl.textContent = '✓ ' + this.files[0].name;
                } else {
                    nameEl.textContent = '';
                }
            });
        }
    });

    // Form submission with loading state
    const form = document.getElementById('docenteForm');
    const submitBtn = form.querySelector('.btn-submit');
    
    form.addEventListener('submit', function() {
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
    });

    // Toggle label update
    const toggleInput = document.querySelector('.toggle-switch input');
    const toggleLabel = document.querySelector('.toggle-label');
    
    if (toggleInput && toggleLabel) {
        toggleInput.addEventListener('change', function() {
            // Label updates via CSS :has() selector
        });
    }
});

function removePhoto() {
    if (confirm('¿Está seguro de eliminar la foto?')) {
        const preview = document.getElementById('photoPreview');
        const img = preview.querySelector('img');
        if (img) {
            img.remove();
            const placeholder = document.createElement('div');
            placeholder.className = 'photo-placeholder';
            placeholder.id = 'photoPlaceholder';
            placeholder.innerHTML = '<i class="fas fa-user"></i><span>Sin foto</span>';
            preview.insertBefore(placeholder, preview.firstChild);
        }
        // Add hidden input to mark photo for deletion
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'eliminar_foto';
        hiddenInput.value = '1';
        document.getElementById('docenteForm').appendChild(hiddenInput);
    }
}
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>