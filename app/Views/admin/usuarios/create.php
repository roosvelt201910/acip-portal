<?php 
$old = $_SESSION['flash_old'] ?? [];
unset($_SESSION['flash_old']);
?>

<?php ob_start(); ?>

<style>
    .form-page { max-width: 800px; margin: 0 auto; }
    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .form-header {
        padding: 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .form-header a {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        border-radius: 10px;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .form-header a:hover { background: #e2e8f0; }
    .form-title { font-size: 20px; font-weight: 700; color: #1e293b; }
    
    .form-body { padding: 24px; }
    
    .form-group { margin-bottom: 20px; }
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    .form-label .required { color: #ef4444; }
    
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 15px;
        color: #1e293b;
        background: #f9fafb;
        transition: all 0.2s ease;
    }
    .form-control:focus {
        outline: none;
        border-color: #6366f1;
        background: white;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .avatar-upload {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .avatar-preview {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }
    .upload-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: #f1f5f9;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        color: #475569;
        transition: all 0.2s ease;
    }
    .upload-btn:hover { background: #e2e8f0; }
    
    .form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding: 20px 24px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        border: none;
        transition: all 0.2s ease;
    }
    .btn-cancel {
        background: white;
        color: #64748b;
        border: 2px solid #e5e7eb;
    }
    .btn-cancel:hover { background: #f8fafc; }
    .btn-save {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
    }
    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5); }
    
    .alert {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .alert-error { background: #fee2e2; color: #991b1b; }
</style>

<div class="form-page">
    <?php if (isset($_SESSION['flash_errors'])): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <?php foreach ($_SESSION['flash_errors'] as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        </div>
        <?php unset($_SESSION['flash_errors']); ?>
    <?php endif; ?>

    <div class="form-card">
        <div class="form-header">
            <a href="<?= url('admin/usuarios') ?>"><i class="fas fa-arrow-left"></i></a>
            <h2 class="form-title">Crear Nuevo Usuario</h2>
        </div>
        
        <form action="<?= url('admin/usuarios/store') ?>" method="POST" enctype="multipart/form-data">
            <div class="form-body">
                <!-- Avatar -->
                <div class="form-group">
                    <label class="form-label">Avatar</label>
                    <div class="avatar-upload">
                        <img id="avatarPreview" src="https://ui-avatars.com/api/?name=Nuevo+Usuario&background=6366f1&color=ffffff&size=160" alt="Avatar" class="avatar-preview">
                        <label class="upload-btn">
                            <i class="fas fa-upload"></i>
                            Subir imagen
                            <input type="file" name="avatar" accept="image/*" style="display:none" onchange="previewAvatar(this)">
                        </label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nombre Completo <span class="required">*</span></label>
                        <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($old['nombre'] ?? '') ?>" required placeholder="Nombre del usuario">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Correo Electrónico <span class="required">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required placeholder="correo@ejemplo.com">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Contraseña <span class="required">*</span></label>
                        <input type="password" name="password" class="form-control" required placeholder="Mínimo 6 caracteres" minlength="6">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Rol <span class="required">*</span></label>
                        <select name="rol" class="form-control" required>
                            <option value="usuario" <?= ($old['rol'] ?? '') === 'usuario' ? 'selected' : '' ?>>Usuario</option>
                            <option value="administrador" <?= ($old['rol'] ?? '') === 'administrador' ? 'selected' : '' ?>>Administrador</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="<?= url('admin/usuarios') ?>" class="btn btn-cancel">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-save">
                    <i class="fas fa-save"></i> Crear Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => document.getElementById('avatarPreview').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../../layouts/admin.php'; ?>
