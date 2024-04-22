<?php
// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$grupo = $_POST['grupo'];
$nota = $_POST['nota'];

// Crear un nuevo documento XML
$doc = new DOMDocument();
$doc->formatOutput = true;

// Crear el elemento raíz <alumnos>
$alumnos = $doc->createElement('alumnos');
$doc->appendChild($alumnos);

// Crear el elemento <alumno> y sus atributos
$alumno = $doc->createElement('alumno');
$alumno->setAttribute('grupo', $grupo);
$alumnos->appendChild($alumno);

// Crear elementos para los datos del alumno
$nombreElement = $doc->createElement('nombre', $nombre);
$apellidosElement = $doc->createElement('apellidos', $apellidos);
$notaElement = $doc->createElement('nota', $nota);

// Agregar elementos al elemento <alumno>
$alumno->appendChild($nombreElement);
$alumno->appendChild($apellidosElement);
$alumno->appendChild($notaElement);

// Guardar el documento XML en un archivo
$doc->save('datos.xml');

// Mostrar el contenido del archivo XML
echo "Datos guardados correctamente en datos.xml:\n";
echo $doc->saveXML();
?>
