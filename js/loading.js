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
    }, 1000); // Tiempo de espera (en milisegundos)
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

            /*
            // Ejecutar la función toggleMenu cada vez que se hace clic en algún elemento
            document.addEventListener('click', function(event) {
                toggleMenu();
            });*/
            const modal = document.getElementById('modal');
            const openModalButton = document.getElementById('openModal');
           
            const closeModalButton = document.getElementById('closeModal');

            // Función para abrir el modal
            function openModal() {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                document.getElementById('openRegistroModel').addEventListener('click', openRegistroModal);
            }

            // Función para cerrar el modal
            function closeModal() {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // Event listeners para abrir y cerrar el modal
            openModalButton.addEventListener('click', openModal);
            closeModalButton.addEventListener('click', closeModal);

            function openRegistroModal() {
                document.getElementById('modal').classList.add('hidden');
                document.getElementById('registroModal').classList.remove('hidden');
            }

            document.getElementById('closeRegistroModal').addEventListener('click', function () {
                document.getElementById('registroModal').classList.add('hidden');
                document.getElementById('modal').classList.remove('hidden');
            });

            function submitForm(event) {
                event.preventDefault(); // Evita que se envíe el formulario de manera tradicional

                // Obtener los datos del formulario
                var formData = {
                    nombre: $('#nombre').val(),
                    apellido: $('#apellido').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    confirmPassword: $('#confirmPassword').val()
                };

                // Enviar los datos del formulario al servidor
                $.ajax({
                    type: 'POST',
                    url: '../csl/register.php', // Ruta al archivo PHP que procesa el formulario
                    data: formData,
                    success: function (response) {
                        // Manejar la respuesta del servidor
                        $('#mensaje').html(response); // Mostrar el mensaje del servidor en el elemento con id "mensaje"
                    }
                });
            }

        })
        .catch(error => {
            console.error('Error:', error);
        });

};

