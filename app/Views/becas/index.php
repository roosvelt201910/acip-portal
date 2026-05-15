<?php ob_start(); ?>

<?php 
// Configuration
$heroType = $becas['hero_type']['contenido'] ?? 'image';
$heroVideo = $becas['hero_video']['contenido'] ?? '';
$heroImage = $becas['hero_image']['archivo_url'] ?? '';

$hasVideo = $heroType === 'video' && !empty($heroVideo);
$hasImage = !empty($heroImage);

// Default Style
$heroStyle = ""; 

if (!$hasVideo && $hasImage) {
    $imageUrl = url($heroImage);
    $heroStyle = "background-image: url('{$imageUrl}');";
}
?>

<div class="becas-page">


    <!-- Hero Section -->
    <section class="hero-section <?= $hasVideo ? 'has-video' : '' ?>" style="<?= htmlspecialchars($heroStyle) ?>">
        <!-- Gradient Overlay -->
        <div class="hero-overlay"></div>
        
        <!-- Decorative Elements -->
        <div class="hero-pattern"></div>
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
        
        <?php if ($hasVideo): ?>
            <?php 
                preg_match('/(?:v=|\/)([\w-]{11})(?:&|\?|\/|$)/', $heroVideo, $matches);
                $videoId = $matches[1] ?? '';
                $embedUrl = "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=1&controls=0&loop=1&playlist={$videoId}&showinfo=0&rel=0&iv_load_policy=3&disablekb=1&modestbranding=1";
            ?>
            <div class="video-background">
                <iframe src="<?= $embedUrl ?>" frameborder="0" allow="autoplay; encrypted-media"></iframe>
            </div>
        <?php endif; ?>

        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">
                    <div class="badge-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <span>Programa de Apoyo Estudiantil 2026</span>
                </div>
                
                <h1 class="hero-title">
                    Becas y <br>
                    <span class="text-gradient">Créditos</span>
                </h1>
                
                <p class="hero-description">
                    Brindamos oportunidades de desarrollo académico a estudiantes destacados 
                    del Instituto de Educación Superior Privado "ACIP
                </p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number" data-count="4">4</div>
                        <div class="stat-label">Modalidades</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Gratuito</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-number">2025</div>
                        <div class="stat-label">Convocatoria</div>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="#documentos" class="btn-primary-hero">
                        <i class="fas fa-file-alt"></i>
                        <span>Ver Documentos</span>
                    </a>
                    <a href="#requisitos" class="btn-secondary-hero">
                        <i class="fas fa-info-circle"></i>
                        <span>Más Información</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Bottom Wave -->
        <div class="hero-bottom">
            <svg viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path d="M0,0 C280,100 720,100 1440,0 L1440,100 L0,100 Z" fill="#f8fafc"/>
            </svg>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content" id="requisitos">
        <div class="container">
            
            <!-- Institution Info Card -->
            <section class="institution-card">
                <div class="card-accent"></div>
                <div class="card-content">
                    <div class="card-header">
                        <div class="institution-logo">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="institution-info">
                            <span class="institution-label">Comunicado Oficial</span>
                            <h2 class="institution-title">Información de la Convocatoria</h2>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="info-content">
                            <?= $becas['header_info']['contenido'] ?? '<p>Información pendiente de actualización.</p>' ?>
                        </div>
                        
                        <div class="info-highlights">
                            <div class="highlight-item">
                                <div class="highlight-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="highlight-text">
                                    <span class="highlight-label">Proceso</span>
                                    <span class="highlight-value">Semestre 2026-I</span>
                                </div>
                            </div>
                            <div class="highlight-item">
                                <div class="highlight-icon">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="highlight-text">
                                    <span class="highlight-label">Dirigido a</span>
                                    <span class="highlight-value">Estudiantes Regulares</span>
                                </div>
                            </div>
                            <div class="highlight-item">
                                <div class="highlight-icon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="highlight-text">
                                    <span class="highlight-label">Unidad</span>
                                    <span class="highlight-value">Bienestar Social</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Documents Section -->
            <section class="documents-section" id="documentos">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div class="section-title-content">
                        <h2 class="section-title">Documentos de la Convocatoria</h2>
                        <p class="section-subtitle">Relación de estudiantes aptos según modalidad de beca</p>
                    </div>
                </div>

                <div class="documents-grid">
                    <?php 
                    $meritos = [
                        'merito_1' => [
                            'icon' => 'trophy', 
                            'color' => 'gold', 
                            'label' => 'Primer Puesto',
                            'benefit' => 'Beca Completa',
                            'description' => 'Exoneración total de pagos académicos'
                        ],
                        'merito_2' => [
                            'icon' => 'medal', 
                            'color' => 'silver', 
                            'label' => 'Segundo Puesto',
                            'benefit' => 'Media Beca',
                            'description' => 'Exoneración del 50% de pagos'
                        ],
                        'condicion_hermanos' => [
                            'icon' => 'users', 
                            'color' => 'blue', 
                            'label' => 'Condición Hermanos',
                            'benefit' => 'Semi Beca',
                            'description' => 'Beneficio para hermanos estudiando'
                        ],
                        'servicio_militar' => [
                            'icon' => 'shield-alt', 
                            'color' => 'green', 
                            'label' => 'Servicio Militar',
                            'benefit' => 'Beca Especial',
                            'description' => 'Para licenciados del servicio militar'
                        ]
                    ];

                    $index = 0;
                    foreach ($meritos as $key => $meta): 
                        $data = $becas[$key] ?? ['contenido' => 'Pendiente de actualización', 'archivo_url' => ''];
                        $hasFile = !empty($data['archivo_url']);
                        $index++;
                    ?>
                    <article class="document-card" style="--delay: <?= $index * 0.1 ?>s">
                        <div class="card-top-border <?= $meta['color'] ?>"></div>
                        
                        <div class="card-header">
                            <div class="card-icon <?= $meta['color'] ?>">
                                <i class="fas fa-<?= $meta['icon'] ?>"></i>
                            </div>
                            <div class="card-number"><?= str_pad($index, 2, '0', STR_PAD_LEFT) ?></div>
                        </div>
                        
                        <div class="card-body">
                            <span class="card-benefit <?= $meta['color'] ?>"><?= $meta['benefit'] ?></span>
                            <h3 class="card-title"><?= $meta['label'] ?></h3>
                            <p class="card-description"><?= $meta['description'] ?></p>
                            
                            <div class="card-detail">
                                <i class="fas fa-file-pdf"></i>
                                <span><?= htmlspecialchars($data['contenido']) ?></span>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <?php if ($hasFile): ?>
                                <a href="<?= url($data['archivo_url']) ?>" target="_blank" class="btn-document available">
                                    <div class="btn-content">
                                        <i class="fas fa-eye"></i>
                                        <span>Ver Documento</span>
                                    </div>
                                    <div class="btn-icon">
                                        <i class="fas fa-external-link-alt"></i>
                                    </div>
                                </a>
                                <a href="<?= url($data['archivo_url']) ?>" download class="btn-download">
                                    <i class="fas fa-download"></i>
                                </a>
                            <?php else: ?>
                                <button disabled class="btn-document unavailable">
                                    <div class="btn-content">
                                        <i class="fas fa-clock"></i>
                                        <span>Próximamente</span>
                                    </div>
                                    <div class="btn-icon">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </button>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($hasFile): ?>
                            <div class="card-status available">
                                <i class="fas fa-check-circle"></i>
                                <span>Disponible</span>
                            </div>
                        <?php else: ?>
                            <div class="card-status pending">
                                <i class="fas fa-hourglass-half"></i>
                                <span>Pendiente</span>
                            </div>
                        <?php endif; ?>
                    </article>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Process Timeline -->
            <section class="process-section">
                <div class="section-header centered">
                    <h2 class="section-title">Proceso de Postulación</h2>
                    <p class="section-subtitle">Sigue estos pasos para acceder a los beneficios</p>
                </div>
                
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            <span>1</span>
                        </div>
                        <div class="timeline-content">
                            <h4>Verificar Requisitos</h4>
                            <p>Revisa los documentos y confirma que cumples con los requisitos de la modalidad elegida.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            <span>2</span>
                        </div>
                        <div class="timeline-content">
                            <h4>Presentar Documentación</h4>
                            <p>Acércate a la oficina de Bienestar Social con tu expediente completo.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            <span>3</span>
                        </div>
                        <div class="timeline-content">
                            <h4>Evaluación</h4>
                            <p>El comité evaluador revisará tu solicitud y documentación presentada.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            <span>4</span>
                        </div>
                        <div class="timeline-content">
                            <h4>Publicación de Resultados</h4>
                            <p>Los resultados serán publicados en esta página y en los canales oficiales.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact CTA -->
            <section class="contact-cta">
                <div class="cta-content">
                    <div class="cta-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="cta-text">
                        <h3>¿Tienes dudas sobre el proceso?</h3>
                        <p>Nuestro equipo de Bienestar Social está disponible para orientarte</p>
                    </div>
                    <div class="cta-actions">
                        <a href="tel:+51042551451" class="cta-btn phone">
                            <i class="fas fa-phone-alt"></i>
                            <span>Llamar Ahora</span>
                        </a>
                        <a href="mailto:bienestar@iespacip.edu.pe" class="cta-btn email">
                            <i class="fas fa-envelope"></i>
                            <span>Enviar Correo</span>
                        </a>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <!-- Footer -->

</div>

<style>
/* ============================================
   CSS Variables
   ============================================ */
:root {
    /* Primary Colors - Professional Blue */
    --primary-50: #eff6ff;
    --primary-100: #dbeafe;
    --primary-200: #bfdbfe;
    --primary-300: #93c5fd;
    --primary-400: #60a5fa;
    --primary-500: #3b82f6;
    --primary-600: #2563eb;
    --primary-700: #1d4ed8;
    --primary-800: #1e40af;
    --primary-900: #1e3a8a;
    --primary-950: #172554;
    
    /* Secondary - Institutional Red */
    --secondary-500: #ef4444;
    --secondary-600: #dc2626;
    --secondary-700: #b91c1c;
    
    /* Neutrals */
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
    
    /* Accent Colors */
    --gold: #f59e0b;
    --gold-light: #fef3c7;
    --silver: #64748b;
    --silver-light: #f1f5f9;
    --success: #10b981;
    --success-light: #d1fae5;
    
    /* Shadows */
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    
    /* Transitions */
    --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
    --transition-normal: 300ms cubic-bezier(0.4, 0, 0.2, 1);
    --transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);
}

/* ============================================
   Base Styles
   ============================================ */
.becas-page {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background-color: var(--gray-50);
    color: var(--gray-800);
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* ============================================
   Top Bar
   ============================================ */
.top-bar {
    background: var(--primary-950);
    color: var(--gray-300);
    font-size: 0.8rem;
    padding: 0.5rem 0;
}

.top-bar-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.top-bar-left,
.top-bar-right {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.top-bar span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.top-bar i {
    color: var(--primary-400);
    font-size: 0.75rem;
}

/* ============================================
   Hero Section
   ============================================ */
.hero-section {
    position: relative;
    min-height: 600px;
    display: flex;
    align-items: center;
    background-color: var(--primary-900);
    background-size: cover;
    background-position: center;
    overflow: hidden;
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, 
        rgba(23, 37, 84, 0.95) 0%, 
        rgba(30, 64, 175, 0.85) 50%,
        rgba(29, 78, 216, 0.9) 100%
    );
    z-index: 1;
}

.hero-pattern {
    position: absolute;
    inset: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(255,255,255,0.03) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255,255,255,0.05) 0%, transparent 30%),
        url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    z-index: 2;
    pointer-events: none;
}

.hero-shapes {
    position: absolute;
    inset: 0;
    z-index: 2;
    pointer-events: none;
    overflow: hidden;
}

.shape {
    position: absolute;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 60%);
}

.shape-1 {
    width: 400px;
    height: 400px;
    top: -100px;
    right: -100px;
    animation: float 20s ease-in-out infinite;
}

.shape-2 {
    width: 300px;
    height: 300px;
    bottom: -50px;
    left: -50px;
    animation: float 25s ease-in-out infinite reverse;
}

.shape-3 {
    width: 200px;
    height: 200px;
    top: 50%;
    left: 60%;
    animation: float 15s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    25% { transform: translate(20px, -20px) rotate(5deg); }
    50% { transform: translate(-10px, 10px) rotate(-5deg); }
    75% { transform: translate(15px, 15px) rotate(3deg); }
}

.video-background {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100vw;
    height: 100vh;
    transform: translate(-50%, -50%) scale(1.2);
    z-index: 0;
    pointer-events: none;
    opacity: 0.4;
}

.video-background iframe {
    width: 100%;
    height: 100%;
}

.hero-content {
    position: relative;
    z-index: 10;
    max-width: 800px;
    padding: 4rem 0;
    color: white;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 1rem 0.5rem 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 50px;
    margin-bottom: 1.5rem;
    animation: fadeInDown 0.6s ease-out;
}

.badge-icon {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, var(--gold) 0%, #fbbf24 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    color: white;
}

.hero-badge span {
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--gray-200);
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 1.5rem;
    letter-spacing: -0.02em;
    animation: fadeInUp 0.6s ease-out;
}

.text-gradient {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #fcd34d 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-description {
    font-size: 1.15rem;
    color: var(--gray-300);
    margin-bottom: 2rem;
    max-width: 600px;
    line-height: 1.7;
    animation: fadeInUp 0.6s ease-out 0.1s both;
}

.hero-stats {
    display: flex;
    align-items: center;
    gap: 2rem;
    padding: 1.5rem 2rem;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    margin-bottom: 2rem;
    animation: fadeInUp 0.6s ease-out 0.2s both;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: white;
    line-height: 1;
}

.stat-label {
    font-size: 0.8rem;
    color: var(--gray-400);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-top: 0.25rem;
}

.stat-divider {
    width: 1px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
}

.hero-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    animation: fadeInUp 0.6s ease-out 0.3s both;
}

.btn-primary-hero,
.btn-secondary-hero {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.75rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: all var(--transition-normal);
}

.btn-primary-hero {
    background: linear-gradient(135deg, var(--gold) 0%, #d97706 100%);
    color: white;
    box-shadow: 0 4px 15px -3px rgba(245, 158, 11, 0.4);
}

.btn-primary-hero:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px -5px rgba(245, 158, 11, 0.5);
}

.btn-secondary-hero {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-secondary-hero:hover {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.3);
}

.hero-bottom {
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    z-index: 10;
    line-height: 0;
}

.hero-bottom svg {
    width: 100%;
    height: 80px;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ============================================
   Main Content
   ============================================ */
.main-content {
    padding: 4rem 0;
}

/* ============================================
   Institution Card
   ============================================ */
.institution-card {
    position: relative;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow-xl);
    margin-bottom: 4rem;
    margin-top: -4rem;
}

.card-accent {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-600) 0%, var(--primary-400) 50%, var(--gold) 100%);
}

.card-content {
    padding: 2.5rem;
}

.card-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--gray-100);
}

.institution-logo {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-800) 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    box-shadow: 0 8px 20px -5px rgba(37, 99, 235, 0.4);
}

.institution-label {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background: var(--primary-50);
    color: var(--primary-700);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-radius: 50px;
    margin-bottom: 0.5rem;
}

.institution-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0;
}

.card-body {
    display: grid;
    gap: 2rem;
}

.info-content {
    color: var(--gray-600);
    font-size: 1rem;
    line-height: 1.8;
}

.info-content p {
    margin-bottom: 1rem;
}

.info-content p:last-child {
    margin-bottom: 0;
}

.info-highlights {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.highlight-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    background: var(--gray-50);
    border-radius: 12px;
    border: 1px solid var(--gray-100);
}

.highlight-icon {
    width: 44px;
    height: 44px;
    background: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-600);
    font-size: 1.1rem;
    box-shadow: var(--shadow-sm);
}

.highlight-text {
    display: flex;
    flex-direction: column;
}

.highlight-label {
    font-size: 0.75rem;
    color: var(--gray-500);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.highlight-value {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--gray-800);
}

/* ============================================
   Documents Section
   ============================================ */
.documents-section {
    margin-bottom: 4rem;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    margin-bottom: 2.5rem;
}

.section-header.centered {
    flex-direction: column;
    text-align: center;
    gap: 0.5rem;
}

.section-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--secondary-500) 0%, var(--secondary-600) 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 8px 20px -5px rgba(220, 38, 38, 0.4);
}

.section-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0;
}

.section-subtitle {
    font-size: 1rem;
    color: var(--gray-500);
    margin: 0;
}

.documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

/* ============================================
   Document Card
   ============================================ */
.document-card {
    position: relative;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all var(--transition-normal);
    animation: fadeInUp 0.5s ease-out both;
    animation-delay: var(--delay);
}

.document-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
}

.card-top-border {
    height: 4px;
}

.card-top-border.gold { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
.card-top-border.silver { background: linear-gradient(90deg, #64748b, #94a3b8); }
.card-top-border.blue { background: linear-gradient(90deg, #2563eb, #3b82f6); }
.card-top-border.green { background: linear-gradient(90deg, #059669, #10b981); }

.document-card .card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 1.5rem 1.5rem 0;
    margin: 0;
    border: none;
}

.card-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.card-icon.gold { background: var(--gold-light); color: var(--gold); }
.card-icon.silver { background: var(--silver-light); color: var(--silver); }
.card-icon.blue { background: var(--primary-50); color: var(--primary-600); }
.card-icon.green { background: var(--success-light); color: var(--success); }

.card-number {
    font-size: 2rem;
    font-weight: 800;
    color: var(--gray-100);
    line-height: 1;
}

.document-card .card-body {
    padding: 1.25rem 1.5rem;
    display: block;
}

.card-benefit {
    display: inline-block;
    padding: 0.25rem 0.6rem;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    margin-bottom: 0.75rem;
}

.card-benefit.gold { background: var(--gold-light); color: #b45309; }
.card-benefit.silver { background: var(--silver-light); color: var(--gray-700); }
.card-benefit.blue { background: var(--primary-50); color: var(--primary-700); }
.card-benefit.green { background: var(--success-light); color: #047857; }

.card-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0 0 0.5rem 0;
}

.card-description {
    font-size: 0.85rem;
    color: var(--gray-500);
    margin: 0 0 1rem 0;
    line-height: 1.5;
}

.card-detail {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    padding: 0.75rem;
    background: var(--gray-50);
    border-radius: 8px;
    font-size: 0.8rem;
    color: var(--gray-600);
}

.card-detail i {
    color: var(--secondary-500);
    margin-top: 0.1rem;
}

.card-footer {
    padding: 1rem 1.5rem 1.5rem;
    display: flex;
    gap: 0.5rem;
}

.btn-document {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.875rem 1rem;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all var(--transition-fast);
    border: none;
    cursor: pointer;
}

.btn-document .btn-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-document.available {
    background: var(--primary-600);
    color: white;
}

.btn-document.available:hover {
    background: var(--primary-700);
}

.btn-document.unavailable {
    background: var(--gray-100);
    color: var(--gray-400);
    cursor: not-allowed;
}

.btn-download {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gray-100);
    color: var(--gray-600);
    border-radius: 10px;
    text-decoration: none;
    transition: all var(--transition-fast);
}

.btn-download:hover {
    background: var(--primary-50);
    color: var(--primary-600);
}

.card-status {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 600;
}

.card-status.available {
    background: var(--success-light);
    color: #047857;
}

.card-status.pending {
    background: var(--gold-light);
    color: #b45309;
}

/* ============================================
   Process Timeline
   ============================================ */
.process-section {
    margin-bottom: 4rem;
    padding: 3rem;
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
}

.timeline {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.timeline-item {
    position: relative;
    text-align: center;
    padding: 1.5rem;
}

.timeline-marker {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    box-shadow: 0 4px 15px -3px rgba(37, 99, 235, 0.4);
}

.timeline-marker span {
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
}

.timeline-content h4 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0 0 0.5rem 0;
}

.timeline-content p {
    font-size: 0.85rem;
    color: var(--gray-500);
    margin: 0;
    line-height: 1.6;
}

/* ============================================
   Contact CTA
   ============================================ */
.contact-cta {
    background: linear-gradient(135deg, var(--primary-800) 0%, var(--primary-900) 100%);
    border-radius: 20px;
    padding: 2.5rem;
    overflow: hidden;
    position: relative;
}

.contact-cta::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.cta-content {
    position: relative;
    display: flex;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.cta-icon {
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: white;
}

.cta-text {
    flex: 1;
    min-width: 200px;
}

.cta-text h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.25rem 0;
}

.cta-text p {
    font-size: 0.9rem;
    color: var(--gray-300);
    margin: 0;
}

.cta-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all var(--transition-fast);
}

.cta-btn.phone {
    background: var(--success);
    color: white;
}

.cta-btn.phone:hover {
    background: #059669;
    transform: translateY(-2px);
}

.cta-btn.email {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.cta-btn.email:hover {
    background: rgba(255, 255, 255, 0.15);
}

/* ============================================
   Footer
   ============================================ */
.page-footer {
    background: var(--gray-900);
    color: var(--gray-400);
    padding: 2rem 0 1rem;
    margin-top: 4rem;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--gray-800);
    flex-wrap: wrap;
    gap: 1.5rem;
}

.footer-brand {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.footer-logo {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.footer-info h4 {
    font-size: 1rem;
    font-weight: 700;
    color: white;
    margin: 0;
}

.footer-info p {
    font-size: 0.8rem;
    margin: 0;
}

.footer-links {
    display: flex;
    gap: 0.75rem;
}

.footer-link {
    width: 40px;
    height: 40px;
    background: var(--gray-800);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
    text-decoration: none;
    transition: all var(--transition-fast);
}

.footer-link:hover {
    background: var(--primary-600);
    color: white;
}

.footer-bottom {
    text-align: center;
    padding-top: 1.5rem;
    font-size: 0.8rem;
}

/* ============================================
   Responsive Design
   ============================================ */
@media (max-width: 992px) {
    .hero-title {
        font-size: 2.75rem;
    }
    
    .hero-stats {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .stat-divider {
        display: none;
    }
}

@media (max-width: 768px) {
    .top-bar-content {
        justify-content: center;
    }
    
    .top-bar-right {
        display: none;
    }
    
    .hero-section {
        min-height: 500px;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-description {
        font-size: 1rem;
    }
    
    .hero-stats {
        padding: 1rem;
        gap: 1rem;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
    
    .hero-actions {
        flex-direction: column;
    }
    
    .btn-primary-hero,
    .btn-secondary-hero {
        width: 100%;
        justify-content: center;
    }
    
    .card-content {
        padding: 1.5rem;
    }
    
    .card-header {
        flex-direction: column;
        text-align: center;
    }
    
    .institution-logo {
        margin: 0 auto;
    }
    
    .cta-content {
        flex-direction: column;
        text-align: center;
    }
    
    .cta-actions {
        width: 100%;
        justify-content: center;
    }
    
    .footer-content {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.document-card').forEach(card => {
        card.style.animationPlayState = 'paused';
        observer.observe(card);
    });
});
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php';
?>