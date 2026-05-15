<?php
// Fix for Reclamaciones Table - Add missing columns
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/includes/Database.php';

$db = Database::getInstance();

echo "<h1>Actualizando Base de Datos...</h1>";

try {
    // 1. Add 'domicilio' if not exists
    $db->query("ALTER TABLE reclamaciones ADD COLUMN IF NOT EXISTS domicilio TEXT AFTER telefono");
    echo "✅ Columna 'domicilio' verificada/agregada.<br>";

    // 2. Add 'tipo_contacto'
    $db->query("ALTER TABLE reclamaciones ADD COLUMN IF NOT EXISTS tipo_contacto VARCHAR(50) AFTER id");
    echo "✅ Columna 'tipo_contacto' verificada/agregada.<br>";

    // 3. Add 'apoderado'
    $db->query("ALTER TABLE reclamaciones ADD COLUMN IF NOT EXISTS apoderado VARCHAR(255) AFTER domicilio");
    echo "✅ Columna 'apoderado' verificada/agregada.<br>";

    // 4. Add 'pedido'
    $db->query("ALTER TABLE reclamaciones ADD COLUMN IF NOT EXISTS pedido TEXT AFTER detalle");
    echo "✅ Columna 'pedido' verificada/agregada.<br>";

    echo "<h3 style='color:green'>¡Actualización completada con éxito!</h3>";
    echo "<p>Ahora puede intentar enviar el reclamo nuevamente.</p>";
    echo "<a href='libro-reclamaciones'>Volver al formulario</a>";

} catch (Exception $e) {
    echo "<h3 style='color:red'>Error: " . $e->getMessage() . "</h3>";
}
