

<div class="header-container">
    <h2 class="page-title">Modalidades: <?= e($proceso['titulo']) ?></h2>
    <div class="breadcrumb">
        <a href="<?= url('admin/dashboard') ?>">Dashboard</a> / 
        <a href="<?= url('admin/admision') ?>">Admisión</a> / 
        <span>Modalidades</span>
    </div>
</div>

<div class="row">
    <!-- Formulario (Full Width) -->
    <div class="col-12 mb-4">
        <div class="card-enterprise">
            <div class="card-header-enterprise">
                <h3><i class="fas fa-plus-circle"></i> Agregar Modalidad</h3>
            </div>
            <div class="card-body-enterprise">
                <form action="<?= url('admin/admision/storeModalidad/' . $proceso['id']) ?>" method="POST">
                    
                    <div class="form-group-enterprise">
                        <label>Título de la Modalidad</label>
                        <input type="text" name="titulo" class="input-enterprise" required placeholder="Ej: Examen Ordinario">
                    </div>

                    <div class="form-group-enterprise">
                        <label>Descripción (Opcional)</label>
                        <textarea name="descripcion" id="editor_modalidad" rows="4" class="input-enterprise" placeholder="Breve descripción..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group-enterprise">
                                <label>Orden</label>
                                <input type="number" name="orden" value="0" class="input-enterprise">
                            </div>
                        </div>
                        <div class="col-md-10 d-flex align-items-end">
                            <div class="form-group-enterprise w-100">
                                <button type="submit" class="btn-enterprise btn-primary-enterprise w-100">
                                    <i class="fas fa-save"></i> Guardar Modalidad
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Lista -->
    <div class="col-12">
        <div class="card-enterprise">
            <div class="card-header-enterprise">
                <h3><i class="fas fa-list-ul"></i> Lista de Modalidades</h3>
            </div>
            <div class="card-body-enterprise p-0">
                <div class="table-responsive">
                    <table class="table-enterprise">
                        <thead>
                            <tr>
                                <th width="80" class="text-center">Orden</th>
                                <th>Modalidad</th>
                                <th>Descripción (Vista Previa)</th>
                                <th width="100" class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($modalidades as $mod): ?>
                            <tr>
                                <td class="text-center"><span class="badge-enterprise badge-gray"><?= $mod['orden'] ?></span></td>
                                <td>
                                    <strong><?= e($mod['titulo']) ?></strong>
                                </td>
                                <td>
                                    <!-- Truncated preview ignoring tags -->
                                    <?= truncate(strip_tags($mod['descripcion']), 100) ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= url('admin/admision/deleteModalidad/' . $mod['id']) ?>" class="btn-icon-enterprise btn-delete" onclick="return confirm('¿Eliminar esta modalidad?')" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                            <?php if (empty($modalidades)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="fas fa-clipboard-list fa-2x mb-2"></i><br>
                                        No hay modalidades registradas.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CKEditor 4 Full -->
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('editor_modalidad', {
                versionCheck: false,
                height: 300,
                // Ensure nice styling matching the theme
                contentsCss: [
                    'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css',
                    'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial; font-size: 16px; padding: 15px; }'
                ],
                // Full toolbar configuration
                toolbar: [
                    { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                    { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                    { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                    { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                    '/',
                    { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                    { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
                    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                    { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'Video' ] },
                    '/',
                    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                    { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                    { name: 'about', items: [ 'About' ] }
                ],
                extraPlugins: 'justify,font,colorbutton,iframe' 
            });
        }
    });
</script>

<style>
/* Enterprise Design System */
:root {
    --primary-color: #2563eb;
    --primary-hover: #1d4ed8;
    --text-dark: #1e293b;
    --text-muted: #64748b;
    --border-color: #e2e8f0;
    --bg-light: #f8fafc;
}

.header-container { margin-bottom: 2rem; }
.page-title { font-size: 1.5rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem; }
.breadcrumb { font-size: 0.9rem; color: var(--text-muted); background: transparent; padding: 0; }
.breadcrumb a { color: var(--primary-color); text-decoration: none; }

/* Use Flex layout similar to requirements */
.row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
.col-12 {
    flex: 0 0 100%;
    max-width: 100%;
    padding-right: 15px;
    padding-left: 15px;
}
.col-md-2 {
    flex: 0 0 16.666667%;
    max-width: 16.666667%;
    padding-right: 15px;
    padding-left: 15px;
}
.col-md-10 {
    flex: 0 0 83.333333%;
    max-width: 83.333333%;
    padding-right: 15px;
    padding-left: 15px;
}
.d-flex { display: flex; }
.align-items-end { align-items: flex-end; }
.mb-4 { margin-bottom: 1.5rem; }

.card-enterprise {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}
.card-enterprise:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
}
.card-header-enterprise {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    background: white;
}
.card-header-enterprise h3 {
    margin: 0; font-size: 1.1rem; font-weight: 600; color: var(--text-dark); display: flex; align-items: center; gap: 0.5rem;
}
.card-header-enterprise h3 i { color: var(--primary-color); }

.card-body-enterprise { padding: 1.5rem; }
.card-body-enterprise.p-0 { padding: 0; }

.form-group-enterprise { margin-bottom: 1.25rem; }
.form-group-enterprise label {
    display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-dark); font-size: 0.95rem;
}

.input-enterprise, .select-enterprise {
    width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.95rem; color: var(--text-dark); background-color: #fff; transition: all 0.2s;
}
.input-enterprise:focus, .select-enterprise:focus {
    outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}
textarea.input-enterprise { resize: vertical; min-height: 100px; }

.btn-enterprise {
    display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500; font-size: 0.95rem; cursor: pointer; transition: all 0.2s; border: none; gap: 0.5rem;
}
.btn-primary-enterprise { background-color: var(--primary-color); color: white; }
.btn-primary-enterprise:hover { background-color: var(--primary-hover); transform: translateY(-1px); }
.w-100 { width: 100%; }

/* Table Styles */
.table-responsive { overflow-x: auto; }
.table-enterprise { width: 100%; border-collapse: collapse; }
.table-enterprise th {
    background-color: var(--bg-light); color: var(--text-muted); font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; padding: 1rem 1.5rem; text-align: left; border-bottom: 1px solid var(--border-color);
}
.table-enterprise td {
    padding: 1rem 1.5rem; border-bottom: 1px solid var(--border-color); color: var(--text-dark); vertical-align: middle;
}
.table-enterprise tr:last-child td { border-bottom: none; }
.table-enterprise tr:hover td { background-color: #f8fafc; }

.badge-enterprise {
    display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;
}
.badge-gray { background-color: #f1f5f9; color: #475569; }

.btn-icon-enterprise {
    width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; transition: all 0.2s; color: var(--text-muted); background: transparent; border: none; cursor: pointer;
}
.btn-icon-enterprise:hover { background-color: #f1f5f9; color: var(--text-dark); }
.btn-delete:hover { background-color: #fee2e2; color: #ef4444; }
</style>

