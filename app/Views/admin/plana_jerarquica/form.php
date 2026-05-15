<?php ob_start(); ?>

<div class="header-container d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title"><?= isset($miembro) ? 'Editar Miembro' : 'Nuevo Miembro' ?></h2>
        <div class="breadcrumb">
            <a href="<?= url('admin/dashboard') ?>">Dashboard</a> / 
            <a href="<?= url('admin/plana-jerarquica') ?>">Plana Jerárquica</a> / 
            <span><?= isset($miembro) ? 'Editar' : 'Nuevo' ?></span>
        </div>
    </div>
    <a href="<?= url('admin/plana-jerarquica') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="card bg-white shadow-sm border-0 rounded-lg">
    <div class="card-body">
        <form action="<?= isset($miembro) ? url('admin/plana-jerarquica/actualizar/' . $miembro['id']) : url('admin/plana-jerarquica/guardar') ?>" method="POST" enctype="multipart/form-data">
            
            <div class="row">
                <div class="col-md-8">
                    <!-- Información General -->
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" required value="<?= $miembro['nombre'] ?? '' ?>" placeholder="Ej: Dr. Juan Pérez">
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Cargo <span class="text-danger">*</span></label>
                        <input type="text" name="cargo" class="form-control" required value="<?= $miembro['cargo'] ?? '' ?>" placeholder="Ej: Director General">
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Categoría <span class="text-danger">*</span></label>
                        <select name="categoria" class="form-control" required>
                            <?php 
                            $categorias = [
                                'direccion' => 'Dirección General',
                                'plana_jerarquica' => 'Plana Jerárquica',
                                'coordinadores' => 'Coordinadores de Programas',
                                'unidades' => 'Unidades Institucionales'
                            ];
                            $currentCat = $miembro['categoria'] ?? 'plana_jerarquica';
                            foreach ($categorias as $key => $label): ?>
                                <option value="<?= $key ?>" <?= $currentCat === $key ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Correo Institucional</label>
                        <input type="email" name="email" class="form-control" value="<?= $miembro['email'] ?? '' ?>" placeholder="ejemplo@instituto.edu.pe">
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Imagen y Opciones -->
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Fotografía</label>
                        <div class="card bg-light border-0">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <?php if (isset($miembro) && $miembro['imagen']): ?>
                                        <img src="<?= url($miembro['imagen']) ?>" id="preview-image" class="rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                                    <?php else: ?>
                                        <div id="placeholder-image" class="rounded-circle bg-white d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 150px; height: 150px;">
                                            <i class="fas fa-user fa-4x text-muted"></i>
                                        </div>
                                        <img src="" id="preview-image" class="rounded-circle shadow-sm d-none" style="width: 150px; height: 150px; object-fit: cover;">
                                    <?php endif; ?>
                                </div>
                                <div class="custom-file">
                                    <label class="btn btn-outline-primary btn-sm btn-block cursor-pointer">
                                        <i class="fas fa-camera"></i> Seleccionar Foto
                                        <input type="file" name="imagen" class="d-none" accept="image/*" onchange="previewImage(this)">
                                    </label>
                                </div>
                                <small class="text-muted mt-2 d-block">JPG, PNG. Max 2MB.</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Orden de Visualización</label>
                        <input type="number" name="orden" class="form-control" value="<?= $miembro['orden'] ?? 0 ?>">
                        <small class="text-muted">Menor número aparece primero.</small>
                    </div>
                </div>
            </div>

            <div class="border-top pt-4 mt-2 text-right">
                <button type="submit" class="btn btn-primary px-5">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('preview-image').classList.remove('d-none');
            if(document.getElementById('placeholder-image')) {
                document.getElementById('placeholder-image').classList.add('d-none');
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
