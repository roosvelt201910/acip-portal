<?php ob_start(); ?>

<style>
    :root {
        --primary-color: #ef4444; /* Red color from the image */
        --primary-dark: #b91c1c;
        --text-dark: #1f2937;
        --text-gray: #6b7280;
        --bg-light: #f9fafb;
        --border-color: #e5e7eb;
        --radius: 12px;
    }

    .program-header {
        position: relative;
        background: #1e3a8a; /* Dark blue header */
        color: white;
        padding: 60px 0;
        margin-bottom: 40px;
    }

    .program-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .program-container {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 40px;
        margin-bottom: 60px;
        align-items: start;
    }

    /* Left Sidebar */
    .sidebar-section h2 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 10px;
        position: relative;
    }

    .sidebar-section h2::after {
        content: '';
        display: block;
        width: 60px;
        height: 4px;
        background: var(--primary-color);
        margin-top: 8px;
    }

    .program-intro {
        color: var(--text-gray);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    /* Tabs Navigation */
    .program-tabs {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .tab-btn {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 16px 20px;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        color: var(--text-dark);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: left;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .tab-btn:hover {
        transform: translateX(5px);
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .tab-btn.active {
        border-left: 5px solid var(--primary-color);
        background: white;
        color: var(--text-dark);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .tab-btn i {
        font-size: 1.25rem;
        color: var(--primary-color);
        width: 24px;
        text-align: center;
    }

    /* Right Content */
    .content-area {
        background: white;
        border-radius: var(--radius);
    }

    /* Video Hero */
    .video-hero {
        width: 100%;
        border-radius: var(--radius);
        overflow: hidden;
        margin-bottom: 30px;
        background: #000;
        aspect-ratio: 16/9;
        position: relative;
    }

    .video-hero iframe, .video-hero video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Tab Content */
    .tab-pane {
        display: none;
        animation: fadeIn 0.4s ease;
        background: white;
        padding: 30px;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .tab-pane.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .pane-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 12px;
        border-bottom: 3px solid var(--primary-color);
        display: inline-block;
    }

    .pane-content {
        color: var(--text-gray);
        line-height: 1.7;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .program-container {
            grid-template-columns: 1fr;
        }
        
        .sidebar-section {
            order: 2;
        }
        
        .content-area {
            order: 1;
        }

        .video-hero {
            margin-bottom: 40px;
        }
    }
    /* Gallery Styles */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }

    .gallery-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        aspect-ratio: 4/3;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .gallery-item:hover {
        transform: scale(1.03);
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        z-index: 10000;
        align-items: center;
        justify-content: center;
    }

    .lightbox.active {
        display: flex;
    }

    .lightbox-img {
        max-width: 90%;
        max-height: 90vh;
        object-fit: contain;
        border-radius: 4px;
    }

    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        background: none;
        border: none;
    }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        font-size: 2rem;
        cursor: pointer;
        background: rgba(255,255,255,0.1);
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s;
    }

    .lightbox-nav:hover {
        background: rgba(255,255,255,0.3);
    }

    .lightbox-prev { left: 20px; }
    .lightbox-next { right: 20px; }

    /* Partners Slider */
    .partners-wrapper {
        position: relative;
        overflow: hidden;
        padding: 20px 40px;
    }

    .partners-slider {
        display: flex;
        gap: 20px;
        transition: transform 0.5s ease;
    }

    .partner-slide {
        flex: 0 0 180px;
        background: white;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 120px;
    }

    .partner-slide img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        filter: grayscale(100%);
        transition: filter 0.3s;
    }

    .partner-slide:hover img {
        filter: grayscale(0%);
    }

    .partners-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: white;
        border: 1px solid #ddd;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .partners-prev { left: 0; }
    .partners-next { right: 0; }
</style>

<?php 
// Determine hero media
$heroMediaType = $programa['hero_media_type'] ?? 'image';
$hasHeroMedia = !empty($programa['hero_image']) || !empty($programa['video_hero']) || !empty($programa['hero_youtube_url']) || !empty($programa['imagen']);
?>

<?php if ($hasHeroMedia): ?>
<!-- Hero Section with Media -->
<div class="program-hero" style="position: relative; min-height: 500px; overflow: hidden; background: linear-gradient(135deg, var(--primary-color) 0%, #6b1028 100%); margin-bottom: 60px;">
    <?php if ($heroMediaType === 'youtube' && !empty($programa['hero_youtube_url'])): ?>
        <?php 
        // YouTube video for hero
        $youtubeUrl = $programa['hero_youtube_url'];
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $youtubeUrl, $matches);
        if (isset($matches[1])):
            $embedUrl = 'https://www.youtube.com/embed/' . $matches[1] . '?autoplay=1&mute=1&loop=1&playlist=' . $matches[1] . '&controls=0&showinfo=0&rel=0&modestbranding=1';
        ?>
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
                <iframe src="<?= $embedUrl ?>" style="position: absolute; top: 50%; left: 50%; width: 100vw; height: 100vh; transform: translate(-50%, -50%); pointer-events: none;" frameborder="0" allow="autoplay; encrypted-media"></iframe>
            </div>
        <?php endif; ?>
    <?php elseif ($heroMediaType === 'video' && !empty($programa['video_hero'])): ?>
        <?php 
        $videoHero = $programa['video_hero'];
        $isYouTube = (strpos($videoHero, 'youtube.com') !== false || strpos($videoHero, 'youtu.be') !== false);
        
        if ($isYouTube):
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoHero, $matches);
            if (isset($matches[1])):
                $embedUrl = 'https://www.youtube.com/embed/' . $matches[1] . '?autoplay=1&mute=1&loop=1&playlist=' . $matches[1] . '&controls=0&showinfo=0&rel=0&modestbranding=1';
        ?>
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
                <iframe src="<?= $embedUrl ?>" style="position: absolute; top: 50%; left: 50%; width: 100vw; height: 100vh; transform: translate(-50%, -50%); pointer-events: none;" frameborder="0" allow="autoplay; encrypted-media"></iframe>
            </div>
        <?php 
            endif;
        else:
        ?>
            <video autoplay loop muted playsinline style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1;">
                <source src="<?= url($videoHero) ?>" type="video/mp4">
            </video>
        <?php endif; ?>
    <?php elseif ($heroMediaType === 'image' && !empty($programa['hero_image'])): ?>
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('<?= url($programa['hero_image']) ?>'); background-size: cover; background-position: center; z-index: 1;"></div>
    <?php elseif (!empty($programa['imagen'])): ?>
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('<?= url($programa['imagen']) ?>'); background-size: contain; background-position: left center; background-repeat: no-repeat; z-index: 1;"></div>
    <?php endif; ?>
    
    <!-- Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 2;"></div>
    
    <!-- Content -->
    <div class="container" style="position: relative; z-index: 3; padding: 150px 0; color: white;">
        <h1 style="font-size: 3.5rem; font-weight: 700; text-shadow: 2px 2px 8px rgba(0,0,0,0.4); margin: 0; line-height: 1.2;"><?= e($programa['nombre']) ?></h1>
        <p style="color: rgba(255,255,255,0.95); font-size: 1.3rem; margin-top: 20px; text-shadow: 1px 1px 3px rgba(0,0,0,0.3); font-weight: 300;">
            <i class="fas fa-graduation-cap"></i> <?= e(ucfirst($programa['modalidad'])) ?> • <i class="far fa-clock"></i> <?= e($programa['duracion_semestres']) ?> semestres
        </p>
    </div>
</div>
<?php else: ?>
<!-- Fallback Hero without Media -->
<div class="program-hero" style="position: relative; padding: 100px 0; background: #1e3a8a; color: white; margin-bottom: 60px;">
    <div class="container" style="position: relative; z-index: 3;">
        <h1 style="font-size: 3rem; font-weight: 700; margin: 0;"><?= e($programa['nombre']) ?></h1>
        <p style="font-size: 1.2rem; margin-top: 15px; opacity: 0.9;">
            <i class="fas fa-graduation-cap"></i> <?= e(ucfirst($programa['modalidad'])) ?> • <i class="far fa-clock"></i> <?= e($programa['duracion_semestres']) ?> semestres
        </p>
    </div>
</div>
<?php endif; ?>

<div class="container">
    <!-- Intro & Video Section -->
    <div class="row" style="display: flex; flex-wrap: wrap; gap: 40px; margin-bottom: 50px; align-items: flex-start;">
        <!-- Intro Text -->
        <div style="flex: 1; min-width: 300px;">
            <div style="position: relative; margin-bottom: 25px;">
                <h2 style="font-size: 2rem; font-weight: 800; color: #1e3a8a; margin: 0;">Estudia con nosotros</h2>
                <div style="width: 80px; height: 4px; background: var(--primary-color); margin-top: 10px;"></div>
            </div>
            <div class="program-intro" style="color: #4b5563; line-height: 1.8; font-size: 1.05rem;">
                <?= $programa['descripcion'] ?>
            </div>
        </div>
        
        <!-- Promotional Content -->
        <div style="flex: 1; min-width: 300px;">
            <div class="video-hero" style="box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); border-radius: 12px; overflow: hidden; margin: 0;">
                <?php 
                $promoType = $programa['promo_media_type'] ?? 'youtube';
                
                if ($promoType === 'image' && !empty($programa['promo_image'])): 
                ?>
                    <img src="<?= url($programa['promo_image']) ?>" alt="<?= e($programa['nombre']) ?>" style="width: 100%; height: auto; display: block;">
                
                <?php elseif ($promoType === 'youtube' && !empty($programa['promo_youtube_url'])): 
                    $youtubeUrl = $programa['promo_youtube_url'];
                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $youtubeUrl, $matches);
                    if (isset($matches[1])):
                        $embedUrl = 'https://www.youtube.com/embed/' . $matches[1] . '?autoplay=0&controls=1&rel=0&modestbranding=1';
                ?>
                    <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                        <iframe src="<?= $embedUrl ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                <?php 
                    endif;
                elseif (!empty($programa['imagen'])): 
                ?>
                     <img src="<?= url($programa['imagen']) ?>" alt="<?= e($programa['nombre']) ?>" style="width: 100%; height: auto; display: block;">
                <?php else: ?>
                    <div style="background: #000; color: white; display: flex; align-items: center; justify-content: center; aspect-ratio: 16/9; flex-direction: column;">
                         <i class="fas fa-play-circle" style="font-size: 4rem; margin-bottom: 20px;"></i>
                         <h3>Contenido Promocional</h3>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Divider -->
    <div style="width: 100%; height: 2px; background: var(--primary-color); margin-bottom: 50px; opacity: 0.6;"></div>

    <div class="program-container">
        <!-- Sidebar Navigation -->
        <div class="sidebar-section">
            <div class="program-tabs">
                <button class="tab-btn active" onclick="openTab(event, 'perfil')">
                    <i class="fas fa-user-graduate"></i> Perfil de Egreso
                </button>
                
                <?php if (!empty($programa['ambito_laboral'])): ?>
                <button class="tab-btn" onclick="openTab(event, 'ambito')">
                    <i class="fas fa-briefcase"></i> Ámbito Laboral
                </button>
                <?php endif; ?>

                <?php if (!empty($programa['certificaciones'])): ?>
                <button class="tab-btn" onclick="openTab(event, 'certificaciones')">
                    <i class="fas fa-certificate"></i> Certificaciones
                </button>
                <?php endif; ?>

                <?php if (!empty($programa['plan_estudios'])): ?>
                <button class="tab-btn" onclick="openTab(event, 'plan')">
                    <i class="fas fa-book-open"></i> Plan de Estudio
                </button>
                <?php endif; ?>

                <?php if (!empty($programa['horario_clases'])): ?>
                <button class="tab-btn" onclick="openTab(event, 'horario')">
                    <i class="fas fa-clock"></i> Horario de Clases
                </button>
                <?php endif; ?>

                <?php if (!empty($programa['oficio_autorizacion'])): ?>
                <button class="tab-btn" onclick="openTab(event, 'oficio')">
                    <i class="fas fa-file-contract"></i> Of. Autorización
                </button>
                <?php endif; ?>

                <?php if (!empty($programa['matricula_info'])): ?>
                <button class="tab-btn" onclick="openTab(event, 'matricula')">
                    <i class="fas fa-calendar-alt"></i> Matrícula 2026
                </button>
                <?php endif; ?>

                <?php if (!empty($programa['efsrt'])): ?>
                <button class="tab-btn" onclick="openTab(event, 'efsrt')">
                    <i class="fas fa-handshake"></i> EFSRT Convenios
                </button>
                <?php endif; ?>
            </div>
            
            <!-- Contact Box for Sidebar -->
             <div style="margin-top: 30px; background: #1e3a8a; padding: 25px; border-radius: 12px; color: white;">
                <h3 style="margin-bottom: 15px; font-size: 1.2rem;">¿Más información?</h3>
                <p style="font-size: 0.9rem; margin-bottom: 20px; opacity: 0.9;">Nuestro equipo de admisión está listo para ayudarte con todas tus dudas.</p>
                <a href="<?= url('contacto') ?>" class="btn btn-primary btn-block" style="background: var(--primary-color); border: none;">Contáctanos</a>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="content-area">
            
            <!-- Tab Contents -->
            <div id="perfil" class="tab-pane active">
                <h3 class="pane-title">Perfil de Egreso</h3>
                <div class="pane-content">
                    <?= !empty($programa['perfil_egresado']) ? $programa['perfil_egresado'] : '<p>Información no disponible.</p>' ?>
                </div>
            </div>

            <div id="ambito" class="tab-pane">
                <h3 class="pane-title">Ámbito Laboral</h3>
                <div class="pane-content">
                    <?= $programa['ambito_laboral'] ?>
                </div>
            </div>

            <div id="certificaciones" class="tab-pane">
                <h3 class="pane-title">Certificaciones</h3>
                <div class="pane-content">
                    <?= $programa['certificaciones'] ?>
                </div>
            </div>

            <div id="plan" class="tab-pane">
                <h3 class="pane-title">Plan de Estudios</h3>
                <div class="pane-content">
                    <?= $programa['plan_estudios'] ?>
                </div>
            </div>

            <div id="horario" class="tab-pane">
                <h3 class="pane-title">Horario de Clases</h3>
                <div class="pane-content">
                    <?= $programa['horario_clases'] ?>
                </div>
            </div>

            <div id="oficio" class="tab-pane">
                <h3 class="pane-title">Oficio de Autorización</h3>
                <div class="pane-content">
                    <?= $programa['oficio_autorizacion'] ?>
                </div>
            </div>

             <div id="matricula" class="tab-pane">
                <h3 class="pane-title">Información de Matrícula</h3>
                <div class="pane-content">
                    <?= $programa['matricula_info'] ?>
                </div>
            </div>

            <div id="efsrt" class="tab-pane">
                <h3 class="pane-title">EFSRT y Convenios</h3>
                <div class="pane-content">
                    <?= $programa['efsrt'] ?>
                </div>
            </div>



        </div>
    </div>
</div>

<?php if (!empty($galeria)): ?>
<div class="container" style="margin-bottom: 60px;">
    <!-- Divider -->
    <div style="width: 100%; height: 1px; background: #e5e7eb; margin-bottom: 40px;"></div>
    
    <div style="position: relative; margin-bottom: 30px;">
        <h2 style="font-size: 1.8rem; font-weight: 800; color: var(--text-dark); display: inline-block;">Galería de Fotos</h2>
        <div style="width: 60px; height: 4px; background: var(--primary-color); margin-top: 8px;"></div>
    </div>
    
    <div class="gallery-grid">
        <?php foreach($galeria as $index => $foto): ?>
        <div class="gallery-item" onclick="openLightbox(<?= $index ?>)">
            <img src="<?= url($foto['imagen_path']) ?>" alt="Galería">
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php if (!empty($aliados)): ?>
<div class="container" style="margin-bottom: 60px;">
    <!-- Divider -->
    <div style="width: 100%; height: 1px; background: #e5e7eb; margin-bottom: 40px;"></div>

    <div style="position: relative; margin-bottom: 30px;">
        <h2 style="font-size: 1.8rem; font-weight: 800; color: var(--text-dark); display: inline-block;">Aliados Estratégicos</h2>
        <div style="width: 60px; height: 4px; background: var(--primary-color); margin-top: 8px;"></div>
    </div>

    <div class="partners-wrapper" style="background: white; border-radius: var(--radius); border: 1px solid var(--border-color); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <button class="partners-nav partners-prev" onclick="movePartners(-1)"><i class="fas fa-chevron-left"></i></button>
        <button class="partners-nav partners-next" onclick="movePartners(1)"><i class="fas fa-chevron-right"></i></button>
        
        <div class="partners-slider" id="partners-slider">
            <?php foreach($aliados as $aliado): ?>
            <div class="partner-slide">
                <img src="<?= url($aliado['imagen_path']) ?>" alt="Aliado">
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function openTab(evt, tabName) {
    var i, tabPane, tabBtn;
    
    // Hide all tab panes
    tabPane = document.getElementsByClassName("tab-pane");
    for (i = 0; i < tabPane.length; i++) {
        tabPane[i].style.display = "none";
        tabPane[i].classList.remove("active");
    }
    
    // Remove active class from all buttons
    tabBtn = document.getElementsByClassName("tab-btn");
    for (i = 0; i < tabBtn.length; i++) {
        tabBtn[i].className = tabBtn[i].className.replace(" active", "");
    }
    
    // Show the current tab and add active class to button
    document.getElementById(tabName).style.display = "block";
    
    // Small delay to allow fade animation to restart if we want
    setTimeout(() => {
         document.getElementById(tabName).classList.add("active");
    }, 10);
   
    evt.currentTarget.className += " active";
}

// Lightbox Logic
const galleryImages = [
    <?php if(!empty($galeria)) foreach($galeria as $foto): ?>
    "<?= url($foto['imagen_path']) ?>",
    <?php endforeach; ?>
];
let currentImageIndex = 0;

function openLightbox(index) {
    if(galleryImages.length === 0) return;
    currentImageIndex = index;
    const lightbox = document.getElementById('lightbox');
    const img = document.getElementById('lightbox-img');
    
    img.src = galleryImages[currentImageIndex];
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('active');
    document.body.style.overflow = 'auto';
}

function changeLightboxImage(direction) {
    currentImageIndex += direction;
    if (currentImageIndex < 0) currentImageIndex = galleryImages.length - 1;
    if (currentImageIndex >= galleryImages.length) currentImageIndex = 0;
    
    document.getElementById('lightbox-img').src = galleryImages[currentImageIndex];
}

// Partners Slider Logic
let partnersPosition = 0;
const slideWidth = 200; // 180 + 20 gap
// Initialize slider
document.addEventListener('DOMContentLoaded', function() {
    // Lightbox events
    const lightbox = document.getElementById('lightbox');
    if(lightbox) {
        lightbox.addEventListener('click', function(e) {
            if (e.target === this) closeLightbox();
        });
        
        document.addEventListener('keydown', function(e) {
            if (lightbox.classList.contains('active')) {
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') changeLightboxImage(-1);
                if (e.key === 'ArrowRight') changeLightboxImage(1);
            }
        });
    }
});

function movePartners(direction) {
    const slider = document.getElementById('partners-slider');
    if(!slider) return;
    
    const maxSlidesVisible = Math.floor(slider.parentElement.offsetWidth / slideWidth);
    const totalSlides = slider.children.length;
    const maxPosition = totalSlides - maxSlidesVisible;
    
    partnersPosition += direction;
    
    if (partnersPosition < 0) partnersPosition = 0;
    if (partnersPosition > maxPosition && maxPosition > 0) partnersPosition = maxPosition;
    
    slider.style.transform = `translateX(-${partnersPosition * slideWidth}px)`;
}
</script>

<!-- Lightbox Markup -->
<div id="lightbox" class="lightbox">
    <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
    <button class="lightbox-nav lightbox-prev" onclick="changeLightboxImage(-1)"><i class="fas fa-chevron-left"></i></button>
    <img id="lightbox-img" class="lightbox-img" src="" alt="Full view">
    <button class="lightbox-nav lightbox-next" onclick="changeLightboxImage(1)"><i class="fas fa-chevron-right"></i></button>
</div>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php';
?>
