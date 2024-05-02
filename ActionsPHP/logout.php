<?php
session_start();

// Cerrar la sesión y eliminar las variables de sesión
session_destroy();

// Redirigir al usuario a index.php
header("Location: ../index.php");
exit;