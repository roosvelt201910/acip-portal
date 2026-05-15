<?php
// Banner Handling
$bannerImg = !empty($proceso['banner_url']) ? url($proceso['banner_url']) : asset('images/hero-bg.jpg');
$titulo = isset($proceso['titulo']) ? $proceso['titulo'] : 'Proceso de Admisión';
// Clean Title
$displayTitle = (stripos($titulo, 'Admisión') !== false) ? $titulo : 'Admisión ' . $titulo;
?>

<style>
/* PREMIUM ADMISSION THEME */
:root {
    --adm-primary: #002d72; /* Navy Blue */
    --adm-secondary: #cca300; /* Gold/Bronze */
    --adm-accent: #0056b3; /* Lighter Blue */
    --adm-dark: #1a1a1a;
    --adm-light: #f4f6f9;
    --adm-white: #ffffff;
    --font-heading: 'Montserrat', sans-serif;
    --font-body: 'Inter', sans-serif;
}

body {
    background-color: var(--adm-light);
    font-family: var(--font-body);
    color: var(--adm-dark);
}

/* 1. HERO SECTION */
.adm-hero {
    position: relative;
    height: 500px;
    background-color: var(--adm-primary);
    overflow: hidden;
}
.adm-hero-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.4; /* Darken for text readability */
    transform: scale(1.05);
    animation: slowZoom 20s infinite alternate;
}
.adm-hero-content {
    position: absolute;
    top: 50%;
    left: 0;
    width: 100%;
    transform: translateY(-60%); /* Move up slightly to account for floating bar */
    z-index: 2;
    text-align: center;
}
.adm-badge {
    display: inline-block;
    background: var(--adm-secondary);
    color: var(--adm-primary);
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 1px;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 15px rgba(204, 163, 0, 0.4);
}
.adm-title {
    font-family: var(--font-heading);
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    text-shadow: 0 4px 10px rgba(0,0,0,0.5);
    margin-bottom: 1rem;
    line-height: 1.1;
}
.adm-subtitle {
    font-size: 1.25rem;
    color: rgba(255,255,255,0.9);
    font-weight: 300;
    max-width: 700px;
    margin: 0 auto 2rem;
}

@keyframes slowZoom {
    from { transform: scale(1.0); }
    to { transform: scale(1.1); }
}

/* 2. FLOATING INFO BAR (FIXED & POLISHED) */
.adm-info-bar {
    position: relative;
    margin-top: -100px; /* Stronger overlap */
    z-index: 10;
    margin-bottom: 4rem;
}
.adm-info-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 1.25rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08); /* Softer, deeper shadow */
    height: 100%;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    border-bottom: 4px solid var(--adm-secondary);
    display: flex;
    align-items: center;
    border: 1px solid rgba(0,0,0,0.02);
}
.adm-info-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
}
.adm-icon-box {
    width: 56px;
    height: 56px;
    background: #f0f7ff; /* Very light blue */
    color: var(--adm-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    margin-right: 1.25rem;
    flex-shrink: 0;
    transition: all 0.3s;
}
.adm-info-card:hover .adm-icon-box {
    background: var(--adm-primary);
    color: white;
}
.adm-info-text h6 {
    font-weight: 800;
    margin: 0 0 0.25rem 0;
    color: var(--adm-primary);
    font-family: var(--font-heading);
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.adm-info-text span {
    font-size: 0.9rem;
    color: #555;
    font-weight: 500;
}

/* 3. STEPS - ICONIC HORIZONTAL TIMELINE */
.adm-steps-section {
    padding: 5rem 0 7rem;
    position: relative;
    background-color: #ffffff;
    background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
    background-size: 20px 20px;
}
/* Ensure row is relative for absolute positioning of line */
.adm-steps-row {
    position: relative;
}
.adm-step-item {
    text-align: center;
    position: relative;
    padding: 0 1.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    z-index: 2;
}
.adm-step-icon-wrapper {
    position: relative;
    margin-bottom: 30px;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
/* The Circle */
.adm-step-circle {
    width: 90px;
    height: 90px;
    background: white;
    color: var(--adm-primary);
    font-size: 2.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid var(--adm-primary);
    box-shadow: 0 10px 25px rgba(0,45,114,0.15);
    position: relative;
    z-index: 2;
}

/* Hover Effects */
.adm-step-item:hover .adm-step-circle {
    background: var(--adm-primary);
    color: var(--adm-secondary);
    border-color: var(--adm-secondary);
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,45,114,0.3);
}

.adm-step-title {
    font-weight: 800;
    color: var(--adm-primary);
    margin-bottom: 0.75rem;
    font-size: 1.2rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.adm-step-desc {
    font-size: 0.95rem;
    color: #64748b;
    line-height: 1.6;
    max-width: 260px;
}

/* Horizontal Connector (Desktop) */
@media (min-width: 992px) {
    .adm-steps-row {
        display: flex;
        justify-content: center;
    }
    /* Gray Base Line */
    .adm-steps-row::before {
        content: '';
        position: absolute;
        top: 45px; /* Center of 90px circle */
        left: 12.5%; /* Adjust based on column width */
        width: 75%;
        height: 4px;
        background-color: #e2e8f0;
        z-index: 0;
        border-radius: 4px;
    }
    /* Dynamic Progress Line (Controlled by JS) */
    .adm-progress-bar {
        position: absolute;
        top: 45px;
        left: 12.5%;
        width: 0%; /* Start at 0 */
        height: 4px;
        background-color: var(--adm-secondary);
        z-index: 1;
        border-radius: 4px;
        transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
}

@media (max-width: 991.98px) {
    .adm-step-item { margin-bottom: 4rem; }
    .adm-progress-bar { display: none; }
    /* Vertical Line for Mobile */
    .adm-step-item::before {
        content: '';
        position: absolute;
        top: 90px;
        left: 50%;
        width: 3px;
        height: 60px; /* Gap filler */
        background: #e2e8f0;
        transform: translateX(-50%);
        z-index: 0;
    }
    .adm-step-item:last-child::before { display: none; }
}

/* 4. CONTENT GRID */
.adm-section-title {
    font-family: var(--font-heading);
    font-weight: 700;
    color: var(--adm-primary);
    font-size: 1.75rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e0e0e0;
    position: relative;
}
.adm-section-title::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 60px;
    height: 2px;
    background: var(--adm-secondary);
}

.adm-card {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    margin-bottom: 2rem;
}

/* Requirements List */
.adm-req-list {
    list-style: none;
    padding: 0;
}
.adm-req-item {
    display: block; /* Changed from flex to block to support tables/rich text */
    margin-bottom: 1rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 6px;
    border-left: 4px solid var(--adm-accent);
    overflow-x: auto; /* Handle wide tables */
}
.adm-req-item table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 0;
}
.adm-req-item table td, .adm-req-item table th {
    padding: 1rem;
    vertical-align: top;
    border: 1px solid #dee2e6; /* Match Bootstrap/CKEditor default border look */
}
}
.adm-req-icon {
    margin-right: 1rem;
    color: var(--adm-accent);
    font-size: 1.2rem;
}

/* Sidebar Widgets */
.adm-widget {
    background: white;
    border-radius: 8px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    margin-bottom: 2rem;
    overflow: hidden;
}
.adm-widget-header {
    background: var(--adm-primary);
    color: white;
    padding: 1rem 1.5rem;
    font-weight: 700;
}
.adm-widget-body {
    padding: 1.5rem;
}
.btn-download {
    display: block;
    background: #f8f9fa;
    color: var(--adm-dark);
    padding: 1rem;
    border-radius: 6px;
    border: 1px solid #e0e0e0;
    font-weight: 600;
    transition: all 0.3s;
    text-align: center;
}
.btn-download:hover {
    background: var(--adm-secondary);
    color: white;
    border-color: var(--adm-secondary);
    text-decoration: none;
}

/* Responsive */
@media (max-width: 991.98px) {
    .adm-title { font-size: 2.5rem; }
    .adm-hero { height: 400px; }
    .adm-info-bar { margin-top: -60px; }
    /* Ensure they don't stack weirdly on tablets */
    .adm-info-card { margin-bottom: 1rem; min-height: 100px; }
}
@media (max-width: 767.98px) {
    .adm-info-bar { margin-top: -40px; }
    .adm-hero-content { transform: translateY(-50%); }
    .adm-step-item { margin-bottom: 3.5rem; }
    .adm-steps-section { padding: 4rem 0; }
}
</style>

<!-- 1. HERO SECTION -->
<div class="adm-hero">
    <div style="background: linear-gradient(rgba(0,45,114,0.8), rgba(0,45,114,0.6)); position: absolute; width: 100%; height: 100%; z-index: 1;"></div>
    <img src="<?= $bannerImg ?>" alt="Institución" class="adm-hero-img">
    
    <div class="container h-100 position-relative">
        <div class="adm-hero-content animate-up">
            <span class="adm-badge">Convocatoria Oficial</span>
            <h1 class="adm-title"><?= e($displayTitle) ?></h1>
            <p class="adm-subtitle">Forma parte de una comunidad académica de primer nivel. Tu éxito profesional está garantizado con nosotros.</p>
            
            <?php if (isset($proceso['activo']) && $proceso['activo']): ?>
                <a href="#requisitos" class="btn btn-lg px-5 py-3 rounded-pill font-weight-bold shadow mr-2" style="background-color: #ffffff !important; color: #002d72 !important; border-color: #ffffff !important;">
                    <i class="fas fa-file-alt mr-2"></i> Ver Requisitos
                </a>
            <?php else: ?>
                <button class="btn btn-secondary btn-lg px-5 py-3 rounded-pill font-weight-bold shadow disabled">
                    <i class="fas fa-lock mr-2"></i> Proceso Cerrado
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- 2. FLOATING INFO BAR -->
<div class="container adm-info-bar animate-up delay-1">
    <div class="row">
        <!-- Date Stats -->
        <div class="col-md-6 col-lg-3 mb-5">
            <div class="adm-info-card">
                <div class="adm-icon-box"><i class="far fa-calendar-alt"></i></div>
                <div class="adm-info-text">
                    <h6>Inscripciones</h6>
                    <span><?= isset($proceso['fecha_inicio']) ? date('d/m/Y', strtotime($proceso['fecha_inicio'])) : 'Pendiente' ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-5">
            <div class="adm-info-card">
                <div class="adm-icon-box"><i class="far fa-calendar-times"></i></div>
                <div class="adm-info-text">
                    <h6>Cierre</h6>
                    <span><?= isset($proceso['fecha_fin']) ? date('d/m/Y', strtotime($proceso['fecha_fin'])) : 'Pendiente' ?></span>
                </div>
            </div>
        </div>
        <!-- Result Link -->
        <div class="col-md-6 col-lg-3 mb-5">
            <a href="<?= url('admision/resultados') ?>" style="text-decoration: none; color: inherit; display: block; height: 100%;">
                <div class="adm-info-card" style="border-bottom-color: var(--adm-accent);">
                    <div class="adm-icon-box" style="background: var(--adm-accent); color: white;"><i class="fas fa-search"></i></div>
                    <div class="adm-info-text">
                        <h6>Resultados</h6>
                        <span>Ver lista de ingresantes</span>
                    </div>
                </div>
            </a>
        </div>
        <!-- Contact -->
        <div class="col-md-6 col-lg-3 mb-5">
            <div class="adm-info-card" style="border-bottom-color: #25D366;">
                <div class="adm-icon-box" style="color: #25D366;"><i class="fab fa-whatsapp"></i></div>
                <div class="adm-info-text">
                    <h6>Contacto</h6>
                    <span><?= e(site_config('site_phone', '942 551 451')) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. STEPS TO ADMISSION (ICONS) -->
<div class="container adm-steps-section">
    <div class="text-center mb-5 pb-3">
        <h2 class="adm-section-title d-inline-block">Tu Camino al Éxito</h2>
        <p class="text-muted mt-2 h5 font-weight-light">4 pasos simples para iniciar tu carrera profesional</p>
    </div>
    <div class="row adm-steps-row position-relative">
        
        <!-- Interactive Progress Line -->
        <div class="adm-progress-bar"></div>
        
        <!-- Step 1: Pago -->
        <div class="col-lg-3 col-md-6 adm-step-item animate-up delay-1" onmouseenter="updateProgress(0)">
            <div class="adm-step-icon-wrapper">
                <div class="adm-step-circle">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
            </div>
            <h5 class="adm-step-title">1. Pago</h5>
            <p class="adm-step-desc">Realiza el pago por derecho de examen en nuestra tesorería o agentes autorizados.</p>
        </div>

        <!-- Step 2: Inscripción -->
        <div class="col-lg-3 col-md-6 adm-step-item animate-up delay-2" onmouseenter="updateProgress(25)">
            <div class="adm-step-icon-wrapper">
                <div class="adm-step-circle">
                    <i class="fas fa-user-edit"></i>
                </div>
            </div>
            <h5 class="adm-step-title">2. Inscripción</h5>
            <p class="adm-step-desc">Canjea tu voucher y registra tus datos personales en nuestra oficina de admisión.</p>
        </div>

        <!-- Step 3: Examen -->
        <div class="col-lg-3 col-md-6 adm-step-item animate-up delay-3" onmouseenter="updateProgress(50)">
             <div class="adm-step-icon-wrapper">
                <div class="adm-step-circle">
                    <i class="fas fa-file-signature"></i>
                </div>
            </div>
            <h5 class="adm-step-title">3. Examen</h5>
            <p class="adm-step-desc">Asiste puntualmente al examen de conocimientos en la fecha y hora programada.</p>
        </div>

        <!-- Step 4: Resultados -->
        <div class="col-lg-3 col-md-6 adm-step-item animate-up delay-4" onmouseenter="updateProgress(75)">
             <div class="adm-step-icon-wrapper">
                <div class="adm-step-circle">
                    <i class="fas fa-trophy"></i>
                </div>
            </div>
            <h5 class="adm-step-title">4. Ingreso</h5>
            <p class="adm-step-desc">¡Felicidades! Consulta tu resultado y gestiona tu matrícula inmediata.</p>
        </div>

    </div>
</div>

<!-- 4. MAIN CONTENT GRID -->
<div class="container pb-5 mt-5" id="requisitos">
    <div class="row">
        <!-- Content Left -->
        <div class="col-lg-8 pr-lg-5">
            
            <?php if (isset($proceso['descripcion'])): ?>
                <div class="adm-card animate-up delay-2">
                    <h3 class="adm-section-title mb-5">Información General</h3>
                    <div class="lead text-muted" style="line-height: 1.8;">
                        <?= nl2br(e($proceso['descripcion'])) ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="adm-card animate-up delay-2">
                <h3 class="adm-section-title">Requisitos de Admisión</h3>
                <?php if (!empty($requisitos)): ?>
                    <ul class="adm-req-list">
                        <?php foreach ($requisitos as $req): ?>
                            <li class="adm-req-item">
                                <!-- Icon removed to allow full editor control or replaced logic -->
                                <div class="w-100">
                                    <?= $req['descripcion'] ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">No se han especificado requisitos.</p>
                <?php endif; ?>
            </div>

            <div class="adm-card animate-up delay-3">
                <h3 class="adm-section-title">Modalidades de Ingreso</h3>
                <?php if (!empty($modalidades)): ?>
                    <div class="row">
                        <?php foreach ($modalidades as $mod): ?>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 border rounded h-100 bg-light">
                                    <h5 class="adm-section-subtitle font-weight-bold text-primary mb-2"><?= e($mod['titulo']) ?></h5>
                                    <div class="small text-muted mb-0"><?= $mod['descripcion'] ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Información pendiente.</p>
                <?php endif; ?>
            </div>

        </div>

        <!-- Sidebar Right -->
        <div class="col-lg-4 animate-up delay-2">
            
            <!-- Calendar Widget -->
            <?php if (!empty($proceso['calendario_url'])): ?>
                <div class="adm-widget">
                    <div class="adm-widget-header">
                        <i class="fas fa-calendar-alt mr-2"></i> Cronograma
                    </div>
                    <div class="adm-widget-body p-0">
                        <img src="<?= url($proceso['calendario_url']) ?>" alt="Calendario" class="img-fluid w-100">
                    </div>
                    <div class="p-3 text-center bg-light border-top">
                        <a href="<?= url($proceso['calendario_url']) ?>" target="_blank" class="small font-weight-bold">
                            <i class="fas fa-search-plus"></i> Ampliar Imagen
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Resultados Widget -->
            <?php if (!empty($resultadosArchivos)): ?>
                <div class="adm-widget animate-up delay-3">
                     <div class="adm-widget-header" style="background-color: #095899ff; color: white;">
                        <i class="fas fa-clipboard-check mr-2"></i> Resultados
                    </div>
                    <div class="adm-widget-body bg-light">
                        <?php
                            // Group files
                            $groupedPublic = ['General' => []];
                            foreach ($resultadosArchivos as $file) {
                                $key = !empty($file['programa_nombre']) ? $file['programa_nombre'] : 'General';
                                if (!isset($groupedPublic[$key])) {
                                    $groupedPublic[$key] = [];
                                }
                                $groupedPublic[$key][] = $file;
                            }
                        ?>
                        
                        <!-- Tabs Header -->
                        <div class="public-tabs-header">
                            <?php $pIndex = 0; ?>
                            <?php foreach ($groupedPublic as $groupName => $files): ?>
                                <?php if (empty($files) && $groupName !== 'General') continue; ?>
                                <button class="public-tab-btn <?= $pIndex === 0 ? 'active' : '' ?>" onclick="switchPublicTab(this, 'pub-content-<?= md5($groupName) ?>')">
                                    <?= $groupName ?>
                                </button>
                                <?php $pIndex++; ?>
                            <?php endforeach; ?>
                        </div>

                        <!-- Tabs Content -->
                        <div class="public-tabs-content">
                            <?php $pIndex = 0; ?>
                            <?php foreach ($groupedPublic as $groupName => $files): ?>
                                <?php if (empty($files) && $groupName !== 'General') continue; ?>
                                <div id="pub-content-<?= md5($groupName) ?>" class="public-tab-pane <?= $pIndex === 0 ? 'active' : '' ?>">
                                    <div class="row no-gutters">
                                        <?php foreach ($files as $archivo): ?>
                                            <div class="col-12 mb-3">
                                                <div class="macos-file-item" onclick="openPublicPreview('<?= url($archivo['archivo_url']) ?>', '<?= e($archivo['titulo']) ?>')">
                                                    <div class="macos-icon-sm">
                                                        <div class="macos-icon-corner"></div>
                                                        <div class="macos-icon-type">PDF</div>
                                                        <i class="fas fa-file-pdf text-danger"></i>
                                                    </div>
                                                    <div class="macos-file-info">
                                                        <span class="macos-file-title"><?= e($archivo['titulo']) ?></span>
                                                        <?php if (!empty($archivo['programa_nombre'])): ?>
                                                            <small class="text-secondary" style="font-size: 0.7rem;"><i class="fas fa-graduation-cap"></i> <?= e($archivo['programa_nombre']) ?></small>
                                                        <?php endif; ?>
                                                        <span class="macos-file-action">Ver Documento</span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <?php if(empty($files)): ?>
                                            <div class="col-12 text-center py-4 text-muted small">
                                                No hay resultados en esta sección.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php $pIndex++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Downloads -->
            <div class="adm-widget animate-up delay-2">
                <div class="adm-widget-header">
                    <i class="fas fa-download mr-2"></i> Descargas
                </div>
                <div class="adm-widget-body bg-light">
                     <div class="row no-gutters">
                        <?php if (!empty($documentos)): ?>
                            <?php foreach ($documentos as $doc): ?>
                                <div class="col-12 mb-3">
                                     <div class="macos-file-item" onclick="openPublicPreview('<?= url($doc['archivo_url']) ?>', '<?= e($doc['titulo']) ?>')">
                                        <div class="macos-icon-sm">
                                            <div class="macos-icon-corner"></div>
                                            <div class="macos-icon-type">PDF</div>
                                            <i class="fas fa-file-pdf text-danger"></i>
                                        </div>
                                        <div class="macos-file-info">
                                            <span class="macos-file-title"><?= e($doc['titulo']) ?></span>
                                            <span class="macos-file-action">Descargar/Ver</span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 p-4 text-center text-muted">
                                No hay documentos disponibles.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Public Preview Modal -->
            <div id="publicPdfModal" class="public-modal-overlay" style="display: none;">
                <div class="public-modal-container">
                    <div class="public-modal-header">
                        <h5 class="public-modal-title" id="publicModalTitle">Vista Previa</h5>
                        <button type="button" class="public-close-btn" onclick="closePublicModal()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="public-modal-body">
                        <iframe id="publicModalFrame" src="" width="100%" height="100%" style="border: none;"></iframe>
                    </div>
                </div>
            </div>

            <style>
            /* macOS File Style for Widget */
            .macos-file-item {
                display: flex;
                align-items: center;
                background: white;
                padding: 10px;
                border-radius: 8px;
                cursor: pointer;
                transition: transform 0.2s, box-shadow 0.2s;
                border: 1px solid #e2e8f0;
            }
            .macos-file-item:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            }
            .macos-icon-sm {
                width: 36px;
                height: 48px;
                background: white;
                border: 1px solid #cbd5e1;
                border-radius: 4px;
                position: relative;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin-right: 12px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }
            .macos-icon-corner {
                position: absolute;
                top: 0;
                right: 0;
                border-width: 0 10px 10px 0;
                border-style: solid;
                border-color: #f1f5f9 #fff;
                background: #cbd5e1;
                display: block;
                width: 0;
                border-bottom-left-radius: 2px;
            }
            .macos-icon-type {
                font-size: 6px;
                font-weight: 800;
                color: #ef4444;
                margin-bottom: 2px;
            }
            .macos-icon-sm i {
                font-size: 18px;
            }
            .macos-file-info {
                flex: 1;
                display: flex;
                flex-direction: column;
                overflow: hidden;
            }
            .macos-file-title {
                font-weight: 600;
                color: #334155;
                font-size: 0.9rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .macos-file-action {
                font-size: 0.75rem;
                color: #64748b;
            }

            /* Modal Styles */
            .public-modal-overlay {
                position: fixed;
                top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.6);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
                backdrop-filter: blur(3px);
            }
            .public-modal-container {
                background: white;
                width: 90%;
                max-width: 900px;
                height: 85vh;
                border-radius: 8px;
                display: flex;
                flex-direction: column;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }
            .public-modal-header {
                padding: 1rem;
                border-bottom: 1px solid #e2e8f0;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .public-modal-title { margin: 0; font-size: 1.1rem; }
            .public-modal-body { flex: 1; overflow: hidden; background: #f1f5f9; }
            .public-close-btn {
                background: none;
                border: none;
                font-size: 1.2rem;
                cursor: pointer;
                color: #64748b;
            }
            .public-close-btn:hover { color: #0f172a; }

            /* Public Widget Tabs */
            .public-tabs-header {
                display: flex;
                overflow-x: auto;
                background: #f1f5f9;
                border-bottom: 1px solid #e2e8f0;
                padding: 4px;
                gap: 4px;
            }
            .public-tab-btn {
                padding: 6px 12px;
                border: none;
                background: transparent;
                font-size: 0.8rem;
                font-weight: 600;
                color: #64748b;
                border-radius: 4px;
                cursor: pointer;
                white-space: nowrap;
                transition: all 0.2s;
            }
            .public-tab-btn:hover {
                background: rgba(0,0,0,0.05);
                color: #334155;
            }
            .public-tab-btn.active {
                background: white;
                color: #28a745; /* Green to match widget header */
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            .public-tabs-content {
                padding: 10px;
                min-height: 100px;
            }
            .public-tab-pane {
                display: none;
                animation: fadeIn 0.3s ease;
            }
            .public-tab-pane.active {
                display: block;
            }
            </style>

            <script>
            function switchPublicTab(btn, targetId) {
                // Remove active class from buttons buttons in this container
                let container = btn.closest('.adm-widget-body');
                container.querySelectorAll('.public-tab-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                // Hide panes
                container.querySelectorAll('.public-tab-pane').forEach(p => p.classList.remove('active'));
                document.getElementById(targetId).classList.add('active');
            }

            function openPublicPreview(url, title) {
                if(url === '#') return;
                document.getElementById('publicModalFrame').src = url;
                document.getElementById('publicModalTitle').textContent = title;
                document.getElementById('publicPdfModal').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
            function closePublicModal() {
                document.getElementById('publicPdfModal').style.display = 'none';
                document.getElementById('publicModalFrame').src = '';
                document.body.style.overflow = 'auto';
            }
            document.getElementById('publicPdfModal').addEventListener('click', function(e) {
                if (e.target === this) closePublicModal();
            });
            </script>

            <!-- Help Contact -->
            <div class="adm-widget">
                <div class="adm-widget-header bg-dark">
                    <i class="fas fa-headset mr-2"></i> ¿Necesitas Ayuda?
                </div>
                <div class="adm-widget-body">
                    <p class="small text-muted mb-3">Si tienes dudas sobre el proceso, contáctanos:</p>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-phone mr-2 text-primary"></i> <?= e(site_config('site_phone', '+51 942 551 451')) ?></li>
                        <li class="mb-2"><i class="fas fa-envelope mr-2 text-primary"></i> <?= e(site_config('site_email', 'admision@acip.edu.pe')) ?></li>
                        <li><i class="fas fa-map-marker-alt mr-2 text-primary"></i> <?= e(site_config('site_direccion', 'Jr. Pajaten 232')) ?></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function updateProgress(width) {
    if (window.innerWidth >= 992) {
        var bar = document.querySelector('.adm-progress-bar');
        if(bar) bar.style.width = width + '%';
    }
}
</script>
