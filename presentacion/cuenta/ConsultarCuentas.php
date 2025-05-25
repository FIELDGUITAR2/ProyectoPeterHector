<?php
include("presentacion/Extremos/Cabeza.php");
include("presentacion/menu" . ucfirst($_SESSION["rol"]) . ".php");
?>

<?php

require_once("logica/Cuenta.php");
require_once("persistencia/CuentaDAO.php");

$rol = $_SESSION["rol"];
?>


<div class="container mt-4">
    <div class="row">
        <div class="col">
            <div class="card shadow-sm ">
                <div class="card-header ">
                    <h4 class="mb-0">Listado de Cuentas</h4>
                </div>
                   <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 150px;">
                    <?php
                        $cuenta = new Cuenta();
        				$cuenta -> consultarCuentas();
                        $cuentas = $cuenta->getCuentasLista();
        				echo "<table class='table table-striped table-hover'>";
        				echo "
                        <tr>
                        <td>ID_Cuenta</td>
                        <td>ID_Apartamento</td>
                        <td>Nombre_Apartamento</td>
                        <td>ID_Propietario</td>
                        <td>Nombre</td>
                        <td>Apellido</td>
                        <td>Telefono</td>
                        </tr>";
        				foreach($cuentas as $cute){
        				    echo "<tr>";
        				    echo "<td>" . $cute -> getId() . "</td>";
        				    echo "<td>" . $cute -> getIdApartamento() -> getId() . "</td>";
                            echo "<td>" . $cute -> getIdApartamento() -> getNombre() . "</td>";
        				    echo "<td>" . $cute -> getIdApartamento() -> getPropietario() -> getId() . "</td>";
        				    echo "<td>" . $cute -> getIdApartamento() -> getPropietario() -> getNombre() . "</td>";
                            echo "<td>" . $cute -> getIdApartamento() -> getPropietario() -> getApellido() . "</td>";
                            echo "<td>" . $cute -> getIdApartamento() -> getPropietario() -> getTelefono() . "</td>";
        				    echo "</tr>";
        				}
        				echo "</table>";
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
