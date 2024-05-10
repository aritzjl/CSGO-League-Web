<?php
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
} else {
    $username = "Undefined";
}
if (!isset($_SESSION['privilegiado'])) {
    $_SESSION['privilegiado'] = "false";
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../js/styles_popup.css" />
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="icon" href="../img/logo.png" type="image/x-icon" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <img src="../img/scope-yellow.svg" alt="" class="w-80 animate-spin" />
            </div>
        </div>
    </div>

    <div id="header-container"></div>
    <div id="login-container"></div>

    <main class="w-full h-screen m-0 p-0 bg-red-400 bg-[url('../img/fondo2.jpg')] bg-cover bg-no-repeat bg-local overflow-y-scroll flex items-center flex-col">
        <section class="mt-16">
            <!-- Sección banner -->
        </section>
        <div id="popup" class="popup hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-75 z-50">
            <div class="popup-inner bg-[rgba(29, 29, 27, 0.9);] rounded-lg shadow-md p-6 max-w-md">
                <div class="noticia">
                    <!-- Contenido de la noticia -->
                </div>
                <h1 class="text-xl text-[#ffff09] font-bold mb-2"></h1>
                <div id="popup-comentarios" class="comentarios"></div>
                <!-- Formulario de comentarios -->
                <form id="commentForm" class="comment-form flex flex-col" onsubmit="enviarComentario(event)">
                    <input type="hidden" id="noticiaId" name="noticiaId" value="" />
                    <input type="hidden" id="commentUsername" name="commentUsername" value="<?php echo htmlspecialchars($username); ?>" />
                    <?php
                    // Verificar si el usuario está logueado
                    if ($username === "Undefined") {
                        // Si el usuario no está logueado, muestra un campo de texto para el nombre
                        echo '<div class="mb-4"><label for="commentUsername" class="text-yellow-500">Nombre:</label><input type="text" id="commentUsername" name="commentUsername" class="px-4 py-2 border border-gray-300 rounded-md mt-1 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500" placeholder="Nombre"></div>';
                    }
                    // Mostrar el área de comentario para todos los usuarios
                    ?>
                    <!-- Comentario -->
                    <div class="mb-4">
                        <label for="commentContent" class="text-yellow-500">Comentario:</label>
                        <textarea id="commentContent" name="commentContent" class="px-4 py-2 border border-gray-300 rounded-md mt-1 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500" rows="4" placeholder="Escribe tu comentario aquí"></textarea>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between">
                        <input type="submit" value="Enviar" class="bg-yellow-500 text-gray-900 px-4 py-2 rounded-md hover:bg-yellow-400 transition-colors" />
                        <button type="button" class="bg-red-500 text-gray-900 px-4 py-2 rounded-md hover:bg-red-400 transition-colors focus:outline-none" onclick="cerrarPopup()">Salir</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="w-full h-auto sm:h-auto bg-[#ffff09] flex flex-nowrap flex-col sm:flex-row md:w-10/12 border-sky-200 shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0]">
                <img src="../img/scope.svg" alt="" class="hidden w-8 md:block" />
                <div class="w-full md:w-3/4 h-full ml-1">
                    <h1 class="text-3xl font-extrabold">Noticias</h1>
                </div>
            </div>
        <section class="w-full h-full flex flex-col items-center bg-[url('../img/trophie.jpg')] bg-cover bg-no-repeat bg-local bg-opacity-10 md:w-10/12 overflow-hidden overflow-y-auto border-sky-200 shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0] scroll-bonito mb-16">
            <?php
            // Cargar el archivo XML
            $xml = simplexml_load_file('../xmlxsl/noticias.xml');

            // Comprobar si se cargó correctamente el archivo
            if ($xml) {
                // Iniciar el contenido del div para las noticias
                $noticiasHTML = '<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 mt-4 px-4 text-wrap">';

                // Recorrer cada noticia en el XML
                foreach ($xml->noticia as $noticia) {
                    // Obtener el ID de la noticia
                    $id = (string)$noticia['id'];

                    // Obtener los datos de la noticia
                    $titulo = $noticia->titulo;
                    $descripcion = $noticia->descripcion;
                    $imagen = $noticia->imagen;

                    // Generar el HTML para la noticia actual
                    $noticiasHTML .= '
                        <div class="bg-white rounded-lg shadow-md p-4 text-wrap overflow-hidden">
                            <img src="' . $imagen . '" alt="' . $titulo . '" class="w-full h-40 object-cover rounded-lg mb-4"/>
                            <h2 class="text-xl font-bold mb-2 text-wrap">' . $titulo . '</h2>
                            <p class="text-gray-700 text-wrap">' . $descripcion . '</p>
                            <div class="flex items-center mt-2 justify-between">
                                <a href="#" class="text-[#1d1d1b] font-semibold mr-4 inline-block hover:underline" onclick="abrirPopup(\'' . $imagen . '\', \'' . $titulo . '\', \'' . $descripcion . '\',\'' . $id . '\')">Leer más</a>
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
        <div id="footer-container"></div>
        <!-- Modal para añadir noticia -->
        <div id="modalAddNoticia" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
                <!-- Contenido del modal -->
                <div class="bg-[#1d1d1b] bg-opacity-90 rounded-lg p-8 max-w-sm mx-auto z-50">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-[#ffff09]">Añadir Noticia</h2>
                        <button id="closeAddNoticiaModal" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Formulario de añadir noticia -->
                    <form id="addNoticiaForm" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="titulo" class="block text-sm font-medium text-[#ffff09]">Título</label>
                            <input type="text" name="titulo" id="titulo" class="mt-1 focus:ring-[#ffff09] focus:border-[#ffff09] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <div class="mb-4">
                            <label for="contenido" class="block text-sm font-medium text-[#ffff09]">Contenido</label>
                            <textarea name="contenido" id="contenido" class="mt-1 focus:ring-[#ffff09] focus:border-[#ffff09] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="imagen" class="block text-sm font-medium text-[#ffff09]">Imagen</label>
                            <input type="file" name="imagen" id="imagen" accept="image/*" required="required" class="mt-1 focus:ring-[#ffff09] focus:border-[#ffff09] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-amarillo-flojo" />
                            <p class="text-xs text-[#ffff09] mt-1">Seleccione una imagen para cargar.</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <a id="PublicarNoticiaButton" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-gray-900 bg-[#ffff09] hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ffff09] hover:border-sky-200 hover:shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0]">
                                    Añadir Noticia
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Enlace para añadir noticia -->
        <?php
        if ($_SESSION['privilegiado'] === "true") {
            // Si el usuario tiene privilegios, mostrar el botón de añadir noticia
            echo '<button id="openAddNoticiaModal" class="fixed bottom-10 right-10 bg-[#ffff09] text-gray-900 px-4 py-2 rounded-full shadow-md focus:outline-none hover:border-sky-200 hover:shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0]">+ Añadir Noticia</button>';
        }
        ?>
    </main>
    <script src="../js/headerfooterpages.js"></script>
    <script src="../js/modalnoti.js"></script>
    <script src="../js/popupnoti.js"></script>
    <script src='../js/validaciones.js'></script>
</body>

</html>