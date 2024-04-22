<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];

    $xml = new DOMDocument();
    $xml->load('datos.xml');


    $xpath = new DOMXPath($xml);


    $query = "//alumno[nombre='$nombre']";
    $alumnos = $xpath->query($query);

    
    if ($alumnos->length > 0) {

        echo "<h2 class='text-2xl font-bold mb-4'>Alumnos de nombre: $nombre</h2>";

        echo "<table class='border-collapse border border-gray-400'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th class='border border-gray-400 px-4 py-2'>Nombre</th>";
        echo "<th class='border border-gray-400 px-4 py-2'>Apellidos</th>";
        echo "<th class='border border-gray-400 px-4 py-2'>Grupo</th>";
        echo "<th class='border border-gray-400 px-4 py-2'>Nota</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";


        foreach ($alumnos as $alumno) {
            $nombre = $alumno->getElementsByTagName('nombre')->item(0)->nodeValue;
            $apellidos = $alumno->getElementsByTagName('apellidos')->item(0)->nodeValue;
            $grupo = $alumno->getElementsByTagName('grupo')->item(0)->nodeValue;
            $nota = $alumno->getElementsByTagName('nota')->item(0)->nodeValue;

            echo "<tr>";
            echo "<td class='border border-gray-400 px-4 py-2'>$nombre</td>";
            echo "<td class='border border-gray-400 px-4 py-2'>$apellidos</td>";
            echo "<td class='border border-gray-400 px-4 py-2'>$grupo</td>";
            echo "<td class='border border-gray-400 px-4 py-2'>$nota</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {

        echo "No se ha encontrado ningún alumno con el nombre '$nombre'.";
    }
}
?>
