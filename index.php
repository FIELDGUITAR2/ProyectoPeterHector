<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once("logica/Admin.php");
require_once("logica/Propietario.php");
require_once("logica/Apartamento.php");
require_once("logica/Aria.php");
require_once("logica/Cuenta.php");
require_once("logica/Pago.php");

    $paginas_sin_autenticacion = array(
        "presentacion/Autenticar.php",


    );

$paginas_con_autenticacion = array(
    "presentacion/inicio.php",
    "presentacion/sesionAdmin.php",
    "presentacion/sesionPropietario.php",
    "presentacion/cuenta/crearCuenta.php",
        "presentacion/usuario/editarUsuario.php",
    "presentacion/cuenta/ConsultarCuentas.php",
    "presentacion/cuentasPropietario/pagar_propietario.php",
    "presentacion/CuentasPropietario/consultarCuentas.php"
);

if (!isset($_GET["pid"])) {
    include("presentacion/Autenticar.php");
} else {
    $pid = base64_decode($_GET["pid"]);

    if (in_array($pid, $paginas_sin_autenticacion)) {
        include $pid;
    } else if (in_array($pid, $paginas_con_autenticacion)) {
        if (!isset($_SESSION["id"])) {
            include "presentacion/Autenticar.php";
        } else {
            include $pid;
        }
    } else {
        echo "Error 404";
    }
}
?>

</body>
</html>
