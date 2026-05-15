<?php ob_start(); ?>

<!-- Hero Section -->
<section class="page-hero" style="background-image: url('<?= url('assets/img/hero-bg.jpg') ?>'); background-size: cover; background-position: center; padding: 100px 0; color: white; position: relative;">
    <div class="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 50, 100, 0.7);"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <div class="hero-content text-center">
            <h1 style="font-size: 3rem; font-weight: 700; margin-bottom: 20px;">Por qué elegirnos</h1>
            <div class="breadcrumb" style="justify-content: center; background: transparent; padding: 0;">
                <a href="<?= url('/') ?>" style="color: rgba(255,255,255,0.8); text-decoration: none;">Inicio</a>
                <span style="color: rgba(255,255,255,0.6); margin: 0 10px;">/</span>
                <span class="current" style="color: white; font-weight: 600;">Por qué elegirnos</span>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="why-choose-us-section">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="subtitle">Nuestras Fortalezas</span>
            <h2>Razones para ser parte de nuestra familia</h2>
            <div class="divider mx-auto"></div>
            <p class="section-description">
                Descubre lo que nos hace únicos y por qué somos la mejor opción para tu formación profesional.
            </p>
        </div>

        <?php if (!empty($items)): ?>
            <div class="reasons-grid">
                <?php foreach ($items as $item): ?>
                    <div class="reason-card">
                        <div class="reason-icon-wrapper">
                            <?php if ($item['imagen']): ?>
                                <img src="<?= url('uploads/why_choose_us/' . e($item['imagen'])) ?>" alt="<?= e($item['titulo']) ?>" class="reason-img">
                            <?php else: ?>
                                <i class="fas fa-check-circle reason-icon-placeholder"></i>
                            <?php endif; ?>
                        </div>
                        <div class="reason-content">
                            <h3><?= e($item['titulo']) ?></h3>
                            <p><?= e($item['descripcion']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state text-center py-5">
                <!-- Fallback empty state -->
                <div style="font-size: 4rem; color: #cbd5e1; margin-bottom: 20px;"><i class="fas fa-search"></i></div>
                <h3>Próximamente</h3>
                <p class="text-muted">Estamos actualizando nuestra información. Vuelve pronto.</p>
            </div>
        <?php endif; ?>
        
        <div class="cta-section mt-5 text-center">
            <h3>¿Listo para empezar tu futuro?</h3>
            <div class="mt-4">
                <a href="<?= url('admision') ?>" class="btn btn-primary btn-lg">Postula Ahora</a>
                <a href="<?= url('contacto') ?>" class="btn btn-outline-primary btn-lg ml-3">Contáctanos</a>
            </div>
        </div>
    </div>
</section>

<style>
    /* Section Styles */
    .why-choose-us-section {
        padding: 80px 0;
        background-color: #f8fafc;
    }
    
    .section-header .subtitle {
        color: #4f46e5;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
        display: block;
        margin-bottom: 10px;
    }
    
    .section-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
    }
    
    .section-header .divider {
        width: 80px;
        height: 4px;
        background: #4f46e5;
        border-radius: 2px;
        margin-bottom: 20px;
    }
    
    .section-description {
        max-width: 700px;
        margin: 0 auto;
        color: #64748b;
        font-size: 1.1rem;
        line-height: 1.6;
    }
    
    /* Grid Styles */
    .reasons-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }
    
    /* Card Styles */
    .reason-card {
        background: white;
        padding: 40px 30px;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .reason-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: rgba(79, 70, 229, 0.1);
    }
    
    .reason-icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #eef2ff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
        transition: background-color 0.3s ease;
        overflow: hidden;
    }
    
    .reason-card:hover .reason-icon-wrapper {
        background: #e0e7ff;
    }
    
    .reason-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .reason-icon-placeholder {
        font-size: 2.5rem;
        color: #4f46e5;
    }
    
    .reason-content h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
    }
    
    .reason-content p {
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 0;
    }
    
    /* CTA Section */
    .cta-section {
        background: white;
        padding: 50px;
        border-radius: 20px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        margin-top: 60px;
        border: 1px solid #f1f5f9;
    }
    
    .cta-section h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
    }
    
    .btn-lg {
        padding: 12px 30px;
        font-weight: 600;
        font-size: 1rem;
        border-radius: 8px;
    }
    
    .ml-3 {
        margin-left: 1rem;
    }
    
    @media (max-width: 768px) {
        .section-header h2 {
            font-size: 2rem;
        }
        
        .cta-section {
            padding: 30px;
        }
        
        .cta-section .btn {
            display: block;
            width: 100%;
            margin: 10px 0;
        }
        
        .ml-3 {
            margin-left: 0;
        }
    }
</style>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php';
?>
