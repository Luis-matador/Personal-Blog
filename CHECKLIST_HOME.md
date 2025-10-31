# Checklist de mejoras para la página home


## Checklist detallado de mejoras para la página home

- [ ] **Reducir el ancho de los contenedores de publicaciones**
	- Limitar el ancho máximo (ej: `max-w-3xl`) para mejorar la legibilidad y el enfoque visual.
- [ ] **Aumentar el espacio entre publicaciones**
	- Usar clases como `mb-8` o `gap-y-8` para separar las tarjetas y evitar que se vean amontonadas.
- [ ] **Agregar sombra sutil a las tarjetas**
	- Añadir `shadow-lg` o `shadow-md` en Tailwind para dar profundidad y resaltar cada publicación.
- [ ] **Hacer la imagen más protagonista en cada tarjeta**
	- Aumentar el tamaño de la imagen, usarla como fondo o aplicar un overlay oscuro con el texto encima.
- [ ] **Mostrar nombre del autor y número de comentarios**
	- Añadir debajo del título el autor y, si existe sistema de comentarios, mostrar el contador.
- [ ] **Agregar resumen debajo del título**
	- Incluir un pequeño extracto del contenido para invitar a leer más.
- [ ] **Mejorar tipografía**
	- Usar una fuente secundaria para la fecha y el resumen (`font-light`, `text-gray-400`).
- [ ] **Botón “Leer más” más grande y llamativo**
	- Usar colores de acento, aumentar el padding y aplicar `hover:bg-indigo-600`.
- [ ] **Hover effects en tarjetas y botones**
	- Animar el fondo, sombra o escala al pasar el mouse (`hover:scale-105`, `transition`).
- [ ] **Header más alto y con fondo diferente**
	- Cambiar el fondo del header por un degradado, imagen o color destacado. Aumentar el padding vertical.
- [ ] **Agregar logo/avatar en el header**
	- Incluir un logo gráfico o avatar personal para dar identidad.
- [ ] **Incluir buscador en la barra superior**
	- Añadir un input de búsqueda para filtrar publicaciones por título o contenido.
- [ ] **Fondo con textura o degradado**
	- Sustituir el fondo plano por un degradado (`bg-gradient-to-r`) o textura sutil.
- [ ] **Aumentar contraste entre tarjetas y fondo**
	- Usar colores más claros en las tarjetas o más oscuros en el fondo para que resalten.
- [ ] **Diseño responsive para móviles**
	- Verificar que todo se adapte bien en pantallas pequeñas (`flex-col`, `w-full`, `sm:w-1/2`).
- [ ] **Animaciones suaves al cargar/hover**
	- Implementar animaciones con Tailwind (`transition`, `duration-300`) para mejorar la experiencia visual.

Puedes ir marcando cada punto a medida que lo vayas implementando. Si quieres añadir más ideas, solo dímelo y lo actualizo.
Puedes ir marcando cada punto a medida que lo vayas implementando. Si quieres añadir más ideas, solo dímelo y lo actualizo.