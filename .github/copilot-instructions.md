## 📋 Estado actual del proyecto (checklist)

### Implementado
- [x] Sistema de autenticación (registro/login/logout)
- [x] CRUD de posts (controlador y modelo, faltan vistas de crear/editar)
- [x] Enrutamiento amigable y seguro
- [x] Mensajes flash con SweetAlert2
- [x] Protección de rutas por login
- [x] Validación de formularios en el servidor
- [x] Estructura MVC y uso de PDO/password_hash

### Pendiente o mejoras sugeridas
- [ ] Vistas de crear/editar posts (`views/posts/create.php`, `edit.php`)
- [ ] Paginación en el listado de posts
- [ ] Protección de rutas por rol y panel de administración
- [ ] Validación de formularios en el cliente (JS)
- [ ] Subida de imágenes/archivos para posts (obligatorio para el enunciado)
- [ ] Sistema de comentarios, categorías, etiquetas
- [ ] Editor WYSIWYG para posts
- [ ] API REST, búsqueda, compartir en redes
- [ ] Tests automatizados

---

## 🚩 Pasos mínimos para cumplir el enunciado

1. **Vistas de crear/editar posts**: Implementa los formularios y vistas para crear y editar publicaciones.
2. **Subida y gestión de archivos**: Permite subir imágenes para los posts usando un campo `<input type="file">`, procesa el archivo con `$_FILES`, valida tipo/tamaño y guarda la ruta en la base de datos.
3. **Validación en el cliente (JS)**: Añade validación básica en los formularios usando JavaScript.
4. **Botón eliminar en la interfaz**: Añade el botón y confirmación visual para eliminar posts desde la vista.

---

## 📝 Guía rápida para la subida de imágenes

- Añade un campo `image` en la tabla de posts (puede ser VARCHAR para la ruta).
- En el formulario de crear/editar post, añade `<input type="file" name="image">`.
- En el controlador, procesa `$_FILES['image']`, valida tipo/tamaño, mueve el archivo a `/public/uploads/` y guarda la ruta en la BD.
- Muestra la imagen en la vista del post si existe.
- Asegúrate de validar y sanear el nombre del archivo y restringir los tipos permitidos (jpg, png, etc).

---

## 🏗️ Arquitectura General
- Proyecto PHP puro siguiendo el patrón MVC (Modelo-Vista-Controlador).
- **Enrutamiento**: Definido en `includes/Router.php`, convierte URLs amigables en llamadas a controladores.
- **Controladores**: En `controllers/` (`PostController.php`, `UserController.php`) gestionan la lógica de negocio y coordinan modelos y vistas.
- **Modelos**: En `models/` (`Post.php`, `User.php`) encapsulan acceso a datos y lógica de negocio.
- **Vistas**: En `views/` separadas por entidad y tipo de vista. Plantilla principal en `views/layouts/main.php`.
- **Base de datos**: Acceso mediante PDO, configuración en `config/database.php`.
- **Punto de entrada**: `public/index.php`.

## ⚙️ Flujos de Desarrollo
- No hay sistema de build automatizado: los cambios en PHP se reflejan directamente.
- Para desarrollo local, usar Apache con mod_rewrite y apuntar el DocumentRoot a `public/`.
- La base de datos debe estar creada y configurada según `personal_blog.sql` y `config/database.php`.
- No hay tests automatizados definidos.

## 📝 Convenciones y Patrones
- **MVC estricto**: No mezclar lógica de negocio en vistas ni acceso a datos en controladores.
- **Funciones auxiliares**: Centralizadas en `includes/functions.php`.
- **Mensajes flash**: Usar sesiones para notificaciones temporales.
- **Validación**: Validar y sanear datos tanto en el servidor como en el cliente.
- **URLs amigables**: Todas las rutas deben ser gestionadas por el router, evitando parámetros GET visibles.
- **Seguridad**: Usar siempre consultas preparadas y `password_hash()` para contraseñas.

## 🔗 Integraciones y Dependencias
- **Frontend**: Usa Tailwind CSS (ver `src/input.css` y `public/css/style.css`).
- **No hay dependencias externas vía Composer**: todo el código es PHP nativo.
- **Autenticación**: Implementada manualmente en `UserController.php` y `User.php`.

## 📁 Archivos y Directorios Clave
- `config/database.php`: Configuración de la base de datos.
- `includes/Router.php`: Lógica de enrutamiento.
- `controllers/`: Lógica de negocio y flujo de la app.
- `models/`: Acceso a datos y lógica de entidades.
- `views/`: Presentación y plantillas.
- `public/index.php`: Punto de entrada y bootstrap.

## 🧩 Ejemplos de Patrones
- Para agregar una nueva entidad:
  1. Crear modelo en `models/`.
  2. Crear controlador en `controllers/`.
  3. Crear vistas en `views/[entidad]/`.
  4. Registrar rutas en `includes/Router.php`.