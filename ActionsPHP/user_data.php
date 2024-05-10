<?php

// Verificar si el usuario tiene nombre

session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
} else {
    $username = "LOGIN";
}

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($username);