<?php ob_start(); ?>
<div class="header-container">
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Inicio</a>
        <span>/</span>
        <a href="<?= url('admin/menus') ?>">Menús</a>
        <span>/</span>
        <a href="<?= url('admin/menus/gestionar/' . $menu['id']) ?>"><?= e($menu['nombre']) ?></a>
        <span>/</span>
        <span class="current">Nuevo Enlace</span>
    </div>
</div>

<div class="card-enterprise">
    <div class="card-header-enterprise">
        <h2><i class="fas fa-plus"></i> Nuevo Elemento de Menú</h2>
    </div>

    <form action="<?= url('admin/menus/crear-item/' . $menu['id']) ?>" method="POST">
        <div class="form-grid">
            <div class="form-column">
                <div class="form-group">
                    <label class="label-enterprise">Título del Enlace <span class="required">*</span></label>
                    <div class="input-group-enterprise">
                        <i class="fas fa-font"></i>
                        <input type="text" name="titulo" class="input-enterprise" placeholder="Ej: Nosotros" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="label-enterprise">URL de Destino <span class="required">*</span></label>
                    <div class="input-group-enterprise">
                        <i class="fas fa-link"></i>
                        <input type="text" name="url" class="input-enterprise" placeholder="Ej: /nosotros" required>
                    </div>
                    <p class="file-info">Usa /ruta para internos, http://... para externos.</p>
                </div>
            </div>

            <div class="form-column">
                <div class="form-group">
                    <label class="label-enterprise">Elemento Padre (Opcional)</label>
                    <div class="input-group-enterprise">
                        <i class="fas fa-level-up-alt"></i>
                        <select name="parent_id" class="input-enterprise">
                            <option value="">-- Ninguno (Raíz) --</option>
                            <?php foreach ($parents as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= e($p['titulo']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <p class="file-info">Selecciona si este enlace debe aparecer dentro de un desplegable.</p>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="label-enterprise">Orden</label>
                            <input type="number" name="orden" class="input-enterprise" value="0">
                        </div>
                    </div>
                </div>
                
                <div class="form-group" style="margin-top: 25px;">
                     <label class="checkbox-container">
                        <input type="checkbox" name="activo" checked>
                        <span class="checkmark"></span>
                        <span class="checkbox-label">Visible en el menú</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= url('admin/menus/gestionar/' . $menu['id']) ?>" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-enterprise">
                <i class="fas fa-save mr-2"></i> Guardar Elemento
            </button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
