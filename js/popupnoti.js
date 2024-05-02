function obtenerComentarios(noticiaId, callback) {
    // Aquí realizarías una petición AJAX para obtener el XML de los comentarios
    // Por ahra, vamos a cargar el XML directamente desde el documento XML de noticias.xml
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Cuando se completa la solicitud y el estado es 200 (OK), procesamos el XML
            var xmlDoc = this.responseXML;
            // Llamamos a la función procesarComentarios para obtener los comentarios de la noticia
            var comentarios = procesarComentarios(xmlDoc, noticiaId);
            // Llamamos al callback con los comentarios obtenidos
            callback(comentarios);
        }
    };
    // Hacemos la solicitud GET al archivo noticias.xml
    xhttp.open("GET", "../xmlxsl/noticias.xml", true);
    xhttp.send();
}

// Función para procesar los comentarios del XML y obtener los comentarios de una noticia específica
function procesarComentarios(xmlDoc, noticiaId) {
    var comentarios = [];
    // Buscamos la noticia correspondiente al ID
    var noticia = xmlDoc.querySelector("noticia[id='" + noticiaId + "']");
    if (noticia) {
        // Si encontramos la noticia, obtenemos sus comentarios
        var comentarioElements = noticia.querySelectorAll('comentario');
        comentarioElements.forEach(function(comentarioElement) {
            var comentario = {
                nombre: comentarioElement.querySelector('nombre').textContent,
                fecha: comentarioElement.querySelector('fecha').textContent,
                contenido: comentarioElement.querySelector('contenido').textContent
            };
            comentarios.push(comentario);
        });
    }
    return comentarios;
}

var comentariosMostrados = 5; // Número inicial de comentarios mostrados
var comentariosPorPagina = 5; // Número de comentarios por página

function mostrarComentarios(comentarios, id) {
    // Código para mostrar los comentarios en el popup
    // Por ejemplo, puedes recorrer el array de comentarios y construir elementos HTML para cada uno de ellos
    var comentariosHTML = "";
    for (var i = 0; i < comentariosMostrados && i < comentarios.length; i++) {
        comentariosHTML += "<div class='text-[#ffff09]'><span>" + comentarios[i].fecha + "</span> <strong>" + comentarios[i].nombre + "</strong>: " + comentarios[i].contenido + "</div>";
    }
    // Si hay más comentarios que los mostrados actualmente, agregamos el botón "Ver más"
    if (comentariosMostrados < comentarios.length) {
        comentariosHTML += "<button onclick='verMasComentarios(" + comentarios.length + ", \"" + id + "\")' class='text-[#ffff09] mt-2'>Ver más</button>";
    }
    return comentariosHTML;
}

function verMasComentarios(totalComentarios, id) {
    // Aumentar el número de comentarios mostrados
    comentariosMostrados += comentariosPorPagina;
    // Volver a mostrar los comentarios con el nuevo número de comentarios mostrados
    obtenerComentarios(id, function(comentarios) {
        document.getElementById("popup-comentarios").innerHTML = mostrarComentarios(comentarios, id);
    });
}

function abrirPopup(imagen, titulo, descripcion, id) {
    // Mostrar el popup
    var popup = document.getElementById("popup");
    popup.classList.remove("hidden");

    // Llenar el contenido del popup con los datos de la noticia
    var popupContent = `
        <img src="${imagen}" alt="${titulo}" class="w-full h-40 object-cover rounded-lg mb-4"/>
        <h1 class="text-xl  text-[#ffff09] font-bold mb-2">${titulo}</h1>
        <p class="text-[#ffff09]">${descripcion}</p>
    `;
    // Asignar el contenido al elemento con la clase "noticia" dentro del popup
    popup.querySelector(".noticia").innerHTML = popupContent;

    // Establecer el ID de la noticia en el formulario de comentarios
    document.getElementById("noticiaId").value = id;

    // Obtener los comentarios y mostrarlos en el popup
    obtenerComentarios(id, function(comentarios) {
        document.getElementById("popup-comentarios").innerHTML = mostrarComentarios(comentarios, id);
    });
}

function cerrarPopup() {
    var popup = document.getElementById("popup");
    popup.classList.add("hidden");
}
var userName = '<?php echo htmlspecialchars($username); ?>';

function enviarComentario(event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    // Obtener los datos del formulario
    var formData = new FormData(event.target);

    //Validaciones con JS
    var contenidoComentario = formData.get('commentContent');
    var errorMessage = ""

    if(contenidoComentario.length < 10){
        errorMessage = "El comentario debe tener al menos 10 caracteres.";
    }else if(contenidoComentario.length > 500){
        errorMessage = "El comentario no debe superar los 500 caracteres.";
    }

    if(errorMessage !== ""){
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



    // Enviar el comentario mediante una petición AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../ActionsPHP/guardar_comentario.php", true);
    xhr.onreadystatechange = function() {
        // Manejar la respuesta del servidor aquí
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // La solicitud se completó y se recibió una respuesta exitosa
                console.log(xhr.responseText); // Puedes hacer algo con la respuesta, como mostrar un mensaje de éxito

                // Actualizar los comentarios en el popup
                var noticiaId = formData.get("noticiaId");
                obtenerComentarios(noticiaId, function(comentarios) {
                    document.getElementById("popup-comentarios").innerHTML = mostrarComentarios(comentarios, noticiaId);
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Comentario enviado',
                    iconColor: '#ffff09',
                    color: "white",
                    confirmButtonText: 'Aceptar',
                    background: '#1d1d1b',
                    confirmButtonColor: 'black',
                    text: 'El comentario se ha enviado correctamente.',
                });
                event.target.reset(); // Limpiar el formulario

            } else {
                // Hubo un error al procesar la solicitud
                console.error("Error al enviar el comentario:", xhr.statusText);
            }
        }
    };
    xhr.send(formData);
}





