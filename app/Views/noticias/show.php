<?php ob_start(); ?>

<article class="single-noticia">
    <?php if (isset($noticia['tipo_encabezado']) && $noticia['tipo_encabezado'] === 'video' && !empty($noticia['video_encabezado'])): 
        $originalUrl = $noticia['video_encabezado'];
        $videoUrl = getEmbedUrl($originalUrl);
        
        $isYoutube = (strpos($videoUrl, 'youtube') !== false);
        $isVimeo = (strpos($videoUrl, 'vimeo') !== false);
        $isIframe = ($isYoutube || $isVimeo);

        // Construct Autoplay Source
        $iframeSrc = $videoUrl;
        if ($isYoutube) {
            // Extract ID from embed URL (cleanup existing params)
            $parts = explode('?', $videoUrl);
            $baseUrl = $parts[0]; 
            $id = basename($baseUrl);
            $iframeSrc = $baseUrl . "?autoplay=1&mute=1&controls=0&loop=1&playlist=" . $id . "&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1";
        } elseif ($isVimeo) {
             // Vimeo background mode
             $iframeSrc = $videoUrl . "?background=1&autoplay=1&loop=1&byline=0&title=0&muted=1";
        }
    ?>
    <div class="noticia-hero" style="height: 480px; position: relative; overflow: hidden; background: #000;">
        <?php if ($isIframe): ?>
            <iframe src="<?= $iframeSrc ?>" frameborder="0" style="position: absolute; top: 50%; left: 50%; width: 100vw; height: 100vh; transform: translate(-50%, -50%); pointer-events: none; opacity: 0.6;" allow="autoplay; encrypted-media"></iframe>
        <?php else: ?>
            <video autoplay muted loop playsinline style="position: absolute; top: 50%; left: 50%; min-width: 100%; min-height: 100%; width: auto; height: auto; z-index: 1; transform: translateX(-50%) translateY(-50%); opacity: 0.6; object-fit: cover;">
                <source src="<?= e($noticia['video_encabezado']) ?>" type="video/mp4">
            </video>
        <?php endif; ?>

        <div class="overlay" style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.5); z-index: 2;"></div>
        <div class="container" style="position: relative; z-index: 3; height: 100%; display: flex; flex-direction: column; justify-content: flex-end; padding-bottom: 60px; color: white;">
            <span class="badge" style="background: var(--color-primary); display: inline-block; padding: 6px 16px; border-radius: 4px; margin-bottom: 12px; font-weight: 600; letter-spacing: 0.5px;"><?= e(ucfirst($noticia['categoria'])) ?></span>
            <h1 style="font-size: 3rem; font-weight: 800; line-height: 1.2; text-shadow: 0 4px 6px rgba(0,0,0,0.6); max-width: 900px;"><?= e($noticia['titulo']) ?></h1>
            <div class="meta" style="margin-top: 15px; font-size: 1.1rem; opacity: 0.9;">
                <span><i class="far fa-calendar-alt mr-2"></i> <?= formatDate($noticia['fecha_publicacion']) ?></span>
                <span style="margin-left: 25px;"><i class="far fa-user mr-2"></i> <?= e($noticia['autor_nombre']) ?></span>
            </div>
        </div>
    </div>
    <?php elseif ($noticia['imagen']): ?>
    <div class="noticia-hero" style="background-image: url('<?= url('uploads/noticias/' . e($noticia['imagen'])) ?>'); height: 480px; background-size: cover; background-position: center; position: relative;">
        <div class="overlay" style="position: absolute; top:0; left:0; right:0; bottom:0; background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.3) 100%);"></div>
        <div class="container" style="position: relative; z-index: 2; height: 100%; display: flex; flex-direction: column; justify-content: flex-end; padding-bottom: 60px; color: white;">
            <span class="badge" style="background: var(--color-primary); display: inline-block; padding: 6px 16px; border-radius: 4px; margin-bottom: 12px; font-weight: 600; letter-spacing: 0.5px;"><?= e(ucfirst($noticia['categoria'])) ?></span>
            <h1 style="font-size: 3rem; font-weight: 800; line-height: 1.2; text-shadow: 0 4px 6px rgba(0,0,0,0.6); max-width: 900px;"><?= e($noticia['titulo']) ?></h1>
            <div class="meta" style="margin-top: 15px; font-size: 1.1rem; opacity: 0.9;">
                <span><i class="far fa-calendar-alt mr-2"></i> <?= formatDate($noticia['fecha_publicacion']) ?></span>
                <span style="margin-left: 25px;"><i class="far fa-user mr-2"></i> <?= e($noticia['autor_nombre']) ?></span>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="container section">
        <h1><?= e($noticia['titulo']) ?></h1>
    </div>
    <?php endif; ?>

    <div class="container section">
        <div class="row">
            <div class="col-lg-8" style="margin: 0 auto; max-width: 800px;">
                <div class="noticia-body content-typography">
                    <?= $noticia['contenido'] ?>
                </div>
            </div>
        </div>
    </div>
</article>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php';
?>
