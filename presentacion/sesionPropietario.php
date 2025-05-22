<?php
if ($_SESSION["rol"] != "propietario") {
    header("Location: ?pid=" . base64_encode("presentacion/Autenticar"));
}

echo "hola pro";

?>
