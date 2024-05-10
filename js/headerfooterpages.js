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

    // Hacer la solicitud para obtener el contenido del encabezado
    fetch('../Header_Footer/header.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar el archivo');
            }
            return response.text(); // Convertir la respuesta a texto
        })
        .then(html => {
            // Crear un div temporal para contener el contenido del encabezado
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
            console.error('Error al cargar el encabezado:', error);
        });

    // Hacer la solicitud para obtener el contenido del pie de página
    fetch('../Header_Footer/footer.html')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar el archivo');
            }
            return response.text(); // Convertir la respuesta a texto
        })
        .then(html => {
            // Crear un div temporal para contener el contenido del pie de página
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;

            // Insertar el contenido como hermano del marcador de posición
            const placeholderDiv = document.getElementById('footer-container');
            placeholderDiv.parentNode.insertBefore(tempDiv.firstChild, placeholderDiv.nextSibling);

            // Eliminar el marcador de posición
            placeholderDiv.parentNode.removeChild(placeholderDiv);
        })
        .catch(error => {
            console.error('Error al cargar el pie de página:', error);
        });

    // Hacer la solicitud para obtener el nombre de usuario
    fetch('../ActionsPHP/user_data.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar el archivo');
            }
            return response.json(); // Convertir la respuesta a JSON
        })
        .then(data => {
            // Cambiar el texto del botón de login por el nombre del usuario si existe el elemento
            const logintext = document.getElementById('loginText');
            if (logintext) {
                logintext.textContent = data;
            }

            // Si el usuario está loggeado, mostrar el botón de logout y ocultar el botón de login
            if (data !== "LOGIN") {
                var logout = document.getElementById('logout');
                if (logout) {
                    logout.classList.remove('hidden');
                }
                var openModalButton = document.getElementById('openModal');
                if (openModalButton) {
                    openModalButton.classList.add('hidden');
                }
            }
        })
        .catch(error => {
            console.error('Error al cargar los datos del usuario:', error);
        });

    // Hacer la solicitud para obtener el contenido del modal
    fetch('../pages/login.html')
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
        })
        .catch(error => {
            console.error('Error al cargar el contenido del modal:', error);
        });
};
