<?php 
// Group members by category
$grouped = [
    'direccion' => [],
    'plana_jerarquica' => [],
    'coordinadores' => [],
    'unidades' => []
];

foreach ($miembros as $miembro) {
    $cat = $miembro['categoria'] ?? 'plana_jerarquica';
    if (isset($grouped[$cat])) {
        $grouped[$cat][] = $miembro;
    } else {
        $grouped['plana_jerarquica'][] = $miembro;
    }
}

ob_start(); 
?>

<div class="potencial-humano-page">
    <!-- Hero Section -->
    <section class="page-hero">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-users"></i>
            </div>
            <h1 class="hero-title">Potencial Humano</h1>
            <p class="hero-subtitle">Equipo directivo y administrativo del <?= e(site_config('site_title', 'Instituto ACIP')) ?></p>
        </div>
        <div class="hero-wave">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path d="M0,60 C360,120 1080,0 1440,60 L1440,120 L0,120 Z" fill="#f8fafc"/>
            </svg>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            
            <?php if (empty($miembros)): ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-users-slash"></i>
                    </div>
                    <h3>Información en actualización</h3>
                    <p>Pronto estará disponible la información del personal institucional.</p>
                </div>
            <?php else: ?>

                <!-- Organizational Pyramid -->
                <div class="org-pyramid">
                    
                    <!-- NIVEL 1: DIRECCIÓN (Cima de la pirámide) -->
                    <?php if (!empty($grouped['direccion'])): ?>
                    <section class="pyramid-level level-1">
                        <div class="level-header">
                            <span class="level-badge">Nivel Directivo</span>
                            <h2 class="level-title">Dirección General</h2>
                            <div class="level-line"></div>
                        </div>
                        
                        <div class="pyramid-row justify-center">
                            <?php foreach ($grouped['direccion'] as $miembro): ?>
                                <?php renderPyramidCard($miembro, 'director'); ?>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Connector Lines -->
                        <div class="pyramid-connector">
                            <div class="connector-line vertical"></div>
                            <div class="connector-line horizontal"></div>
                        </div>
                    </section>
                    <?php endif; ?>

                    <!-- NIVEL 2: PLANA JERÁRQUICA -->
                    <?php if (!empty($grouped['plana_jerarquica'])): ?>
                    <section class="pyramid-level level-2">
                        <div class="level-header">
                            <span class="level-badge">Nivel Jerárquico</span>
                            <h2 class="level-title">Plana Jerárquica</h2>
                            <div class="level-line"></div>
                        </div>
                        
                        <div class="pyramid-row">
                            <?php foreach ($grouped['plana_jerarquica'] as $miembro): ?>
                                <?php renderPyramidCard($miembro, 'jerarquico'); ?>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Connector Lines -->
                        <div class="pyramid-connector">
                            <div class="connector-line vertical"></div>
                            <div class="connector-line horizontal wide"></div>
                        </div>
                    </section>
                    <?php endif; ?>

                    <!-- NIVEL 3: COORDINADORES -->
                    <?php if (!empty($grouped['coordinadores'])): ?>
                    <section class="pyramid-level level-3">
                        <div class="level-header">
                            <span class="level-badge">Nivel Coordinación</span>
                            <h2 class="level-title">Coordinadores de Programas de Estudios</h2>
                            <div class="level-line"></div>
                        </div>
                        
                        <div class="pyramid-row expanded">
                            <?php foreach ($grouped['coordinadores'] as $miembro): ?>
                                <?php renderPyramidCard($miembro, 'coordinador'); ?>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Connector Lines -->
                        <div class="pyramid-connector">
                            <div class="connector-line vertical"></div>
                            <div class="connector-line horizontal wide"></div>
                        </div>
                    </section>
                    <?php endif; ?>

                    <!-- NIVEL 4: UNIDADES -->
                    <?php if (!empty($grouped['unidades'])): ?>
                    <section class="pyramid-level level-4">
                        <div class="level-header">
                            <span class="level-badge">Nivel Operativo</span>
                            <h2 class="level-title">Unidades Institucionales</h2>
                            <div class="level-line"></div>
                        </div>
                        
                        <div class="pyramid-row">
                            <?php foreach ($grouped['unidades'] as $miembro): ?>
                                <?php renderPyramidCard($miembro, 'unidad'); ?>
                            <?php endforeach; ?>
                        </div>
                    </section>
                    <?php endif; ?>

                </div>

                <!-- Pyramid Visual Indicator -->
                <div class="pyramid-visual">
                    <div class="pyramid-shape">
                        <div class="pyramid-tier tier-1" data-level="Dirección"></div>
                        <div class="pyramid-tier tier-2" data-level="Jerárquica"></div>
                        <div class="pyramid-tier tier-3" data-level="Coordinadores"></div>
                        <div class="pyramid-tier tier-4" data-level="Unidades"></div>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </main>
</div>

<?php 
// Helper function for pyramid cards
function renderPyramidCard($miembro, $type = 'standard') {
    $imgUrl = $miembro['imagen'] ? url($miembro['imagen']) : null;
    $typeClass = $type;
    ?>
    <div class="pyramid-card <?= $typeClass ?>">
        <div class="card-inner">
            <!-- Photo Container -->
            <div class="card-photo">
                <?php if ($imgUrl): ?>
                    <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($miembro['nombre']) ?>">
                <?php else: ?>
                    <div class="photo-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                <?php endif; ?>
                <div class="photo-ring"></div>
            </div>
            
            <!-- Info Container -->
            <div class="card-info">
                <h3 class="card-name"><?= htmlspecialchars($miembro['nombre']) ?></h3>
                <div class="card-role"><?= htmlspecialchars($miembro['cargo']) ?></div>
                <?php if($miembro['email']): ?>
                    <a href="mailto:<?= htmlspecialchars($miembro['email']) ?>" class="card-email">
                        <i class="fas fa-envelope"></i>
                        <span><?= htmlspecialchars($miembro['email']) ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Card Accent -->
        <div class="card-accent"></div>
    </div>
    <?php
}
?>

<style>
/* ============================================
   CSS Variables
   ============================================ */
:root {
    --primary-900: #1e3a5f;
    --primary-800: #1e4976;
    --primary-700: #2563eb;
    --primary-600: #3b82f6;
    --primary-500: #60a5fa;
    --primary-100: #dbeafe;
    --primary-50: #eff6ff;
    
    --accent: #dc2626;
    --accent-light: #fecaca;
    
    --gold: #f59e0b;
    --gold-light: #fef3c7;
    
    --gray-900: #0f172a;
    --gray-800: #1e293b;
    --gray-700: #334155;
    --gray-600: #475569;
    --gray-500: #64748b;
    --gray-400: #94a3b8;
    --gray-300: #cbd5e1;
    --gray-200: #e2e8f0;
    --gray-100: #f1f5f9;
    --gray-50: #f8fafc;
    
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
    
    --transition: 300ms cubic-bezier(0.4, 0, 0.2, 1);
}

/* ============================================
   Base Styles
   ============================================ */
.potencial-humano-page {
    background: var(--gray-50);
    min-height: 100vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

.container {
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* ============================================
   Hero Section
   ============================================ */
.page-hero {
    position: relative;
    min-height: 320px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.hero-bg {
    position: absolute;
    inset: 0;
    background: 
        linear-gradient(135deg, var(--primary-900) 0%, var(--primary-800) 50%, var(--primary-700) 100%);
}

.hero-bg::before {
    content: '';
    position: absolute;
    inset: 0;
    background: 
        url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.5;
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at center, transparent 0%, rgba(0,0,0,0.2) 100%);
}

.hero-content {
    position: relative;
    z-index: 10;
    text-align: center;
    color: white;
    padding: 2rem;
}

.hero-badge {
    width: 70px;
    height: 70px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 1.75rem;
}

.hero-title {
    font-size: 3rem;
    font-weight: 800;
    margin: 0 0 0.75rem;
    text-transform: uppercase;
    letter-spacing: 3px;
    text-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

.hero-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
    font-weight: 400;
}

.hero-wave {
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    z-index: 10;
    line-height: 0;
}

.hero-wave svg {
    width: 100%;
    height: 60px;
}

/* ============================================
   Main Content
   ============================================ */
.main-content {
    padding: 3rem 0 5rem;
}

/* ============================================
   Empty State
   ============================================ */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: var(--gray-100);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.5rem;
    color: var(--gray-400);
}

.empty-state h3 {
    font-size: 1.5rem;
    color: var(--gray-700);
    margin: 0 0 0.5rem;
}

.empty-state p {
    color: var(--gray-500);
    margin: 0;
}

/* ============================================
   Organizational Pyramid
   ============================================ */
.org-pyramid {
    position: relative;
}

/* ============================================
   Pyramid Level
   ============================================ */
.pyramid-level {
    position: relative;
    margin-bottom: 3rem;
}

.pyramid-level:last-child {
    margin-bottom: 0;
}

/* Level Header */
.level-header {
    text-align: center;
    margin-bottom: 2rem;
}

.level-badge {
    display: inline-block;
    padding: 0.35rem 1rem;
    background: var(--primary-50);
    color: var(--primary-700);
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    border-radius: 50px;
    margin-bottom: 0.75rem;
}

.level-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--gray-800);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0 0 0.75rem;
}

.level-line {
    width: 50px;
    height: 3px;
    background: var(--accent);
    margin: 0 auto;
    border-radius: 2px;
}

/* ============================================
   Pyramid Row - Triangle Distribution
   ============================================ */
.pyramid-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1.5rem;
    max-width: 100%;
    margin: 0 auto;
}

/* Level 1: Director - Centered, Single Card */
.level-1 .pyramid-row {
    max-width: 320px;
}

.level-1 .pyramid-card {
    width: 100%;
    max-width: 300px;
}

/* Level 2: Plana Jerárquica - 3 Cards */
.level-2 .pyramid-row {
    max-width: 900px;
}

.level-2 .pyramid-card {
    width: calc(33.333% - 1rem);
    min-width: 250px;
    max-width: 280px;
}

/* Level 3: Coordinadores - 4+ Cards, Wider */
.level-3 .pyramid-row {
    max-width: 1200px;
}

.level-3 .pyramid-card {
    width: calc(25% - 1.125rem);
    min-width: 220px;
    max-width: 260px;
}

/* Level 4: Unidades - 3-4 Cards */
.level-4 .pyramid-row {
    max-width: 1000px;
}

.level-4 .pyramid-card {
    width: calc(33.333% - 1rem);
    min-width: 240px;
    max-width: 280px;
}

/* ============================================
   Pyramid Card
   ============================================ */
.pyramid-card {
    position: relative;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all var(--transition);
}

.pyramid-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.card-inner {
    padding: 2rem 1.5rem;
    text-align: center;
}

/* Card Photo */
.card-photo {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 1.25rem;
}

.card-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.photo-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: var(--gray-400);
}

.photo-ring {
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    border: 3px solid transparent;
    transition: all var(--transition);
}

.pyramid-card:hover .photo-ring {
    border-color: var(--primary-500);
    transform: scale(1.05);
}

/* Card Types - Different Ring Colors */
.pyramid-card.director .photo-ring {
    border: 3px solid var(--gold);
    box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
}

.pyramid-card.director:hover .photo-ring {
    border-color: var(--gold);
    box-shadow: 0 0 30px rgba(245, 158, 11, 0.5);
}

.pyramid-card.jerarquico .photo-ring {
    border: 3px solid var(--primary-600);
}

.pyramid-card.coordinador .photo-ring {
    border: 3px solid var(--accent);
}

.pyramid-card.unidad .photo-ring {
    border: 3px solid var(--gray-400);
}

/* Card Info */
.card-info {
    position: relative;
}

.card-name {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--gray-900);
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin: 0 0 0.5rem;
    line-height: 1.3;
}

.card-role {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

/* Role colors by type */
.pyramid-card.director .card-role {
    color: var(--gold);
}

.pyramid-card.jerarquico .card-role {
    color: var(--primary-700);
}

.pyramid-card.coordinador .card-role {
    color: var(--accent);
}

.card-email {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.75rem;
    background: var(--gray-50);
    border-radius: 6px;
    font-size: 0.75rem;
    color: var(--gray-500);
    text-decoration: none;
    transition: all var(--transition);
    max-width: 100%;
    overflow: hidden;
}

.card-email i {
    flex-shrink: 0;
    font-size: 0.7rem;
}

.card-email span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.card-email:hover {
    background: var(--primary-50);
    color: var(--primary-700);
}

/* Card Accent - Top Border by Type */
.card-accent {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
}

.pyramid-card.director .card-accent {
    background: linear-gradient(90deg, var(--gold), #fbbf24);
}

.pyramid-card.jerarquico .card-accent {
    background: linear-gradient(90deg, var(--primary-700), var(--primary-500));
}

.pyramid-card.coordinador .card-accent {
    background: linear-gradient(90deg, var(--accent), #ef4444);
}

.pyramid-card.unidad .card-accent {
    background: linear-gradient(90deg, var(--gray-500), var(--gray-400));
}

/* ============================================
   Pyramid Connectors
   ============================================ */
.pyramid-connector {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem 0;
}

.connector-line {
    background: var(--gray-300);
}

.connector-line.vertical {
    width: 2px;
    height: 30px;
}

.connector-line.horizontal {
    width: 200px;
    height: 2px;
    position: relative;
}

.connector-line.horizontal.wide {
    width: 400px;
}

.connector-line.horizontal::before,
.connector-line.horizontal::after {
    content: '';
    position: absolute;
    top: -4px;
    width: 2px;
    height: 10px;
    background: var(--gray-300);
}

.connector-line.horizontal::before {
    left: 0;
}

.connector-line.horizontal::after {
    right: 0;
}

/* ============================================
   Pyramid Visual Indicator (Side)
   ============================================ */
.pyramid-visual {
    position: fixed;
    left: 2rem;
    top: 50%;
    transform: translateY(-50%);
    z-index: 100;
    display: none; /* Show on larger screens */
}

@media (min-width: 1400px) {
    .pyramid-visual {
        display: block;
    }
}

.pyramid-shape {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
}

.pyramid-tier {
    background: var(--gray-300);
    height: 20px;
    border-radius: 4px;
    position: relative;
    transition: all var(--transition);
    cursor: pointer;
}

.pyramid-tier::after {
    content: attr(data-level);
    position: absolute;
    left: calc(100% + 10px);
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.65rem;
    font-weight: 600;
    color: var(--gray-500);
    white-space: nowrap;
    opacity: 0;
    transition: opacity var(--transition);
}

.pyramid-tier:hover::after {
    opacity: 1;
}

.pyramid-tier.tier-1 {
    width: 30px;
    background: linear-gradient(135deg, var(--gold), #fbbf24);
}

.pyramid-tier.tier-2 {
    width: 50px;
    background: linear-gradient(135deg, var(--primary-700), var(--primary-500));
}

.pyramid-tier.tier-3 {
    width: 70px;
    background: linear-gradient(135deg, var(--accent), #ef4444);
}

.pyramid-tier.tier-4 {
    width: 90px;
    background: linear-gradient(135deg, var(--gray-600), var(--gray-400));
}

/* ============================================
   Director Card - Special Styling
   ============================================ */
.level-1 .pyramid-card.director {
    background: linear-gradient(135deg, #fffbeb 0%, white 50%);
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.level-1 .pyramid-card.director .card-photo {
    width: 140px;
    height: 140px;
}

.level-1 .pyramid-card.director .card-name {
    font-size: 1rem;
}

.level-1 .pyramid-card.director .card-role {
    font-size: 0.95rem;
}

/* ============================================
   Animations
   ============================================ */
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

.pyramid-level {
    animation: fadeInUp 0.6s ease-out both;
}

.level-1 { animation-delay: 0.1s; }
.level-2 { animation-delay: 0.2s; }
.level-3 { animation-delay: 0.3s; }
.level-4 { animation-delay: 0.4s; }

/* ============================================
   Responsive Design
   ============================================ */
@media (max-width: 1200px) {
    .level-3 .pyramid-card {
        width: calc(33.333% - 1rem);
    }
}

@media (max-width: 992px) {
    .hero-title {
        font-size: 2.25rem;
        letter-spacing: 2px;
    }
    
    .level-2 .pyramid-card,
    .level-3 .pyramid-card,
    .level-4 .pyramid-card {
        width: calc(50% - 0.75rem);
        max-width: 280px;
    }
    
    .connector-line.horizontal,
    .connector-line.horizontal.wide {
        width: 150px;
    }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 1.75rem;
        letter-spacing: 1px;
    }
    
    .hero-badge {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .level-title {
        font-size: 1rem;
    }
    
    .pyramid-row {
        gap: 1rem;
    }
    
    .level-1 .pyramid-card,
    .level-2 .pyramid-card,
    .level-3 .pyramid-card,
    .level-4 .pyramid-card {
        width: 100%;
        max-width: 300px;
    }
    
    .card-photo {
        width: 100px;
        height: 100px;
    }
    
    .level-1 .pyramid-card.director .card-photo {
        width: 120px;
        height: 120px;
    }
    
    .pyramid-connector {
        display: none;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 1.5rem;
    }
    
    .card-inner {
        padding: 1.5rem 1rem;
    }
    
    .card-name {
        font-size: 0.85rem;
    }
    
    .card-role {
        font-size: 0.8rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all pyramid cards
    document.querySelectorAll('.pyramid-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = `all 0.5s ease ${index * 0.05}s`;
        observer.observe(card);
    });

    // Pyramid visual indicator - highlight on scroll
    const levels = document.querySelectorAll('.pyramid-level');
    const tiers = document.querySelectorAll('.pyramid-tier');

    window.addEventListener('scroll', () => {
        levels.forEach((level, index) => {
            const rect = level.getBoundingClientRect();
            const isVisible = rect.top < window.innerHeight / 2 && rect.bottom > window.innerHeight / 2;
            
            if (tiers[index]) {
                if (isVisible) {
                    tiers[index].style.transform = 'scale(1.2)';
                    tiers[index].style.boxShadow = '0 0 15px rgba(0,0,0,0.2)';
                } else {
                    tiers[index].style.transform = 'scale(1)';
                    tiers[index].style.boxShadow = 'none';
                }
            }
        });
    });

    // Click on pyramid tier to scroll to level
    tiers.forEach((tier, index) => {
        tier.addEventListener('click', () => {
            if (levels[index]) {
                levels[index].scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });
});
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php';
?>