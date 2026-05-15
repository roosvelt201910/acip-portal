<?php ob_start(); ?>

<style>
    /* Enterprise Style Variables */
    :root {
        --primary-color: #0f172a; 
        --accent-color: #2563eb; 
        --bg-gray: #f8fafc;
        --border-color: #e2e8f0;
        --text-color: #334155;
    }

    /* General Layout */
    .card-enterprise {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    .card-header-enterprise {
        background: #fff;
        padding: 24px 32px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header-enterprise h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
        letter-spacing: -0.025em;
    }

    /* Tabs Styling */
    .nav-tabs-enterprise {
        display: flex;
        padding: 0 20px;
        background: #fff;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 30px;
    }

    .nav-tab-enterprise {
        padding: 16px 24px;
        cursor: pointer;
        font-weight: 500;
        color: #64748b;
        border-bottom: 2px solid transparent;
        transition: all 0.2s ease;
        font-size: 0.95rem;
    }

    .nav-tab-enterprise:hover {
        color: var(--accent-color);
        background: #f1f5f9;
    }

    .nav-tab-enterprise.active {
        color: var(--accent-color);
        border-bottom-color: var(--accent-color);
    }

    /* Form Elements */
    .form-section {
        padding: 0 32px 32px;
        position: relative;
    }

    .form-group-enterprise {
        margin-bottom: 24px;
    }

    .label-enterprise {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 8px;
    }

    .input-enterprise {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 0.95rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #fcfcfc;
    }

    .input-enterprise:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: #fff;
    }

    /* Drag & Drop Zones */
    .drop-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .drop-zone:hover, .drop-zone.dragover {
        border-color: var(--accent-color);
        background: #eff6ff;
    }

    .drop-zone i {
        font-size: 2.5rem;
        color: #94a3b8;
        margin-bottom: 12px;
    }

    .drop-zone p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    .drop-zone .highlight-text {
        color: var(--accent-color);
        font-weight: 600;
    }

    /* Gallery Grid */
    .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; margin-top: 15px; margin-bottom: 20px;}
    .gallery-item { position: relative; border-radius: 8px; overflow: hidden; height: 150px; border: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .gallery-item img { width: 100%; height: 100%; object-fit: cover; }
    .delete-img { position: absolute; top: 5px; right: 5px; background: rgba(239, 68, 68, 0.9); color: white; border: none; border-radius: 50%; width: 28px; height: 28px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
    .delete-img:hover { background: #dc2626; transform: scale(1.1); }

    /* Preview Grids */
    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 12px;
        margin-top: 16px;
    }
    .preview-item {
        position: relative;
        height: 100px;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid var(--border-color);
    }
    .preview-item img {
        width: 100%; height: 100%; object-fit: cover;
    }

    /* Tab Content - Standard Display */
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn { 
        from { opacity: 0; } 
        to { opacity: 1; } 
    }

    .btn-enterprise {
        background: var(--accent-color);
        color: white;
        padding: 12px 28px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(37,99,235,0.2);
        transition: transform 0.1s, box-shadow 0.1s;
    }
    .btn-enterprise:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 6px rgba(37,99,235,0.3);
        transform: translateY(-1px);
    }

    /* CKEditor Styles */
    .ck-editor__editable {
        min-height: 200px !important;
        max-height: 500px !important;
    }
    
    .ck.ck-editor {
        width: 100%;
    }
</style>

<div class="card-enterprise">
    <div class="card-header-enterprise">
        <h2><i class="fas fa-edit text-gray-400 mr-2"></i> Editar Programa: <?= e($programa['nombre']) ?></h2>
        <a href="<?= url('admin/programas') ?>" class="btn btn-light" style="border: 1px solid #e2e8f0; color: #475569; padding: 8px 16px; border-radius: 6px; font-weight: 500;">
            <i class="fas fa-arrow-left mr-1"></i> Cancelar
        </a>
    </div>

    <form action="<?= url('admin/programas/editar/' . $programa['id']) ?>" method="POST" enctype="multipart/form-data" id="formPrograma">
        
        <!-- Enterprise Tabs -->
        <div class="nav-tabs-enterprise">
            <div class="nav-tab-enterprise active" data-tab="general">Información General</div>
            <div class="nav-tab-enterprise" data-tab="academico">Detalles Académicos</div>
            <div class="nav-tab-enterprise" data-tab="documentos">Gestión y Documentos</div>
            <div class="nav-tab-enterprise" data-tab="galeria">Galería y Aliados</div>
        </div>

        <div class="form-section">
            <!-- TAB: GENERAL -->
            <div id="tab-general" class="tab-content active">
                <div class="row" style="display: flex; gap: 40px;">
                    <div style="flex: 2;">
                        <div class="form-group-enterprise">
                            <label class="label-enterprise">Nombre del Programa <span class="text-red-500">*</span></label>
                            <input type="text" name="nombre" class="input-enterprise" value="<?= e($programa['nombre']) ?>" required>
                        </div>
                        <div class="form-group-enterprise">
                            <label class="label-enterprise">Descripción Corta <span class="text-red-500">*</span></label>
                            <textarea name="descripcion" rows="4" class="input-enterprise" required><?= e($programa['descripcion']) ?></textarea>
                        </div>
                    </div>
                    <div style="flex: 1;">
                         <div style="background: #f8fafc; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <div class="form-group-enterprise">
                                <label class="label-enterprise">Modalidad</label>
                                <select name="modalidad" class="input-enterprise">
                                    <option value="presencial" <?= ($programa['modalidad'] == 'presencial') ? 'selected' : '' ?>>Presencial</option>
                                    <option value="semipresencial" <?= ($programa['modalidad'] == 'semipresencial') ? 'selected' : '' ?>>Semipresencial</option>
                                    <option value="virtual" <?= ($programa['modalidad'] == 'virtual') ? 'selected' : '' ?>>Virtual</option>
                                </select>
                            </div>
                            
                            <div class="row" style="display:flex; gap: 15px;">
                                <div class="form-group-enterprise" style="flex:1">
                                    <label class="label-enterprise">Duración (Sem)</label>
                                    <input type="number" name="duracion_semestres" class="input-enterprise" value="<?= e($programa['duracion_semestres']) ?>">
                                </div>
                                <div class="form-group-enterprise" style="flex:1">
                                    <label class="label-enterprise">Orden</label>
                                    <input type="number" name="orden" class="input-enterprise" value="<?= e($programa['orden']) ?>">
                                </div>
                            </div>

                            <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-white rounded transition">
                                <input type="checkbox" name="activo" value="1" <?= $programa['activo'] ? 'checked' : '' ?> style="width: 18px; height: 18px;">
                                <span class="text-sm font-semibold text-gray-700">Publicar en Web</span>
                            </label>
                         </div>
                    </div>
                </div>

                <hr style="margin: 30px 0; border: 0; border-top: 1px solid #e2e8f0;">

                <div class="row" style="display: flex; gap: 40px;">
                    <div style="flex: 1;">
                         <label class="label-enterprise mb-3">Imagen Destacada (Portada)</label>
                         
                         <!-- Media Type Selector for Portada -->
                         <div style="display: flex; gap: 12px; margin-bottom: 15px;">
                            <label style="display: flex; align-items: center; gap: 6px; padding: 10px 16px; background: #f8fafc; border-radius: 8px; cursor: pointer; border: 2px solid <?= ($programa['portada_media_type'] ?? 'image') === 'image' ? '#6366f1' : '#e5e7eb' ?>; transition: all 0.2s; font-size: 0.9rem;">
                                <input type="radio" name="portada_media_type" value="image" 
                                       <?= ($programa['portada_media_type'] ?? 'image') === 'image' ? 'checked' : '' ?>
                                       onchange="togglePortadaType('image')" style="accent-color: #6366f1;">
                                <i class="fas fa-image" style="color: #6366f1;"></i>
                                <span style="font-weight: 600;">Imagen</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 6px; padding: 10px 16px; background: #f8fafc; border-radius: 8px; cursor: pointer; border: 2px solid <?= ($programa['portada_media_type'] ?? 'image') === 'video' ? '#dc2626' : '#e5e7eb' ?>; transition: all 0.2s; font-size: 0.9rem;">
                                <input type="radio" name="portada_media_type" value="video" 
                                       <?= ($programa['portada_media_type'] ?? 'image') === 'video' ? 'checked' : '' ?>
                                       onchange="togglePortadaType('video')" style="accent-color: #dc2626;">
                                <i class="fab fa-youtube" style="color: #dc2626;"></i>
                                <span style="font-weight: 600;">Video YouTube</span>
                            </label>
                         </div>

                         <!-- Image Section -->
                         <div id="portadaImageSection" style="display: <?= ($programa['portada_media_type'] ?? 'image') === 'image' ? 'block' : 'none' ?>;">
                             <?php if(!empty($programa['imagen'])): ?>
                                <div style="margin-bottom: 15px;">
                                    <img src="<?= url($programa['imagen']) ?>" style="height: 150px; width: auto; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                </div>
                             <?php endif; ?>

                             <div class="drop-zone" id="drop-main">
                                <input type="file" name="imagen" id="imagen" accept="image/*" style="display:none;">
                                <i class="fas fa-camera"></i>
                                <p>Cambiar imagen: Arrastrar o <span class="highlight-text">clic aquí</span></p>
                                <div id="preview-main" class="preview-grid" style="grid-template-columns: 1fr; margin-top: 15px;"></div>
                             </div>
                         </div>

                         <!-- Video YouTube Section -->
                         <div id="portadaVideoSection" style="display: <?= ($programa['portada_media_type'] ?? 'image') === 'video' ? 'block' : 'none' ?>;">
                             <?php if(!empty($programa['portada_video_url'])): ?>
                                <div style="margin-bottom: 15px; padding: 12px; background: #fef2f2; border-radius: 8px; border: 1px solid #fecaca;">
                                    <p style="margin: 0; font-size: 0.85rem; color: #dc2626;">
                                        <i class="fab fa-youtube"></i> Video actual: 
                                        <a href="<?= e($programa['portada_video_url']) ?>" target="_blank" style="color: #7f1d1d;"><?= e($programa['portada_video_url']) ?></a>
                                    </p>
                                </div>
                             <?php endif; ?>
                             
                             <div class="form-group-enterprise">
                                 <input type="url" name="portada_video_url" class="input-enterprise" 
                                        value="<?= e($programa['portada_video_url'] ?? '') ?>" 
                                        placeholder="https://youtube.com/watch?v=xxxxx">
                                 <small style="display: block; margin-top: 5px; color: #64748b;">
                                     <i class="fab fa-youtube" style="color: #dc2626;"></i> Pega el enlace del video de YouTube
                                 </small>
                         </div>
                    </div>
                    <div style="flex: 1;">
                        <label class="label-enterprise mb-3">Contenido Promocional</label>
                        
                        <!-- Media Type Selector for Promo -->
                        <div style="display: flex; gap: 12px; margin-bottom: 15px;">
                            <label style="display: flex; align-items: center; gap: 6px; padding: 10px 16px; background: #f8fafc; border-radius: 8px; cursor: pointer; border: 2px solid <?= ($programa['promo_media_type'] ?? 'video') === 'image' ? '#6366f1' : '#e5e7eb' ?>; transition: all 0.2s; font-size: 0.9rem;">
                                <input type="radio" name="promo_media_type" value="image" 
                                       <?= ($programa['promo_media_type'] ?? 'video') === 'image' ? 'checked' : '' ?>
                                       onchange="togglePromoType('image')" style="accent-color: #6366f1;">
                                <i class="fas fa-image" style="color: #6366f1;"></i>
                                <span style="font-weight: 600;">Imagen</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 6px; padding: 10px 16px; background: #f8fafc; border-radius: 8px; cursor: pointer; border: 2px solid <?= ($programa['promo_media_type'] ?? 'video') === 'video' ? '#dc2626' : '#e5e7eb' ?>; transition: all 0.2s; font-size: 0.9rem;">
                                <input type="radio" name="promo_media_type" value="video" 
                                       <?= ($programa['promo_media_type'] ?? 'video') === 'video' ? 'checked' : '' ?>
                                       onchange="togglePromoType('video')" style="accent-color: #dc2626;">
                                <i class="fab fa-youtube" style="color: #dc2626;"></i>
                                <span style="font-weight: 600;">Video YouTube</span>
                            </label>
                        </div>

                        <!-- Promo Image Section -->
                        <div id="promoImageSection" style="display: <?= ($programa['promo_media_type'] ?? 'video') === 'image' ? 'block' : 'none' ?>;">
                             <?php if(!empty($programa['promo_image'])): ?>
                                <div style="margin-bottom: 15px;">
                                    <img src="<?= url($programa['promo_image']) ?>" style="height: 100px; width: auto; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <p style="margin-top: 8px; font-size: 0.85rem; color: #64748b;">
                                        <i class="fas fa-check-circle" style="color: #10b981;"></i> Imagen promocional actual
                                    </p>
                                </div>
                             <?php endif; ?>

                             <div class="drop-zone" id="drop-promo-image">
                                <input type="file" name="promo_image" id="promo_image" accept="image/*" style="display:none;">
                                <i class="fas fa-image"></i>
                                <p>Arrastra imagen o <span class="highlight-text">clic aquí</span></p>
                                <div id="preview-promo-image" style="margin-top: 15px;"></div>
                             </div>
                        </div>

                        <!-- Promo Video Section -->
                        <div id="promoVideoSection" style="display: <?= ($programa['promo_media_type'] ?? 'video') === 'video' ? 'block' : 'none' ?>;">
                            <div class="form-group-enterprise">
                                <?php if(!empty($programa['video_url'])): ?>
                                    <p style="margin-bottom: 10px; font-size: 0.85rem; color: #64748b;">
                                        <i class="fab fa-youtube" style="color: #dc2626;"></i> Video actual: 
                                        <a href="<?= e($programa['video_url']) ?>" target="_blank" style="color: #2563eb;"><?= e($programa['video_url']) ?></a>
                                    </p>
                                <?php endif; ?>
                                <input type="url" name="video_url" class="input-enterprise" value="<?= e($programa['video_url'] ?? '') ?>" placeholder="https://youtube.com/...">
                                <small style="display: block; margin-top: 5px; color: #64748b;">Enlace directo a YouTube o Vimeo</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="display: flex; gap: 40px; margin-top: 30px;">
                    <div style="flex: 1;">
                         <label class="label-enterprise mb-3">Hero del Programa</label>
                         
                         <!-- Media Type Selector for Hero -->
                         <div style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                            <label style="display: flex; align-items: center; gap: 6px; padding: 10px 14px; background: #f8fafc; border-radius: 8px; cursor: pointer; border: 2px solid <?= ($programa['hero_media_type'] ?? 'image') === 'image' ? '#6366f1' : '#e5e7eb' ?>; transition: all 0.2s; font-size: 0.85rem;">
                                <input type="radio" name="hero_media_type" value="image" 
                                       <?= ($programa['hero_media_type'] ?? 'image') === 'image' ? 'checked' : '' ?>
                                       onchange="toggleHeroType('image')" style="accent-color: #6366f1;">
                                <i class="fas fa-image" style="color: #6366f1;"></i>
                                <span style="font-weight: 600;">Imagen</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 6px; padding: 10px 14px; background: #f8fafc; border-radius: 8px; cursor: pointer; border: 2px solid <?= ($programa['hero_media_type'] ?? 'image') === 'video' ? '#10b981' : '#e5e7eb' ?>; transition: all 0.2s; font-size: 0.85rem;">
                                <input type="radio" name="hero_media_type" value="video" 
                                       <?= ($programa['hero_media_type'] ?? 'image') === 'video' ? 'checked' : '' ?>
                                       onchange="toggleHeroType('video')" style="accent-color: #10b981;">
                                <i class="fas fa-video" style="color: #10b981;"></i>
                                <span style="font-weight: 600;">Video Archivo</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 6px; padding: 10px 14px; background: #f8fafc; border-radius: 8px; cursor: pointer; border: 2px solid <?= ($programa['hero_media_type'] ?? 'image') === 'youtube' ? '#dc2626' : '#e5e7eb' ?>; transition: all 0.2s; font-size: 0.85rem;">
                                <input type="radio" name="hero_media_type" value="youtube" 
                                       <?= ($programa['hero_media_type'] ?? 'image') === 'youtube' ? 'checked' : '' ?>
                                       onchange="toggleHeroType('youtube')" style="accent-color: #dc2626;">
                                <i class="fab fa-youtube" style="color: #dc2626;"></i>
                                <span style="font-weight: 600;">YouTube</span>
                            </label>
                         </div>

                         <!-- Hero Image Section -->
                         <div id="heroImageSection" style="display: <?= ($programa['hero_media_type'] ?? 'image') === 'image' ? 'block' : 'none' ?>;">
                             <?php if(!empty($programa['hero_image'])): ?>
                                <div style="margin-bottom: 15px;">
                                    <img src="<?= url($programa['hero_image']) ?>" style="height: 120px; width: auto; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <p style="margin-top: 8px; font-size: 0.85rem; color: #64748b;">
                                        <i class="fas fa-check-circle" style="color: #10b981;"></i> Imagen hero actual
                                    </p>
                                </div>
                             <?php endif; ?>

                             <div class="drop-zone" id="drop-hero-image">
                                <input type="file" name="hero_image" id="hero_image" accept="image/*" style="display:none;">
                                <i class="fas fa-image"></i>
                                <p>Arrastra imagen aquí o <span class="highlight-text">clic para subir</span></p>
                                <small style="color: #64748b;">PNG, JPG, WEBP (recomendado: 1920x600px)</small>
                                <div id="preview-hero-image" style="margin-top: 15px;"></div>
                             </div>
                         </div>

                         <!-- Hero Video File Section -->
                         <div id="heroVideoSection" style="display: <?= ($programa['hero_media_type'] ?? 'image') === 'video' ? 'block' : 'none' ?>;">
                             <?php if(!empty($programa['video_hero']) && strpos($programa['video_hero'], 'youtube') === false && strpos($programa['video_hero'], 'youtu.be') === false): ?>
                                <div style="margin-bottom: 15px;">
                                    <video controls style="width: 100%; max-height: 150px; border-radius: 8px; border: 1px solid #e2e8f0;">
                                        <source src="<?= url($programa['video_hero']) ?>" type="video/mp4">
                                    </video>
                                    <p style="margin-top: 8px; font-size: 0.85rem; color: #64748b;">
                                        <i class="fas fa-check-circle" style="color: #10b981;"></i> Video archivo actual
                                    </p>
                                </div>
                             <?php endif; ?>

                             <div class="drop-zone" id="drop-video">
                                <input type="file" name="video_hero" id="video_hero" accept="video/*" style="display:none;">
                                <i class="fas fa-video"></i>
                                <p>Arrastra video aquí / <span class="highlight-text">clic para subir archivo</span></p>
                                <small style="color: #64748b;">Formatos: MP4, WebM, MOV (máx. 50MB)</small>
                                <div id="preview-video" style="margin-top: 15px;"></div>
                             </div>
                         </div>

                         <!-- Hero YouTube Section -->
                         <div id="heroYoutubeSection" style="display: <?= ($programa['hero_media_type'] ?? 'image') === 'youtube' ? 'block' : 'none' ?>;">
                             <?php 
                             $currentYoutubeUrl = '';
                             if(!empty($programa['video_hero']) && (strpos($programa['video_hero'], 'youtube') !== false || strpos($programa['video_hero'], 'youtu.be') !== false)) {
                                 $currentYoutubeUrl = $programa['video_hero'];
                             }
                             if(!empty($programa['hero_youtube_url'])) {
                                 $currentYoutubeUrl = $programa['hero_youtube_url'];
                             }
                             ?>
                             <?php if(!empty($currentYoutubeUrl)): ?>
                                <div style="margin-bottom: 15px; padding: 12px; background: #fef2f2; border-radius: 8px; border: 1px solid #fecaca;">
                                    <p style="margin: 0; font-size: 0.85rem; color: #dc2626;">
                                        <i class="fab fa-youtube"></i> Video actual: 
                                        <a href="<?= e($currentYoutubeUrl) ?>" target="_blank" style="color: #7f1d1d;"><?= e($currentYoutubeUrl) ?></a>
                                    </p>
                                </div>
                             <?php endif; ?>
                             
                             <div class="form-group-enterprise">
                                 <input type="url" name="hero_youtube_url" class="input-enterprise" 
                                        value="<?= e($currentYoutubeUrl) ?>" 
                                        placeholder="https://youtube.com/watch?v=xxxxx">
                                 <small style="display: block; margin-top: 5px; color: #64748b;">
                                     <i class="fab fa-youtube" style="color: #dc2626;"></i> Pega el enlace del video de YouTube
                                 </small>
                             </div>
                         </div>
                    </div>
                    <div style="flex: 1; display: flex; align-items: center; justify-content: center; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px;">
                        <div style="text-align: center; color: #64748b;">
                            <i class="fas fa-info-circle" style="font-size: 2rem; margin-bottom: 10px; color: #2563eb;"></i>
                            <p style="margin: 0; font-size: 0.9rem;"><strong>Tip:</strong> El hero es el fondo de la cabecera de la página del programa. Puedes usar imagen, video subido o video de YouTube.</p>
                        </div>
                    </div>
                </div>
            </div>
            </div> <!-- END tab-general -->

            <!-- TAB: ACADEMICO -->
            <div id="tab-academico" class="tab-content">
                <div class="form-group-enterprise">
                    <label class="label-enterprise">Perfil del Egresado</label>
                    <textarea name="perfil_egresado" id="perfil_egresado" class="editor"><?= $programa['perfil_egresado'] ?? '' ?></textarea>
                </div>
                <div class="form-group-enterprise">
                    <label class="label-enterprise">Ámbito Laboral</label>
                    <textarea name="ambito_laboral" id="ambito_laboral" class="editor"><?= $programa['ambito_laboral'] ?? '' ?></textarea>
                </div>
                <div class="form-group-enterprise">
                    <label class="label-enterprise">Certificaciones</label>
                    <textarea name="certificaciones" id="certificaciones" class="editor"><?= $programa['certificaciones'] ?? '' ?></textarea>
                </div>
                <div class="form-group-enterprise">
                    <label class="label-enterprise">Plan de Estudios</label>
                    <textarea name="plan_estudios" id="plan_estudios" class="editor"><?= $programa['plan_estudios'] ?? '' ?></textarea>
                </div>
            </div>

            <!-- TAB: DOCUMENTOS -->
            <div id="tab-documentos" class="tab-content">
                <div class="form-group-enterprise">
                    <label class="label-enterprise">Horario de Clases</label>
                    <textarea name="horario_clases" id="horario_clases" class="editor"><?= $programa['horario_clases'] ?? '' ?></textarea>
                    <small class="text-gray-500">Puedes escribir el horario o insertar un enlace a PDF aquí.</small>
                </div>
                <div class="form-group-enterprise">
                    <label class="label-enterprise">Oficio de Autorización</label>
                    <textarea name="oficio_autorizacion" id="oficio_autorizacion" class="editor"><?= $programa['oficio_autorizacion'] ?? '' ?></textarea>
                </div>
                <div class="form-group-enterprise">
                    <label class="label-enterprise">Información de Matrícula</label>
                    <textarea name="matricula_info" id="matricula_info" class="editor"><?= $programa['matricula_info'] ?? '' ?></textarea>
                </div>
                <div class="form-group-enterprise">
                    <label class="label-enterprise">EFSRT (Experiencias Formativas)</label>
                    <textarea name="efsrt" id="efsrt" class="editor"><?= $programa['efsrt'] ?? '' ?></textarea>
                </div>
            </div>

            <!-- TAB: GALERIA -->
            <div id="tab-galeria" class="tab-content">
                <div class="mb-5">
                    <label class="label-enterprise mb-3">Galería de Fotos (Existentes)</label>
                    
                    <div class="gallery-grid">
                        <?php if (!empty($galeria)): foreach($galeria as $img): ?>
                        <div class="gallery-item" id="img-<?= $img['id'] ?>">
                            <img src="<?= url($img['imagen_path']) ?>">
                            <button type="button" class="delete-img" onclick="deleteImage('galeria', <?= $img['id'] ?>)"><i class="fas fa-times"></i></button>
                        </div>
                        <?php endforeach; else: ?>
                            <p class="text-gray-400 text-sm">No hay imágenes en la galería.</p>
                        <?php endif; ?>
                    </div>

                    <label class="label-enterprise mb-3 mt-4">Agregar Nuevas Fotos</label>
                    <div class="drop-zone" id="drop-gallery">
                        <input type="file" name="galeria[]" id="galeria" multiple accept="image/*" style="display:none;">
                        <i class="fas fa-images"></i>
                        <p>Arrastra nuevas fotos aquí o <span class="highlight-text">haz clic</span></p>
                        <div id="preview-gallery" class="preview-grid"></div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200">
                    <label class="label-enterprise mb-3">Aliados / Convenios (Existentes)</label>
                    <div class="gallery-grid">
                        <?php if (!empty($aliados)): foreach($aliados as $img): ?>
                        <div class="gallery-item" id="aliado-<?= $img['id'] ?>">
                            <img src="<?= url($img['imagen_path']) ?>">
                            <button type="button" class="delete-img" onclick="deleteImage('aliados', <?= $img['id'] ?>)"><i class="fas fa-times"></i></button>
                        </div>
                        <?php endforeach; else: ?>
                            <p class="text-gray-400 text-sm">No hay aliados registrados.</p>
                        <?php endif; ?>
                    </div>

                    <label class="label-enterprise mb-3 mt-4">Agregar Nuevos Aliados</label>
                    <div class="drop-zone" id="drop-aliados">
                        <input type="file" name="aliados[]" id="aliados" multiple accept="image/*" style="display:none;">
                        <i class="fas fa-handshake"></i>
                        <p>Sube logotipos de aliados aquí</p>
                        <div id="preview-aliados" class="preview-grid"></div>
                    </div>
                </div>
            </div>
        </div>

        <div style="padding: 24px 32px; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: right;">
            <button type="submit" class="btn-enterprise">
                <i class="fas fa-save mr-2"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>

<!-- CKEditor 5 Official CDN with GPL License (UMD Build) -->
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">
<script src="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.umd.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // Tab Switching (Moved to top priority)
    document.querySelectorAll('.nav-tab-enterprise').forEach(tab => {
        tab.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            
            // Remove active from all
            document.querySelectorAll('.nav-tab-enterprise').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => {
                c.classList.remove('active');
            });
            
            // Add active to selected
            this.classList.add('active');
            const target = document.getElementById('tab-' + tabName);
            if(target) {
                target.classList.add('active');
                // Trigger resize to fix CKEditor/Charts rendering in hidden tabs
                setTimeout(() => {
                    window.dispatchEvent(new Event('resize'));
                }, 100);
            }
        });
    });

    // CKEditor Initialization
    if (typeof CKEDITOR !== 'undefined') {
        try {
            // Extraer plugins necesarios del objeto global CKEDITOR
            const {
        ClassicEditor,
        SourceEditing,
        Essentials,
        Bold,
        Italic,
        Underline,
        Strikethrough,
        Heading,
        Link,
        List,
        BlockQuote,
        Table,
        TableToolbar,
        Paragraph,
        Undo,
        Indent,
        IndentBlock,
        Alignment,
        GeneralHtmlSupport,
        Image,
        ImageToolbar,
        ImageUpload,
        ImageResize,
        ImageStyle,
        MediaEmbed
    } = CKEDITOR;
    
    // Almacenar instancias de editores
    const editors = {};
    
    // Configuración común para todos los editores
    const editorConfig = {
        licenseKey: 'GPL',
        plugins: [
            SourceEditing,
            Essentials,
            Bold,
            Italic,
            Underline,
            Strikethrough,
            Heading,
            Link,
            List,
            BlockQuote,
            Table,
            TableToolbar,
            Paragraph,
            Undo,
            Indent,
            IndentBlock,
            Alignment,
            GeneralHtmlSupport,
            Image,
            ImageToolbar,
            ImageUpload,
            ImageResize,
            ImageStyle,
            MediaEmbed
        ],
        toolbar: [
            'sourceEditing', '|',
            'heading', '|',
            'bold', 'italic', 'underline', 'strikethrough', '|',
            'bulletedList', 'numberedList', '|',
            'alignment', 'outdent', 'indent', '|',
            'link', 'blockQuote', 'insertTable', '|',
            'uploadImage', 'mediaEmbed', '|',
            'undo', 'redo'
        ],
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
        },
        image: {
            toolbar: [
                'imageStyle:inline',
                'imageStyle:block',
                'imageStyle:side',
                '|',
                'toggleImageCaption',
                'imageTextAlternative',
                '|',
                'linkImage'
            ],
            resizeOptions: [
                {
                    name: 'resizeImage:original',
                    label: 'Original',
                    value: null
                },
                {
                    name: 'resizeImage:50',
                    label: '50%',
                    value: '50'
                },
                {
                    name: 'resizeImage:75',
                    label: '75%',
                    value: '75'
                }
            ]
        },
        htmlSupport: {
            allow: [
                {
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }
            ]
        },
        language: 'es'
    };

    // Custom Upload Adapter for Base64 images
    function CustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return {
                upload: () => {
                    return loader.file.then(file => new Promise((resolve, reject) => {
                        const reader = new FileReader();
                        reader.onload = () => {
                            resolve({ default: reader.result });
                        };
                        reader.onerror = error => reject(error);
                        reader.readAsDataURL(file);
                    }));
                }
            };
        };
    }

    // Inicializar editores
    document.querySelectorAll('.editor').forEach(textarea => {
        const id = textarea.id;
        
        ClassicEditor
            .create(textarea, editorConfig)
            .then(editor => {
                // Add custom upload adapter
                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                    return {
                        upload: () => {
                            return loader.file.then(file => new Promise((resolve, reject) => {
                                const reader = new FileReader();
                                reader.onload = () => {
                                    resolve({ default: reader.result });
                                };
                                reader.onerror = error => reject(error);
                                reader.readAsDataURL(file);
                            }));
                        }
                    };
                };
                
                editors[id] = editor;
                console.log('CKEditor initialized successfully on:', id);
            })
            .catch(error => {
                console.error('Error initializing editor ' + id + ':', error);
            });
    });

    // Actualizar textareas antes de enviar el formulario
    document.getElementById('formPrograma').addEventListener('submit', function() {
        for (const [id, editor] of Object.entries(editors)) {
            const textarea = document.getElementById(id);
            if (textarea) {
                textarea.value = editor.getData();
            }
        }
    });



        } catch (error) {
            console.error('CKEditor initialization error:', error);
        }
    }

    // Delete Image
    window.deleteImage = function(type, id) {
        if(!confirm("¿Eliminar esta imagen?")) return;
        
        fetch("<?= url('admin/programas/eliminar-imagen') ?>/" + type + "/" + id, {
            method: "GET",
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const prefix = (type === "galeria") ? "img-" : "aliado-";
                const el = document.getElementById(prefix + id);
                if(el) el.remove();
            } else {
                alert("Error al eliminar la imagen");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Error de conexión");
        });
    }

    // Drop Zone Setup
    function setupDropZone(dropZoneId, inputId, previewId, isMultiple) {
        const dropZone = document.getElementById(dropZoneId);
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        
        if(!dropZone || !input || !preview) return;

        dropZone.addEventListener('click', function(e) {
            if(e.target === dropZone || e.target.tagName === 'I' || e.target.tagName === 'P' || e.target.tagName === 'SPAN') {
                input.click();
            }
        });
        
        input.addEventListener('change', function() {
            handleFiles(this.files, preview, isMultiple);
        });
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, function(e) { 
                e.preventDefault(); 
                e.stopPropagation(); 
            });
        });
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, function() { 
                this.classList.add('dragover'); 
            });
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, function() { 
                this.classList.remove('dragover'); 
            });
        });
        
        dropZone.addEventListener('drop', function(e) {
            input.files = e.dataTransfer.files;
            handleFiles(e.dataTransfer.files, preview, isMultiple);
        });
    }

    function handleFiles(files, previewContainer, isMultiple) {
        if (!isMultiple) previewContainer.innerHTML = '';
        
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onloadend = function() {
                    const div = document.createElement('div');
                    div.className = 'preview-item';
                    div.innerHTML = '<img src="' + reader.result + '" alt="Preview">';
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            } else if (file.type.startsWith('video/')) {
                const reader = new FileReader();
                reader.onloadend = function() {
                    const div = document.createElement('div');
                    div.style.marginTop = '10px';
                    div.innerHTML = `
                        <video controls style="width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <source src="${reader.result}" type="${file.type}">
                        </video>
                        <p style="margin-top: 8px; font-size: 0.85rem; color: #64748b;">
                            <i class="fas fa-file-video"></i> ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)
                        </p>
                    `;
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Initialize Drop Zones
    setupDropZone('drop-main', 'imagen', 'preview-main', false);
    setupDropZone('drop-video', 'video_hero', 'preview-video', false);
    setupDropZone('drop-gallery', 'galeria', 'preview-gallery', true);
    setupDropZone('drop-aliados', 'aliados', 'preview-aliados', true);
    setupDropZone('drop-hero-image', 'hero_image', 'preview-hero-image', false);
    setupDropZone('drop-promo-image', 'promo_image', 'preview-promo-image', false);
});

// Toggle between Portada Image and Video
function togglePortadaType(type) {
    const imageSection = document.getElementById('portadaImageSection');
    const videoSection = document.getElementById('portadaVideoSection');
    
    if (type === 'image') {
        imageSection.style.display = 'block';
        videoSection.style.display = 'none';
    } else {
        imageSection.style.display = 'none';
        videoSection.style.display = 'block';
    }
}

// Toggle between Hero Image, Video and YouTube
function toggleHeroType(type) {
    const imageSection = document.getElementById('heroImageSection');
    const videoSection = document.getElementById('heroVideoSection');
    const youtubeSection = document.getElementById('heroYoutubeSection');
    
    imageSection.style.display = 'none';
    videoSection.style.display = 'none';
    youtubeSection.style.display = 'none';
    
    if (type === 'image') {
        imageSection.style.display = 'block';
    } else if (type === 'video') {
        videoSection.style.display = 'block';
    } else if (type === 'youtube') {
        youtubeSection.style.display = 'block';
    }
}

// Toggle between Promo Image and Video
function togglePromoType(type) {
    const imageSection = document.getElementById('promoImageSection');
    const videoSection = document.getElementById('promoVideoSection');
    
    if (type === 'image') {
        imageSection.style.display = 'block';
        videoSection.style.display = 'none';
    } else {
        imageSection.style.display = 'none';
        videoSection.style.display = 'block';
    }
}
</script>

<!-- SweetAlert for Flash Messages -->
<script>
<?php if (isset($_SESSION['flash_success'])): ?>
Swal.fire({
    icon: 'success',
    title: '¡Guardado!',
    text: '<?= e($_SESSION['flash_success']) ?>',
    confirmButtonColor: '#2563eb',
    timer: 3000,
    timerProgressBar: true
});
<?php unset($_SESSION['flash_success']); endif; ?>

<?php if (isset($_SESSION['flash_error'])): ?>
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: '<?= e($_SESSION['flash_error']) ?>',
    confirmButtonColor: '#dc2626'
});
<?php unset($_SESSION['flash_error']); endif; ?>
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
