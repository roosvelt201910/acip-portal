<?php ob_start(); ?>

<section class="hero-programas">
    <div class="container">
        <div class="hero-content-programas">
            <div class="hero-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h1 class="hero-title-programas">Programas de Estudio</h1>
            <p class="hero-subtitle-programas">Formación profesional técnica de excelencia con alta demanda laboral</p>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number"><?= count($programas) ?></span>
                    <span class="stat-label">Programas</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-number">100%</span>
                    <span class="stat-label">Empleabilidad</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="content-with-sidebar">
            <!-- Main Content -->
            <div class="main-content">
                <div class="programas-grid-modern">
                    <?php foreach ($programas as $programa): ?>
                    <div class="programa-card-modern">
                        <?php if ($programa['imagen']): ?>
                        <div class="programa-image-modern">
                            <img src="<?= url(e($programa['imagen'])) ?>" alt="<?= e($programa['nombre']) ?>">
                            <div class="programa-overlay">
                                <span class="programa-badge">
                                    <i class="fas fa-graduation-cap"></i>
                                    <?= e(ucfirst($programa['modalidad'])) ?>
                                </span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="programa-content-modern">
                            <h3 class="programa-title"><?= e($programa['nombre']) ?></h3>
                            <p class="programa-description"><?= e(truncate($programa['descripcion'], 120)) ?></p>
                            
                            <div class="programa-meta">
                                <div class="meta-item">
                                    <i class="far fa-clock"></i>
                                    <span><?= e($programa['duracion_semestres']) ?> semestres</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-certificate"></i>
                                    <span>Certificación</span>
                                </div>
                            </div>
                            
                            <a href="<?= url('programas/' . e($programa['slug'])) ?>" class="btn-programa-modern">
                                <span>Ver programa completo</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="sidebar-widget">
                    <h3 class="sidebar-title">Navegación</h3>
                    <ul class="sidebar-menu">
                        <li>
                            <a href="<?= url('noticias') ?>">
                                <i class="fas fa-newspaper"></i>
                                <span>Noticias</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('eventos') ?>">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Eventos</span>
                            </a>
                        </li>
                        <li class="active">
                            <a href="<?= url('programas') ?>">
                                <i class="fas fa-graduation-cap"></i>
                                <span>Programas</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('documentos') ?>">
                                <i class="fas fa-file-alt"></i>
                                <span>Documentos</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('contacto') ?>">
                                <i class="fas fa-envelope"></i>
                                <span>Contacto</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="sidebar-widget">
                    <h3 class="sidebar-title">Accesos Rápidos</h3>
                    <ul class="sidebar-categories">
                        <li><a href="<?= url('/') ?>">Inicio</a></li>
                        <li><a href="<?= url('nosotros') ?>">Nosotros</a></li>
                        <li><a href="<?= url('admision') ?>">Admisión</a></li>
                        <li><a href="<?= url('transparencia') ?>">Transparencia</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>

<!-- Enlaces Destacados -->
<?php if (!empty($enlaces)): ?>
<section class="section enlaces-section" style="background: #f8fafc; padding: 60px 0;">
    <div class="container">
        <div class="section-header text-center" style="margin-bottom: 40px;">
            <h2 style="font-size: 2rem; font-weight: 700; color: #0f172a; margin-bottom: 12px;">Enlaces Destacados</h2>
            <p style="color: #64748b; font-size: 1.1rem;">Explora una selección de recursos y sitios destacados para ti</p>
        </div>
        
        <div class="enlaces-slider-container" id="enlaces-slider">
            <div class="enlaces-track">
                <?php foreach ($enlaces as $enlace): ?>
                <div class="enlace-slide">
                    <a href="<?= e($enlace['enlace']) ?>" target="_blank" class="enlace-card-modern" title="<?= e($enlace['titulo']) ?>">
                        <div class="enlace-icon-modern">
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
        </div>
        
        <?php if (count($enlaces) > 5): ?>
        <div class="enlaces-nav">
            <button class="enlaces-prev"><i class="fas fa-chevron-left"></i></button>
            <button class="enlaces-next"><i class="fas fa-chevron-right"></i></button>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>


<style>
/* Professional Programs Hero */
.hero-programas {
    background: linear-gradient(135deg, #065f46 0%, #059669 40%, #10b981 100%);
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.hero-programas::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.2) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(52, 211, 153, 0.2) 0%, transparent 50%),
        url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(16,185,129,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    animation: pulse 4s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 0.3;
    }
    50% {
        opacity: 0.5;
    }
}

.hero-content-programas {
    position: relative;
    z-index: 1;
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.hero-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.hero-icon i {
    font-size: 2.5rem;
    color: white;
}

.hero-title-programas {
    font-size: 3.5rem;
    font-weight: 900;
    color: white;
    margin: 0 0 16px 0;
    letter-spacing: -0.02em;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.hero-subtitle-programas {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    margin: 0 0 40px 0;
    line-height: 1.6;
}

.hero-stats {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 40px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 24px 48px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: white;
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.8);
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
}

.stat-divider {
    width: 1px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
}

/* Hero Animations */
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

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

.hero-icon {
    animation: scaleIn 0.6s ease-out;
}

.hero-icon i {
    animation: float 3s ease-in-out infinite;
}

.hero-title-programas {
    animation: fadeInUp 0.8s ease-out 0.2s both;
}

.hero-subtitle-programas {
    animation: fadeInUp 0.8s ease-out 0.4s both;
}

.hero-stats {
    animation: fadeInUp 0.8s ease-out 0.6s both;
}

.stat-item:nth-child(1) {
    animation: fadeInUp 0.6s ease-out 0.8s both;
}

.stat-item:nth-child(3) {
    animation: fadeInUp 0.6s ease-out 1s both;
}

@media (max-width: 768px) {
    .hero-programas {
        padding: 60px 0;
    }
    
    .hero-title-programas {
        font-size: 2.5rem;
    }
    
    .hero-subtitle-programas {
        font-size: 1.1rem;
    }
    
    .hero-stats {
        flex-direction: column;
        gap: 20px;
        padding: 20px 32px;
    }
    
    .stat-divider {
        width: 50px;
        height: 1px;
    }
}

/* Modern Programs Grid */
.programas-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.programa-card-modern {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
}

.programa-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border-color: #2563eb;
}

.programa-image-modern {
    position: relative;
    height: 220px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.programa-image-modern img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.programa-card-modern:hover .programa-image-modern img {
    transform: scale(1.1);
}

.programa-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.7) 100%);
    display: flex;
    align-items: flex-end;
    padding: 20px;
}

.programa-badge {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #2563eb;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.programa-badge i {
    font-size: 0.9rem;
}

.programa-content-modern {
    padding: 28px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.programa-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 12px 0;
    line-height: 1.3;
    letter-spacing: -0.025em;
}

.programa-description {
    color: #64748b;
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0 0 24px 0;
    flex: 1;
}

.programa-meta {
    display: flex;
    gap: 20px;
    padding: 20px 0;
    border-top: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
    margin-bottom: 24px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #475569;
    font-size: 0.9rem;
    font-weight: 500;
}

.meta-item i {
    color: #2563eb;
    font-size: 1rem;
}

.btn-programa-modern {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: white;
    padding: 14px 24px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
    border: none;
    cursor: pointer;
}

.btn-programa-modern:hover {
    background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
    box-shadow: 0 6px 12px rgba(37, 99, 235, 0.3);
    transform: translateY(-2px);
}

.btn-programa-modern i {
    transition: transform 0.3s ease;
}

.btn-programa-modern:hover i {
    transform: translateX(4px);
}

/* Enlaces Destacados Slider */
.enlaces-slider-container {
    position: relative;
    overflow: hidden;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 60px;
}

.enlaces-track {
    display: flex;
    gap: 24px;
    transition: transform 0.4s ease;
}

.enlace-slide {
    min-width: 200px;
    flex-shrink: 0;
}

.enlace-card-modern {
    display: block;
    background: #fff;
    border-radius: 12px;
    padding: 32px 24px;
    text-align: center;
    transition: all 0.3s ease;
    border: 2px solid #e2e8f0;
    text-decoration: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    height: 100%;
}

.enlace-card-modern:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    border-color: #2563eb;
}

.enlace-icon-modern {
    width: 100%;
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.enlace-icon-modern img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.enlace-card-modern:hover .enlace-icon-modern img {
    transform: scale(1.05);
}

.enlace-icon-modern i {
    font-size: 3rem;
    color: #2563eb;
}

.enlaces-nav {
    display: flex;
    justify-content: center;
    gap: 16px;
    margin-top: 32px;
}

.enlaces-prev,
.enlaces-next {
    background: #fff;
    border: 2px solid #e2e8f0;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #475569;
    font-size: 1.2rem;
}

.enlaces-prev:hover,
.enlaces-next:hover {
    background: #2563eb;
    border-color: #2563eb;
    color: white;
    transform: scale(1.1);
}

@media (max-width: 768px) {
    .enlaces-slider-container {
        padding: 0 40px;
    }
    
    .enlace-slide {
        min-width: 160px;
    }
}

/* Sidebar Styles */
.content-with-sidebar {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 40px;
    align-items: start;
}

.sidebar {
    position: sticky;
    top: 100px;
}

.sidebar-widget {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
}

.sidebar-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 16px 0;
    padding-bottom: 12px;
    border-bottom: 2px solid #2563eb;
}

.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-menu li {
    margin-bottom: 8px;
}

.sidebar-menu li:last-child {
    margin-bottom: 0;
}

.sidebar-menu a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: #475569;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s;
    font-weight: 500;
}

.sidebar-menu a:hover {
    background: #f1f5f9;
    color: #2563eb;
    transform: translateX(4px);
}

.sidebar-menu li.active a {
    background: #eff6ff;
    color: #2563eb;
    font-weight: 600;
}

.sidebar-menu i {
    font-size: 1.1rem;
    width: 20px;
    text-align: center;
}

.sidebar-categories {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-categories li {
    margin-bottom: 10px;
}

.sidebar-categories a {
    color: #64748b;
    text-decoration: none;
    display: flex;
    align-items: center;
    padding: 8px 0;
    transition: color 0.2s;
}

.sidebar-categories a:before {
    content: "›";
    margin-right: 8px;
    font-size: 1.2rem;
    color: #2563eb;
}

.sidebar-categories a:hover {
    color: #2563eb;
}

@media (max-width: 992px) {
    .content-with-sidebar {
        grid-template-columns: 1fr;
    }
    
    .sidebar {
        position: static;
        order: -1;
    }
    
    .sidebar-widget {
        margin-bottom: 16px;
    }
    
    .programas-grid-modern {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Enlaces Slider Navigation
document.addEventListener('DOMContentLoaded', function() {
    const enlacesSlider = document.getElementById('enlaces-slider');
    if (!enlacesSlider) return;
    
    const track = enlacesSlider.querySelector('.enlaces-track');
    const prevBtn = document.querySelector('.enlaces-prev');
    const nextBtn = document.querySelector('.enlaces-next');
    const slides = track.querySelectorAll('.enlace-slide');
    
    if (!track || slides.length === 0) return;
    
    let currentPosition = 0;
    const slideWidth = slides[0].offsetWidth + 24; // width + gap
    const visibleSlides = 5;
    const maxPosition = -(slides.length - visibleSlides) * slideWidth;
    
    function updateSlider() {
        track.style.transform = `translateX(${currentPosition}px)`;
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            if (currentPosition < 0) {
                currentPosition += slideWidth;
                if (currentPosition > 0) currentPosition = 0;
                updateSlider();
            }
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            if (currentPosition > maxPosition) {
                currentPosition -= slideWidth;
                if (currentPosition < maxPosition) currentPosition = maxPosition;
                updateSlider();
            }
        });
    }
});
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php';
?>
