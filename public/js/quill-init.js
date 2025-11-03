/**
 * Inicialización y configuración de Quill Editor
 * Funciones reutilizables para crear y editar posts
 */

/**
 * Inicializa el editor Quill en el elemento especificado
 * @param {string} containerSelector - Selector CSS del contenedor del editor
 * @param {string} textareaSelector - Selector CSS del textarea oculto para sincronización
 * @param {string} placeholder - Texto placeholder para el editor
 * @returns {Quill} Instancia del editor Quill
 */
function initQuillEditor(containerSelector, textareaSelector, placeholder = 'Escribe el contenido de tu post aquí...') {
    const quill = new Quill(containerSelector, {
        theme: 'snow',
        placeholder: placeholder,
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'blockquote', 'code-block'],
                ['clean']
            ]
        }
    });

    // Sincronizar el contenido de Quill con el textarea oculto
    const contentTextarea = document.querySelector(textareaSelector);
    if (contentTextarea) {
        quill.on('text-change', function() {
            contentTextarea.value = quill.root.innerHTML;
        });
    }

    // Configurar observadores para actualizar indicadores de color
    setupColorIndicators();

    return quill;
}

/**
 * Actualiza los indicadores de color en los selectores de Quill
 */
function updateColorIndicators() {
    // Selector de color de texto
    const colorPicker = document.querySelector('.ql-color .ql-picker-label');
    if (colorPicker) {
        const colorValue = colorPicker.getAttribute('data-value');
        const strokeElement = colorPicker.querySelector('.ql-stroke.ql-color-label');
        if (strokeElement && colorValue) {
            strokeElement.style.stroke = colorValue;
        }
    }
    
    // Selector de color de fondo
    const bgPicker = document.querySelector('.ql-background .ql-picker-label');
    if (bgPicker) {
        const bgValue = bgPicker.getAttribute('data-value');
        const fillElement = bgPicker.querySelector('.ql-fill.ql-color-label');
        if (fillElement && bgValue) {
            fillElement.style.fill = bgValue;
        }
    }
}

/**
 * Configura los observadores de mutación para los indicadores de color
 */
function setupColorIndicators() {
    // Observar cambios en los atributos data-value
    const observer = new MutationObserver(updateColorIndicators);
    const colorButton = document.querySelector('.ql-color');
    const bgButton = document.querySelector('.ql-background');
    
    if (colorButton) {
        observer.observe(colorButton, { 
            attributes: true, 
            subtree: true, 
            attributeFilter: ['data-value'] 
        });
    }
    
    if (bgButton) {
        observer.observe(bgButton, { 
            attributes: true, 
            subtree: true, 
            attributeFilter: ['data-value'] 
        });
    }
    
    // Actualizar al inicio
    updateColorIndicators();
}

/**
 * Configura el contador de caracteres para un campo input o textarea
 * @param {string} inputSelector - Selector CSS del campo de entrada
 * @param {string} counterSelector - Selector CSS del elemento contador
 * @param {number} maxLength - Longitud máxima permitida
 * @param {boolean} autoResize - Si es true, auto-redimensiona el textarea
 */
function setupCharCounter(inputSelector, counterSelector, maxLength, autoResize = false) {
    const input = document.querySelector(inputSelector);
    const counter = document.querySelector(counterSelector);
    
    if (!input || !counter) return;
    
    function updateCounter() {
        counter.textContent = input.value.length + '/' + maxLength + ' caracteres';
        if (autoResize && input.tagName === 'TEXTAREA') {
            input.style.height = 'auto';
            input.style.height = input.scrollHeight + 'px';
        }
    }
    
    input.addEventListener('input', updateCounter);
    
    // Actualizar al inicio
    updateCounter();
}

/**
 * Configura la previsualización de imagen
 * @param {string} inputSelector - Selector CSS del input file
 * @param {string} buttonSelector - Selector CSS del botón de selección
 * @param {string} containerSelector - Selector CSS del contenedor de preview
 */
function setupImagePreview(inputSelector, buttonSelector, containerSelector) {
    const fileInput = document.querySelector(inputSelector);
    const previewContainer = document.querySelector(containerSelector);
    const imageSelectBtn = document.querySelector(buttonSelector);
    
    if (!fileInput || !previewContainer || !imageSelectBtn) return;
    
    imageSelectBtn.addEventListener('click', function(e) {
        e.preventDefault();
        fileInput.click();
    });
    
    fileInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';
        if (fileInput.files.length && fileInput.files[0].type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'rounded shadow border border-gray-700 max-w-[200px] h-auto';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    });
}
