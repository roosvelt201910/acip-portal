<?php
ob_start();
?>

<!-- Modal Aviso -->
<?php if (!empty($aviso)): ?>
<div id="avisoModal" class="aviso-modal" role="dialog" aria-modal="true" aria-labelledby="avisoModalTitle" aria-hidden="true">
    <div class="aviso-modal-backdrop" onclick="closeAvisoModal()" aria-hidden="true"></div>
    <div class="aviso-modal-dialog">
        <div class="aviso-modal-content">
            <div class="aviso-modal-header">
                <div class="aviso-modal-header-text">
                    <span class="aviso-modal-badge">Aviso institucional</span>
                    <h2 id="avisoModalTitle"><?= e($aviso['titulo']) ?></h2>
                </div>
                <button type="button" class="aviso-modal-close" onclick="closeAvisoModal()" aria-label="Cerrar aviso">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="aviso-modal-body">
        <?php if ($aviso['tipo_contenido'] === 'imagen' && $aviso['imagen']): ?>
            <div class="aviso-imagen">
                <img src="<?= url($aviso['imagen']) ?>" alt="<?= e($aviso['titulo']) ?>">
            </div>
        <?php elseif ($aviso['tipo_contenido'] === 'video' && $aviso['video_url']): ?>
            <div class="aviso-video">
                <?php 
                $videoUrl = getEmbedUrl($aviso['video_url']);
                $isYoutube = strpos($videoUrl, 'youtube') !== false;
                $isVimeo = strpos($videoUrl, 'vimeo') !== false;
                
                if ($isYoutube):
                    // YouTube autoplay parameters
                    $iframeSrc = $videoUrl . '?autoplay=1&mute=0&controls=1';
                ?>
                    <iframe src="<?= $iframeSrc ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <?php elseif ($isVimeo):
                    // Vimeo autoplay parameters
                    $iframeSrc = $videoUrl . '?autoplay=1&muted=0';
                ?>
                    <iframe src="<?= $iframeSrc ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <?php endif; ?>
            </div>
        <?php elseif ($aviso['tipo_contenido'] === 'html' && $aviso['contenido_html']): ?>
            <div class="aviso-html">
                <?= $aviso['contenido_html'] ?>
            </div>
        <?php endif; ?>
        
            </div>

        <?php if ($aviso['enlace_boton'] || $aviso['mostrar_una_vez']): ?>
            <div class="aviso-modal-footer">
                <?php if ($aviso['enlace_boton']): ?>
                    <div class="aviso-actions">
                        <a href="<?= e($aviso['enlace_boton']) ?>" class="aviso-btn-primary" target="_blank" rel="noopener">
                            <?= e($aviso['texto_boton'] ?: 'Más información') ?>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if ($aviso['mostrar_una_vez']): ?>
                    <div class="aviso-checkbox">
                        <label>
                            <input type="checkbox" id="noMostrarDeNuevo" onchange="toggleNoShowAgain()">
                            <span>No volver a mostrar este aviso</span>
                        </label>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?= asset('css/aviso-modal.css') ?>?v=<?= time() ?>">

<script>
// Modal Aviso Logic
(function() {
    const modal = document.getElementById('avisoModal');
    if (!modal) return;

    const avisoId = '<?= $aviso['id'] ?>';
    const mostrarUnaVez = <?= $aviso['mostrar_una_vez'] ? 'true' : 'false' ?>;
    const storageKey = 'aviso_modal_' + avisoId;

    // Check if user has chosen not to show again
    if (mostrarUnaVez && localStorage.getItem(storageKey) === 'hidden') {
        return;
    }

    function openAvisoModal() {
        modal.classList.add('is-visible');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeAvisoModalInternal() {
        modal.classList.remove('is-visible');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    // Show modal after a short delay
    setTimeout(openAvisoModal, 1000);

    // Close modal function
    window.closeAvisoModal = closeAvisoModalInternal;

    // Toggle "no show again"
    window.toggleNoShowAgain = function() {
        const checkbox = document.getElementById('noMostrarDeNuevo');
        if (checkbox && checkbox.checked) {
            localStorage.setItem(storageKey, 'hidden');
        } else {
            localStorage.removeItem(storageKey);
        }
    };

    // Cerrar con Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modal.classList.contains('is-visible')) {
            closeAvisoModalInternal();
        }
    });
})();
</script>
<?php endif; ?>

<!-- Hero Slider -->
<?php if (!empty($banners)): ?>
<section class="hero-slider">
    <div class="slider-container">
        <?php foreach ($banners as $index => $banner): ?>
        <div class="slide <?= $index === 0 ? 'active' : '' ?>">
            <?php 
            $isVideo = isset($banner['tipo_multimedia']) && $banner['tipo_multimedia'] === 'video' && !empty($banner['video_url']);
            
            if ($isVideo): 
                $videoUrl = getEmbedUrl($banner['video_url']);
                $isIframe = (strpos($videoUrl, 'youtube') !== false || strpos($videoUrl, 'vimeo') !== false);
            ?>
                <div class="video-background" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; z-index: 1;">
                    <?php if ($isIframe): ?>
                        <iframe src="<?= $videoUrl ?>?background=1&autoplay=1&loop=1&byline=0&title=0" frameborder="0" style="position: absolute; top: 50%; left: 50%; width: 100%; height: 100%; min-width: 100%; min-height: 100%; transform: translate(-50%, -50%); pointer-events: none; border: 0;" allow="autoplay; encrypted-media"></iframe>
                    <?php else: ?>
                         <video autoplay muted loop playsinline style="position: absolute; top: 50%; left: 50%; min-width: 100%; min-height: 100%; width: auto; height: auto; transform: translateX(-50%) translateY(-50%); object-fit: cover;">
                            <source src="<?= e($videoUrl) ?>" type="video/mp4">
                        </video>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <img src="<?= url('uploads/banners/' . e($banner['imagen'])) ?>" alt="<?= e($banner['titulo']) ?>" style="z-index: 1;">
            <?php endif; ?>

            <div class="slide-overlay" style="z-index: 2; background: rgba(0,0,0,0.5);"></div>
            <div class="slide-content" style="z-index: 3;">
                <div class="container">
                    <h1><?= e($banner['titulo']) ?></h1>
                    <?php if ($banner['descripcion']): ?>
                    <p><?= e($banner['descripcion']) ?></p>
                    <?php endif; ?>
                    <?php if ($banner['enlace']): ?>
                    <a href="<?= e($banner['enlace']) ?>" class="btn btn-primary"><?= e($banner['boton_texto'] ?: 'Más información') ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <?php if (count($banners) > 1): ?>
    <button class="slider-prev"><i class="fas fa-chevron-left"></i></button>
    <button class="slider-next"><i class="fas fa-chevron-right"></i></button>
    <div class="slider-dots"></div>
    <?php endif; ?>
</section>
<?php endif; ?>

<!-- Welcome / Institutional Section -->
<section class="section welcome-section">
    <div class="container">
        <div class="welcome-grid">
            <div class="welcome-content">
                <h2 class="welcome-title">"<?= e($siteConfig['home_welcome_title'] ?? 'IESTP ACIP - JUANJUI') ?>"</h2>
                <h3 class="welcome-subtitle">"<?= e($siteConfig['home_welcome_subtitle'] ?? 'Empieza tu camino al éxito') ?>"</h3>
                <div class="welcome-text">
                    <?php 
                    $description = $siteConfig['home_welcome_description'] ?? 'Somos una institución educativa privada que formamos profesionales técnicos de calidad y competitividad con habilidades: sociales, emprendimiento, investigación aplicada e innovación y de productividad para responder a las exigencias del sector productivo y contribuir al desarrollo sostenible regional, nacional y global.';
                    // Split by double newlines to create paragraphs
                    $paragraphs = preg_split('/\n\s*\n/', $description);
                    foreach ($paragraphs as $p): ?>
                        <p><?= nl2br(e(trim($p))) ?></p>
                    <?php endforeach; ?>
                </div>
                <?php 
                $btnUrl = $siteConfig['home_welcome_button_url'] ?? '/nosotros';
                $btnText = $siteConfig['home_welcome_button_text'] ?? 'LEER MAS';
                ?>
                <a href="<?= url($btnUrl) ?>" class="btn btn-primary welcome-btn"><?= e($btnText) ?></a>
            </div>
            <div class="welcome-image">
                <?php 
                $mediaType = $siteConfig['home_welcome_media_type'] ?? 'image';
                $videoUrl = $siteConfig['home_welcome_video_url'] ?? '';
                $welcomeImg = $siteConfig['home_welcome_image'] ?? 'uploads/banners/694dadc2eaba4_475551851_122193756290158096_5519593940972461496_n.jpg';
                
                if ($mediaType === 'video' && !empty($videoUrl)):
                    // Extract YouTube video ID
                    $videoId = '';
                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches)) {
                        $videoId = $matches[1];
                    }
                    // YouTube embed with cleaner controls
                    $embedParams = http_build_query([
                        'rel' => 0,              // No related videos
                        'modestbranding' => 1,   // Minimal YouTube branding
                        'showinfo' => 0,         // Hide video title
                        'color' => 'white',      // White progress bar
                        'controls' => 1,         // Show controls
                        'fs' => 1,               // Allow fullscreen
                        'iv_load_policy' => 3,   // Hide annotations
                        'disablekb' => 0,        // Enable keyboard controls
                        'cc_load_policy' => 0,   // Don't show captions
                        'playsinline' => 1,      // Play inline on mobile
                    ]);
                ?>
                    <div class="video-container">
                        <iframe 
                            src="https://www.youtube.com/embed/<?= e($videoId) ?>?<?= $embedParams ?>" 
                            frameborder="0" 
                            loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen
                            title="Video institucional">
                        </iframe>
                    </div>
                <?php else: ?>
                    <img src="<?= url($welcomeImg) ?>" alt="<?= e($siteConfig['home_welcome_title'] ?? 'IESTP ACIP - JUANJUI') ?>">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Noticias Destacadas -->
<?php if (!empty($noticias)): ?>
<section class="section noticias-destacadas">
    <div class="container">
        <div class="section-header news-section-header">
            <div class="news-section-intro">
                <span class="section-eyebrow">Actualidad institucional</span>
                <h2>Noticias Destacadas</h2>
                <p class="section-subtitle">Las últimas novedades, logros y comunicados del Instituto ACIP</p>
            </div>
            <a href="<?= url('/noticias') ?>" class="btn-news-all">
                Ver todas <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="news-slider-wrapper">
            <button class="news-prev" id="news-prev-btn" type="button" aria-label="Noticia anterior" onclick="window.moveNewsPrev()">
                <i class="fas fa-chevron-left"></i>
            </button>

            <div id="news-revolver" class="news-slider-container" data-total="<?= count($noticias) ?>">
            <div class="news-track">
                <?php foreach ($noticias as $noticia): ?>
                <div class="noticia-slide">
                    <article class="noticia-card">
                        <div class="noticia-image">
                            <?php if ($noticia['imagen']): ?>
                            <img src="<?= url(e($noticia['imagen'])) ?>" alt="<?= e($noticia['titulo']) ?>" loading="lazy">
                            <?php else: ?>
                            <div class="noticia-image-placeholder" aria-hidden="true">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <?php endif; ?>
                            <span class="noticia-categoria"><?= e(ucfirst($noticia['categoria'])) ?></span>
                        </div>
                        <div class="noticia-content">
                            <div class="noticia-meta">
                                <span class="meta-pill"><i class="far fa-calendar"></i> <?= formatDate($noticia['fecha_publicacion']) ?></span>
                                <span class="meta-pill"><i class="far fa-user"></i> <?= e($noticia['autor_nombre']) ?></span>
                            </div>
                            <h3><?= e($noticia['titulo']) ?></h3>
                            <p><?= e(truncate($noticia['resumen'], 120)) ?></p>
                            <a href="<?= url('/noticias/' . e($noticia['slug'])) ?>" class="read-more">Leer más <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </article>
                </div>
                <?php endforeach; ?>
            </div>
            </div>

            <button class="news-next" id="news-next-btn" type="button" aria-label="Siguiente noticia" onclick="window.moveNewsNext()">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <?php if (count($noticias) > 1): ?>
        <div class="news-dots" id="news-dots" role="tablist" aria-label="Paginación de noticias">
            <?php for ($i = 0; $i < count($noticias); $i++): ?>
            <button type="button" class="news-dot<?= $i === 0 ? ' active' : '' ?>" data-index="<?= $i ?>" aria-label="Ir a noticia <?= $i + 1 ?>"></button>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<!-- Programas de Estudio -->
<?php if (!empty($programas)): ?>
<section class="section programas-section bg-light">
    <div class="container">
        <div class="section-header text-center">
            <h2>Programas de Estudio</h2>
            <p>Ofrecemos carreras profesionales de calidad orientadas al mercado laboral</p>
        </div>
        
        <div class="programas-slider-container" id="programas-slider">
            <div class="programas-track">
                <?php foreach ($programas as $programa): ?>
                <div class="programa-slide">
                    <div class="programa-card">
                        <?php if ($programa['imagen']): ?>
                        <div class="programa-image">
                            <img src="<?= url(e($programa['imagen'])) ?>" alt="<?= e($programa['nombre']) ?>">
                        </div>
                        <?php endif; ?>
                        <div class="programa-content">
                            <h3><?= e($programa['nombre']) ?></h3>
                            <p><?= e(truncate($programa['descripcion'], 100)) ?></p>
                            <div class="programa-info">
                                <span><i class="far fa-clock"></i> <?= e($programa['duracion_semestres']) ?> semestres</span>
                                <span><i class="fas fa-graduation-cap"></i> <?= e(ucfirst($programa['modalidad'])) ?></span>
                            </div>
                            <a href="<?= url('/programas/' . e($programa['slug'])) ?>" class="btn btn-primary btn-block">Ver programa</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Por qué estudiar aquí -->
<section class="section reasons-section">
    <div class="container">
        <div class="section-header text-center">
            <h2>¿Por qué estudiar en el IESTP ACIP?</h2>
        </div>
        
        <div class="reasons-grid">
            <div class="reason-card">
                <div class="reason-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3>Docentes altamente calificados</h3>
                <p>Contamos con docentes altamente capacitados, con amplia experiencia y comprometidos con tu aprendizaje y desarrollo profesional.</p>
            </div>
            
            <div class="reason-card">
                <div class="reason-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <h3>Calidad en el servicio educativo</h3>
                <p>Ofrecemos una educación de calidad y excelencia, con programas académicos que están enfocados en las necesidades del mercado laboral.</p>
            </div>
            
            <div class="reason-card">
                <div class="reason-icon">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h3>Tecnología e infraestructura</h3>
                <p>Nuestras instalaciones están equipadas con tecnología de punta, creando un entorno propicio para el aprendizaje práctico y teórico.</p>
            </div>
            
            <div class="reason-card">
                <div class="reason-icon">
                    <i class="fas fa-scroll"></i>
                </div>
                <h3>Título a nombre de la Nación</h3>
                <p>Al finalizar tu carrera, obtendrás un título oficial reconocido por el Estado, abriendo puertas a múltiples oportunidades laborales.</p>
            </div>
        </div>
    </div>
</section>

<!-- Próximos Eventos -->
<?php if (!empty($eventos)): ?>
<section class="section eventos-section">
    <div class="container">
        <div class="section-header">
            <h2>Próximos Eventos</h2>
            <a href="<?= url('/eventos') ?>" class="btn btn-outline">Ver calendario</a>
        </div>
        
        <div class="events-slider-container">
            <div class="events-track">
                <?php foreach ($eventos as $evento): ?>
                <div class="evento-slide">
                    <div class="evento-item">
                        <div class="evento-date">
                            <span class="day"><?= date('d', strtotime($evento['fecha_inicio'])) ?></span>
                            <span class="month"><?= date('M', strtotime($evento['fecha_inicio'])) ?></span>
                        </div>
                        <div class="evento-info">
                            <h3><?= e($evento['titulo']) ?></h3>
                            <p><?= e(truncate(strip_tags($evento['descripcion']), 120)) ?></p>
                            <div class="evento-meta">
                                <span><i class="far fa-clock"></i> <?= date('H:i', strtotime($evento['fecha_inicio'])) ?></span>
                                <?php if ($evento['ubicacion']): ?>
                                <span><i class="fas fa-map-marker-alt"></i> <?= e($evento['ubicacion']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <button class="events-prev" id="events-prev-btn" onclick="window.moveEventsPrev()"><i class="fas fa-chevron-left"></i></button>
            <button class="events-next" id="events-next-btn" onclick="window.moveEventsNext()"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Accesos Rápidos -->
<section class="section accesos-rapidos bg-primary">
    <div class="container">
        <div class="accesos-grid">
            <a href="<?= url('/admision') ?>" class="acceso-card">
                <i class="fas fa-user-graduate"></i>
                <h3>Admisión 2026</h3>
                <p>Conoce el proceso de admisión</p>
            </a>
            <a href="<?= url('/tupa') ?>" class="acceso-card">
                <i class="fas fa-file-alt"></i>
                <h3>Trámites</h3>
                <p>Consulta el TUPA</p>
            </a>
            <a href="<?= url('/libro-reclamaciones') ?>" class="acceso-card">
                <i class="fas fa-book"></i>
                <h3>Libro de Reclamaciones</h3>
                <p>Presenta tu reclamo</p>
            </a>
            <a href="<?= url('/contacto') ?>" class="acceso-card">
                <i class="fas fa-envelope"></i>
                <h3>Contacto</h3>
                <p>Comunícate con nosotros</p>
            </a>
        </div>
    </div>
</section>

<!-- Enlaces Destacados -->
<?php if (!empty($enlaces)): ?>
<section class="section enlaces-section">
    <div class="container">
        <div class="section-header text-center">
            <h2>Enlaces Destacados</h2>
            <p>Explora una selección de recursos y sitios destacados para ti</p>
        </div>
        
        <div class="enlaces-slider-container" id="enlaces-slider">
            <div class="enlaces-track">
                <?php foreach ($enlaces as $enlace): ?>
                <div class="enlace-slide">
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
        </div>
    </div>
</section>
<?php endif; ?>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php';
?>
