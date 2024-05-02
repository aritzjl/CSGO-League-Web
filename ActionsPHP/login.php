<?php
session_start();

// Definir una variable para almacenar el mensaje de error
$error = "";

// Verificar si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cargar el archivo XML
    $xml = new DOMDocument();
    $xml->load('../xmlxsl/csleague.xml');

    // Obtener todos los elementos 'usuario'
    $usuarios = $xml->getElementsByTagName('usuario');

    // Variable para verificar si las credenciales son válidas
    $credenciales_validas = false;

    // Iterar sobre cada usuario y verificar las credenciales
    foreach ($usuarios as $usuario) {
        $nombre = $usuario->getElementsByTagName('nombre')->item(0)->nodeValue;
        $pass = $usuario->getElementsByTagName('password')->item(0)->nodeValue;
        $privilegiado = $usuario->getElementsByTagName('privilegiado')->item(0)->nodeValue;
        if ($nombre == $username && $pass == $password) {
            // Credenciales válidas, iniciar sesión y redirigir
            $_SESSION['username'] = $username;
            $_SESSION['privilegiado'] = $privilegiado;
            $credenciales_validas = true;
            break; // Salir del bucle una vez que se encuentren las credenciales válidas
        }
    }

    // Verificar si las credenciales son válidas
    if ($credenciales_validas) {
        // Redirigir al usuario a la página anterior
        $previous_page = $_SERVER['HTTP_REFERER'];
        header("Location: $previous_page");
        exit(); // Salir del script después de la redirección
    } else {
        // Si las credenciales son incorrectas, almacenar el mensaje de error
        $error = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
        // Redirigir al usuario de vuelta a la página de inicio de sesión
        header("Location: ../index.php");
        exit(); // Salir del script después de la redirección
    }
}
?>
