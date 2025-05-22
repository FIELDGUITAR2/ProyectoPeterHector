<?php

if ($_SESSION["rol"] != "admin") {
    header("Location: ?pid=" . base64_encode("presentacion/Autenticar"));
}


echo "hola admin";

?>
