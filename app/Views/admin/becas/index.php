<?php ob_start(); ?>

<div class="becas-admin-wrapper">
    <!-- Animated Background -->
    <div class="bg-decoration">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <!-- Header Section -->
    <div class="admin-header animate-slide-down">
        <div class="header-content">
            <div class="header-info">
                <div class="header-badge">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <h1 class="header-title">Convocatoria de Becas</h1>
                    <p class="header-subtitle">Gestione la configuración visual y documentos de la convocatoria</p>
                </div>
            </div>
            <a href="<?= url('becas') ?>" target="_blank" class="btn-preview">
                <i class="fas fa-external-link-alt"></i>
                <span>Vista Previa</span>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>

    <form action="<?= url('admin/becas/update') ?>" method="POST" enctype="multipart/form-data" id="becasForm">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

        <div class="admin-grid">
            
            <!-- Main Content Column -->
            <div class="main-column">
                
                <!-- Hero Section Card -->
                <div class="glass-card animate-slide-up" style="--delay: 0.1s">
                    <div class="card-header-modern">
                        <div class="header-icon gradient-primary">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="header-text">
                            <h2>Portada Principal</h2>
                            <span>Configura el hero de la página</span>
                        </div>
                        <div class="header-status active">
                            <span class="status-dot"></span>
                            Activo
                        </div>
                    </div>
                    
                    <div class="card-body-modern">
                        <?php 
                            $heroType = $becas['hero_type']['contenido'] ?? 'image';
                            $heroVideo = $becas['hero_video']['contenido'] ?? '';
                            $heroImage = $becas['hero_image']['archivo_url'] ?? '';
                        ?>

                        <!-- Type Selector -->
                        <div class="type-selector-wrapper">
                            <label class="section-label">
                                <i class="fas fa-palette"></i>
                                Tipo de Fondo
                            </label>
                            
                            <div class="type-selector">
                                <div class="type-option <?= $heroType !== 'video' ? 'active' : '' ?>" onclick="setHeroType('image')">
                                    <input type="radio" name="hero_type" id="type_image" value="image" <?= $heroType !== 'video' ? 'checked' : '' ?>>
                                    <div class="type-icon">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <div class="type-info">
                                        <span class="type-title">Imagen Estática</span>
                                        <span class="type-desc">JPG, PNG, WEBP</span>
                                    </div>
                                    <div class="type-check">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                                
                                <div class="type-option <?= $heroType === 'video' ? 'active' : '' ?>" onclick="setHeroType('video')">
                                    <input type="radio" name="hero_type" id="type_video" value="video" <?= $heroType === 'video' ? 'checked' : '' ?>>
                                    <div class="type-icon youtube">
                                        <i class="fab fa-youtube"></i>
                                    </div>
                                    <div class="type-info">
                                        <span class="type-title">Video YouTube</span>
                                        <span class="type-desc">Reproducción automática</span>
                                    </div>
                                    <div class="type-check">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image Upload Section -->
                        <div id="hero-image-section" class="upload-section <?= $heroType !== 'video' ? 'active' : '' ?>">
                            <div class="dropzone" id="drop-hero-image">
                                <input type="file" id="hero_image_input" name="hero_image" accept="image/jpeg,image/png,image/webp">
                                <div class="dropzone-content">
                                    <div class="dropzone-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <div class="upload-rings">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </div>
                                    <h4>Arrastra tu imagen aquí</h4>
                                    <p>o haz clic para seleccionar</p>
                                    <span class="dropzone-hint">Recomendado: 1920×600px • Máx. 5MB</span>
                                </div>
                                <div class="dropzone-selected">
                                    <i class="fas fa-file-image"></i>
                                    <span class="file-name">Ningún archivo seleccionado</span>
                                </div>
                            </div>
                            
                            <?php if (!empty($heroImage)): ?>
                            <div class="current-preview">
                                <label class="section-label">
                                    <i class="fas fa-eye"></i>
                                    Vista Previa Actual
                                </label>
                                <div class="preview-frame">
                                    <img src="<?= url($heroImage) ?>" alt="Hero Preview">
                                    <div class="preview-overlay">
                                        <button type="button" class="preview-btn" onclick="document.getElementById('hero_image_input').click()">
                                            <i class="fas fa-sync-alt"></i>
                                            Cambiar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Video URL Section -->
                        <div id="hero-video-section" class="video-section <?= $heroType === 'video' ? 'active' : '' ?>">
                            <label class="section-label">
                                <i class="fab fa-youtube"></i>
                                URL del Video
                            </label>
                            <div class="video-input-wrapper">
                                <div class="video-input-icon">
                                    <i class="fab fa-youtube"></i>
                                </div>
                                <input type="text" class="video-input" id="hero_video_url" name="hero_video_url" 
                                       value="<?= htmlspecialchars($heroVideo) ?>" 
                                       placeholder="https://youtube.com/watch?v=...">
                                <button type="button" class="video-test-btn" onclick="testVideo()">
                                    <i class="fas fa-play"></i>
                                </button>
                            </div>
                            <p class="input-hint">
                                <i class="fas fa-info-circle"></i>
                                El video se reproducirá en bucle sin sonido como fondo del encabezado
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Description Card -->
                <div class="glass-card animate-slide-up" style="--delay: 0.2s">
                    <div class="card-header-modern">
                        <div class="header-icon gradient-secondary">
                            <i class="fas fa-align-left"></i>
                        </div>
                        <div class="header-text">
                            <h2>Descripción</h2>
                            <span>Información de la convocatoria</span>
                        </div>
                    </div>
                    
                    <div class="card-body-modern">
                        <div class="editor-wrapper">
                            <textarea class="editor-textarea" id="header_info" name="header_info"><?= htmlspecialchars($becas['header_info']['contenido'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="sidebar-column">
                <div class="sidebar-sticky">
                    
                    <!-- Documents Section -->
                    <div class="glass-card sidebar-card animate-slide-up" style="--delay: 0.3s">
                        <div class="sidebar-header">
                            <div class="sidebar-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <h3>Documentos Requeridos</h3>
                        </div>
                        
                        <div class="documents-list">
                            <?php 
                            $files = [
                                'merito_1' => ['label' => 'Primer Puesto', 'desc' => 'Cuadro de méritos 1er Puesto', 'icon' => 'trophy', 'color' => 'gold'],
                                'merito_2' => ['label' => 'Segundo Puesto', 'desc' => 'Cuadro de méritos 2do Puesto', 'icon' => 'medal', 'color' => 'silver'],
                                'condicion_hermanos' => ['label' => 'Hermanos', 'desc' => 'Semi beca Condición hermanos', 'icon' => 'users', 'color' => 'blue'],
                                'servicio_militar' => ['label' => 'Servicio Militar', 'desc' => 'Beca Servicio Militar', 'icon' => 'shield-alt', 'color' => 'green']
                            ];

                            foreach ($files as $key => $info): 
                                $data = $becas[$key] ?? ['contenido' => $info['desc'], 'archivo_url' => ''];
                                $hasFile = !empty($data['archivo_url']);
                            ?>
                            
                            <div class="doc-item <?= $hasFile ? 'has-file' : '' ?>" data-key="<?= $key ?>">
                                <div class="doc-icon <?= $info['color'] ?>">
                                    <i class="fas fa-<?= $info['icon'] ?>"></i>
                                </div>
                                
                                <div class="doc-content">
                                    <div class="doc-header">
                                        <h4><?= $info['label'] ?></h4>
                                        <?php if ($hasFile): ?>
                                            <span class="doc-status success">
                                                <i class="fas fa-check-circle"></i>
                                            </span>
                                        <?php else: ?>
                                            <span class="doc-status pending">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <input type="text" class="doc-description" name="<?= $key ?>" 
                                           value="<?= htmlspecialchars($data['contenido']) ?>" 
                                           placeholder="Descripción del documento">
                                    
                                    <div class="doc-actions">
                                        <?php if ($hasFile): ?>
                                            <a href="<?= url($data['archivo_url']) ?>" target="_blank" class="doc-btn view">
                                                <i class="fas fa-eye"></i>
                                                <span>Ver</span>
                                            </a>
                                            <button type="button" class="doc-btn replace" onclick="triggerUpload('<?= $key ?>')">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                            <button type="button" class="doc-btn delete" onclick="deleteFile('<?= $key ?>')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        <?php else: ?>
                                            <button type="button" class="doc-btn upload-trigger" onclick="triggerUpload('<?= $key ?>')">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <span>Subir PDF</span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="doc-upload-area" id="upload-box-<?= $key ?>">
                                        <input type="file" id="<?= $key ?>_file" name="<?= $key ?>" accept="application/pdf">
                                        <label for="<?= $key ?>_file" class="upload-label">
                                            <i class="fas fa-file-pdf"></i>
                                            <span>Seleccionar PDF</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <button type="submit" class="save-button animate-slide-up" style="--delay: 0.4s">
                        <div class="save-icon">
                            <i class="fas fa-save"></i>
                        </div>
                        <span>Guardar Cambios</span>
                        <div class="save-loader">
                            <div class="loader-spinner"></div>
                        </div>
                    </button>
                    
                    <!-- Quick Stats -->
                    <div class="quick-stats animate-slide-up" style="--delay: 0.5s">
                        <div class="stat-item">
                            <div class="stat-value"><?= count(array_filter($files, fn($k) => !empty($becas[$k]['archivo_url'] ?? ''), ARRAY_FILTER_USE_KEY)) ?>/4</div>
                            <div class="stat-label">Documentos</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-value <?= $heroType === 'video' ? 'video' : 'image' ?>">
                                <i class="fas fa-<?= $heroType === 'video' ? 'video' : 'image' ?>"></i>
                            </div>
                            <div class="stat-label">Hero</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Delete Form -->
<form id="deleteFileForm" action="<?= url('admin/becas/delete-file') ?>" method="POST" style="display: none;">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <input type="hidden" name="key_name" id="deleteFileKey">
</form>

<!-- Toast Notification -->
<div class="toast-container" id="toastContainer"></div>

<style>
/* ============================================
   CSS Variables & Reset
   ============================================ */
:root {
    --primary: #6366f1;
    --primary-dark: #4f46e5;
    --primary-light: #818cf8;
    --secondary: #ec4899;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --dark: #1e1b4b;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-500: #64748b;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --gray-900: #0f172a;
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 24px;
    --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
    --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
    --transition-fast: 150ms ease;
    --transition-normal: 250ms ease;
    --transition-slow: 350ms ease;
}

.becas-admin-wrapper {
    position: relative;
    min-height: 100vh;
    padding: 2rem;
    background: linear-gradient(135deg, #f0f4ff 0%, #fdf4ff 50%, #f0fdff 100%);
}

/* ============================================
   Background Decorations
   ============================================ */
.bg-decoration {
    position: fixed;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
    z-index: 0;
}

.blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.5;
    animation: blob-float 20s ease-in-out infinite;
}

.blob-1 {
    width: 600px;
    height: 600px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.3), rgba(168, 85, 247, 0.2));
    top: -200px;
    right: -100px;
    animation-delay: 0s;
}

.blob-2 {
    width: 500px;
    height: 500px;
    background: linear-gradient(135deg, rgba(236, 72, 153, 0.2), rgba(244, 114, 182, 0.15));
    bottom: -150px;
    left: -100px;
    animation-delay: -7s;
}

.blob-3 {
    width: 400px;
    height: 400px;
    background: linear-gradient(135deg, rgba(34, 211, 238, 0.2), rgba(59, 130, 246, 0.15));
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation-delay: -14s;
}

@keyframes blob-float {
    0%, 100% { transform: translate(0, 0) scale(1); }
    25% { transform: translate(30px, -30px) scale(1.05); }
    50% { transform: translate(-20px, 20px) scale(0.95); }
    75% { transform: translate(20px, 30px) scale(1.02); }
}

/* ============================================
   Animations
   ============================================ */
@keyframes slide-down {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slide-up {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes pulse-ring {
    0% { transform: scale(0.8); opacity: 1; }
    100% { transform: scale(2); opacity: 0; }
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.animate-slide-down {
    animation: slide-down 0.5s ease forwards;
}

.animate-slide-up {
    animation: slide-up 0.5s ease forwards;
    animation-delay: var(--delay, 0s);
    opacity: 0;
}

.animate-fade-in {
    animation: fade-in 0.3s ease forwards;
}

/* ============================================
   Header
   ============================================ */
.admin-header {
    position: relative;
    z-index: 10;
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-badge {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 10px 30px -10px rgba(99, 102, 241, 0.5);
}

.header-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0;
    background: linear-gradient(135deg, var(--gray-900) 0%, var(--gray-700) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.header-subtitle {
    font-size: 0.9rem;
    color: var(--gray-500);
    margin: 0.25rem 0 0 0;
}

.btn-preview {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: white;
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-lg);
    color: var(--gray-700);
    font-weight: 500;
    font-size: 0.875rem;
    text-decoration: none;
    overflow: hidden;
    transition: all var(--transition-normal);
}

.btn-preview:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-preview .btn-glow {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(236, 72, 153, 0.1));
    opacity: 0;
    transition: opacity var(--transition-normal);
}

.btn-preview:hover .btn-glow {
    opacity: 1;
}

/* ============================================
   Grid Layout
   ============================================ */
.admin-grid {
    position: relative;
    z-index: 10;
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

@media (max-width: 1200px) {
    .admin-grid {
        grid-template-columns: 1fr;
    }
}

.main-column {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.sidebar-column {
    position: relative;
}

.sidebar-sticky {
    position: sticky;
    top: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* ============================================
   Glass Card
   ============================================ */
.glass-card {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: var(--radius-xl);
    border: 1px solid rgba(255, 255, 255, 0.5);
    box-shadow: var(--shadow-lg), 0 0 0 1px rgba(255, 255, 255, 0.5) inset;
    overflow: hidden;
    transition: all var(--transition-normal);
}

.glass-card:hover {
    box-shadow: var(--shadow-xl), 0 0 0 1px rgba(255, 255, 255, 0.5) inset;
}

/* ============================================
   Card Header Modern
   ============================================ */
.card-header-modern {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    background: rgba(255, 255, 255, 0.5);
}

.header-icon {
    width: 44px;
    height: 44px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: white;
    flex-shrink: 0;
}

.header-icon.gradient-primary {
    background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
    box-shadow: 0 4px 15px -3px rgba(99, 102, 241, 0.4);
}

.header-icon.gradient-secondary {
    background: linear-gradient(135deg, var(--secondary) 0%, #f472b6 100%);
    box-shadow: 0 4px 15px -3px rgba(236, 72, 153, 0.4);
}

.header-text {
    flex: 1;
}

.header-text h2 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
}

.header-text span {
    font-size: 0.8rem;
    color: var(--gray-500);
}

.header-status {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 500;
}

.header-status.active {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.status-dot {
    width: 6px;
    height: 6px;
    background: currentColor;
    border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.8); }
}

/* ============================================
   Card Body Modern
   ============================================ */
.card-body-modern {
    padding: 1.5rem;
}

.section-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--gray-500);
    margin-bottom: 0.75rem;
}

.section-label i {
    font-size: 0.7rem;
    opacity: 0.7;
}

/* ============================================
   Type Selector
   ============================================ */
.type-selector-wrapper {
    margin-bottom: 1.5rem;
}

.type-selector {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.type-option {
    position: relative;
    padding: 1.25rem;
    background: var(--gray-50);
    border: 2px solid transparent;
    border-radius: var(--radius-lg);
    cursor: pointer;
    transition: all var(--transition-normal);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.type-option input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.type-option:hover {
    background: white;
    border-color: var(--gray-200);
    transform: translateY(-2px);
}

.type-option.active {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(139, 92, 246, 0.08) 100%);
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.type-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius-md);
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: var(--gray-400);
    transition: all var(--transition-normal);
    box-shadow: var(--shadow-sm);
}

.type-option.active .type-icon {
    background: var(--primary);
    color: white;
    box-shadow: 0 4px 15px -3px rgba(99, 102, 241, 0.5);
}

.type-option.active .type-icon.youtube {
    background: #ff0000;
    box-shadow: 0 4px 15px -3px rgba(255, 0, 0, 0.4);
}

.type-info {
    flex: 1;
}

.type-title {
    display: block;
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--gray-800);
    margin-bottom: 0.15rem;
}

.type-desc {
    display: block;
    font-size: 0.75rem;
    color: var(--gray-500);
}

.type-check {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    color: white;
    opacity: 0;
    transform: scale(0.5);
    transition: all var(--transition-normal);
}

.type-option.active .type-check {
    background: var(--primary);
    opacity: 1;
    transform: scale(1);
}

/* ============================================
   Upload Section
   ============================================ */
.upload-section,
.video-section {
    display: none;
    animation: fade-in 0.3s ease;
}

.upload-section.active,
.video-section.active {
    display: block;
}

.dropzone {
    position: relative;
    border: 2px dashed var(--gray-300);
    border-radius: var(--radius-lg);
    padding: 2.5rem 1.5rem;
    text-align: center;
    background: var(--gray-50);
    cursor: pointer;
    transition: all var(--transition-normal);
    overflow: hidden;
}

.dropzone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
}

.dropzone:hover,
.dropzone.dragover {
    border-color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
}

.dropzone-content {
    position: relative;
    z-index: 1;
}

.dropzone-icon {
    position: relative;
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.dropzone-icon i {
    font-size: 2.5rem;
    color: var(--primary);
    position: relative;
    z-index: 2;
}

.upload-rings {
    position: absolute;
    inset: 0;
}

.upload-rings span {
    position: absolute;
    inset: 0;
    border: 2px solid var(--primary);
    border-radius: 50%;
    opacity: 0;
}

.dropzone:hover .upload-rings span {
    animation: pulse-ring 1.5s ease-out infinite;
}

.dropzone:hover .upload-rings span:nth-child(2) {
    animation-delay: 0.3s;
}

.dropzone:hover .upload-rings span:nth-child(3) {
    animation-delay: 0.6s;
}

.dropzone-content h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0 0 0.25rem 0;
}

.dropzone-content p {
    font-size: 0.875rem;
    color: var(--gray-500);
    margin: 0 0 0.75rem 0;
}

.dropzone-hint {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    background: white;
    border-radius: 50px;
    font-size: 0.7rem;
    color: var(--gray-500);
    box-shadow: var(--shadow-sm);
}

.dropzone-selected {
    display: none;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1rem;
    padding: 0.75rem 1rem;
    background: white;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
}

.dropzone-selected i {
    color: var(--primary);
}

.dropzone-selected .file-name {
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--gray-700);
}

.dropzone.has-file .dropzone-selected {
    display: flex;
}

/* ============================================
   Current Preview
   ============================================ */
.current-preview {
    margin-top: 1.5rem;
}

.preview-frame {
    position: relative;
    border-radius: var(--radius-lg);
    overflow: hidden;
    background: var(--gray-900);
    aspect-ratio: 16/5;
}

.preview-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow);
}

.preview-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity var(--transition-normal);
}

.preview-frame:hover img {
    transform: scale(1.05);
}

.preview-frame:hover .preview-overlay {
    opacity: 1;
}

.preview-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: white;
    border: none;
    border-radius: var(--radius-md);
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--gray-800);
    cursor: pointer;
    transition: all var(--transition-fast);
}

.preview-btn:hover {
    background: var(--primary);
    color: white;
    transform: scale(1.05);
}

/* ============================================
   Video Section
   ============================================ */
.video-input-wrapper {
    display: flex;
    align-items: stretch;
    background: var(--gray-50);
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-md);
    overflow: hidden;
    transition: all var(--transition-normal);
}

.video-input-wrapper:focus-within {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.video-input-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    background: white;
    color: #ff0000;
    font-size: 1.25rem;
    border-right: 1px solid var(--gray-200);
}

.video-input {
    flex: 1;
    padding: 0.875rem 1rem;
    border: none;
    background: transparent;
    font-size: 0.9rem;
    color: var(--gray-800);
}

.video-input:focus {
    outline: none;
}

.video-input::placeholder {
    color: var(--gray-400);
}

.video-test-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    background: var(--primary);
    border: none;
    color: white;
    cursor: pointer;
    transition: all var(--transition-fast);
}

.video-test-btn:hover {
    background: var(--primary-dark);
}

.input-hint {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.75rem;
    padding: 0.75rem 1rem;
    background: rgba(99, 102, 241, 0.05);
    border-radius: var(--radius-sm);
    font-size: 0.8rem;
    color: var(--gray-600);
}

.input-hint i {
    color: var(--primary);
}

/* ============================================
   Editor
   ============================================ */
.editor-wrapper {
    border-radius: var(--radius-md);
    overflow: hidden;
    border: 1px solid var(--gray-200);
}

.editor-wrapper .ck.ck-editor__editable_inline {
    min-height: 200px;
    padding: 1rem;
}

.editor-wrapper .ck.ck-toolbar {
    background: var(--gray-50);
    border-bottom: 1px solid var(--gray-200);
}

.editor-textarea {
    display: none;
}

/* ============================================
   Sidebar
   ============================================ */
.sidebar-card {
    padding: 0;
}

.sidebar-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.25rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    background: rgba(255, 255, 255, 0.5);
}

.sidebar-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    box-shadow: 0 4px 15px -3px rgba(239, 68, 68, 0.4);
}

.sidebar-header h3 {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
}

/* ============================================
   Documents List
   ============================================ */
.documents-list {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.doc-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: var(--gray-50);
    border-radius: var(--radius-md);
    border: 1px solid transparent;
    transition: all var(--transition-normal);
}

.doc-item:hover {
    background: white;
    border-color: var(--gray-200);
    box-shadow: var(--shadow-md);
}

.doc-item.has-file {
    background: rgba(16, 185, 129, 0.05);
    border-color: rgba(16, 185, 129, 0.2);
}

.doc-icon {
    width: 44px;
    height: 44px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.doc-icon.gold {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
    box-shadow: 0 4px 10px -2px rgba(245, 158, 11, 0.4);
}

.doc-icon.silver {
    background: linear-gradient(135deg, #94a3b8, #64748b);
    color: white;
    box-shadow: 0 4px 10px -2px rgba(100, 116, 139, 0.4);
}

.doc-icon.blue {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    box-shadow: 0 4px 10px -2px rgba(37, 99, 235, 0.4);
}

.doc-icon.green {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    box-shadow: 0 4px 10px -2px rgba(5, 150, 105, 0.4);
}

.doc-content {
    flex: 1;
    min-width: 0;
}

.doc-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.doc-header h4 {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
}

.doc-status {
    font-size: 0.9rem;
}

.doc-status.success {
    color: var(--success);
}

.doc-status.pending {
    color: var(--gray-400);
}

.doc-description {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-sm);
    font-size: 0.8rem;
    color: var(--gray-600);
    background: white;
    transition: all var(--transition-fast);
}

.doc-description:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.doc-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.75rem;
}

.doc-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    padding: 0.5rem 0.75rem;
    border: none;
    border-radius: var(--radius-sm);
    font-size: 0.75rem;
    font-weight: 500;
    cursor: pointer;
    transition: all var(--transition-fast);
    text-decoration: none;
}

.doc-btn.view {
    background: rgba(99, 102, 241, 0.1);
    color: var(--primary);
    flex: 1;
}

.doc-btn.view:hover {
    background: var(--primary);
    color: white;
}

.doc-btn.replace {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
    width: 36px;
    padding: 0.5rem;
}

.doc-btn.replace:hover {
    background: var(--warning);
    color: white;
}

.doc-btn.delete {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
    width: 36px;
    padding: 0.5rem;
}

.doc-btn.delete:hover {
    background: var(--danger);
    color: white;
}

.doc-btn.upload-trigger {
    background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
    color: white;
    flex: 1;
}

.doc-btn.upload-trigger:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px -3px rgba(99, 102, 241, 0.5);
}

/* Document Upload Area */
.doc-upload-area {
    display: none;
    margin-top: 0.75rem;
    position: relative;
}

.doc-upload-area.show {
    display: block;
    animation: slide-up 0.3s ease;
}

.doc-upload-area input[type="file"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.upload-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    border: 2px dashed var(--gray-300);
    border-radius: var(--radius-sm);
    font-size: 0.8rem;
    color: var(--gray-500);
    cursor: pointer;
    transition: all var(--transition-fast);
}

.upload-label:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
}

/* ============================================
   Save Button
   ============================================ */
.save-button {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    width: 100%;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
    border: none;
    border-radius: var(--radius-lg);
    color: white;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    overflow: hidden;
    transition: all var(--transition-normal);
    box-shadow: 0 4px 15px -3px rgba(99, 102, 241, 0.5);
}

.save-button::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    opacity: 0;
    transition: opacity var(--transition-normal);
}

.save-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px -5px rgba(99, 102, 241, 0.6);
}

.save-button:hover::before {
    opacity: 1;
}

.save-button:active {
    transform: translateY(0);
}

.save-icon,
.save-button span {
    position: relative;
    z-index: 1;
}

.save-loader {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: inherit;
    opacity: 0;
    pointer-events: none;
    transition: opacity var(--transition-normal);
}

.save-button.loading .save-loader {
    opacity: 1;
}

.save-button.loading .save-icon,
.save-button.loading span {
    opacity: 0;
}

.loader-spinner {
    width: 24px;
    height: 24px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

/* ============================================
   Quick Stats
   ============================================ */
.quick-stats {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(10px);
    border-radius: var(--radius-lg);
    border: 1px solid rgba(255, 255, 255, 0.5);
}

.stat-item {
    text-align: center;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-800);
}

.stat-value.video {
    color: #ff0000;
}

.stat-value.image {
    color: var(--primary);
}

.stat-label {
    font-size: 0.75rem;
    color: var(--gray-500);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.stat-divider {
    width: 1px;
    height: 40px;
    background: var(--gray-200);
}

/* ============================================
   Toast Notifications
   ============================================ */
.toast-container {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.toast {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    background: white;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-xl);
    animation: slide-up 0.3s ease;
    min-width: 300px;
}

.toast.success {
    border-left: 4px solid var(--success);
}

.toast.error {
    border-left: 4px solid var(--danger);
}

.toast-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
}

.toast.success .toast-icon {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.toast.error .toast-icon {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

.toast-message {
    flex: 1;
    font-size: 0.875rem;
    color: var(--gray-700);
}

/* ============================================
   Responsive Adjustments
   ============================================ */
@media (max-width: 768px) {
    .becas-admin-wrapper {
        padding: 1rem;
    }

    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .type-selector {
        grid-template-columns: 1fr;
    }

    .admin-grid {
        gap: 1.5rem;
    }

    .sidebar-sticky {
        position: relative;
        top: 0;
    }
}
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize CKEditor
    if(document.querySelector('#header_info')) {
        ClassicEditor
            .create(document.querySelector('#header_info'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
                language: 'es'
            })
            .catch(error => console.error(error));
    }

    // Dropzone Enhancement
    const dropzone = document.getElementById('drop-hero-image');
    const heroInput = document.getElementById('hero_image_input');
    
    if(dropzone && heroInput) {
        ['dragenter', 'dragover'].forEach(event => {
            dropzone.addEventListener(event, (e) => {
                e.preventDefault();
                dropzone.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(event => {
            dropzone.addEventListener(event, (e) => {
                e.preventDefault();
                dropzone.classList.remove('dragover');
            });
        });

        dropzone.addEventListener('drop', (e) => {
            if(e.dataTransfer.files.length) {
                heroInput.files = e.dataTransfer.files;
                updateFileName(heroInput);
            }
        });

        heroInput.addEventListener('change', () => updateFileName(heroInput));
    }

    // Document file inputs
    document.querySelectorAll('.doc-upload-area input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            if(this.files[0]) {
                const label = this.nextElementSibling;
                label.innerHTML = `<i class="fas fa-check-circle"></i><span>${this.files[0].name}</span>`;
                label.style.borderColor = 'var(--success)';
                label.style.color = 'var(--success)';
            }
        });
    });

    // Form submission
    const form = document.getElementById('becasForm');
    const saveBtn = form.querySelector('.save-button');
    
    form.addEventListener('submit', function() {
        saveBtn.classList.add('loading');
    });
});

function updateFileName(input) {
    const dropzone = input.closest('.dropzone');
    const fileName = dropzone.querySelector('.file-name');
    
    if(input.files[0]) {
        fileName.textContent = input.files[0].name;
        dropzone.classList.add('has-file');
    }
}

function setHeroType(type) {
    document.querySelectorAll('.type-option').forEach(opt => opt.classList.remove('active'));
    
    const imageSection = document.getElementById('hero-image-section');
    const videoSection = document.getElementById('hero-video-section');
    const typeImage = document.getElementById('type_image');
    const typeVideo = document.getElementById('type_video');

    if(type === 'image') {
        typeImage.checked = true;
        typeImage.closest('.type-option').classList.add('active');
        imageSection.classList.add('active');
        videoSection.classList.remove('active');
    } else {
        typeVideo.checked = true;
        typeVideo.closest('.type-option').classList.add('active');
        imageSection.classList.remove('active');
        videoSection.classList.add('active');
    }
}

function deleteFile(key) {
    if(confirm('¿Está seguro de eliminar este documento?')) {
        document.getElementById('deleteFileKey').value = key;
        document.getElementById('deleteFileForm').submit();
    }
}

function triggerUpload(key) {
    const uploadBox = document.getElementById('upload-box-' + key);
    const input = document.getElementById(key + '_file');
    
    uploadBox.classList.toggle('show');
    
    if(uploadBox.classList.contains('show')) {
        input.click();
    }
}

function testVideo() {
    const url = document.getElementById('hero_video_url').value;
    if(url) {
        window.open(url, '_blank');
    } else {
        showToast('Por favor ingrese una URL de video', 'error');
    }
}

function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <div class="toast-icon">
            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}"></i>
        </div>
        <span class="toast-message">${message}</span>
    `;
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<?php
$content = ob_get_clean();
$pageTitle = 'Administrar Becas';
$currentPage = 'becas';
require APP_PATH . '/Views/layouts/admin.php';
?>