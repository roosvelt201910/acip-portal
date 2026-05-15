<?php ob_start(); ?>

<section class="hero-noticias">
    <div class="container">
        <div class="hero-content-noticias">
            <div class="hero-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <h1 class="hero-title-noticias">Últimas Noticias</h1>
            <p class="hero-subtitle-noticias">Mantente informado con las últimas novedades y acontecimientos de nuestra institución</p>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number"><?= count($noticias) ?></span>
                    <span class="stat-label">Artículos</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-number">Hoy</span>
                    <span class="stat-label"><?= date('d M Y') ?></span>
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
                <div class="noticias-grid-editorial">
                    <?php foreach ($noticias as $noticia): ?>
                    <article class="noticia-card-editorial">
                        <?php if ($noticia['imagen']): ?>
                        <div class="noticia-image-editorial">
                            <img src="<?= url(e($noticia['imagen'])) ?>" alt="<?= e($noticia['titulo']) ?>">
                            <div class="noticia-overlay">
                                <span class="noticia-categoria-badge"><?= e(ucfirst($noticia['categoria'])) ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="noticia-content-editorial">
                            <div class="noticia-meta-editorial">
                                <span class="meta-date">
                                    <i class="far fa-calendar"></i>
                                    <?= formatDate($noticia['fecha_publicacion']) ?>
                                </span>
                                <span class="meta-divider">•</span>
                                <span class="meta-category"><?= e(ucfirst($noticia['categoria'])) ?></span>
                            </div>
                            <h2 class="noticia-titulo-editorial">
                                <a href="<?= url('noticias/' . e($noticia['slug'])) ?>">
                                    <?= e(truncate($noticia['titulo'], 85)) ?>
                                </a>
                            </h2>
                            <p class="noticia-resumen-editorial"><?= e(truncate($noticia['resumen'], 140)) ?></p>
                            <div class="noticia-footer-editorial">
                                <a href="<?= url('noticias/' . e($noticia['slug'])) ?>" class="btn-leer-mas-editorial">
                                    <span>Leer artículo completo</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="sidebar-widget">
                    <h3 class="sidebar-title">Navegación</h3>
                    <ul class="sidebar-menu">
                        <li class="active">
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
                        <li>
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
                    <h3 class="sidebar-title">Categorías</h3>
                    <ul class="sidebar-categories">
                        <li><a href="<?= url('noticias?categoria=institucional') ?>">Institucional</a></li>
                        <li><a href="<?= url('noticias?categoria=academico') ?>">Académico</a></li>
                        <li><a href="<?= url('noticias?categoria=eventos') ?>">Eventos</a></li>
                        <li><a href="<?= url('noticias?categoria=logros') ?>">Logros</a></li>
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
/* Professional News Hero */
.hero-noticias {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.hero-noticias::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.hero-content-noticias {
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

.hero-title-noticias {
    font-size: 3.5rem;
    font-weight: 900;
    color: white;
    margin: 0 0 16px 0;
    letter-spacing: -0.02em;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.hero-subtitle-noticias {
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

@media (max-width: 768px) {
    .hero-noticias {
        padding: 60px 0;
    }
    
    .hero-title-noticias {
        font-size: 2.5rem;
    }
    
    .hero-subtitle-noticias {
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

/* Editorial News Grid */
.noticias-grid-editorial {
    display: grid;
    grid-template-columns: 1fr;
    gap: 32px;
    margin-bottom: 40px;
}

.noticia-card-editorial {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
    display: grid;
    grid-template-columns: 380px 1fr;
    gap: 0;
}

.noticia-card-editorial:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    border-left-color: #2563eb;
    transform: translateX(4px);
}

.noticia-image-editorial {
    position: relative;
    height: 280px;
    overflow: hidden;
    background: #f1f5f9;
}

.noticia-image-editorial img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.noticia-card-editorial:hover .noticia-image-editorial img {
    transform: scale(1.05);
}

.noticia-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0) 50%);
    padding: 20px;
}

.noticia-categoria-badge {
    display: inline-block;
    background: #2563eb;
    color: white;
    padding: 6px 16px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.noticia-content-editorial {
    padding: 32px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.noticia-meta-editorial {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    font-size: 0.875rem;
    color: #64748b;
}

.meta-date {
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
}

.meta-date i {
    color: #2563eb;
}

.meta-divider {
    color: #cbd5e1;
}

.meta-category {
    color: #2563eb;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.noticia-titulo-editorial {
    margin: 0 0 16px 0;
    font-size: 1.75rem;
    line-height: 1.3;
    font-weight: 800;
    letter-spacing: -0.025em;
}

.noticia-titulo-editorial a {
    color: #0f172a;
    text-decoration: none;
    transition: color 0.2s;
}

.noticia-titulo-editorial a:hover {
    color: #2563eb;
}

.noticia-resumen-editorial {
    color: #475569;
    font-size: 1rem;
    line-height: 1.7;
    margin: 0 0 24px 0;
}

.noticia-footer-editorial {
    border-top: 1px solid #e2e8f0;
    padding-top: 20px;
}

.btn-leer-mas-editorial {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #2563eb;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.2s;
    padding: 8px 0;
}

.btn-leer-mas-editorial:hover {
    gap: 14px;
    color: #1d4ed8;
}

.btn-leer-mas-editorial i {
    transition: transform 0.2s;
}

.btn-leer-mas-editorial:hover i {
    transform: translateX(4px);
}

@media (max-width: 992px) {
    .noticia-card-editorial {
        grid-template-columns: 1fr;
    }
    
    .noticia-image-editorial {
        height: 240px;
    }
    
    .noticia-content-editorial {
        padding: 24px;
    }
    
    .noticia-titulo-editorial {
        font-size: 1.5rem;
    }
}

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
}
</style>

<style>
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
