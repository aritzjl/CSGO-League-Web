<?php
session_start();

// Función para generar el HTML del botón de inicio de sesión
function generateLoginButton() {
    if (isset($_SESSION["username"])) {
        // Usuario autenticado
        $username = $_SESSION["username"];
        echo '
        <div class="ml-5 mt-10 flex flex-row flex-wrap justify-left items-center">
            <img src="../img/user.svg" alt="" class="w-8 h-8">
            <p class="text-[#ffff09] font-semibold ml-2">' . $username . '</p>
        </div>
        <div id="logout" class="ml-5 mt-1 flex flex-row flex-wrap justify-left items-center">
            <a href="../ActionsPHP/logout.php" class="ml-2 flex flex-row flex-wrap justify-left items-center">
                <img src="../img/puerta.svg" alt="" class="w-8 h-8">
                <p class="m-1 text-[#ffff09] font-semibold">Cerrar Sesión</p>
            </a>
        </div>';
        
    } else {
        // Usuario no autenticado
        echo '
        <a href="#" id="openModal" class="ml-5 mt-10 flex flex-row flex-wrap justify-left ">
            <img src="../img/user.svg" alt="" class="w-8 h-8">
            <p class="m-1 text-[#ffff09] font-semibold">LOGIN</p>
        </a>';
    }
}
?>
<header class="w-full h-10 bg-[#1d1d1b] md:w-1/4 md:h-screen md:flex md:flex-col items-center">
    <!-- Contenedor principal -->
    <div class="w-full h-full md:h-1/5 flex flex-row justify-center pt-1 md:flex-col md:items-center md:p-5 md:mt-10">
        <!-- Enlace del logo -->
        <a href="../index.php">
            <img src="../img/logo.png" alt="" class="w-8 h-8 ml-5 md:h-16 md:w-16 md:m-none mr-6">
        </a>
        <!-- Título grande (visible en pantallas grandes) -->
        <h1 class="hidden text-4xl font-extrabold text-[#ffff09] text-center md:block">Counter Strike League</h1>
        <!-- Título pequeño (visible en pantallas pequeñas) -->
        <h1 class="text-xl font-extrabold text-[#ffff09] text-center md:hidden">CSL</h1>
        <!-- Línea divisoria (visible en pantallas grandes) -->
        <div class="hidden w-11/12 h-px bg-gray-600 mt-4 text-[#1d1d1b] md:block">-----------</div>
        <!-- Menú hamburguesa (visible en pantallas pequeñas) -->
        <div id="hamburger-container" class="w-full h-full flex justify-end md:hidden" data-selected="false">
            <div id="hamburger" class="w-8 mt-1">
                <div class="w-6 h-1 bg-[#ffff09] mb-1"></div>
                <div class="w-6 h-1 bg-[#ffff09] mb-1"></div>
                <div class="w-6 h-1 bg-[#ffff09] mb-1"></div>
            </div>
        </div>
    </div>
    <!-- Menú de navegación -->
    <nav id="nav" class="hidden z-50 h-full w-full absolute md:static bg-opacity-80 md:bg-opacity-100 bg-black md:w-11/12 md:h-full md:p-5 :mt-10 flex flex-col flex-wrap justify-center md:bg-[#1d1d1b] md:justify-start md:z-0 md:block">
        <ul class="ml-5 md:ml-none">
            <!-- Enlaces de navegación -->
            <a href="clasi.php">
                <li class="text-2xl text-white font-bold my-4">Temporadas</li>
            </a>
            <a href="noticias.php">
                <li class="text-2xl text-[#ffff09] font-bold my-4">Noticias</li>
            </a>
            <a href="jugadores.php">
                <li class="text-2xl text-[#ffff09] font-bold my-4">Jugadores</li>
            </a>
        </ul>
        <!-- Enlace de inicio de sesión -->
        <?php generateLoginButton(); ?>
        <!-- Enlace de cierre de sesión (oculto por defecto) -->
        <div id="logout" class="hidden">
            <a href="../ActionsPHP/logout.php" class="ml-5 mt-10 flex flex-row flex-wrap justify-left">
                <img src="../img/puerta.svg" alt="" class="w-8 h-8">
                <p class="m-1 text-[#ffff09] font-semibold">Cerrar Sesión</p>
            </a>
        </div>
    </nav>
    <!-- Separadores amarillos (visible solo en pantallas grandes) -->
    <div class="w-full flex flex-col hidden md:block">
        <div class="bg-[#ffff09] h-1"></div>
        <div class="bg-[#ffff09] h-2 mt-1"></div>
        <div class="bg-[#ffff09] h-6 mt-2"></div>
    </div>
</header>
