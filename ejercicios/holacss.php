<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta PHP con CSS</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"])) {
        $nombre = $_POST["nombre"];
        echo "<h2>Hola, $nombre!</h2>";
    } else {
        echo "<h2>No se recibieron datos válidos</h2>";
    }
    ?>
</body>
</html>
