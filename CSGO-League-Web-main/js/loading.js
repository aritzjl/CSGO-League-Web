window.onload = function () {
    // Obtener el div de carga
    var loadingDiv = document.getElementById('loading');

    // Esperar 1000 milisegundos (1 segundo)
    setTimeout(function () {
        // Agregar la clase 'hidden' con transición al div de carga
        loadingDiv.classList.add('fade-out');
        // Esperar la duración de la transición antes de ocultar realmente el div
        setTimeout(function () {
            loadingDiv.classList.add('hidden');
        }, 500); // Duración de la transición (en milisegundos)
    }, 600); // Tiempo de espera (en milisegundos)

    // Hacer la solicitud para obtener el contenido de header.html
    fetch('header.html')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar el archivo');
            }
            return response.text(); // Convertir la respuesta a texto
        })
        .then(html => {
            // Crear un div temporal para contener el contenido de header.html
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;

            // Insertar el contenido como hermano del marcador de posición
            const placeholderDiv = document.getElementById('header-container');
            placeholderDiv.parentNode.insertBefore(tempDiv.firstChild, placeholderDiv.nextSibling);

            // Eliminar el marcador de posición
            placeholderDiv.parentNode.removeChild(placeholderDiv);

            function toggleMenu() {
                const hamburger = document.getElementById('hamburger');
                const nav = document.getElementById('nav');
                var isSelected = false;

                if (hamburger.classList.contains('selected')) {
                    isSelected = true;
                } else {
                    isSelected = false;
                }

                if (isSelected) {
                    hamburger.classList.remove('selected');
                    nav.classList.remove('hidden');
                } else {
                    hamburger.classList.add('selected');
                    nav.classList.add('hidden');
                }
            }

            const hamburger = document.getElementById('hamburger');
            hamburger.addEventListener('click', toggleMenu);

        })
        .catch(error => {
            console.error('Error:', error);
        });

    // Hacer la solicitud para obtener el contenido de login.html
    fetch('login.html')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar el archivo');
            }
            return response.text(); // Convertir la respuesta a texto
        })
        .then(html => {
            // Insertar el contenido de login.html dentro del contenedor
            document.getElementById('login-container').innerHTML = html;

            const openModalButton = document.getElementById('openModal');
            const closeModalButton = document.getElementById('closeModal');

            // Función para abrir el modal
            function openModal() {
                const modal = document.getElementById('modal');
                if (modal) {
                    modal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                } else {
                    console.error('El elemento modal es nulo.');
                }
            }

            // Función para cerrar el modal
            function closeModal() {
                const modal = document.getElementById('modal');
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    console.error('El elemento modal es nulo.');
                }
            }

            // Event listeners para abrir y cerrar el modal
            if (openModalButton && closeModalButton) {
                openModalButton.addEventListener('click', openModal);
                closeModalButton.addEventListener('click', closeModal);
            } else {
                console.error('Alguno de los elementos openModalButton o closeModalButton es nulo.');
            }

            // Event listener para abrir el modal de registro
            const openRegistroModelButton = document.getElementById('openRegistroModel');
            if (openRegistroModelButton) {
                openRegistroModelButton.addEventListener('click', openRegistroModal);
            } else {
                console.error('El elemento openRegistroModelButton es nulo.');
            }

        })
        .catch(error => {
            console.error('Error:', error);
        });
};

// Función para abrir el modal de registro
function openRegistroModal() {
    const registroModal = document.getElementById('registroModal');
    if (registroModal) {
        registroModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    } else {
        console.error('El elemento registroModal es nulo.');
    }
}

// Función para cerrar el modal de registro
function closeRegistroModal() {
    const registroModal = document.getElementById('registroModal');
    if (registroModal) {
        registroModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    } else {
        console.error('El elemento registroModal es nulo.');
    }
}
