<?php ob_start(); ?>

<section class="section">
    <div class="container">
        <!-- Header Section -->
        <div class="reclamaciones-header">
            <div class="header-left">
                <div class="blue-line-decoration"></div>
                <h1>LIBRO DE RECLAMACIONES</h1>
                <div class="blue-line-decoration-small"></div>
                
                <p>Conforme A Lo Establecido En El Código De Protección Y Defensa Del Consumidor (Ley N° 29571),<br>
                Nuestra Institución Cuenta Con El Libro De Reclamaciones Virtual A Su Disposición.</p>
                
                <div class="book-illustration">
                    <!-- Book SVG -->
                    <!-- Book Image -->
                    <img src="<?= url('assets/images/img_libro_reclamaciones-1.jpg') ?>" alt="Libro de Reclamaciones" style="width: 350px; max-width: 100%;">
                </div>
            </div>
            <div class="header-right">
                <div class="info-item">
                    <div class="info-content">
                        <h3>¿Qué Es Un Reclamo</h3>
                        <p>Se realiza cuando el consumidor no se encuentra conforme con el producto adquirido o con el servicio recibido.</p>
                    </div>
                    <div class="info-icon">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                <div class="info-item">
                     <div class="info-content">
                        <h3>¿Qué Es Una Queja?</h3>
                        <p>Malestar o descontento por algo que está relacionado directamente al producto o servicio comprado o se refiere a una mala atención al público. Puedes registrar tu reclamo, las 24 horas del día, los 7 días de la semana, pero ten en cuenta que si registras tu reclamo fuera de horario laboral será registrado al día hábil siguiente para el inicio de su trámite.</p>
                    </div>
                     <div class="info-icon">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin: 40px 0;">
            <h3 style="color: #ef4444; font-size: 1.1rem; margin-bottom: 10px; font-weight: 600;">¿Cómo presentarlo?</h3>
            <p style="color: #000; font-weight: 500;">Para el registro de tu reclamo o queja debe completar el siguiente formulario:</p>
        </div>

        <form action="<?= url('libro-reclamaciones') ?>" method="POST" class="reclamaciones-form">
            
            <!-- Section 1 -->
            <div class="form-section">
                <h3 class="form-section-title">Identificación del Consumidor Reclamante</h3>
                
                <div class="form-grid">
                    <!-- Contacto Select -->
                    <div class="form-group icon-input select-box">
                        <i class="far fa-list-alt input-icon"></i>
                        <label class="floating-label-select">Contacto <span class="text-danger">*</span></label>
                        <select name="tipo_contacto" class="form-control" required>
                            <option value="">Seleccione item</option>
                            <option value="publico">Público general</option>
                            <option value="alumno">Alumno</option>
                            <option value="egresado">Egresado</option>
                            <option value="familiar">Familiar</option>
                        </select>
                    </div>

                    <div class="form-group icon-input">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="nombres" placeholder="Apellidos y nombres *" class="form-control" required>
                    </div>

                    <div class="form-group icon-input">
                         <i class="far fa-envelope input-icon"></i>
                        <input type="email" name="email" placeholder="Correo *" class="form-control" required>
                    </div>

                    <!-- Documento Select -->
                    <div class="form-group icon-input select-box">
                         <i class="far fa-id-card input-icon"></i>
                         <label class="floating-label-select">Documento <span class="text-danger">*</span></label>
                        <select name="tipo_documento" class="form-control" required>
                            <option value="">Seleccione item</option>
                            <option value="DNI">DNI</option>
                            <option value="CE">Carnet Extranjería</option>
                        </select>
                    </div>

                    <div class="form-group icon-input">
                        <i class="fas fa-fingerprint input-icon"></i> <!-- Icono aproximado para N° doc -->
                        <input type="text" name="numero_documento" placeholder="N° Documento *" class="form-control" required>
                    </div>
                    
                    <div class="form-group icon-input">
                        <i class="fas fa-phone-alt input-icon"></i>
                        <input type="tel" name="telefono" placeholder="Teléfono/celular *" class="form-control" required>
                    </div>

                    <div class="form-group icon-input full-width">
                         <i class="fas fa-user input-icon"></i>
                        <input type="text" name="domicilio" placeholder="Domicilio *" class="form-control" required>
                    </div>

                     <div class="form-group icon-input full-width" id="parent-field" style="display: none;">
                        <i class="fas fa-user-friends input-icon"></i>
                        <input type="text" name="apoderado" id="apoderado-input" placeholder="Padre o Madre *" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Section 2 -->
            <div class="form-section">
                <h3 class="form-section-title">Detalle de reclamación y pedido del consumidor</h3>
                
                <div class="form-group icon-input full-width select-box">
                    <i class="fas fa-list-ul input-icon"></i>
                    <label class="floating-label-select">Tipo de reclamo <span class="text-danger">*</span></label>
                    <select name="tipo_reclamo" class="form-control" required>
                        <option value="">Seleccione item</option>
                        <option value="reclamo">Reclamo</option>
                        <option value="queja">Queja</option>
                    </select>
                </div>
                
                <p class="form-note">(*) Disconformidad no relacionada a los productos o servicios; o, malestar o descontento respecto a la atención al público</p>

                <div class="form-group icon-input full-width">
                    <i class="far fa-edit input-icon textarea-icon"></i>
                    <textarea name="detalle" placeholder="Detalle *" rows="4" class="form-control" required></textarea>
                </div>

                <div class="form-group icon-input full-width">
                    <i class="far fa-edit input-icon textarea-icon"></i>
                    <textarea name="pedido" placeholder="Pedido *" rows="4" class="form-control" required></textarea>
                </div>
            </div>

             <div class="form-legal">
                <div class="legal-check">
                    <i class="fas fa-check-circle"></i>
                    <p>La formulación de reclamo no impide acudir a otras vías de solución de controversias ni es requisito previo para interponer una denuncia ante el INDECOPI.</p>
                </div>
                <div class="legal-check">
                     <i class="fas fa-check-circle"></i>
                    <p>El proveedor deberá dar respuesta al reclamo en un plazo no mayor a treinta (30) días calendario, pudiendo ampliar el plazo hasta por treinta (30) días más, previa comunicación al consumidor.</p>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Enviar</button>
        </form>
    </div>
</section>

<script>
// Toggle parent field based on contact type
document.addEventListener('DOMContentLoaded', function() {
    const tipoContactoSelect = document.querySelector('select[name="tipo_contacto"]');
    const parentField = document.getElementById('parent-field');
    const apoderadoInput = document.getElementById('apoderado-input');
    
    if (tipoContactoSelect) {
        tipoContactoSelect.addEventListener('change', function() {
            const selectedValue = this.value.toLowerCase();
            
            // Show field only for "alumno" or "familiar"
            if (selectedValue === 'alumno' || selectedValue === 'familiar') {
                parentField.style.display = 'block';
                apoderadoInput.setAttribute('required', 'required');
            } else {
                parentField.style.display = 'none';
                apoderadoInput.removeAttribute('required');
                apoderadoInput.value = ''; // Clear value when hidden
            }
        });
    }
});
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_SESSION['success']) && isset($_SESSION['show_pdf_download'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: '¡Reclamo Registrado!',
    html: '<p style="font-size: 1.1rem; margin: 15px 0;"><?= $_SESSION['success'] ?></p><p style="color: #666; margin-top: 10px;">Puede ver e imprimir su constancia haciendo clic en el botón de abajo.</p>',
    showCancelButton: true,
    confirmButtonText: '<i class="fas fa-file-alt"></i> Ver Constancia',
    cancelButtonText: 'Cerrar',
    confirmButtonColor: '#667eea',
    cancelButtonColor: '#6c757d',
    customClass: {
        confirmButton: 'swal-btn-download',
        cancelButton: 'swal-btn-close'
    }
}).then((result) => {
    if (result.isConfirmed) {
        window.open('<?= url('libro-reclamaciones/pdf') ?>', '_blank');
    }
});
</script>
<?php 
    unset($_SESSION['success']);
    unset($_SESSION['show_pdf_download']);
endif; 
?>

<?php if (isset($_SESSION['error'])): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: '<?= $_SESSION['error'] ?>',
    confirmButtonColor: '#dc3545'
});
</script>
<?php 
    unset($_SESSION['error']);
endif; 
?>

<style>
.swal-btn-download, .swal-btn-close {
    padding: 12px 24px !important;
    font-size: 1rem !important;
    border-radius: 8px !important;
    font-weight: 500 !important;
}
</style>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php';
?>
