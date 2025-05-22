<?php
if ($_SESSION["rol"] != "propietario") {
    header("Location: ?pid=" . base64_encode("presentacion/Autenticar"));
}
$id = $_SESSION["id"];
$propietario = new Propietario($id);
$propietario->consultar();





?>
Propietario: <?php echo $propietario->getNombre() . " " . $propietario->getApellido() ?>

<div class="card-header mt-4">
    <h4>Propietarios</h4>
</div>
<div class="card-body">
    <?php
    $propietario = new Propietario();
    $propietarios = $propietario->consultar2();
    echo "<table class='table table-striped table-hover'>";
    echo "<tr><td>Id</td><td>Nombre</td><td>Apellido</td><td>Fecha</td></tr>";
    foreach ($propietarios as $pro) {
        echo "<tr>";
        echo "<td>" . $pro->getId() . "</td>";
        echo "<td>" . $pro->getNombre() . "</td>";
        echo "<td>" . $pro->getApellido() . "</td>";
        echo "<td>" . $pro->getFecha() . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
</div>