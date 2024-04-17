<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>
    <xsl:variable name="index" select="position()"/>
    <!-- Plantilla para el documento HTML -->
    <xsl:template match="/">
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
                            <!-- Aquí se generarán las noticias -->
                            <xsl:apply-templates select="noticias/noticia"/>
                        </div>
                    </section>
                    <!-- Modal para añadir noticia -->
                    <div id="modalAddNoticia" class="fixed inset-0 z-50 hidden overflow-y-auto">
                        <div class="flex items-center justify-center min-h-screen">
                            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
                            <!-- Contenido del modal -->
                            <div class="bg-[#1d1d1b] bg-opacity-90 rounded-lg p-8 max-w-sm mx-auto z-50">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-2xl font-bold text-[#ffff09]">Añadir Noticia</h2>
                                    <button id="closeAddNoticiaModal" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <!-- Formulario de añadir noticia -->
                                <form id="addNoticiaForm" action="guardar_noticia.php" method="post" enctype="multipart/form-data">
                                    <div class="mb-4">
                                        <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                                        <input type="text" name="titulo" id="titulo" required="required" class="mt-1 focus:ring-[#ffff09] focus:border-[#ffff09] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                    </div>
                                    <div class="mb-4">
                                        <label for="contenido" class="block text-sm font-medium text-gray-700">Contenido</label>
                                        <textarea name="contenido" id="contenido" required="required" class="mt-1 focus:ring-[#ffff09] focus:border-[#ffff09] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen</label>
                                        <input type="file" name="imagen" id="imagen" accept="image/*" required="required" class="mt-1 focus:ring-[#ffff09] focus:border-[#ffff09] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                        <p class="text-xs text-gray-500 mt-1">Seleccione una imagen para cargar.</p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-gray-900 bg-[#ffff09] hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ffff09] hover:border-sky-200 hover:shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0]">
                                                Añadir Noticia
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
                <script src="js/loading.js"></script>
                <script src="js/header.js"></script>
                <script src="js/modalnoti.js"></script>
                <script src="js/popupnoti.js"></script>
            </body>
        </html>
    </xsl:template>

    <!-- Plantilla para cada noticia -->
    <xsl:template match="noticia">
        <!-- Estructura HTML para mostrar una noticia -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <img src="{imagen}" alt="{titulo}" class="w-full h-40 object-cover rounded-lg mb-4"/>
            <h2 class="text-xl font-bold mb-2">
                <xsl:value-of select="titulo"/>
            </h2>
            <p class="text-gray-700">
                <xsl:value-of select="descripcion"/>
            </p>
            <div class="flex items-center mt-2 justify-between">
                <!-- Agregar evento de clic para abrir el popup -->
                <a href="#" class="text-[#1d1d1b] font-semibold mr-4 inline-block hover:underline" onclick="abrirPopup('{imagen}', '{titulo}', '{descripcion}')">Leer más</a>
            </div>
        </div>
    </xsl:template>


</xsl:stylesheet>
