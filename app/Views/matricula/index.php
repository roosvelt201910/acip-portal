<?php
ob_start();
?>

<!-- Google Fonts: Poppins + Inter -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<div class="matriculas-wrapper">
    <!-- Hero Section Profesional -->
    <?php 
    $heroType = $matriculaData['hero_type']['contenido'] ?? 'default';
    $heroImage = $matriculaData['hero_image']['contenido'] ?? '';
    $heroVideoUrl = $matriculaData['hero_video_url']['contenido'] ?? '';
    
    // Extract YouTube video ID
    $videoId = '';
    if ($heroType === 'video' && !empty($heroVideoUrl)) {
        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $heroVideoUrl, $matches);
        $videoId = $matches[1] ?? '';
    }
    ?>
    <section class="hero-section <?= $heroType === 'image' && !empty($heroImage) ? 'hero-with-image' : '' ?>">
        <?php if ($heroType === 'video' && !empty($videoId)): ?>
            <!-- Video Background -->
            <div class="hero-video-wrapper">
                <iframe 
                    src="https://www.youtube.com/embed/<?= $videoId ?>?autoplay=1&mute=1&loop=1&controls=0&showinfo=0&rel=0&playlist=<?= $videoId ?>" 
                    frameborder="0" 
                    allow="autoplay; encrypted-media" 
                    allowfullscreen>
                </iframe>
            </div>
        <?php elseif ($heroType === 'image' && !empty($heroImage)): ?>
            <!-- Image Background -->
            <div class="hero-image-wrapper" style="background-image: url('<?= url($heroImage) ?>');"></div>
        <?php else: ?>
            <!-- Default Pattern Background -->
            <div class="hero-bg-pattern"></div>
        <?php endif; ?>
        
        <div class="hero-overlay"></div>
        <div class="container position-relative">
            <div class="hero-content">
                <span class="hero-badge">
                    <i class="fas fa-graduation-cap me-2"></i><?= site_config('sitio_nombre', 'IESP "ACIP"') ?>
                </span>
                <h1 class="hero-title">Matrículas</h1>
                <p class="hero-subtitle">Inscríbete y forma parte de nuestra comunidad educativa</p>
                <div class="hero-decoration">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="hero-wave">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path d="M0,64 C288,120 720,0 1440,64 L1440,120 L0,120 Z" fill="#f8fafc"/>
            </svg>
        </div>
    </section>

    <!-- Título Principal -->
    <section class="main-title-section">
        <div class="container">
            <div class="title-wrapper text-center">
                <div class="title-icon">
                    <i class="fas fa-file-signature"></i>
                </div>
                <h2 class="section-title">Proceso de Matrícula <?= date('Y') ?> – I</h2>
                <p class="section-description">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    Matrículas presenciales y virtuales en la oficina de Secretaría Académica
                </p>
                <div class="title-separator">
                    <span class="line"></span>
                    <span class="diamond"><i class="fas fa-diamond"></i></span>
                    <span class="line"></span>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenido Principal -->
    <section class="content-section">
        <div class="container">
            <div class="row g-4">
                <?php 
                $icons = [
                    'requisitos' => 'fa-clipboard-list',
                    'cronograma' => 'fa-calendar-alt',
                    'costos' => 'fa-money-bill-wave',
                    'documentos' => 'fa-folder-open',
                    'horarios' => 'fa-clock',
                    'contacto' => 'fa-headset',
                    'programas' => 'fa-book-open',
                    'vacantes' => 'fa-users',
                    'default' => 'fa-info-circle'
                ];
                
                $colors = [
                    ['#0061f2', '#00c6fb'], // Azul
                    ['#e74a3b', '#fd7e14'], // Rojo-Naranja
                    ['#1cc88a', '#36d399'], // Verde
                    ['#6f42c1', '#a855f7'], // Púrpura
                    ['#f6c23e', '#ffc107'], // Amarillo
                    ['#17a2b8', '#20c9a6'], // Cyan
                ];
                
                $index = 0;
                
                foreach ($info as $item): 
                    $key = $item['key_name'];
                    
                    // Ignorar campos de configuración del Hero
                    if (in_array($key, ['hero_type', 'hero_image', 'hero_video_url'])) continue;

                    $data = $item;
                    $colorSet = $colors[$index % count($colors)];
                    
                    // Detectar icono según key
                    $iconClass = 'fa-info-circle';
                    foreach ($icons as $keyword => $icon) {
                        if (stripos($key, $keyword) !== false) {
                            $iconClass = $icon;
                            break;
                        }
                    }
                    
                    // Banner Vertical - Se muestra como publicidad flotante al lado izquierdo
                    if ($key === 'banner_vertical'):
                        if (!empty($data['contenido'])): ?>
                        <div class="floating-ad-banner" id="floatingAdBanner" style="display: none;">
                            <div class="ad-label">
                                <i class="fas fa-bullhorn"></i>
                                <span>Enterate mas aqui!!</span>
                            </div>
                            <a href="<?= !empty($data['enlace']) ? url($data['enlace']) : '#' ?>" target="_blank" class="ad-link">
                                <img src="<?= url($data['contenido']) ?>" alt="<?= e($data['titulo']) ?>" class="ad-image">
                            </a>
                            <button class="ad-close" onclick="this.closest('.floating-ad-banner').style.display='none'">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const banner = document.getElementById('floatingAdBanner');
                            const showBannerScrollPercent = 50; // Mostrar cuando se haya scrolleado el 50% de la página
                            
                            window.addEventListener('scroll', function() {
                                const scrollTop = window.scrollY;
                                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                                const scrollPercent = (scrollTop / docHeight) * 100;
                                
                                if (scrollPercent >= showBannerScrollPercent) {
                                    if (banner.style.display === 'none') {
                                        banner.style.display = 'block';
                                    }
                                }
                            });
                        });
                        </script>
                        <?php endif;
                        continue;
                    endif;
                ?>
                
                <div class="col-lg-6 d-flex">
                    <div class="info-card w-100" style="--card-color: <?= $colorSet[0] ?>; --card-gradient: <?= $colorSet[1] ?>;">
                        <!-- Header de la tarjeta -->
                        <div class="card-header-custom">
                            <div class="card-icon-wrapper">
                                <i class="fas <?= $iconClass ?>"></i>
                            </div>
                            <h3 class="card-title-custom"><?= e($data['titulo']) ?></h3>
                            <div class="card-number"><?= str_pad($index + 1, 2, '0', STR_PAD_LEFT) ?></div>
                        </div>
                        
                        <!-- Contenido -->
                        <div class="card-body-custom">
                            <div class="card-content">
                                <?= $data['contenido'] ?>
                            </div>
                        </div>
                        
                        <!-- Decoración inferior -->
                        <div class="card-footer-decoration">
                            <div class="decoration-line"></div>
                        </div>
                    </div>
                </div>

                <?php 
                $index++;
                endforeach; 
                ?>
            </div>
            
            <!-- CTA Section -->
            <div class="cta-section">
                <div class="cta-card">
                    <div class="cta-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <div class="cta-content">
                        <h4>¿Tienes dudas sobre el proceso?</h4>
                        <p>Contáctanos y te ayudaremos en todo el proceso de matrícula</p>
                    </div>
                    <a href="<?= url('contacto') ?>" class="cta-button">
                        <span>Contáctanos</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Enlaces Destacados -->
    <?php if (!empty($enlaces)): ?>
    <section class="enlaces-section">
        <div class="container">
            <div class="enlaces-header text-center">
                <h2 class="enlaces-title">Enlaces Destacados</h2>
                <p class="enlaces-subtitle">Explora una selección de recursos y sitios destacados para ti</p>
            </div>
            
            <!-- Swiper Slider -->
            <div class="swiper enlaces-slider" style="padding: 20px 5px 50px;">
                <div class="swiper-wrapper">
                    <?php foreach ($enlaces as $enlace): ?>
                    <div class="swiper-slide">
                        <a href="<?= e($enlace['enlace']) ?>" target="_blank" class="enlace-card" title="<?= e($enlace['titulo']) ?>">
                            <div class="enlace-icon">
                                <?php if ($enlace['icono']): ?>
                                    <img src="<?= url(e($enlace['icono'])) ?>" alt="<?= e($enlace['titulo']) ?>">
                                <?php else: ?>
                                    <i class="fas fa-link"></i>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.enlaces-slider', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                576: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                992: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
                1200: {
                    slidesPerView: 5,
                    spaceBetween: 30,
                },
            }
        });
    });
</script>

<style>
/* ================================================
   ESTILOS PROFESIONALES - PÁGINA DE MATRÍCULAS
   IESTP "Alto Huallaga"
   ================================================ */

:root {
    --primary: #0061f2;
    --primary-dark: #0048b3;
    --secondary: #6c757d;
    --accent: #ffc107;
    --success: #1cc88a;
    --danger: #e74a3b;
    --dark: #1a1f36;
    --light: #f8fafc;
    --white: #ffffff;
    --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
    --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
    --shadow-lg: 0 8px 30px rgba(0,0,0,0.12);
    --shadow-xl: 0 20px 50px rgba(0,0,0,0.15);
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 20px;
    --radius-xl: 30px;
    --font-main: 'Poppins', sans-serif;
    --font-body: 'Inter', sans-serif;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.matriculas-wrapper {
    font-family: var(--font-body);
    background-color: var(--light);
    color: var(--dark);
    overflow-x: hidden;
}

/* ============ HERO SECTION ============ */
.hero-section {
    position: relative;
    min-height: 650px;
    background: linear-gradient(135deg, var(--dark) 0%, #2d3748 50%, var(--primary-dark) 100%);
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-bg-pattern {
    position: absolute;
    inset: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(255,255,255,0.03) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(0,97,242,0.15) 0%, transparent 40%),
        radial-gradient(circle at 40% 80%, rgba(255,193,7,0.1) 0%, transparent 40%);
    opacity: 1;
}

/* Hero Video Background */
.hero-video-wrapper {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1;
}

.hero-video-wrapper iframe {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100vw;
    height: 100vh;
    transform: translate(-50%, -50%);
    pointer-events: none;
    min-width: 100%;
    min-height: 100%;
}

/* Hero Image Background */
.hero-image-wrapper {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: top center;
    background-repeat: no-repeat;
    z-index: 1;
}

.hero-with-image {
    background: var(--dark);
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.4);
    z-index: 2;
}

.hero-content {
    position: relative;
    z-index: 10;
    padding: 60px 0 100px;
    text-align: center;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
    padding: 10px 24px;
    border-radius: 50px;
    color: var(--white);
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 24px;
    letter-spacing: 0.5px;
}

.hero-title {
    font-family: var(--font-main);
    font-size: clamp(2.5rem, 6vw, 4rem);
    font-weight: 800;
    color: var(--white);
    margin-bottom: 16px;
    text-transform: uppercase;
    letter-spacing: 3px;
    text-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

.hero-subtitle {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.8);
    font-weight: 400;
    max-width: 500px;
    margin: 0 auto;
}

.hero-decoration {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 30px;
}

.hero-decoration span {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: var(--accent);
    animation: pulse 2s ease-in-out infinite;
}

.hero-decoration span:nth-child(2) {
    animation-delay: 0.3s;
    background: var(--white);
}

.hero-decoration span:nth-child(3) {
    animation-delay: 0.6s;
    background: var(--success);
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.2); opacity: 0.7; }
}

.hero-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    line-height: 0;
}

.hero-wave svg {
    width: 100%;
    height: 80px;
}

/* ============ TÍTULO PRINCIPAL ============ */
.main-title-section {
    padding: 40px 0 20px;
    background: var(--light);
}

.title-wrapper {
    max-width: 700px;
    margin: 0 auto;
}

.title-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    box-shadow: 0 10px 30px rgba(0,97,242,0.3);
}

.title-icon i {
    font-size: 1.8rem;
    color: var(--white);
}

.section-title {
    font-family: var(--font-main);
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.section-description {
    font-size: 1rem;
    color: var(--secondary);
    margin-bottom: 0;
}

.section-description i {
    color: var(--danger);
}

.title-separator {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-top: 25px;
}

.title-separator .line {
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--primary), transparent);
    border-radius: 2px;
}

.title-separator .diamond {
    color: var(--accent);
    font-size: 0.6rem;
}

/* ============ CONTENIDO - TARJETAS ============ */
.content-section {
    padding: 40px 0 80px;
}

/* Tarjeta de información */
.info-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: var(--transition);
    position: relative;
    display: flex;
    flex-direction: column;
}

.info-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--card-color), var(--card-gradient));
}

.info-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

/* Header de tarjeta */
.card-header-custom {
    padding: 25px 25px 15px;
    display: flex;
    align-items: center;
    gap: 15px;
    position: relative;
}

.card-icon-wrapper {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--card-color), var(--card-gradient));
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.card-icon-wrapper i {
    font-size: 1.3rem;
    color: var(--white);
}

.card-title-custom {
    font-family: var(--font-main);
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
    margin: 0;
    flex: 1;
    line-height: 1.3;
}

.card-number {
    position: absolute;
    top: 20px;
    right: 25px;
    font-family: var(--font-main);
    font-size: 2.5rem;
    font-weight: 800;
    color: rgba(0,0,0,0.04);
    line-height: 1;
}

/* Body de tarjeta */
.card-body-custom {
    padding: 0 25px 25px;
    flex: 1;
}

.card-content {
    font-size: 0.95rem;
    line-height: 1.7;
    color: #4a5568;
}

/* Estilos para contenido rico */
.card-content ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.card-content ul li {
    position: relative;
    padding-left: 24px;
    margin-bottom: 10px;
    font-size: 0.9rem;
    color: #4a5568;
}

.card-content ul li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 8px;
    width: 8px;
    height: 8px;
    background: linear-gradient(135deg, var(--card-color), var(--card-gradient));
    border-radius: 50%;
}

.card-content strong, .card-content b {
    color: var(--dark);
    font-weight: 600;
}

.card-content a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
}

.card-content a:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

.card-content p {
    margin-bottom: 12px;
}

.card-content p:last-child {
    margin-bottom: 0;
}

/* Botones en contenido */
.card-content .btn,
.card-content a.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, var(--card-color), var(--card-gradient));
    color: var(--white) !important;
    padding: 10px 24px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none !important;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.card-content .btn:hover,
.card-content a.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
}

/* Decoración inferior */
.card-footer-decoration {
    padding: 0 25px 20px;
}

.decoration-line {
    height: 3px;
    background: linear-gradient(90deg, var(--card-color), var(--card-gradient), transparent);
    border-radius: 2px;
    opacity: 0.3;
}

/* ============ BANNER CARD ============ */
.banner-card {
    position: relative;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    transition: var(--transition);
}

.banner-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.banner-glow {
    position: absolute;
    inset: -2px;
    background: linear-gradient(135deg, var(--primary), var(--accent), var(--success));
    border-radius: var(--radius-lg);
    z-index: -1;
    opacity: 0;
    transition: var(--transition);
}

.banner-card:hover .banner-glow {
    opacity: 1;
}

.banner-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    min-height: 300px;
    display: block;
}

/* ============ FLOATING AD BANNER ============ */
.floating-ad-banner {
    position: fixed;
    left: 20px;
    bottom: 80px;
    width: 450px;
    max-width: 580px;
    background: var(--white);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    z-index: 1000;
    animation: slideInFromLeft 0.6s ease-out forwards;
}

@keyframes slideInFromLeft {
    from {
        opacity: 0;
        transform: translateX(-100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.floating-ad-banner .ad-label {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: var(--white);
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 6px 10px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.floating-ad-banner .ad-label i {
    font-size: 0.6rem;
}

.floating-ad-banner .ad-link {
    display: block;
    line-height: 0;
}

.floating-ad-banner .ad-image {
    width: 100%;
    height: auto;
    object-fit: contain;
    transition: var(--transition);
}

.floating-ad-banner:hover .ad-image {
    transform: scale(1.03);
}

.floating-ad-banner .ad-close {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 22px;
    height: 22px;
    background: rgba(0,0,0,0.5);
    border: none;
    border-radius: 50%;
    color: var(--white);
    font-size: 0.65rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
    opacity: 0;
}

.floating-ad-banner:hover .ad-close {
    opacity: 1;
}

.floating-ad-banner .ad-close:hover {
    background: var(--danger);
    transform: scale(1.1);
}

/* Responsive para el banner flotante */
@media (max-width: 768px) {
    .floating-ad-banner {
        width: 420px;
        left: 15px;
        bottom: 80px;
    }
    
    .floating-ad-banner .ad-image {
        max-height: 320px;
    }
}

@media (max-width: 576px) {
    .floating-ad-banner {
        width: 420px;
        left: 10px;
        bottom: 70px;
    }
    
    .floating-ad-banner .ad-label {
        padding: 5px 10px;
        font-size: 0.6rem;
    }
    
    .floating-ad-banner .ad-image {
        max-height: 460px;
    }
}

/* ============ CTA SECTION ============ */
.cta-section {
    margin-top: 50px;
}

.cta-card {
    background: linear-gradient(135deg, var(--dark) 0%, #2d3748 100%);
    border-radius: var(--radius-lg);
    padding: 40px;
    display: flex;
    align-items: center;
    gap: 30px;
    flex-wrap: wrap;
    box-shadow: var(--shadow-xl);
    position: relative;
    overflow: hidden;
}

.cta-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255,193,7,0.15) 0%, transparent 70%);
    border-radius: 50%;
}

.cta-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--accent), #ffa000);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.cta-icon i {
    font-size: 1.8rem;
    color: var(--dark);
}

.cta-content {
    flex: 1;
    min-width: 200px;
}

.cta-content h4 {
    font-family: var(--font-main);
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--white);
    margin-bottom: 5px;
}

.cta-content p {
    color: rgba(255,255,255,0.7);
    margin: 0;
    font-size: 0.95rem;
}

.cta-button {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--white);
    color: var(--dark) !important;
    padding: 14px 30px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none !important;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.cta-button:hover {
    background: var(--accent);
    transform: translateX(5px);
}

.cta-button i {
    transition: var(--transition);
}

.cta-button:hover i {
    transform: translateX(5px);
}

/* ============ ENLACES DESTACADOS ============ */
.enlaces-section {
    padding: 60px 0;
    background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%);
}

.enlaces-header {
    margin-bottom: 40px;
}

.enlaces-title {
    font-family: var(--font-main);
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 12px;
}

.enlaces-subtitle {
    font-size: 1rem;
    color: var(--secondary);
    margin: 0;
}

/* Enlaces Slider Styles */
.swiper-pagination-bullet-active {
    background-color: var(--primary) !important;
}

.enlaces-slider {
    padding-bottom: 40px !important; /* Space for pagination */
}

.enlace-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: 20px;
    width: 100%;
    /* Removed fixed widths to adapt to slider */
    box-shadow: var(--shadow-md);
    transition: var(--transition);
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.enlace-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.enlace-icon {
    display: flex;
    align-items: center;
    justify-content: center;
}

.enlace-icon img {
    max-width: 150px;
    max-height: 80px;
    object-fit: contain;
    transition: var(--transition);
}

.enlace-card:hover .enlace-icon img {
    transform: scale(1.05);
}

.enlace-icon i {
    font-size: 2.5rem;
    color: var(--primary);
}

/* ============ RESPONSIVE ============ */
@media (max-width: 992px) {
    .hero-section {
        min-height: 350px;
    }
    
    .hero-content {
        padding: 50px 0 90px;
    }
    
    .cta-card {
        padding: 30px;
        justify-content: center;
        text-align: center;
    }
    
    .cta-content {
        text-align: center;
    }
}

@media (max-width: 576px) {
    .hero-section {
        min-height: 300px;
    }
    
    .hero-badge {
        font-size: 0.8rem;
        padding: 8px 18px;
    }
    
    .card-header-custom {
        padding: 20px 20px 10px;
    }
    
    .card-body-custom {
        padding: 0 20px 20px;
    }
    
    .card-number {
        display: none;
    }
    
    .cta-card {
        padding: 25px;
        gap: 20px;
    }
    
    .cta-icon {
        width: 60px;
        height: 60px;
    }
    
    .cta-button {
        width: 100%;
        justify-content: center;
    }
}

/* ============ ANIMACIONES ============ */
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

.info-card, .banner-card {
    animation: fadeInUp 0.6s ease-out forwards;
}

.row > .col-lg-6:nth-child(1) .info-card { animation-delay: 0.1s; }
.row > .col-lg-6:nth-child(2) .info-card { animation-delay: 0.2s; }
.row > .col-lg-6:nth-child(3) .info-card { animation-delay: 0.3s; }
.row > .col-lg-6:nth-child(4) .info-card { animation-delay: 0.4s; }
.row > .col-lg-6:nth-child(5) .info-card { animation-delay: 0.5s; }
.row > .col-lg-6:nth-child(6) .info-card { animation-delay: 0.6s; }
</style>

<?php 
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php'; 
?>