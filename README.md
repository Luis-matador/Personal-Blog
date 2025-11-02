# 📝 Personal Blog - Blog Personal en PHP# 📝 Personal Blog - Blog Personal en PHP



Un sistema de blog completo desarrollado en PHP puro siguiendo el patrón **MVC** (Modelo-Vista-Controlador), con diseño moderno usando Tailwind CSS y funcionalidades avanzadas.


## 📋 Estado Actual del Proyecto

## 📋 Estado actual y checklist

### ✅ **COMPLETAMENTE IMPLEMENTADO**

- [x] Sistema de autenticación completo (registro/login/logout)### ✅ Implementado

- [x] **CRUD completo de posts** (crear, leer, editar, eliminar)- [x] Sistema de autenticación (registro/login/logout) con sesiones seguras

- [x] **Vista de crear posts** con editor WYSIWYG (Quill.js)- [x] CRUD completo de posts (crear, leer, editar, eliminar)

- [x] **Vista de editar posts** con actualización de imagen- [x] **Vistas de crear/editar posts** con editor WYSIWYG (Quill)

- [x] **Subida y gestión de imágenes** (validación, preview, eliminación)- [x] **Subida y gestión de imágenes** (validación tipo/tamaño, preview, eliminación)

- [x] **Validación en cliente (JavaScript)** con contadores en tiempo real- [x] **Validación en cliente (JavaScript)** con contador de caracteres en tiempo real

- [x] **Validación en servidor (PHP)** completa- [x] **Validación en servidor (PHP)** completa con mensajes de error

- [x] **Botón eliminar** con confirmación visual (SweetAlert2)- [x] **Botón eliminar** con confirmación visual (SweetAlert2)

- [x] Sistema de rutas con `BASE_URL` dinámico- [x] Enrutamiento amigable con URLs limpias

- [x] Sesiones centralizadas en `index.php`- [x] Sistema de rutas con `BASE_URL` configurable

- [x] Diseño responsive con Tailwind CSS- [x] Mensajes flash con SweetAlert2

- [x] Página 404 personalizada- [x] Protección de rutas por autenticación

- [x] Mensajes flash con SweetAlert2- [x] Estructura MVC profesional

- [x] Uso de PDO y password_hash

### 🎯 **PROYECTO LISTO PARA ENTREGAR**- [x] Diseño responsive con Tailwind CSS

Todas las funcionalidades obligatorias del enunciado están implementadas y funcionando correctamente.- [x] Página 404 personalizada

- [x] Contador de caracteres en formularios

---- [x] Preview de imágenes antes de subir



## ✨ Características Principales### 🚧 Mejoras Futuras

- [ ] Paginación en el listado de posts

### 🔐 Autenticación Segura- [ ] Búsqueda de posts

- Registro con validación de email y contraseñas- [ ] Categorías y etiquetas

- Login con hash bcrypt- [ ] Comentarios en posts

- Sesiones gestionadas centralmente- [ ] Panel de administración

- Cierre de sesión- [ ] Edición de perfil de usuario

- [ ] Recuperación de contraseña

### 📰 Gestión Completa de Posts- [ ] Protección CSRF

- **Crear**: Editor WYSIWYG con formato rico- [ ] Sistema de roles (admin, editor, lector)

- **Editar**: Actualizar título, descripción, contenido e imagen

- **Eliminar**: Confirmación visual y eliminación de imagen---

- **Listar**: Vista moderna con cards y previews

- **Ver**: Post individual con contenido completo## ✨ Características Principales



### 🖼️ Sistema de Imágenes### 🔐 **Autenticación de Usuarios**

- Subida con validación de tipo (jpg, png, gif, webp)- Registro de nuevos usuarios con validación completa

- Límite de tamaño (5MB)- Inicio de sesión seguro con contraseñas hasheadas (bcrypt)

- Preview en tiempo real- Sistema de sesiones centralizadas

- Eliminación automática de imagen anterior- Cierre de sesión

- Nombres seguros con `uniqid()`

### 📰 **Gestión Completa de Posts**

### ✅ Validación Dual- ✅ **Crear** publicaciones con editor WYSIWYG (Quill.js)

- **JavaScript**: Validación en tiempo real- ✅ **Editar** publicaciones propias con actualización de imagen

- **PHP**: Validación completa en servidor- ✅ **Eliminar** publicaciones con confirmación visual

- Contadores de caracteres para título (120) y descripción (180)- ✅ **Listar** todos los posts con diseño moderno

- Alertas visuales con SweetAlert2- ✅ **Ver** post individual con contenido completo

- Descripción corta (máx. 180 caracteres) para previews

---- Título con límite de 120 caracteres



## 🚀 Instalación### 🖼️ **Sistema de Imágenes Avanzado**

- Subida de imágenes destacadas para cada post

### Requisitos- Validación de tipo de archivo (jpg, png, gif, webp)

- PHP 7.4+- Validación de tamaño máximo (5MB)

- MySQL 8.0+- Preview de imagen antes de publicar

- Apache con mod_rewrite- Eliminación automática de imagen anterior al actualizar

- Nombres de archivo seguros con `uniqid()`

### Pasos- Muestra de imagen actual en modo edición



1. **Clonar el repositorio**### ✅ **Validación Dual (Cliente + Servidor)**

   ```bash- **JavaScript**: Validación en tiempo real con SweetAlert2

   git clone https://github.com/Luis-matador/Personal-Blog.git- **PHP**: Validación completa en el servidor

   ```- Contador de caracteres en vivo para título y descripción

- Validación de tamaño de imagen antes de subir

2. **Importar base de datos**- Mensajes de error detallados y contextuales

   ```sql

   CREATE DATABASE personal_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;### 🎨 **Diseño Profesional**

   mysql -u root -p personal_blog < personal_blog.sql- Interfaz moderna y responsive con Tailwind CSS

   ```- Modo oscuro elegante

- Animaciones y transiciones suaves

3. **Configurar conexión**- Alertas visuales con SweetAlert2

   - Página 404 personalizada con iconos

   Edita `config/database.php`:- Navegación intuitiva

   ```php- Cards de posts con hover effects

   define('DB_HOST', 'localhost');

   define('DB_NAME', 'personal_blog');---

   define('DB_USER', 'root');

   define('DB_PASS', '');## 🚀 Instalación

   ```

### Requisitos Previos

4. **Configurar Apache**- **PHP 7.4+** con extensión PDO

   - DocumentRoot: `public/`- **MySQL 8.0+** o MariaDB

   - Habilitar mod_rewrite- **Apache** con mod_rewrite habilitado

- **XAMPP, WAMP, MAMP** o servidor similar (recomendado)

5. **Permisos**

   ```bash### Pasos de Instalación

   chmod -R 755 public/uploads/

   ```1. **Clonar el repositorio**

   ```bash

6. **Acceder**   git clone https://github.com/Luis-matador/Personal-Blog.git

   ```   cd Personal-Blog

   http://localhost/Personal-Blog/public/   ```

   ```

2. **Configurar la base de datos**

---   - Crear una base de datos MySQL:

     ```sql

## 📁 Estructura     CREATE DATABASE personal_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

     ```

```   - Importar el esquema:

Personal-Blog/     ```bash

├── config/     mysql -u root -p personal_blog < personal_blog.sql

│   ├── config.php          # Configuración y funciones URL     ```

│   └── database.php        # Conexión PDO

├── controllers/3. **Configurar la conexión**

│   ├── PostController.php  # CRUD de posts   

│   └── UserController.php  # Autenticación   Edita `config/database.php` con tus credenciales:

├── models/   ```php

│   ├── Post.php           # Modelo Post   define('DB_HOST', 'localhost');

│   └── User.php           # Modelo User   define('DB_NAME', 'personal_blog');

├── views/   define('DB_USER', 'tu_usuario');

│   ├── layouts/main.php   # Plantilla principal   define('DB_PASS', 'tu_contraseña');

│   ├── posts/   ```

│   │   ├── index.php      # Listado

│   │   ├── view.php       # Ver post4. **Configurar Apache**

│   │   ├── create.php     # Crear post   - **DocumentRoot**: Apunta a la carpeta `public/`

│   │   └── edit.php       # Editar post   - **Habilitar mod_rewrite**: Para URLs amigables

│   ├── users/   - El archivo `.htaccess` ya está incluido

│   │   ├── login.php      # Login

│   │   └── register.php   # Registro5. **Permisos de directorios**

│   └── errors/404.php     # Error 404   ```bash

├── includes/   chmod -R 755 public/uploads/

│   ├── Router.php         # Enrutamiento   ```

│   └── functions.php      # Funciones auxiliares

├── public/6. **Acceder a la aplicación**

│   ├── index.php          # Punto de entrada   ```

│   ├── css/style.css      # Tailwind CSS   http://localhost/Personal-Blog/public/

│   ├── js/   ```

│   │   ├── alerts.js      # SweetAlert2

│   │   └── validation.js  # Validaciones JS---

│   └── uploads/           # Imágenes

└── personal_blog.sql      # Esquema BD## 📝 Guía rápida para la subida de imágenes

```

- Añade un campo `image` en la tabla de posts (puede ser VARCHAR para la ruta).

---- En el formulario de crear/editar post, añade `<input type="file" name="image">`.

- En el controlador, procesa `$_FILES['image']`, valida tipo/tamaño, mueve el archivo a `/public/uploads/` y guarda la ruta en la BD.

## 🎯 Uso- Muestra la imagen en la vista del post si existe.

- Asegúrate de validar y sanear el nombre del archivo y restringir los tipos permitidos (jpg, png, etc).

### Crear un Post

1. Login o registro---

2. Click "Crear post"

3. Completa el formulario (el contador te ayuda)## 🛠️ Recursos útiles

4. Sube una imagen (opcional)- [Documentación oficial de PHP sobre subida de archivos](https://www.php.net/manual/es/features.file-upload.php)

5. Usa el editor WYSIWYG para el contenido- [Validación de archivos en PHP](https://www.php.net/manual/es/function.move-uploaded-file.php)

6. Click "Publicar"- [Ejemplo de formulario de subida de imagen](https://www.w3schools.com/php/php_file_upload.asp)



### Editar un Post---

1. Abre el post

2. Click "Editar post"## 💡 Siguiente paso recomendado

3. Modifica los camposImplementa la subida de imágenes en los posts para cumplir el enunciado y tener un CMS funcional y completo.

4. Cambia la imagen si quieres

5. Click "Actualizar"---



### Eliminar un Post## 📝 Descripción

1. Abre el post

2. Click "Eliminar post"Este proyecto consiste en un Sistema de Gestión de Contenido (CMS) para un blog personal desarrollado en PHP puro, sin frameworks. El objetivo principal es implementar y comprender los diferentes conceptos y capas del desarrollo web moderno utilizando PHP orientado a objetos, siguiendo el patrón de arquitectura MVC (Modelo-Vista-Controlador).

3. Confirma en el diálogo

4. El post y su imagen se eliminan## 🎯 Objetivos de Aprendizaje



---Este proyecto está diseñado para dominar los siguientes conceptos de desarrollo web con PHP:



## 🛠️ Tecnologías- **Enrutamiento**: Sistema que interpreta URLs amigables y las dirige al código correspondiente

- **Programación Orientada a Objetos (POO)**: Organización del código en clases que representan entidades reales

- **Backend**: PHP 7.4+, MySQL, PDO- **Bases de Datos con PDO**: Interacción segura con la base de datos mediante PHP Data Objects

- **Frontend**: HTML5, Tailwind CSS, JavaScript ES6- **Autenticación y Sesiones**: Sistema seguro de registro e inicio de sesión con manejo de sesiones

- **Librerías**: SweetAlert2, Quill.js- **Plantillas y Separación de Vistas**: Separación de la lógica (PHP) y la presentación (HTML)

- **Seguridad**: Bcrypt, prepared statements, validación dual- **Subida y Gestión de Archivos**: Procesamiento seguro de imágenes y archivos para posts

- **Validación y Saneamiento de Datos**: Protección contra inyecciones y validación de entrada

---- **Desarrollo Mantenible**: Código estructurado y organizado para facilitar el mantenimiento



## 🔒 Seguridad## 💻 Tecnologías Utilizadas



✅ Consultas preparadas (PDO)  - **Backend**: PHP 7.4+ 

✅ Contraseñas hasheadas (bcrypt)  - **Base de Datos**: MySQL/MariaDB

✅ Validación dual (cliente + servidor)  - **Frontend**: HTML5, CSS3

✅ Sanitización de inputs  - **CSS Framework**: Tailwind CSS

✅ Validación de tipos de archivo  - **Seguridad**: PDO con prepared statements, password_hash()

✅ Nombres de archivo seguros  - **Servidor Web**: Apache con mod_rewrite habilitado

✅ Verificación de autoría  

✅ Protección de rutas  ## 🏗️ Estructura del Proyecto



---```

blog-personal/

## 💡 Mejoras Futuras├── config/

│   └── database.php       # Configuración de conexión a BD

- [ ] Paginación├── controllers/

- [ ] Búsqueda│   ├── PostController.php # Controlador para posts del blog

- [ ] Categorías│   └── UserController.php # Controlador para usuarios y autenticación

- [ ] Comentarios├── includes/

- [ ] Panel admin│   ├── Database.php       # Clase para gestionar conexión a BD

- [ ] Roles de usuario│   ├── functions.php      # Funciones auxiliares globales

- [ ] Protección CSRF│   └── Router.php         # Sistema de enrutamiento

- [ ] API REST├── models/

│   ├── Post.php           # Modelo para gestión de posts

---│   └── User.php           # Modelo para gestión de usuarios

├── public/

## 👤 Autor│   ├── css/

│   │   └── style.css      # Estilos personalizados

**Luis Matador**  │   ├── index.php          # Punto de entrada único

GitHub: [@Luis-matador](https://github.com/Luis-matador)│   └── .htaccess          # Configuración para URLs amigables

├── views/

---│   ├── layouts/

│   │   └── main.php       # Plantilla principal (header, footer)

## 🙏 Agradecimientos│   └── posts/

│       ├── index.php      # Vista de lista de posts

- [Tailwind CSS](https://tailwindcss.com/)│       └── view.php       # Vista de post individual

- [SweetAlert2](https://sweetalert2.github.io/)├── .htaccess              # Redirección a carpeta public

- [Quill.js](https://quilljs.com/)└── README.md              # Documentación del proyecto

```

---

## ✨ Estado de las Características

**¡Proyecto completado y listo para usar!** 🎉

### Implementado

Si te ha sido útil, deja una ⭐ en GitHub.- [x] Sistema de Autenticación: Registro e inicio de sesión de usuarios

- [x] Gestión de Posts: Crear, leer, actualizar y eliminar posts (CRUD) *(faltan vistas de crear/editar)*
- [x] URLs Amigables: Sistema de rutas que permite URLs como `/post/titulo-del-post`
- [x] Interfaz Responsive: Diseño adaptable a diferentes dispositivos
- [x] Mensajes Flash: Notificaciones temporales para informar al usuario (SweetAlert2)
- [x] Validación de formularios en el servidor
- [x] Seguridad: PDO, password_hash, sesiones
- [x] Configuración y estructura MVC
- [x] Protección de rutas por login (no por roles)

### Pendiente o Mejoras Futuras
- [ ] Vistas de crear/editar posts (`views/posts/create.php`, `edit.php`)
- [ ] Botón y confirmación visual para eliminar posts desde la interfaz
- [ ] Paginación en el listado de posts
- [ ] Protección de rutas por rol y panel de administración
- [ ] Validación de formularios en el cliente (JS)
- [ ] Subida de imágenes/archivos para posts
- [ ] Sistema de comentarios en posts
- [ ] Categorías y etiquetas para posts
- [ ] Editor WYSIWYG para posts
- [ ] Implementación de API REST
- [ ] Búsqueda de posts
- [ ] Compartir en redes sociales
- [ ] Tests automatizados

## 🚀 Instalación y Configuración

### Requisitos previos

- PHP 7.4 o superior
- MySQL
- Servidor web Apache con mod_rewrite habilitado

### Configuración de la base de datos

- Crear una base de datos llamada "personal_blog"
- Crear tablas para usuarios y posts con las columnas necesarias

### Configuración de la conexión

- Editar el archivo `config/database.php` con los datos de conexión

### Permisos de directorio

- Asegurarse de que el servidor web tiene permisos de escritura en los directorios necesarios

## 🔍 Conceptos Implementados

### Sistema MVC (Modelo-Vista-Controlador)
- **Modelos**: Encapsulan la lógica de negocio y el acceso a datos
- **Vistas**: Se encargan únicamente de la presentación al usuario
- **Controladores**: Coordinan la interacción entre modelos y vistas

### Enrutamiento
El sistema de enrutamiento permite convertir URLs amigables como `/post/mi-primer-post` en llamadas a controladores específicos, sin mostrar parámetros GET en la URL.

### PDO y Prepared Statements
Todas las consultas a la base de datos se realizan mediante PDO y prepared statements para prevenir inyecciones SQL.

### Autenticación Segura
Las contraseñas se almacenan utilizando `password_hash()` y se verifican con `password_verify()`, nunca en texto plano.

## 🛠️ Notas de desarrollo y mejoras

Consulta la sección anterior para ver el checklist actualizado de lo implementado y lo pendiente.