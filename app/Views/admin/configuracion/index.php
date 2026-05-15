<?php ob_start(); ?>

<style>
    /* Page Container */
    .config-page {
        max-width: 1000px;
        margin: 0 auto;
    }
    
    /* Header */
    .config-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    
    .config-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .config-header h1 i {
        color: #6366f1;
    }
    
    .breadcrumb {
        font-size: 13px;
        color: #64748b;
    }
    
    .breadcrumb a {
        color: #6366f1;
        text-decoration: none;
    }
    
    /* Alert */
    .alert-success {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        background: linear-gradient(135deg, #dcfce7, #d1fae5);
        color: #166534;
        border-radius: 12px;
        margin-bottom: 24px;
        border: 1px solid #86efac;
    }
    
    /* Tabs */
    .config-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 24px;
        padding: 6px;
        background: #f1f5f9;
        border-radius: 16px;
    }
    
    .config-tab {
        flex: 1;
        padding: 14px 20px;
        background: transparent;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        color: #64748b;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .config-tab:hover {
        color: #1e293b;
        background: rgba(255,255,255,0.5);
    }
    
    .config-tab.active {
        color: #6366f1;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    /* Tab Content */
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Config Card */
    .config-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    
    .card-header {
        padding: 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .card-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    
    .card-header-icon.purple { background: #ede9fe; color: #7c3aed; }
    .card-header-icon.blue { background: #dbeafe; color: #2563eb; }
    .card-header-icon.pink { background: #fce7f3; color: #db2777; }
    .card-header-icon.green { background: #dcfce7; color: #16a34a; }
    
    .card-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .card-header p {
        font-size: 13px;
        color: #64748b;
        margin-top: 2px;
    }
    
    .card-body {
        padding: 24px;
    }
    
    /* Form Elements */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .form-grid.single {
        grid-template-columns: 1fr;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    
    .form-label i {
        margin-right: 6px;
        color: #6366f1;
    }
    
    .form-control {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 15px;
        color: #1e293b;
        background: #f9fafb;
        transition: all 0.2s ease;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #6366f1;
        background: white;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }
    
    .form-control::placeholder {
        color: #9ca3af;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    
    .form-hint {
        font-size: 12px;
        color: #64748b;
        margin-top: 6px;
    }
    
    /* Drag and Drop Zone */
    .upload-zone {
        border: 2px dashed #d1d5db;
        border-radius: 16px;
        padding: 32px;
        text-align: center;
        background: #fafafa;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .upload-zone:hover,
    .upload-zone.dragover {
        border-color: #6366f1;
        background: #f5f3ff;
    }
    
    .upload-zone.dragover {
        transform: scale(1.01);
    }
    
    .upload-zone-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 16px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
    }
    
    .upload-zone h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }
    
    .upload-zone p {
        font-size: 13px;
        color: #64748b;
    }
    
    .upload-zone input[type="file"] {
        display: none;
    }
    
    /* Preview */
    .preview-container {
        display: none;
        margin-top: 20px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }
    
    .preview-container.has-file {
        display: block;
    }
    
    .preview-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }
    
    .preview-header span {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }
    
    .preview-remove {
        background: #fee2e2;
        color: #dc2626;
        border: none;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .preview-remove:hover {
        background: #fecaca;
    }
    
    .preview-image {
        width: 100%;
        max-width: 300px;
        height: auto;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        background: white;
        padding: 8px;
    }
    
    .preview-info {
        margin-top: 12px;
        display: flex;
        gap: 16px;
    }
    
    .preview-info span {
        font-size: 12px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    /* Current Logo */
    .current-logo {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: #f0fdf4;
        border-radius: 12px;
        border: 1px solid #bbf7d0;
        margin-bottom: 16px;
    }
    
    .current-logo img {
        max-height: 60px;
        border-radius: 8px;
        background: white;
        padding: 8px;
        border: 1px solid #e5e7eb;
    }
    
    .current-logo-info {
        flex: 1;
    }
    
    .current-logo-info strong {
        display: block;
        color: #166534;
        font-size: 14px;
    }
    
    .current-logo-info span {
        font-size: 12px;
        color: #64748b;
    }
    
    /* Toggle Switch */
    .toggle-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px;
        background: linear-gradient(135deg, #fef3c7, #fef9c3);
        border-radius: 12px;
        border: 1px solid #fde047;
    }
    
    .toggle-info h4 {
        font-size: 15px;
        font-weight: 600;
        color: #92400e;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .toggle-info p {
        font-size: 12px;
        color: #a16207;
        margin-top: 4px;
    }
    
    .switch {
        position: relative;
        display: inline-block;
        width: 56px;
        height: 30px;
    }
    
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #d1d5db;
        transition: .4s;
        border-radius: 30px;
    }
    
    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    input:checked + .slider {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }
    
    input:checked + .slider:before {
        transform: translateX(26px);
    }
    
    /* Submit Button */
    .form-footer {
        padding: 24px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
    }
    
    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
        transition: all 0.3s ease;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5);
    }

    /* Social Icons Colors */
    .social-facebook { color: #1877f2; }
    .social-instagram { color: #e4405f; }
    .social-youtube { color: #ff0000; }
    .social-twitter { color: #1da1f2; }
    .social-tiktok { color: #000000; }
    .social-whatsapp { color: #25D366; }
</style>

<div class="config-page">
    <!-- Header -->
    <div class="config-header">
        <h1><i class="fas fa-cogs"></i> Configuración del Sitio</h1>
        <div class="breadcrumb">
            <a href="<?= url('admin') ?>">Dashboard</a> / Configuración
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert-success">
        <i class="fas fa-check-circle"></i>
        <span><?= $_SESSION['success'] ?></span>
    </div>
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <form method="POST" action="<?= url('admin/configuracion') ?>" enctype="multipart/form-data">
        <!-- Tabs -->
        <div class="config-tabs">
            <button type="button" class="config-tab active" onclick="switchTab(0)">
                <i class="fas fa-cog"></i> General
            </button>
            <button type="button" class="config-tab" onclick="switchTab(1)">
                <i class="fas fa-home"></i> Página Principal
            </button>
            <button type="button" class="config-tab" onclick="switchTab(2)">
                <i class="fas fa-address-book"></i> Contacto
            </button>
            <button type="button" class="config-tab" onclick="switchTab(3)">
                <i class="fas fa-share-alt"></i> Redes Sociales
            </button>
            <button type="button" class="config-tab" onclick="switchTab(4)">
                <i class="fas fa-envelope"></i> Email SMTP
            </button>
        </div>

        <!-- Tab 1: General -->
        <div class="tab-content active">
            <div class="config-card">
                <div class="card-header">
                    <div class="card-header-icon purple">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div>
                        <h3>Información General</h3>
                        <p>Configuración básica del sitio web</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Título del Sitio</label>
                        <input type="text" name="site_title" class="form-control" 
                               value="<?= e($config['site_title'] ?? 'Portal ACIP') ?>" required 
                               placeholder="Nombre de tu institución">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Descripción del Sitio</label>
                        <textarea name="site_description" class="form-control" rows="3" 
                                  placeholder="Breve descripción de tu institución..."><?= e($config['site_description'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Resumen "Quiénes Somos" (Pie de página)</label>
                        <textarea name="site_about_snippet" class="form-control" rows="3" 
                                  placeholder="Formando profesionales de excelencia..."><?= e($config['site_about_snippet'] ?? 'Formando profesionales de excelencia...') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-image"></i> Logotipo del Sitio</label>
                        
                        <?php if (!empty($config['site_logo'])): ?>
                        <div class="current-logo">
                            <img src="<?= url($config['site_logo']) ?>" alt="Logo actual">
                            <div class="current-logo-info">
                                <strong><i class="fas fa-check-circle"></i> Logo actual</strong>
                                <span>Sube una nueva imagen para reemplazar</span>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="upload-zone" id="logoDropZone" onclick="document.getElementById('logoInput').click()">
                            <input type="file" name="site_logo" id="logoInput" accept="image/*">
                            <div class="upload-zone-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <h4>Arrastra y suelta tu logo aquí</h4>
                            <p>o haz clic para seleccionar un archivo</p>
                            <p style="margin-top: 8px; font-size: 11px; color: #9ca3af;">PNG, JPG, SVG, WEBP (máx. 2MB)</p>
                        </div>
                        
                        <div class="preview-container" id="logoPreview">
                            <div class="preview-header">
                                <span><i class="fas fa-eye"></i> Vista Previa</span>
                                <button type="button" class="preview-remove" onclick="removePreview()">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </div>
                            <img src="" alt="Preview" class="preview-image" id="previewImage">
                            <div class="preview-info">
                                <span><i class="fas fa-file"></i> <span id="fileName">archivo.png</span></span>
                                <span><i class="fas fa-weight"></i> <span id="fileSize">0 KB</span></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Keywords SEO (separados por comas)</label>
                        <input type="text" name="seo_keywords" class="form-control" 
                               value="<?= e($config['seo_keywords'] ?? '') ?>" 
                               placeholder="instituto, educación superior, ACIP, Perú">
                        <p class="form-hint">Palabras clave que ayudarán a posicionar tu sitio en buscadores</p>
                    </div>

                    <div class="toggle-card">
                        <div class="toggle-info">
                            <h4><i class="fas fa-tools"></i> Modo Mantenimiento</h4>
                            <p>Desactiva el sitio público temporalmente para realizar cambios</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="mantenimiento_activo" <?= !empty($config['mantenimiento_activo']) ? 'checked' : '' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: Página Principal -->
        <div class="tab-content">
            <div class="config-card">
                <div class="card-header">
                    <div class="card-header-icon" style="background: #fef3c7; color: #d97706;">
                        <i class="fas fa-home"></i>
                    </div>
                    <div>
                        <h3>Sección Bienvenida</h3>
                        <p>Configura el contenido de la sección principal de la página de inicio</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-heading"></i> Título Principal</label>
                            <input type="text" name="home_welcome_title" class="form-control" 
                                   value="<?= e($config['home_welcome_title'] ?? 'IESTP ACIP - JUANJUI') ?>" 
                                   placeholder="Título de bienvenida">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-quote-left"></i> Subtítulo / Eslogan</label>
                            <input type="text" name="home_welcome_subtitle" class="form-control" 
                                   value="<?= e($config['home_welcome_subtitle'] ?? 'Empieza tu camino al éxito') ?>" 
                                   placeholder="Frase motivadora o eslogan">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-align-left"></i> Descripción</label>
                        <textarea name="home_welcome_description" class="form-control" rows="5" 
                                  placeholder="Descripción detallada de la institución..."><?= e($config['home_welcome_description'] ?? 'Somos una institución educativa privada que formamos profesionales técnicos de calidad y competitividad con habilidades: sociales, emprendimiento, investigación aplicada e innovación y de productividad para responder a las exigencias del sector productivo y contribuir al desarrollo sostenible regional, nacional y global.') ?></textarea>
                        <p class="form-hint">Este texto aparecerá debajo del título en la página principal</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-mouse-pointer"></i> Texto del Botón</label>
                            <input type="text" name="home_welcome_button_text" class="form-control" 
                                   value="<?= e($config['home_welcome_button_text'] ?? 'LEER MAS') ?>" 
                                   placeholder="Texto del botón de acción">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-link"></i> Enlace del Botón</label>
                            <input type="text" name="home_welcome_button_url" class="form-control" 
                                   value="<?= e($config['home_welcome_button_url'] ?? '/nosotros') ?>" 
                                   placeholder="/nosotros o URL completa">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-photo-video"></i> Tipo de Contenido</label>
                        <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                            <label style="display: flex; align-items: center; gap: 8px; padding: 12px 20px; background: #f8fafc; border-radius: 10px; cursor: pointer; border: 2px solid <?= ($config['home_welcome_media_type'] ?? 'image') === 'image' ? '#6366f1' : '#e5e7eb' ?>; transition: all 0.2s;">
                                <input type="radio" name="home_welcome_media_type" value="image" 
                                       <?= ($config['home_welcome_media_type'] ?? 'image') === 'image' ? 'checked' : '' ?>
                                       onchange="toggleMediaType('image')" style="accent-color: #6366f1;">
                                <i class="fas fa-image" style="color: #6366f1;"></i>
                                <span style="font-weight: 600;">Imagen</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; padding: 12px 20px; background: #f8fafc; border-radius: 10px; cursor: pointer; border: 2px solid <?= ($config['home_welcome_media_type'] ?? 'image') === 'video' ? '#dc2626' : '#e5e7eb' ?>; transition: all 0.2s;">
                                <input type="radio" name="home_welcome_media_type" value="video" 
                                       <?= ($config['home_welcome_media_type'] ?? 'image') === 'video' ? 'checked' : '' ?>
                                       onchange="toggleMediaType('video')" style="accent-color: #dc2626;">
                                <i class="fab fa-youtube" style="color: #dc2626;"></i>
                                <span style="font-weight: 600;">Video YouTube</span>
                            </label>
                        </div>
                    </div>

                    <!-- Image Upload Section -->
                    <div id="imageSection" class="form-group" style="display: <?= ($config['home_welcome_media_type'] ?? 'image') === 'image' ? 'block' : 'none' ?>;">
                        <label class="form-label"><i class="fas fa-image"></i> Imagen de la Sección</label>
                        
                        <?php if (!empty($config['home_welcome_image'])): ?>
                        <div class="current-logo">
                            <img src="<?= url($config['home_welcome_image']) ?>" alt="Imagen actual" style="max-height: 80px; max-width: 150px;">
                            <div class="current-logo-info">
                                <strong><i class="fas fa-check-circle"></i> Imagen actual</strong>
                                <span>Sube una nueva imagen para reemplazar</span>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="upload-zone" id="welcomeDropZone" onclick="document.getElementById('welcomeInput').click()">
                            <input type="file" name="home_welcome_image" id="welcomeInput" accept="image/*">
                            <div class="upload-zone-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <h4>Arrastra y suelta la imagen aquí</h4>
                            <p>o haz clic para seleccionar un archivo</p>
                            <p style="margin-top: 8px; font-size: 11px; color: #9ca3af;">PNG, JPG, WEBP (recomendado: 600x400px)</p>
                        </div>
                        
                        <div class="preview-container" id="welcomePreview">
                            <div class="preview-header">
                                <span><i class="fas fa-eye"></i> Vista Previa</span>
                                <button type="button" class="preview-remove" onclick="removeWelcomePreview()">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </div>
                            <img src="" alt="Preview" class="preview-image" id="welcomePreviewImage">
                            <div class="preview-info">
                                <span><i class="fas fa-file"></i> <span id="welcomeFileName">archivo.png</span></span>
                                <span><i class="fas fa-weight"></i> <span id="welcomeFileSize">0 KB</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Video YouTube Section -->
                    <div id="videoSection" class="form-group" style="display: <?= ($config['home_welcome_media_type'] ?? 'image') === 'video' ? 'block' : 'none' ?>;">
                        <label class="form-label"><i class="fab fa-youtube" style="color: #dc2626;"></i> URL del Video de YouTube</label>
                        <input type="url" name="home_welcome_video_url" class="form-control" 
                               value="<?= e($config['home_welcome_video_url'] ?? '') ?>" 
                               placeholder="https://www.youtube.com/watch?v=xxxxx">
                        <p class="form-hint">Pega el enlace del video de YouTube. Se mostrará automáticamente en la página principal.</p>
                        
                        <?php if (!empty($config['home_welcome_video_url'])): ?>
                        <div style="margin-top: 16px; padding: 16px; background: #fef2f2; border-radius: 12px; border: 1px solid #fecaca;">
                            <strong style="color: #dc2626; font-size: 13px;"><i class="fab fa-youtube"></i> Video actual:</strong>
                            <p style="font-size: 12px; color: #7f1d1d; margin-top: 4px; word-break: break-all;"><?= e($config['home_welcome_video_url']) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 3: Contacto -->
        <div class="tab-content">
            <div class="config-card">
                <div class="card-header">
                    <div class="card-header-icon blue">
                        <i class="fas fa-address-book"></i>
                    </div>
                    <div>
                        <h3>Información de Contacto</h3>
                        <p>Datos de contacto que se mostrarán en el sitio</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-envelope"></i> Email de Contacto</label>
                            <input type="email" name="site_email" class="form-control" 
                                   value="<?= e($config['site_email'] ?? 'contacto@acip.edu.pe') ?>" 
                                   placeholder="contacto@ejemplo.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-phone"></i> Teléfono</label>
                            <input type="text" name="site_phone" class="form-control" 
                                   value="<?= e($config['site_phone'] ?? '') ?>" 
                                   placeholder="(01) 123-4567">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-map-marker-alt"></i> Dirección Institucional</label>
                        <textarea name="site_direccion" class="form-control" rows="3" 
                                  placeholder="Dirección completa de la institución"><?= e($config['site_direccion'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-clock"></i> Horario de Atención</label>
                        <input type="text" name="site_horario" class="form-control" 
                               value="<?= e($config['site_horario'] ?? 'Lun - Vie: 8:00 AM - 6:00 PM') ?>" 
                               placeholder="Lun - Vie: 8:00 AM - 6:00 PM">
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-map"></i> Mapa de Ubicación (Embed de Google Maps)</label>
                        <textarea name="site_map_embed" class="form-control" rows="4" 
                                  placeholder='<iframe src="https://www.google.com/maps/embed?...">'><?= e($config['site_map_embed'] ?? '') ?></textarea>
                        <p class="form-hint">Pega aquí el código HTML del iframe de Google Maps</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 3: Redes Sociales -->
        <div class="tab-content">
            <div class="config-card">
                <div class="card-header">
                    <div class="card-header-icon pink">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    <div>
                        <h3>Redes Sociales</h3>
                        <p>Enlaces a tus perfiles de redes sociales</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label"><i class="fab fa-facebook social-facebook"></i> Facebook</label>
                            <input type="url" name="redes_facebook" class="form-control" 
                                   value="<?= e($config['redes_facebook'] ?? '') ?>" 
                                   placeholder="https://facebook.com/tupagina">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fab fa-instagram social-instagram"></i> Instagram</label>
                            <input type="url" name="redes_instagram" class="form-control" 
                                   value="<?= e($config['redes_instagram'] ?? '') ?>" 
                                   placeholder="https://instagram.com/tuperfil">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label"><i class="fab fa-youtube social-youtube"></i> YouTube</label>
                            <input type="url" name="redes_youtube" class="form-control" 
                                   value="<?= e($config['redes_youtube'] ?? '') ?>" 
                                   placeholder="https://youtube.com/@tucanal">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fab fa-twitter social-twitter"></i> Twitter (X)</label>
                            <input type="url" name="redes_twitter" class="form-control" 
                                   value="<?= e($config['redes_twitter'] ?? '') ?>" 
                                   placeholder="https://twitter.com/tuperfil">
                        </div>
                    </div>

                    <div class="form-grid single">
                        <div class="form-group">
                            <label class="form-label"><i class="fab fa-tiktok social-tiktok"></i> TikTok</label>
                            <input type="url" name="redes_tiktok" class="form-control" 
                                   value="<?= e($config['redes_tiktok'] ?? '') ?>" 
                                   placeholder="https://tiktok.com/@tuperfil">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label"><i class="fab fa-whatsapp social-whatsapp"></i> WhatsApp</label>
                            <input type="text" name="whatsapp_numero" class="form-control" 
                                   value="<?= e($config['whatsapp_numero'] ?? '') ?>" 
                                   placeholder="51974293842">
                            <small style="color: #6b7280; font-size: 0.875rem; margin-top: 4px; display: block;">
                                Número en formato internacional (código + número, sin espacios)
                            </small>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-comment-dots"></i> Mensaje Predeterminado</label>
                            <textarea name="whatsapp_mensaje" class="form-control" rows="3" 
                                      placeholder="Hola, estoy interesado en información sobre..."><?= e($config['whatsapp_mensaje'] ?? '') ?></textarea>
                            <small style="color: #6b7280; font-size: 0.875rem; margin-top: 4px; display: block;">
                                Este mensaje aparecerá automáticamente al contactar por WhatsApp
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 4: Email SMTP -->
        <div class="tab-content">
            <div class="config-card">
                <div class="card-header">
                    <div class="card-header-icon green">
                        <i class="fas fa-server"></i>
                    </div>
                    <div>
                        <h3>Configuración de Email SMTP</h3>
                        <p>Configura el servidor de correo saliente</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-server"></i> Servidor SMTP (Host)</label>
                            <input type="text" name="email_smtp_host" class="form-control" 
                                   value="<?= e($config['email_smtp_host'] ?? '') ?>" 
                                   placeholder="smtp.gmail.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-plug"></i> Puerto SMTP</label>
                            <input type="number" name="email_smtp_port" class="form-control" 
                                   value="<?= e($config['email_smtp_port'] ?? '587') ?>" 
                                   placeholder="587">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-user"></i> Usuario SMTP</label>
                        <input type="text" name="email_smtp_user" class="form-control" 
                               value="<?= e($config['email_smtp_user'] ?? '') ?>" 
                               placeholder="usuario@gmail.com">
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-lock"></i> Contraseña SMTP</label>
                        <input type="password" name="email_smtp_pass" class="form-control" 
                               value="<?= e($config['email_smtp_pass'] ?? '') ?>" 
                               placeholder="••••••••">
                        <p class="form-hint">Deja en blanco para mantener la contraseña actual</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div style="margin-top: 24px; text-align: right;">
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Guardar Configuración
            </button>
        </div>
    </form>
</div>

<script>
// Tab Switching
function switchTab(index) {
    const tabs = document.querySelectorAll('.config-tab');
    const contents = document.querySelectorAll('.tab-content');
    
    tabs.forEach((tab, i) => {
        tab.classList.toggle('active', i === index);
    });
    
    contents.forEach((content, i) => {
        content.classList.toggle('active', i === index);
    });
}

// Drag and Drop
const dropZone = document.getElementById('logoDropZone');
const fileInput = document.getElementById('logoInput');
const previewContainer = document.getElementById('logoPreview');
const previewImage = document.getElementById('previewImage');
const fileName = document.getElementById('fileName');
const fileSize = document.getElementById('fileSize');

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
    dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
});

// Handle dropped files
dropZone.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        showPreview(files[0]);
    }
}

// Handle file input change
fileInput.addEventListener('change', function() {
    if (this.files.length > 0) {
        showPreview(this.files[0]);
    }
});

function showPreview(file) {
    if (!file.type.startsWith('image/')) {
        alert('Por favor selecciona una imagen válida');
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        previewImage.src = e.target.result;
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        previewContainer.classList.add('has-file');
    }
    reader.readAsDataURL(file);
}

function removePreview() {
    fileInput.value = '';
    previewImage.src = '';
    previewContainer.classList.remove('has-file');
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Welcome Image Drag and Drop
const welcomeDropZone = document.getElementById('welcomeDropZone');
const welcomeInput = document.getElementById('welcomeInput');
const welcomePreviewContainer = document.getElementById('welcomePreview');
const welcomePreviewImage = document.getElementById('welcomePreviewImage');
const welcomeFileName = document.getElementById('welcomeFileName');
const welcomeFileSize = document.getElementById('welcomeFileSize');

if (welcomeDropZone) {
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        welcomeDropZone.addEventListener(eventName, preventDefaults, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        welcomeDropZone.addEventListener(eventName, () => welcomeDropZone.classList.add('dragover'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        welcomeDropZone.addEventListener(eventName, () => welcomeDropZone.classList.remove('dragover'), false);
    });

    welcomeDropZone.addEventListener('drop', function(e) {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            welcomeInput.files = files;
            showWelcomePreview(files[0]);
        }
    }, false);

    welcomeInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            showWelcomePreview(this.files[0]);
        }
    });
}

function showWelcomePreview(file) {
    if (!file.type.startsWith('image/')) {
        alert('Por favor selecciona una imagen válida');
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        welcomePreviewImage.src = e.target.result;
        welcomeFileName.textContent = file.name;
        welcomeFileSize.textContent = formatFileSize(file.size);
        welcomePreviewContainer.classList.add('has-file');
    }
    reader.readAsDataURL(file);
}

function removeWelcomePreview() {
    welcomeInput.value = '';
    welcomePreviewImage.src = '';
    welcomePreviewContainer.classList.remove('has-file');
}

// Toggle between Image and Video sections
function toggleMediaType(type) {
    const imageSection = document.getElementById('imageSection');
    const videoSection = document.getElementById('videoSection');
    
    if (type === 'image') {
        imageSection.style.display = 'block';
        videoSection.style.display = 'none';
    } else {
        imageSection.style.display = 'none';
        videoSection.style.display = 'block';
    }
}
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
