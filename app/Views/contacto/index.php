<?php ob_start(); ?>

<section class="hero-contacto">
    <div class="container">
        <div class="hero-content-contacto">
            <div class="hero-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <h1 class="hero-title-contacto">Contáctanos</h1>
            <p class="hero-subtitle-contacto">Estamos aquí para atender tus consultas y brindarte la información que necesitas</p>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">Disponible</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-number"><24h</span>
                    <span class="stat-label">Respuesta</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section contact-section">
    <div class="container">
        <div class="contact-grid-layout">
            <!-- Left Column: Info & Map -->
            <div class="contact-left">
                <div class="contact-cards-grid">
                    <div class="contact-info-card">
                        <div class="icon-box"><i class="fas fa-map-marker-alt"></i></div>
                        <h3>Visítanos</h3>
                        <p><?= nl2br(e(site_config('site_direccion', "Av. Principal 123\nTocache, San Martín"))) ?></p>
                    </div>
                    <div class="contact-info-card">
                        <div class="icon-box"><i class="fas fa-phone-alt"></i></div>
                        <h3>Llámanos</h3>
                        <p><?= e(site_config('site_phone', '+51 999 888 777')) ?></p>
                    </div>
                    <div class="contact-info-card">
                        <div class="icon-box"><i class="fas fa-envelope"></i></div>
                        <h3>Escríbenos</h3>
                        <p><?= e(site_config('site_email', 'informes@acip.edu.pe')) ?></p>
                    </div>
                    <div class="contact-info-card">
                        <div class="icon-box"><i class="far fa-clock"></i></div>
                        <h3>Horario</h3>
                        <p><?= e(site_config('site_horario', 'Lun - Vie: 8am - 6pm')) ?></p>
                    </div>
                </div>
                
                <div class="contact-map">
                    <!-- Dynamic Google Map Embed -->
                    <?= site_config('site_map_embed') ?: '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15764.394628296!2d-76.5166667!3d-8.1833333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91a5db8fb64821a7%3A0x6bbaec4d284a37b4!2sTocache!5e0!3m2!1ses-419!2spe!4v1703550000000!5m2!1ses-419!2spe" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>' ?>
                </div>
            </div>

            <!-- Right Column: Form -->
            <div class="contact-right">
                <div class="contact-form-card">
                    <div class="form-header">
                        <h2>Envíanos un mensaje</h2>
                        <p>¿Tienes alguna consulta? Llena el formulario y te responderemos a la brevedad.</p>
                    </div>
                    
                    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                    <div class="alert alert-success" style="padding: 15px; background: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 20px;">
                        <i class="fas fa-check-circle"></i> Mensaje enviado correctamente.
                    </div>
                    <?php endif; ?>

                    <form action="<?= url('contacto') ?>" method="POST" class="corporate-form">
                        <div class="form-group">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ej. Juan Pérez" required>
                        </div>
                        
                        <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label for="email">Email Corporativo / Personal</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="nombre@correo.com" required>
                            </div>
                            <div class="form-group">
                                <label for="celular">Celular</label>
                                <input type="tel" id="celular" name="celular" class="form-control" placeholder="999 888 777">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="asunto">Asunto</label>
                            <input type="text" id="asunto" name="asunto" class="form-control" placeholder="Consulta sobre admisión..." required>
                        </div>

                        <div class="form-group">
                            <label for="mensaje">Mensaje</label>
                            <textarea id="mensaje" name="mensaje" rows="5" class="form-control" placeholder="Escribe tu mensaje aquí..." required></textarea>
                        </div>

                        <button type="submit" class="btn-submit">
                            Enviar Mensaje <i class="fas fa-paper-plane ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
/* Professional Contact Hero */
.hero-contacto {
    background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 40%, #0ea5e9 100%);
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.hero-contacto::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 50%, rgba(14, 165, 233, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(56, 189, 248, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 50% 20%, rgba(6, 182, 212, 0.2) 0%, transparent 40%),
        url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(14,165,233,0.15)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    animation: electricPulse 3s ease-in-out infinite;
}

@keyframes electricPulse {
    0%, 100% {
        opacity: 0.4;
    }
    50% {
        opacity: 0.7;
    }
}

.hero-content-contacto {
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

.hero-title-contacto {
    font-size: 3.5rem;
    font-weight: 900;
    color: white;
    margin: 0 0 16px 0;
    letter-spacing: -0.02em;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.hero-subtitle-contacto {
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

.hero-title-contacto {
    animation: fadeInUp 0.8s ease-out 0.2s both;
}

.hero-subtitle-contacto {
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
    .hero-contacto {
        padding: 60px 0;
    }
    
    .hero-title-contacto {
        font-size: 2.5rem;
    }
    
    .hero-subtitle-contacto {
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
</style>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php';
?>
