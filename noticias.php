<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles_popup.css"/>
    <link rel="stylesheet" href="css/styles.css"></link>
    <link rel="icon" href="img/logo.png" type="image/x-icon"/>
    <title>Noticias</title>
</head>
<body class="w-screen h-full m-0 p-0 md:flex md:flex-row">
    <!--ANIMACIÓN DE CARGA-->
    <div id="loading" class="w-screen h-screen absolute z-50 bg-black">
        <div class="flex justify-center w-full h-full ">
            <div class="flex flex-col items-center justify-center animate-pulse">
                <h1 class="text-2xl font-bold text-[#ffff09]">
                    CARGANDO...
                </h1>
                <img src="img/scope-yellow.svg" alt="" class="w-80 animate-spin"></img>
            </div>
        </div>
    </div>

    <div id="header-container"></div>

    <main class="w-full h-screen m-0 p-0 bg-red-400 bg-[url('img/fondo2.jpg')] bg-cover bg-no-repeat bg-local overflow-y-scroll flex items-center flex-col">
        <section class="">
            <!-- Sección banner -->
        </section>
        <section class="w-full h-full flex flex-col items-center bg-[url('img/trophie.jpg')] bg-cover bg-no-repeat bg-local bg-opacity-10 md:w-10/12 overflow-hidden border-sky-200 shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0]">
            <!-- Contenido de la sección de noticias -->
            <div class="w-full h-auto sm:h-auto bg-[#ffff09] flex flex-nowrap flex-col sm:flex-row">
                <img src="img/scope.svg" alt="" class="hidden w-8 md:block"/>
                <div class="w-full md:w-3/4 h-full ml-1">
                    <h1 class="text-3xl font-extrabold">Noticias</h1>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 mt-4 px-4">
            <?php
// Cargar el archivo XML
$xml = simplexml_load_file('noticias.xml');

// Comprobar si se cargó correctamente el archivo
if ($xml) {
    // Iniciar el contenido del div para las noticias
    $noticiasHTML = '<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 mt-4 px-4">';

    // Recorrer cada noticia en el XML
    foreach ($xml->noticia as $noticia) {
        // Obtener los datos de la noticia
        $titulo = $noticia->titulo;
        $descripcion = $noticia->descripcion;
        $imagen = $noticia->imagen;

        // Generar el HTML para la noticia actual
        $noticiasHTML .= '
            <div class="bg-white rounded-lg shadow-md p-4">
                <img src="' . $imagen . '" alt="' . $titulo . '" class="w-full h-40 object-cover rounded-lg mb-4"/>
                <h2 class="text-xl font-bold mb-2">' . $titulo . '</h2>
                <p class="text-gray-700">' . $descripcion . '</p>
                <div class="flex items-center mt-2 justify-between">
                    <a href="#" class="text-[#1d1d1b] font-semibold mr-4 inline-block hover:underline" onclick="abrirPopup(\'' . $imagen . '\', \'' . $titulo . '\', \'' . $descripcion . '\')">Leer más</a>
                </div>
            </div>';
    }

    // Cerrar el div de las noticias
    $noticiasHTML .= '</div>';
} else {
    // Si hay un error al cargar el archivo XML
    $noticiasHTML = '<div class="text-red-500">Error al cargar las noticias.</div>';
}

// Imprimir el HTML de las noticias
echo $noticiasHTML;
?>

            </div>
        </section>

        <?php
        if ($_SESSION['privilegiado'] === "true") {
            // Si el usuario tiene privilegios, mostrar el botón de añadir noticia
            echo '<button id="openAddNoticiaModal" class="fixed bottom-10 right-10 bg-[#ffff09] text-gray-900 px-4 py-2 rounded-full shadow-md focus:outline-none hover:border-sky-200 hover:shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0]">+ Añadir Noticia</button>';
        }
        ?>
        <!-- Modal para añadir noticia -->
        <!-- En este espacio se insertará el código del modal -->
    </main>
    <script src="js/loading.js"></script>
    <script src="js/modalnoti.js"></script>
    <script src="js/popupnoti.js"></script>
</body>
</html>
