<?php
// Verifica si se han enviado los datos del formulario
// Verifica si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén los valores del formulario
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];
    $imagen = $_FILES["imagen"]; // Utiliza $_FILES para acceder a la información del archivo

    // Renombra la imagen con el título de la noticia
    $imagenNombreOriginal = $imagen["name"];
    $extension = pathinfo($imagenNombreOriginal, PATHINFO_EXTENSION); // Obtiene la extensión del archivo
    $imagenNombreNuevo = str_replace(" ", "_", $titulo) . "." . $extension; // Reemplaza los espacios en blanco por guiones bajos y agrega la extensión

    // Ruta donde se guardará la imagen
    $directorioDestino = "../img/imagenesnoticias/"; // Ajusta la ruta según la ubicación de guardarcomentario.php

    // Guarda la imagen en el directorio destino con el nuevo nombre
    if (move_uploaded_file($imagen["tmp_name"], $directorioDestino . $imagenNombreNuevo)) {
        // La imagen se ha subido correctamente

        // Crea un objeto DOMDocument para cargar el archivo XML
        $xml = new DOMDocument();
        $xml->load('../xmlxsl/noticias.xml'); // Ajusta la ruta según la ubicación de guardarcomentario.php

        // Genera un ID único para la nueva noticia
        $noticias = $xml->getElementsByTagName("noticia");
        $nuevaId = $noticias->length + 1;

        // Crea el elemento <noticia> y sus hijos
        $noticia = $xml->createElement("noticia");
        $noticia->setAttribute("id", $nuevaId); // Agrega el atributo id

        $tituloElem = $xml->createElement("titulo", $titulo);
        $contenidoElem = $xml->createElement("descripcion", $contenido);
        $imagenElem = $xml->createElement("imagen", $directorioDestino . $imagenNombreNuevo); // Utiliza la ruta completa de la imagen

        // Crea la estructura de comentarios
        $comentarios = $xml->createElement("comentarios");
        $comentario = $xml->createElement("comentario");
        $nombre = $xml->createElement("nombre");
        $fecha = $xml->createElement("fecha");
        $contenidoComentario = $xml->createElement("contenido");

        // Agrega los nodos de comentarios vacíos
        $comentario->appendChild($nombre);
        $comentario->appendChild($fecha);
        $comentario->appendChild($contenidoComentario);
        $comentarios->appendChild($comentario);

        // Agrega los hijos al elemento <noticia>
        $noticia->appendChild($tituloElem);
        $noticia->appendChild($contenidoElem);
        $noticia->appendChild($imagenElem);
        $noticia->appendChild($comentarios);

        // Obtiene el elemento raíz <noticias>
        $noticias = $xml->getElementsByTagName("noticias")->item(0);

        // Agrega la nueva noticia al elemento raíz
        $noticias->appendChild($noticia);

        // Guarda el archivo XML
        $xml->save('../xmlxsl/noticias.xml'); // Ajusta la ruta según la ubicación de guardarcomentario.php

        // Devuelve un código de estado HTTP 200 para indicar éxito
        header("Location: ../pages/noticias.php"); // Ajusta la ruta según la ubicación de guardarcomentario.php
    } else {
        // Error al subir la imagen
        echo "Error al subir la imagen.";
    }
}
