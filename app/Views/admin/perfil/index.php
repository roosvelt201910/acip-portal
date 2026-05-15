<?php
$avatar = !empty($user['avatar']) ? asset($user['avatar']) : "https://ui-avatars.com/api/?name=" . urlencode($user['nombre']) . "&background=6366f1&color=ffffff&bold=true&size=128";
?>

<?php ob_start(); ?>

<style>
    .profile-page {
        min-height: calc(100vh - 80px);
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
        padding: 24px;
    }
    
    /* Profile Summary Card */
    .profile-summary {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
        border-radius: 20px;
        padding: 32px 24px;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px -12px rgba(99, 102, 241, 0.4);
    }
    
    .profile-summary::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    }
    
    .profile-summary::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -30%;
        width: 60%;
        height: 60%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    }
    
    .avatar-container {
        position: relative;
        display: inline-block;
        z-index: 10;
    }
    
    .avatar-ring {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        padding: 4px;
        background: linear-gradient(135deg, rgba(255,255,255,0.8), rgba(255,255,255,0.3));
        display: inline-block;
    }
    
    .avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
    }
    
    .avatar-edit {
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6366f1;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    
    .avatar-edit:hover {
        transform: scale(1.1);
        background: #6366f1;
        color: white;
    }
    
    .user-name {
        font-size: 24px;
        font-weight: 700;
        margin-top: 20px;
        position: relative;
        z-index: 10;
    }
    
    .user-email {
        font-size: 14px;
        opacity: 0.9;
        margin-top: 4px;
        position: relative;
        z-index: 10;
    }
    
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: rgba(255,255,255,0.2);
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        margin-top: 16px;
        position: relative;
        z-index: 10;
        backdrop-filter: blur(10px);
    }
    
    /* Info Cards */
    .info-section {
        background: white;
        border-radius: 16px;
        padding: 20px;
        margin-top: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        border-radius: 12px;
        background: #f8fafc;
        margin-bottom: 12px;
        transition: all 0.2s ease;
    }
    
    .info-item:last-child { margin-bottom: 0; }
    .info-item:hover { background: #f1f5f9; transform: translateX(4px); }
    
    .info-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    
    .info-icon.blue { background: #dbeafe; color: #2563eb; }
    .info-icon.purple { background: #ede9fe; color: #7c3aed; }
    .info-icon.green { background: #dcfce7; color: #16a34a; }
    
    .info-label { font-size: 12px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
    .info-value { font-size: 15px; color: #1e293b; font-weight: 600; margin-top: 2px; }
    
    .status-active {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        background: #dcfce7;
        color: #16a34a;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .status-active::before {
        content: '';
        width: 6px;
        height: 6px;
        background: currentColor;
        border-radius: 50%;
        animation: blink 1.5s infinite;
    }
    
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }
    
    /* Form Card */
    .form-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    
    .form-header {
        padding: 24px 28px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .form-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .form-subtitle {
        font-size: 14px;
        color: #64748b;
        margin-top: 4px;
    }
    
    .form-body { padding: 28px; }
    
    .section-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
    }
    
    .section-label i { color: #6366f1; }
    .section-label::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }
    
    .form-group { margin-bottom: 20px; }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    
    .form-label .required { color: #ef4444; }
    
    .input-wrapper {
        position: relative;
    }
    
    .input-wrapper i.input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        transition: color 0.2s ease;
    }
    
    .form-control {
        width: 100%;
        padding: 14px 16px 14px 48px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
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
    
    .form-control:focus + i.input-icon,
    .input-wrapper:focus-within i.input-icon { color: #6366f1; }
    
    .password-toggle {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 4px;
    }
    
    .password-toggle:hover { color: #6366f1; }
    
    .info-box {
        display: flex;
        gap: 12px;
        padding: 16px;
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-radius: 12px;
        margin-bottom: 24px;
        border: 1px solid #fcd34d;
    }
    
    .info-box i { color: #d97706; font-size: 18px; flex-shrink: 0; margin-top: 2px; }
    .info-box p { color: #92400e; font-size: 14px; line-height: 1.5; }
    
    .form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding: 20px 28px;
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
        transition: all 0.2s ease;
        border: none;
    }
    
    .btn-cancel {
        background: white;
        color: #64748b;
        border: 2px solid #e5e7eb;
    }
    
    .btn-cancel:hover { background: #f8fafc; border-color: #cbd5e1; }
    
    .btn-save {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5);
    }
    
    /* Alerts */
    .alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
    }
    
    .alert-success { background: #dcfce7; color: #166534; }
    .alert-error { background: #fee2e2; color: #991b1b; }
    .alert i { font-size: 20px; }
    
    /* Responsive Grid */
    .profile-grid {
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 24px;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    @media (max-width: 1024px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="profile-page">
    <!-- Alerts -->
    <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="alert alert-success" style="max-width: 1400px; margin: 0 auto 20px;">
            <i class="fas fa-check-circle"></i>
            <span><?= $_SESSION['flash_success'] ?></span>
        </div>
        <?php unset($_SESSION['flash_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_errors'])): ?>
        <div class="alert alert-error" style="max-width: 1400px; margin: 0 auto 20px;">
            <i class="fas fa-exclamation-circle"></i>
            <div><?php foreach ($_SESSION['flash_errors'] as $e): ?><p><?= $e ?></p><?php endforeach; ?></div>
        </div>
        <?php unset($_SESSION['flash_errors']); ?>
    <?php endif; ?>

    <div class="profile-grid">
        <!-- Left Column: Profile Summary -->
        <div>
            <div class="profile-summary">
                <div class="avatar-container">
                    <div class="avatar-ring">
                        <img id="avatarPreview" src="<?= $avatar ?>" alt="Avatar" class="avatar-img">
                    </div>
                    <label for="avatarInput" class="avatar-edit">
                        <i class="fas fa-camera"></i>
                    </label>
                </div>
                <h2 class="user-name"><?= htmlspecialchars($user['nombre']) ?></h2>
                <p class="user-email"><?= htmlspecialchars($user['email']) ?></p>
                <span class="role-badge">
                    <i class="fas fa-shield-alt"></i>
                    <?= ucfirst($user['rol']) ?>
                </span>
            </div>
            
            <div class="info-section">
                <div class="info-item">
                    <div class="info-icon blue"><i class="fas fa-envelope"></i></div>
                    <div>
                        <p class="info-label">Correo Electrónico</p>
                        <p class="info-value"><?= htmlspecialchars($user['email']) ?></p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon purple"><i class="fas fa-calendar-alt"></i></div>
                    <div>
                        <p class="info-label">Miembro Desde</p>
                        <p class="info-value"><?= date('d M, Y', strtotime($user['created_at'])) ?></p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon green"><i class="fas fa-user-check"></i></div>
                    <div>
                        <p class="info-label">Estado de Cuenta</p>
                        <span class="status-active">Activo</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Edit Form -->
        <div class="form-card">
            <div class="form-header">
                <div>
                    <h3 class="form-title">Editar Perfil</h3>
                    <p class="form-subtitle">Actualiza tu información personal y credenciales de acceso</p>
                </div>
            </div>
            
            <form action="<?= url('admin/perfil/update') ?>" method="POST" enctype="multipart/form-data">
                <input type="file" name="avatar" id="avatarInput" class="hidden" style="display:none" accept="image/*" onchange="previewAvatar(this)">
                
                <div class="form-body">
                    <!-- Personal Info Section -->
                    <div class="section-label">
                        <i class="fas fa-user"></i>
                        Información Personal
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">Nombre Completo <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <input type="text" name="nombre" value="<?= htmlspecialchars($user['nombre']) ?>" 
                                       class="form-control" placeholder="Ingresa tu nombre" required>
                                <i class="fas fa-user input-icon"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Correo Electrónico <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" 
                                       class="form-control" placeholder="correo@ejemplo.com" required>
                                <i class="fas fa-envelope input-icon"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Security Section -->
                    <div class="section-label" style="margin-top: 32px;">
                        <i class="fas fa-lock"></i>
                        Seguridad
                    </div>
                    
                    <div class="info-box">
                        <i class="fas fa-info-circle"></i>
                        <p>Deja los campos de contraseña en blanco si no deseas modificar tu contraseña actual. La nueva contraseña debe tener al menos 6 caracteres.</p>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">Nueva Contraseña</label>
                            <div class="input-wrapper">
                                <input type="password" name="password" id="password" class="form-control" 
                                       placeholder="••••••••" minlength="6" style="padding-right: 48px;">
                                <i class="fas fa-lock input-icon"></i>
                                <button type="button" class="password-toggle" onclick="togglePass('password')">
                                    <i class="fas fa-eye" id="password-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirmar Contraseña</label>
                            <div class="input-wrapper">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" 
                                       placeholder="••••••••" minlength="6" style="padding-right: 48px;">
                                <i class="fas fa-key input-icon"></i>
                                <button type="button" class="password-toggle" onclick="togglePass('confirm_password')">
                                    <i class="fas fa-eye" id="confirm_password-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-footer">
                    <button type="button" onclick="history.back()" class="btn btn-cancel">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
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

function togglePass(id) {
    const input = document.getElementById(id);
    const eye = document.getElementById(id + '-eye');
    if (input.type === 'password') {
        input.type = 'text';
        eye.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        eye.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>

<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../../layouts/admin.php'; ?>