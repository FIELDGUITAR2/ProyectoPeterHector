    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    require_once("logica/Admin.php");
    require_once("logica/Propietario.php");
    require_once("logica/Apartamento.php");
    require_once("logica/Aria.php");
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>ViveLaVidaLoca</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- FontAwesome -->
        <link href="https://use.fontawesome.com/releases/v6.7.2/css/all.css"
            rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"></script>
    </head>
    <?php

    $paginas_sin_autenticacion = array(
        "presentacion/Autenticar.php",


    );

    $paginas_con_autenticacion = array(
        "presentacion/inicio.php",
        "presentacion/sesionAdmin.php",
        "presentacion/sesionPropietario.php"
    );


    if (!isset($_GET["pid"])) {
        include("presentacion/Autenticar.php");
    } else {

        $pid = base64_decode($_GET["pid"]);
        if (in_array($pid, $paginas_sin_autenticacion)) {

            include $pid;
        } else if (in_array($pid, $paginas_con_autenticacion)) {
            if (!isset($_SESSION["id"])) {
                include "presentacion/autenticar.php";
            } else {
                include $pid;
            }
        } else {
            echo "error 404";
        }
    }


    ?>
    </>