# 📝 Personal Blog - Sistema de Blog en PHP

Sistema de blog desarrollado en **PHP puro** siguiendo el patrón **MVC** (Modelo-Vista-Controlador).


## 🚀 Instalación

### 1. Instalar XAMPP

1. Instalar XAMPP en tu sistema (por defecto se instala en `C:\xampp`)

### 2. Copiar el proyecto en htdocs

1. Descargar o clonar este repositorio
2. Copiar la carpeta `Personal-Blog` dentro de la carpeta `htdocs` de XAMPP:

### 3. Iniciar los servicios de XAMPP

1. Abrir el **Panel de Control de XAMPP**
2. Hacer clic en **Start** en el servicio **Apache**
3. Hacer clic en **Start** en el servicio **MySQL**

### 4. Crear la base de datos

1. Crear una nueva base de datos llamada `personal_blog`

2. Seleccionar la base de datos `personal_blog` y ejecutar el siguiente SQL en la pestaña "SQL":

```sql
-- Tabla de usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    must_change_password TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de posts
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    content TEXT NOT NULL,
    image VARCHAR(255),
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### 5. Configurar credenciales de la base de datos (opcional)

Si has cambiado las credenciales por defecto de MySQL, editar el archivo `config/database.php`:

```php
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'personal_blog');
define('DB_USER', 'root');
define('DB_PASS', ''); // Por defecto en XAMPP está vacía
```

### 6. Acceder a la aplicación

1. Asegurarse de que **Apache** y **MySQL** están activos en XAMPP
2. Abrir el navegador
3. Escribir la siguiente URL:

```
http://localhost/Personal-Blog/public/
```
---

## 📁 Estructura del Proyecto

```
Personal-Blog/
├── config/
│   ├── config.php          # Configuración general
│   └── database.php        # Credenciales de BD
├── controllers/
│   ├── AdminController.php # Controlador del panel admin
│   ├── PostController.php  # Controlador de posts
│   └── UserController.php  # Controlador de usuarios
├── includes/
│   ├── Database.php        # Clase Singleton para conexión PDO
│   ├── functions.php       # Funciones auxiliares
│   ├── Router.php          # Sistema de enrutamiento
│   └── translations.php    # Traducciones
├── models/
│   ├── Post.php            # Modelo de Post
│   └── User.php            # Modelo de Usuario
├── public/
│   ├── index.php           # Punto de entrada único
│   ├── css/                # Estilos CSS
│   ├── js/                 # JavaScript (validaciones)
│   └── uploads/            # Imágenes subidas
├── views/
│   ├── admin/              # Vistas del panel admin
│   ├── errors/             # Páginas de error (403, 404, 500)
│   ├── layouts/            # Plantilla principal
│   ├── posts/              # Vistas de posts (CRUD)
│   └── users/              # Vistas de autenticación
└── README.md
```

---

## 🏗️ Arquitectura MVC

### Flujo de una petición

```
Usuario → public/index.php → Router → Controller → Model → View
```

1. **Router** (`includes/Router.php`): Analiza la URL y dirige al controlador correcto
2. **Controller** (`controllers/`): Procesa la lógica de negocio
3. **Model** (`models/`): Interactúa con la base de datos mediante PDO
4. **View** (`views/`): Renderiza la respuesta HTML

### Patrón Singleton - Database

La clase `Database` implementa el patrón Singleton para mantener una única conexión PDO:

```php
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() { /* conexión PDO */ }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
}
```

---

## ✨ Funcionalidades

### 🔐 Autenticación y Sesiones

- Registro de usuarios con validación completa
- Login con `password_hash()` y `password_verify()`
- Sesiones seguras con `$_SESSION`
- Roles: Usuario normal y Administrador
- Contraseña maestra para registro de admins: `admin2024`

### 📰 Gestión de Posts (CRUD)

- **Crear**: Formulario con editor WYSIWYG (Quill.js)
- **Leer**: Listado paginado y vista individual
- **Actualizar**: Edición con permisos (dueño o admin)
- **Eliminar**: Con confirmación SweetAlert2 y eliminación de imagen

### 🖼️ Subida de Imágenes

- Validación de tipo MIME real (jpg, png, gif, webp)
- Validación de extensión de archivo
- Validación de tamaño máximo (10MB)
- Redimensionado automático (máx. 1200px ancho)
- Compresión de imágenes con GD
- Nombres seguros con `uniqid()`

### 👑 Panel de Administración

- Gestión de usuarios (CRUD completo)
- Gestión de todos los posts
- Cambio de contraseñas de usuarios
- Eliminación en cascada (usuario → posts)

### ✅ Validación Dual

- **Cliente (JavaScript)**: Validación en tiempo real
- **Servidor (PHP)**: Validación completa con `trim()`, `filter_var()`, `htmlspecialchars()`

---

## 🔒 Seguridad

### Protección SQL Injection

Todas las consultas usan **prepared statements**:

```php
$stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
```

### Protección XSS

Uso de `htmlspecialchars()` en todas las salidas:

```php
<?= htmlspecialchars($post->title) ?>
```

### Contraseñas Seguras

```php
// Hashear al guardar
password_hash($password, PASSWORD_DEFAULT);

// Verificar al autenticar
password_verify($password, $user->password);
```

### Validación de Archivos

- Verificación de tipo MIME real con `$_FILES['image']['type']`
- Validación de extensión del archivo
- Límite de tamaño (10MB)
- Nombres sanitizados con `uniqid()`
- Movimiento controlado con `move_uploaded_file()`

### Gestión de Sesiones

- `session_start()` centralizado en `public/index.php`
- Verificación de sesión en rutas protegidas
- Roles verificados en `$_SESSION['is_admin']`

---

