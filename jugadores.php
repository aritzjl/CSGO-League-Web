<?php


session_start();

if(isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
} else {
    $username = "Undefined";
}
if (!isset($_SESSION['privilegiado'])) {
    $_SESSION['privilegiado'] = "false";
}

$listaTemporadas = "./XmlXsl/listaTemporadas.xml";

if (!file_exists($listaTemporadas)) {
    echo "El archivo XML no existe.";
    exit;
}

$xmlListaTemporadas = simplexml_load_file($listaTemporadas);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $temporada = $_POST['temporada'];
} else{
    $temporada = "1";
}

$xmlFilePath = "./XmlXsl/XML_temporada" . $temporada . "/temporada.xml";

//Inicializamos las variables predetermiandas
$nombre = "";
$apellido = "";
$nacionalidadFiltro = "";
$rol = "all";
$equipoFiltro = "all";

if (file_exists($xmlFilePath)) {
    $xml = simplexml_load_file($xmlFilePath);
    // Verificar el método de solicitud
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $nacionalidadFiltro = $_POST['nacionalidad'];
            $rol = $_POST['rol'];
            $equipoFiltro = $_POST['equipo'];
        
    } 

    


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

    <body class="w-screen h-full m-0 p-0 md:flex md:flex-row">

 <!--ANIMACIÓN DE CARGA-->
 <div id="loading" class="w-screen h-screen absolute z-50 bg-black">
        <div class="flex justify-center w-full h-full ">
            <div class="flex flex-col items-center justify-center animate-pulse">
                <h1 class="text-2xl font-bold text-[#ffff09]">
                    CARGANDO...
                </h1>
                <img src="./img/scope-yellow.svg" alt="" class="w-80 animate-spin"/>
            </div>
        </div>
    </div>

    <div id="header-container"></div>
    <div id="login-container"></div>

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



                <main class="w-full h-screen m-0 p-0  overflow-y-auto bg-cover bg-scroll bg-bottom bg-no-repeat shadow-lg" style="background-image:url('/img/fondo2.jpg');">
                    <div class="w-full h-auto backdrop-blur-md bg-cover  bg-no-repeat flex flex-col items-center">
                        <section class="w-full flex flex-row space-between">
                            <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                                <div class="mr-auto place-self-center lg:col-span-7">
                                    <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight text-white leading-none md:text-5xl xl:text-6xl">
                                        Encuentra a tu jugador favorito</h1>
                                    <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl">
                                        En esta sección, podrás buscar y filtrar a todos los jugadores de la historia de nuestra
                                        liga.</p>

                                </div>
                                <div class="hidden lg:mt-0 lg:col-span-5 lg:flex ml-2">
                                    <img src="/img/aleksib.avif" alt="mockup" class="">

                                </div>
                            </div>
                        </section>
                        <!--Sección de jugadores-->
                        <section class="w-full md:w-10/12 mt-16 mb-16">

                        <form action="/jugadores.php" method="POST" id="filtros"
                class="bg-[#1d1d1b] w-full h-auto rounded-t-xl border-[#ffff09] border-t-2 text-white py-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-2">
                <div>
                    <input type="search" id="default-search" name="nombre"
                        class="block w-full p-2 ps2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-[#ffff09] focus:border-[#ffff09]"
                        placeholder="Nombre" />
                </div>
                <div>
                    <input type="search" id="default-search" name="apellido"
                        class="block w-full p-2 ps2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-[#ffff09] focus:border-[#ffff09]"
                        placeholder="Apellido" />
                </div>
                <div>
                    <input type="search" id="default-search" name="nacionalidad"
                        class="block w-full p-2 ps2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-[#ffff09] focus:border-[#ffff09]"
                        placeholder="Nacionalidad" />
                </div>
                <div>
                    <select id="rol" name="rol"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#ffff09] focus:border-[#ffff09] block p-2.5">
                        <option selected value="all">Rol</option>
                        <option value="Leader">Leader</option>
                        <option value="Support">Support</option>
                        <option value="Lurker">Lurker</option>
                        <option value="Fragger">Fragger</option>
                        <option value="Awper">Awper</option>
                    </select>
                </div>
                <div>
                    <select id="temporada" name="temporada"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#ffff09] focus:border-[#ffff09] block p-2.5">
                        <?php foreach ($xmlListaTemporadas->Temporada as $temp) {
                            
                        ?>
                                <option value="<?php echo $temp->Numero; ?>">Temporada <?php echo $temp->Numero; ?></option>
                        <?php
                            }
                        
                        ?>
                    </select>
                </div>
                <div>
                    <select id="equipo" name="equipo"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#ffff09] focus:border-[#ffff09] block p-2.5">
                        <option selected value="all">Equipo</option>
                        <option value="Equipo1">Equipo1</option>
                        <option value="Equipo2">Equipo2</option>
                        <option value="Equipo3">Equipo3</option>
                    </select>
                </div>
                <a href="#"
                    class="col-span-full md:col-span-2 lg:col-span-1 inline-flex bg-[#ffff09] items-center justify-center px-5 py-2 text-base font-medium text-center text-gray-900 border border-gray-900 rounded-lg hover:border-sky-200 hover:shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0]">
                    <button>
                        Buscar
                    </button>
 
                </a>
            </form>

                            <div class="relative overflow-x-auto mb-5">

                                <table class="w-full text-sm text-left rtl:text-right text-white">

                                    <thead class="text-xs text-black uppercase bg-[#ffff09]">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Equipo
                                            </th>
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
                                        // Loop through each team
                                        foreach ($xml->Equipos->Equipo as $equipo) {
                                            //Filtrar por equipo
                                            if ($equipo->Nombre == $equipoFiltro || $equipoFiltro == "all") {
                                                // Loop through each player
                                                foreach ($equipo->Jugadores->Jugador as $player) {


                                                    if (($player->Rol == $rol || $rol == "all") && (strpos($player->Nombre, $nombre) !== false || $nombre == "") && (strpos($player->Apellido, $apellido) !== false || $apellido == "") && (strpos($player->Nacionalidad, $nacionalidadFiltro) !== false || $nacionalidadFiltro == "")) { //Solo mostrar si el rol coincide o si se selecciona "all"
                                        ?>
                                                        <tr class="bg-black border-b border-gray-800">
                                                            <td class="px-6 py-4">
                                                                <?php echo $equipo->Nombre; ?>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <img src="/XmlXsl/XML_temporada1/<?php echo $player->Foto; ?>" alt="Foto de jugador" class="w-20">
                                                            </td>

                                                            <td class="px-6 py-4 font-medium whitespace-nowrap">
                                                                <?php echo $player->Nombre; ?>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <?php echo $player->Apellido; ?>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <?php echo $player->Nacionalidad; ?>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <?php echo $player->Rol; ?>
                                                            </td>
                                                        </tr>
                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </main>
            </div>
        </div>

        <script src="/js/loading.js"></script>

    </body>

    </html>

<?php
} else {

echo "El archivo XML no existe.";
exit;
}
?>