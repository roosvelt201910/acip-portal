<?php ob_start(); ?>

<section class="hero-eventos">
    <div class="container">
        <div class="hero-content-eventos">
            <div class="hero-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h1 class="hero-title-eventos">Calendario de Eventos</h1>
            <p class="hero-subtitle-eventos">Descubre y participa en las actividades y eventos de nuestra comunidad educativa</p>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number"><?= count($eventos) ?></span>
                    <span class="stat-label">Eventos</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-number">Próximos</span>
                    <span class="stat-label">Este mes</span>
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
                <div class="eventos-list">
                    <?php foreach ($eventos as $evento): ?>
                    <div class="evento-item" style="display: flex; gap: 20px; background: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                        <div class="evento-date" style="text-align: center; min-width: 80px;">
                            <span class="day" style="display: block; font-size: 2rem; font-weight: 700; color: var(--color-primary);"><?= date('d', strtotime($evento['fecha_inicio'])) ?></span>
                            <span class="month" style="text-transform: uppercase; font-size: 0.9rem; color: #666;"><?= date('M', strtotime($evento['fecha_inicio'])) ?></span>
                        </div>
                        <div class="evento-info">
                            <h3 style="margin-top: 0;"><?= e(truncate($evento['titulo'], 80)) ?></h3>
                            <p><?= e(truncate(strip_tags($evento['descripcion']), 150)) ?></p>
                            <div class="evento-meta" style="color: #666; font-size: 0.9rem;">
                                <span style="margin-right: 15px;"><i class="far fa-clock"></i> <?= date('H:i', strtotime($evento['fecha_inicio'])) ?></span>
                                <?php if ($evento['ubicacion']): ?>
                                <span><i class="fas fa-map-marker-alt"></i> <?= e($evento['ubicacion']) ?></span>
                                <?php endif; ?>
                            </div>
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
                        <li class="active">
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

<style>
/* Professional Events Hero */
.hero-eventos {
    background: linear-gradient(135deg, #0f172a 0%, #1e40af 40%, #06b6d4 100%);
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.hero-eventos::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 50%, rgba(6, 182, 212, 0.2) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.2) 0%, transparent 50%),
        url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(6,182,212,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
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

.hero-content-eventos {
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

.hero-title-eventos {
    font-size: 3.5rem;
    font-weight: 900;
    color: white;
    margin: 0 0 16px 0;
    letter-spacing: -0.02em;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.hero-subtitle-eventos {
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
    .hero-eventos {
        padding: 60px 0;
    }
    
    .hero-title-eventos {
        font-size: 2.5rem;
    }
    
    .hero-subtitle-eventos {
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

.hero-title-eventos {
    animation: fadeInUp 0.8s ease-out 0.2s both;
}

.hero-subtitle-eventos {
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

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php';
?>
