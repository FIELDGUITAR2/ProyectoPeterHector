    <?php
    session_start();

    require("logica/Admin.php");

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
    /*"presentacion/inicio.php",
    "presentacion/autenticar.php",
    "presentacion/noAutorizado.php",*/

);

$paginas_con_autenticacion = array(
    /*"presentacion/sesionAdmin.php",
    "presentacion/sesionMedico.php",
    "presentacion/sesionPaciente.php",
    "presentacion/cita/consultarCita.php",
    "presentacion/cita/crearCita.php"*/
    
);


if(!isset($_GET["pid"])){
    include ("presentacion/inicio.php");
}else{

    $pid = base64_decode($_GET["pid"]);
    if(in_array($pid, $paginas_sin_autenticacion)){
        include $pid;
    }else if(in_array($pid, $paginas_con_autenticacion)){
        if(!isset($_SESSION["id"])){
            include "presentacion/autenticar.php";
        }else{
            include $pid;
        }
    }else{
        echo "error 404";
    }
}

    
?>
</>
    
