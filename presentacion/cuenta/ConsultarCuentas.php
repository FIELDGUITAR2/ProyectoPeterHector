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
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Listado de Cuentas</h4>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 150px;">
                    <?php
                    $cuenta = new Cuenta();
                    $cuenta->consultar();
                    $cuentas = $cuenta->getCuentasLista();

                    if (!empty($cuentas)) {
                        echo "<div class='table-responsive w-100'>";
                        echo "<table class='table table-bordered table-hover align-middle'>";
                        echo "<thead class='table-light'>";
                        echo "<tr>
                                <th>ID</th>
                                <th>Fecha Límite</th>
                                <th>Cantidad</th>
                                <th>Saldo Anterior</th>
                                <th>Administrador</th>
                                <th>Apartamento</th>
                                <th>Estado de Pago</th>
                              </tr>";
                        echo "</thead><tbody>";
                        foreach ($cuentas as $cute) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($cute->getId()) . "</td>";
                            echo "<td>" . htmlspecialchars($cute->getFechaLimite()) . "</td>";
                            echo "<td>$" . number_format($cute->getCantidad(), 2) . "</td>";
                            echo "<td>" . htmlspecialchars($cute->getSaldoAnterior()->getNombre()) . "</td>";
                            echo "<td>" . htmlspecialchars($cute->getIdAdmin()) . "</td>";
                            echo "<td>" . htmlspecialchars($cute->getIdApartamento()) . "</td>";
                            echo "<td>" . htmlspecialchars($cute->getIdEstadoPago()) . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody></table></div>";
                    } else {
                        echo "<div class='alert alert-info text-center w-100'>No hay Cuentas registradas.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
