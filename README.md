# Blog Personal PHP - Proyecto Educativo

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

## ✨ Características del Blog

- **Sistema de Autenticación**: Registro e inicio de sesión de usuarios
- **Gestión de Posts**: Crear, leer, actualizar y eliminar posts (CRUD)
- **URLs Amigables**: Sistema de rutas que permite URLs como `/post/titulo-del-post`
- **Protección de Rutas**: Acceso restringido a funcionalidades según el rol del usuario
- **Interfaz Responsive**: Diseño adaptable a diferentes dispositivos
- **Validación de Formularios**: Tanto del lado del cliente como del servidor
- **Mensajes Flash**: Notificaciones temporales para informar al usuario
- **Paginación**: Para navegar entre múltiples posts

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

## 🛠️ Desarrollo Futuro

Posibles mejoras para implementar:

- Sistema de comentarios en posts
- Categorías y etiquetas para posts
- Panel de administración avanzado
- Editor WYSIWYG para posts
- Implementación de API REST
- Búsqueda de posts
- Compartir en redes sociales