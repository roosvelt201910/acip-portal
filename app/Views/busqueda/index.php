<?php ob_start(); ?>

<section class="section header-page">
    <div class="container">
        <h1>Resultados de Búsqueda</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (!empty($query)): ?>
            <p>Resultados para: <strong><?= e($query) ?></strong></p>
            
            <?php if (!empty($resultados)): ?>
                <div class="search-results">
                    <?php foreach ($resultados as $resultado): ?>
                    <div class="card" style="padding: 20px; margin-bottom: 20px;">
                        <h3>
                            <a href="<?= url($resultado['slug']) ?>" style="text-decoration: none; color: var(--color-primary);">
                                <?= e($resultado['titulo']) ?>
                            </a>
                        </h3>
                        <span class="badge" style="background: #eee; color: #666; font-size: 0.8rem;">
                            <?= ucfirst($resultado['tipo']) ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No se encontraron resultados.</p>
            <?php endif; ?>
            
        <?php else: ?>
            <p>Ingresa un término para buscar.</p>
        <?php endif; ?>
    </div>
</section>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php';
?>
