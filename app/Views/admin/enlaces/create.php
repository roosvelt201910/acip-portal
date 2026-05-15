<div class="header-actions">
    <h2>Nuevo Enlace Destacado</h2>
    <a href="<?= url('admin/enlaces') ?>" class="btn btn-secondary" style="background: #6c757d; color: white;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="card" style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
    <form action="<?= url('admin/enlaces/store') ?>" method="POST" enctype="multipart/form-data" class="form-grid">
        <div class="form-group span-2">
            <label for="titulo">Título *</label>
            <input type="text" id="titulo" name="titulo" class="form-control" required placeholder="Ej. Biblioteca Virtual">
        </div>

        <div class="form-group span-2">
            <label for="enlace">Enlace URL *</label>
            <input type="url" id="enlace" name="enlace" class="form-control" required placeholder="https://...">
        </div>

        <div class="form-group span-2">
            <label for="descripcion">Descripción Corta</label>
            <textarea id="descripcion" name="descripcion" class="form-control" rows="2" placeholder="Breve descripción del recurso..."></textarea>
        </div>

        <div class="form-group">
            <label for="icono">Icono / Imagen</label>
            <input type="file" id="icono" name="icono" class="form-control" accept="image/*">
            <div class="help-text" style="font-size: 0.85em; color: #666; margin-top: 5px;">Recomendado: PNG/SVG transparente (64x64px)</div>
        </div>

        <div class="form-group">
            <label for="orden">Orden de Visualización</label>
            <input type="number" id="orden" name="orden" class="form-control" value="0">
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" class="form-control">
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>

        <div class="form-group span-2" style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar Enlace
            </button>
        </div>
    </form>
</div>

<style>
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .span-2 {
        grid-column: span 2;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .form-control {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    label {
        font-weight: 500;
        font-size: 14px;
        color: #333;
    }
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .span-2 {
            grid-column: span 1;
        }
    }
</style>
