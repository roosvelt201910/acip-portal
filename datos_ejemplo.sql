-- Datos de ejemplo para el Portal ACIP
-- Ejecutar después de la instalación inicial

USE acip_portal;

-- Insertar banners de ejemplo
INSERT INTO banners (titulo, descripcion, imagen, enlace, boton_texto, orden, activo) VALUES
('Bienvenidos al Instituto ACIP', 'Formando profesionales de excelencia comprometidos con el desarrollo del país', 'banner1.jpg', '/admision-2025', 'Proceso de Admisión', 1, 1),
('Admisión 2025 - Inscripciones Abiertas', 'Inicia tu camino profesional con nosotros. Conoce nuestros programas de estudio', '/programas', 'Ver Programas', 2, 1),
('Educación de Calidad', 'Contamos con docentes altamente calificados y moderna infraestructura', '/nosotros', 'Conócenos', 3, 1);

-- Insertar noticias de ejemplo
INSERT INTO noticias (titulo, resumen, contenido, imagen, slug, categoria, destacada, autor_id, estado, fecha_publicacion) VALUES
('Inicio del Proceso de Admisión 2025', 
 'El Instituto ACIP anuncia el inicio del proceso de admisión para el año académico 2025 en todas sus carreras profesionales.',
 '<p>El Instituto de Educación Superior Privado ACIP se complace en anunciar el inicio del <strong>Proceso de Admisión 2025</strong> para todas nuestras carreras profesionales.</p><p>Las inscripciones estarán abiertas desde el 15 de enero hasta el 28 de febrero de 2025.</p><h3>Requisitos:</h3><ul><li>Certificado de estudios secundarios</li><li>DNI original y copia</li><li>Partida de nacimiento</li><li>2 fotos tamaño carnet</li></ul><p>Para más información, visita nuestra oficina de admisión o contáctanos.</p>',
 'noticia1.jpg', 'inicio-proceso-admision-2025', 'institucional', 1, 1, 'publicado', NOW()),

('Ceremonia de Graduación 2024', 
 'Más de 200 estudiantes recibieron sus diplomas en emotiva ceremonia de graduación.',
 '<p>El pasado viernes 15 de diciembre se llevó a cabo la <strong>Ceremonia de Graduación 2024</strong> del Instituto ACIP, donde más de 200 estudiantes de las diferentes carreras profesionales recibieron sus diplomas.</p><p>El evento contó con la presencia de autoridades educativas, docentes, familiares y amigos de los graduados.</p><p>Felicitamos a todos nuestros egresados y les deseamos mucho éxito en su vida profesional.</p>',
 'noticia2.jpg', 'ceremonia-graduacion-2024', 'academica', 1, 1, 'publicado', DATE_SUB(NOW(), INTERVAL 5 DAY)),

('Convenio con Empresas del Sector Salud', 
 'ACIP firma convenio con importantes empresas del sector salud para prácticas profesionales.',
 '<p>El Instituto ACIP ha firmado un importante convenio con empresas líderes del sector salud para que nuestros estudiantes de <strong>Farmacia Técnica</strong> puedan realizar sus prácticas profesionales.</p><p>Este convenio beneficiará a más de 150 estudiantes que podrán adquirir experiencia laboral en farmacias y establecimientos de salud reconocidos.</p>',
 'noticia3.jpg', 'convenio-empresas-sector-salud', 'institucional', 1, 1, 'publicado', DATE_SUB(NOW(), INTERVAL 10 DAY)),

('Feria de Ciencias y Tecnología 2025', 
 'Estudiantes presentarán proyectos innovadores en la Feria de Ciencias y Tecnología.',
 '<p>El próximo 15 de marzo se realizará la <strong>Feria de Ciencias y Tecnología 2025</strong> donde estudiantes de todas las carreras presentarán sus proyectos innovadores.</p><p>La feria estará abierta al público en general y contará con demostraciones en vivo, exposiciones y talleres interactivos.</p>',
 'noticia4.jpg', 'feria-ciencias-tecnologia-2025', 'eventos', 0, 1, 'publicado', DATE_SUB(NOW(), INTERVAL 2 DAY));

-- Insertar eventos de ejemplo
INSERT INTO eventos (titulo, descripcion, contenido, imagen, fecha_inicio, fecha_fin, ubicacion, slug, autor_id, activo) VALUES
('Feria de Ciencias y Tecnología', 
 'Exposición de proyectos científicos y tecnológicos de estudiantes',
 '<p>Te invitamos a participar en nuestra Feria de Ciencias y Tecnología donde podrás conocer los proyectos innovadores desarrollados por nuestros estudiantes.</p>',
 'evento1.jpg', '2025-03-15 09:00:00', '2025-03-15 17:00:00', 'Auditorio Principal - ACIP', 'feria-ciencias-tecnologia', 1, 1),

('Charla: Oportunidades Laborales en TI', 
 'Charla informativa sobre el mercado laboral en Tecnologías de la Información',
 '<p>Expertos del sector TI compartirán información sobre las oportunidades laborales actuales y futuras en el campo de las tecnologías de la información.</p>',
 'evento2.jpg', '2025-02-20 15:00:00', '2025-02-20 17:00:00', 'Sala de Conferencias', 'charla-oportunidades-laborales-ti', 1, 1),

('Taller de Emprendimiento', 
 'Taller práctico sobre cómo iniciar tu propio negocio',
 '<p>Aprende las bases del emprendimiento y cómo convertir tu idea en un negocio exitoso.</p>',
 'evento3.jpg', '2025-02-25 10:00:00', '2025-02-25 13:00:00', 'Laboratorio de Innovación', 'taller-emprendimiento', 1, 1);

-- Insertar páginas de contenido
INSERT INTO contenidos (parent_id, tipo, titulo, contenido, slug, meta_title, meta_description, estado, autor_id, orden) VALUES
(NULL, 'pagina', 'Presentación', 
 '<h2>Instituto de Educación Superior Privado ACIP</h2><p>El Instituto ACIP es una institución educativa comprometida con la formación de profesionales de excelencia, capaces de enfrentar los retos del mundo laboral actual.</p><p>Contamos con más de 20 años de experiencia en educación superior y hemos formado a miles de profesionales que hoy se desempeñan exitosamente en diferentes sectores.</p><h3>Nuestra Propuesta Educativa</h3><ul><li>Docentes altamente calificados</li><li>Infraestructura moderna</li><li>Convenios con empresas líderes</li><li>Enfoque práctico y profesional</li></ul>',
 'presentacion', 'Presentación Institucional - ACIP', 'Conoce al Instituto ACIP, nuestra historia y propuesta educativa', 'publicado', 1, 1),

(NULL, 'pagina', 'Misión, Visión y Valores',
 '<h2>Misión</h2><p>Formar profesionales técnicos competentes, con valores éticos y compromiso social, capaces de contribuir al desarrollo del país.</p><h2>Visión</h2><p>Ser reconocidos como una institución líder en educación superior tecnológica, con estándares de calidad internacional.</p><h2>Valores</h2><ul><li><strong>Excelencia:</strong> Buscamos la mejora continua en todos nuestros procesos</li><li><strong>Integridad:</strong> Actuamos con honestidad y transparencia</li><li><strong>Compromiso:</strong> Nos dedicamos plenamente a la formación de nuestros estudiantes</li><li><strong>Innovación:</strong> Fomentamos la creatividad y el pensamiento crítico</li></ul>',
 'mision-vision', 'Misión, Visión y Valores - ACIP', 'Conoce la misión, visión y valores del Instituto ACIP', 'publicado', 1, 2);

-- Insertar documentos de ejemplo
INSERT INTO documentos (titulo, descripcion, archivo, categoria, tipo_documento, tamanio, extension, autor_id, activo) VALUES
('TUPA 2025', 'Texto Único de Procedimientos Administrativos vigente', 'tupa-2025.pdf', 'TUPA', 'reglamento', 2048000, 'pdf', 1, 1),
('Reglamento Institucional', 'Reglamento Institucional del Instituto ACIP', 'reglamento-institucional.pdf', 'Documentos de Gestión', 'reglamento', 1536000, 'pdf', 1, 1),
('Plan Estratégico Institucional 2024-2028', 'PEI del Instituto ACIP', 'pei-2024-2028.pdf', 'Documentos de Gestión', 'manual', 3072000, 'pdf', 1, 1);

COMMIT;
