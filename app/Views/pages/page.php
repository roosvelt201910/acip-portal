<?php ob_start(); ?>

<!-- Page Hero -->
<?php 
    $heroStyle = "background: linear-gradient(135deg, var(--primary), var(--secondary));"; // Default
    $hasVideo = ($page['media_type'] ?? 'image') === 'video' && !empty($page['video_url']);
    $hasImage = !empty($page['imagen_destacada']);

    if (!$hasVideo && $hasImage) {
        $imageUrl = url($page['imagen_destacada']);
        // Linear gradient overlay + image
        $heroStyle = "background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('{$imageUrl}') no-repeat center center / cover;";
    }
?>

<section class="page-hero" style="position: relative; overflow: hidden; color: white; display: flex; align-items: flex-end; min-height: 500px; <?= !$hasVideo ? $heroStyle : '' ?>">
    
    <!-- Render Video Background if Enabled -->
    <?php if ($hasVideo): ?>
        <?php 
            // Simple logic to extract ID from YouTube URL (Standard or Short)
            $videoUrl = $page['video_url'];
            $embedUrl = $videoUrl; // Default fallback
            
            if (strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false) {
                 // It's YouTube
                 // Use simple regex or parser. For now, assume embedding instructions.
                 // Actually, best to use an iframe overlay.
                 // To make it "Slider/Background" like, we usually use an absolute positioned iframe.
                 if (preg_match('/(?:v=|\/)([\w-]{11})(?:&|\?|\/|$)/', $videoUrl, $matches)) {
                     $videoId = $matches[1];
                     // Autoplay, Mute, Loop, Controls=0
                     $embedUrl = "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=1&controls=0&loop=1&playlist={$videoId}&showinfo=0&rel=0";
                 }
            }
        ?>
        <div class="video-background" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none;">
            <!-- Increased scale to prevent black bars if aspect ratio differs -->
            <iframe src="<?= $embedUrl ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width: 100vw; height: 100vh; transform: scale(1.5); pointer-events: none;"></iframe>
        </div>
        <!-- Overlay to ensure text readability -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.6)); z-index: 2;"></div>
    <?php endif; ?>

    <div class="container" style="position: relative; z-index: 3; padding-top: 60px; padding-bottom: 60px; width: 100%; text-align: left;">
        <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 5px; letter-spacing: -1px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);"><?= e($page['titulo']) ?></h1>
        <nav aria-label="breadcrumb" style="
            display: inline-flex; 
            align-items: center; 
            gap: 10px;
            background: rgba(255, 255, 255, 0.1); 
            backdrop-filter: blur(5px); 
            padding: 8px 16px; 
            border-radius: 50px; 
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.85rem; 
            font-weight: 600; 
            text-transform: uppercase; 
            letter-spacing: 1px;
            margin-bottom: 2rem;
        ">
            <a href="<?= url('/') ?>" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: all 0.2s; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-home" style="font-size: 0.9em;"></i> INICIO
            </a>
            <span style="color: rgba(255,255,255,0.4); font-size: 0.8em;"><i class="fas fa-chevron-right"></i></span>
            <span style="color: #fbbf24; text-shadow: 0 0 10px rgba(251, 191, 36, 0.3);"><?= e($page['titulo']) ?></span>
        </nav>
        <?php if (!empty($page['subtitulo'] ?? '')): ?>
            <p class="lead" style="opacity: 0.95; font-size: 1.5rem; font-weight: 300; max-width: 800px; text-shadow: 0 1px 2px rgba(0,0,0,0.3);"><?= e($page['subtitulo']) ?></p>
        <?php endif; ?>
    </div>
</section>

<!-- Page Content -->
<section class="section page-content">
    <div class="container">
        <div class="card" style="padding: 40px; border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-radius: 16px;">
            <div class="content-body text-gray-700 leading-relaxed">
                <?= $page['contenido'] ?>
            </div>
            

        </div>

        <?php if (!empty($documentos)): ?>
        <!-- Group documents by category/type for better organization -->
        <?php 
            $docsByCategory = [];
            foreach ($documentos as $doc) {
                $category = $doc['tipo_documento'] ?? 'general';
                if (!isset($docsByCategory[$category])) {
                    $docsByCategory[$category] = [];
                }
                $docsByCategory[$category][] = $doc;
            }
        ?>
        
        <div class="documents-section" style="margin-top: 3rem;">
            <!-- Section Header -->
            <div class="section-header animate-gradient" style="
                background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
                padding: 3rem;
                border-radius: 20px;
                margin-bottom: 2rem;
                position: relative;
                overflow: hidden;
                box-shadow: 0 20px 40px rgba(30, 64, 175, 0.15);
            ">
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.1; background: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M0 0h60v60H0z\" fill=\"none\"/%3E%3Cpath d=\"M30 0L45 15H30zM0 30L15 45V30z\" fill=\"%23fff\"/%3E%3C/svg%3E') repeat;"></div>
                
                <div style="position: relative; z-index: 2;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                        <div style="
                            width: 60px;
                            height: 60px;
                            background: rgba(255, 255, 255, 0.15);
                            backdrop-filter: blur(10px);
                            border-radius: 16px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            border: 2px solid rgba(255, 255, 255, 0.2);
                        ">
                            <i class="fas fa-folder-open" style="font-size: 28px; color: white;"></i>
                        </div>
                        <div>
                            <h2 style="margin: 0; color: white; font-size: 2rem; font-weight: 800; letter-spacing: -0.5px;">
                                <?= e($documentos[0]['categoria_nombre'] ?? 'Documentos') ?>
                            </h2>
                            <p style="margin: 0; color: rgba(255, 255, 255, 0.9); font-size: 0.95rem; font-weight: 500;">
                                <?= count($documentos) ?> documento<?= count($documentos) != 1 ? 's' : '' ?> disponible<?= count($documentos) != 1 ? 's' : '' ?> para descarga
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents by Category -->
            <?php foreach ($docsByCategory as $categoryName => $categoryDocs): ?>
                <?php if (count($docsByCategory) > 1): // Only show category titles if there's more than one category ?>
                <div class="category-section" style="margin-bottom: 2.5rem;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem;">
                        <div style="flex: 1; height: 2px; background: linear-gradient(to right, #e2e8f0, transparent);"></div>
                        <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #475569; text-transform: capitalize; letter-spacing: 0.5px;">
                            <i class="fas fa-tag" style="color: #1e40af; margin-right: 8px;"></i>
                            <?= e(str_replace('_', ' ', $categoryName)) ?>
                        </h3>
                        <div style="flex: 1; height: 2px; background: linear-gradient(to left, #e2e8f0, transparent);"></div>
                    </div>
                <?php endif; ?>
                    
                    <div class="documents-grid" style="
                        display: grid; 
                        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); 
                        gap: 1.5rem;
                    ">
                        <?php foreach ($categoryDocs as $doc): ?>
                            <?php
                                $ext = strtolower($doc['extension']);
                                $typeConfig = [
                                    'pdf' => ['color' => '#ef4444', 'icon' => 'fa-book-open', 'bgGradient' => 'linear-gradient(135deg, #fee2e2, #fecaca)', 'label' => 'PDF'],
                                    'doc' => ['color' => '#3b82f6', 'icon' => 'fa-file-word', 'bgGradient' => 'linear-gradient(135deg, #dbeafe, #bfdbfe)', 'label' => 'Word'],
                                    'docx' => ['color' => '#3b82f6', 'icon' => 'fa-file-word', 'bgGradient' => 'linear-gradient(135deg, #dbeafe, #bfdbfe)', 'label' => 'Word'],
                                    'xls' => ['color' => '#10b981', 'icon' => 'fa-file-excel', 'bgGradient' => 'linear-gradient(135deg, #d1fae5, #a7f3d0)', 'label' => 'Excel'],
                                    'xlsx' => ['color' => '#10b981', 'icon' => 'fa-file-excel', 'bgGradient' => 'linear-gradient(135deg, #d1fae5, #a7f3d0)', 'label' => 'Excel'],
                                    'ppt' => ['color' => '#f59e0b', 'icon' => 'fa-file-powerpoint', 'bgGradient' => 'linear-gradient(135deg, #fed7aa, #fdba74)', 'label' => 'PPT'],
                                    'pptx' => ['color' => '#f59e0b', 'icon' => 'fa-file-powerpoint', 'bgGradient' => 'linear-gradient(135deg, #fed7aa, #fdba74)', 'label' => 'PPT'],
                                    'zip' => ['color' => '#8b5cf6', 'icon' => 'fa-file-archive', 'bgGradient' => 'linear-gradient(135deg, #ede9fe, #ddd6fe)', 'label' => 'ZIP'],
                                    'rar' => ['color' => '#8b5cf6', 'icon' => 'fa-file-archive', 'bgGradient' => 'linear-gradient(135deg, #ede9fe, #ddd6fe)', 'label' => 'RAR'],
                                    'default' => ['color' => '#64748b', 'icon' => 'fa-file', 'bgGradient' => 'linear-gradient(135deg, #f1f5f9, #e2e8f0)', 'label' => strtoupper($ext)]
                                ];
                                $config = $typeConfig[$ext] ?? $typeConfig['default'];
                            ?>
                            
                            <div class="doc-wrapper" style="
                                display: flex;
                                gap: 1.5rem;
                                align-items: flex-start;
                                transition: all 0.3s ease;
                                cursor: default;
                            " data-wrapper-id="wrapper-doc-<?= $doc['id'] ?>">
                                
                                <!-- Document Card (Left Side) -->
                                <div class="modern-doc-card" 
                                   data-doc-type="<?= $ext ?>"
                                   data-doc-id="doc-<?= $doc['id'] ?>"
                                   style="
                                       flex: 0 0 350px;
                                       text-decoration: none;
                                       background: white;
                                       border: 2px solid #f1f5f9;
                                       border-radius: 16px;
                                       padding: 1.5rem;
                                       transition: all 0.3s ease;
                                       position: relative;
                                       overflow: hidden;
                                   ">
                                   
                                   <!-- Card Overlay -->
                                   <div class="card-overlay" style="
                                       position: absolute;
                                       top: 0;
                                       left: 0;
                                       right: 0;
                                       bottom: 0;
                                       background: linear-gradient(135deg, rgba(30, 64, 175, 0.05), rgba(59, 130, 246, 0.05));
                                       opacity: 0;
                                       transition: opacity 0.3s ease;
                                       pointer-events: none;
                                   "></div>

                                    <div style="position: relative; z-index: 1; display: flex; flex-direction: column; height: 100%;">
                                        
                                        <!-- Centered Content -->
                                        <div style="text-align: center; flex: 1; padding-bottom: 1rem;">
                                            <!-- Large Centered Icon -->
                                            <div style="
                                                width: 90px;
                                                height: 90px;
                                                border-radius: 20px;
                                                background: <?= $config['bgGradient'] ?>;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                margin: 0 auto 1.5rem auto;
                                                box-shadow: 0 10px 20px -5px <?= $config['color'] ?>30;
                                            ">
                                                <i class="fas <?= $config['icon'] ?>" style="
                                                    font-size: 2.8rem;
                                                    color: <?= $config['color'] ?>;
                                                "></i>
                                            </div>

                                            <!-- Title -->
                                            <h4 style="
                                                margin: 0 0 0.75rem 0;
                                                font-size: 1.15rem;
                                                font-weight: 700;
                                                color: #1e293b;
                                                line-height: 1.4;
                                                display: -webkit-box;
                                                -webkit-line-clamp: 2;
                                                -webkit-box-orient: vertical;
                                                overflow: hidden;
                                            " title="<?= e($doc['titulo']) ?>">
                                                <?= e($doc['titulo']) ?>
                                            </h4>
                                            
                                            <?php if (!empty($doc['descripcion'])): ?>
                                            <p style="
                                                margin: 0;
                                                font-size: 0.9rem;
                                                color: #64748b;
                                                line-height: 1.5;
                                                display: -webkit-box;
                                                -webkit-line-clamp: 2;
                                                -webkit-box-orient: vertical;
                                                overflow: hidden;
                                            ">
                                                <?= e($doc['descripcion']) ?>
                                            </p>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Footer Info (Format & Size) -->
                                        <div style="
                                            display: flex;
                                            align-items: center;
                                            justify-content: space-between;
                                            padding-top: 1rem;
                                            border-top: 1px solid #f1f5f9;
                                            margin-bottom: 1rem;
                                        ">
                                            <!-- Format Badge -->
                                            <div style="
                                                background: <?= $config['color'] ?>15;
                                                color: <?= $config['color'] ?>;
                                                padding: 6px 14px;
                                                border-radius: 8px;
                                                font-size: 0.75rem;
                                                font-weight: 700;
                                                text-transform: uppercase;
                                                letter-spacing: 0.5px;
                                            ">
                                                <?= $config['label'] ?>
                                            </div>

                                            <!-- Size -->
                                            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #64748b;">
                                                <i class="fas fa-weight-hanging" style="font-size: 0.8rem; opacity: 0.7;"></i>
                                                <span style="font-weight: 600;"><?= formatFileSize($doc['tamanio']) ?></span>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div style="display: flex; gap: 10px;">
                                            <button onclick="togglePDFViewer('doc-<?= $doc['id'] ?>', '<?= url('uploads/documentos/' . $doc['archivo']) ?>', '<?= e($doc['titulo']) ?>')" class="view-doc-btn" style="
                                                flex: 1;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                gap: 8px;
                                                background: linear-gradient(135deg, #1e40af, #3b82f6);
                                                color: white;
                                                padding: 12px;
                                                border-radius: 10px;
                                                font-size: 0.9rem;
                                                font-weight: 600;
                                                transition: all 0.3s ease;
                                                border: none;
                                                cursor: pointer;
                                                box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
                                            ">
                                                <i class="fas fa-eye"></i>
                                                <span class="btn-text">Ver</span>
                                            </button>

                                            <a href="<?= url('uploads/documentos/' . $doc['archivo']) ?>" download class="download-link" style="
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                width: 44px;
                                                background: #f8fafc;
                                                color: #475569;
                                                border: 1px solid #e2e8f0;
                                                border-radius: 10px;
                                                font-size: 1rem;
                                                transition: all 0.3s ease;
                                                text-decoration: none;
                                            " title="Descargar">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                               </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php if (count($docsByCategory) > 1): ?>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        
        <!-- Full-Page PDF Viewers (Outside Grid) -->
        <?php foreach ($documentos as $doc): ?>
        <div class="pdf-viewer-fullpage" id="viewer-doc-<?= $doc['id'] ?>" style="
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            background: #0f172a;
        ">
            <!-- Header with close button -->
            <div class="pdf-viewer-header" style="
                background: linear-gradient(135deg, #1e40af, #3b82f6);
                padding: 1rem 1.5rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            ">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-book-open" style="color: white; font-size: 1.5rem;"></i>
                    <span class="pdf-title" style="color: white; font-size: 1.1rem; font-weight: 600;"><?= e($doc['titulo']) ?></span>
                </div>
                <button onclick="closePDFViewer('doc-<?= $doc['id'] ?>')" style="
                    background: rgba(255, 255, 255, 0.1);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                    color: white;
                    width: 40px;
                    height: 40px;
                    border-radius: 8px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    transition: all 0.2s ease;
                    font-size: 1.1rem;
                " onmouseover="this.style.background='rgba(255, 255, 255, 0.2)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- PDF iframe -->
            <iframe class="pdf-iframe" src="" frameborder="0" style="
                width: 100%;
                height: calc(100% - 64px);
                border: none;
            "></iframe>
        </div>
        <?php endforeach; ?>
        
        <style>
            /* Modern Document Card Hover Effects */
            .modern-doc-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
                border-color: #1e40af;
            }

            .modern-doc-card:hover .card-overlay {
                opacity: 1;
            }

            .view-doc-btn:hover {
                background: linear-gradient(135deg, #1e3a8a, #2563eb) !important;
                box-shadow: 0 4px 12px rgba(30, 64, 175, 0.4);
                transform: translateY(-2px);
            }

            .download-link:hover {
                background: rgba(30, 64, 175, 0.2) !important;
                transform: translateY(-2px);
            }

            /* Responsive Grid */
            @media (max-width: 768px) {
                .documents-grid {
                    grid-template-columns: 1fr !important;
                }

                .section-header {
                    padding: 2rem 1.5rem !important;
                }

                /* Stack vertically on mobile */
                .doc-wrapper {
                    flex-direction: column !important;
                }

                .modern-doc-card {
                    flex: 1 !important;
                    width: 100% !important;
                }

                .pdf-viewer-inline {
                    width: 100% !important;
                }
            }

            @media (max-width: 480px) {
                .section-header h2 {
                    font-size: 1.5rem !important;
                }
            }
        </style>
        <?php endif; ?>

    </div>
</section>


<script>
    // Full-Page PDF Viewer Functions
    function togglePDFViewer(docId, pdfUrl, title) {
        const viewer = document.getElementById('viewer-' + docId);
        const iframe = viewer.querySelector('.pdf-iframe');
        
        // Show fullpage viewer
        iframe.src = pdfUrl + '#toolbar=1&navpanes=1&scrollbar=1';
        viewer.style.display = 'block';
        document.body.style.overflow = 'hidden'; // Prevent body scroll
    }
    
    function closePDFViewer(docId) {
        const viewer = document.getElementById('viewer-' + docId);
        const iframe = viewer.querySelector('.pdf-iframe');
        
        // Hide viewer
        viewer.style.display = 'none';
        iframe.src = '';
        document.body.style.overflow = ''; // Restore body scroll
    }
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openViewer = document.querySelector('.pdf-viewer-fullpage[style*="display: block"]');
            if (openViewer) {
               const docId = openViewer.id.replace('viewer-', '');
                closePDFViewer(docId);
            }
        }
    });
</script>

<style>
    .content-body h2 { color: var(--primary); font-size: 1.8rem; margin-top: 2rem; margin-bottom: 1rem; font-weight: 700; }
    .content-body h3 { color: var(--text-dark); font-size: 1.5rem; margin-top: 1.5rem; margin-bottom: 1rem; font-weight: 600; }
    .content-body p { margin-bottom: 1.2rem; font-size: 1.05rem; line-height: 1.7; }
    .content-body ul, .content-body ol { margin-bottom: 1.5rem; padding-left: 2rem; }
    .content-body li { margin-bottom: 0.5rem; }
    .content-body a { color: var(--primary); text-decoration: underline; }
    .content-body a:hover { color: var(--secondary); }
    .content-body img { max-width: 100%; height: auto; border-radius: 8px; margin: 1.5rem 0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
    .content-body table { width: 100%; margin-bottom: 1.5rem; border-collapse: collapse; }
    .content-body th, .content-body td { padding: 12px; border: 1px solid #e5e7eb; }
    .content-body th { background: #f9fafb; font-weight: 600; }
    
    /* Animation Keyframes */
    @keyframes gradientFlow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .animate-gradient {
        background-size: 200% 200% !important;
        animation: gradientFlow 6s ease infinite !important;
    }
</style>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php';
?>
