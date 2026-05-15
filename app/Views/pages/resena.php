<?php ob_start(); ?>

<!-- Page Hero -->
<?php 
    // Hero configuration
    $heroTitle = "Reseña Histórica";
    $heroSubtitle = "Conoce nuestra historia y trayectoria institucional";
    // Retro Dark Gradient
    $heroStyle = "background: linear-gradient(to bottom, #1a1a2e, #16213e, #0f3460);";
?>

<section class="page-hero retro-hero" style="position: relative; overflow: hidden; color: white; display: flex; align-items: center; min-height: 400px; <?= $heroStyle ?>">
    
    <!-- Retro Animation Layer -->
    <div class="retro-grid"></div>
    <div class="retro-scanlines"></div>
    
    <div class="container" style="position: relative; z-index: 3; padding-top: 60px; padding-bottom: 60px;">
        <h1 class="retro-title" style="font-size: 3.5rem; font-weight: 800; margin-bottom: 15px; letter-spacing: -1px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);"><?= $heroTitle ?></h1>
        <p class="lead" style="opacity: 0.95; font-size: 1.5rem; font-weight: 300; max-width: 800px; text-shadow: 0 1px 2px rgba(0,0,0,0.3);"><?= $heroSubtitle ?></p>
    </div>
</section>

<style>
    /* Retro Hero Styles */
    .retro-hero {
        perspective: 1000px;
    }

    .retro-grid {
        position: absolute;
        width: 200%;
        height: 200%;
        bottom: -100%;
        left: -50%;
        background-image: 
            linear-gradient(#e94560 2px, transparent 2px), 
            linear-gradient(90deg, #e94560 2px, transparent 2px);
        background-size: 50px 50px;
        background-position: 0 0;
        transform: rotateX(45deg);
        animation: planeMove 2s linear infinite;
        opacity: 0.2;
        mask-image: linear-gradient(to top, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 80%);
        -webkit-mask-image: linear-gradient(to top, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 80%);
        z-index: 1;
    }

    .retro-scanlines {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            to bottom,
            rgba(255,255,255,0),
            rgba(255,255,255,0) 50%,
            rgba(0,0,0,0.1) 50%,
            rgba(0,0,0,0.1)
        );
        background-size: 100% 4px;
        z-index: 2;
        pointer-events: none;
    }

    .retro-title {
        text-shadow: 
            0 0 5px #e94560,
            0 0 10px #e94560,
            0 0 20px #e94560;
    }

    @keyframes planeMove {
        0% {
            transform: rotateX(45deg) translateY(0);
        }
        100% {
            transform: rotateX(45deg) translateY(50px);
        }
    }
</style>


<!-- Page Content -->
<section class="section page-content">
    <div class="container">
        <div class="card" style="padding: 40px; border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-radius: 16px;">
            <div class="content-body text-gray-700 leading-relaxed">
                
                <h2 style="color: var(--primary); font-size: 1.8rem; margin-top: 0; margin-bottom: 1.5rem; font-weight: 700; text-align: center;">
                    RESEÑA HISTÓRICA DEL INSTITUTO DE EDUCACIÓN SUPERIOR TECNOLÓGICO PRIVADO “ACIP”
                </h2>

                <p>
                    Los antecedentes del IESTP “ACIP”, se basa en lo que fuera el CEOGNE “ACIP COMPUTER”, creado con Resolución Directoral Nº 0313-92, siendo en ese entonces Directora de la Sub Región Huallaga Central la Prof. Ernestina Reyes de Vela.
                </p>

                <p>
                    El CEOGNE ACIP COMPUTER, inicia sus actividades educativas el 20-08-92. Iniciando sus actividades en el Jr. La Merced cuadra 5. Con un número de 26 alumnos, siendo su directora la Prof. Soraya Vela Pérez, docente Rolando Vela Tarazona y su promotor el Sr. José Vela Pérez.
                </p>

                <p>
                    En 1993 la sociedad del ACIP COMPUTER, se desintegra por razones económicas, dos de los socios venden sus acciones, un porcentaje al Prof. Rolando Vela Tarazona, continuando las actividades sin ningún inconveniente con un numero de 40 alumnos.
                </p>

                <p>
                    En 1993 en el mes de agosto se desintegra por segunda vez por motivos de salud de uno de los socios, el Prof. Rolando Vela Tarazona, el CEOGNE ACIP COMPUTER, cierra sus actividades por espacio de cinco meses.
                </p>

                <p>
                    En enero de 1994 el CEOGNE ACIP COMPUTER reinicia sus actividades al servicio de la población estudiantil, por un convenio entre el Prof. Rolando Vela Tarazona y el Sr. Bruno Acosta Vela, estas actividades se inician el 05-01-95 en otro local en el Jr. Huallaga cuadra 9, con un número de 65 alumnos.
                </p>

                <p>
                    En agosto de 1995 siendo su promotor Rolando Vela Tarazona, continúa sus actividades académicas en un nuevo local en el Jr. Triunfo con un total de 82 alumnos todos de especialidad de computación e informática.
                </p>

                <p>
                    En el año 2000, en el mes de setiembre el CEOGNE ACIP COMPUTER, amplia sus carreras técnicas, Guía Oficial de Turismo, Computación e Informática, Secretariado Ejecutivo, Inglés y Aviación Comercial.
                </p>

                <p>
                    En julio del 2003, el CEOGNE ACIP COMPUTER, apertura su propio local ubicado en el Jr. Progreso N° 547.
                </p>

                <p>
                    En enero del 2004, sigue desarrollando sus actividades educativas en las especialidades de Computación e Informática, Secretariado Ejecutivo e Inglés.
                </p>

                <p>
                    En agosto del 2007, el CEOGNE ACIP COMPUTER, Mediante Resolución Directoral Regional N° 00777-2007-DRESM, se convierte en CETPRO, con las siguientes especialidades: Operación en Computadoras y Asistente de Gerencia. Dado a las necesidades Educativas en nuestra Provincia de Mariscal Cáceres y contando con una infraestructura propia y adecuada para el trabajo técnico pedagógico, nos vemos en la imperiosa necesidad de ampliar el Servicio de Educación Básica Regular en el Nivel Primaria. Orientados a una Educación en Valores, de calidad y preparados para el éxito.
                </p>

                <p>
                    Basados en esta maravillosa experiencia, la promotora, toma la decisión de presentar el proyecto para la creación del INSTITUTO DE EDUCACIÓN SUPERIOR TECNOLÓGICO PRIVADO “ACIP”, autorizado a funcionar, mediante R.M.N°. 0258-2013-ED, con las Carreras Profesionales de Contabilidad y Secretariado Ejecutivo.
                </p>

            </div>
        </div>
    </div>
</section>

<style>
    .content-body p { margin-bottom: 1.2rem; font-size: 1.05rem; line-height: 1.8; text-align: justify; }
</style>

<?php
$content = ob_get_clean();
require APP_PATH . '/Views/layouts/main.php';
?>
