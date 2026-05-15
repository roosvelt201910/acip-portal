# Portal Institucional ACIP

Sistema de gestión de contenidos (CMS) para el Instituto de Educación Superior Privado "ACIP".

## Características

- ✅ Portal público responsive
- ✅ Panel de administración completo
- ✅ Gestión de contenidos con editor WYSIWYG
- ✅ Sistema de noticias y eventos
- ✅ Gestión de documentos
- ✅ Constructor de menús drag-and-drop
- ✅ Libro de reclamaciones digital
- ✅ SEO optimizado

## Requisitos

- PHP 8.1 o superior
- MySQL 8.0 o superior
- Apache con mod_rewrite habilitado

## Instalación

1. **Importar base de datos:**
   ```bash
   mysql -u root -p < database_schema.sql
   ```

2. **Configurar credenciales:**
   Editar `config/database.php` con tus credenciales de MySQL

3. **Configurar permisos:**
   ```bash
   chmod -R 775 public/uploads
   chmod -R 775 storage
   ```

4. **Acceder al sistema:**
   - Portal público: `http://localhost/web/acip-portal/public`
   - Panel admin: `http://localhost/web/acip-portal/public/admin`

## Credenciales por Defecto

**Email:** admin@acip.edu.pe  
**Contraseña:** admin123

> ⚠️ **IMPORTANTE:** Cambiar la contraseña después del primer acceso.

## Estructura del Proyecto

```
acip-portal/
├── app/
│   ├── Controllers/     # Controladores
│   ├── Models/          # Modelos
│   ├── Views/           # Vistas
│   ├── Services/        # Servicios
│   └── Middleware/      # Middleware
├── config/              # Configuración
├── includes/            # Archivos core
├── public/              # Archivos públicos
│   ├── assets/          # CSS, JS, imágenes
│   └── uploads/         # Archivos subidos
└── storage/             # Logs, cache, sesiones
```

## Documentación

- [Propuesta Técnica Completa](../brain/implementation_plan.md)
- [Guía de Despliegue](../brain/guia_despliegue.md)
- [Manual de Usuario](../brain/manual_usuario.md)

## Soporte

Para soporte técnico: soporte@acip.edu.pe

## Licencia

© 2025 Instituto ACIP. Todos los derechos reservados.
