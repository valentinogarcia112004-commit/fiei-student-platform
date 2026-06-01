// FIEI Platform - JavaScript Principal

// ============ FUNCIONES GLOBALES ============

function showNotification(message, type = 'info') {
    // Crear elemento de notificación
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;

    // Estilos de la notificación
    notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 2rem;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            z-index: 10000;
            animation: slideIn 0.3s ease-out;
        `;

    // Colores según tipo
    switch (type) {
        case 'success':
            notification.style.backgroundColor = '#4caf50';
            break;
        case 'error':
            notification.style.backgroundColor = '#f44336';
            break;
        default:
            notification.style.backgroundColor = '#2196f3';
    }

    document.body.appendChild(notification);

    // Eliminar después de 3 segundos
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Validar email institucional (ejemplo)
function isInstitutionalEmail(email) {
    return email.includes('universidad.edu');
}

// Agregar animaciones CSS dinámicamente
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);



document.addEventListener('DOMContentLoaded', function () {

    // ============ VALIDACIÓN DE FORMULARIOS ============

    // Validación del Login
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            if (!email || !password) {
                e.preventDefault();
                showNotification('Por favor completa todos los campos', 'error');
                return;
            }
            if (!isValidEmail(email)) {
                e.preventDefault();
                showNotification('Por favor ingresa un correo electrónico válido', 'error');
                return;
            }
            
        });
    }

    // Validación del Registro
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const career = document.getElementById('career').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            // Validaciones – solo prevenimos el envío si hay error
            if (!fullName || !email || !career || !password || !confirmPassword) {
                e.preventDefault();
                showNotification('Por favor completa todos los campos', 'error');
                return;
            }
            if (!isValidEmail(email)) {
                e.preventDefault();
                showNotification('Por favor ingresa un correo electrónico válido', 'error');
                return;
            }
            if (!isInstitutionalEmail(email)) {
                e.preventDefault();
                showNotification('Por favor usa tu correo institucional', 'error');
                return;
            }
            if (password.length < 8) {
                e.preventDefault();
                showNotification('La contraseña debe tener al menos 8 caracteres', 'error');
                return;
            }
            if (password !== confirmPassword) {
                e.preventDefault();
                showNotification('Las contraseñas no coinciden', 'error');
                return;
            }

            // Si pasa todas las validaciones, no llamamos a e.preventDefault()
            // El formulario se enviará automáticamente a backend/register.php
            showNotification('Registrando...', 'success');
        });
    }
    


    // Animación de las cards al hacer hover
    const cards = document.querySelectorAll('.card, .career-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-10px)';
            this.style.transition = 'transform 0.3s ease';
        });

        card.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
        });
    });

    // Smooth scroll para enlaces internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // ============ SIMULACIÓN DE ANUNCIOS (Futuro: Cargar desde BD) ============
    const announcements = [
        {
            date: '25 Mayo 2024',
            title: 'Taller de Programación Web',
            content: 'Aprende HTML, CSS y JavaScript desde cero'
        },
        {
            date: '20 Mayo 2024',
            title: 'Competencia de Robótica 2024',
            content: 'Inscripciones abiertas para la competencia anual'
        },
        {
            date: '15 Mayo 2024',
            title: 'Conferencia: Inteligencia Artificial',
            content: 'Ponente internacional este viernes'
        }
    ];

    console.log('FIEI Platform inicializado correctamente');
    console.log('Anuncios cargados:', announcements.length);



    const params = new URLSearchParams(window.location.search);
    if (params.get('registered') === '1') {
        showNotification('Registro exitoso. Por favor inicia sesión.', 'success');
    }
    if (params.get('error') === 'invalid_credentials') {
        showNotification('Correo o contraseña incorrectos.', 'error');
    }
    if (params.get('error') === 'empty_fields') {
        showNotification('Todos los campos son obligatorios.', 'error');
    }
    if (params.get('error') === 'invalid_email') {
        showNotification('El formato del correo no es válido.', 'error');
    }
    if (params.get('error') === 'password_mismatch') {
        showNotification('Las contraseñas no coinciden.', 'error');
    }
    if (params.get('error') === 'email_exists') {
        showNotification('El correo ya está registrado.', 'error');
    }
    // Limpiar la URL para que no se vea el parámetro
    if (window.location.search) {
        window.history.replaceState({}, document.title, window.location.pathname);
    }



    
    // Menú hamburguesa
    const menuToggle = document.getElementById('menuToggle');
    const navMenu = document.getElementById('navMenu');

    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function () {
            navMenu.classList.toggle('active');
        });

        // Cerrar el menú al hacer clic en un enlace (opcional, mejora la usabilidad)
        const navLinks = navMenu.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
            });
        });
    }

});



// ============ FUNCIONALIDAD DEL DASHBOARD ============

// Navegación del Sidebar (si existe en la página)
const sidebarLinks = document.querySelectorAll('.sidebar-link');
sidebarLinks.forEach(link => {
    link.addEventListener('click', function (e) {
        sidebarLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
    });
});

// ============ FUNCIONALIDAD DE RECURSOS ============

// Filtro de categorías con tabs
const categoryTabs = document.querySelectorAll('.category-tab');
const resourceCards = document.querySelectorAll('.resource-card');

if (categoryTabs.length > 0 && resourceCards.length > 0) {
    categoryTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            // Actualizar tabs activos
            categoryTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const category = this.getAttribute('data-category');

            // Filtrar recursos
            resourceCards.forEach(card => {
                if (category === 'all' || card.getAttribute('data-category') === category) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.5s';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
}

// Búsqueda de recursos
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();

        resourceCards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const description = card.querySelector('.resource-description').textContent.toLowerCase();

            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
}

// Filtro por selector
const categoryFilter = document.getElementById('categoryFilter');
if (categoryFilter) {
    categoryFilter.addEventListener('change', function () {
        const category = this.value;

        resourceCards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
}

// ============ FUNCIONALIDAD DE SUBIDA DE ARCHIVOS ============

const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');
const fileInfo = document.getElementById('fileInfo');
const fileName = document.getElementById('fileName');
const fileSize = document.getElementById('fileSize');
const removeFile = document.getElementById('removeFile');

if (dropZone && fileInput) {
    // Click para abrir explorador de archivos
    dropZone.addEventListener('click', function () {
        fileInput.click();
    });

    // Prevenir comportamiento por defecto
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Efectos visuales al arrastrar
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
    });

    // Manejar archivo soltado
    dropZone.addEventListener('drop', function (e) {
        const files = e.dataTransfer.files;
        handleFiles(files);
    });

    // Manejar archivo seleccionado
    fileInput.addEventListener('change', function () {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        if (files.length > 0) {
            const file = files[0];

            // Validar tamaño (50MB)
            if (file.size > 50 * 1024 * 1024) {
                showNotification('El archivo supera el límite de 50MB', 'error');
                return;
            }

            // Validar formato
            const allowedTypes = ['.pdf', '.ppt', '.pptx', '.doc', '.docx', '.zip', '.rar'];
            const fileExtension = '.' + file.name.split('.').pop().toLowerCase();

            if (!allowedTypes.includes(fileExtension)) {
                showNotification('Formato de archivo no permitido', 'error');
                return;
            }

            // Mostrar información del archivo
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            fileInfo.style.display = 'flex';
            dropZone.querySelector('.file-upload-content').style.display = 'none';

            showNotification('Archivo listo para subir', 'success');
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Eliminar archivo
    if (removeFile) {
        removeFile.addEventListener('click', function () {
            fileInput.value = '';
            fileInfo.style.display = 'none';
            dropZone.querySelector('.file-upload-content').style.display = 'block';
        });
    }

    // Validación del formulario de subida
    const uploadForm = document.getElementById('uploadForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function (e) {
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();
            const category = document.getElementById('category').value;

            // Validaciones
            if (!title || !description || !category) {
                e.preventDefault();
                showNotification('Completa todos los campos obligatorios', 'error');
                return;
            }

            if (!fileInput.files[0]) {
                e.preventDefault();
                showNotification('Por favor selecciona un archivo', 'error');
                return;
            }

            if (!document.getElementById('terms').checked) {
                e.preventDefault();
                showNotification('Debes aceptar los términos', 'error');
                return;
            }

            // Si pasa las validaciones, se envía al backend.
            // No limpiamos el formulario manualmente; lo hará el backend o la recarga.
            showNotification('Subiendo recurso...', 'success');
        });
    }
}

// ============ FUNCIONALIDAD DE CONTACTO ============

const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const subject = document.getElementById('subject').value;
        const message = document.getElementById('message').value.trim();

        // Validaciones
        if (!name || !email || !subject || !message) {
            e.preventDefault();
            showNotification('Completa todos los campos obligatorios', 'error');
            return;
        }

        if (!isValidEmail(email)) {
            e.preventDefault();
            showNotification('Ingresa un correo electrónico válido', 'error');
            return;
        }

        // Si todo está correcto, el formulario se envía al backend.
        // El archivo contact.php guardará el mensaje en la base de datos.
        showNotification('Enviando mensaje...', 'success');
        // No limpiamos el formulario manualmente; el backend redirigirá con el resultado.
    });
}

// Animación de fadeIn
const fadeInStyle = document.createElement('style');
fadeInStyle.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(fadeInStyle);

console.log('✅ Todas las funcionalidades FIEI cargadas correctamente');