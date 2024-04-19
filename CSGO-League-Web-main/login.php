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
    $xml->load('usuarios.xml');

    // Obtener todos los elementos 'usuario'
    $usuarios = $xml->getElementsByTagName('usuario');

    // Iterar sobre cada usuario y verificar las credenciales
    foreach ($usuarios as $usuario) {
        $nombre = $usuario->getElementsByTagName('nombre')->item(0)->nodeValue;
        $pass = $usuario->getElementsByTagName('password')->item(0)->nodeValue;
        $privilegiado = $usuario->getElementsByTagName('privilegiado')->item(0)->nodeValue;
        if ($nombre == $username && $pass == $password) {
            // Iniciar sesión y redirigir al usuario
            $_SESSION['username'] = $username;
            $_SESSION['privilegiado'] = $privilegiado;
            // Recargar la página actual después de 2 segundos
            $previous_page = $_SERVER['HTTP_REFERER'];
            header("Location: $previous_page");
            exit(); // Salir del script después de la recarga de la página
        }
    }
    
    // Si las credenciales son incorrectas, almacenar el mensaje de error
    $error = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
}
?>

