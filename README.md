# 📝 Personal Blog - Sistema de Blog Personal en PHP

Un sistema de blog completo desarrollado en PHP puro siguiendo el patrón **MVC** (Modelo-Vista-Controlador), con diseño moderno usando Tailwind CSS y funcionalidades avanzadas.

---

## 📋 Estado Actual del Proyecto

### ✅ Completamente Implementado

- [x] Sistema de autenticación completo (registro/login/logout) con sesiones seguras
- [x] **Sistema de administrador con roles** (registro con contraseña maestra)
- [x] CRUD completo de posts (crear, leer, editar, eliminar)
- [x] **Vistas de crear/editar posts** con editor WYSIWYG (Quill.js)
- [x] **Subida y gestión de imágenes** (validación tipo/tamaño, preview, eliminación)
- [x] **Validación dual (JavaScript + PHP)** con mensajes en tiempo real
- [x] **Botón eliminar** con confirmación visual (SweetAlert2)
- [x] **Panel de administración** para gestionar usuarios y posts
- [x] Sistema de rutas con URLs amigables
- [x] Mensajes flash con SweetAlert2
- [x] Protección de rutas por roles (admin/usuario)
- [x] Estructura MVC profesional y optimizada
- [x] Diseño responsive con Tailwind CSS
- [x] Páginas de error personalizadas (404, 403, 500)

### 🚧 Mejoras Futuras

- [ ] Paginación en el listado de posts
- [ ] Búsqueda avanzada de posts
- [ ] Categorías y etiquetas
- [ ] Sistema de comentarios
- [ ] Edición de perfil de usuario
- [ ] Recuperación de contraseña
- [ ] Protección CSRF completa
- [ ] API REST

---

## ✨ Características Principales

### 🔐 **Sistema de Roles y Administración**

- **Registro de administradores**: Al registrarse, puedes marcar la opción de administrador ingresando la contraseña maestra (`admin2024`)
- **Panel de administración**: Los administradores pueden:
  - Ver y gestionar todos los usuarios
  - Crear nuevos usuarios (admin o normales)
  - Editar información de usuarios
  - Cambiar contraseñas de usuarios
  - Eliminar usuarios (con eliminación en cascada de sus posts)
  - Ver y eliminar todos los posts
- **Protección de rutas**: Páginas de error 403 para acceso no autorizado
- **Persistencia**: El rol de administrador se guarda en la base de datos

### 📰 **Gestión Completa de Posts**

- ✅ **Crear** publicaciones con editor WYSIWYG (Quill.js con tema oscuro)
- ✅ **Editar** publicaciones propias (o todas si eres admin)
- ✅ **Eliminar** publicaciones con confirmación visual
- ✅ **Listar** todos los posts con diseño moderno en cards
- ✅ **Ver** post individual con contenido formateado
- Título con límite de 30 caracteres
- Descripción corta (máx. 60 caracteres) para previews
- Editor de texto enriquecido con colores personalizados

### 🖼️ **Sistema de Imágenes Avanzado**

- Subida de imágenes destacadas para cada post
- Validación de tipo de archivo (jpg, png, gif, webp)
- Validación de tamaño máximo (5MB)
- Preview de imagen antes de publicar
- Eliminación automática de imagen anterior al actualizar
- Nombres de archivo seguros con `uniqid()`
- Muestra de imagen actual en modo edición

### ✅ **Validación Dual (Cliente + Servidor)**

- **JavaScript**: Validación en tiempo real con SweetAlert2
- **PHP**: Validación completa en el servidor
- Contador de caracteres en vivo para título y descripción
- Validación de tamaño de imagen antes de subir
- Mensajes de error detallados y contextuales
- Validación de roles y permisos

### 🎨 **Diseño Profesional**

- Interfaz moderna y responsive con Tailwind CSS
- Modo oscuro elegante
- Animaciones y transiciones suaves
- Alertas visuales con SweetAlert2
- Páginas de error personalizadas con iconos
- Navegación intuitiva
- Cards de posts con hover effects

---

## 🚀 Instalación

### Requisitos Previos

- **PHP 7.4+** con extensión PDO
- **MySQL 8.0+** o MariaDB
- **Apache** con mod_rewrite habilitado
- **XAMPP, WAMP, MAMP** o servidor similar (recomendado)

### Pasos de Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/Luis-matador/Personal-Blog.git
   cd Personal-Blog
   ```

2. **Configurar la base de datos**
   - Crear una base de datos MySQL:
     ```sql
     CREATE DATABASE personal_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
     ```
   - Importar el esquema:
     ```bash
     mysql -u root -p personal_blog < personal_blog.sql
     ```

3. **Configurar la conexión**
   
   Edita `config/database.php` con tus credenciales:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'personal_blog');
   define('DB_USER', 'tu_usuario');
   define('DB_PASS', 'tu_contraseña');
   ```

4. **Configurar Apache**
   - **DocumentRoot**: Apunta a la carpeta `public/`
   - **Habilitar mod_rewrite**: Para URLs amigables
   - El archivo `.htaccess` ya está incluido

5. **Permisos de directorios**
   ```bash
   chmod -R 755 public/uploads/
   ```

6. **Acceder a la aplicación**
   ```
   http://localhost/Personal-Blog/public/
   ```

### Migración del Sistema de Administrador

Si ya tienes el proyecto instalado con la versión anterior, consulta `MIGRATION.md` para actualizar el sistema de administrador con roles persistentes.

---

## 🎯 Guía de Uso

### Registrarse como Administrador

1. Ir a "Registrarse"
2. Completar el formulario
3. ✅ **Marcar la casilla "¿Eres administrador?"**
4. Ingresar la contraseña maestra: `admin2024`
5. Registrarse

### Panel de Administración

1. Iniciar sesión con una cuenta de administrador
2. Click en "Panel Admin" en la barra de navegación
3. Acceso a:
   - **Gestión de usuarios**: Crear, editar, eliminar, cambiar contraseñas
   - **Gestión de posts**: Ver y eliminar todos los posts del blog

### Crear un Post

1. Login o registro
2. Click "Crear post"
3. Completa el formulario (el contador te ayuda)
4. Sube una imagen (opcional, máx 5MB)
5. Usa el editor WYSIWYG para el contenido
6. Click "Publicar"

### Editar un Post

1. Abre el post
2. Click "Editar post" (solo el autor o admin)
3. Modifica los campos
4. Cambia la imagen si quieres
5. Click "Actualizar"

### Eliminar un Post

1. Abre el post
2. Click "Eliminar post" (solo el autor o admin)
3. Confirma en el diálogo de SweetAlert2
4. El post y su imagen se eliminan

---

## 📁 Estructura del Proyecto

```
Personal-Blog/
├── config/
│   ├── config.php          # Configuración global y funciones URL
│   └── database.php        # Conexión PDO
├── controllers/
│   ├── AdminController.php # Panel de administración
│   ├── PostController.php  # CRUD de posts
│   └── UserController.php  # Autenticación y gestión de usuarios
├── models/
│   ├── Post.php           # Modelo Post con consultas optimizadas
│   └── User.php           # Modelo User con roles
├── views/
│   ├── layouts/main.php   # Plantilla principal
│   ├── admin/
│   │   ├── index.php      # Dashboard admin
│   │   ├── users.php      # Gestión de usuarios
│   │   └── posts.php      # Gestión de posts
│   ├── posts/
│   │   ├── index.php      # Listado
│   │   ├── view.php       # Ver post
│   │   ├── create.php     # Crear post
│   │   └── edit.php       # Editar post
│   ├── users/
│   │   ├── login.php      # Login
│   │   └── register.php   # Registro
│   └── errors/
│       ├── 404.php        # No encontrado
│       ├── 403.php        # Acceso denegado
│       └── 500.php        # Error del servidor
├── includes/
│   ├── Router.php         # Enrutamiento
│   ├── Database.php       # Singleton de BD
│   └── functions.php      # Funciones auxiliares
├── public/
│   ├── index.php          # Punto de entrada único
│   ├── css/
│   │   ├── style.css      # Tailwind CSS compilado
│   │   └── quill-custom.css # Estilos del editor
│   ├── js/
│   │   ├── alerts.js      # SweetAlert2
│   │   ├── validation.js  # Validaciones JS
│   │   └── quill-init.js  # Inicialización de Quill
│   └── uploads/           # Imágenes de posts
├── migration_add_admin.sql # Script de migración de roles
├── MIGRATION.md           # Guía de migración
├── personal_blog.sql      # Esquema BD completo
└── README.md              # Este archivo
```

---

## 🛠️ Tecnologías

- **Backend**: PHP 7.4+, MySQL, PDO
- **Frontend**: HTML5, Tailwind CSS, JavaScript ES6
- **Editor**: Quill.js (WYSIWYG)
- **Alertas**: SweetAlert2
- **Seguridad**: Bcrypt, prepared statements, validación dual
- **Arquitectura**: MVC puro sin frameworks

---

## 🔒 Seguridad

✅ Consultas preparadas (PDO) contra SQL Injection  
✅ Contraseñas hasheadas (bcrypt)  
✅ Validación dual (cliente + servidor)  
✅ Sanitización de inputs con `htmlspecialchars()`  
✅ Validación de tipos de archivo  
✅ Nombres de archivo seguros con `uniqid()`  
✅ Verificación de autoría y roles  
✅ Protección de rutas con middleware  
✅ Sesiones centralizadas en `index.php`  

---

## 💡 Código Optimizado

- ✅ Eliminación de código duplicado
- ✅ Editor Quill centralizado (CSS + JS)
- ✅ Consultas SQL optimizadas con índices
- ✅ Includes centralizados en controladores
- ✅ Validaciones JavaScript consolidadas
- ✅ Sin código de depuración (error_log removidos)
- ✅ Session_start() centralizado en index.php

---

## 👤 Autor

**Luis Matador**  
GitHub: [@Luis-matador](https://github.com/Luis-matador)

---

## 🙏 Agradecimientos

- [Tailwind CSS](https://tailwindcss.com/)
- [SweetAlert2](https://sweetalert2.github.io/)
- [Quill.js](https://quilljs.com/)

---

**¡Proyecto completado y listo para usar!** 🎉

Si te ha sido útil, deja una ⭐ en GitHub.
