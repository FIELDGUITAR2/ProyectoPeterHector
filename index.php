    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    require_once("logica/Admin.php");
    require_once("logica/Propietario.php");

    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>ViveLaVidaLoca</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <?php

    $paginas_sin_autenticacion = array(
        "presentacion/Autenticar.php"
    );

    $paginas_con_autenticacion = array(
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