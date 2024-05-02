// VALIDACIONES PUBLICAR NOTICIA

/**
 * Función para publicar una noticia después de realizar validaciones en el formulario.
 */
function publicarNoticia() {
    // Obtenemos el formulario y el modal de la noticia
    var form = document.getElementById('addNoticiaForm');
    var modalNoticia = document.getElementById('modalAddNoticia');
    
    // Creamos un objeto FormData para recopilar los datos del formulario
    var formData = new FormData(form);

    // Variable para almacenar el mensaje de error
    var errorMessage = '';

    // Realizamos validaciones
    // Validamos si se han completado todos los campos
    if (formData.get('titulo') === '' || formData.get('contenido') === '' || formData.get('imagen') === null) {
        errorMessage = 'Por favor, complete todos los campos.';
    } else if (formData.get('imagen').size > 2097152) { // Validamos el tamaño de la imagen (no debe superar los 2MB)
        errorMessage = 'La imagen no debe superar los 2MB.';
    } else if (!formData.get('imagen').type.includes('image')) { // Validamos si el archivo seleccionado es una imagen
        errorMessage = 'El archivo seleccionado no es una imagen.';
    } else if (formData.get('titulo').length > 100) { // Validamos la longitud del título (no debe superar los 100 caracteres)
        errorMessage = 'El título no debe superar los 100 caracteres.';
    } else if (formData.get('contenido').length > 60) { // Validamos la longitud del contenido (no debe superar los 500 caracteres)
        errorMessage = 'El contenido no debe superar los 60 caracteres.';
    } else if (formData.get('titulo').length < 10) { // Validamos que el título tenga al menos 10 caracteres
        errorMessage = 'El título debe tener al menos 10 caracteres.';
    } else if (formData.get('contenido').length < 10) { // Validamos que el contenido tenga al menos 50 caracteres
        errorMessage = 'El contenido debe tener al menos 10 caracteres.';
    }

    // Si hay un mensaje de error, mostramos el modal y detenemos la ejecución
    if (errorMessage !== '') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            iconColor: '#ffff09',
            color: "white",
            confirmButtonText: 'Aceptar',
            background: '#1d1d1b',
            confirmButtonColor: 'black',
            text: errorMessage,

        });
        return;
    }

    // Realizamos una petición fetch para guardar la noticia
    fetch('../ActionsPHP/guardar_noticia.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // Verificamos si la respuesta es exitosa
        if (!response.ok) {
            throw new Error('Error al publicar la noticia');
        } else {
            // Si la noticia se publicó correctamente, mostramos un mensaje de éxito
            Swal.fire({
                icon: 'success',
                title: 'Noticia publicada',
                text: 'La noticia se ha publicado correctamente.',
                iconColor: '#ffff09',
                color: "white",
                confirmButtonText: 'Aceptar',
                background: '#1d1d1b',
                confirmButtonColor: 'black'

            }).then((result) => {
                // Después de que el usuario presione "OK", recargamos la página
                if (result.isConfirmed) {
                    location.reload();
                }
            });
            // Reiniciamos el formulario y ocultamos el modal
            form.reset();
            modalNoticia.classList.add('hidden');
        }
    })
    .catch(error => {
        // Capturamos cualquier error durante la petición fetch y mostramos un mensaje de error
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ha ocurrido un error al publicar la noticia. Por favor, inténtelo de nuevo.',
            iconColor: '#ffff09',
            color: "white",
            confirmButtonText: 'Aceptar',
            background: '#1d1d1b',
            confirmButtonColor: 'black'
        });
    });
}

// Asignamos el evento click al botón de publicar noticia
const PublicarNoticiaButton = document.getElementById('PublicarNoticiaButton');
PublicarNoticiaButton.addEventListener('click', () => {
    // Llamamos a la función publicarNoticia al hacer clic en el botón
    publicarNoticia();
});
