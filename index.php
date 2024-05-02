<?php
// Ruta del archivo XML que contiene la información de la liga
$xmlPath = "./XmlXsl/csleague.xml";

// Verificar si el archivo XML existe
if (file_exists($xmlPath)) {
    // Cargar el archivo XML
    $xml = simplexml_load_file($xmlPath);
    $temporadaNum = "0";

    // Obtener la temporada activa si existe
    $temporadaActiva = $xml->xpath("//Temporada[Estado='ACTIVA']");

    // Si hay una temporada activa, obtener su número
    if ($temporadaActiva) {
        $temporadaNum = $temporadaActiva[0]->Numero;
    } else {
        // Si no hay una temporada activa, buscar la última temporada finalizada
        $temporadaActiva = $xml->xpath("//Temporada[Estado='FINALIZADA']");
        if ($temporadaActiva) {
            // Obtener el número de la última temporada finalizada
            $lastIndex = count($temporadaActiva) - 1;
            $temporadaNum = $temporadaActiva[$lastIndex]->Numero;
        } else {
            // Si no hay temporadas finalizadas, buscar la próxima temporada
            $temporadaActiva = $xml->xpath("//Temporada[Estado='PROXIMAMENTE']");
            if ($temporadaActiva) {
                // Obtener el número de la próxima temporada
                $temporadaNum = $temporadaActiva[0]->Numero;
            } else {
                // Si no hay temporadas disponibles, salir del script
                exit('No hay temporadas disponibles');
            }
        }
    }

    // Obtener los equipos asociados a la temporada activa
    $equiposTemporada = $xml->xpath("//Temporada[Numero='$temporadaNum']/Equipos/Equipo");
} else {
    // Si no se encuentra el archivo XML, mostrar un mensaje de error y salir del script
    exit('No se ha encontrado el archivo XML');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Configuración básica -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Enlaces a recursos externos -->
    <script src="https://cdn.tailwindcss.com"></script> <!-- CDN de Tailwind CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- CDN de jQuery -->
    <link rel="stylesheet" href="css/styles.css"> <!-- Hoja de estilos personalizada -->
    <link rel="icon" href="img/logo.png" type="image/x-icon"> <!-- Ícono de la pestaña del navegador -->
    <!-- Título de la página -->
    <title>Inicio</title>
</head>

<!--
    Colores:
    amarillo: #ffff09
    bg navbar: #1d1d1b
-->

<body class="w-screen h-full m-0 p-0 md:flex md:flex-row">
    <!-- Animación de carga -->
    <div id="loading" class="w-screen h-screen absolute z-50 bg-black">
        <!-- Contenido de la animación de carga -->
        <div class="flex justify-center w-full h-full ">
            <div class="flex flex-col items-center justify-center animate-pulse">
                <!-- Mensaje de carga -->
                <h1 class="text-lg sm:text-2xl font-bold text-[#ffff09]">
                    CARGANDO...
                </h1>
                <!-- Imagen de carga -->
                <img src="img/scope-yellow.svg" alt="" class="w-20 md:w-60 animate-spin">
            </div>
        </div>
    </div>

    <!-- Contenedores para el encabezado y el inicio de sesión -->
    <div id="header-container"></div>
    <div id="login-container"></div>

    <!-- Sección principal -->
    <div class="w-full h-screen m-0 p-0  overflow-y-auto bg-cover bg-scroll bg-bottom bg-no-repeat shadow-lg"
        style="background-image:url('img/fondo2.jpg');">
        <div class="w-full h-auto backdrop-blur-sm bg-cover  bg-no-repeat flex flex-col items-center">

            <!-- Contenido principal -->
            <section class="">
                <!-- Grid para organizar el contenido -->
                <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                    <!-- Columna para el texto principal -->
                    <div class="mr-auto place-self-center lg:col-span-7">
                        <!-- Título principal -->
                        <h1
                            class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl xl:text-6xl dark:text-white">
                            Conoce las últimas noticias de tu equipo</h1>
                        <!-- Texto de introducción -->
                        <p
                            class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                           Entra al apartado de noticias y descubre las últimas novedades de tu equipo favorito.</p>
                        <!-- Enlace para ver más información -->
                        <a href="pages/noticias.php"
                            class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                            Ver más
                            <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <!-- Enlace para ir a noticias -->
                        <a href="pages/noticias.php"
                            class="inline-flex bg-[#ffff09] items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-900 rounded-lg hover:bg-red-600">
                            Noticias
                        </a>
                    </div>
                    <!-- Columna para la imagen de ejemplo -->
                    <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                        <img src="img/imagen1.jpg" alt="mockup"
                            class="rounded-2xl border-2 rounded-lg border-sky-200 shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0]">
                    </div>
                </div>
            </section>

            <!-- Sección de los equipos de la temporada actual -->
            <section
                class="w-full h-auto flex flex-col items-center bg-[url('img/estadio.jpg')] bg-cover bg-no-repeat bg-local bg-opacity-10 md:w-10/12 overflow-hidden">
                <!-- Encabezado de la sección -->
                <div class="w-full h-auto sm:h-auto bg-[#ffff09] flex flex-nowrap flex-col sm:flex-row">
                    <!-- Imagen del icono -->
                    <img src="img/scope.svg" alt="" class="hidden w-8 md:block">
                    <!-- Título de la sección -->
                    <div class="w-full md:w-3/4 h-full ml-1">
                        <h1 class="text-3xl font-extrabold">EQUIPOS TEMPORADA ACTUAL</h1>
                    </div>
                </div>

                <!-- Carrusel de equipos -->
                <div class="flex flex-row backdrop-blur-lg">
                    <!-- Botón para navegar hacia atrás en el carrusel -->
                    <div class="">
                        <button type="button" id="carruselBefore"
                            class="relative top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                            data-carousel-prev>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#ffff09]/80 group-hover:bg-[#ffff09]/50">
                                <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="#000000" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 1 1 5l4 4" />
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                        </button>
                    </div>

                    <!-- Contenedor del carrusel -->
                    <div id="contenedorCarrusel" class="w-full h-48 mt-16 flex justify-center">
                        <div class="">
                            <!-- Imágenes de los escudos de los equipos (generadas dinámicamente con PHP) -->
                            <!-- Se muestra el primer equipo -->
                            <a href="javascript:void(0);"
                                onclick="submitForm('<?php echo $equiposTemporada[0]->Nombre; ?>')">
                                <img src="XmlXsl/<?php echo $equiposTemporada[0]->Escudo; ?>"
                                    alt="<?php echo $equiposTemporada[0]->Nombre; ?>" class="w-60">
                            </a>
                            <!-- Se muestran los demás equipos -->
                            <?php
                            foreach ($equiposTemporada as $index => $equipo) {
                                if ($index > 0) {
                                    ?>
                                    <a href="javascript:void(0);" onclick="submitForm('<?php echo $equipo->Nombre; ?>')"
                                        class="">
                                        <img src="XmlXsl/<?php echo $equipo->Escudo; ?>" alt="<?php echo $equipo->Nombre; ?>"
                                            class="w-60 hidden">
                                    </a>
                                    <?php
                                }
                            }
                            ?>

                        </div>
                    </div>

                    <!-- Botón para navegar hacia adelante en el carrusel -->
                    <div>
                        <button type="button" id="carruselNext"
                            class="relative top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                            data-carousel-next>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#ffff09]/80 group-hover:bg-[#ffff09]/50">
                                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span class="sr-only">Next</span>
                            </span>
                        </button>
                    </div>
                </div>
            </section>

            <!-- Iframe para mostrar contenido externo -->
            <iframe src="https://laurita19.github.io/cubitomalito/" width="800" height="400" frameborder="0" scrolling="no"></iframe>
        </div>

        <!-- Contenedor del pie de página -->
        <div id="footer-container"></div>

    </div>
    <!-- Formulario oculto para enviar datos a la página `pages/club.php` -->
    <form id="postForm" action="pages/club.php" method="post" style="display: none;">
        <input type="hidden" id="clubIDInput" name="clubID">
    </form>
    <!-- Script JavaScript para enviar datos del club -->
    <script>
        function submitForm(clubID) {
            document.getElementById('clubIDInput').value = clubID;
            document.getElementById('postForm').submit();
        }
    </script>
    <!-- Scripts adicionales para la funcionalidad de carga y el carrusel de equipos -->
    <script src="js/loading.js"></script>
    <script src="js/carruselEquipos.js"></script>
</body>

</html>