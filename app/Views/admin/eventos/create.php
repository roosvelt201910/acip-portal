<?php ob_start(); ?>

<div class="header-container">
    <h2 class="page-title">Nuevo Evento</h2>
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Dashboard</a> / 
        <a href="<?= url('admin/eventos') ?>">Eventos</a> / 
        <span>Nuevo</span>
    </div>
</div>

<div class="card-enterprise">
    <form action="<?= url('admin/eventos/crear') ?>" method="POST">
        <div class="form-grid">
            <div class="form-group span-2">
                <label for="titulo" class="form-label">Título del Evento</label>
                <input type="text" id="titulo" name="titulo" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="fecha_inicio" class="form-label">Fecha y Hora de Inicio</label>
                <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <input type="text" id="ubicacion" name="ubicacion" class="form-control">
            </div>
            
            <div class="form-group span-2">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="4"></textarea>
            </div>
            
            <div class="form-group">
                <label class="checkbox-container">
                    <input type="checkbox" name="activo" value="1" checked>
                    <span class="checkmark"></span>
                    Activo (Visible en la web)
                </label>
            </div>
        </div>
        
        <div class="form-actions">
            <a href="<?= url('admin/eventos') ?>" class="btn-enterprise btn-secondary">Cancelar</a>
            <button type="submit" class="btn-enterprise">
                <i class="fas fa-save"></i> Guardar Evento
            </button>
        </div>
    </form>
</div>

<?php
$extraJS = '
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector("#descripcion"), {
            toolbar: ["heading", "|", "bold", "italic", "link", "bulletedList", "numberedList", "blockQuote", "|", "insertTable", "mediaEmbed", "|", "undo", "redo"],
            language: "es"
        })
        .catch(error => {
            console.error(error);
        });
</script>
';
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/admin.php';
?>
