## 📋 Estado actual y checklist

### Implementado
- [x] Sistema de autenticación (registro/login/logout)
- [x] CRUD de posts (controlador y modelo)
- [x] Enrutamiento amigable y seguro
- [x] Mensajes flash con SweetAlert2
- [x] Protección de rutas por login
- [x] Validación de formularios en el servidor
- [x] Estructura MVC y uso de PDO/password_hash
- [x] El usuario puede eliminar sus propios posts (desde el controlador, falta vista/botón)

### Pendiente o mejoras sugeridas
- [ ] Vistas de crear/editar posts (`views/posts/create.php`, `edit.php`)
- [ ] Botón y confirmación visual para eliminar posts desde la interfaz
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

## 🛠️ Recursos útiles
- [Documentación oficial de PHP sobre subida de archivos](https://www.php.net/manual/es/features.file-upload.php)
- [Validación de archivos en PHP](https://www.php.net/manual/es/function.move-uploaded-file.php)
- [Ejemplo de formulario de subida de imagen](https://www.w3schools.com/php/php_file_upload.asp)

---

## 💡 Siguiente paso recomendado
Implementa la subida de imágenes en los posts para cumplir el enunciado y tener un CMS funcional y completo.

---

## 📝 Descripción

Este proyecto consiste en un Sistema de Gestión de Contenido (CMS) para un blog personal desarrollado en PHP puro, sin frameworks. El objetivo principal es implementar y comprender los diferentes conceptos y capas del desarrollo web moderno utilizando PHP orientado a objetos, siguiendo el patrón de arquitectura MVC (Modelo-Vista-Controlador).

## 🎯 Objetivos de Aprendizaje

Este proyecto está diseñado para dominar los siguientes conceptos de desarrollo web con PHP:

- **Enrutamiento**: Sistema que interpreta URLs amigables y las dirige al código correspondiente
- **Programación Orientada a Objetos (POO)**: Organización del código en clases que representan entidades reales
- **Bases de Datos con PDO**: Interacción segura con la base de datos mediante PHP Data Objects
- **Autenticación y Sesiones**: Sistema seguro de registro e inicio de sesión con manejo de sesiones
- **Plantillas y Separación de Vistas**: Separación de la lógica (PHP) y la presentación (HTML)
- **Subida y Gestión de Archivos**: Procesamiento seguro de imágenes y archivos para posts
- **Validación y Saneamiento de Datos**: Protección contra inyecciones y validación de entrada
- **Desarrollo Mantenible**: Código estructurado y organizado para facilitar el mantenimiento

## 💻 Tecnologías Utilizadas

- **Backend**: PHP 7.4+ 
- **Base de Datos**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3
- **CSS Framework**: Tailwind CSS
- **Seguridad**: PDO con prepared statements, password_hash()
- **Servidor Web**: Apache con mod_rewrite habilitado

## 🏗️ Estructura del Proyecto

```
blog-personal/
├── config/
│   └── database.php       # Configuración de conexión a BD
├── controllers/
│   ├── PostController.php # Controlador para posts del blog
│   └── UserController.php # Controlador para usuarios y autenticación
├── includes/
│   ├── Database.php       # Clase para gestionar conexión a BD
│   ├── functions.php      # Funciones auxiliares globales
│   └── Router.php         # Sistema de enrutamiento
├── models/
│   ├── Post.php           # Modelo para gestión de posts
│   └── User.php           # Modelo para gestión de usuarios
├── public/
│   ├── css/
│   │   └── style.css      # Estilos personalizados
│   ├── index.php          # Punto de entrada único
│   └── .htaccess          # Configuración para URLs amigables
├── views/
│   ├── layouts/
│   │   └── main.php       # Plantilla principal (header, footer)
│   └── posts/
│       ├── index.php      # Vista de lista de posts
│       └── view.php       # Vista de post individual
├── .htaccess              # Redirección a carpeta public
└── README.md              # Documentación del proyecto
```

## ✨ Estado de las Características

### Implementado
- [x] Sistema de Autenticación: Registro e inicio de sesión de usuarios
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