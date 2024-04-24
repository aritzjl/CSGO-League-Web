<!DOCTYPE html>
<html lang="en">
<?php
    // Cargar el nombre de la temporada seleccionada
    $temporada_seleccionada = isset($_GET['temporada']) ? $_GET['temporada'] : '';

    // Cargar el documento XML
    $xml = new DOMDocument;
    $xml->load('../xmlxsl/csleague.xml');

    // Obtener todas las temporadas del XML
    $temporadas = $xml->getElementsByTagName('Temporada');
    ?>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script> <!-- tailwindcss CDN -->
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="../img/logo.png" type="image/x-icon">
    <title>Inicio</title>
</head>

<body class="w-screen h-full m-0 p-0 md:flex md:flex-row">
    <!--ANIMACIÓN DE CARGA-->
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

    <div id="header-container"></div>
    <div id="login-container"></div>
    <div class="w-full h-screen m-0 p-0  overflow-y-auto bg-cover bg-scroll bg-bottom bg-no-repeat shadow-lg"
        style="background-image:url('../img/fondo2.jpg');">
        <div class="w-full h-auto backdrop-blur-sm bg-cover  bg-no-repeat flex flex-col items-center">
            <!--BANNER-->
            <article class="w-full mt-16 md:w-10/12 flex flex-col justify-left md:flex-row md:justify-between mb-6">
                <h1
                    class="mb-4 text-4xl font-extrabold leading-none tracking-tight ml-2 text-white md:text-5xl lg:text-6xl ">
                    Temporada <span
                        class="underline underline-offset-3 decoration-8 decoration-[#ffff09]">2023-2024</span></h1>
                <div class="w-auto flex justify-start md:flex-col md:justify-center ">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" id="temporadaForm">
                        <select name="temporada" id="temporada" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                            <option value="" disabled <?php if ($temporada_seleccionada == '') echo 'selected'; ?> style="display:none;">Elige una temporada</option>
                            <?php
                            // Iterar sobre las temporadas para crear las opciones
                            foreach ($temporadas as $temporada) {
                                $numero_temporada = $temporada->getElementsByTagName('Numero')->item(0)->nodeValue;
                                $selected = ($temporada_seleccionada == $numero_temporada) ? 'selected' : '';
                                echo "<option value='$numero_temporada' $selected>$numero_temporada</option>";
                            }
                            ?>
                        </select>
                    </form>

                </div>
            </article>
    <!-- Aplicar la transformación solo si se ha seleccionado una temporada -->
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
    // Variable para almacenar la temporada activa
    $temporada_activa = '';

    // Iterar sobre todas las temporadas para encontrar la activa
    foreach ($temporadas as $temporada) {
        $estado_temporada = $temporada->getElementsByTagName('Estado')->item(0)->nodeValue;
        if ($estado_temporada == 'ACTIVA') {
            $temporada_activa = $temporada->getElementsByTagName('Numero')->item(0)->nodeValue;
            break; // Detener el bucle una vez que se encuentra la temporada activa
        }
    }

    // Redirigir al usuario al archivo clasi.php con el parámetro de la temporada activa
    header("Location: clasi.php?temporada=$temporada_activa");
?>
    <script src="../js/headerfooterpages.js"></script>
    <script src="../js/clasificacion.js"></script>
</body>

</html>
