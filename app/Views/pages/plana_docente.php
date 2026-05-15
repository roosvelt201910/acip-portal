<?php 
// Group teachers by program
$grouped = [];
$programas = [];

foreach ($docentes as $docente) {
    $program = $docente['programa_nombre'] ?? 'General';
    $programId = $docente['programa_id'] ?? 'general';
    
    if (!isset($grouped[$program])) {
        $grouped[$program] = [];
        $programas[] = [
            'id' => $programId,
            'nombre' => $program
        ];
    }
    $grouped[$program][] = $docente;
}

// Sort to put "General" first if exists
usort($programas, function($a, $b) {
    if ($a['nombre'] === 'General') return -1;
    if ($b['nombre'] === 'General') return 1;
    return strcmp($a['nombre'], $b['nombre']);
});

ob_start(); 
?>

<div class="plana-docente-page">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-bg">
            <div class="hero-pattern"></div>
            <div class="hero-gradient"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <span class="hero-badge">
                    <i class="fas fa-users"></i>
                    Nuestro Equipo
                </span>
                <h1 class="hero-title">Plana Docente</h1>
                <div class="hero-divider"></div>
                <p class="hero-description">
                    En nuestra institución contamos con docentes altamente capacitados y con amplia experiencia 
                    en el ámbito laboral y empresarial. Cada uno se mantiene actualizado en las últimas tendencias 
                    y prácticas del sector, lo que garantiza una formación de calidad que prepara a nuestros 
                    estudiantes para enfrentar los desafíos del mundo profesional.
                </p>
            </div>
        </div>
        <div class="hero-wave">
            <svg viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path d="M0,40 C320,100 620,0 960,50 C1300,100 1440,30 1440,30 L1440,100 L0,100 Z" fill="#f8fafc"/>
            </svg>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            
            <?php if (empty($docentes)): ?>
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>Próximamente</h3>
                    <p>Estamos actualizando la información de nuestra plana docente.</p>
                </div>
            <?php else: ?>

                <!-- Program Tabs -->
                <div class="tabs-wrapper">
                    <div class="tabs-container">
                        <div class="tabs-scroll">
                            <?php $isFirst = true; foreach ($programas as $index => $prog): ?>
                                <button class="tab-btn <?= $isFirst ? 'active' : '' ?>" 
                                        data-tab="<?= htmlspecialchars($prog['nombre']) ?>"
                                        onclick="switchTab('<?= htmlspecialchars(addslashes($prog['nombre'])) ?>', this)">
                                    <i class="fas fa-graduation-cap"></i>
                                    <span><?= htmlspecialchars($prog['nombre']) ?></span>
                                    <span class="tab-count"><?= count($grouped[$prog['nombre']]) ?></span>
                                </button>
                            <?php $isFirst = false; endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Active Program Title -->
                <div class="program-header">
                    <div class="program-title-wrapper">
                        <h2 class="program-title" id="programTitle">
                            Docentes del Programa de Estudios: <span><?= htmlspecialchars($programas[0]['nombre'] ?? '') ?></span>
                        </h2>
                        <div class="program-line"></div>
                    </div>
                    <div class="program-stats">
                        <span id="docenteCount"><?= count($grouped[$programas[0]['nombre']] ?? []) ?></span> docentes
                    </div>
                </div>

                <!-- Teachers Grid Container -->
                <div class="teachers-container">
                    <?php foreach ($grouped as $programa => $grupo): ?>
                        <div class="tab-content <?= $programa === $programas[0]['nombre'] ? 'active' : '' ?>" 
                             data-content="<?= htmlspecialchars($programa) ?>">
                            <div class="teachers-grid">
                                <?php foreach ($grupo as $index => $docente): ?>
                                    <article class="teacher-card" style="--delay: <?= $index * 0.05 ?>s">
                                        <!-- Card Image -->
                                        <div class="card-image">
                                            <?php if ($docente['foto']): ?>
                                                <img src="<?= url($docente['foto']) ?>" 
                                                     alt="<?= htmlspecialchars($docente['nombre']) ?>"
                                                     loading="lazy">
                                            <?php else: ?>
                                                <div class="image-placeholder">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <!-- Hover Overlay -->
                                            <div class="card-overlay">
                                                <div class="overlay-content">
                                                    <?php if ($docente['cv']): ?>
                                                        <a href="<?= url($docente['cv']) ?>" target="_blank" class="overlay-btn" title="Ver CV">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if ($docente['carga_horaria']): ?>
                                                        <a href="<?= url($docente['carga_horaria']) ?>" target="_blank" class="overlay-btn" title="Ver Horario">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <h3 class="teacher-name"><?= htmlspecialchars($docente['nombre']) ?></h3>
                                            <p class="teacher-role"><?= htmlspecialchars($docente['cargo']) ?></p>
                                            
                                            <!-- Document Buttons -->
                                            <div class="card-actions">
                                                <?php if ($docente['cv']): ?>
                                                    <a href="<?= url($docente['cv']) ?>" target="_blank" class="action-btn cv">
                                                        <i class="fas fa-file-pdf"></i>
                                                        <span>CV</span>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($docente['carga_horaria']): ?>
                                                    <a href="<?= url($docente['carga_horaria']) ?>" target="_blank" class="action-btn schedule">
                                                        <i class="fas fa-clock"></i>
                                                        <span>Carga Horaria</span>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>
    </main>

    <!-- Stats Section -->
    <?php if (!empty($docentes)): ?>
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number"><?= count($docentes) ?></span>
                        <span class="stat-label">Docentes</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number"><?= count($programas) ?></span>
                        <span class="stat-label">Programas</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Profesionales</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number">A+</span>
                        <span class="stat-label">Calidad</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</div>

<style>
/* ============================================
   CSS Variables
   ============================================ */
:root {
    --primary: #0ea5e9;
    --primary-dark: #0284c7;
    --primary-darker: #0369a1;
    --primary-light: #e0f2fe;
    
    --secondary: #64748b;
    --accent: #f59e0b;
    
    --success: #10b981;
    --success-light: #d1fae5;
    
    --danger: #ef4444;
    --danger-light: #fee2e2;
    
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
    --radius-full: 9999px;
    
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    
    --transition: 300ms cubic-bezier(0.4, 0, 0.2, 1);
}

/* ============================================
   Base
   ============================================ */
.plana-docente-page {
    background: var(--gray-50);
    min-height: 100vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* ============================================
   Hero Section
   ============================================ */
.hero-section {
    position: relative;
    padding: 5rem 0 8rem;
    overflow: hidden;
}

.hero-bg {
    position: absolute;
    inset: 0;
}

.hero-gradient {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 40%, #0ea5e9 100%);
}

.hero-pattern {
    position: absolute;
    inset: 0;
    opacity: 0.1;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.hero-content {
    position: relative;
    z-index: 10;
    text-align: center;
    max-width: 900px;
    margin: 0 auto;
    color: white;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1.25rem;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-full);
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin: 0 0 1rem;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.hero-divider {
    width: 80px;
    height: 4px;
    background: var(--accent);
    margin: 0 auto 1.5rem;
    border-radius: 2px;
}

.hero-description {
    font-size: 1.1rem;
    line-height: 1.8;
    opacity: 0.95;
    margin: 0;
}

.hero-wave {
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    line-height: 0;
    z-index: 5;
}

.hero-wave svg {
    width: 100%;
    height: 80px;
}

/* ============================================
   Main Content
   ============================================ */
.main-content {
    padding: 3rem 0 4rem;
}

/* ============================================
   Tabs
   ============================================ */
.tabs-wrapper {
    margin-bottom: 2.5rem;
}

.tabs-container {
    background: white;
    border-radius: var(--radius-xl);
    padding: 0.75rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--gray-100);
}

.tabs-scroll {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.5rem;
}

.tab-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    background: transparent;
    border: none;
    border-radius: var(--radius-lg);
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--gray-600);
    cursor: pointer;
    transition: all var(--transition);
    white-space: nowrap;
}

.tab-btn i {
    font-size: 0.85rem;
    opacity: 0.7;
}

.tab-btn .tab-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 24px;
    height: 24px;
    padding: 0 0.5rem;
    background: var(--gray-100);
    color: var(--gray-500);
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: 700;
    transition: all var(--transition);
}

.tab-btn:hover {
    background: var(--gray-50);
    color: var(--primary);
}

.tab-btn:hover .tab-count {
    background: var(--primary-light);
    color: var(--primary);
}

.tab-btn.active {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    box-shadow: 0 4px 14px -3px rgba(14, 165, 233, 0.5);
}

.tab-btn.active i {
    opacity: 1;
}

.tab-btn.active .tab-count {
    background: rgba(255, 255, 255, 0.25);
    color: white;
}

/* ============================================
   Program Header
   ============================================ */
.program-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.program-title-wrapper {
    flex: 1;
}

.program-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-800);
    margin: 0 0 0.75rem;
}

.program-title span {
    color: var(--primary);
}

.program-line {
    width: 60px;
    height: 4px;
    background: var(--primary);
    border-radius: 2px;
}

.program-stats {
    padding: 0.5rem 1rem;
    background: var(--primary-light);
    color: var(--primary-dark);
    border-radius: var(--radius-full);
    font-size: 0.875rem;
    font-weight: 600;
}

.program-stats span {
    font-weight: 800;
}

/* ============================================
   Teachers Grid
   ============================================ */
.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
    animation: fadeIn 0.4s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.teachers-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
}

@media (max-width: 1200px) {
    .teachers-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 900px) {
    .teachers-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 540px) {
    .teachers-grid {
        grid-template-columns: 1fr;
        max-width: 320px;
        margin: 0 auto;
    }
}

/* ============================================
   Teacher Card
   ============================================ */
.teacher-card {
    background: white;
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--gray-100);
    transition: all var(--transition);
    animation: cardIn 0.5s ease both;
    animation-delay: var(--delay);
}

@keyframes cardIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.teacher-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

/* Card Image */
.card-image {
    position: relative;
    aspect-ratio: 1;
    background: var(--gray-100);
    overflow: hidden;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.teacher-card:hover .card-image img {
    transform: scale(1.08);
}

.image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
    color: var(--gray-400);
    font-size: 4rem;
}

/* Card Overlay */
.card-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, transparent 50%);
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding: 1.5rem;
    opacity: 0;
    transition: opacity var(--transition);
}

.teacher-card:hover .card-overlay {
    opacity: 1;
}

.overlay-content {
    display: flex;
    gap: 0.75rem;
    transform: translateY(20px);
    transition: transform var(--transition);
}

.teacher-card:hover .overlay-content {
    transform: translateY(0);
}

.overlay-btn {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    color: var(--gray-700);
    border-radius: var(--radius-md);
    text-decoration: none;
    font-size: 1.1rem;
    transition: all var(--transition);
}

.overlay-btn:hover {
    background: var(--primary);
    color: white;
    transform: scale(1.1);
}

/* Card Body */
.card-body {
    padding: 1.25rem;
    text-align: center;
}

.teacher-name {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--gray-800);
    margin: 0 0 0.25rem;
    line-height: 1.4;
}

.teacher-role {
    font-size: 0.8rem;
    color: var(--gray-500);
    margin: 0 0 1rem;
}

/* Card Actions */
.card-actions {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.5rem 0.875rem;
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    transition: all var(--transition);
}

.action-btn.cv {
    background: var(--primary);
    color: white;
}

.action-btn.cv:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px -2px rgba(14, 165, 233, 0.4);
}

.action-btn.schedule {
    background: var(--success);
    color: white;
}

.action-btn.schedule:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px -2px rgba(16, 185, 129, 0.4);
}

/* ============================================
   Stats Section
   ============================================ */
.stats-section {
    background: linear-gradient(135deg, var(--gray-800) 0%, var(--gray-900) 100%);
    padding: 3rem 0;
    margin-top: 3rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--radius-lg);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all var(--transition);
}

.stat-item:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-3px);
}

.stat-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 1.75rem;
    font-weight: 800;
    color: white;
    line-height: 1;
}

.stat-label {
    font-size: 0.85rem;
    color: var(--gray-400);
    margin-top: 0.25rem;
}

/* ============================================
   Empty State
   ============================================ */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
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
    font-weight: 700;
    color: var(--gray-800);
    margin: 0 0 0.5rem;
}

.empty-state p {
    color: var(--gray-500);
    margin: 0;
}

/* ============================================
   Responsive
   ============================================ */
@media (max-width: 768px) {
    .hero-section {
        padding: 3rem 0 6rem;
    }
    
    .hero-title {
        font-size: 2.25rem;
    }
    
    .hero-description {
        font-size: 1rem;
    }
    
    .tabs-scroll {
        justify-content: flex-start;
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 0.5rem;
        -webkit-overflow-scrolling: touch;
    }
    
    .tab-btn {
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
    }
    
    .tab-btn span:not(.tab-count) {
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .program-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .program-title {
        font-size: 1.25rem;
    }
}
</style>

<script>
function switchTab(tabName, btn) {
    // Update active button
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    
    // Update content visibility
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    
    const targetContent = document.querySelector(`[data-content="${tabName}"]`);
    if (targetContent) {
        targetContent.classList.add('active');
        
        // Reset animations
        targetContent.querySelectorAll('.teacher-card').forEach((card, index) => {
            card.style.animation = 'none';
            card.offsetHeight; // Trigger reflow
            card.style.animation = null;
        });
    }
    
    // Update title
    const titleSpan = document.querySelector('#programTitle span');
    if (titleSpan) {
        titleSpan.textContent = tabName;
    }
    
    // Update count
    const countEl = document.getElementById('docenteCount');
    const count = targetContent ? targetContent.querySelectorAll('.teacher-card').length : 0;
    if (countEl) {
        countEl.textContent = count;
    }
    
    // Smooth scroll to content on mobile
    if (window.innerWidth < 768) {
        document.querySelector('.program-header').scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add horizontal scroll indicators for tabs on mobile
    const tabsScroll = document.querySelector('.tabs-scroll');
    if (tabsScroll) {
        tabsScroll.addEventListener('scroll', function() {
            const container = this.parentElement;
            if (this.scrollLeft > 0) {
                container.classList.add('scrolled-left');
            } else {
                container.classList.remove('scrolled-left');
            }
            
            if (this.scrollLeft < this.scrollWidth - this.clientWidth - 10) {
                container.classList.add('scrolled-right');
            } else {
                container.classList.remove('scrolled-right');
            }
        });
    }
});
</script>

<?php 
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php';
?>