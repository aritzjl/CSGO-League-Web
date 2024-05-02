<?php
// Cargar el nombre de la temporada seleccionada
$temporada_seleccionada = isset($_GET['temporada']) ? $_GET['temporada'] : '';

// Cargar el documento XML
$xml = new DOMDocument;
$xml->load('../xmlxsl/csleague.xml');

// Obtener todas las temporadas del XML
$temporadas = $xml->getElementsByTagName('Temporada');

// Variable para almacenar el número total de jornadas
$total_jornadas = 0;

// Variable para almacenar la temporada activa
$temporada_activa = '';

// Iterar sobre todas las temporadas para encontrar la activa
foreach ($temporadas as $temporada) {
    $estado_temporada = $temporada->getElementsByTagName('Estado')->item(0)->nodeValue;
    if ($estado_temporada == 'ACTIVA') {
        $temporada_activa = $temporada->getElementsByTagName('Numero')->item(0)->nodeValue;
        // Obtener las jornadas de la temporada activa
        $jornadas = $temporada->getElementsByTagName('Jornada');
        $total_jornadas = $jornadas->length;
        break; // Detener el bucle una vez que se encuentra la temporada activa
    }
}

// Verificar si la redirección es necesaria
if ($temporada_seleccionada == '') {
    // Redirigir al usuario al archivo clasi.php con el parámetro de la temporada activa
    header("Location: clasi.php?temporada=$temporada_activa");
    exit; // Asegurarse de que el script se detenga después de redirigir
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="../img/logo.png" type="image/x-icon">
    <title>Temporada <?php echo $temporada_seleccionada ?></title>
</head>

<body class="w-screen h-full m-0 p-0 md:flex md:flex-row">
    <!-- Elemento para la animación de carga -->
    <div id="loading" class="w-screen h-screen absolute z-50 bg-black">
        <div class="flex justify-center w-full h-full ">
            <div class="flex flex-col items-center justify-center animate-pulse">
                <h1 class="text-2xl font-bold text-[#ffff09]">
                    CARGANDO...
                </h1>
                <img src="../img/scope-yellow.svg" alt="" class="w-80 animate-spin" />
            </div>
        </div>
    </div>

    <!-- Contenedor del encabezado -->
    <div id="header-container"></div>
    <!-- Contenedor del inicio de sesión -->
    <div id="login-container"></div>
    <!-- Contenedor principal con fondo de imagen -->
    <div class="w-full h-screen m-0 p-0  overflow-y-auto bg-cover bg-scroll bg-bottom bg-no-repeat shadow-lg"
        style="background-image:url('../img/fondo2.jpg');">
        <div class="w-full h-auto backdrop-blur-sm bg-cover  bg-no-repeat flex flex-col items-center">
            <!-- Sección del banner con el título de la temporada seleccionada -->
            <article class="w-full mt-16 md:w-10/12 flex flex-col justify-left md:flex-row md:justify-between mb-6">
                <h1
                    class="mb-4 text-4xl font-extrabold leading-none tracking-tight ml-2 text-white md:text-5xl lg:text-6xl ">
                    Temporada <span
                        class="underline underline-offset-3 decoration-8 decoration-[#ffff09]"><?php echo $temporada_seleccionada ?></span>
                </h1>
                <div class="w-auto flex justify-start md:flex-col md:justify-center ">
                    <!-- Formulario para seleccionar la temporada -->
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" id="temporadaForm">
                        <select name="temporada" id="temporada"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                            <!-- Opción predeterminada deshabilitada -->
                            <option value="" disabled <?php if ($temporada_seleccionada == '')
                                echo 'selected'; ?>
                                style="display:none;">Elige una temporada</option>
                            <!-- Iteración sobre las temporadas disponibles -->
                            <?php
                            foreach ($temporadas as $temporada_option) {
                                $numero_temporada = $temporada_option->getElementsByTagName('Numero')->item(0)->nodeValue;
                                $selected = ($temporada_seleccionada == $numero_temporada) ? 'selected' : '';
                                echo "<option value='$numero_temporada' $selected>$numero_temporada</option>";
                            }
                            ?>
                        </select>
                    </form>

                </div>
            </article>
            <!-- Aplicar la transformación XSLT solo si se ha seleccionado una temporada -->
            <?php
            if ($temporada_seleccionada != '') {
                // Cargar la hoja de estilo XSLT
                $xsl = new DOMDocument;
                $xsl->load('../xmlxsl/clasificacion.xsl');

                // Crear el procesador XSLT
                $proc = new XSLTProcessor;

                // Adjuntar la hoja de estilo XSLT al procesador
                $proc->importStyleSheet($xsl);

                // Pasar parámetros al XSLT
                $proc->setParameter('', 'temporadaSeleccionada', $temporada_seleccionada);

                // Aplicar la transformación
                $resultado = $proc->transformToXML($xml);

                // Imprimir el resultado
                echo $resultado;
            }
            ?>

            <?php
            // Generar la sección del calendario
            echo '<!-- Sección CALENDARIO -->';
            echo '<div class="w-full md:w-10/12 mt-16">';
            echo '<h1 class="mb-6 text-4xl font-extrabold leading-none tracking-tight ml-2 text-white md:text-5xl lg:text-6xl ">Calendario</h1>';
            echo '</div>';
            echo '<section class="w-full h-full flex flex-col items-center bg-[url(\'../img/estadio.jpg\')] bg-cover bg-no-repeat bg-local bg-opacity-10 md:w-10/12 overflow-hidden mb-16">';

            // Contador de jornadas
            $jornadaIndex = 1;

            // Loop a través de cada temporada
            foreach ($temporadas as $temporada) {
                $numeroTemporada = $temporada->getElementsByTagName('Numero')->item(0)->nodeValue;
                if ($numeroTemporada == $temporada_seleccionada) {
                    // Obtener las jornadas de la temporada seleccionada
                    $jornadas = $temporada->getElementsByTagName('Jornada');
                    if ($jornadas->length > 0) {
                        // Loop a través de cada jornada
                        foreach ($jornadas as $jornada) {
                            // Obtener el número de la jornada actual
                            $jornadaNumero = $jornada->getElementsByTagName('Numero')->item(0)->nodeValue;
                            $fechaDia = $jornada->getElementsByTagName('Dia')->item(0)->nodeValue;
                            $fechaMes = $jornada->getElementsByTagName('Mes')->item(0)->nodeValue;
                            $fechaAnio = $jornada->getElementsByTagName('Año')->item(0)->nodeValue;

                            // Inicio del carrusel de jornadas
                            echo '<button class="text-3xl font-extrabold bg-[#ffff09] p-2 rounded-lg mb-4" onclick="mostrarOcultarPartidos(\'jornada' . $jornadaNumero . '\')">JORNADA ' . $jornadaNumero . ' - ' . $fechaDia . '/' . $fechaMes . '/' . $fechaAnio . '</button>';
                            // Contenedor de los partidos de la jornada
                            echo "<div id='jornada$jornadaNumero' style='display:none; transition: max-height 0.3s ease;' class='w-full sm:w-auto h-auto sm:h-auto flex flex-wrap justify-center items-center sm:flex-row p-4 rounded-xl'>";

                            // Obtener los partidos de la jornada
                            $partidos = $jornada->getElementsByTagName('Partido');

                            // Loop a través de cada partido
                            foreach ($partidos as $partido) {
                                $equipoLocalNombre = $partido->getElementsByTagName('EquipoLocal')->item(0)->nodeValue;
                                $equipoVisitanteNombre = $partido->getElementsByTagName('EquipoVisitante')->item(0)->nodeValue;
                                $puntosLocal = $partido->getElementsByTagName('PuntosLocal')->item(0)->nodeValue;
                                $puntosVisitante = $partido->getElementsByTagName('PuntosVisitante')->item(0)->nodeValue;

                                // Obtener la información del equipo local
                                $xpath = new DOMXPath($xml);
                                $equipoLocal = $xpath->query("//Temporada[Numero='$temporada_seleccionada']/Equipos/Equipo[Nombre='$equipoLocalNombre']");
                                if ($equipoLocal->length > 0) {
                                    $escudoLocal = $equipoLocal->item(0)->getElementsByTagName('Escudo')->item(0)->nodeValue;
                                } else {
                                    $escudoLocal = ''; // Manejar el caso en que no se encuentra el equipo local
                                }

                                // Obtener la información del equipo visitante
                                $equipoVisitante = $xpath->query("//Temporada[Numero='$temporada_seleccionada']/Equipos/Equipo[Nombre='$equipoVisitanteNombre']");
                                if ($equipoVisitante->length > 0) {
                                    $escudoVisitante = $equipoVisitante->item(0)->getElementsByTagName('Escudo')->item(0)->nodeValue;
                                } else {
                                    $escudoVisitante = ''; // Manejar el caso en que no se encuentra el equipo visitante
                                }

                                echo "<div class='inline-flex items-center justify-center p-4 rounded-xl backdrop-blur'>";
                                echo "<img src='../xmlxsl/$escudoLocal' alt='' class='w-20'>";
                                echo "<div class='mx-6 flex items-center'>";
                                echo "<h3 class='text-[#ffff09] text-xl font-extrabold'>$puntosLocal - $puntosVisitante</h3>";
                                echo '</div>';
                                echo "<img src='../xmlxsl/$escudoVisitante' alt='' class='w-20'>";
                                echo '</div>';
                            }


                            echo '</div>'; // Cierre del contenedor de los partidos de la jornada
                        }
                    } else {
                        echo "No hay datos de jornadas disponibles para esta temporada.";
                    }
                }
            }

            echo '</section>'; // Cierre de la sección del calendario
            ?>

        </div>
        <!-- Contenedor del pie de página -->
        <div id="footer-container"></div>

    </div>

    <!-- Scripts -->
    <script src="../js/headerfooterpages.js"></script>
    <script src="../js/clasificacion.js"></script>
</body>

</html>
