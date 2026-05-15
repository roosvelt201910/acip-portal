<div class="header-actions">
    <h2>Administrar Enlaces Destacados</h2>
    <a href="<?= url('admin/enlaces/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Enlace
    </a>
</div>

<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Icono</th>
                <th>Título</th>
                <th>Enlace</th>
                <th>Orden</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($enlaces)): ?>
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px;">No hay enlaces registrados.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($enlaces as $item): ?>
                <tr>
                    <td>
                        <?php if ($item['icono']): ?>
                        <img src="<?= url(e($item['icono'])) ?>" alt="Icono" style="width: 40px; height: 40px; object-fit: contain;">
                        <?php else: ?>
                        <div style="width: 40px; height: 40px; background: #eee; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                            <i class="fas fa-link" style="color: #ccc;"></i>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= e($item['titulo']) ?></strong></td>
                    <td><a href="<?= e($item['enlace']) ?>" target="_blank" style="color: #666; font-size: 0.9em;"><?= e($item['enlace']) ?></a></td>
                    <td><?= e($item['orden']) ?></td>
                    <td>
                        <span class="badge <?= $item['estado'] === 'activo' ? 'badge-green' : 'badge-red' ?>">
                            <?= ucfirst(e($item['estado'])) ?>
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="<?= url('admin/enlaces/edit/' . $item['id']) ?>" class="action-btn" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= url('admin/enlaces/delete/' . $item['id']) ?>" class="action-btn" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este enlace?');" style="color: #d32f2f;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Vista Previa Slider -->
<div style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px;">
    <h3 style="margin-bottom: 20px; font-size: 18px; color: #333;">Vista Previa (Slider)</h3>
    <div class="preview-slider-container">
        <?php if (empty($enlaces)): ?>
            <p style="color: #666; font-style: italic;">No hay enlaces para previsualizar.</p>
        <?php else: ?>
            <div class="preview-slider">
                <?php foreach ($enlaces as $item): ?>
                    <?php if ($item['estado'] === 'activo'): ?>
                    <div class="preview-slide">
                        <a href="<?= e($item['enlace']) ?>" target="_blank" class="preview-card" title="<?= e($item['titulo']) ?>">
                            <?php if ($item['icono']): ?>
                                <img src="<?= url(e($item['icono'])) ?>" alt="<?= e($item['titulo']) ?>">
                            <?php else: ?>
                                <i class="fas fa-link" style="font-size: 24px; color: #ccc;"></i>
                                <span style="font-size: 12px; margin-top: 5px; color: #666; text-align: center;"><?= e($item['titulo']) ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .preview-slider-container {
        width: 100%;
        overflow: hidden;
        padding: 10px 0;
    }
    
    .preview-slider {
        display: flex;
        /* gap removed, using padding in slide */
        overflow-x: hidden; /* Hide scrollbar for slider effect */
        padding-bottom: 20px;
    }
    
    .preview-slide {
        flex: 0 0 20%; /* 5 items per view */
        padding: 0 10px;
        box-sizing: border-box;
        display: flex;
        justify-content: center;
    }
    
    .preview-card {
        width: 100%;
        height: 100px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid #f0f0f0;
        overflow: hidden;
        padding: 15px;
    }
    
    .preview-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .preview-card img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sliderContainer = document.querySelector('.preview-slider-container');
    if (!sliderContainer) return;

    const track = sliderContainer.querySelector('.preview-slider');
    let slides = track.querySelectorAll('.preview-slide'); // target slides now
    
    // Clone logic for infinite loop
    if (slides.length > 0) {
        const minSlides = 10;
        let currentCount = slides.length;
        
        if (currentCount < minSlides) {
            while (currentCount < minSlides) {
                points: for (let i = 0; i < slides.length; i++) {
                    if (currentCount >= minSlides) break points;
                    const clone = slides[i].cloneNode(true);
                    track.appendChild(clone);
                    currentCount++;
                }
            }
            slides = track.querySelectorAll('.preview-slide');
        }
    }
    
    let currentIndex = 0;
    let autoPlayInterval;

    function updateSliderPosition() {
        if (slides.length === 0) return;
        const slideWidth = slides[0].offsetWidth; // Dynamic width
        track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }

    function startAutoPlay() {
        autoPlayInterval = setInterval(() => {
            currentIndex++;
            const maxIndex = slides.length - 5; // 5 items visible
            
            if (currentIndex > maxIndex) {
               currentIndex = 0;
               track.style.transition = 'none';
               updateSliderPosition();
               
               setTimeout(() => {
                   track.style.transition = 'transform 0.5s ease';
                   currentIndex = 1;
                   updateSliderPosition();
               }, 20);
               return;
            }
            
            updateSliderPosition();
            
        }, 3000);
    }
    
    // Initial style setup
    track.style.transition = 'transform 0.5s ease';
    
    // Handle Window Resize to recalculate widths
    window.addEventListener('resize', () => {
         updateSliderPosition();
    });
    
    startAutoPlay();
});
</script>
