<?php ob_start(); ?>
<div class="header-container">
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Inicio</a>
        <span>/</span>
        <a href="<?= url('admin/menus') ?>">Menús</a>
        <span>/</span>
        <a href="<?= url('admin/menus/gestionar/' . $item['menu_id']) ?>">Gestión</a>
        <span>/</span>
        <span class="current">Editar Enlace</span>
    </div>
</div>

<div class="card-enterprise">
    <div class="card-header-enterprise">
        <h2><i class="fas fa-edit"></i> Editar Elemento: <?= e($item['titulo']) ?></h2>
    </div>

    <form action="<?= url('admin/menus/editar-item/' . $item['id']) ?>" method="POST">
        <div class="form-grid">
            <div class="form-column">
                <div class="form-group">
                    <label class="label-enterprise">Título del Enlace <span class="required">*</span></label>
                    <div class="input-group-enterprise">
                        <i class="fas fa-font"></i>
                        <input type="text" name="titulo" class="input-enterprise" value="<?= e($item['titulo']) ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="label-enterprise">URL de Destino <span class="required">*</span></label>
                    <div class="input-group-enterprise">
                        <i class="fas fa-link"></i>
                        <input type="text" name="url" class="input-enterprise" value="<?= e($item['url']) ?>" required>
                    </div>
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
                                <option value="<?= $p['id'] ?>" <?= $item['parent_id'] == $p['id'] ? 'selected' : '' ?>>
                                    <?= e($p['titulo']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="label-enterprise">Orden</label>
                            <input type="number" name="orden" class="input-enterprise" value="<?= e($item['orden']) ?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-group" style="margin-top: 25px;">
                     <label class="checkbox-container">
                        <input type="checkbox" name="activo" <?= $item['activo'] ? 'checked' : '' ?>>
                        <span class="checkmark"></span>
                        <span class="checkbox-label">Visible en el menú</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= url('admin/menus/gestionar/' . $item['menu_id']) ?>" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-enterprise">
                <i class="fas fa-save mr-2"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
