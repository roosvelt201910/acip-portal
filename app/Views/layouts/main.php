<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($metaDescription ?? 'Instituto de Educación Superior Privado ACIP - Formando profesionales de excelencia') ?>">
    <meta name="acip-site_direccion" content="<?= e(site_config('site_direccion', 'Dirección Institucional')) ?>">
    <meta name="acip-site_phone" content="<?= e(site_config('site_phone', '+51 XXX XXX XXX')) ?>">
    <meta name="acip-site_email" content="<?= e(site_config('site_email', 'contacto@acip.edu.pe')) ?>">
    <meta name="acip-site_horario" content="<?= e(site_config('site_horario', 'Lun - Vie: 8:00 AM - 6:00 PM')) ?>">
    <title><?= e($pageTitle ?? 'Portal ACIP') ?> - Instituto ACIP</title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?= asset('images/favicon.ico') ?>" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- CSS Principal -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>?v=<?= time() ?>">
    
    <!-- Chatbot CSS -->
    <link rel="stylesheet" href="<?= url('css/chatbot.css') ?>?v=<?= time() ?>">
    
    <?php if (isset($extraCSS)): ?>
        <?= $extraCSS ?>
    <?php endif; ?>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="top-bar">
            <div class="container">
                <div class="top-bar-content">
                    <div class="contact-info">
                        <span>Tel: <?= e(site_config('site_phone', '(01) 123-4567')) ?></span>
                        <span>Email: <?= e(site_config('site_email', 'contacto@acip.edu.pe')) ?></span>
                    </div>
                    <div class="top-links">
                        <?php if ($fb = site_config('redes_facebook')): ?>
                            <a href="<?= e($fb) ?>" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i> <span>Facebook</span></a>
                        <?php endif; ?>
                        <?php if ($ig = site_config('redes_instagram')): ?>
                            <a href="<?= e($ig) ?>" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i> <span>Instagram</span></a>
                        <?php endif; ?>
                        <?php if ($tw = site_config('redes_twitter')): ?>
                            <a href="<?= e($tw) ?>" target="_blank" aria-label="Twitter"><i class="fab fa-x-twitter"></i> <span>X (Twitter)</span></a>
                        <?php endif; ?>
                        <?php if ($tk = site_config('redes_tiktok')): ?>
                            <a href="<?= e($tk) ?>" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok"></i> <span>TikTok</span></a>
                        <?php endif; ?>
                        <span class="divider">|</span>
                        <a href="<?= url('/admin/login') ?>" class="intranet-link">Intranet</a>
                    </div>
                </div>
            </div>
        </div>
        
        <nav class="navbar">
            <div class="container">
                <div class="navbar-content">
                    <a href="<?= url('/') ?>" class="logo">
                        <?php if ($logo = site_config('site_logo')): ?>
                            <img src="<?= asset($logo) ?>" alt="<?= e(site_config('site_title', 'ACIP')) ?>" style="max-height: 50px; width: auto;">
                        <?php else: ?>
                            <img src="<?= url('assets/images/logo-wide.png') ?>" alt="<?= e(site_config('site_title', 'ACIP')) ?>" style="max-height: 50px; width: auto;">
                        <?php endif; ?>
                    </a>
                    
                    <button class="mobile-menu-toggle" id="mobileMenuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <?php
                    // Get Menu Items (Dynamic)
                    $db = Database::getInstance();
                    $rawItems = $db->fetchAll("SELECT * FROM menu_items WHERE menu_id = 1 AND activo = 1 ORDER BY orden ASC");
                    
                    $menuTree = [];
                    // First pass: Root items
                    foreach ($rawItems as $item) {
                        if (empty($item['parent_id'])) {
                            $item['children'] = [];
                            $menuTree[$item['id']] = $item;
                        }
                    }
                    // Second pass: Children
                    foreach ($rawItems as $item) {
                        if (!empty($item['parent_id']) && isset($menuTree[$item['parent_id']])) {
                            $menuTree[$item['parent_id']]['children'][] = $item;
                        }
                    }
                    ?>

                    <ul class="nav-menu" id="navMenu">
                        <?php foreach ($menuTree as $item): ?>
                            <?php if (empty($item['children'])): ?>
                                <li><a href="<?= strpos($item['url'], 'http') === 0 ? $item['url'] : url($item['url']) ?>"><?= e($item['titulo']) ?></a></li>
                            <?php else: ?>
                                <li class="dropdown">
                                    <a href="<?= $item['url'] === '#' ? '#' : (strpos($item['url'], 'http') === 0 ? $item['url'] : url($item['url'])) ?>">
                                        <?= e($item['titulo']) ?> <i class="fas fa-chevron-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php foreach ($item['children'] as $child): ?>
                                            <li><a href="<?= strpos($child['url'], 'http') === 0 ? $child['url'] : url($child['url']) ?>"><?= e($child['titulo']) ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Contenido Principal -->
    <main class="main-content">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-col">
                        <h3>Instituto ACIP</h3>
                        <p><?= e(site_config('site_about_snippet', 'Formando profesionales de excelencia comprometidos con el desarrollo del país.')) ?></p>
                        <div class="social-links">
                            <?php if ($fb = site_config('redes_facebook')): ?>
                                <a href="<?= e($fb) ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <?php endif; ?>
                            <?php if ($ig = site_config('redes_instagram')): ?>
                                <a href="<?= e($ig) ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if ($yt = site_config('redes_youtube')): ?>
                                <a href="<?= e($yt) ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                            <?php endif; ?>
                            <?php if ($tw = site_config('redes_twitter')): ?>
                                <a href="<?= e($tw) ?>" target="_blank"><i class="fab fa-x-twitter"></i></a>
                            <?php endif; ?>
                            <?php if ($tk = site_config('redes_tiktok')): ?>
                                <a href="<?= e($tk) ?>" target="_blank"><i class="fab fa-tiktok"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php
                    // Get Footer Menu Items (Dynamic)
                    // Re-using $db instance from header if available, or get new
                    if (!isset($db)) $db = Database::getInstance();
                    $rawFooter = $db->fetchAll("SELECT * FROM menu_items WHERE menu_id = 2 AND activo = 1 ORDER BY orden ASC");
                    
                    $footerTree = [];
                    foreach ($rawFooter as $item) {
                        if (empty($item['parent_id'])) {
                            $item['children'] = [];
                            $footerTree[$item['id']] = $item;
                        }
                    }
                    foreach ($rawFooter as $item) {
                        if (!empty($item['parent_id']) && isset($footerTree[$item['parent_id']])) {
                            $footerTree[$item['parent_id']]['children'][] = $item;
                        }
                    }
                    ?>

                    <?php foreach ($footerTree as $group): ?>
                    <div class="footer-col">
                        <h4><?= e($group['titulo']) ?></h4>
                        <ul>
                            <?php foreach ($group['children'] as $link): ?>
                                <li><a href="<?= strpos($link['url'], 'http') === 0 ? $link['url'] : url($link['url']) ?>"><?= e($link['titulo']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endforeach; ?>
                    
                    <?php if (empty($footerTree)): ?>
                        <!-- Fallback if no footer menus defined -->
                        <div class="footer-col"><h4>Menu Footer</h4><p>No configurado</p></div>
                    <?php endif; ?>
                    
                    <div class="footer-col">
                        <h4>Contacto</h4>
                        <ul class="contact-list">
                            <li><i class="fas fa-map-marker-alt"></i> <?= e(site_config('site_direccion', 'Dirección Institucional')) ?></li>
                            <li><i class="fas fa-phone"></i> <?= e(site_config('site_phone', '+51 XXX XXX XXX')) ?></li>
                            <li><i class="fas fa-envelope"></i> <?= e(site_config('site_email', 'contacto@acip.edu.pe')) ?></li>
                            <li><i class="fas fa-clock"></i> <?= e(site_config('site_horario', 'Lun - Vie: 8:00 AM - 6:00 PM')) ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; <?= date('Y') ?> Instituto de Educación Superior Privado ACIP. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Botón Ir Arriba -->
    <button id="scrollTopBtn" title="Ir arriba" aria-label="Ir arriba">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Floating Social Icons -->
    <div class="floating-social">
        <?php if ($fb = site_config('redes_facebook')): ?>
        <a href="<?= e($fb) ?>" target="_blank" class="float-icon float-fb" title="Facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
        <?php endif; ?>
        
        <?php if ($ig = site_config('redes_instagram')): ?>
        <a href="<?= e($ig) ?>" target="_blank" class="float-icon float-ig" title="Instagram">
            <i class="fab fa-instagram"></i>
        </a>
        <?php endif; ?>

        <?php if ($yt = site_config('redes_youtube')): ?>
        <a href="<?= e($yt) ?>" target="_blank" class="float-icon float-yt" title="YouTube">
            <i class="fab fa-youtube"></i>
        </a>
        <?php endif; ?>
        
        <?php if ($tw = site_config('redes_twitter')): ?>
        <a href="<?= e($tw) ?>" target="_blank" class="float-icon float-tw" title="X (Twitter)">
            <i class="fab fa-x-twitter"></i>
        </a>
        <?php endif; ?>

        <?php if ($tk = site_config('redes_tiktok')): ?>
        <a href="<?= e($tk) ?>" target="_blank" class="float-icon float-tk" title="TikTok">
            <i class="fab fa-tiktok"></i>
        </a>
        <?php endif; ?>

        <?php 
        $whatsappNum = site_config('whatsapp_numero');
        $whatsappMsg = site_config('whatsapp_mensaje') ?: 'Hola, estoy interesado en más información';
        if ($whatsappNum): 
            $whatsappUrl = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsappNum) . '?text=' . urlencode($whatsappMsg);
        ?>
        <a href="<?= e($whatsappUrl) ?>" target="_blank" class="float-icon float-wa" title="WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
        <?php endif; ?>
    </div>

    <style>
        .floating-social {
            position: fixed;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .float-icon {
            width: 45px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
            box-shadow: -2px 2px 5px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .float-icon:hover {
            width: 55px;
            padding-right: 5px;
            color: white;
        }

        .float-fb { background: #1877F2; }
        .float-fb:hover { background: #1461c7; }

        .float-ig { 
            background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
        }
        .float-ig:hover { opacity: 0.9; }

        .float-yt { background: #FF0000; }
        .float-yt:hover { background: #CC0000; }

        .float-tw { background: #000000; }
        .float-tw:hover { background: #333333; }

        .float-tk { background: #000000; } 
        /* TikTok often uses black or a gradient. Let's use black with a border or gradient */
        .float-tk { 
            background: linear-gradient(45deg, #000000, #25F4EE, #FE2C55); 
            background-size: 200% 200%;
            animation: gradientBG 3s ease infinite;
        }
        .float-tk:hover { opacity: 0.9; }

        .float-wa { background: #25D366; }
        .float-wa:hover { background: #1ebe57; }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?= asset('js/jquery.revolver.min.js') ?>"></script>
    <script src="<?= asset('js/main.js') ?>?v=<?= time() ?>"></script>
    
    <!-- Chatbot JavaScript -->
    <script src="<?= url('js/chatbot.js') ?>?v=<?= time() ?>"></script>
    
    <?php if (isset($extraJS)): ?>
        <?= $extraJS ?>
    <?php endif; ?>
</body>
</html>
