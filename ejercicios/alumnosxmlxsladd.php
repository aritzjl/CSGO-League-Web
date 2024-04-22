<?php
// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$grupo = $_POST['grupo'];
$nota = $_POST['nota'];

// Cargar o crear el archivo XML
$xmlFile = 'datos.xml';
if (!file_exists($xmlFile)) {
    // Crear el archivo XML si no existe
    $xml = new SimpleXMLElement('<alumnos></alumnos>');
} else {
    // Cargar el archivo XML si existe
    $xml = simplexml_load_file($xmlFile);
}

// Añadir un nuevo alumno al XML
$alumno = $xml->addChild('alumno');
$alumno->addChild('nombre', $nombre);
$alumno->addChild('apellidos', $apellidos);
$alumno->addChild('grupo', $grupo);
$alumno->addChild('nota', $nota);

// Guardar todos los alumnos en el archivo XML
$xml->asXML($xmlFile);

// Mostrar los datos por pantalla usando la transformación XSL
$xml->asXML('alumnos.xml'); // Guardar una copia para la transformación
$xsl = new DOMDocument();
$xsl->load('alumnos.xsl');

$xmlDoc = new DOMDocument();
$xmlDoc->load('alumnos.xml');

$proc = new XSLTProcessor();
$proc->importStylesheet($xsl);
echo $proc->transformToXML($xmlDoc);
?>
