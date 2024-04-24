<?php
// Check if the clubID variable exists in the request query
if (isset($_POST['clubID'])) {
    // Retrieve the value of clubID from the request query
    $clubID = $_POST['clubID'];
    $temporadaNum = $_POST['temporadaNum'];


    $xmlPath = "../XmlXsl/csleague.xml";

    // Load the XML file if exists
    if (file_exists($xmlPath)) {
        $xml = simplexml_load_file($xmlPath);


        if ($temporadaNum == "") { // Si no se especifica la temproada, obtenemos la Activa, si no hay activa, obtenemos la última que ha finalizado, si tampoco hay, elegimos la próxima
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

        //Descartamos las temproadas en las que nuestro equipo NO participa

        $temporadasFiltradas = $xml->xpath("//Temporada[Equipos/Equipo/Nombre='$clubID']");

        $listaTemporadas = $temporadasFiltradas;
      
        if ($club) {


?>

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <script src="https://cdn.tailwindcss.com"></script> <!-- tailwindcss CDN -->
                <link rel="stylesheet" href="css/styles.css">
                <title>Club</title>
            </head>
            <!--
    Colores:
    amarillo: #ffff09
    bg navbar: #1d1d1b
-->

            <body class="w-full h-full m-0 p-0 bg-green-200 flex flex-col md:flex-row bg-url">
                <!--ANIMACIÓN DE CARGA-->
                <div id="loading" class="w-screen h-screen absolute z-50 bg-black">
                    <div class="flex justify-center w-full h-full ">
                        <div class="flex flex-col items-center justify-center animate-pulse">
                            <h1 class="text-2xl font-bold text-[#ffff09]">
                                CARGANDO...
                            </h1>
                            <img src="img/scope-yellow.svg" alt="" class="w-80 animate-spin">
                        </div>



                    </div>
                </div>
                <div id="header-container"></div>

                <!-- Modal de inicio de sesión -->
                <div id="modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen">
                        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>

                        <!-- Contenido del modal -->
                        <div class="bg-[#1d1d1b] bg-opacity-90 rounded-lg p-8 max-w-sm mx-auto z-50">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl font-bold text-[#ffff09]">Iniciar sesión</h2>
                                <button id="closeModal" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Formulario de inicio de sesión -->
                            <form id="loginForm" action="login.php" method="post">
                                <div class="mb-4">
                                    <label for="username" class="block text-sm font-medium text-gray-700">Usuario</label>
                                    <input type="name" name="username" id="username" required class="mt-1 focus:ring-[#ffff09] focus:border-[#ffff09] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                                    <input type="password" name="password" id="password" autocomplete="current-password" required class="mt-1 focus:ring-[#ffff09] focus:border-[#ffff09] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-gray-900 bg-[#ffff09] hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ffff09]">
                                            Iniciar sesión
                                        </button>
                                    </div>
                                </div>
                                <div class="text-sm">
                                    <a href="#" class="font-medium text-[#ffff09] hover:text-yellow-400" id="openRegistroModel" onclick="openRegistroModal()">
                                        ¿No estás registrado aún? Regístrate
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal de registro -->
                <div id="registroModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen">
                        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>

                        <!-- Contenido del modal -->
                        <div class="bg-[#1d1d1b] bg-opacity-90 rounded-lg p-8 max-w-md mx-auto z-50">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl font-bold text-[#ffff09]">Registro</h2>
                                <button id="closeRegistroModal" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Formulario de registro -->
                            <form id="registerForm" onsubmit="submitForm(event)" action="register.php" method="post">
                                <div class="mb-4">
                                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" required class="mt-1 focus:ring-[#ffff09] focus:border-[#ffff09] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                                    <input type="text" name="apellido" id="apellido" required class="mt-1 focus:ring-[#ffff09] focus:border-[#ffff09] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                                    <input type="email" name="email" id="email" required class="mt-1 focus:ring-[#ffff09] focus:border-[#ffff09] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                                    <input type="password" name="password" id="password" autocomplete="new-password" required class="mt-1 focus:ring-[#ffff09] focus:border-[#ffff09] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                                    <input type="password" name="confirmPassword" id="confirmPassword" autocomplete="new-password" required class="mt-1 focus:ring-[#ffff09] focus:border-[#ffff09] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-gray-900 bg-[#ffff09] hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ffff09]">
                                            Registrarse
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="w-full h-screen m-0 p-0  overflow-y-auto bg-cover bg-scroll bg-bottom bg-no-repeat shadow-lg" style="background-image:url('img/fondo2.jpg');">
                    <div class="w-full h-auto backdrop-blur-sm bg-cover  bg-no-repeat flex flex-col items-center">

                        <section class="">
                            <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                                <div class="mr-auto place-self-center lg:col-span-7">
                                    <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl xl:text-6xl dark:text-white">Sigue a tu equipo favorito</h1>
                                    <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">Mantente al tanto de todas las novedades de la CSL, consulta los resultados de los último partidos y conoce los últimos fichajes de tu equipo favorito.</p>
                                    <a href="#" class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                                        Ver más
                                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                    <a href="#" class="inline-flex bg-[#ffff09] items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-900 rounded-lg hover:bg-red-600">
                                        Inicia sesión
                                    </a>
                                </div>
                                <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                                    <img src="img/imagen1.jpg" alt="mockup" class="rounded-2xl border-2 rounded-lg border-sky-200 shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0]">
                                </div>
                            </div>
                        </section>

                        <main class="w-full h-auto m-0 p-0   bg-cover bg-scroll bg-bottom bg-no-repeat shadow-lg" style="background-image:url('/img/fondo2.jpg');">
                            <div class="w-full h-auto backdrop-blur-sm bg-cover  bg-no-repeat flex flex-col items-center">

                                <div class="w-full mt-16 md:w-10/12 flex flex-col justify-left md:flex-row md:justify-between mb-6">
                                    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight ml-2 text-white md:text-5xl lg:text-6xl ">
                                        Temporada <span class="underline underline-offset-3 decoration-8 decoration-[#ffff09]">2023-2024</span></h1>
                                    <div class="w-auto flex justify-start md:flex-col md:justify-center ">
                                        <form class="max-w-sm ml-2" id="temproadasFormulario" method="POST" action="club.php">
                                            <input type="text" hidden name="clubID" value="<?php echo $clubID; ?>">
                                            <select id="temporada" name="temporadaNum"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                                                <?php
                                                foreach ($listaTemporadas as $temporada) {
    
                                                    $selected = ($temporada->Numero == $temporadaNum) ? 'selected' : '';
                                                    echo "<option value='$temporada->Numero' $selected>" . "Temporada " . "$temporada->Numero</option>";
                                                }
                                                ?>

                                            </select>
                                    </div>
                                </div>



                                </form>

                                <!--Sección info del club-->
                                <section class="w-full h-full flex flex-col items-center bg-[url('/img/estadio.jpg')] bg-cover bg-no-repeat bg-local  bg-opacity-10 md:w-10/12 overflow-hidden">
                                    <div class="w-full h-auto sm:h-auto bg-[#ffff09]  flex flex-nowrap flex-col sm:flex-row">
                                        <img src="img/scope.svg" alt="" class="hidden w-8 md:block">
                                        <div class="w-full md:w-3/4 h-full ml-1">
                                            <h1 class="text-3xl font-extrabold"><?php echo $club->Nombre; ?></h1>

                                        </div>
                                    </div>

                                    <div class="bg-black w-full h-auto flex flex-col flex-wrap pl-5 pt-5 justify-between">
                                        <div class="flex flex-row flex-wrap pl-5 pt-5 justify-between w-full">
                                            <img src="img/logo.png" alt="" class="w-20">
                                            <h1 class="text-[#ffff09] text-2xl pt-5 pr-5 font-bold">Descripción del Equipo</h1>
                                        </div>
                                        <div class="text-white mt-5 mb-2">
                                            <p><?php echo $club->Descripcion; ?></p>
                                        </div>

                                    </div>

                                </section>

                                <!--Sección de jugadores-->
                                <section class="w-full md:w-10/12 mt-16">


                                    <div class="relative overflow-x-auto border-sky-200 shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0] mb-5">
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

                                                <?php
                                                foreach ($club[0]->Jugadores->Jugador as $jugador) {

                                                ?>
                                                    <tr class="bg-black border-b border-gray-800">
                                                        <td class="px-6 py-4 ">
                                                            <img src="XmlXsl/<?php echo $jugador->Foto ?>" alt="" class="w-20">
                                                        </td>
                                                        <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                                                            <?php echo $jugador->Nombre; ?>
                                                        </th>
                                                        <td class="px-6 py-4">
                                                            <?php echo $jugador->Apellido; ?>
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <?php echo $jugador->Nacionalidad; ?>
                                                        </td>
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
                        </main>

                        <script src="js/loading.js"></script>
                        <script src="js/carruselEquipos.js"></script>
                        <script>
                            document.getElementById('temporada').addEventListener('change', function() {
                                var temporadaSeleccionada = this.value;
                                // Llamar a la función con la temporada seleccionada como argumento
                                seleccionarTemporada(temporadaSeleccionada);
                            });

                            function seleccionarTemporada(temporada) {
                                // Aquí puedes realizar las acciones que desees con la temporada seleccionada
                                var formulario = document.getElementById('temproadasFormulario');
                                formulario.submit();

                            }

                        </script>

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
}
?>