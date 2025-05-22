<?php

if ($_SESSION["rol"] != "admin") {
    header("Location: ?pid=" . base64_encode("presentacion/Autenticar.php"));
}


$id = $_SESSION["id"];
$admin = new Admin($id);
$admin->consultar();



?>

Admin: <?php echo $admin->getNombre() . " " . $admin->getApellido() ?>

<div class="card-header mt-4">
    <h4>Admins</h4>
</div>

<div class="card-body">
    <?php
    $admin = new Admin();
    $admins = $admin->consultar2();
    echo "<table class='table table-striped table-hover'>";
    echo "<tr><td>Id</td><td>Nombre</td><td>Apellido</td></tr>";
    foreach ($admins as $ad) {
        echo "<tr>";
        echo "<td>" . $ad->getId() . "</td>";
        echo "<td>" . $ad->getNombre() . "</td>";
        echo "<td>" . $ad->getApellido() . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
</div>