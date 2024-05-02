<?php
// Verificar si clubID está definido en el formulario
if (isset($_POST['clubID'])) {
    // Obtener el valor de clubID del envío anterior del formulario
    $clubID = $_POST['clubID'];
    // Inicializar temporadaNum con una cadena vacía por defecto
    $temporadaNum = "";

    // Verificar si temporadaNum está definido en el formulario
    if (isset($_POST['temporadaNum'])) {
        // Si está definido, asignar su valor a la variable $temporadaNum
        $temporadaNum = $_POST['temporadaNum'];
    }

    $xmlPath = "../XmlXsl/csleague.xml";

    // Load the XML file if exists
    if (file_exists($xmlPath)) {
        $xml = simplexml_load_file($xmlPath);

        if ($temporadaNum == "") { // Si no se especifica la temporada, obtenemos la Activa, si no hay activa, obtenemos la última que ha finalizado, si tampoco hay, elegimos la próxima
            $temporadaActiva = $xml->xpath("//Temporada[Estado='ACTIVA']");
            if ($temporadaActiva) {
                $temporadaNum = $temporadaActiva[0]->Numero;
            } else {
                $temporadaActiva = $xml->xpath("//Temporada[Estado='FINALIZADA']");
                if ($temporadaActiva) {
                    $lastIndex = count($temporadaActiva) - 1;
                    $temporadaNum = $temporadaActiva[$lastIndex]->Numero;
                } else {
                    $temporadaActiva = $xml->xpath("//Temporada[Estado='PROXIMAMENTE']");
                    if ($temporadaActiva) {
                        $temporadaNum = $temporadaActiva[0]->Numero;
                    } else {
                        exit('No hay temporadas disponibles');
                    }
                }
            }
        }

        // Find the club with the given clubID
        $club = $xml->xpath("//Temporada[Numero='$temporadaNum']/Equipos/Equipo[Nombre='$clubID']");
        if (!empty($club)) {
            $club = $club[0];
        }

        $listaTemporadas = $xml->xpath("//Temporada");
        // Descartamos las temporadas en las que nuestro equipo NO participa
        $temporadasFiltradas = $xml->xpath("//Temporada[Equipos/Equipo/Nombre='$clubID']");
        // Eliminar la siguiente línea para que no sobrescriba la lista de temporadas filtradas
        // $listaTemporadas = $temporadasFiltradas;
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="stylesheet" href="../css/styles.css">
            <link rel="icon" href="../img/logo.png" type="image/x-icon">
            <title>Club <?php echo $clubID ?></title>
        </head>

        <body class="w-full h-full m-0 p-0 bg-green-200 flex flex-col md:flex-row bg-url">
            <!-- ANIMACIÓN DE CARGA -->
            <div id="loading" class="w-screen h-screen absolute z-50 bg-black">
                <div class="flex justify-center w-full h-full ">
                    <div class="flex flex-col items-center justify-center animate-pulse">
                        <h1 class="text-2xl font-bold text-[#ffff09]">
                            CARGANDO...
                        </h1>
                        <img src="../img/scope-yellow.svg" alt="" class="w-80 animate-spin">
                    </div>
                </div>
            </div>

            <!-- Contenedor del encabezado -->
            <div id="header-container"></div>

            <!-- Contenedor del inicio de sesión -->
            <div id="login-container"></div>

            <!-- Contenedor principal -->
            <div class="w-full h-screen m-0 p-0  overflow-y-auto bg-cover bg-scroll bg-bottom bg-no-repeat shadow-lg"
                style="background-image:url('../img/fondo2.jpg');">
                <div class="w-full h-auto backdrop-blur-sm bg-cover  bg-no-repeat flex flex-col items-center">

                    <!-- Sección destacada -->
                    <section class="">
                        <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                            <!-- Contenido principal -->
                            <div class="mr-auto place-self-center lg:col-span-7">
                                <!-- Título -->
                                <h1
                                    class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl xl:text-6xl dark:text-white">
                                    Conoce las últimas noticias de tu equipo</h1>
                                <!-- Descripción -->
                                <p
                                    class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                                    Entra al apartado de noticias y descubre las últimas novedades de tu equipo favorito.</p>
                                <!-- Botón de ver más -->
                                <a href="noticias.php"
                                    class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                                    Ver más
                                    <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <!-- Botón de inicio de sesión -->
                                <a href="noticias.php"
                                    class="inline-flex bg-[#ffff09] items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-900 rounded-lg hover:bg-red-600">
                                    Noticias
                                </a>
                            </div>
                            <!-- Imagen de fondo -->
                            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                                <img src="../img/imagen1.jpg" alt="mockup"
                                    class="rounded-2xl border-2 rounded-lg border-sky-200 shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0]">
                            </div>
                        </div>
                    </section>

                    <!-- Contenido principal -->
                    <main class="w-full h-auto m-0 p-0   bg-cover bg-scroll bg-bottom bg-no-repeat shadow-lg"
                        style="background-image:url('../img/fondo2.jpg');">
                        <div class="w-full h-auto backdrop-blur-sm bg-cover  bg-no-repeat flex flex-col items-center">

                            <!-- Selección de temporada -->
                            <div class="w-full mt-16 md:w-10/12 flex flex-col justify-left md:flex-row md:justify-between mb-6">
                                <h1
                                    class="mb-4 text-4xl font-extrabold leading-none tracking-tight ml-2 text-white md:text-5xl lg:text-6xl ">
                                    Temporada <span
                                        class="underline underline-offset-3 decoration-8 decoration-[#ffff09]"><?php echo $temporadaNum ?></span>
                                </h1>
                                <div class="w-auto flex justify-start md:flex-col md:justify-center ">
                                    <!-- Formulario de selección de equipo -->
                                    <form id="temporadasformulario" method="POST" action="club.php">
                                        <input type="text" hidden name="clubID" value="<?php echo $clubID; ?>">
                                        <!-- Selector de temporada -->
                                        <select id="temporada" name="temporadaNum"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 mr-2"
                                            onchange="this.form.submit()">
                                            <?php
                                            foreach ($listaTemporadas as $temporada) {
                                                $selected = ($temporada->Numero == $temporadaNum) ? 'selected' : '';
                                                echo "<option value='$temporada->Numero' $selected>" . "Temporada " . "$temporada->Numero</option>";
                                            }
                                            ?>
                                        </select>
                                    </form>
                                    <form id="equiposFormulario" method="POST" action="club.php">
                                        <input type="hidden" name="temporadaNum" value="<?php echo $temporadaNum; ?>">
                                        <select id="equipo" name="clubID"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                                            onchange="this.form.submit()">
                                            <?php
                                            // Obtener la temporada seleccionada
                                            $temporadaSeleccionada = isset($_POST['temporadaNum']) ? $_POST['temporadaNum'] : $temporadaNum;
                                            // Encontrar la temporada seleccionada en el XML
                                            $temporadaSeleccionadaXML = $xml->xpath("//Temporada[Numero='$temporadaSeleccionada']");
                                            // Verificar si se encontró la temporada
                                            if (!empty($temporadaSeleccionadaXML)) {
                                                // Iterar sobre los equipos de la temporada seleccionada
                                                foreach ($temporadaSeleccionadaXML[0]->Equipos->Equipo as $equipo) {
                                                    // Verificar si este equipo es el seleccionado
                                                    $selected = ($equipo->Nombre == $clubID) ? 'selected' : '';
                                                    echo "<option value='$equipo->Nombre' $selected>" . $equipo->Nombre . "</option>";
                                                }
                                            } else {
                                                // Mostrar un mensaje de error si no se encontró la temporada seleccionada
                                                echo "<option value=''>No hay equipos disponibles</option>";
                                            }
                                            ?>
                                        </select>
                                    </form>
                                </div>
                            </div>

                            <!-- Sección de información del club -->
                            <section
                                class="w-full h-auto flex flex-col items-center bg-[url('../img/estadio.jpg')] bg-cover bg-no-repeat bg-local  bg-opacity-10 md:w-10/12 overflow-hidden">
                                <div class="w-full h-auto sm:h-auto bg-[#ffff09]  flex flex-nowrap flex-col sm:flex-row">
                                    <img src="../img/scope.svg" alt="" class="hidden w-8 md:block">
                                    <div class="w-full md:w-3/4 h-full ml-1">
                                        <!-- Nombre del club -->
                                        <h1 class="text-3xl font-extrabold"><?php echo $club->Nombre; ?></h1>
                                    </div>
                                </div>

                                <!-- Descripción del club -->
                                <div class="bg-black w-full h-auto flex flex-col flex-wrap pl-5 pt-5 justify-between">
                                    <div class="flex flex-row flex-wrap pl-5 pt-5 justify-between w-full">
                                        <!-- Escudo del club -->
                                        <img src="../xmlxsl/<?php echo $club->Escudo; ?>" alt="" class="w-20">
                                        <!-- Título de la descripción -->
                                        <h1 class="text-[#ffff09] text-2xl pt-5 pr-5 font-bold">Descripción del Equipo</h1>
                                    </div>
                                    <!-- Contenido de la descripción -->
                                    <div class="text-white mt-5 mb-2">
                                        <p><?php echo $club->Descripcion; ?></p>
                                    </div>
                                    <!-- Información del entrenador -->
                                    <div
                                        class="text-center overflow-x-auto border-sky-200 shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0] mb-5">
                                        <p class="text-[#ffff09] font-bold">
                                            Entrenador: <?php echo $club->Entrenador->Nombre; ?>
                                            <?php echo $club->Entrenador->Apellido; ?>
                                            Nacionalidad: <?php echo $club->Entrenador->Nacionalidad; ?>
                                        </p>
                                    </div>
                                </div>
                            </section>

                            <!-- Sección de jugadores -->
                            <section class="w-full md:w-10/12 mt-16">
                                <!-- Tabla de jugadores -->
                                <div
                                    class="relative overflow-x-auto border-sky-200 shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0] mb-5">
                                    <table class="w-full text-sm text-left rtl:text-right text-white">
                                        <thead class="text-xs text-black uppercase bg-[#ffff09]">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Foto
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Nombre
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Apellido
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Nacionalidad
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Posición
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Ciclo para mostrar jugadores -->
                                            <?php
                                            foreach ($club[0]->Jugadores->Jugador as $jugador) {
                                                ?>
                                                <tr class="bg-black border-b border-gray-800">
                                                    <td class="px-6 py-4 ">
                                                        <!-- Foto del jugador -->
                                                        <img src="../XmlXsl/<?php echo $jugador->Foto ?>" alt="" class="w-20">
                                                    </td>
                                                    <!-- Nombre del jugador -->
                                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                                                        <?php echo $jugador->Nombre; ?>
                                                    </th>
                                                    <!-- Apellido del jugador -->
                                                    <td class="px-6 py-4">
                                                        <?php echo $jugador->Apellido; ?>
                                                    </td>
                                                    <!-- Nacionalidad del jugador -->
                                                    <td class="px-6 py-4">
                                                        <?php echo $jugador->Nacionalidad; ?>
                                                    </td>
                                                    <!-- Posición del jugador -->
                                                    <td class="px-6 py-4">
                                                        <?php echo $jugador->Rol; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </div>
                        <!-- Contenedor del pie de página -->
                        <div id="footer-container"></div>
                    </main>
                    <!-- Scripts -->
                    <script src="../js/headerfooterpages.js"></script>
                </div>
            </div>
        </body>

        </html>
        <?php
    } else {
        // Return an error message if the club does not exist
        exit('Club not found');
    }
} else {
    // Return an error message if the XML file does not exist
    exit('XML file not found');
}
?>