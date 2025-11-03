# Guía de Migración - Sistema de Administrador Mejorado

## 📋 Cambios Implementados

### 1. Nuevo Sistema de Roles de Usuario

El sistema de administrador ha sido completamente rediseñado:

- ✅ **Antes**: Cualquier usuario podía acceder al panel admin con una contraseña temporal (`1234`)
- ✅ **Ahora**: Solo usuarios con rol de administrador pueden acceder, definido en el registro

### 2. Cambios en la Base de Datos

Se ha agregado una nueva columna `is_admin` a la tabla `users`.

#### Ejecutar Migración SQL

```sql
-- Migración: Agregar campo is_admin a la tabla users
ALTER TABLE users ADD COLUMN is_admin TINYINT(1) DEFAULT 0 NOT NULL AFTER password;

-- Crear índice para optimizar búsquedas por rol
CREATE INDEX idx_users_is_admin ON users(is_admin);

-- OPCIONAL: Convertir el primer usuario en administrador
-- UPDATE users SET is_admin = 1 WHERE id = 1;
```

#### Script de Migración

También puedes ejecutar el archivo `migration_add_admin.sql` incluido en la raíz del proyecto.

### 3. Registro de Nuevos Administradores

#### Contraseña Maestra

Para registrarse como administrador, se requiere una **contraseña maestra**:

- **Contraseña por defecto**: `admin2024`
- **Ubicación**: `models/User.php` → Constante `ADMIN_MASTER_PASSWORD`

#### Cómo Cambiar la Contraseña Maestra

1. Abrir `models/User.php`
2. Buscar la línea:
   ```php
   private const ADMIN_MASTER_PASSWORD = 'admin2024';
   ```
3. Cambiar `admin2024` por tu contraseña deseada
4. Guardar el archivo

**⚠️ IMPORTANTE**: Mantén esta contraseña segura y no la compartas.

### 4. Proceso de Registro como Administrador

1. Ir a la página de registro (`/register`)
2. Llenar datos de usuario (nombre, email, contraseña)
3. ✅ Marcar el checkbox **"Registrarse como Administrador"**
4. Ingresar la contraseña maestra en el campo que aparece
5. Completar el registro

### 5. Inicio de Sesión

- Los usuarios administradores inician sesión normalmente con su email y contraseña
- El sistema automáticamente carga su rol de admin en la sesión
- El botón "Admin" en el navbar **solo aparece** si eres administrador

### 6. Acceso al Panel de Administración

- **URL**: `/admin`
- **Requisito**: Debes estar logueado como usuario admin
- **Sin permisos**: Error 403 "Acceso Denegado"

## 🔧 Archivos Modificados

### Modelos
- `models/User.php` - Agregado campo `is_admin` y método `verifyAdminPassword()`

### Controladores
- `controllers/UserController.php` - Actualizado `store()` y `authenticate()`
- `controllers/AdminController.php` - Refactorizado con método `isAdmin()`
- `controllers/PostController.php` - Actualizado verificaciones de admin

### Vistas
- `views/users/register.php` - Agregado checkbox y campo de contraseña admin
- `views/layouts/main.php` - Botón admin condicional
- `views/admin/index.php` - Eliminada notificación de acceso
- `views/errors/403.php` - Nueva página de error

### Archivos Eliminados
- `views/admin/access.php` - Ya no se necesita login admin separado

## 🚀 Mejoras de Código

### Archivos CSS/JS Compartidos

Se crearon archivos reutilizables para el editor Quill:

1. **`public/css/quill-custom.css`** - Estilos del editor (antes duplicados en create.php y edit.php)
2. **`public/js/quill-init.js`** - Funciones JavaScript reutilizables

#### Funciones Disponibles

```javascript
// Inicializar Quill Editor
initQuillEditor(containerSelector, textareaSelector, placeholder);

// Configurar contador de caracteres
setupCharCounter(inputSelector, counterSelector, maxLength, autoResize);

// Configurar preview de imagen
setupImagePreview(inputSelector, buttonSelector, containerSelector);
```

## 📝 Tareas Post-Migración

### Para Usuarios Existentes

Si ya tienes usuarios en la base de datos:

1. **Ejecutar la migración SQL** (archivo `migration_add_admin.sql`)
2. **Convertir un usuario existente en admin** (opcional):
   ```sql
   UPDATE users SET is_admin = 1 WHERE email = 'tu-email@ejemplo.com';
   ```
3. **Cerrar sesión y volver a iniciar** para cargar el nuevo rol

### Para Nuevas Instalaciones

1. Ejecutar el script SQL de migración
2. Registrar el primer usuario marcando "Administrador"
3. Usar la contraseña maestra: `admin2024` (o la que hayas configurado)

## 🔒 Seguridad

### Mejoras Implementadas

✅ **Rol persistente**: El admin está en la base de datos, no en sesión temporal  
✅ **Validación de permisos**: Verificación en cada método del AdminController  
✅ **Error 403**: Página personalizada para accesos denegados  
✅ **Contraseña maestra**: Protege el registro de administradores  

### Recomendaciones

- 🔐 Cambiar la contraseña maestra por defecto
- 🔐 No compartir la contraseña maestra
- 🔐 Crear solo los administradores necesarios
- 🔐 Revisar periódicamente los usuarios con rol admin

## ❓ Preguntas Frecuentes

**P: ¿Qué pasa con los usuarios admin existentes?**  
R: Debes actualizar manualmente su campo `is_admin = 1` en la base de datos.

**P: ¿Puedo tener múltiples administradores?**  
R: Sí, puedes registrar tantos como necesites con la contraseña maestra.

**P: ¿Cómo quito el rol de admin a un usuario?**  
R: Ejecuta: `UPDATE users SET is_admin = 0 WHERE id = [ID_USUARIO];`

**P: ¿Qué pasa si olvido la contraseña maestra?**  
R: Debes cambiarla manualmente en `models/User.php`.

## 📞 Soporte

Si encuentras algún problema durante la migración, revisa:
1. Que la migración SQL se haya ejecutado correctamente
2. Que los archivos CSS/JS estén en las rutas correctas
3. Que hayas cerrado y vuelto a iniciar sesión

---

**Versión**: 2.0  
**Fecha**: Noviembre 2025  
**Autor**: Sistema Mejorado de Blog Personal
