<?php
// Ruta del archivo XML
$xmlFile = "../xmlxsl/noticias.xml";

// Verificar si se ha recibido una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del comentario desde la solicitud POST
    $nombre = $_POST["commentUsername"];
    $contenido = $_POST["commentContent"];
    $noticiaId = $_POST["noticiaId"];

    // Validar los datos recibidos (puedes agregar más validaciones según tus necesidades)
    if (empty($nombre) || empty($contenido) || empty($noticiaId)) {
        echo "Error: Todos los campos son obligatorios.";
        exit();
    }

    // Escapar caracteres especiales para evitar problemas de XML (opcional)
    $nombre = htmlspecialchars($nombre);
    $contenido = htmlspecialchars($contenido);

    // Cargar el archivo XML
    $xml = simplexml_load_file($xmlFile);

    // Buscar la noticia con el ID especificado
    $noticia = $xml->xpath("//noticia[@id='$noticiaId']");
    if (empty($noticia)) {
        echo "Error: No se encontró la noticia especificada.";
        exit();
    }

    // Crear el nuevo comentario
    $nuevoComentario = $noticia[0]->comentarios->addChild('comentario');
    $nuevoComentario->addChild('nombre', $nombre);
    $nuevoComentario->addChild('fecha', date("Y-m-d")); // Agregar la fecha actual
    $nuevoComentario->addChild('contenido', $contenido);

    // Guardar los cambios en el archivo XML
    $xml->asXML($xmlFile);

    // Mostrar mensaje de éxito
    echo "Comentario guardado exitosamente.";

} else {
    // Si no se recibió una solicitud POST, mostrar un mensaje de error
    echo "Error: Se esperaba una solicitud POST.";
}
