      /*  // Hacer la solicitud para obtener el contenido de header.html
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
            })
            .catch(error => {
                console.error('Error:', error);
            });
*/


                

