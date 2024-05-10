<?php
// Inicia la sesión para mantener la información del usuario entre páginas
session_start();

// Verifica si se estableció el nombre de usuario en la sesión
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"]; // Asigna el nombre de usuario de la sesión
} else {
    $username = "Undefined"; // Si no hay nombre de usuario, se asigna "Undefined"
}

// Verifica si el usuario tiene el privilegio establecido en la sesión
if (!isset($_SESSION['privilegiado'])) {
    $_SESSION['privilegiado'] = "false"; // Si no está definido, se asigna "false"
}

// Verifica el método de solicitud (GET o POST) para establecer la temporada
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $temporada = $_POST['temporada']; // Obtiene la temporada seleccionada del formulario
} else {
    $temporada = "2"; // Si no es POST, se establece la temporada predeterminada en 2
}

// Ruta del archivo XML de la liga
$xmlFilePath = "../XmlXsl/csleague.xml";

// Inicializa las variables predeterminadas para filtros de búsqueda de jugadores
$nombre = "";
$apellido = "";
$nacionalidadFiltro = "";
$rol = "all";
$equipoFiltro = "all";

// Verifica si el archivo XML existe
if (file_exists($xmlFilePath)) {
    // Carga el archivo XML
    $xml = simplexml_load_file($xmlFilePath);

    // Verifica si la solicitud es de tipo POST para procesar datos del formulario de filtros
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtiene los valores de los filtros de búsqueda del formulario
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $nacionalidadFiltro = $_POST['nacionalidad'];
        $rol = $_POST['rol'];
        $equipoFiltro = $_POST['equipo'];
    }

    // Obtiene todas las temporadas del XML para mostrar en el select
    $temporadas = $xml->xpath("//Temporada/Numero");

    // Filtra el XML por la temporada seleccionada
    $xml = $xml->xpath("//Temporada[Numero=$temporada]")[0];
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script> <!-- tailwindcss CDN -->
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="icon" href="../img/logo.png" type="image/x-icon">
        <title>Jugadores</title>
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
                    <img src="../img/scope-yellow.svg" alt="" class="w-80 animate-spin" />
                </div>
            </div>
        </div>

        <div id="header-container"></div>
        <div id="login-container"></div>

        <div class="w-full h-screen m-0 p-0  overflow-y-auto bg-cover bg-scroll bg-bottom bg-no-repeat shadow-lg"
            style="background-image:url('../img/fondo2.jpg');">
            <div class="w-full h-auto backdrop-blur-sm bg-cover  bg-no-repeat flex flex-col items-center">
                <main class="w-full h-screen m-0 p-0  overflow-y-auto bg-cover bg-scroll bg-bottom bg-no-repeat shadow-lg"
                    style="background-image:url('../img/fondo2.jpg');">
                    <div class="w-full h-auto backdrop-blur-md bg-cover  bg-no-repeat flex flex-col items-center">
                        <section class="w-full flex flex-row space-between">
                            <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                                <div class="mr-auto place-self-center lg:col-span-7">
                                    <h1
                                        class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight text-white leading-none md:text-5xl xl:text-6xl">
                                        Encuentra a tu jugador favorito</h1>
                                    <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl">
                                        En esta sección, podrás buscar y filtrar a todos los jugadores de la historia de
                                        nuestra
                                        liga.</p>

                                </div>
                                <div class="hidden lg:mt-0 lg:col-span-5 lg:flex ml-2">
                                    <img src="../xmlxsl/jugadores/temporada2/Natus Vincere-44301433Y.png" alt="mockup"
                                        class="w-48">
                                </div>
                            </div>
                        </section>
                        <!--Sección de jugadores-->
                        <section class="w-full md:w-10/12 mt-16 mb-16">

                            <form action="" method="POST" id="filtros"
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
                                        <option value="IGL">IGL</option>
                                        <option value="Support">Support</option>
                                        <option value="Lurker">Lurker</option>
                                        <option value="Fragger">Fragger</option>
                                        <option value="Awper">Awper</option>
                                    </select>
                                </div>
                                <div>
                                    <select id="temporada" name="temporada"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#ffff09] focus:border-[#ffff09] block p-2.5">
                                        <?php foreach ($temporadas as $temp) {

                                            ?>
                                            <option value="<?php echo $temp; ?>">Temporada <?php echo $temp; ?></option>
                                            <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div>
                                    <?php
                                    // Obtener todas las temporadas del archivo XML
                                    $temporadas = $xml->xpath("//Temporada");

                                    // Crear un array para almacenar los nombres de los equipos sin duplicados
                                    $equipos_sin_duplicados = array();

                                    // Iterar sobre todas las temporadas
                                    foreach ($temporadas as $temporada) {
                                        // Obtener todos los equipos de la temporada actual
                                        $equipos_temporada = $temporada->Equipos->Equipo;

                                        // Iterar sobre los equipos de la temporada actual
                                        foreach ($equipos_temporada as $equipo) {
                                            // Obtener el nombre del equipo
                                            $nombre_equipo = (string) $equipo->Nombre;

                                            // Verificar si el nombre del equipo ya está en el array de equipos sin duplicados
                                            if (!in_array($nombre_equipo, $equipos_sin_duplicados)) {
                                                // Si no está en el array, agregarlo
                                                $equipos_sin_duplicados[] = $nombre_equipo;
                                            }
                                        }
                                    }

                                    // Ahora, $equipos_sin_duplicados contiene todos los nombres de los equipos sin duplicados
                                    ?>

                                    <select id="equipo" name="equipo"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#ffff09] focus:border-[#ffff09] block p-2.5">
                                        <option value="all">Equipo</option>
                                        <?php
                                        // Iterar sobre los nombres de los equipos sin duplicados
                                        foreach ($equipos_sin_duplicados as $equipo_nombre) {
                                            ?>
                                            <option value="<?php echo $equipo_nombre; ?>"><?php echo $equipo_nombre; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button
                                    class="col-span-full md:col-span-2 lg:col-span-1 inline-flex bg-[#ffff09] items-center justify-center px-5 py-2 text-base font-medium text-center text-gray-900 border border-gray-900 rounded-lg hover:border-sky-200 hover:shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0]">
                                    Buscar
                                </button>
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
                                                                <img src="../xmlxsl/<?php echo $player->Foto; ?>" alt="Foto de jugador"
                                                                    class="w-20">
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
                    <div id="footer-container"></div>
                </main>
            </div>
        </div>
        <script src="../js/headerfooterpages.js"></script>
    </body>

    </html>
    <?php
} else {

    echo "El archivo XML no existe.";
    exit;
}
?>