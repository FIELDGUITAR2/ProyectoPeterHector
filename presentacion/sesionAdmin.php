<?php

if ($_SESSION["rol"] != "admin") {
    header("Location: ?pid=" . base64_encode("presentacion/Autenticar.php"));
}

?>


<body>
<?php 
include ("presentacion/Extremos/Cabeza.php");
include ("presentacion/menuAdmin.php");
include ("presentacion/inicio.php");
?>





</body>

